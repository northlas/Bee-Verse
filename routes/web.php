<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\UserController;
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

Route::middleware('guest')->group(function(){
    Route::controller(UserController::class)->group(function(){
        Route::get('/login', 'get_login')->name('login');
        Route::post('/login', 'post_login');
        Route::post('/just-login', 'just_login');
        Route::post('/done-login', 'done_login');
        Route::get('/register', 'get_register')->name('register');
        Route::post('/register', 'post_register');
        Route::get('/payment', 'get_payment')->name('payment');
        Route::post('/payment', 'post_payment')->name('post_payment');
        Route::post('/create-user', 'create_user');
    });
});

Route::middleware('auth')->group(function(){
    Route::controller(UserController::class)->group(function(){
        Route::get('/profile/{user:slug}', 'index');
        Route::get('/profile/{user:slug}/follow', 'follow');
        Route::get('/profile/{user:slug}/unfollow', 'unfollow');
        Route::post('/profile/search', 'search');
        Route::post('/profile/show-avatar', 'show_avatar');
        Route::post('/profile/change-visibility', 'change_visibility');
        Route::post('/top-up', 'top_up');
        Route::post('/profile/set-avatar', 'set_avatar');
        Route::get('/logout', 'logout');
    });

    
    Route::controller(MarketController::class)->group(function(){
        Route::post('/offer-avatar', 'offer_avatar');
        Route::post('/buy-avatar', 'buy_avatar');
        Route::post('/select-connection', 'select_connection');
        Route::post('/check-avatar', 'check_avatar');
        Route::post('/send-avatar', 'send_avatar');
    });
    
    Route::controller(ChatController::class)->group(function(){
        Route::get('/chat', 'index')->name('chat');
        Route::get('/open-chat', 'open_chat');
        Route::post('/show-chat', 'show_chat');
        Route::post('/send-chat', 'send_chat');
    });
});

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/', [DashboardController::class, 'filter']);
Route::get('/home', [DashboardController::class, 'index']);
Route::get('/lang/{lang}', [LanguageController::class, 'switch'])->name('switch-lang');
Route::get('/market', [MarketController::class, 'index'])->name('market');
Route::post('/market', [MarketController::class, 'search']);