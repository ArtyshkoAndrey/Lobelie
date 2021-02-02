<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('countries', [App\Http\Controllers\ApiController::class, 'countries']);
Route::post('cities', [App\Http\Controllers\ApiController::class, 'cities']);
Route::post('categories', [App\Http\Controllers\ApiController::class, 'categories']);
Route::post('brands', [App\Http\Controllers\ApiController::class, 'brands']);

Route::post('currency/{id}', [ApiController::class, 'currency']);
Route::post('set-currency', [ApiController::class, 'set_currency']);
Route::post('products', [ApiController::class, 'products']);
Route::post('update-cart', [ApiController::class, 'update_cart']);
Route::post('cart-items-auth', [ApiController::class, 'cart_items_auth']);

Route::post('coupon', [ApiController::class, 'coupon']);

Route::post('cost-ems', [ApiController::class, 'getCostEms']);
