<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// admin
Route::get('/login', [App\Http\Controllers\Backend\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Backend\Auth\LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [App\Http\Controllers\Backend\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/403', [App\Http\Controllers\Backend\Auth\LoginController::class, 'forbidden']);

Route::get('/', function () {
    return view('welcome');
});

// pimpinan
Route::middleware('auth', 'checkRole:pimpinan')->prefix('admin')->group(function () {
    // tiket gwd
    Route::get('/laporan-tiket-gwd', [App\Http\Controllers\Backend\Destination\DestinationBookingController::class, 'laporanGwdPimpinan']);
});


// role admin, content, operator
Route::middleware('auth', 'checkRole:admin,content,content-geopark,operator,pimpinan')->prefix('admin')->group(function () {
    // Home
    Route::get('/', [App\Http\Controllers\Backend\HomeController::class, 'index']);
    // users
    Route::get('users/change-password', [App\Http\Controllers\Backend\UsersController::class, 'change_password']);
    Route::put('users/change-password/{user}', [App\Http\Controllers\Backend\UsersController::class, 'update_password']);
});

// role admin, content
Route::middleware('auth', 'checkRole:admin,content')->prefix('admin')->group(function () {
    // destination
    Route::resource('/destination', App\Http\Controllers\Backend\DestinationController::class);
    Route::resource('/destination-category', App\Http\Controllers\Backend\DestinationCategoryController::class);
    Route::post('/destination/image-cropper/upload', [App\Http\Controllers\Backend\DestinationController::class, 'upload']);
    Route::get('destination/status/{id}/{status}', [App\Http\Controllers\Backend\DestinationController::class, 'status']);
    // festival
    Route::resource('festival', App\Http\Controllers\Backend\FestivalController::class);
    Route::get('festival/change-best-festival/{id}/{status}', [App\Http\Controllers\Backend\FestivalController::class, 'changeBestFestival']);
    Route::post('festival/image-cropper/upload', [App\Http\Controllers\Backend\FestivalController::class, 'upload']);
    // culinary
    Route::resource('culinary', App\Http\Controllers\Backend\CulinaryController::class);
    Route::post('culinary/image-cropper/upload', [App\Http\Controllers\Backend\CulinaryController::class, 'upload']);
    // handcraft
    Route::resource('handcraft', App\Http\Controllers\Backend\HandcraftController::class);
    Route::post('handcraft/image-cropper/upload', [App\Http\Controllers\Backend\HandcraftController::class, 'upload']);
    // produk ppkm
    Route::resource('produk_ppkm', App\Http\Controllers\Backend\ProdukPpkmController::class);
    Route::post('produk_ppkm/image-cropper/upload', [App\Http\Controllers\Backend\ProdukPpkmController::class, 'upload']);
    // news
    Route::resource('news', App\Http\Controllers\Backend\NewsController::class);
    Route::post('news/image-cropper/upload', [App\Http\Controllers\Backend\NewsController::class, 'upload']);
    // hotline
    Route::resource('hotline', App\Http\Controllers\Backend\HotlineController::class);
    Route::post('hotline/image-cropper/upload', [App\Http\Controllers\Backend\HotlineController::class, 'upload']);
});

// role admin, operator
Route::middleware('auth', 'checkRole:admin,operator')->prefix('admin')->group(function () {
    // destination ticket
    Route::get('destination-booking', [App\Http\Controllers\Backend\Destination\DestinationBookingController::class, 'index']);
    // etax offline
    Route::get('laporan-tiket-harian', [App\Http\Controllers\Backend\Destination\DestinationBookingController::class, 'allBookingOffline']);
    Route::get('list-tiket', [App\Http\Controllers\Backend\Destination\DestinationBookingController::class, 'dataTiketOffline']);
    Route::delete('delete-tiket-offline/{id}', [App\Http\Controllers\Backend\Destination\DestinationBookingController::class, 'deleteTiketOffline']);
    // gwd
    Route::get('booking-gwd', [App\Http\Controllers\Backend\Destination\DestinationBookingController::class, 'allBookingGwd']);
    Route::get('booking-gwd/list-tiket', [App\Http\Controllers\Backend\Destination\DestinationBookingController::class, 'listTiketGwd']);
    Route::delete('booking-gwd/delete/{id}', [App\Http\Controllers\Backend\Destination\DestinationBookingController::class, 'deleteTiketGwd']);

    Route::get('harga-tiket-gwd', [App\Http\Controllers\Backend\Destination\DestinationBookingController::class, 'hargaTiketGwd']);
    Route::put('harga-tiket-gwd', [App\Http\Controllers\Backend\Destination\DestinationBookingController::class, 'saveHargaTiketGwd']);

    Route::get('destination-user/{id}', [App\Http\Controllers\Backend\Destination\DestinationUserController::class, 'index']);
    Route::get('destination-tiket/{id}', [App\Http\Controllers\Backend\Destination\DestinationTiketController::class, 'index']);
    Route::put('destination-tiket/{id}', [App\Http\Controllers\Backend\Destination\DestinationTiketController::class, 'update']);

      // admin etax 
      Route::resource('admin-etax', App\Http\Controllers\Backend\Destination\AdminEtaxController::class);
      Route::get('admin-etax/status/{id}/{status}', [App\Http\Controllers\Backend\Destination\AdminEtaxController::class, 'status']);
      Route::get('setting-kuota', [App\Http\Controllers\Backend\Destination\AdminEtaxController::class, 'settingKuota']);
      Route::put('setting-kuota', [App\Http\Controllers\Backend\Destination\AdminEtaxController::class, 'updateKuota']);
      
      Route::get('kelola-admin-etax', [App\Http\Controllers\Backend\Destination\AdminEtaxController::class, 'kelolaAdmin']);
      Route::get('kelola-admin-etax/status/{id}/{status}', [App\Http\Controllers\Backend\Destination\AdminEtaxController::class, 'kelolaStatusAdmin']);
      Route::delete('kelola-admin-etax/{id}', [App\Http\Controllers\Backend\Destination\AdminEtaxController::class, 'deleteAdmin']);
  
      Route::get('tracking-admin-etax', [App\Http\Controllers\Backend\Destination\AdminEtaxController::class, 'trackingUser']);
      Route::get('tracking-admin-etax/status/{id}/{status}', [App\Http\Controllers\Backend\Destination\AdminEtaxController::class, 'statusAktif']);
      Route::get('tracking-admin-etax/status-login/{id}/{status}', [App\Http\Controllers\Backend\Destination\AdminEtaxController::class, 'statusLogin']);

    // festival ticket
    Route::resource('festival-booking/price', App\Http\Controllers\Backend\FestivalBooking\PriceController::class);
    Route::get('festival-booking/price/fee/{id}/{fee}', [App\Http\Controllers\Backend\FestivalBooking\PriceController::class, 'fee']);
    Route::resource('festival-booking/transaction', App\Http\Controllers\Backend\FestivalBooking\TransactionController::class);
});

// geopark only
Route::middleware('auth', 'checkRole:content-geopark')->prefix('admin')->group(function () {
    // destination
    Route::resource('geopark-destination', App\Http\Controllers\Backend\GeoparkDestinationController::class);
    Route::post('/geopark-destination/image-cropper/upload', [App\Http\Controllers\Backend\GeoparkDestinationController::class, 'upload']);
});

// only admin
Route::middleware('auth', 'checkRole:admin')->prefix('admin')->group(function () {
    // language
    Route::resource('language', App\Http\Controllers\Backend\LanguageController::class);
    Route::get('language/status/{id}/{status}', [App\Http\Controllers\Backend\LanguageController::class, 'status']);
    // users
    Route::resource('users', App\Http\Controllers\Backend\UsersController::class);
    Route::post('users/image-cropper/upload', [App\Http\Controllers\Backend\UsersController::class, 'upload']);
});

// front end
Route::get('', [App\Http\Controllers\FrontEndController::class, 'index']);
Route::get('festival/{slug}', [App\Http\Controllers\FrontEndController::class, 'detail_festival']);
Route::get('festival', [App\Http\Controllers\FrontEndController::class, 'festival']);
Route::get('destination/{slug}', [App\Http\Controllers\FrontEndController::class, 'detail_destination']);
Route::get('destination', [App\Http\Controllers\FrontEndController::class, 'destination']);
Route::get('culinary/{slug}', [App\Http\Controllers\FrontEndController::class, 'detail_culinary']);
Route::get('culinary', [App\Http\Controllers\FrontEndController::class, 'culinary']);
Route::get('handcraft/{slug}', [App\Http\Controllers\FrontEndController::class, 'detail_handcraft']);
Route::get('handcraft', [App\Http\Controllers\FrontEndController::class, 'handcraft']);
Route::get('news/{slug}', [App\Http\Controllers\FrontEndController::class, 'detail_news']);
Route::get('news', [App\Http\Controllers\FrontEndController::class, 'news']);
Route::get('get-apps', [App\Http\Controllers\FrontEndController::class, 'get_apps']);
Route::get('produk_ppkm', [App\Http\Controllers\FrontEndController::class, 'produk_ppkm']);

Route::get('geopark', [App\Http\Controllers\FrontEndController::class, 'geopark']);
Route::get('geopark/{slug}', [App\Http\Controllers\FrontEndController::class, 'detail_geopark']);

Route::get('midtrans/success', [App\Http\Controllers\Api\MidtransController::class, 'success']);
Route::get('midtrans/unfinish', [App\Http\Controllers\Api\MidtransController::class, 'unfinish']);
Route::get('midtrans/error', [App\Http\Controllers\Api\MidtransController::class, 'error']);

