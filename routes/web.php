<?php

use Illuminate\Support\Facades\Route;

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
// use App\Http\Controllers\Main\MainController;
use App\Http\Controllers\ChannelsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\Main\MainController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UsersController;


// Main's route
Route::get('/', [MainController::class, 'index'])->name('channelMain');
// Route::get('/', [ChannelsController::class, 'index'])->name('channelMain');

// Channel's route 
Route::get('/channel/{id}', [ChannelsController::class, 'show'])->where('id', '[0-9]+')->name("channelShow");
Route::get('/channel/create', [ChannelsController::class, 'create'])->name("channelCreate");
Route::post('/channel', [ChannelsController::class, 'store'])->name("channelStore");

// Favorite's route
Route::post('/channel/favorite/{id}',[ChannelsController::class, 'addFavorite'])->where('id', '[0-9]+')->name("channelAddFavorite");


// Post's route
Route::get('/post/create',[PostsController::class, 'create'])->name('postCreate');
Route::post('/post', [PostsController::class, 'store'])->name('postStore');
Route::get('/post/{id}', [PostsController::class, 'show'])->where('id', '[0-9]+')->name("postShow");
Route::post('/post/upvote/{id}',[PostsController::class, 'upvote'])->where('id', '[0-9]*')->name('postUpvote');

// Comment's route
Route::post('/comment', [CommentsController::class, 'store'])->name('commentStore');
Route::post('/comment/upvote/{id}',[CommentsController::class, 'upvote'])->where('id', '[0-9]*')->name('commentUpvote');

// User's route
Route::get('/mypage/{el}', [UsersController::class, 'index'])->name('userMypage');

// Login with APIs
Route::get('auth/social', 'Auth\LoginController@show')->name('social.login');
Route::get('oauth/{driver}', [LoginController::class, 'redirectToProvider'])->name('social.oauth');
Route::get('oauth/{driver}/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');

