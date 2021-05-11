<?php

namespace App\Jobs;

use File;
use App\Models\StorageFolder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteOldFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $storage_folder;

    public function __construct(StorageFolder $storage_folder)
    {
        $this->storage_folder = $storage_folder;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $uploadedFiles = storage_path('app/uploaded/' . $this->storage_folder->name);       
        $convertedFile = storage_path('app/public/' . $this->storage_folder->name);
        /**
         * Удаляем загруженные файлы 
         */
        if (File::exists($uploadedFiles)) File::deleteDirectory($uploadedFiles);

        /**
         * Удаляем конвертированные файлы 
         */
        if (File::exists($convertedFile)) File::deleteDirectory($convertedFile);


        \Log::info(get_class($this) . ": $uploadedFiles");
        \Log::info(get_class($this) . ": $convertedFile");
    }
}
