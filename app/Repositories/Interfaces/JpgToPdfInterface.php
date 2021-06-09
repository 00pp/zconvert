<?php


namespace App\Repositories\Interfaces;


interface JpgToPdfInterface
{
    /**
     * @param $source
     * @param $destination
     * @return mixed
     */
    public function convertFiles($source, $destination);
}
