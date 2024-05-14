<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChackoutController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncruadController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PassresetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestApiController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//__forntend controller__//
Route::get('/',[FrontendController::class,'index'])->name('index');
Route::get('/product/single/{slug}',[FrontendController::class,'product_single'])->name('product.single');
Route::post('/getsize',[FrontendController::class,'getsize']);
Route::post('/getquantity',[FrontendController::class,'getquantity']);
Route::get('/shop',[FrontendController::class,'shop'])->name('shop');
Route::get('/resent/view',[FrontendController::class,'resent_view'])->name('resent.view');

//__include page __//
Route::get('/subcategories/{id}',[IncruadController::class,'subcategories'])->name('subcategories');
Route::get('/ban_product/{id}',[IncruadController::class,'ban_product'])->name('ban_product');
Route::get('/categories/{id}',[IncruadController::class,'categories'])->name('categories');
Route::get('/upcomming/shop/{id}',[IncruadController::class,'upcomming_shop'])->name('upcomming.shop');
Route::get('/new_offer/{id}',[IncruadController::class,'new_offer'])->name('new_offer');
Route::get('/product/all/item',[IncruadController::class,'product_all_item'])->name('product.all.item');
Route::get('/offer/font/{id}',[IncruadController::class,'offer_font'])->name('offer.font');
Route::get('/tag/product/{id}',[IncruadController::class,'tag_product'])->name('tag.product');

//__ Customer controller__//
Route::get('/customer/login',[CustomerController::class,'customer_login'])->name('customer.login');
Route::get('/customer/register',[CustomerController::class,'customer_register'])->name('customer.register');
Route::post('/customer/store',[CustomerController::class,'customer_store'])->name('customer.store');
Route::post('/customer/logged',[CustomerController::class,'customer_logged'])->name('customer.logged');
Route::get('/customer/email/varify/{token}',[CustomerController::class,'customer_email_varify'])->name('customer.email.varify');
Route::get('/email/varification/reset',[CustomerController::class,'email_varification_reset'])->name('email.varification.reset');
Route::post('/email/varification/reset',[CustomerController::class,'email_resed_request'])->name('email.resed.request');
Route::get('/reload-captcha', [CustomerController::class, 'reloadCaptcha']);


//customer forget password
Route::get('/forgot/password',[PassresetController::class,'forgot_password'])->name('forgot.password');
Route::post('/password/reset/request',[PassresetController::class,'password_reset_request'])->name('password.reset.request');
Route::get('/password/reset/form/{token}',[PassresetController::class,'password_reset_form'])->name('password.reset.form');
Route::post('/password/reset/form/succ/{token}',[PassresetController::class,'password_reset_form_succ'])->name('password.reset.form.succ');

//__Customer profile__//
Route::middleware('customer')->group(function () {
    Route::get('/customer/profile', [CustomerProfileController::class, 'customer_profile'])->name('customer.profile');
    Route::get('/customer/edit/profile', [CustomerProfileController::class, 'customer_edit_profile'])->name('customer.edit.profile');
    Route::post('/customer/update/profile', [CustomerProfileController::class, 'customer_update_profile'])->name('customer.update.profile');
    Route::get('/cusomer/order',[CustomerProfileController::class,'cusomer_order'])->name('cusomer.order');
    Route::get('/cusomer/wishlist',[CustomerProfileController::class,'cusomer_wishlist'])->name('cusomer.wishlist');
    Route::get('/cusomer/password',[CustomerProfileController::class,'cusomer_password'])->name('cusomer.password');
    Route::get('/customer/logout',[CustomerProfileController::class,'customer_logout'])->name('customer.logout');
    Route::get('/download/invoice/{id}',[CustomerProfileController::class,'download_invoice'])->name('download.invoice');
    Route::post('/customer/password',[CustomerProfileController::class,'customer_update_password'])->name('customer.update.password');
});

//__Customer cancel order__//
Route::middleware('auth')->group(function () {
    Route::get('/cancel/order/{id}',[OrdersController::class,'cancel_order'])->name('cancel.order');
    Route::post('/order/status/update/{id}',[OrdersController::class,'order_status_update'])->name('order.status.update');
    Route::get('/return/product/{id}',[OrdersController::class,'return_product'])->name('return.product');
    Route::post('/return/product/store',[OrdersController::class,'return_product_store'])->name('return.product.store');
});

//__Customer cart__//
Route::middleware('customer')->group(function () {
    Route::post('/cart/store', [CartController::class, 'cart_store'])->name('cart.store');
    Route::get('/cart/remove/{id}',[CartController::class,'cart_remove'])->name('cart.remove');
    Route::get('/wishlist/remove/{id}',[CartController::class,'wishlist_remove'])->name('wishlist.remove');
    Route::get('/wishlist',[CartController::class,'wishlist'])->name('wishlist');
    Route::get('/cart',[CartController::class,'cart'])->name('cart');
    Route::post('/cart/update',[CartController::class,'cart_update'])->name('cart.update');
});

//__Customer cart__//
Route::middleware('customer')->group(function () {
    Route::get('/checkout', [ChackoutController::class,'checkout'])->name('checkout');
    Route::post('/getcheckoutcity', [ChackoutController::class,'getcheckoutcity']);
    Route::post('/checkout/store', [ChackoutController::class,'checkout_store'])->name('checkout.store');
    Route::get('/order/success', [ChackoutController::class,'order_success'])->name('order.success');
});




//__Home controller__//
Route::get('/dashboard',[HomeController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//__user Controller__//
Route::middleware('auth')->group(function () {
    Route::get('/user/profile',[UserController::class,'user_profile'])->name('user.profile');
    Route::get('/user/profile/edit',[UserController::class,'user_profile_edit'])->name('user.profile.edit');
    Route::post('/user/info/update',[UserController::class,'user_info_update'])->name('user.info.update');
    Route::post('/getusercity',[UserController::class,'getusercity']);
    Route::post('/user/password/update',[UserController::class,'user_password_update'])->name('user.password.update');
    Route::post('/socile/store',[UserController::class,'socile_store'])->name('socile.store');
    Route::get('/socile/delete/{id}',[UserController::class,'socile_delete'])->name('socile.delete');
    Route::post('/cover_photo/update',[UserController::class,'cover_photo_update'])->name('cover_photo.update');
    Route::post('/photo_photo/update',[UserController::class,'photo_photo_update'])->name('photo_photo.update');
});

//__category Controller__//
Route::middleware('auth')->group(function () {
    Route::get('/category/list',[CategoryController::class,'category_list'])->name('category.list');
    Route::post('/add/category',[CategoryController::class,'add_category'])->name('add.category');
    Route::post('/category/update/{id}',[CategoryController::class,'category_update'])->name('category.update');
    Route::get('/category/soft/delete/{id}',[CategoryController::class,'category_soft_delete'])->name('category.soft.delete');
    Route::get('/trashed/category',[CategoryController::class,'trashed_category'])->name('trashed.category');
    Route::get('/category/restore/{id}',[CategoryController::class,'category_restore'])->name('category.restore');
    Route::get('/category/delete/{id}',[CategoryController::class,'category_delete'])->name('category.delete');
});

//__category Controller__//
Route::middleware('auth')->group(function () {
    Route::get('/subcategory/list',[SubcategoryController::class,'subcategory_list'])->name('subcategory.list');
    Route::post('/subcategory/store',[SubcategoryController::class,'subcategory_store'])->name('subcategory.store');
    Route::post('/subcategory/update/{id}',[SubcategoryController::class,'subcategory_update'])->name('subcategory.update');
    Route::get('/subcategory/soft/delete/{id}',[SubcategoryController::class,'subcategory_soft_delete'])->name('subcategory.soft.delete');
    Route::get('/trashed/subcategory',[SubcategoryController::class,'trashed_subcategory'])->name('trashed.subcategory');
    Route::get('/subcategory/restore/{id}',[SubcategoryController::class,'subcategory_restore'])->name('subcategory.restore');
    Route::get('/subcategory/delete/{id}',[SubcategoryController::class,'subcategory_delete'])->name('subcategory.delete');
});

//__brand Controller__//
Route::middleware('auth')->group(function () {
    Route::get('/brand/list',[BrandController::class,'brand_list'])->name('brand.list');
    Route::post('/brand/store',[BrandController::class,'brand_store'])->name('brand.store');
    Route::post('/brand/update/{id}',[BrandController::class,'brand_update'])->name('brand.update');
    Route::get('/brand/delete/{id}',[BrandController::class,'brand_delete'])->name('brand.delete');
});

//__tag Controller__//
Route::middleware('auth')->group(function () {
    Route::get('/tag',[TagController::class,'tag'])->name('tag');
    Route::post('/tag./store',[TagController::class,'tag_store'])->name('tag.store');
    Route::get('/tag/delete/{id}',[TagController::class,'tag_delete'])->name('tag.delete');
});

//__product Controller__//
Route::middleware('auth')->group(function () {
    Route::get('/product',[ProductController::class,'product'])->name('product');
    Route::post('/getsubcategory',[ProductController::class,'getsubcategory']);
    Route::post('/getproductstatus',[ProductController::class,'getproductstatus']);
    Route::post('/getupcommingproductstatus',[ProductController::class,'getupcommingproductstatus']);
    Route::post('/product/store',[ProductController::class,'product_store'])->name('product.store');
    Route::get('/product/list',[ProductController::class,'product_list'])->name('product.list');
    Route::get('/product/delete/{id}',[ProductController::class,'product_delete'])->name('product.delete');
});

//__color Controller__//
Route::middleware('auth')->group(function () {
    Route::get('/color',[InventoryController::class,'color'])->name('color');
    Route::post('/color/store',[InventoryController::class,'color_store'])->name('color.store');
    Route::post('/size/store',[InventoryController::class,'size_store'])->name('size.store');
    Route::get('/inventory/list/{id}',[InventoryController::class,'inventory_list'])->name('inventory.list');
    Route::post('/inventory/store',[InventoryController::class,'inventory_store'])->name('inventory.store');
});

//banner part
Route::middleware('auth')->group(function () {
    Route::get('/banner', [BannerController::class, 'banner'])->name('banner');
    Route::post('/banner/store', [BannerController::class, 'banner_store'])->name('banner.store');
    Route::get('/banner/delete/{id}', [BannerController::class, 'banner_delete'])->name('banner.delete');
});

//offer
Route::middleware('auth')->group(function () {
    Route::get('/offer', [OfferController::class, 'offer'])->name('offer');
    Route::post('/upcomming/update', [OfferController::class, 'upcomming_update'])->name('upcomming.update');
    Route::post('/new_offer/{id}', [OfferController::class, 'newoffer_update'])->name('newoffer.update');
    Route::post('/offer/update/{id}', [OfferController::class, 'offer_update'])->name('offer.update');
});

//offer
Route::middleware('auth')->group(function () {
    Route::get('/deal/of/day', [DealController::class, 'deal_of_day'])->name('deal.of.day');
    Route::post('/deal/store', [DealController::class, 'deal_store'])->name('deal.store');
});

//offer
Route::middleware('auth')->group(function () {
    Route::get('/subscriber/ban', [SubscriberController::class, 'subscriber_ban'])->name('subscriber.ban');
    Route::post('/subscribe/update/{id}', [SubscriberController::class, 'subscribe_update'])->name('subscribe.update');
    Route::post('/subscriber/store', [SubscriberController::class, 'subscriber_store'])->name('subscriber.store');
});

//coupon
Route::middleware('auth')->group(function () {
    Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
    Route::post('/coupon/store', [CouponController::class, 'coupon_store'])->name('coupon.store');
    Route::get('/coupon/delete/{id}', [CouponController::class, 'coupon_delete'])->name('coupon.delete');
    Route::post('/getcouponctstatus', [CouponController::class, 'getcouponctstatus']);
});

//delivery
Route::middleware('auth')->group(function () {
    Route::get('/delivery', [DeliveryController::class, 'delivery'])->name('delivery');
    Route::post('/delivery/update', [DeliveryController::class, 'delivery_update'])->name('delivery.update');
});

//review & comment
Route::post('/review/store/{id}',[FrontendController::class,'review_store'])->name('review.store');

// SSLCOMMERZ Start
Route::get('/pay', [SslCommerzPaymentController::class, 'index'])->name('sslpay');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


//stripe start
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe')->name('stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});
//stripe end


//==========Rest API Controller============//
Route::get('/api/cat', [RestApiController::class, 'api_cat']);
Route::get('/api/customer', [RestApiController::class, 'api_customer']);
