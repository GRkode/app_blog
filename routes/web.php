<?php

use App\Http\Controllers\Back\{
    AdminController, PostController as BackPostController,
    UserController as BackUserController,
    ResourceController as BackResourceController,
};
use App\Http\Controllers\Auth\RegisteredUserController;
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
        // Users
        Route::put('valid/{user}', [BackUserController::class, 'valid'])->name('users.valid');
        Route::put('unvalid/{user}', [BackUserController::class, 'unvalid'])->name('users.unvalid');
        // Comments
        Route::resource('comments', BackResourceController::class)->except(['show', 'create', 'store']);
        Route::name('comments.indexnew')->get('newcomments', [BackResourceController::class, 'index']);
    });

    Route::middleware('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('administration');
        Route::put('purge/{model}', [AdminController::class, 'purge'])->name('purge');
        // Posts
        Route::get('newposts', [BackPostController::class, 'index'])->name('posts.indexnew');
        // Users
        Route::resource('users', BackUserController::class)->except(['show', 'create', 'store']);
        Route::get('newusers', [BackResourceController::class, 'index'])->name('users.indexnew');
    });
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::view('profile', 'auth.profile');
    Route::put('profile', [RegisteredUserController::class, 'update'])->name('profile');
});

require __DIR__.'/auth.php';
