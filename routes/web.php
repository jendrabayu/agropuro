<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes([
    'verify' => true
]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/{id}-{slug}', 'ProductController@show')->name('product.show');
Route::get('product', 'ProductController@index')->name('product.index');


Route::middleware(['auth', 'verified'])->group(function () {

    //Forum
    Route::resource('forum', 'ForumController')->except(['index', 'show']);
    Route::put('/forum/solved/{forum}', 'ForumController@solved')->name('forum.solved');

    //profile setting fol all
    Route::prefix('profile-setting')->name('profile-setting.')->group(function () {
        Route::get('/', 'UserController@index')->name('index');
        Route::put('/{user}', 'UserController@update')->name('update');
    });

    //Planting Schedule
    Route::resource('planting-schedule', 'PlantingScheduleController');

    //Planting Schedule Detail
    Route::prefix('planting-schedule-detail')->name('planting-schedule-detail.')->group(function () {
        Route::get('/is-done', 'PlantingScheduleDetailController@isDone')->name('is-done');
        Route::post('/', 'PlantingScheduleDetailController@store')->name('store');
        Route::delete('/{id}', 'PlantingScheduleDetailController@destroy')->name('destroy');
    });

    Route::middleware('role:user')->group(function () {
        Route::resource('/cart', 'CartController')->except(['show', 'edit', 'update', 'store']);
        Route::put('/cart', 'CartController@update')->name('cart.update');
        Route::post('/cart/{product}', 'CartController@store')->name('cart.store');
        Route::get('/checkout', 'CheckoutController')->name('checkout');
    });

    //Customer
    Route::namespace('User')->prefix('customer')->name('customer.')->middleware(['role:user'])->group(function () {
        Route::resource('/address', 'AddressController')->except(['show']);
        Route::put('/address/setmain/{address}', 'AddressController@setIsMain')->name('address.setmain');
        Route::get('/address/cities/{id}', 'AddressController@cities')->name('address.cities');
        Route::resource('/order', 'OrderController')->except(['show']);
        Route::get('/order/detail/{order:invoice}', 'OrderController@show')->name('order.detail');
        Route::post('/order/add-payment-proof/{invoice}', 'OrderController@storePaymentProof')->name('order.add-payment-proof');
    });

    //Admin
    Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');

        //Forum Category
        Route::resource('forum-category', 'ForumCategoryController')->except(['show', 'edit']);

        //Order
        Route::prefix('order')->name('order.')->group(function () {
            Route::get('/', 'OrderController@index')->name('index');
            Route::get('/detail/{invoice}', 'OrderController@detail')->name('detail');
            Route::get('/order-is-done/{invoice}', 'OrderController@orderIsDone')->name('order-is-done');
            Route::post('/payment-is-confirmed/{invoice}', 'OrderController@paymentIsConfirmed')->name('payment-is-confirmed');
            Route::post('/order-is-canceled/{invoice}', 'OrderController@orderIsCanceled')->name('order-is-canceled');
            Route::post('/add-tracking-code/{invoice}', 'OrderController@addTrackingCode')->name('add-tracking-code');
        });

        //Product category
        Route::resource('category', 'CategoryController')->except(['create', 'edit', 'show']);

        //Bank Account For Shop
        Route::resource('bank-account', 'BankAccountController')->except(['create', 'show', 'edit']);

        //Shop Address
        Route::get('/shop-address/cities/{id}', 'ShopAddressController@cities');
        Route::get('/shop-address', 'ShopAddressController@edit')->name('shop-address');
        Route::resource('shop-address', 'ShopAddressController')->only(['store', 'update']);

        //Produk
        Route::resource('product', 'ProductController')->except('show');
        Route::put('product/archived/{product}', 'ProductController@setArchived')->name('product.set_archived');

        //Customer
        Route::get('customer', 'CustomerController')->name('customer');

        //Recap
        Route::get('recap', 'OrderController@recap')->name('recap');
        Route::post('recap', 'OrderController@recapData')->name('recap.ajax');
    });
});


//Forum comment or answer
Route::name('forum.comment.')->prefix('forum/comment')->group(function () {
    Route::get('/{forumComment}', 'ForumCommentController@edit')->name('edit');
    Route::post('/{forum}', 'ForumCommentController@store')->name('store');
    Route::put('/{forumComment}', 'ForumCommentController@update')->name('update');
    Route::delete('/{forumComment}', 'ForumCommentController@destroy')->name('destroy');
});

//Forum
Route::resource('forum', 'ForumController')->only(['index', 'show']);
//Ajax Data
Route::get('/ajax/cities/{id}', 'AjaxController@cities')->name('ajax.cities');
