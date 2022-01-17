<?php

use App\Http\Controllers\Back\{
    AdminController, PostController as BackPostController,
    UserController as BackUserController,
    ResourceController as BackResourceController,
};
use App\Http\Controllers\{
    PostController as FrontPostController,
    CommentController as FrontCommentController,
    PremiumPostController as FrontPremiumPostController,
    PaymentController as FrontPaymentController,
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

Route::get('/', [FrontPostController::class, 'index'])->name('home');
Route::get('category/{category:slug}', [FrontPostController::class, 'category'])->name('category');
Route::get('tag/{tag:slug}', [FrontPostController::class, 'tag'])->name('tag');
Route::get('author/{user}', [FrontPostController::class, 'user'])->name('author');
Route::prefix('posts')->group(function () {
    Route::get('{slug}', [FrontPostController::class, 'show'])->name('posts.display');
    Route::get('', [FrontPostController::class, 'search'])->name('posts.search');
    Route::get('{post}/comments', [FrontCommentController::class, 'comments'])->name('posts.comments');
    Route::post('{post}/comments', [FrontCommentController::class, 'store'])->middleware('auth')->name('posts.comments.store');
});
Route::delete('comments/{comment}', [FrontCommentController::class, 'destroy'])->name('front.comments.destroy');

//article premium
Route::get('membership', [FrontPremiumPostController::class, 'index'])->name('premium.index');
Route::get('payments', [FrontPaymentController::class, 'index'])->name('payment');
Route::post('payments', [FrontPaymentController::class, 'store'])->name('payment.store');

// Profile
Route::middleware('auth')->group(function () {
    Route::view('profile', 'auth.profile');
    Route::put('profile', [RegisteredUserController::class, 'update'])->name('profile');
});

require __DIR__.'/auth.php';
