<?php

namespace App\Services;

use App\Events\ConvertionStatusChanged;
use App\Events\ConvertStatusUpdateEcho;
use App\Jobs\EpubToPdfConverter;
use App\Jobs\JpgToPdfConverter;
use App\Jobs\OdsToPdfConverter;
use App\Jobs\OdtToPdfConverter;
use App\Jobs\PdfsToPdfConverter;
use App\Jobs\PptToPdfConverter;
use App\Jobs\PptxToPdfConverter;
use App\Jobs\RtfToPdfConverter;
use App\Models\StorageFolder;
use Illuminate\Support\Str;
use Storage;
use Illuminate\Support\Facades\Bus;
use App\Jobs\DockToPdfConverter;
use App\Jobs\PdfToImageConverter;
use App\Jobs\ZipFiles;
use Illuminate\Bus\Batch;
use Carbon\Carbon;
use Exception;

class ConvertorService
{

    protected $uploadFolder;
    protected $storageFolder;
    protected $destination;


    public function __construct(StorageFolder $storageFolder, $destination = null)
    {
        $this->storageFolder = $storageFolder;
        $this->uploadFolder = storage_path('app/uploaded/' . $storageFolder->name);


        if (!is_null($destination)) {
            $this->destination = $destination;
        } else {
            $this->destination = storage_path('app/public/' . $storageFolder->name);
        }
        if (!\File::exists($this->destination)) \File::makeDirectory($this->destination);
    }

    public function epubToPdf()
    {
        $pdfFolder = $this->uploadFolder . "/pdf";

        $storageFolder = $this->storageFolder;

        Bus::chain([
            new EpubToPdfConverter($this->uploadFolder, $pdfFolder),
            new ZipFiles($pdfFolder, $this->destination, $storageFolder->conversion, $storageFolder->name),
            function () use ($storageFolder) {
                event(new ConvertStatusUpdateEcho($storageFolder));
                event(new ConvertionStatusChanged($storageFolder->conversion, 'converted'));
            }
        ])->dispatch();
    }

    public function jpgToPdf()
    {
        $pdfFolder = $this->uploadFolder . "/pdf";

        $storageFolder = $this->storageFolder;

        Bus::chain([
            new JpgToPdfConverter($this->uploadFolder, $pdfFolder),
            new ZipFiles($pdfFolder, $this->destination, $storageFolder->conversion, $storageFolder->name),
            function () use ($storageFolder) {
                event(new ConvertStatusUpdateEcho($storageFolder));
                event(new ConvertionStatusChanged($storageFolder->conversion, 'converted'));
            }
        ])->dispatch();
    }

    public function odsToPdf()
    {
        $pdfFolder = $this->uploadFolder . "/pdf";

        $storageFolder = $this->storageFolder;

        Bus::chain([
            new OdsToPdfConverter($this->uploadFolder, $pdfFolder),
            new ZipFiles($pdfFolder, $this->destination, $storageFolder->conversion, $storageFolder->name),
            function () use ($storageFolder) {
                event(new ConvertStatusUpdateEcho($storageFolder));
                event(new ConvertionStatusChanged($storageFolder->conversion, 'converted'));
            }
        ])->dispatch();
    }

    public function odtToPdf()
    {
        $pdfFolder = $this->uploadFolder . "/pdf";

        $storageFolder = $this->storageFolder;

        Bus::chain([
            new OdtToPdfConverter($this->uploadFolder, $pdfFolder),
            new ZipFiles($pdfFolder, $this->destination, $storageFolder->conversion, $storageFolder->name),
            function () use ($storageFolder) {
                event(new ConvertStatusUpdateEcho($storageFolder));
                event(new ConvertionStatusChanged($storageFolder->conversion, 'converted'));
            }
        ])->dispatch();
    }

    public function pptToPdf()
    {
        $pdfFolder = $this->uploadFolder . "/pdf";

        $storageFolder = $this->storageFolder;

        Bus::chain([
            new PptToPdfConverter($this->uploadFolder, $pdfFolder),
            new ZipFiles($pdfFolder, $this->destination, $storageFolder->conversion, $storageFolder->name),
            function () use ($storageFolder) {
                event(new ConvertStatusUpdateEcho($storageFolder));
                event(new ConvertionStatusChanged($storageFolder->conversion, 'converted'));
            }
        ])->dispatch();
    }

    public function pptxToPdf()
    {
        $pdfFolder = $this->uploadFolder . "/pdf";

        $storageFolder = $this->storageFolder;

        Bus::chain([
            new PptxToPdfConverter($this->uploadFolder, $pdfFolder),
            new ZipFiles($pdfFolder, $this->destination, $storageFolder->conversion, $storageFolder->name),
            function () use ($storageFolder) {
                event(new ConvertStatusUpdateEcho($storageFolder));
                event(new ConvertionStatusChanged($storageFolder->conversion, 'converted'));
            }
        ])->dispatch();
    }

    public function rtfToPdf()
    {
        $pdfFolder = $this->uploadFolder . "/pdf";

        $storageFolder = $this->storageFolder;

        Bus::chain([
            new RtfToPdfConverter($this->uploadFolder, $pdfFolder),
            new ZipFiles($pdfFolder, $this->destination, $storageFolder->conversion, $storageFolder->name),
            function () use ($storageFolder) {
                event(new ConvertStatusUpdateEcho($storageFolder));
                event(new ConvertionStatusChanged($storageFolder->conversion, 'converted'));
            }
        ])->dispatch();
    }

    public function pdfsToPdf()
    {
        $pdfFolder = $this->uploadFolder . "/pdf";

        $storageFolder = $this->storageFolder;

        Bus::chain([
            new PdfsToPdfConverter($this->uploadFolder, $pdfFolder),
            new ZipFiles($pdfFolder, $this->destination, $storageFolder->conversion, $storageFolder->name),
            function () use ($storageFolder) {
                event(new ConvertStatusUpdateEcho($storageFolder));
                event(new ConvertionStatusChanged($storageFolder->conversion, 'converted'));
            }
        ])->dispatch();
    }

    public function docxToJpg()
    {

        $pdfFolder = $this->uploadFolder . "/pdf";
        $imageFolder = $this->uploadFolder . "/images";
        $storageFolder = $this->storageFolder;

        Bus::chain([
            new DockToPdfConverter($this->uploadFolder, $pdfFolder),
            new PdfToImageConverter($pdfFolder, $imageFolder),
            new ZipFiles($imageFolder, $this->destination, $storageFolder->conversion, $storageFolder->name),
            function () use ($storageFolder) {
                event(new ConvertStatusUpdateEcho($storageFolder));
                event(new ConvertionStatusChanged($storageFolder->conversion, 'converted'));
            }

        ])->dispatch();
    }


    public function docxToPdf()
    {
        $pdfFolder = $this->uploadFolder . "/pdf";
        $storageFolder = $this->storageFolder;


        Bus::chain([
            new DockToPdfConverter($this->uploadFolder, $pdfFolder),
            new ZipFiles($pdfFolder, $this->destination, $storageFolder->conversion, $storageFolder->name),
            function () use ($storageFolder) {
                event(new ConvertStatusUpdateEcho($storageFolder));
                event(new ConvertionStatusChanged($storageFolder->conversion, 'converted'));
            }
        ])->dispatch();
    }
}
