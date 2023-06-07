<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});


// products
// Route::resource('product', ProductController::class);
// Route::resource('product/show', ProductController::class);
// Route::resource('product/show/edit', ProductController::class);
// Route::resource('product/update', ProductController::class);
// Route::resource('product/save', ProductController::class);
// Route::resource('product/create_data', ProductController::class);


Route::controller(ProductController::class)->group(function () {
    Route::get('product', 'index');
    Route::post('product/getDataAll', 'getDataAll');
    Route::get('product/GetDataSelect', 'GetDataSelect');
    Route::post('product/Insert', 'Insert');
    Route::put('product/Update', 'Update');
    Route::delete('product/destroy', 'destroy');
    Route::get('product/functionSelect', 'functionSelect');
});
