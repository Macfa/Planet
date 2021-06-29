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
use App\Http\Controllers\EditorsController;
use App\Http\Controllers\UsersController;


// Main's route
Route::get('/', [MainController::class, 'index'])->name('mainHomePage');
Route::get('/search', [MainController::class, 'search'])->name('mainSearch');
// Route::get('/', [ChannelsController::class, 'index'])->name('main');

// Channel's route
Route::get('/channel/{id}', [ChannelsController::class, 'show'])->where('id', '[0-9]+')->name("channelShow");
Route::get('/channel/create', [ChannelsController::class, 'create'])->name("channelCreate");
Route::post('/channel', [ChannelsController::class, 'store'])->name("channelStore");

// Favorite's route
Route::post('/channel/favorite',[ChannelsController::class, 'addFavorite'])->where('id', '[0-9]+')->name("channelAddFavorite");


// Post's route
Route::get('/post/create',[PostsController::class, 'create'])->name('postCreate');
Route::post('/post', [PostsController::class, 'store'])->name('postStore');
Route::delete('/post/destroy', [PostsController::class, 'destroy'])->name('post.destroy');
Route::get('/post/{id}', [PostsController::class, 'show'])->where('id', '[0-9]+')->name("postShow");
Route::post('/post/voteLikeInPost',[PostsController::class, 'voteLikeInPost'])
    ->name('voteLikeInPost');
//Route::post('/post/upvote',[PostsController::class, 'upvote'])->where('id', '[0-9]*')->name('postUpvote');

// Comment's route
Route::post('/comment', [CommentsController::class, 'store'])->name('commentStore');
Route::post('/comment/voteLikeInComment',[CommentsController::class, 'voteLikeInComment'])->name('voteLikeInComment');

// User's route
Route::get('/user/{user?}', [UsersController::class, 'index'])->name('userMypage');

// apis
Route::get('/api/main', [MainController::class, 'getData']);
Route::get('/api/channel', [ChannelsController::class, 'getData']);

// Login with APIs
Route::get('auth/social', 'Auth\LoginController@show')->name('social.login');
Route::get('oauth/{driver}', [LoginController::class, 'redirectToProvider'])->name('social.oauth');
Route::get('oauth/{driver}/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');

// it must be change api sections
Route::post('/api/upload', [EditorsController::class, 'upload']);
