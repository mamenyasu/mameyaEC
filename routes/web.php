<?php

use App\Http\Controllers\DashBoredController;
use App\Http\Controllers\MemberIndexController;
use Illuminate\Support\Facades\MaintenanceMode;
use Illuminate\Support\Facades\Route;
use App\Livewire\MainEC;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('memberIndex', [MemberIndexController::class, 'membersIndex'])->name('memberIndex')->middleware('admin');
    Route::get('mainEC', [MemberIndexController::class, 'mainEC'])->name('mainEC');
    Route::post('/cart/add', [MemberIndexController::class, 'add']);
    Route::get('/cart', [MemberIndexController::class, 'cartIndex'])->name('cartIndex');
    Route::post('/cart/remove', [MemberIndexController::class, 'cartRemove'])->name('cartRemove');
    Route::get('/cart/checkout', [MemberIndexController::class, 'checkoutIndex'])->name('checkout');
    Route::post('/checkout/process', [MemberIndexController::class, 'checkoutProcess'])->name('checkout.process');
    Route::get('/checkout/complete', function () {
        return view('checkout.complete');
    })->name('checkout.complete');
});

require __DIR__ . '/settings.php';
