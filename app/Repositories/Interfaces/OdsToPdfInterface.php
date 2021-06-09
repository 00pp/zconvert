<?php


namespace App\Repositories\Interfaces;


interface OdsToPdfInterface
{
    /**
     * @param $source
     * @param $destination
     * @return mixed
     */
    public function convertFiles($source, $destination);
}
