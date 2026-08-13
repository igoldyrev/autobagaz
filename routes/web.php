<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VehicleMakeController;
use App\Http\Controllers\Admin\VehicleModelController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RoofRackCategoryController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::prefix('autobagazhniki')->name('roof-racks.')->group(function () {
        Route::get('vehicle-makes/attach', [VehicleMakeController::class, 'attachForm'])->name('vehicle-makes.attach-form');
        Route::post('vehicle-makes/attach', [VehicleMakeController::class, 'attach'])->name('vehicle-makes.attach');
        Route::resource('vehicle-makes', VehicleMakeController::class)->except('show');
        Route::resource('vehicle-makes.vehicle-models', VehicleModelController::class)
            ->except('show')
            ->names('vehicle-models');
    });
});

Route::prefix('autobagazhniki')->name('catalog.autobagazhniki.')->group(function () {
    Route::get('/', [RoofRackCategoryController::class, 'index'])->name('index');
    Route::get('/{category}', [RoofRackCategoryController::class, 'show'])->name('show');
    Route::get('/{category}/{model}', [RoofRackCategoryController::class, 'showModel'])->name('model.show');
});
