<?php


namespace App\Repositories;


use Illuminate\Support\Facades\Log;

class PdfsToPdf implements Interfaces\PdfsToPdfInterface
{

    /**
     * @inheritDoc
     */
    public function convertFiles($source, $destination)
    {
        $this->checkAndMakeDir($destination);

        $filesAsString = $this->getFileNamesAsString($source);

        $command = "gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -dAutoRotatePages=/None -sOutputFile=$destination/output.pdf $filesAsString";

        Log::debug(class_basename(self::class), [
            'source' => $source,
            'destination' => $destination,
            'command' => $command,
        ]);

        return shell_exec($command);
    }

    protected function checkAndMakeDir(string $destination): void
    {
        if (!is_dir($destination)) {
            mkdir($destination, 0755);
        }
    }

    protected function getFileNamesAsString(string $source): string
    {
        $filesFromSource = glob($source . '.pdf');

        return implode(' ', $filesFromSource);
    }
}
