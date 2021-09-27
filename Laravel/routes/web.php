<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryVideoController;
use App\Http\Controllers\CategoryBlogController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ImageProductController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

//Đăng nhập admin
Route::group(['prefix' => 'users'], function(){
    Route::get('login', [UserController::class,'login_form'])->name('users.login');
    Route::post('login', [UserController::class,'login'])->name('users.login');
    Route::get('logout', [UserController::class,'logout'])->name('users.logout');

});
Route::group(['prefix' => 'admin','middleware'=>'check_admin'], function(){
    Route::get('/', [AdminController::class,'index'])->name('index');

    Route::group(['prefix' => 'category'], function(){
        Route::get('/', [CategoryVideoController::class,'index'])->name('categoryVideo.index');
        Route::get('create', [CategoryVideoController::class,'create'])->name('categoryVideo.create');
        Route::post('add', [CategoryVideoController::class,'add'])->name('categoryVideo.add');

        Route::get('trashed', [CategoryVideoController::class,'trashed'])->name('categoryVideo.trashed');
        Route::get('restore/{id}', [CategoryVideoController::class,'restore'])->name('categoryVideo.restore');
        Route::put('/restore-all',[CategoryVideoController::class,'restoreAll'])->name('categoryVideo.restoreAll');
        Route::get('force-delete/{id}', [CategoryVideoController::class,'forceDelete'])->name('categoryVideo.forceDelete');

        Route::get('edit/{cat}', [CategoryVideoController::class,'edit'])->name('categoryVideo.edit');
        Route::put('update/{cat}', [CategoryVideoController::class,'update'])->name('categoryVideo.update');
        Route::delete('destroy/{cat}', [CategoryVideoController::class,'destroy'])->name('categoryVideo.destroy');

        Route::delete('deleteAll', [CategoryVideoController::class,'deleteAll'])->name('categoryVideo.deleteAll');

        Route::delete('clear', [CategoryVideoController::class,'clear'])->name('categoryVideo.clear');
    });
    Route::group(['prefix' => 'categoryBlog'], function(){
        Route::get('/', [CategoryBlogController::class,'index'])->name('categoryBlog.index');
        Route::get('create', [CategoryBlogController::class,'create'])->name('categoryBlog.create');
        Route::post('add', [CategoryBlogController::class,'add'])->name('categoryBlog.add');

        Route::get('edit/{cat}', [CategoryBlogController::class,'edit'])->name('categoryBlog.edit');
        Route::put('update/{cat}', [CategoryBlogController::class,'update'])->name('categoryBlog.update');
        Route::delete('destroy/{cat}', [CategoryBlogController::class,'destroy'])->name('categoryBlog.destroy');

        Route::put('restoreAll', [CategoryBlogController::class,'restoreAll'])->name('categoryBlog.restoreAll');

        Route::get('trashed', [CategoryBlogController::class,'trashed'])->name('categoryBlog.trashed');
        Route::get('restore/{id}', [CategoryBlogController::class,'restore'])->name('categoryBlog.restore');
        Route::get('force-delete/{id}', [CategoryBlogController::class,'forceDelete'])->name('categoryBlog.forceDelete');

        Route::delete('deleteAll', [CategoryBlogController::class,'deleteAll'])->name('categoryBlog.deleteAll');

        Route::delete('clear', [CategoryBlogController::class,'clear'])->name('categoryBlog.clear');
    });
    Route::group(['prefix' => 'categoryProduct'], function(){
        Route::get('/', [CategoryProductController::class,'index'])->name('categoryProduct.index');
        Route::get('create', [CategoryProductController::class,'create'])->name('categoryProduct.create');
        Route::post('add', [CategoryProductController::class,'add'])->name('categoryProduct.add');

        Route::get('edit/{cat}', [CategoryProductController::class,'edit'])->name('categoryProduct.edit');
        Route::put('update/{cat}', [CategoryProductController::class,'update'])->name('categoryProduct.update');
        Route::delete('destroy/{cat}', [CategoryProductController::class,'destroy'])->name('categoryProduct.destroy');

        Route::put('restoreAll', [CategoryProductController::class,'restoreAll'])->name('categoryProduct.restoreAll');

        Route::get('trashed', [CategoryProductController::class,'trashed'])->name('categoryProduct.trashed');
        Route::get('restore/{id}', [CategoryProductController::class,'restore'])->name('categoryProduct.restore');
        Route::get('force-delete/{id}', [CategoryProductController::class,'forceDelete'])->name('categoryProduct.forceDelete');

        Route::delete('deleteAll', [CategoryProductController::class,'deleteAll'])->name('categoryProduct.deleteAll');

        Route::delete('clear', [CategoryProductController::class,'clear'])->name('categoryProduct.clear');
    });
    Route::group(['prefix' => 'blog'], function(){
        Route::get('/', [BlogController::class,'index'])->name('blog.index');
        Route::get('create', [BlogController::class,'create'])->name('blog.create');
        Route::post('add', [BlogController::class,'add'])->name('blog.add');

        Route::get('edit/{blog}', [BlogController::class,'edit'])->name('blog.edit');
        Route::put('update/{blog}', [BlogController::class,'update'])->name('blog.update');

        Route::delete('destroy/{blog}', [BlogController::class,'destroy'])->name('blog.destroy');
        Route::delete('clear', [BlogController::class,'clear'])->name('blog.clear');

    });
    //video
    Route::group(['prefix'=>'video'],function(){
        Route::get('/',[VideoController::class,'index'])->name('admin.video');
        Route::get('/video/{id}',[VideoController::class,'view']);
        Route::get('create',[VideoController::class,'create'])->name('video.create');
        Route::post('store',[VideoController::class,'store'])->name('video.store');

        Route::get('trashed',[VideoController::class,'trashed'])->name('video.trashed');
        Route::get('restore/{id}',[VideoController::class,'restore'])->name('video.restore');
        Route::get('force-delete/{id}',[VideoController::class,'forceDelete'])->name('video.forceDelete');

        Route::get('edit/{vid}',[VideoController::class,'edit'])->name('video.edit');
        Route::put('update/{vid}',[VideoController::class,'update'])->name('video.update');

        Route::delete('/destroy/{vid}',[VideoController::class,'destroy'])->name('video.destroy');
        Route::delete('/delete-all',[VideoController::class,'deleteAll'])->name('video.deleteAll');
        Route::put('/restore-all',[VideoController::class,'restoreAll'])->name('video.restoreAll');
        
        Route::delete('/force-delete-all',[VideoController::class,'forceDeleteAll'])->name('video.forceDeleteAll');
        Route::delete('clear', [VideoController::class,'clear'])->name('video.clear');

    });
    Route::group(['prefix'=>'logo'],function(){
        Route::get('/',[LogoController::class,'index'])->name('admin.logo');
        Route::get('/logo/{id}',[LogoController::class,'view']);
        Route::get('create',[LogoController::class,'create'])->name('admin.logo.create');
        Route::post('store',[LogoController::class,'store'])->name('admin.logo.store');

        Route::get('edit/{vid}',[LogoController::class,'edit'])->name('admin.logo.edit');
        Route::put('update/{vid}',[LogoController::class,'update'])->name('admin.logo.update');

    });
    Route::group(['prefix' => 'banner'], function(){
        Route::get('/', [BannerController::class,'index'])->name('banner.index');
        Route::get('create', [BannerController::class,'create'])->name('banner.create');
        Route::post('add', [BannerController::class,'add'])->name('banner.add');

        Route::get('edit/{ban}', [BannerController::class,'edit'])->name('banner.edit');
        Route::put('update/{ban}', [BannerController::class,'update'])->name('banner.update');

        Route::delete('destroy/{ban}', [BannerController::class,'destroy'])->name('banner.destroy');
        Route::delete('clear', [BannerController::class,'clear'])->name('banner.clear');

    });

    Route::group(['prefix' => 'product'], function(){
        Route::get('', [ProductController::class, 'index']) -> name('product.index');

        Route::get('create', [ProductController::class, 'create']) -> name('product.create');        
        Route::post('store', [ProductController::class, 'store']) -> name('product.store');

        Route::get('edit/{product}', [ProductController::class, 'edit']) -> name('product.edit');
        Route::put('update/{product}', [ProductController::class, 'update']) -> name('product.update');

        Route::get('trashed', [ProductController::class, 'trashed']) -> name('product.trashed');
        Route::get('restore/{id}', [ProductController::class, 'restore']) -> name('product.restore');
        Route::get('forceDelete/{id}', [ProductController::class, 'forceDelete']) -> name('product.forceDelete');
        Route::get('restore-all', [ProductController::class, 'restoreAll']) -> name('product.restoreAll');

        Route::delete('delete/{pro}', [ProductController::class, 'delete'])->name('product.delete');
        Route::delete('delete-all', [ProductController::class, 'deleteAll']) -> name('product.deleteAll');
        Route::get('image-destroy/{image}', [ImageProductController::class,'destroy'])->name('product.image-destroy');
        Route::delete('clear', [ProductController::class,'clear'])->name('product.clear');    });
    Route::resources([
        'image' => ImageProductController::class       
    ]);
    Route::group(['prefix' => 'customer'], function(){
        Route::get('/', [CustomerController::class,'index'])->name('customer.index');
        Route::get('create', [CustomerController::class,'create'])->name('customer.create');
        Route::post('add', [CustomerController::class,'add'])->name('customer.add');

        Route::get('trashed', [CustomerController::class,'trashed'])->name('customer.trashed');
        Route::get('restore/{id}', [CustomerController::class,'restore'])->name('customer.restore');
        Route::get('force-delete/{id}', [CustomerController::class,'forceDelete'])->name('customer.forceDelete');

        Route::get('edit/{cus}', [CustomerController::class,'edit'])->name('customer.edit');
        Route::put('update/{cus}', [CustomerController::class,'update'])->name('customer.update');

        Route::delete('destroy/{cus}', [CustomerController::class,'destroy'])->name('customer.destroy');
        Route::delete('clear', [CustomerController::class,'clear'])->name('customer.clear');
        Route::get('retrieve', [CustomerController::class,'retrieve'])->name('customer.retrieve');
        Route::delete('deleteAll', [CustomerController::class,'deleteAll'])->name('customer.deleteAll');
    });
        Route::group(['prefix' => 'admin'], function(){
        Route::get('/', [AdminsController::class,'index'])->name('admin.index');
        Route::get('create', [AdminsController::class,'create'])->name('admin.create');
        Route::post('add', [AdminsController::class,'add'])->name('admin.add');
        Route::get('edit/{adm}', [AdminsController ::class,'edit'])->name('admin.edit');
        Route::put('update/{adm}', [AdminsController ::class,'update'])->name('admin.update');
        Route::delete('destroy/{adm}', [AdminsController::class,'destroy'])->name('admin.destroy');
        Route::get('trashed',[AdminsController::class,'trashed'])->name('admin.trashed');
        Route::get('restore/{id}',[AdminsController::class,'restore'])->name('admin.restore');
        Route::get('force-delete/{id}',[AdminsController::class,'forceDelete'])->name('admin.forceDelete');
        Route::put('/restore-all',[AdminsController::class,'restoreAll'])->name('admin.restoreAll');
         Route::delete('/delete-all',[AdminsController::class,'deleteAll'])->name('admin.deleteAll');
        Route::delete('clear', [AdminsController::class,'clear'])->name('admin.clear');

    });

    // Route::group(['prefix' => 'order'], function(){
    //     Route::get('/', [OrderController::class,'index'])->name('order.index');
    //     Route::get('order/detail/{id}', [OrderController::class,'detail'])->name('admin.order.detail');
    //     Route::put('order/status/{id}', [OrderController::class,'status'])->name('order.status');


    // });


});