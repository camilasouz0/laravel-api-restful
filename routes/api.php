<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Authentication\AuthLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthLoginController::class, 'login'])->name('login');
    Route::post('register', [AuthLoginController::class, 'registrar'])->name('registrar');
    // Route::post('logout', [AuthLoginController::class, 'logout']);
    // Route::post('refresh', [AuthLoginController::class, 'refresh']);

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('users', [UserController::class, 'index'])->name('users.all');
        Route::post('users/{id}', [UserController::class, 'findUser'])->name('users.one');
    });
});
