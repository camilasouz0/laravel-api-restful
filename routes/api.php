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

    // Route::post('password/forgot', 'Auth\PasswordController@forgot')->name('password.forgot');

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('users', [UserController::class, 'index'])->name('users.all');
        Route::post('users/{id}', [UserController::class, 'findUser'])->name('users.one');

    //     Route::post('logout', 'Auth\TokenController@logout')->name('logout');

    //     Route::post('me', 'Auth\UserController@me')->name('user.show');
    //     Route::post('put-me', 'Auth\UserController@putMe')->name('user.update');
    //     Route::put('me/avatar', 'Auth\UserController@putMyAvatar')->name('user.update.avatar');
    });
});
