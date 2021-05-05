<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\Helper;
use App\Services\ConvertorService;
use App\Models\StorageFolder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Validator;

class Convertor extends Component
{
    use WithFileUploads;

    public $currentType;
    public $config;
    public $isFinished;

    public $files = [];
    public $newfiles = [];
    public $storageFolder;

    public $types = [];

    // protected $listeners = ['showAlert'];


    public function mount()
    {
        $this->isFinished = false;
        $parts = explode('-', $this->currentType);
        $this->config = config('convertor.types.' . $parts[0]);

        // $rules = 'required|file|'.$this->config['rules'].'|max:'.config('app.max_file_size_limit');

    }


    public function updatedNewfiles()
    {

        $totalFiles = count($this->files) + count($this->newfiles);

        $rules = 'required|file|' . $this->config['rules'] . '|max:' . config('app.max_file_size_limit');
        // $this->validate([
        //     'newfiles.*' => 'required|file|'.$this->config['rules'].'|max:'.config('app.max_file_size_limit'),            
        // ]);

        $validator = Validator::make(
            ['newfiles' => $this->newfiles],
            [
                'newfiles.*' => $rules,
            ]
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

        $directoryName = Helper::uniqueName();

        $folderName = 'uploaded/' . $directoryName;

        //create a storage folder record
        $this->storageFolder = $storageFolder = new StorageFolder;
        $storageFolder->name = $directoryName;
        $storageFolder->save();

        foreach ($this->files as $file) {
            $fileName = $file->storePublicly($folderName);

            $storageFolder->files()->create([
                'name' => $fileName
            ]);
        }

        $fromTo = explode('-to-', $this->currentType);

        //create a new conversion record
        $conversion =  $storageFolder->conversion()->create([
            'from_type' => $fromTo[0],
            'to_type' => $fromTo[1]
        ]);


        $method = Str::camel($this->currentType);

        ConvertorService::$method($storageFolder);

        $this->isFinished = true;
        $this->files = [];
        $this->newfiles = [];

        session()->flash('success', 'Converted Successfully!');
    }



    public function refresh()
    {
        $this->isFinished = false;
        $this->files = [];
        $this->newfiles = [];
        $this->storageFolder = null;
    }

    public function download()
    {
        $path = storage_path()  . '/' . $this->storageFolder->name . '.zip';

        $this->storageFolder->conversion->downloaded_at = Carbon::now();
        $this->storageFolder->conversion->save();

        //download the zipped file if exist
        if (file_exists($path)) {
            return response()->download($path);
        }
    }

    public function sendMessage($message, $type)
    {
        $this->emit('showAlert', ['type' => $type, 'title' => 'System', 'message' => $message]);
    }
}
