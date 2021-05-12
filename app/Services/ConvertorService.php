<?php

namespace App\Services;

use App\Events\ConvertionStatusChanged;
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


  public function __construct(StorageFolder $storageFolder,  $destination = null)
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


  public  function docxToJpg()
  {

    $pdfFolder = $this->uploadFolder . "/pdf";
    $imageFolder = $this->uploadFolder . "/images";
    $storageFolder = $this->storageFolder;

    Bus::chain([
      new DockToPdfConverter($this->uploadFolder, $pdfFolder),
      new PdfToImageConverter($pdfFolder, $imageFolder),
      new ZipFiles($imageFolder, $this->destination, $storageFolder->conversion, $storageFolder->name),
      function () use ($storageFolder) {
        event(new \App\Events\ConvertStatusUpdateEcho($storageFolder));
        event(new ConvertionStatusChanged($storageFolder->conversion, 'converted'));
      }

    ])->dispatch();
  }


  public  function docxToPdf()
  {
    $pdfFolder = $this->uploadFolder . "/pdf";
    $storageFolder = $this->storageFolder;


    Bus::chain([
      new DockToPdfConverter($this->uploadFolder, $pdfFolder),
      new ZipFiles($pdfFolder, $this->destination, $storageFolder->conversion, $storageFolder->name),
      function () use ($storageFolder) {       
        event(new \App\Events\ConvertStatusUpdateEcho($storageFolder));
        event(new ConvertionStatusChanged($storageFolder->conversion, 'converted'));
      }
    ])->dispatch();
  }
}
