<?php

use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PaymentinfoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RassedActevityContoller;
use App\Http\Controllers\SiteSettingController;
use App\Http\Livewire\Admin\ProductTable;
use App\Models\Paymentinfo;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::resource('ad',AdController::class)->name('index','ad');

    Route::get('/products-table',ProductTable::class)->name('products-table');
    Route::resource('/products',ProductController::class)->name('index','products');

    Route::post('/uploade',[\App\Http\Controllers\Admin\UploadeController::class,'store'])->name('uploade');


    Route::get("/sitesetting",[SiteSettingController::class,'index'])->name("sitesetting");
    Route::post("/sitesetting",[SiteSettingController::class,'store'])->name("sitesetting.post");

    Route::get('/contact',[ContactController::class,'index'])->name('admin.contacts');
    Route::get('/contact/{contact}',[ContactController::class,'replay'])->name('admin.contacts.replay');
    Route::post('/contact.update/{contact}',[ContactController::class,'update'])->name('admin.contacts.update');


    Route::get('/departments.show',\App\Http\Livewire\Admin\DepartmentTable::class)->name('departments.show');
   Route::post('/departments.store',[\App\Http\Controllers\DepartmentController::class,'store'])->name('departments.store');
    Route::post('/departments.update',[\App\Http\Controllers\DepartmentController::class,'update'])->name('departments.update');

    Route::resource('/depts', App\Http\Controllers\DepartmentController::class)->name('index','depts');

    Route::resource('/offers',OfferController::class)->name('index','offers');
    Route::resource('/discount',DiscountController::class)->name('index','discount');
    Route::resource('/paymentinfo',PaymentinfoController::class)->name('index','paymentinfo');
    Route::resource('/rasseds',RassedActevityContoller::class)->name('index','rasseds');

    Route::resource('/clients',ClientController::class)->name('index','users');
    Route::resource('/coins',CoinController::class)->name('index','coins');






});
Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::resource('permissions', PermissionsController::class);
    Route::delete('permissions_mass_destroy', [PermissionsController::class,'massDestroy'])->name('permissions.mass_destroy');
    Route::delete('roles_mass_destroy', [RolesController::class,'massDestroy'])->name('roles.mass_destroy');
    Route::resource('roles', RolesController::class);
    Route::delete('users_mass_destroy', [UsersController::class,'massDestroy'])->name('users.mass_destroy');
    Route::get('users_ban/{user}',[UsersController::class,'ban'])->name('users.ban.show');
    Route::post('users_ban/{user}',[UsersController::class,'ban_store'])->name('users.ban.post');

    Route::resource('users', UsersController::class);




});
