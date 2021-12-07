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
use App\Http\Controllers\MobileHomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\StampController;
use App\Http\Controllers\UserController;
use App\Models\Channel;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::domain('m.lanet.co.kr')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('mobile.home');
});

Route::domain('m.localhost')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('mobile.home2');
});

// should be deleted route
Route::get('/test', [HomeController::class, 'test']);
Route::get('/test2', [HomeController::class, 'test2']);
Route::get('/noti', [\App\Http\Controllers\NoticeNotiController::class, 'test'])->name('test.noti');
Route::get('/noti2', [\App\Http\Controllers\NoticeNotiController::class, 'test_2'])->name('test.noti2');

// Main's route
//Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('home.search');
Route::get('/searchHelper', [HomeController::class, 'searchHelper'])->name('home.search.helper');
Route::get('/sidebar', [HomeController::class, 'sidebar'])->name('home.sidebar');
Route::get('/mainMenu', [HomeController::class, 'mainMenu'])->name('home.mainmenu');


Route::get('/post/{post}/get', [PostController::class, 'getPost']);
Route::post('/post/{post}/like', [PostController::class, 'like']);
Route::post('/post/{post}/report', [PostController::class, 'report']);
Route::post('/post/{post}/scrap', [PostController::class, 'scrap']);
// Post's resource
Route::resource('post', PostController::class);
//Route::resource('post', PostController::class)->except([
//    'show', 'index'
//]);
//Route::get('/post/show/{post}', [PostController::class, 'show']);
//Route::get('/post/show/{post}', [HomeController::class, 'index']);


Route::post('/comment/{comment}/like', [CommentController::class, 'like']);
// Comments resource
Route::resource('comment', CommentController::class);
//Route::post('/post/{post}/like', [PostController::class, 'like']);


// Channel's resource
Route::post('/channel/channelJoin', [ChannelController::class, 'channelJoin']);
Route::post('/channel/addChannelAdmin', [ChannelController::class, 'addChannelAdmin']);
Route::get('/channel/getUserInChannel/{channelID}', [ChannelController::class, 'getUserInChannel']);
Route::get('/channel/removeChannelAdmin/{userID}', [ChannelController::class, 'getUserInChannel']);
Route::resource('channel', ChannelController::class);

// Post resource in Channel
Route::prefix('/channel/{channel}')->group(function () {
//    Route::get('/post/{post}', [PostController::class, 'show']);
    Route::get('/post/{post}', [PostController::class, 'show']);
});
// User's
Route::get('/user/{user}/{el?}', [UserController::class,'show'])->name('user.show');
Route::post('/user/{id}', [UserController::class,'modify'])->name('user.modify');
Route::delete('/user/{id?}', [UserController::class,'destroy'])->name('user.destroy');
Route::get('/user/', [UserController::class,'logout'])->name('user.logout');
Route::get('/mark', function() {
    auth()->user()->unreadNotifications->markAsRead();
});

// Stamp's
//Route::get('/stamp', [StampController::class,'getDataFromCategory']);
Route::post('/stamp/purchase', [StampController::class,'purchase']);
Route::get('/stamp', [StampController::class,'show']);
Route::get('/stamp/{id}', [StampController::class,'get']);
Route::get('/category/', [\App\Http\Controllers\StampCategoryController::class,'get']);

// Login with APIs
//Route::get('auth/social', 'Auth\LoginController@show')->name('social.login');
Route::get('auth/social', [LoginController::class,'show'])->name('social.login');
Route::get('oauth/{driver}', [LoginController::class, 'redirectToProvider'])->name('social.oauth');
Route::get('oauth/{driver}/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');

// it must be change api sections
Route::post('/api/upload', [EditorsController::class, 'upload'])->name('ck.upload');
