<?php


namespace App\Repositories\Interfaces;


interface OdtToPdfInterface
{
    /**
     * @param $source
     * @param $destination
     * @return mixed
     */
    public function convertFiles($source, $destination);
}
