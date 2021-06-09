<?php


namespace App\Repositories\Interfaces;


interface PptxToPdfInterface
{
    /**
     * @param $source
     * @param $destination
     * @return mixed
     */
    public function convertFiles($source, $destination);
}
