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

    protected $source;
    protected $conversion;
    protected $folderNameToHoldImages;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($conversion, $source)
    {
        $this->conversion = $conversion;
        $this->source = $source;
        $this->folderNameToHoldImages = Helper::$folderNameToHoldImages;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PdfToImageInterface $pdfToImage)
    {

        //interface method
        $result = $pdfToImage->convertFiles($this->source,$this->folderNameToHoldImages);

      

        \Log::info(get_class($this) . ": $this->source");

    }
}
