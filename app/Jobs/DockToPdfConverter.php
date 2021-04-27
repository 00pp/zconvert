<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use App\Repositories\Interfaces\DocToPdfInterface;
use App\Services\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DockToPdfConverter implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $source;
    protected $folderNameHoldingPdfFiles;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($source)
    {
        $this->source = $source;
        $this->folderNameHoldingPdfFiles = Helper::$folderNameHoldingPdfFiles;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DocToPdfInterface $docToPdf)
    {

        $path = $this->source . "/*";

        $files =  Storage::path("$path");
        $output = Storage::path("$this->source/$this->folderNameHoldingPdfFiles");

        //interface method
        $docToPdf->convertFiles($files, $output);

        //$this->convertFilesToImage($pdfToImage,$uploadedPath, $zip);

        \Log::info(get_class($this) . ": $this->source");

    }
}
