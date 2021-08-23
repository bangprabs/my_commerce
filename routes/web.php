<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group whichs
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Category;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/admin')->namespace('Admin')->group(function(){

    Route::match(['get', 'post'], '/', 'AdminController@login');

    Route::group(['middleware'=>['admin']], function () {

        Route::get('dashboard', 'AdminController@Dashboard');
        Route::get('logout', 'AdminController@logout');
        Route::get('settings', 'AdminController@Settings');
        Route::POST('check-current-pwd','AdminController@chkCurrentPassword');
        Route::POST('update-current-pwd','AdminController@updateCurrentPassword');
        Route::POST('update-name','AdminController@updateCurrentPassword');
        Route::match(['get', 'post'], 'update-admin-details', 'AdminController@updateAdminDetails');

        // Sections Routes
        Route::get('sections', 'SectionController@sections');
        Route::post('update-section-status', 'SectionController@UpdateSectionStatus');

        //Brand Routes
        Route::get('brands', 'BrandsController@brands');
        Route::post('update-brands-status', 'BrandsController@updateBrandsStatus');
        Route::match(['get', 'post'], 'add-edit-brand/{id?}', 'BrandsController@addEditBrand');
        Route::get('delete-brand/{id}','BrandsController@deleteBrand');

        // Cateogires Route
        Route::get('categories','CategoryController@categories');
        Route::post('update-category-status', 'CategoryController@UpdateCategoryStatus');
        Route::match(['get', 'post'], 'add-edit-category/{id?}', 'CategoryController@addEditCategory');
        Route::post('append-categories-level', 'CategoryController@appendCategoryLevel');
        Route::get('delete-category-image/{id}','CategoryController@deleteCategoryImage');
        Route::get('delete-category/{id}','CategoryController@deleteCategory');

        //Products Route
        Route::get('products', 'ProductsController@products');
        Route::post('update-product-status', 'ProductsController@updateProductStatus');
        Route::get('delete-product/{id}','ProductsController@deleteProduct');
        Route::match(['get', 'post'], 'add-edit-product/{id?}', 'ProductsController@addEditProduct');
        Route::get('delete-product-image/{id}','ProductsController@deleteProductImage');
        Route::get('delete-product-video/{id}','ProductsController@deleteProductVideo');

        //Attributes Route
        Route::match(['get', 'post'], 'add-attributes/{id}', 'ProductsController@addAttributes');
        Route::post ('edit-attributes/{id}', 'ProductsController@editAttributes');
        Route::post('update-attribute-status', 'ProductsController@updateAttributeStatus');
        Route::get('delete-attribute/{id}','ProductsController@deleteAttributes');

        //Images Route
        Route::match(['get', 'post'], 'add-images/{id}', 'ProductsController@addImages');
        Route::post('update-images-status', 'ProductsController@updateImagesStatus');
        Route::get('delete-image/{id}','ProductsController@deleteImage');

        //Banners Route
        Route::get('banners', 'BannersController@banners');
        Route::match(['get', 'post'], 'add-edit-banner/{id?}', 'BannersController@addEditBanner');
        Route::post('update-banner-status', 'BannersController@updateBannerStatus');
        Route::get('delete-banner/{id}','BannersController@deleteBanner');
    });
});

Route::namespace('Front')->group(function (){
    //Homepage Route
    Route::get('/', 'IndexController@index');

    // Get categeory url
    $catUrls = Category::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    foreach ($catUrls as $url) {
        Route::get('/'.$url, 'ProductsController@listing');
    }

    // Details page route
    Route::get('/product/{id}', 'ProductsController@detail');
});





