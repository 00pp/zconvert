<?php


namespace App\Repositories\Interfaces;


interface PptToPdfInterface
{
    /**
     * @param $source
     * @param $destination
     * @return mixed
     */
    public function convertFiles($source, $destination);
}
