<?php

use App\Http\Controllers\Admin\AdminActivityController;
use App\Http\Controllers\Admin\AutoBoxManufacturerController;
use App\Http\Controllers\Admin\AutoBoxProductController;
use App\Http\Controllers\Admin\CatalogCategoryController as AdminCatalogCategoryController;
use App\Http\Controllers\Admin\CompatibilityOverrideController;
use App\Http\Controllers\Admin\CompatibilityPreviewController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FitmentController;
use App\Http\Controllers\Admin\ProductSectionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProfileSecurityController;
use App\Http\Controllers\Admin\RoofRackManufacturerController;
use App\Http\Controllers\Admin\RoofRackProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserSessionController;
use App\Http\Controllers\Admin\VehicleBodyStyleController;
use App\Http\Controllers\Admin\VehicleConfigurationController;
use App\Http\Controllers\Admin\VehicleGenerationController;
use App\Http\Controllers\Admin\VehicleMakeController;
use App\Http\Controllers\Admin\VehicleModelController;
use App\Http\Controllers\Admin\VehicleRoofTypeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AutoBoxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoofRackCategoryController;
use App\Http\Controllers\VehicleFitmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::view('/prokat', 'rental')->name('rental');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware(['auth', 'auth.session', 'admin', 'admin.presence', 'admin.activity'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/settings', [ProfileController::class, 'edit'])->name('profile.settings.edit');
    Route::put('profile/settings', [ProfileController::class, 'update'])->name('profile.settings.update');
    Route::get('profile/security', [ProfileSecurityController::class, 'edit'])->name('profile.security.edit');
    Route::put('profile/security/password', [ProfileSecurityController::class, 'updatePassword'])->name('profile.security.password.update');
    Route::delete('profile/security/sessions', [ProfileSecurityController::class, 'destroyOtherSessions'])->name('profile.security.sessions.destroy');

    Route::middleware('permission:users.manage')->group(function () {
        Route::resource('users', UserController::class)->except(['show', 'destroy']);
    });

    Route::middleware('super_admin')->group(function () {
        Route::get('activity', AdminActivityController::class)->name('activity.index');
        Route::delete('users/{user}/sessions', UserSessionController::class)->name('users.sessions.destroy');
    });

    Route::middleware('permission:products.manage')->group(function () {
        Route::get('products', ProductSectionController::class)->name('products.index');
        Route::prefix('products/autobox')->name('products.auto-boxes.')->group(function () {
            Route::resource('manufacturers', AutoBoxManufacturerController::class)
                ->except(['show', 'destroy'])
                ->names('manufacturers');
            Route::get('/', [AutoBoxProductController::class, 'index'])->name('index');
            Route::get('/create', [AutoBoxProductController::class, 'create'])->name('create');
            Route::post('/', [AutoBoxProductController::class, 'store'])->name('store');
            Route::get('/{product}/edit', [AutoBoxProductController::class, 'edit'])->name('edit');
            Route::put('/{product}', [AutoBoxProductController::class, 'update'])->name('update');
        });
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
    });

    Route::middleware('permission:categories.manage')->group(function () {
        Route::resource('catalog-categories', AdminCatalogCategoryController::class)->except(['show', 'destroy']);
    });

    Route::middleware('permission:vehicles.manage')->group(function () {
        Route::get('compatibility/preview', CompatibilityPreviewController::class)->name('compatibility.preview');
        Route::resource('compatibility-overrides', CompatibilityOverrideController::class)->except('show');
        Route::get('fitments/{fitment}/configurations', [FitmentController::class, 'configurations'])->name('fitments.configurations');
        Route::post('fitments/{fitment}/configurations', [FitmentController::class, 'updateConfigurations'])->name('fitments.configurations.update');
        Route::get('fitments/{fitment}/preview', [FitmentController::class, 'preview'])->name('fitments.preview');
        Route::resource('fitments', FitmentController::class)->except('show');
        Route::prefix('vehicles')->name('vehicles.')->group(function () {
            Route::resource('vehicle-body-styles', VehicleBodyStyleController::class)->except('show');
            Route::resource('vehicle-roof-types', VehicleRoofTypeController::class)->except('show');
            Route::resource('vehicle-makes', VehicleMakeController::class)->except(['show', 'destroy']);
            Route::resource('vehicle-makes.vehicle-models', VehicleModelController::class)
                ->except('show')
                ->names('vehicle-models');
            Route::resource('vehicle-makes.vehicle-models.vehicle-generations', VehicleGenerationController::class)
                ->except('show')
                ->names('vehicle-generations');
            Route::resource('vehicle-makes.vehicle-models.vehicle-generations.vehicle-configurations', VehicleConfigurationController::class)
                ->except('show')
                ->names('vehicle-configurations');
        });
    });
});

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/autobox', AutoBoxController::class)->name('catalog.auto-boxes.index');
Route::get('/podbor-avto', [VehicleFitmentController::class, 'index'])->name('catalog.vehicle-fitment.index');
Route::get('/podbor-avto/models', [VehicleFitmentController::class, 'models'])->name('catalog.vehicle-fitment.models');
Route::get('/podbor-avto/configurations', [VehicleFitmentController::class, 'configurations'])->name('catalog.vehicle-fitment.configurations');

Route::prefix('autobagazhniki')->name('catalog.autobagazhniki.')->group(function () {
    Route::get('/', [RoofRackCategoryController::class, 'index'])->name('index');
    Route::get('/{category}', [RoofRackCategoryController::class, 'show'])->name('show');
    Route::get('/{category}/{model}', [RoofRackCategoryController::class, 'showModel'])->name('model.show');
    Route::get('/{category}/{model}/{generation}/{configuration}', [RoofRackCategoryController::class, 'showConfiguration'])->name('configuration.show');
    Route::get('/{category}/{model}/{generation}', [RoofRackCategoryController::class, 'showGeneration'])->name('generation.show');
});
