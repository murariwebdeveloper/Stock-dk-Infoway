<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: *");*/

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('login', [\App\Http\Controllers\API\AuthController::class, 'login']);
Route::get('login', [\App\Http\Controllers\API\AuthController::class, 'notLogin'])->name('login');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('user-details', [\App\Http\Controllers\API\AuthController::class, 'getLoginUserDetails'])->name('user-details');;
    Route::post('logout', [\App\Http\Controllers\API\AuthController::class, 'logout'])->name('logout');

    Route::group(['namespace' => 'Store', 'prefix' => 'store', 'as' => 'store.'], function () {
        Route::get('/', [\App\Http\Controllers\API\StoreController::class, 'index'])->name('all-data');
        Route::get('/list', [\App\Http\Controllers\API\StoreController::class, 'list'])->name('list');
        Route::post('save', [\App\Http\Controllers\API\StoreController::class, 'save'])->name('save');
        Route::post('update', [\App\Http\Controllers\API\StoreController::class, 'update'])->name('update');
        Route::post('delete', [\App\Http\Controllers\API\StoreController::class, 'delete'])->name('delete');
        Route::post('status', [\App\Http\Controllers\API\StoreController::class, 'updateStatus'])->name('status');
    });

    Route::group(['namespace' => 'Entry', 'prefix' => 'entry', 'as' => 'entry.'], function () {
        Route::get('/', [\App\Http\Controllers\API\StockEntryController::class, 'index'])->name('all-data');
        Route::get('/list', [\App\Http\Controllers\API\StockEntryController::class, 'list'])->name('list');
        Route::post('save', [\App\Http\Controllers\API\StockEntryController::class, 'save'])->name('save');
        Route::post('update', [\App\Http\Controllers\API\StockEntryController::class, 'update'])->name('update');
        Route::post('delete', [\App\Http\Controllers\API\StockEntryController::class, 'delete'])->name('delete');
        Route::post('status', [\App\Http\Controllers\API\StockEntryController::class, 'updateStatus'])->name('status');
    });



});

