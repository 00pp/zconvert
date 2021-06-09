<?php

namespace App\Providers;

use App\Repositories\EpubToPdf;
use App\Repositories\Interfaces;
use App\Repositories\JpgToPdf;
use App\Repositories;
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
            Interfaces\DocToPdfInterface::class,
            Repositories\LibreOfficeDocToPdf::class
        );

        $this->app->bind(
            Interfaces\PdfToImageInterface::class,
            Repositories\Pdftoppm::class
        );

        $this->app->bind(
            Interfaces\ZipFilesInterface::class,
            Repositories\Zip::class
        );


        $this->app->bind(
            Interfaces\EpubToPdfInterface::class,
            Repositories\EpubToPdf::class
        );
        $this->app->bind(
            Interfaces\JpgToPdfInterface::class,
            Repositories\JpgToPdf::class
        );
        $this->app->bind(
            Interfaces\OdsToPdfInterface::class,
            Repositories\OdsToPdf::class
        );
        $this->app->bind(
            Interfaces\OdtToPdfInterface::class,
            Repositories\OdtToPdf::class
        );
        $this->app->bind(
            Interfaces\PptToPdfInterface::class,
            Repositories\PptToPdf::class
        );
        $this->app->bind(
            Interfaces\PptxToPdfInterface::class,
            Repositories\PptxToPdf::class
        );
        $this->app->bind(
            Interfaces\RtfToPdfInterface::class,
            Repositories\RtfToPdf::class
        );
        $this->app->bind(
            Interfaces\PdfsToPdfInterface::class,
            Repositories\PdfsToPdf::class
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
