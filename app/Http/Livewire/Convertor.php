<?php

namespace App\Http\Livewire;

use App\Models\Conversion;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\Helper;
use App\Services\ConvertorService;
use App\Models\StorageFolder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Storage;
use Validator;

class Convertor extends Component
{
    use WithFileUploads;

    public $currentType;
    public $config;
    public $isFinished;
    public $converting = false;

    public $files = [];
    public $newfiles = [];
    public $storageFolder;

    public $types = [];

    // protected $listeners = ['showAlert'];

    // protected $listeners = ['echo-private:converts,ConvertStatusUpdate' => 'refreshStatus'];


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
            "echo:laravel_database_converts-{$this->storageFolder->id},ConvertStatusUpdate" => 'refreshStatus',
        ];
    }



    public function refreshStatus($event)
    {
        $this->isFinished = true;
        $this->converting = false;
        $this->files = [];
        $this->newfiles = [];
        $this->sendMessage('Converted Successfully!', 'success');
        $this->download();
    }


    public function updatedNewfiles()
    {

        $totalFiles = count($this->files) + count($this->newfiles);

        $rules = 'required|file|' . $this->config['rules'] . '|max:' . config('app.max_file_size_limit');
     
        $validator = Validator::make(
            ['newfiles' => $this->newfiles],
            ['newfiles.*' => $rules]
        );

        if ($validator->fails()) {
            $messages = '';

            foreach ($validator->errors()->all() as $message) {
                $messages .= '<p>' . $message . '</p>';
            }

            $this->sendMessage($messages, 'error');
            return;
        }


        if ($totalFiles > config('app.max_files_allowed')) {

            $this->sendMessage('Maximum file upload limit is less than: ' . config('app.max_files_allowed'), 'error');
            return;
        }

        $this->files = array_merge($this->files, $this->newfiles);
    }


    public function render()
    {
        return view('livewire.convertor');
    }

    public function delete($index)
    {
        unset($this->files[$index]);
    }


    public function convert()
    {

        $this->converting = true;

        $folderName = 'uploaded/' . $this->storageFolder->name;

        $storageFolder = $this->storageFolder;

        foreach ($this->files as $file) {
            $fileName = $file->storePublicly($folderName);

            $storageFolder->files()->create([
                'name' => $fileName
            ]);
        }

        $fromTo = explode('-to-', $this->currentType);


        $storageFolder->conversion()->create([
            'from_type' => $fromTo[0],
            'to_type' => $fromTo[1]
        ]);


        $result = StorageFolder::find($storageFolder->id);

        // event(new \App\Events\ConvertStatusUpdate($this->storageFolder));   


        $method = Str::camel($this->currentType);

        ConvertorService::$method($result);

      
    }




    public function download()
    {
        $path = storage_path('app/public/' . $this->storageFolder->name . '.zip');

        $this->storageFolder->conversion->downloaded_at = Carbon::now();
        $this->storageFolder->conversion->save();
       
        if (file_exists($path)) {
            
            $headers = array(
                'Content-Type' => 'application/octet-stream',
            );

            return Storage::disk('public')->download($this->storageFolder->name . '.zip', $this->storageFolder->name . '.zip' , $headers);
        }else{
            $this->sendMessage('File deleted from server', 'error');
        }
    }

    public function sendMessage($message, $type)
    {
        $this->emit('showAlert', ['type' => $type, 'title' => 'System', 'message' => $message]);
    }
}
