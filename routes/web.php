<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PickupController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');


Route::prefix('product')->name('product.')->group( function () {
  Route::get('/search', [ProductController::class, 'search'])->name('search');
  Route::get('/all', [ProductController::class, 'all'])->name('all');
  Route::get('/{id}', [ProductController::class, 'show'])->name('show');
});

Route::prefix('cart')->name('cart.')->group( function () {
  Route::get('/', [CartController::class, 'index'])->name('index');
});

Route::middleware(['auth'])->prefix('profile')->name('profile.')->group( function () {
  Route::name('update.')->prefix('update')->group( function () {
    Route::put('data', [ProfileController::class, 'data'])->name('data');
    Route::put('photo', [ProfileController::class, 'photo'])->name('photo');
    Route::put('password', [ProfileController::class, 'password'])->name('password');
  });
  Route::get('/favorites', [ProductController::class, 'favorites'])->name('favorites');
  Route::post('/favorites', [ProductController::class, 'userFavorites'])->name('userFavorites');
  Route::get('/', [ProfileController::class, 'index'])->name('index');
});

Route::prefix('order')->name('order.')->group( function () {
  Route::get('/', [OrderController::class, 'index'])->middleware('auth')->name('index');
  Route::get('/create', [OrderController::class, 'create'])->name('create');
  Route::post('/store', [OrderController::class, 'store'])->name('store');
  Route::post('/update/status', [OrderController::class, 'updateStatus'])->name('update.status');
});

Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
  Route::get('/', [HomeController::class, 'index'])->name('index');
  Route::get('/redirect', [HomeController::class, 'redirect'])->name('redirect');

  Route::resource('order', App\Http\Controllers\Admin\OrderController::class)->except([
    'create', 'store', 'show'
  ]);

  Route::resource('product', App\Http\Controllers\Admin\ProductController::class)->except([
    'show'
  ]);

  Route::resource('skus', App\Http\Controllers\Admin\SkusController::class)->except([
    'create'
  ]);

  Route::resource('skus-category', App\Http\Controllers\Admin\SkusCategoryController::class)->only([
    'store', 'destroy'
  ]);
  Route::resource('brand', App\Http\Controllers\Admin\BrandController::class)->except([
    'create', 'show', 'edit'
  ]);
  Route::resource('category', App\Http\Controllers\Admin\CategoryController::class)->except([
    'create', 'show', 'edit'
  ]);
  Route::resource('coupon', App\Http\Controllers\Admin\CouponController::class)->except([
    'show'
  ]);
  Route::resource('slider', App\Http\Controllers\Admin\SliderController::class)->except([
    'show', 'create', 'edit'
  ]);

  Route::post('product/photo/store', [\App\Http\Controllers\Admin\ProductController::class, 'photoStore'])->name('product.store.photo');
  Route::post('product/photo/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'photo'])->name('product.photo');
  Route::post('product/photo-delete', [\App\Http\Controllers\Admin\ProductController::class, 'photoDelete'])->name('product.photo.delete');

  Route::prefix('settings')->name('settings.')->group(function () {
    Route::prefix('pickup')->name('pickup.')->group(function () {
      Route::get('/', [PickupController::class, 'index'])->name('index');
      Route::post('/store', [PickupController::class, 'store'])->name('store');
      Route::delete('/{id}', [PickupController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('money')->name('money.')->group(function () {
      Route::get('/', [SettingController::class, 'index'])->name('index');
      Route::put('/', [SettingController::class, 'update'])->name('update');
    });
  });
});

Route::post('auth/check', [App\Http\Controllers\ApiController::class, 'check']);
