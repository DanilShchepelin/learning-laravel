<?php

use App\Http\Controllers\Article\GetList as ArticleCollection;
use App\Http\Controllers\Article\Delete as ArticleDelete;
use App\Http\Controllers\Article\GetItem as ArticleDetail;
use App\Http\Controllers\Article\Store as ArticleStore;
use App\Http\Controllers\Article\Update as ArticleUpdate;
use App\Http\Controllers\Authentication\Login;
use App\Http\Controllers\Authentication\Logout;
use App\Http\Controllers\Authentication\Me;
use App\Http\Controllers\Authentication\Registration;
use App\Http\Controllers\Category\GetList as CategoryCollection;
use App\Http\Controllers\Category\Delete as CategoryDelete;
use App\Http\Controllers\Category\GetItem as CategoryDetail;
use App\Http\Controllers\Category\Store as CategoryStore;
use App\Http\Controllers\Category\Update as CategoryUpdate;
use App\Http\Controllers\User\GetList as UserCollection;
use App\Http\Controllers\User\Delete as UserDelete;
use App\Http\Controllers\User\GetItem as UserDetail;
use App\Http\Controllers\User\ChangePassword;
use App\Http\Controllers\User\Update as UserUpdate;
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
        Route::get('me', Me::class);
    });
});

Route::prefix('users')->group(function () {
    Route::get('/', UserCollection::class);
    Route::get('{user}', UserDetail::class);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('{user}', UserUpdate::class)->can('update', 'user');
        Route::put('{user}/reset-password', ChangePassword::class)->can('update', 'user');
        Route::delete('{user}', UserDelete::class)->can('delete', 'user');
    });
});

Route::prefix('articles')->group(function () {
    Route::get('/', ArticleCollection::class);
    Route::get('{article}', ArticleDetail::class);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('', ArticleStore::class)->can('create', \App\Models\Article::class);
        Route::post('{article}', ArticleUpdate::class)->can('update', 'article');
        Route::delete('{article}', ArticleDelete::class)->can('delete', 'article');
    });
});

Route::prefix('categories')->group(function () {
    Route::get('/', CategoryCollection::class);
    Route::get('{category}', CategoryDetail::class);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('', CategoryStore::class)->can('create', \App\Models\Category::class);
        Route::post('{category}', CategoryUpdate::class)->can('update', 'category');
        Route::delete('{category}', CategoryDelete::class)->can('delete', 'category');
    });
});
