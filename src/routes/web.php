<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
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
Route::get('/{tab?}', [ItemController::class, 'index']);
Route::get('/item/{item_id}', [ItemController::class, 'show']);
Route::get('/register', [UserController::class, 'create']);
Route::post('/register', [UserController::class, 'store']);
Route::get('/login', [UserController::class, 'show']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth')->group(function () {
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'buy']);
    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'edit']);
    Route::get('/sell', [ItemController::class, 'show']);
    Route::post('/sell', [ItemController::class, 'sell']);
    Route::get('/mypage{page?}', [ProfileController::class, 'show']);
    Route::get('/mypage/profile', [ProfileController::class, 'input']);
    Route::post('/mypage/profile', [ProfileController::class, 'edit']);
});