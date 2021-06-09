<?php


namespace App\Repositories\Interfaces;


interface RtfToPdfInterface
{
    /**
     * @param $source
     * @param $destination
     * @return mixed
     */
    public function convertFiles($source, $destination);
}
