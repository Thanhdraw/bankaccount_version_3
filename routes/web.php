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
    ->name('account.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::get('/create', [AccountController::class, 'create'])->name('create');
        Route::post('/store', [AccountController::class, 'store'])->name('store');
        Route::get('/{id}', [AccountController::class, 'show'])->name('show');
        Route::get('edit/{id}', [AccountController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [AccountController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [AccountController::class, 'delete'])->name('delete');

        // Depost and Withdraw
        Route::post('/deposit/{account_number}', [AccountController::class, 'deposit'])->name('deposit');
         Route::post('/withdraw/{account_number}', [AccountController::class, 'withdraw'])->name('withdraw');
    });


require __DIR__ . '/auth.php';