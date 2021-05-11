<?php

namespace App\Console\Commands;

use App\Jobs\DeleteOldFilesJob;
use App\Models\Conversion;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;
use App\Events\ConvertionStatusChanged;

class DeleteOldFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zconvert:clear {--downloaded=1} {--hour=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Команда, которая будет удалять  скачанные файлы или старые файлы.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $query = Conversion::with('folder')->where('created_at', '<=', Carbon::now()->subHours($this->option('hour'))->toDateTimeString())
            ->where('status','!=' ,'deleted');
         
            
        if($this->option('downloaded') == 1){
            $query->whereNotNull('downloaded_at');
        } 

        $convertions = $query->get();

        
        if (is_null($convertions)) return;

        foreach ($convertions as $convertion) {
            if ($convertion->folder) Bus::chain([ 
                new DeleteOldFilesJob($convertion->folder),
                function() use($convertion){
                    event(new ConvertionStatusChanged($convertion, 'deleted'));
                }                
                ])->dispatch();
        }
    }
}
