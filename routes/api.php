<?php

use App\Http\Controllers\AuthController;
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

Route::get('/test', function(){
    $response = [
        "data" => "backend connected"
    ];
    return response($response, 200);
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'registerApi'])->name('customer.registration');
    Route::post('/login', [AuthController::class, 'loginApi'])->name('customer.login');

    Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
        Route::get('/logout', [AuthController::class, 'logoutApi'])->name('customer.logout');

    });
});
