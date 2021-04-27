<?php

namespace App\Listeners;

use App\Events\FilesHaveBeenZipped;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetDownloadableFileLink
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FilesHaveBeenZipped  $event
     * @return void
     */
    public function handle(FilesHaveBeenZipped $event)
    {
        session(['test' => 'Bang!']);
        \Log::info('event listiner triggered');
        \Log::info(session('test'));
    }
}
