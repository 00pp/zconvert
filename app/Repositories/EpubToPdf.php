<?php


namespace App\Repositories;


use App\Repositories\Interfaces\EpubToPdfInterface;
use Illuminate\Support\Facades\Log;

class EpubToPdf implements EpubToPdfInterface
{
    public function convertFiles($source, $destination)
    {
        Log::debug(class_basename(self::class), [
            'source' => $source,
            'destination' => $destination,
        ]);
        return shell_exec("ebook-convert $source $destination/output.pdf");
    }
}
