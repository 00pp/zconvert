<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use App\Events\FilesHaveBeenZipped;
use App\Repositories\Interfaces\ZipFilesInterface;
use Carbon\Carbon;
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
    public function __construct($conversion, $fileName, $source, $destination)
    {
        $this->filename = $fileName;
        $this->source = $source;
        $this->destination = $destination;
        $this->conversion = $conversion;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ZipFilesInterface $zip)
    {
        $zip->execute($this->filename,$this->source,$this->destination);

        //set the time when the zipping is done
        $this->conversion->zipped_at = Carbon::now();
        $this->conversion->save();

        \Log::info(get_class($this) . ":  $this->filename");
        //FilesHaveBeenZipped::dispatch($this->filename);

    }
}
