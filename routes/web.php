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
Route::get('/products', 'App\Http\Controllers\ProductController@index')->name('products.index');
Route::get('/product/{product}', 'App\Http\Controllers\ProductController@show')->name('product.show');
Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart.index');
Route::get('/api/test/convert/doc/to/pdf', 'App\Http\Controllers\HomeController@convertDocToPdf')->name('dock.to.pdf');
Route::get('/api/test/convert/pdf/to/image', 'App\Http\Controllers\HomeController@convertPdfToImage')->name('pdf.to.image');
Route::get('/api/test/zip/files', 'App\Http\Controllers\HomeController@zipFiles');

Route::get('/api/all/conversions', function (){
    return \App\Models\StorageFolder::paginate();
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
