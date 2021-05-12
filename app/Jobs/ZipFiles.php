<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use App\Events\FilesHaveBeenZipped;
use App\Repositories\Interfaces\ZipFilesInterface;
use Carbon\Carbon;
use Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ZipFiles implements ShouldQueue
{
    use Batchable,Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $conversion, $filename, $source, $destination;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($source, $destination, $conversion, $filename)
    {      
        $this->source = $source;
        $this->destination = $destination;
        $this->conversion= $conversion;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ZipFilesInterface $zip)
    {
        $zip->execute($this->filename,$this->source,$this->destination);
        $this->conversion->zipped_at = Carbon::now();
        $this->destination = $this->destination.'/'.$this->filename.'.zip';
        
        
        $this->conversion->filename = $this->destination;
        $this->conversion->save();

        \Log::info(get_class($this) . ":  $this->filename");
    }
}
