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
use App\Http\Controllers\Main\MainController;
use App\Http\Controllers\Channel\ChannelController;

// Route::get('/', function () {
//     return view('main.index');
// });

Route::get('/', [MainController::class, 'index']);
Route::get('/create', [ChannelController::class, 'create']);