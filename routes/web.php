<?php

use App\Http\Controllers\Admin\AdminActivityController;
use App\Http\Controllers\Admin\AutoBoxManufacturerController;
use App\Http\Controllers\Admin\AutoBoxProductController;
use App\Http\Controllers\Admin\BikeRackManufacturerController;
use App\Http\Controllers\Admin\BikeRackProductController;
use App\Http\Controllers\Admin\CallbackRequestController as AdminCallbackRequestController;
use App\Http\Controllers\Admin\CatalogCategoryController as AdminCatalogCategoryController;
use App\Http\Controllers\Admin\CompatibilityOverrideController;
use App\Http\Controllers\Admin\CompatibilityPreviewController;
use App\Http\Controllers\Admin\CompatibilityQualityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FitmentController;
use App\Http\Controllers\Admin\InstallationServiceController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductPageInformationController;
use App\Http\Controllers\Admin\ProductSectionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProfileSecurityController;
use App\Http\Controllers\Admin\RoofRackManufacturerController;
use App\Http\Controllers\Admin\RoofRackProductController;
use App\Http\Controllers\Admin\SkiRackManufacturerController;
use App\Http\Controllers\Admin\SkiRackProductController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserSessionController;
use App\Http\Controllers\Admin\VehicleBodyStyleController;
use App\Http\Controllers\Admin\VehicleConfigurationController;
use App\Http\Controllers\Admin\VehicleConfigurationQualityController;
use App\Http\Controllers\Admin\VehicleGenerationController;
use App\Http\Controllers\Admin\VehicleMakeController;
use App\Http\Controllers\Admin\VehicleModelController;
use App\Http\Controllers\Admin\VehicleRoofTypeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AutoBoxController;
use App\Http\Controllers\BikeRackController;
use App\Http\Controllers\CallbackRequestController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstallationController;
use App\Http\Controllers\Internal\AdminMonitoringController;
use App\Http\Controllers\LegacyRedirectController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\RoofRackCategoryController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\SkiRackController;
use App\Http\Controllers\VehicleFitmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('seo.robots');
Route::get('/sitemap.xml', [SeoController::class, 'index'])->name('seo.sitemap');
Route::get('/sitemaps/{page}.xml', [SeoController::class, 'page'])->where('page', '[1-9][0-9]{0,5}')->name('seo.sitemap.page');
foreach (array_keys(config('legacy_urls')) as $index => $legacyPath) {
    Route::get($legacyPath, LegacyRedirectController::class)->name('legacy.redirect.'.$index);
}
Route::view('/prokat', 'rental')->name('rental');
Route::get('/ustanovka', InstallationController::class)->name('installation');
Route::get('/akcii', PromotionController::class)->name('promotions.index');
Route::view('/contacts', 'contacts')->name('contacts');
Route::view('/dostavka-i-oplata', 'delivery-and-payment')->name('delivery-payment');
Route::view('/garantiya', 'warranty')->name('warranty');
Route::view('/politika-konfidentsialnosti', 'privacy-policy')->name('privacy-policy');
Route::view('/soglasie-na-obrabotku-personalnykh-dannykh', 'personal-data-consent')->name('personal-data-consent');

Route::get('/internal/daily-brief/admin-activity', AdminMonitoringController::class)
    ->middleware(['daily_brief.token', 'throttle:30,1'])
    ->name('internal.daily-brief.admin-activity');

Route::get('/internal/monitoring/project-snapshot', AdminMonitoringController::class)
    ->middleware(['daily_brief.token', 'throttle:30,1'])
    ->name('internal.monitoring.project-snapshot');

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
        Route::get('stock', [StockController::class, 'index'])->name('stock.index');
        Route::post('stock/export', [StockController::class, 'export'])->name('stock.export');
        Route::post('stock/import', [StockController::class, 'preview'])->name('stock.preview');
        Route::get('stock/import/{import}', [StockController::class, 'show'])->name('stock.show');
        Route::post('stock/import/{import}/apply', [StockController::class, 'apply'])->name('stock.apply');
        Route::get('products', ProductSectionController::class)->name('products.index');
        Route::get('products/information', [ProductPageInformationController::class, 'edit'])->name('products.information.edit');
        Route::put('products/information', [ProductPageInformationController::class, 'update'])->name('products.information.update');
        Route::get('products/installation-service', [InstallationServiceController::class, 'edit'])->name('products.installation-service.edit');
        Route::put('products/installation-service', [InstallationServiceController::class, 'update'])->name('products.installation-service.update');
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
        Route::prefix('products/velokrepleniya')->name('products.bike-racks.')->group(function () {
            Route::resource('manufacturers', BikeRackManufacturerController::class)
                ->except(['show', 'destroy'])
                ->names('manufacturers');
            Route::get('/', [BikeRackProductController::class, 'index'])->name('index');
            Route::get('/create', [BikeRackProductController::class, 'create'])->name('create');
            Route::post('/', [BikeRackProductController::class, 'store'])->name('store');
            Route::get('/{product}/edit', [BikeRackProductController::class, 'edit'])->name('edit');
            Route::put('/{product}', [BikeRackProductController::class, 'update'])->name('update');
        });
        Route::prefix('products/lyzhnye-krepleniya')->name('products.ski-racks.')->group(function () {
            Route::resource('manufacturers', SkiRackManufacturerController::class)->except(['show', 'destroy'])->names('manufacturers');
            Route::get('/', [SkiRackProductController::class, 'index'])->name('index');
            Route::get('/create', [SkiRackProductController::class, 'create'])->name('create');
            Route::post('/', [SkiRackProductController::class, 'store'])->name('store');
            Route::get('/{product}/edit', [SkiRackProductController::class, 'edit'])->name('edit');
            Route::put('/{product}', [SkiRackProductController::class, 'update'])->name('update');
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

    Route::middleware('permission:orders.manage')->group(function () {
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/terms', [AdminOrderController::class, 'storeTerms'])->name('orders.terms.store');
        Route::put('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
        Route::get('callback-requests', [AdminCallbackRequestController::class, 'index'])->name('callback-requests.index');
        Route::get('callback-requests/{callbackRequest}', [AdminCallbackRequestController::class, 'show'])->name('callback-requests.show');
        Route::put('callback-requests/{callbackRequest}', [AdminCallbackRequestController::class, 'update'])->name('callback-requests.update');
    });

    Route::middleware('permission:categories.manage')->group(function () {
        Route::resource('catalog-categories', AdminCatalogCategoryController::class)->except(['show', 'destroy']);
    });

    Route::middleware('permission:vehicles.manage')->group(function () {
        Route::get('compatibility/quality', CompatibilityQualityController::class)->name('compatibility.quality');
        Route::get('compatibility/preview', CompatibilityPreviewController::class)->name('compatibility.preview');
        Route::resource('compatibility-overrides', CompatibilityOverrideController::class)->except('show');
        Route::get('fitments/{fitment}/configurations', [FitmentController::class, 'configurations'])->name('fitments.configurations');
        Route::post('fitments/{fitment}/configurations', [FitmentController::class, 'updateConfigurations'])->name('fitments.configurations.update');
        Route::get('fitments/{fitment}/preview', [FitmentController::class, 'preview'])->name('fitments.preview');
        Route::post('fitments/{fitment}/copy', [FitmentController::class, 'copy'])->name('fitments.copy');
        Route::resource('fitments', FitmentController::class)->except('show');
        Route::get('vehicles/configurations/quality', VehicleConfigurationQualityController::class)->name('vehicles.configurations.quality');
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
Route::post('/products/{product}/crossbars', [ProductController::class, 'updateCrossbars'])->name('products.crossbars.update');
Route::post('/callback', [CallbackRequestController::class, 'store'])->middleware('throttle:10,1')->name('callback.store');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/crossbars', [CartController::class, 'updateCrossbars'])->name('cart.crossbars.update');
Route::post('/cart/kit/{product}/{roofRack}', [CartController::class, 'storeKit'])->middleware('throttle:30,1')->name('cart.store-kit');
Route::post('/cart/{product}', [CartController::class, 'store'])->middleware('throttle:30,1')->name('cart.store');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/installation-service', [CartController::class, 'destroyInstallationService'])->name('cart.installation-service.destroy');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/checkout', [CheckoutController::class, 'create'])->block(10, 10)->name('checkout.create');
Route::post('/checkout', [CheckoutController::class, 'store'])->middleware('throttle:10,1')->block(10, 10)->name('checkout.store');
Route::get('/checkout/thanks', [CheckoutController::class, 'thanks'])->block(10, 10)->name('checkout.thanks');
Route::get('/checkout/open-order', [CheckoutController::class, 'openOrder'])->name('checkout.open-order');
Route::post('/checkout/{order:access_token}/terms/accept', [CheckoutController::class, 'acceptTerms'])->where('order', '[a-f0-9]{64}')->middleware('throttle:10,1')->name('checkout.terms.accept');
Route::get('/checkout/{order:access_token}/success', [CheckoutController::class, 'success'])->where('order', '[a-f0-9]{64}')->name('checkout.success');
Route::get('/autobox', AutoBoxController::class)->name('catalog.auto-boxes.index');
Route::get('/velokrepleniya', BikeRackController::class)->name('catalog.bike-racks.index');
Route::get('/krepleniya-dlya-lyzh-i-snoubordov', SkiRackController::class)->name('catalog.ski-racks.index');
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
