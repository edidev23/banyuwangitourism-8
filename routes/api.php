<?php

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

Route::get('/', [App\Http\Controllers\Api\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\Api\HomeController::class, 'home']);
Route::get('/news', [App\Http\Controllers\Api\NewsController::class, 'index']);
Route::get('/festival/detail/{slug}', [App\Http\Controllers\Api\FestivalController::class, 'detail']);

//ready for connection flutter
Route::get('/destination', [App\Http\Controllers\Api\DestinationController::class, 'index']);
Route::get('/destination/search', [App\Http\Controllers\Api\DestinationController::class, 'search']);
Route::get('/destination/{id}', [App\Http\Controllers\Api\DestinationController::class, 'detail']);
Route::get('/destination-tiket/{id}', [App\Http\Controllers\Api\DestinationController::class, 'tiketDestination']);

//booking destination
Route::get('/destination/booking-by-user/{user_id}', [App\Http\Controllers\Api\DestinationController::class, 'bookingByUser']);
Route::post('/destination/booking', [App\Http\Controllers\Api\DestinationController::class, 'booking']);

Route::post("midtrans/callback", [App\Http\Controllers\Api\MidtransController::class, 'callback']);

//USER
Route::get('/users', [App\Http\Controllers\Api\UserController::class, 'index']);
Route::get('/user/{id}', [App\Http\Controllers\Api\UserController::class, 'userById']);
Route::get('/user-by-email/{email}', [App\Http\Controllers\Api\UserController::class, 'userByEmail']);

Route::post('/user', [App\Http\Controllers\Api\UserController::class, 'store']);
Route::put('/user/{id}', [App\Http\Controllers\Api\UserController::class, 'update']);

//only test
Route::get('/test/destination', [App\Http\Controllers\Api\DestinationController::class, 'testIndex']);

// for vue
Route::get('/produk-ppkm', [App\Http\Controllers\Api\ProdukPpkmController::class, 'index']);

// khusus android kotlin
Route::post('/list-berita', [App\Http\Controllers\Api\NewsController::class, 'listNews']);
Route::get('/festival-by-month/{bulan}', [App\Http\Controllers\Api\FestivalController::class, 'index']);
Route::get('/festival/total-by-month', [App\Http\Controllers\Api\FestivalController::class, 'festivalCount']);

// ETAX
Route::get("tax-destination/destination-all", [App\Http\Controllers\Api\DestinationOfflineController::class, 'listDestination']);
Route::get("tax-destination/destination-by-email/{email}", [App\Http\Controllers\Api\DestinationOfflineController::class, 'detailDestination']);

// request admin
Route::get("tax-destination/data-admin/{email}/{android_id}", [App\Http\Controllers\Api\DestinationOfflineController::class, 'getDataAdmin']);
Route::post("tax-destination/request-admin", [App\Http\Controllers\Api\DestinationOfflineController::class, 'requestAdmin']);

// login
Route::post("tax-destination/check-login", [App\Http\Controllers\Api\DestinationOfflineController::class, 'checkLogin']);

Route::get("/tax-destination/get-harga-tiket/{destination_id}", [App\Http\Controllers\Api\DestinationOfflineController::class, 'getHargaTiket']);
Route::post("/tax-destination/update-harga-tiket", [App\Http\Controllers\Api\DestinationOfflineController::class, 'updateTiket']);
Route::post("/tax-destination/create", [App\Http\Controllers\Api\DestinationOfflineController::class, 'booking']);
Route::get("/tax-destination/{destination_id}", [App\Http\Controllers\Api\DestinationOfflineController::class, 'getByDate']);

// gwd
Route::get("/tax-gwd", [App\Http\Controllers\Api\BookingGwdController::class, 'getByDate']);
Route::get("/tax-gwd/get-harga-tiket/{email_admin}", [App\Http\Controllers\Api\BookingGwdController::class, 'getHargaTiket']);
Route::post("/tax-gwd/create", [App\Http\Controllers\Api\BookingGwdController::class, 'booking']);

Route::get('/produk-ppkm/get-all', [App\Http\Controllers\Api\ProdukPpkmController::class, 'getAll']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
