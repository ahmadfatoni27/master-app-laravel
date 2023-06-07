<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Controll_ProductApi;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/products', [Controll_ProductApi::class, 'index']);
Route::get('/products/{id}', [Controll_ProductApi::class, 'show']);
Route::get('/products/search/{searchBy}/{value}', [Controll_ProductApi::class, 'search']);
Route::post('/products', [Controll_ProductApi::class, 'store']);
Route::put('/products/{id}', [Controll_ProductApi::class, 'update']);
Route::delete('/products/{id}', [Controll_ProductApi::class, 'destroy']);
