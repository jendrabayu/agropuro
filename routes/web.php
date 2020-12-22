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
    Route::put('forum/solved/{forum}', 'ForumController@solved')->name('forum.solved');

    //Account Settings
    Route::get('accountsetting', 'UserController@index')->name('accountsetting.index');
    Route::put('accountsetting/{user}', 'UserController@update')->name('accountsetting.update');

    //Planting Schedule
    Route::resource('plantingschedule', 'PlantingScheduleController');

    //Planting Schedule Detail
    Route::prefix('plantingscheduledetail')->name('plantingscheduledetail.')->group(function () {
        Route::get('/isdone', 'PlantingScheduleDetailController@isDone')->name('is_done');
        Route::get('/{id}/edit', 'PlantingScheduleDetailController@edit')->name('edit');
        Route::post('/', 'PlantingScheduleDetailController@store')->name('store');
        Route::put('/{id}', 'PlantingScheduleDetailController@update')->name('update');
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

        Route::resource('order', 'OrderController')->except(['show']);
        Route::get('order/show/{id}-{invoice}', 'OrderController@show')->name('order.show');
        Route::get('order/{id}/orderdone', 'OrderController@isDone')->name('order.is_done');
        Route::post('order/addpaymentproof/{id}', 'OrderController@addPaymentProof')->name('order.add_payment_proof');
    });

    //Admin
    Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/', 'DashboardController')->name('dashboard');

        //Forum Category
        Route::resource('forum-category', 'ForumCategoryController')->except(['show', 'edit']);

        //Order
        Route::prefix('order')->name('order.')->group(function () {
            Route::get('/', 'OrderController@index')->name('index');
            Route::get('orderdone/{id}', 'OrderController@orderIsDone')->name('order_done');
            Route::get('show/{id}-{invoice}', 'OrderController@show')->name('show');
            Route::post('trackingcode/{id}', 'OrderController@addTrackingCode')->name('add_tracking_code');
            Route::post('ordercanceled/{id}', 'OrderController@orderIsCanceled')->name('order_canceled');
            Route::put('trackingcode/{id}', 'OrderController@updateTrackingCode')->name('update_tracking_code');
            Route::put('paymentconfirmed/{id}', 'OrderController@paymentIsConfirmed')->name('payment_confirmed');
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
