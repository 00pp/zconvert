<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use App\Repositories\Interfaces\PdfToImageInterface;
use App\Services\Helper;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class PdfToImageConverter implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pdfFolder;
    protected $imageFolder;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pdfFolder, $imageFolder)
    {
        $this->pdfFolder = $pdfFolder;
        $this->imageFolder = $imageFolder;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PdfToImageInterface $pdfToImage)
    {

        $pdfToImage->convertFiles($this->pdfFolder, $this->imageFolder);
        \Log::info(get_class($this) . ": $this->pdfFolder");
    }
}
