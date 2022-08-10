<?php

use App\Http\Controllers\Api\AuthController;
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
Route::middleware('json.response')->group(function () {

    Route::middleware( 'auth:api')->group(function () {

        Route::get('/me', function (Request $request) {
            return $request->user();
        })->name('login');

        Route::prefix('users')->group(function () {
            Route::get('/', [AuthController::class, 'index'])->name('auth.index');
            Route::post('/', [AuthController::class, 'store'])->name('auth.store');

            Route::get('/{id}', [AuthController::class, 'show'])->name('auth.show');
            Route::patch('/{id}', [AuthController::class, 'patch'])->name('auth.patch');
            Route::delete('/{id}', [AuthController::class, 'destroy'])->name('auth.destroy');
        });

    });
});
