<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SitePageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KhutStoryController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\WishlistController;

//use for server imgage-view
use Illuminate\Support\Facades\Response;
//use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

Route::get('/stock/{sku}', [StockController::class, 'getStock']);
Route::get('/product/{id}', [ProductController::class, 'showProduct'])->name('product.show');


//for -image
Route::get('/storage/{folder}/{filename}', function ($folder, $filename) {
    $path = storage_path("app/public/{$folder}/{$filename}");

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file, 200)->header("Content-Type", $type);
});


Route::get('/log-visitor', [VisitorController::class, 'logVisitor']);
Route::get('/home', [HomeController::class, 'index']);
//Route::get('/', [HomeController::class, 'homeIndex']);
Route::get('/category/New-Arrivals', [HomeController::class, 'newArrivalsProducts'])->name('home.new-arrivals'); 
Route::get('/category/Patchwork', [HomeController::class, 'patchworkProducts'])->name('home.patchwork'); 

Route::get('/menu/{slug}', [SitePageController::class, 'showPage'])->name('site.page');
Route::get('/category/{category}', [ProductController::class, 'list'])->name('category.list');

Route::get('/', [HomeController::class, 'homeIndex'])->name('home');

// Patchwork must come first



Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/subcategory/{id}', [CategoryController::class, 'subCategory'])->name('category.sub');
Route::get('/childcategory/{id}', [CategoryController::class, 'childCategory'])->name('category.child');







Route::get('/khut-stories', [KhutStoryController::class, 'index'])->name('khut-stories.index');
Route::get('/khut-stories/{id}', [KhutStoryController::class, 'show'])->name('khut-stories.show');

// Detail page
Route::get('/khut-stories/details/{id}', [KhutStoryController::class, 'details'])->name('khut-stories.details');


// Shop / All Products
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// Main Category (slug-based)
Route::get('/category/{slug}', [ShopController::class, 'listBySlug'])->name('category.list');

// Sub Category (id-based)
Route::get('/subcategory/{id}', [ShopController::class, 'listById'])->name('subcategory.list');

// Child Category (id-based)
Route::get('/childcategory/{id}', [ShopController::class, 'listById'])->name('childcategory.list');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');


// Ajax call for tab change
Route::get('category/products/{type}/{id}', [CategoryController::class, 'productsByMenu']);


// Main category - by slug
Route::get('/category/{slug}', [CategoryController::class, 'list'])->name('category.list');


// Main Category (slug ভিত্তিক)
//Route::get('/category/{slug}', [CategoryController::class, 'listBySlug'])->name('category.list');

Route::get('/category/{name}', [CategoryController::class, 'list'])->name('category.list');




// Sub Category (id ভিত্তিক)
Route::get('/subcategory/{id}', [CategoryController::class, 'listById'])->name('subcategory.list');

// Child Category (id ভিত্তিক)
Route::get('/childcategory/{id}', [CategoryController::class, 'listById'])->name('childcategory.list');



// All product list by type (e.g. patchwork, new-arrival)
Route::get('/all-products/{type}', [ProductController::class, 'allProductsList'])->name('all.products.list');

// Product details
Route::get('/product/{slug}', [ProductController::class, 'details'])->name('product.details');
//for product details
Route::get('/product-details/{slug}', [ProductController::class, 'details'])->name('product.details');

Route::get('/menu-products/{slug}', [ProductController::class, 'menuProducts'])->name('menu.products');


Route::get('/search', [SearchController::class, 'search'])->name('search');


//cart route
Route::get('/chart', function () {
    return view('chart.index');
})->name('chart.index');












// Customer Login Page Route





// Login & Registration
Route::get('/customer-login', [CustomerAuthController::class, 'loginForm'])->name('customer.login');
Route::post('/customer-login', [CustomerAuthController::class, 'login'])->name('customer.login.submit');
Route::post('/customer-register', [CustomerAuthController::class, 'register'])->name('customer.register');

// Public route for viewing order details (accessible after payment without login)
Route::get('/customer/order-details/{id}', [CustomerAuthController::class, 'orderDetails'])
    ->name('customer.order.details');

Route::middleware('auth:customer')->group(function() {
    Route::get('/customer-login/profile', [CustomerAuthController::class, 'profile'])->name('customer.profile');

   // Route::get('/customer-login/profile', [CustomerAuthController::class, 'profileForm'])->name('customer.profile');
    Route::post('/customer-login/profile', [CustomerAuthController::class, 'updateProfile'])->name('customer.profile.update');
    Route::post('/customer-login/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
});


// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);
Route::post('/checkout/pay', [SslCommerzPaymentController::class, 'checkoutPayment'])->name('checkout.pay');

Route::match(['get', 'post'], '/success', [SslCommerzPaymentController::class, 'success'])->name('payment.success');
Route::match(['get', 'post'], '/fail', [SslCommerzPaymentController::class, 'fail'])->name('payment.fail');
Route::match(['get', 'post'], '/cancel', [SslCommerzPaymentController::class, 'cancel'])->name('payment.cancel');

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END



Route::get('/wishlist', function () {
    return view('wishlist.index');
})->name('wishlist.page');