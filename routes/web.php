<?php

use App\Http\Controllers\Back\{
    AdminController, PostController as BackPostController
};
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => 'auth'], function () {
    Lfm::routes();
});

Route::prefix('admin')->group(function () {
    Route::middleware('redac')->group(function () {
        Route::resource('posts', BackPostController::class)->except(['show', 'create']);
        Route::get('posts/create/{id?}', [BackPostController::class, 'create'])->name('posts.create');
    });

    Route::middleware('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('administration');
        Route::put('purge/{model}', [AdminController::class, 'purge'])->name('purge');
        // Posts
        Route::get('newposts', [BackPostController::class, 'index'])->name('posts.indexnew');
    });
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
