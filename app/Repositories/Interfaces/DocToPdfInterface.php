<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;

interface DocToPdfInterface
{
    public function execute($file);
    /*
     * convert all files in a directory
     */
    public function convertFiles($source,$destination);
}
