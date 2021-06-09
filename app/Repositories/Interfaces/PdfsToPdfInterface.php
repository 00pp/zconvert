<?php


namespace App\Repositories\Interfaces;


interface PdfsToPdfInterface
{
    /**
     * @param $source
     * @param $destination
     * @return mixed
     */
    public function convertFiles($source, $destination);
}
