<?php

namespace App\Repositories\Interfaces;


interface PdfToImageInterface
{
   

    /*
     * convert all files in a folder
     */
    public function convertFiles($source,$destination);
}
