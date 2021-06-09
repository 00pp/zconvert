<?php


namespace App\Repositories;


use Illuminate\Support\Facades\Log;

class PptxToPdf implements Interfaces\PptxToPdfInterface
{
    /**
     * @inheritDoc
     */
    public function convertFiles($source, $destination)
    {
        Log::debug(class_basename(self::class), [
            'source' => $source,
            'destination' => $destination,
        ]);

        return shell_exec("libreoffice --headless --convert-to pdf $source --outdir $destination");
    }
}
