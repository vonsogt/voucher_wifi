<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    // Dasbor
    $router->get('/', 'HomeController@index')->name('home');

    // Voucher Print
    $router->get('voucher-print/{id}', 'VoucherController@voucherPrint')->name('voucher-print');

    // Admin Resources
    $router->resource('packages', PackageController::class);
    $router->resource('vouchers', VoucherController::class);
    $router->resource('routers', RouterController::class);
});
