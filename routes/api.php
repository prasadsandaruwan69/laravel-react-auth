<?php

use App\Http\Controllers\HotelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\GuidsController;
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
Route::get('/guids/all', [GuidsController::class, 'GetAllGuids']);
Route::get('/hotels/all', [HotelController::class, 'GetAllHotel']);


Route::get('/cars/all', [CarController::class, 'GetAll']);
  Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/cars/add', [CarController::class, 'create']);
    Route::get('/cars', [CarController::class, 'index']);
    Route::get('/cars/{id}', [CarController::class, 'show']);
    Route::put('/cars/{id}', [CarController::class, 'update']);
    Route::delete('/cars/{id}', [CarController::class, 'destroy']);

    Route::post('/guids/add', [GuidsController::class, 'create']);
    Route::get('/guids', [GuidsController::class, 'index']);
    Route::get('/guids/{id}', [GuidsController::class, 'show']);
    Route::put('/guids/{id}', [GuidsController::class, 'update']);
    Route::delete('/guids/{id}', [GuidsController::class, 'destroy']);


    Route::post('/hotels/add', [HotelController::class, 'create']);
    Route::get('/hotels', [HotelController::class, 'index']);
    Route::get('/hotels/{id}', [HotelController::class, 'show']);
    Route::put('/hotels/{id}', [HotelController::class, 'update']);
    Route::delete('/hotels/{id}', [HotelController::class, 'destroy']);


    // Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

});  