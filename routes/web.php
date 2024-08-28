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
Route::get('/register',[UserController::class,'register']);
Route::post('/createuser',[UserController::class,'createuser']);
Route::middleware(['\App\Http\Middleware\StatusLogin::class'])->group(function () {
    Route::middleware(['\App\Http\Middleware\adminauth::class'])->group(function () {
        Route::get('/index',[ProdukController::class,'index']);
        Route::get('/index/pelanggan',[UserController::class,'pelanggan']);
        Route::post('/index/caripelanggan',[UserController::class,'caripelanggan']);
        Route::get('/index/create',[ProdukController::class,'create']);
        Route::get('/index/delete/{id}',[ProdukController::class,'delete']);
        Route::post('/index/create',[ProdukController::class,'input']);
        Route::get('/index/edit/{id}',[ProdukController::class,'edit']);
        Route::post('/index/edit/{id}',[ProdukController::class,'update']);
        Route::post('/index/search',[ProdukController::class,'search']);
    });
    Route::get('/home',[ProdukController::class,'home']);
    Route::post('/home/tambah',[ProdukController::class,'tambah']);
    Route::get('/home/cart',[ProdukController::class,'cart']);
    Route::post('/home/search',[ProdukController::class,'cari']);
    Route::get('/auth/logout',[UserController::class,'logout']);
});
