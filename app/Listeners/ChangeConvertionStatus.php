<?php

namespace App\Listeners;

use App\Events\ConvertionStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;

class ChangeConvertionStatus
{   
    /**
     * Handle the event.
     *
     * @param  ConvertionStatusChanged  $event
     * @return void
     */
    public function handle(ConvertionStatusChanged $event)
    {
        $event->conversion->converted_at = Carbon::now();
        $event->conversion->status = $event->status;
        $event->conversion->save();
    }
}
