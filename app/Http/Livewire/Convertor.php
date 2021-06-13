<?php

namespace App\Http\Livewire;

use App\Models\Conversion;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use App\Services\Helper;
use App\Services\ConvertorService;
use App\Models\StorageFolder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Storage;
use Validator;
use Illuminate\Support\Facades\Http;

class Convertor extends Component
{
    use WithFileUploads;

    public $currentType;
    public $config;
    public $isFinished;
    public $converting = false;
    public $uploading = false;
    public $sortOrder = [];

    public $files = [];
    public $newfiles = [];
    public $storageFolder;

    public $types = [];

    public $recaptcha_response;

    public function mount()
    {
        $this->isFinished = false;
        $parts = explode('-', $this->currentType);
        $this->config = config('convertor.types.' . $parts[0]);

        $directoryName = Helper::uniqueName(); //create a storage folder record
        $storageFolder = new StorageFolder;
        $storageFolder->name = $directoryName;
        $storageFolder->save();
        $this->storageFolder = $storageFolder;
    }


    public function getListeners()
    {
        return [
            "echo:laravel_database_converts-{$this->storageFolder->id},ConvertStatusUpdateEcho" => 'refreshStatus',
        ];
    }


    public function refreshStatus($event)
    {
        $this->isFinished = true;
        $this->converting = false;
        $this->sortOrder = [];
        $this->files = [];
        $this->newfiles = [];
        $this->sendMessage('Converted Successfully!', 'success');
        $this->download();
    }


    public function updatedNewfiles()
    {
        Log::debug('Upload files', $this->newfiles);

        //reCaptcha проверка
        if (!session()->has('noRobot')) {
            $logId = random_int(10000000, 99999999);

            \Log::info('reCaptcha start', [
                'token' => $this->recaptcha_response,
                'log_id' => $logId,
            ]);

            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('convertor.captcha.secret_key'),
                'response' => $this->recaptcha_response,
            ]);

            $captchaResult = $response->json();

            \Log::info('reCaptcha response', [
                'token' => $captchaResult,
                'log_id' => $logId,
            ]);

            if ($this->recaptcha_response && $captchaResult['success'] !== true) {
                $messages = 'Captcha not valid';
                session()->forget('noRobot');
                $this->sendMessage($messages, 'error');
                $this->uploading = false;

                return;
            }

            session(['noRobot' => '1']);
        }

        //Валидация
        $totalFiles = count($this->files) + count($this->newfiles);

        $rules = [
            'required',
            'file',
            'max:' . config('app.max_file_size_limit'),
            function ($attribute, $value, $fail) {
                preg_match('|^convert/(\w+)-.*$|', request('fingerprint')['path'], $matches);
                $isUploadedFile = $value instanceof TemporaryUploadedFile;
                if ($isUploadedFile) {
                    /** @var TemporaryUploadedFile $value */
                    $extension = explode(',', str_replace('mimes:', '', config("convertor.types.$matches[1].rules")));
                    $isNotWordFile = !Str::endsWith($value->getFilename(), $extension);
                    if ($isNotWordFile) {
                        $fail(sprintf('The file must have extension: %s.', implode(', ', $extension)));
                    }
                }
            },
        ];

        $validator = Validator::make(
            [
                'newfiles' => $this->newfiles
            ],
            [
                'newfiles.*' => $rules
            ]
        );

        if ($validator->fails()) {
            $messages = '';

            foreach ($validator->errors()->all() as $message) {
                $messages .= '<p>' . $message . '</p>';
            }

            $this->sendMessage($messages, 'error');
            $this->uploading = false;

            $this->sortOrder = [];

            return;
        }


        if ($totalFiles > config('app.max_files_allowed')) {

            $this->sendMessage('Maximum file upload limit is less than: ' . config('app.max_files_allowed'), 'error');

            return;
        }

        foreach ($this->newfiles as $key => $file) {
            /** @var TemporaryUploadedFile $file */
            $this->sortOrder[] = $file->getFilename();
        }
        $this->files = array_merge($this->files, $this->newfiles);

        $this->uploading = false;
        // $this->sendMessage('Maximum file upload limit is less than: ' . config('app.max_files_allowed'), 'info');
    }


    public function render()
    {
        return view('livewire.convertor');
    }

    public function delete($uploadedFile)
    {
        $this->files = collect($this->files)->reject(function(TemporaryUploadedFile $file) use ($uploadedFile) {
            return $file->getFilename() === $uploadedFile;
        })->toArray();
        unset($this->sortOrder[array_search($uploadedFile, $this->sortOrder)]);
    }


    public function convert()
    {

        $this->converting = true;

        $folderName = 'uploaded/' . $this->storageFolder->name;

        $storageFolder = $this->storageFolder;

        $firstFileName = null;

        foreach ($this->sortOrder as $key => $uploadedFile) {

            $file = collect($this->files)->first(function(TemporaryUploadedFile $file) use ($uploadedFile) {
                return $file->getFilename() === $uploadedFile;
            });

            $fileOriginalName = $file->getClientOriginalName();

            $fileName = pathinfo($fileOriginalName, PATHINFO_FILENAME);

            if (strlen($fileName) == 0) $fileName = Str::random(7);

            $ext = pathinfo($fileOriginalName, PATHINFO_EXTENSION);

            $singleFileName = $key . '_' . Str::slug($fileName) . '.' . $ext;

            $fileFullName = $file->storePubliclyAs($folderName, $singleFileName);

            if (is_null($firstFileName)) {
                $firstFileName = $fileName;
            }

            $storageFolder->files()->create([
                'name' => $fileFullName,
                'filename' => $fileName
            ]);
        }

        $storageFolder->filename = $firstFileName;

        $storageFolder->save();

        $fromTo = explode('-to-', $this->currentType);

        $storageFolder->conversion()->create([
            'from_type' => $fromTo[0],
            'to_type' => $fromTo[1]
        ]);

        $result = StorageFolder::find($storageFolder->id);

        $method = Str::camel($this->currentType);

        $convertor = new ConvertorService($result);

        \call_user_func([$convertor, $method]);
    }


    public function download()
    {
        $filePath = $this->storageFolder->conversion->filename;
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);

        $this->storageFolder->conversion->downloaded_at = Carbon::now();
        $this->storageFolder->conversion->save();

        if (file_exists($filePath)) {
            $headers = [];
            $fileName = Str::slug($this->storageFolder->filename) . '.' . $ext;
            switch ($ext) {
                case 'pdf':
                    $headers = ['Content-Type: application/pdf', 'Content-Length: ' . filesize($filePath)];
                    break;
                case 'zip':
                    $headers = ['Content-Type: application/zip', 'Content-Length: ' . filesize($filePath)];
                    break;
            }
            return \Response::download($filePath, $fileName, $headers);
        } else {
            $this->sendMessage('File deleted from server', 'error');
        }
    }

    public function sendMessage($message, $type)
    {
        $this->emit('showAlert', ['type' => $type, 'title' => 'System', 'message' => $message]);
    }
}
