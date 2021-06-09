<?php


namespace App\Repositories;


use Illuminate\Support\Facades\Log;

class JpgToPdf implements Interfaces\JpgToPdfInterface
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

        $this->checkAndMakeDir($destination);

        $filesAsString = $this->getFileNamesAsString($source);

        return shell_exec("pdfjoin --a4paper --fitpaper 'false' --rotateoversize 'false' $filesAsString -o $destination");
    }

    protected function checkAndMakeDir(string $destination): void
    {
        if (!is_dir($destination)) {
            mkdir($destination, 0755);
        }
    }

    protected function getFileNamesAsString(string $source): string
    {
        $filesFromSource = glob($source . '.j*');

        return implode(' ', $filesFromSource);
    }
}
