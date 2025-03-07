<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpeningHoursController;
use App\Http\Controllers\StoreStatusController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/opening-hours', [OpeningHoursController::class, 'index']);
Route::post('/opening-hours', [OpeningHoursController::class, 'store']);
Route::get('/store-status', [StoreStatusController::class, 'status']);
Route::post('/check-store-status', [StoreStatusController::class, 'checkStoreStatus']);
