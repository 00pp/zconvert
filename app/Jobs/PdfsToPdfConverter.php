<?php

namespace App\Jobs;

use App\Repositories\Interfaces\EpubToPdfInterface;
use App\Repositories\Interfaces\PdfsToPdfInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PdfsToPdfConverter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $docFolder;

    protected $pdfFolder;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($docFolder, $pdfFolder)
    {
        $this->docFolder = $docFolder . "/*";

        $this->pdfFolder = $pdfFolder;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PdfsToPdfInterface $converter)
    {
        $converter->convertFiles($this->docFolder, $this->pdfFolder);

        \Log::info(get_class($this) . ": $this->docFolder");
    }
}