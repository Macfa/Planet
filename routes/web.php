<?php

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

use App\Http\Controllers\CommentController;
use App\Http\Controllers\EditorsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// should be deleted route
Route::get('/test', [HomeController::class, 'test']);
Route::get('/test2', [HomeController::class, 'test2']);
Route::get('/noti', [\App\Http\Controllers\NoticeNotiController::class, 'test'])->name('test.noti');
Route::get('/noti2', [\App\Http\Controllers\NoticeNotiController::class, 'test_2'])->name('test.noti2');

// Main's route
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('home.search');
Route::get('/searchHelper', [HomeController::class, 'searchHelper'])->name('home.search.helper');
Route::get('/sidebar', [HomeController::class, 'sidebar'])->name('home.sidebar');
Route::get('/mainmenu', [HomeController::class, 'mainmenu'])->name('home.mainmenu');

// Post's resource
Route::resource('post', PostController::class);
Route::post('/post/voteLikeInPost', [PostController::class, 'voteLikeInPost']);
Route::post('/post/reportPost', [PostController::class, 'reportPost']);
Route::post('/post/scrapPost', [PostController::class, 'scrapPost']);

// Comments resource
Route::resource('comment', CommentController::class);
Route::post('/comment/voteLikeInComment', [CommentController::class, 'voteLikeInComment']);

// Channel's resource
Route::resource('channel', ChannelController::class);
Route::post('/channel/favorite', [ChannelController::class, 'favorite']);

// User's
Route::get('/user/{user}/{el?}', [UserController::class,'show'])->name('user.show');
Route::post('/user/{id}', [UserController::class,'modify'])->name('user.modify');
Route::get('/user/', [UserController::class,'logout'])->name('user.logout');

// Login with APIs

//Route::get('auth/social', 'Auth\LoginController@show')->name('social.login');
Route::get('auth/social', [LoginController::class,'show'])->name('social.login');
Route::get('oauth/{driver}', [LoginController::class, 'redirectToProvider'])->name('social.oauth');
Route::get('oauth/{driver}/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');

// it must be change api sections
Route::post('/api/upload', [EditorsController::class, 'upload'])->name('ck.upload');
