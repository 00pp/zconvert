<?php

namespace App\Services;


use Illuminate\Support\Str;

class Helper
{

    public static $folderNameHoldingPdfFiles = 'pdf';
    public static $folderNameToHoldImages = 'images';

    public static function uniqueName(): ?string
    {
        return (string)Str::uuid();
    }

    public static function deleteDiretory($name){
        return shell_exec("rm -R $name");
    }


    public static function formatBytes($bytes, $precision = 2) { 
        if ( $bytes < 1000 * 1024 ) {
            return number_format( $bytes / 1024, 2 ) . " KB";
            }
           elseif ( $bytes < 1000 * 1048576 ) {
            return number_format( $bytes / 1048576, 2 ) . " MB";
            }
           elseif ( $bytes < 1000 * 1073741824 ) {
            return number_format( $bytes / 1073741824, 2 ) . " GB";
            }
           else {
            return number_format( $bytes / 1099511627776, 2 ) . " TB";
            }
    }



    public static function getConvertSlugs() {

        $slugs = [];

        foreach(config('convertor.types') as $key => $types) 
        {
            foreach($types['to'] as $type) {
                $slugs[] =  $key.'-to-'.$type;
            }
        }

        return  $slugs;
    }


    
}
