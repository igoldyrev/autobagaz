<?php

use App\Http\Controllers\Admin\CatalogCategoryController as AdminCatalogCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductSectionController;
use App\Http\Controllers\Admin\RoofRackManufacturerController;
use App\Http\Controllers\Admin\RoofRackProductController;
use App\Http\Controllers\Admin\VehicleMakeController;
use App\Http\Controllers\Admin\VehicleModelController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoofRackCategoryController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/prokat', 'rental')->name('rental');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('products', ProductSectionController::class)->name('products.index');
    Route::prefix('products/autobagazhniki')->name('products.roof-racks.')->group(function () {
        Route::resource('manufacturers', RoofRackManufacturerController::class)
            ->except(['show', 'destroy'])
            ->names('manufacturers');
        Route::get('/', [RoofRackProductController::class, 'index'])->name('index');
        Route::get('/create', [RoofRackProductController::class, 'create'])->name('create');
        Route::post('/', [RoofRackProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [RoofRackProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [RoofRackProductController::class, 'update'])->name('update');
    });
    Route::resource('catalog-categories', AdminCatalogCategoryController::class)->except(['show', 'destroy']);

    Route::prefix('vehicles')->name('vehicles.')->group(function () {
        Route::resource('vehicle-makes', VehicleMakeController::class)->except(['show', 'destroy']);
        Route::resource('vehicle-makes.vehicle-models', VehicleModelController::class)
            ->except('show')
            ->names('vehicle-models');
    });
});

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::prefix('autobagazhniki')->name('catalog.autobagazhniki.')->group(function () {
    Route::get('/', [RoofRackCategoryController::class, 'index'])->name('index');
    Route::get('/{category}', [RoofRackCategoryController::class, 'show'])->name('show');
    Route::get('/{category}/{model}', [RoofRackCategoryController::class, 'showModel'])->name('model.show');
});
