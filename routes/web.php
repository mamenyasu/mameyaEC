<?php

use App\Http\Controllers\DashBoredController;
use App\Http\Controllers\MemberIndexController;
use Illuminate\Support\Facades\MaintenanceMode;
use Illuminate\Support\Facades\Route;
use App\Livewire\MainEC;

Route::get('/', [MemberIndexController::class, 'mainEC'])->name('home');

Route::view('dashboard', 'dashboard')->name('dashboard');
Route::get('memberIndex', [MemberIndexController::class, 'membersIndex'])->name('memberIndex')->middleware('admin');
Route::get('mainEC', [MemberIndexController::class, 'mainEC'])->name('mainEC');
Route::post('/cart/add', [MemberIndexController::class, 'add']);
Route::get('/cart', [MemberIndexController::class, 'cartIndex'])->name('cartIndex');
Route::post('/cart/remove', [MemberIndexController::class, 'cartRemove'])->name('cartRemove');
Route::get('/cart/checkout', [MemberIndexController::class, 'checkoutIndex'])->name('checkout');
Route::post('/cart/checkoutConfirm',[MemberIndexController::class,'checkoutConfirm'])->name('checkoutConfirm');
Route::post('/checkout/complete',[MemberIndexController::class,'complete'])->name('checkoutComplete');
Route::view('/checkout/thanks','checkoutThanks')->name('checkoutThanks');
Route::view('/profile/edit','profileEdit')->name('profileEdit');
Route::put('/profile/update',[MemberIndexController::class,'profileUpdate'])->middleware('auth')->name('profileUpdate');
Route::get('/ordersIndex', [MemberIndexController::class, 'ordersIndex'])->middleware('auth')->name('ordersIndex');


Route::middleware(['auth'])->group(function () {
    Route::view('/profile', 'profile')->name('profile.show');
});


require __DIR__ . '/settings.php';
