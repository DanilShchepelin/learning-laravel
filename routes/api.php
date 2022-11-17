<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Authentication\Login;
use App\Http\Controllers\Authentication\Logout;
use App\Http\Controllers\Authentication\Me;
use App\Http\Controllers\Authentication\Registration;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\User\Collection;
use App\Http\Controllers\User\Delete;
use App\Http\Controllers\User\Detail;
use App\Http\Controllers\User\ChangePassword;
use App\Http\Controllers\User\Update;
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

Route::prefix('auth')->group(function () {
    Route::post('login', Login::class);
    Route::post('registration', Registration::class);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', Logout::class);
        Route::post('me', Me::class);
    });
});

Route::prefix('users')->group(function () {
    Route::get('/', Collection::class);
    Route::get('{user}', Detail::class);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('{user}', Update::class);
        Route::put('{user}/reset-password', ChangePassword::class);
        Route::delete('{user}', Delete::class);
    });
});

Route::apiResource('articles', ArticleController::class);
Route::apiResource('categories', CategoryController::class);
