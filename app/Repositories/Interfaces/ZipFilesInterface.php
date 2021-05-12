<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;

interface ZipFilesInterface
{
    public function execute($name,$source,$destination);
}
