<?php

namespace App\Services;

use App\Models\StorageFolder;
use Illuminate\Support\Str;
use Storage;
use Illuminate\Support\Facades\Bus;
use App\Jobs\DockToPdfConverter;
use App\Jobs\PdfToImageConverter;
use App\Jobs\ZipFiles;


class ConvertorService
{
  // public static function convert($files, $type)
  // {

  //   $directoryName = Helper::uniqueName();

  //   $folderName = 'uploaded/' . $directoryName;

  //   //create a storage folder record
  //   $storageFolder = new StorageFolder;
  //   $storageFolder->name = $directoryName;
  //   $storageFolder->save();

  //   foreach ($files as $file) {
  //     $fileName = $file->storePublicly($folderName);

  //     $storageFolder->files()->create([
  //       'name' => $fileName
  //     ]);
  //   }

  //   $fromTo = explode('-to-', $type);

  //   //create a new conversion record
  //   $conversion =  $storageFolder->conversion()->create([
  //     'from_type' => $fromTo[0],
  //     'to_type' => $fromTo[1]
  //   ]);


  //   $method = Str::camel($type);


  //   self::$method($storageFolder);

  // }



  public static function docxToJpg(StorageFolder $storageFolder)
  {
    $folderName = 'uploaded/' . $storageFolder->name;
    $sourceOfPdfs = Storage::path($folderName) . "/pdf";
    $sourceOfImages = $sourceOfPdfs."/images";
    $destination = storage_path();

    Bus::chain([
      new DockToPdfConverter($folderName),
      new PdfToImageConverter($storageFolder->conversion, $sourceOfPdfs),
      new ZipFiles($storageFolder->conversion, $storageFolder->name, $sourceOfImages, $destination)
    ])->dispatch();
  }


  public static function docxToPdf(StorageFolder $storageFolder)
  {
    $folderName = 'uploaded/' . $storageFolder->name;
    $sourceOfPdfs = Storage::path($folderName) . "/pdf";
    $destination = storage_path();

    Bus::chain([
      new DockToPdfConverter($folderName),
      new ZipFiles($storageFolder->conversion, $storageFolder->name, $sourceOfPdfs, $destination)
    ])->dispatch();
  }
}
