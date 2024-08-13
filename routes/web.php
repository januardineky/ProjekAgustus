<?php

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});
Route::post('/auth/login',[UserController::class,'auth']);
Route::middleware(['\App\Http\Middleware\StatusLogin::class'])->group(function () {
    Route::get('/index',[ProdukController::class,'index']);
    Route::post('/index/search',[ProdukController::class,'search']);
    Route::get('/index/create',[ProdukController::class,'create']);
    Route::post('/index/create',[ProdukController::class,'input']);
    Route::get('/auth/logout',[UserController::class,'logout']);
});
