<?php

namespace App\Repositories;

use App\Advertisement;
use App\Repositories\Interfaces\AdvertisementRepositoryInterface;
use App\Repositories\Interfaces\ZipFilesInterface;
use Illuminate\Support\Facades\Storage;

class Zip implements ZipFilesInterface
{

    public  function execute($name,$source,$destination)
    {
        return shell_exec("cd $source && zip -r $name.zip . && mv $name.zip $destination");
    }

}
