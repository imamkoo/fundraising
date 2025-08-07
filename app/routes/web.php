<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\FundraiserController;
use App\Http\Controllers\FundraisingController;
use App\Http\Controllers\FundraisingPhaseController;
use App\Http\Controllers\FundraisingWithdrawalController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ClientController::class, 'index'])->name('client.index');

Route::get('/category/{category}', [ClientController::class, 'category'])->name('client.category');

Route::get('/details/{fundraising:slug}', [ClientController::class, 'details'])->name('client.details');

Route::get('/donation/{fundraising:slug}', [ClientController::class, 'donation'])->name('client.donation');

Route::get('/checkout/{fundraising:slug}/{totalAmountDonation}', [ClientController::class, 'checkout'])->name('client.checkout');

Route::post('/checkout/store/{fundraising:slug}/{totalAmountDonation}', [ClientController::class, 'store'])->name('client.store');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', CategoryController::class)->middleware('role:owner');
        Route::resource('donaturs', DonaturController::class)->middleware('role:owner');
        Route::resource('fundraisers', FundraiserController::class)->middleware('role:owner')->except('index');

        Route::get('fundraisers', [FundraiserController::class, 'index'])->name('fundraisers.index');

        Route::resource('fundraising_withdrawals', FundraisingWithdrawalController::class)->middleware('role:owner|fundraiser');

        Route::post('/fundraising_withdrawals/request/{fundraising}', [FundraisingWithdrawalController::class, 'store'])->middleware('role:fundraiser')->name('fundraising_withdrawals.request');

        Route::resource('fundraising_phases', FundraisingPhaseController::class)->middleware('role:owner|fundraiser');

        Route::post('/fundraising_phases/update/{fundraising}', [FundraisingPhaseController::class, 'store'])->middleware('role:fundraiser')->name('fundraising_phases.request');

        Route::resource('fundraisings', FundraisingController::class)->middleware('role:owner|fundraiser');

        Route::post('/fundraisings/active/{fundraising}', [FundraisingController::class, 'activate_fundraising'])->middleware('role:owner')->name('fundraising_withdrawals.activate_fundraising');

        Route::post('/fundraiser/apply', [DashboardController::class, 'apply_fundraiser'])->name('fundraiser.apply');

        Route::get('/my-withdrawals', [DashboardController::class, 'my_withdrawals'])->name('my-withdrawals');
        
        Route::get('/my-withdrawals/details/{fundraisingWithdrawal}', [DashboardController::class, 'my_withdrawals_details'])->name('my-withdrawals.details');
    
       
    });
});

require __DIR__.'/auth.php';
