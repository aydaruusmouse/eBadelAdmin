<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('/users', UserController::class);
    $router->resource('/orders', OrderController::class);
    $router->resource('/userwallets', UserWalletAccountController::class);
    $router->resource('/wallets', WalletProfileController::class);
    $router->resource('/bridgeFee', BridgeFeeController::class);
});
