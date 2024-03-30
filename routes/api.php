<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/user/getuser', [HomeController::class, 'getuser']);
Route::get('/kendaraan/getkendaraan', [HomeController::class, 'getkendaraan']);
Route::get('/pengemudi/getpengemudi', [HomeController::class, 'getpengemudi']);
Route::post('/orderkendaraan/addorder', [HomeController::class, 'addorder']);
Route::get('/order/getorderprocces', [HomeController::class, 'getorderprocces']);
Route::get('/order/getorderapproved', [HomeController::class, 'getorderapproved']);
Route::put('/order/changestatus/{id}', [HomeController::class, 'changestatus']);
Route::put('/order/changestatuswaiting/{id}', [HomeController::class, 'changestatuswaiting']);
Route::get('/order/getByMonth', [HomeController::class, 'ordersByMonth']);
