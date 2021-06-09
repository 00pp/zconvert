<?php


namespace App\Repositories\Interfaces;


interface EpubToPdfInterface
{
    /**
     * @param $source
     * @param $destination
     * @return mixed
     */
    public function convertFiles($source, $destination);
}
