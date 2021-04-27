<?php

namespace App\Repositories\Interfaces;


interface PdfToImageInterface
{
    public function execute($file);

    /*
     * convert all files in a folder
     */
    public function convertFiles($source,$destination);
}
