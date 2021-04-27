<?php

namespace App\Repositories;

use App\Advertisement;
use App\Repositories\Interfaces\AdvertisementRepositoryInterface;
use App\Repositories\Interfaces\ZipFilesInterface;
use Illuminate\Support\Facades\Storage;

class Zip implements ZipFilesInterface
{

    public function execute($name,$source,$destination)
    {
        // upload zip file to the public folder
//        $public = public_path();
//        shell_exec("cd $public && mkdir converted");
//        $public = public_path() . '/converted';
//
//        //after zipping the files
//        //move the folder to the public directory
//        return shell_exec("cd $filesPath && zip $fileName.zip * && mv $fileName.zip $public");

       //save the files on the same storage folder directory


        //after zipping the files
        return shell_exec("cd $source && zip $name.zip * && mv $name.zip $destination");
    }

}
