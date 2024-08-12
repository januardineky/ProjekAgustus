<?php

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
Route::post('/auth',[UserController::class,'auth']);
Route::middleware(['\App\Http\Middleware\StatusLogin::class'])->group(function () {
Route::get('/home',[UserController::class,'home']);
Route::get('/logout',[UserController::class,'logout']);
});
