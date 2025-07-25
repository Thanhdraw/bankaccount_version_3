<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::prefix('account')
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\AccountController::class)
    ->name('account.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');

        // Depost and Withdraw
        Route::post('/deposit/{account_number}', 'deposit')->name('deposit');
        Route::post('/withdraw/{account_number}', 'withdraw')->name('withdraw');

        Route::post('/transaction/{account_number}', 'accountTransaction')->name('accountTransaction');
    });


require __DIR__ . '/auth.php';