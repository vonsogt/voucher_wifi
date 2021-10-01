<?php

use App\Http\Controllers\API\V1\PackageApiController;
use App\Http\Controllers\API\V1\VoucherApiController;
use App\Http\Controllers\HomeController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'v1',
    'as' =>     'api.v1.'
], function () {
    // HomeController
    Route::get('payment-methods', [HomeController::class, 'paymentMethods'])->name('payment-methods');

    // PackageApiController
    Route::get('packages', [PackageApiController::class, 'index'])->name('packages');

    // VoucherApiController
    Route::post('buy-voucher', [VoucherApiController::class, 'buyVoucher'])->name('buy-voucher');
});
