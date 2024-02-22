<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\WaafiController;
use App\Http\Controllers\Api\DAHAB_API;
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



// route get with CategoryController
Route::get('categories', [\App\Http\Controllers\Api\CategoryController::class, 'index']);
Route::post('credit', [\App\Http\Controllers\Api\WaafiApi::class, 'creditMoney']);
Route::post('purchase', [\App\Http\Controllers\Api\WaafiApi::class, 'payWithZaad']);
// Route::post('credit', [\App\Http\Controllers\Api\WaafiApi::class, 'creditMoney']);
// route post with UserControll 
Route::post('register', [\App\Http\Controllers\Api\UserControll::class, 'register']);
Route::post('login', [\App\Http\Controllers\Api\UserControll::class, 'login']);
Route::get('login', [\App\Http\Controllers\Api\UserControll::class, 'index']);
Route::post('logout', [\App\Http\Controllers\Api\UserControll::class, 'logout']);
Route::get('users', [\App\Http\Controllers\Api\UserControll::class, 'index']);
Route::get('users/{userId}', [\App\Http\Controllers\Api\UserControll::class, 'show']);
// ussd route
Route::post('/process-ussd-codes', [\App\Http\Controllers\Api\UssdController::class, 'processUSSDCodes']);
Route::get('/process-ussd-codes', [\App\Http\Controllers\Api\UssdController::class, 'index']);

// route post with TransectionsController

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('transections', [\App\Http\Controllers\Api\TransectionsController::class, 'store']);
//     Route::get('transections', [\App\Http\Controllers\Api\TransectionsController::class, 'index']);
//     // Add other routes as needed
// });

// route post eDahab controller
Route::post('edahab', [\App\Http\Controllers\Api\eDahab::class, 'createInvoiceAsync']);
Route::post('edahabcredit', [\App\Http\Controllers\Api\eDahab::class, 'CreditMoney']);
// Route::get('edahab', [\App\Http\Controllers\Api\eDahab::class, 'createInvoiceAsync']);
// Route::get('edahab', [\App\Http\Controllers\Api\eDahab::class, 'creditAccount']);
// // Route::post('edahab', [\App\Http\Controllers\Api\eDahab::class, 'creditAccount']);

// // route post waafiController
// Route::post("zaad", [\App\Http\Controllers\WaafiController::class, 'handleWaafiRequest']);

// route transection controller
// Route::post('transections', [\App\Http\Controllers\Api\TransectionsController::class, 'store']);
// Route::get('transections', [\App\Http\Controllers\Api\TransectionsController::class, 'index']);


// Apply auth middleware to routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
    // Your authenticated routes go here
    Route::post('/credit-money', 'WaafiApi@creditMoney');
    Route::post('/pay-with-zaad', 'WaafiApi@payWithZaad');
    Route::post('transections', [\App\Http\Controllers\Api\TransectionsController::class, 'store']);
    Route::get('transections', [\App\Http\Controllers\Api\TransectionsController::class, 'index']);
});

// // Non-authenticated routes
// Route::post('/non-authenticated-route', 'WaafiApi@index');

// Route::middleware('auth')->group(function () {
//     // Your authenticated routes go here
//     Route::resource('/transections', 'TransectionsController');
// });

// cross transfer request

Route::post('request', [\App\Http\Controllers\Api\cros_transfer_requests::class, 'store']);
Route::get('request', function () {
    // Your logic goes here
    // Example: return a response
    return response()->json(['message' => 'Hello from the "request" route']);
});

// wallets
Route::prefix('wallets')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\WalletsController::class, 'index']);
    Route::get('/{userId}', [\App\Http\Controllers\Api\WalletsController::class, 'show']);
    Route::post('/{userId}', [\App\Http\Controllers\Api\WalletsController::class, 'store']);
    Route::put('/{walletId}', [\App\Http\Controllers\Api\WalletsController::class, 'update']);
    Route::delete('/{walletId}', [\App\Http\Controllers\Api\WalletsController::class, 'destroy']);
});




// User Profile Routes
// Route::get('user-profiles', [\App\Http\Controllers\Api\UserProfileController::class, 'index']);
// Route::post('user-profiles', [\App\Http\Controllers\Api\UserProfileController::class, 'store']);
Route::post('user_register', [\App\Http\Controllers\Api\UserProfileController::class, 'register']);
Route::post('user_login', [\App\Http\Controllers\Api\UserProfileController::class, 'login']);
// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('user-profiles', [\App\Http\Controllers\Api\UserProfileController::class, 'store']);
//     Route::get('user-profiles', [\App\Http\Controllers\Api\UserProfileController::class, 'index']);
//     // Route::get('user-profiles/{userId}', [\App\Http\Controllers\Api\UserProfileController::class, 'authUser']);
//     Route::put('user-profiles/{userId}', [\App\Http\Controllers\Api\UserProfileController::class, 'update']);
//     Route::delete('user-profiles/{userId}', [\App\Http\Controllers\Api\UserProfileController::class, 'destroy']);
//     Route::post('user_logout', [\App\Http\Controllers\Api\UserProfileController::class, 'logout']);
// });
// Route::get('user_user', [\App\Http\Controllers\Api\UserProfileController::class, 'authUser']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user_user', [\App\Http\Controllers\Api\UserProfileController::class, 'authUser']);
    });
// Wallets Profile Routes
Route::get('wallets-profiles', [\App\Http\Controllers\Api\WalletsProfileController::class, 'index']);
Route::post('wallets-profiles', [\App\Http\Controllers\Api\WalletsProfileController::class, 'store']);

// Notifications Routes
Route::get('notifications', [\App\Http\Controllers\Api\NotificationsController::class, 'index']);
Route::post('notifications', [\App\Http\Controllers\Api\NotificationsController::class, 'store']);

// Orders Routes
Route::get('orders', [\App\Http\Controllers\Api\OrdersController::class, 'index']);
Route::post('orders', [\App\Http\Controllers\Api\OrdersController::class, 'store']);

// User Wallet Accounts Routes
Route::middleware('auth:sanctum')->group(function () {
Route::get('user-wallet-accounts', [\App\Http\Controllers\Api\UserWalletAccountsController::class, 'index']);
Route::post('user-wallet-accounts', [\App\Http\Controllers\Api\UserWalletAccountsController::class, 'store']);
});
// Bridge Fee Routes
Route::get('bridge-fees', [\App\Http\Controllers\Api\BridgeFeeController::class, 'index']);
Route::post('bridge-fees', [\App\Http\Controllers\Api\BridgeFeeController::class, 'store']);