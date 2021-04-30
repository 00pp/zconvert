<?php

namespace App\Providers;

use App\Repositories\Interfaces\DocToPdfInterface;
use App\Repositories\Interfaces\PdfToImageInterface;
use App\Repositories\Interfaces\ZipFilesInterface;
use App\Repositories\LibreOfficeDocToPdf;
use App\Repositories\Pdftoppm;
use App\Repositories\Zip;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            DocToPdfInterface::class,
            LibreOfficeDocToPdf::class
        );

        $this->app->bind(
            PdfToImageInterface::class,
            Pdftoppm::class
        );

        $this->app->bind(
            ZipFilesInterface::class,
            Zip::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
