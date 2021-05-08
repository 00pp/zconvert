<?php

namespace App\Console\Commands;

use App\Jobs\DeleteOldFilesJob;
use App\Models\Conversion;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;

class DeleteOldFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zconvert:clear_files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Команда, которая будет удалять уже скачанные файлы.';

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
        $convertions = Conversion::with('folder')->where('created_at', '<=', Carbon::now()->subHours(1)->toDateTimeString())
            ->where('status', 'converted')
            ->whereNotNull('downloaded_at')
            ->get();

      
        if (is_null($convertions)) return;

        foreach ($convertions as $convertion) {
            if ($convertion->folder) Bus::chain([ new DeleteOldFilesJob($convertion->folder) ])->dispatch();
        }
    }
}
