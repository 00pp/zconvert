<?php

namespace App\Repositories;

use App\Advertisement;
use App\Repositories\Interfaces\PdfToImageInterface;

class Pdftoppm implements PdfToImageInterface
{

    public function execute($file)
    {
        return  shell_exec("pdftoppm $file good -jpeg");
    }

    public function convertFiles($source, $destination)
    {
        //convert all .pdf files into images jpg
        shell_exec("cd $source && find . -maxdepth 1 -type f -name '*.pdf' -exec pdftoppm -jpeg {} {} \;");
        //move all the converted jpg files into the folder
        shell_exec("cd $source && mkdir $destination && mv *.jpg $destination/");

    }
}
