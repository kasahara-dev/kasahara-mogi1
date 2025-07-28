<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
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
Route::middleware('auth')->group(function () {
    Route::get('/{tab}', [ItemController::class, 'indexAuth']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'signUp']);
    Route::post('/purchase/{item_id}', [OrderController::class, 'buy']);
    Route::post('/purchase/address/{item_id}', [OrderController::class, 'addressEdit']);
    Route::get('/sell', [ItemController::class, 'sale']);
    Route::post('/sell', [ItemController::class, 'putSale']);
    Route::get('/mypage{page?}', [ProfileController::class, 'profileShow']);
    Route::post('/mypage/profile', [ProfileController::class, 'profileEdit']);
});
Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{item_id}', [ItemController::class, 'detail']);
