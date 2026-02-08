<?php


use App\Http\Controllers\HomeController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\MainMenuController;
use App\Http\Controllers\SubMenuController;
use App\Http\Controllers\ChildMenuController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\BodySizeController;
use App\Http\Controllers\CommonSizeController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SitePageController;
use App\Http\Controllers\SiteMenuController;
use App\Http\Controllers\DryWashController;
use App\Http\Controllers\IronController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\CategoryBannerController;
use App\Http\Controllers\TinyMCEController;
use App\Http\Controllers\KhutStoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Middleware\LoginCheckMiddleware;


//use for server imgage-view
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;


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


Route::post('/tinymce-upload', [TinyMCEController::class, 'upload'])->name('tinymce.upload');

//PDF ROUTE
Route::get('/admin/orders/{id}/pdf', [OrderController::class, 'downloadPdf'])->name('orders.downloadPdf');


//cattegory banner route
Route::get('/category-banner', [CategoryBannerController::class, 'categorrybannerIndex'])->name('category-banner.index')->middleware(LoginCheckMiddleware::class);
Route::post('/khut-bd-admin/public/category-banner/store', [CategoryBannerController::class, 'store'])->name('category-banner.store')->middleware(LoginCheckMiddleware::class);
Route::get('/category-banner/{id}/edit', [CategoryBannerController::class, 'edit'])->name('category-banner.edit')->middleware(LoginCheckMiddleware::class);
Route::post('/category-banner/update', [CategoryBannerController::class, 'update'])->name('category-banner.update')->middleware(LoginCheckMiddleware::class);
Route::delete('/category-banner/{id}', [CategoryBannerController::class, 'destroy'])->name('category-banner.destroy')->middleware(LoginCheckMiddleware::class);




//admin route

Route::get('/admin-login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login')->middleware(LoginCheckMiddleware::class);
Route::post('/admin-login', [AdminLoginController::class, 'login'])->middleware(LoginCheckMiddleware::class);
Route::get('/admin-logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
Route::post('/onlogin', [\App\Http\Controllers\AdminLoginController::class, 'login']);


//home section route
Route::get('/', [HomeController::class, 'homeIndex'])->middleware(LoginCheckMiddleware::class);
Route::get('/admin/dashboard', [HomeController::class, 'homeIndex'])->name('admin.dashboard')->middleware(LoginCheckMiddleware::class);

//visitor section route
Route::get('/visitor', [VisitorController::class, 'visitorIndex'])->middleware(LoginCheckMiddleware::class);

//gallery section route
Route::get('/media-gallery', [GalleryController::class, 'galleryIndex'])->middleware(LoginCheckMiddleware::class);
Route::post('/uploadGallery', [GalleryController::class, 'uploadGallery'])->middleware(LoginCheckMiddleware::class);
Route::get('/galleryLoadJson', [GalleryController::class, 'galleryLoadJson'])->middleware(LoginCheckMiddleware::class);
Route::get('/galleryLoadJsonById', [GalleryController::class, 'galleryLoadJsonById'])->middleware(LoginCheckMiddleware::class);
Route::post('/galleryImageDelete', [GalleryController::class, 'deleteGalleryImg'])->middleware(LoginCheckMiddleware::class);
Route::post('/upload-gallery-image', [GalleryController::class, 'upload'])->name('upload.gallery.image')->middleware(LoginCheckMiddleware::class);
Route::get('/get-gallery-images', [GalleryController::class, 'getImages'])->middleware(LoginCheckMiddleware::class);

//menu section route (main menu)
Route::get('/menu', [MainMenuController::class, 'menuIndex'])->middleware(LoginCheckMiddleware::class);
Route::post('/menu/store', [MainMenuController::class, 'store'])->middleware(LoginCheckMiddleware::class);
Route::post('/menu/update/{id}', [MainMenuController::class, 'update'])->middleware(LoginCheckMiddleware::class);
Route::delete('/mainmenu/delete/{id}', [MainMenuController::class, 'destroy'])->middleware(LoginCheckMiddleware::class);

//menu section route (sub menu)
Route::post('/submenu/store', [SubMenuController::class, 'store'])->middleware(LoginCheckMiddleware::class);
Route::get('/submenu/by-main/{id}', [SubMenuController::class, 'getByMainMenu'])->middleware(LoginCheckMiddleware::class);
Route::get('/submenu/{id}/edit', [SubMenuController::class, 'edit'])->middleware(LoginCheckMiddleware::class);
Route::get('/submenu/edit/{id}', [SubMenuController::class, 'edit'])->middleware(LoginCheckMiddleware::class);
Route::post('/submenu/update', [SubMenuController::class, 'update'])->middleware(LoginCheckMiddleware::class);
Route::delete('/submenu/delete/{id}', [SubMenuController::class, 'destroy'])->middleware(LoginCheckMiddleware::class);

//menu section route (chiled menu)
Route::post('/childmenu/store', [ChildMenuController::class, 'store'])->middleware(LoginCheckMiddleware::class);
Route::get('/childmenu/by-submenu/{id}', [ChildMenuController::class, 'getChildMenus'])->middleware(LoginCheckMiddleware::class);
Route::get('/childmenu/edit/{id}', [ChildMenuController::class, 'edit'])->middleware(LoginCheckMiddleware::class);
Route::post('/childmenu/update', [ChildMenuController::class, 'update'])->middleware(LoginCheckMiddleware::class);
Route::delete('/childmenu/delete/{id}', [ChildMenuController::class, 'destroy'])->middleware(LoginCheckMiddleware::class);


//color route
Route::get('/color', [ColorController::class, 'colorIndex'])->middleware(LoginCheckMiddleware::class);
Route::post('/colors/store', [ColorController::class, 'store'])->name('color.store')->middleware(LoginCheckMiddleware::class);
Route::put('/colors/update/{id}', [ColorController::class, 'update'])->name('color.update')->middleware(LoginCheckMiddleware::class);
Route::delete('/colors/delete/{id}', [ColorController::class, 'destroy'])->middleware(LoginCheckMiddleware::class);

//iron route
Route::get('/iron', [IronController::class, 'ironIndex'])->middleware(LoginCheckMiddleware::class);
Route::post('/iron/store', [IronController::class, 'store'])->name('iron.store')->middleware(LoginCheckMiddleware::class);
Route::put('/iron/update/{id}', [IronController::class, 'update'])->name('iron.update')->middleware(LoginCheckMiddleware::class);
Route::delete('/iron/delete/{id}', [IronController::class, 'destroy'])->middleware(LoginCheckMiddleware::class);

//dry wash route
Route::get('/dry-wash-page', [DryWashController::class, 'drywashIndex'])->middleware(LoginCheckMiddleware::class);
Route::post('/dry-wash-page/store', [DryWashController::class, 'store'])->name('drywash.store')->middleware(LoginCheckMiddleware::class);
Route::put('/dry-wash-page/update/{id}', [DryWashController::class, 'update'])->name('drywash.update')->middleware(LoginCheckMiddleware::class);
Route::delete('/dry-wash-page/delete/{id}', [DryWashController::class, 'destroy'])->middleware(LoginCheckMiddleware::class);

//bodysize route
Route::get('/body-size', [BodySizeController::class, 'bodysizeIndex'])->middleware(LoginCheckMiddleware::class);
Route::get('/body-size/all', [BodySizeController::class, 'getAll'])->middleware(LoginCheckMiddleware::class);
Route::post('/body-size/store', [BodySizeController::class, 'store'])->middleware(LoginCheckMiddleware::class);
Route::post('/body-size/update', [BodySizeController::class, 'update'])->middleware(LoginCheckMiddleware::class);
Route::delete('/body-size/delete/{id}', [BodySizeController::class, 'destroy'])->middleware(LoginCheckMiddleware::class);


//commonsize route
Route::get('/common-size', [commonSizeController::class, 'commonsizeIndex'])->middleware(LoginCheckMiddleware::class);
Route::get('/common-size/all', [commonSizeController::class, 'getAll'])->middleware(LoginCheckMiddleware::class);
Route::post('/common-size/store', [commonSizeController::class, 'store'])->middleware(LoginCheckMiddleware::class);
Route::post('/common-size/update', [commonSizeController::class, 'update'])->middleware(LoginCheckMiddleware::class);
Route::delete('/common-size/delete/{id}', [commonSizeController::class, 'destroy'])->middleware(LoginCheckMiddleware::class);


//status route
Route::get('/status-page', [StatusController::class, 'statusIndex'])->middleware(LoginCheckMiddleware::class);
Route::get('/status-page/all', [StatusController::class, 'getAll'])->middleware(LoginCheckMiddleware::class);
Route::post('/status-page/store', [StatusController::class, 'store'])->middleware(LoginCheckMiddleware::class);
Route::post('/status-page/update', [StatusController::class, 'update'])->middleware(LoginCheckMiddleware::class);
Route::delete('/status-page/delete/{id}', [StatusController::class, 'destroy'])->name('status.delete')->middleware(LoginCheckMiddleware::class);

//product route
Route::get('/add-new-product', [ProductController::class, 'productIndex'])->middleware(LoginCheckMiddleware::class);
Route::post('/product/store', [ProductController::class, 'store'])->name('product.store')->middleware(LoginCheckMiddleware::class);
Route::get('/product-list', [ProductController::class, 'productlistIndex'])->middleware(LoginCheckMiddleware::class);
Route::get('/product-list-data', [ProductController::class, 'productListData'])->middleware(LoginCheckMiddleware::class);
Route::get('/products', [ProductController::class, 'productListIndex'])->name('product.list')->middleware(LoginCheckMiddleware::class);
Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit')->middleware(LoginCheckMiddleware::class);
Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('product.update')->middleware(LoginCheckMiddleware::class);
Route::delete('/product/delete/{id}', [ProductController::class, 'destroy'])->middleware(LoginCheckMiddleware::class);
Route::post('/upload-thumbnails', [ProductController::class, 'uploadThumbnails'])->name('upload.thumbnails');


// api.php
Route::get('/sub-menus/{mainId}', function ($mainId) {return \App\Models\SubMenu::where('main_menu_id', $mainId)->get();})->middleware(LoginCheckMiddleware::class);
Route::get('/child-menus/{subId}', function ($subId) {return \App\Models\ChildMenu::where('sub_menu_id', $subId)->get();})->middleware(LoginCheckMiddleware::class);



//slider route
Route::get('/slider', [SliderController::class, 'sliderIndex'])->middleware(LoginCheckMiddleware::class);
Route::post('/slider/store', [SliderController::class, 'store'])->name('slider.store')->middleware(LoginCheckMiddleware::class);
Route::post('/slider/update/{id}', [SliderController::class, 'update'])->middleware(LoginCheckMiddleware::class);
Route::delete('/slider/delete/{id}', [SliderController::class, 'destroy'])->name('slider.destroy')->middleware(LoginCheckMiddleware::class);

//order route
Route::prefix('admin')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/latest', [OrderController::class, 'latest'])->name('orders.latest');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show'); // Order details

    // ✅ Delivery status update
    Route::patch('/orders/{id}/delivery-status', [OrderController::class, 'updateDeliveryStatus'])
        ->name('orders.updateDeliveryStatus');
});



//general page menu route
Route::prefix('admin/site-menus')->name('site.menus.')->group(function () {
    Route::get('/', [SiteMenuController::class, 'index'])->name('index')->middleware(LoginCheckMiddleware::class);
    Route::post('/store', [SiteMenuController::class, 'store'])->name('store')->middleware(LoginCheckMiddleware::class);
    Route::post('/update/{id}', [SiteMenuController::class, 'update'])->name('update')->middleware(LoginCheckMiddleware::class);
    Route::delete('/delete/{id}', [SiteMenuController::class, 'destroy'])->name('delete')->middleware(LoginCheckMiddleware::class);
});


//page route
Route::prefix('admin/site-pages')->group(function () {
    Route::get('/create', [SitePageController::class, 'create'])->name('site-pages.create')->middleware(LoginCheckMiddleware::class);
    Route::post('/store', [SitePageController::class, 'store'])->name('site-pages.store')->middleware(LoginCheckMiddleware::class);
    Route::get('/list', [SitePageController::class, 'index'])->name('site-pages.list')->middleware(LoginCheckMiddleware::class);
    Route::get('/edit/{id}', [SitePageController::class, 'edit'])->name('site-pages.edit')->middleware(LoginCheckMiddleware::class);
    Route::put('/update/{id}', [SitePageController::class, 'update'])->name('site-pages.update')->middleware(LoginCheckMiddleware::class);
    Route::delete('/destroy/{id}', [SitePageController::class, 'destroy'])->name('site-pages.destroy')->middleware(LoginCheckMiddleware::class);
});


//long section
Route::get('/login', [LoginAdminController::class, 'loginAdmin']);
Route::post('/onlogin', [LoginAdminController::class, 'onLogin']);
Route::get('/logout', [LoginAdminController::class, 'onLogout']);

//admin user rout
Route::get('/user', [LoginAdminController::class, 'index'])->name('user.index')->middleware(LoginCheckMiddleware::class);
Route::post('/users/store', [LoginAdminController::class, 'store'])->name('user.store')->middleware(LoginCheckMiddleware::class);
Route::get('/user/edit/{id}', [LoginAdminController::class, 'edit'])->name('user.edit')->middleware(LoginCheckMiddleware::class);
Route::post('/user/update/{id}', [LoginAdminController::class, 'update'])->name('user.update')->middleware(LoginCheckMiddleware::class);
Route::delete('/user/delete/{id}', [LoginAdminController::class, 'destroy'])->name('user.delete')->middleware(LoginCheckMiddleware::class);



Route::resource('khut-stories', KhutStoryController::class)->middleware(LoginCheckMiddleware::class)->middleware(LoginCheckMiddleware::class);

// Create Page
Route::get('/khut-stories/create', [KhutStoryController::class, 'create'])->name('khut-stories.create')->middleware(LoginCheckMiddleware::class);

// Store Page
Route::post('/khut-stories', [KhutStoryController::class, 'store'])->name('khut-stories.store')->middleware(LoginCheckMiddleware::class);

// Optional: TinyMCE image upload
Route::post('/khut-stories/tinymce-upload', [KhutStoryController::class, 'uploadImage'])->name('khut-stories.tinymce.upload')->middleware(LoginCheckMiddleware::class);

Route::post('/khut-stories/update/{id}', [KhutStoryController::class, 'update'])
    ->name('khut-stories.update')
    ->middleware(LoginCheckMiddleware::class)->middleware(LoginCheckMiddleware::class);

Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index')->middleware(LoginCheckMiddleware::class);
Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy')->middleware(LoginCheckMiddleware::class);

Route::get('/dashboard/stats', [HomeController::class, 'dashboardStats'])->name('dashboard.stats');
Route::post('/admin/orders/{order}/delivery-status', [OrderController::class, 'updateDeliveryStatus']);


Route::get('/product/sub-menus/{mainId}', [ProductController::class, 'getSubMenus']);
Route::get('/product/child-menus/{subId}', [ProductController::class, 'getChildMenus']);





