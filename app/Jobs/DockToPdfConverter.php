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
    public function handle(DocToPdfInterface $docToPdf)
    {
        $docToPdf->convertFiles($this->docFolder, $this->pdfFolder);

        \Log::info(get_class($this) . ": $this->docFolder");
    }
}
