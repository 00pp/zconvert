<?php

namespace App\Repositories\Interfaces;

interface DocToPdfInterface
{
    public function execute($file);
    /*
     * convert all files in a directory
     */
    public function convertFiles($source,$destination);
}
