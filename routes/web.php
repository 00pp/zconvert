<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');

Route::get('/convert/{type}', 'App\Http\Controllers\ConvertorController@index')->name('convertor.page');

Route::get('/about', function () {
    return view('pages.about');
})->name('page.about');

Route::get('/terms', function () {
    return view('pages.terms');
})->name('page.terms');

Route::get('/contacts', function () {
    return view('pages.contacts');
})->name('page.contacts');




// Route::get('/api/test/convert/doc/to/pdf', 'App\Http\Controllers\HomeController@convertDocToPdf')->name('dock.to.pdf');
// Route::get('/api/test/convert/pdf/to/image', 'App\Http\Controllers\HomeController@convertPdfToImage')->name('pdf.to.image');
// Route::get('/api/test/zip/files', 'App\Http\Controllers\HomeController@zipFiles');

// Route::get('/api/all/conversions', function (){
//     return \App\Models\StorageFolder::paginate();
// });

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');
