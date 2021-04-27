<?php

namespace App\Http\Livewire;

use App\Events\FilesHaveBeenZipped;
use App\Jobs\DockToPdfConverter;
use App\Jobs\PdfToImageConverter;
use App\Jobs\ZipFiles;
use App\Listeners\SetDownloadFileLink;
use App\Models\Conversion;
use App\Models\StorageFolder;
use App\Repositories\Interfaces\DocToPdfInterface;
use App\Repositories\Interfaces\PdfToImageInterface;
use App\Repositories\Interfaces\ZipFilesInterface;
use App\Services\Helper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Bus\Batch;
use Throwable;

class Fileupload extends Component
{
    use WithFileUploads;

//    protected $listeners = ['FilesHaveBeenZipped' => 'incrementPostCount'];

    public $files = [];

    public $error = "";

    public $text = "Convert";

    public $folderName = '';

    public $folderNameHoldingPdfFiles = '';

    public $folderNameToHoldImages = '';

    public $downloadLink = '';
    public $zipName = '';

    public $maxFilesAllowed;

    public $storageFolder;
    public $conversion;
    public $message = 'Converted Successfully!';

    protected $docToPdf;

    public function mount(){
        $this->folderNameHoldingPdfFiles = Helper::$folderNameHoldingPdfFiles;
        $this->folderNameToHoldImages = Helper::$folderNameToHoldImages;
        $this->maxFilesAllowed = config('app.max_files_allowed');
    }

    public function save( DocToPdfInterface $docToPdf,  PdfToImageInterface $pdfToImage, ZipFilesInterface $zip)
    {
        $this->validate([
            'files.*' => "file",
        ]);

        $validationPassed = $this->validateFiles();

        if($validationPassed){

            //unique name for the directory to store files
            $directoryName = Helper::uniqueName();

            $this->zipName = $directoryName;

            $this->folderName = 'uploaded/' . $directoryName;

            //create a storage folder record
            $storageFolder = new StorageFolder;
            $storageFolder->name = $directoryName;
            $storageFolder->save();

            $this->storageFolder = $storageFolder;

            foreach ($this->files as $file) {
                $fileName = $file->storePublicly($this->folderName);

                //add the file record
                //and attach it with the storage folder
                $storageFolder->files()->create([
                  'name' => $fileName
                ]);
            }

            //create a new conversion record
           $conversion =  $storageFolder->conversion()->create([
                'from_type' => 'doc',
                'to_type' => 'jpg'
           ]);

            $this->conversion = Conversion::find($conversion->id);

            //DockToPdfConverter::dispatch($this->folderName)->delay(now()->addMinutes(1)); //->delay(now()->addMinutes(5))

            $sourceOfPdfs = Storage::path($this->folderName) . "/$this->folderNameHoldingPdfFiles";

            //PdfToImageConverter::dispatch($sourceOfPdfs)->delay(now()->addMinutes(2));

            $zipSource = Storage::path($this->folderName) . "/$this->folderNameHoldingPdfFiles/$this->folderNameToHoldImages";
            $destination = storage_path();

            //ZipFiles::dispatch($this->zipName, $zipSource,$destination)->delay(now()->addMinutes(3));

            //chains the jobs in order
            //to convert doc,docx to images
            Bus::chain([
                new  DockToPdfConverter($this->folderName),
                new PdfToImageConverter($this->conversion, $sourceOfPdfs),
                new ZipFiles($this->conversion,$this->zipName, $zipSource, $destination)
            ])->dispatch();
           // $this->convertFilesToPdf($docToPdf, $pdfToImage, $this->folderName, $zip);

            session()->flash('success', 'Converted Successfully!');


            //these are files that just uploaded
            //for the conversion
            //once they are converted and zipped
            //these files should be removed
           // $this->removeUploadedFiles();

            $this->resetData();

        }else{
            \Log::info('validation failed');
            session()->flash('validationFailed', "Maximum file upload limit is less than: $this->maxFilesAllowed");
        }
    }

    public function resetData()
    {
        $this->files = [];
    }

    public function render()
    {
        return view('livewire.fileupload');
    }

    public function download()
    {
        $path = storage_path()  . '/' . $this->zipName . '.zip';

        $this->conversion->downloaded_at = Carbon::now();
        $this->conversion->save();

        //download the zipped file if exist
        if(file_exists($path)){
            return response()->download($path)->deleteFileAfterSend(true);
        }

    }

    protected function removeUploadedFiles(){
        $path = Storage::path($this->folderName);
        Helper::deleteDiretory($path);
    }

    protected function validateFiles(){
        if(count($this->files)  <= $this->maxFilesAllowed ){
            return true;
        }else{
            return false;
        }
    }
}
