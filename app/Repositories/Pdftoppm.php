<?php

namespace App\Repositories;

use App\Advertisement;
use App\Repositories\Interfaces\PdfToImageInterface;

class Pdftoppm implements PdfToImageInterface
{

    

    public function convertFiles($source, $destination)
    {
        $pdfFiles =  \File::files($source);

        $commands = '';

        foreach($pdfFiles as $file) {
            $fileName = $file->getFilename();
            $baseName = substr($file->getBasename('.pdf'), 0, -2);
            $path = "$destination/$baseName";
            \File::makeDirectory($path);
            if($file->getExtension() == 'pdf'){
               $commands .= " && pdftoppm $fileName $destination/$baseName/$baseName -jpeg";
            }
        }

        shell_exec("cd $source $commands");
    }
}
