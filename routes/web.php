<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashBoardController;
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

Route::get('/',[DashBoardController::class,'index'])
->middleware(['auth', 'verified']);


//post.create_contact
Route::view('/contact-us','contact-us')->name('contact-us');
Route::view('/privacy-policy','privacy-policy')->name('privacy-policy');

Route::post('/post.create_contact',[ContactController::class,'sendmeassge'])->name('post.create_contact');
Route::get('/dashboard',[DashBoardController::class,'index'])
->middleware(['auth', 'verified'])->name('dashboard');

// useless routes
// Just to demo sidebar dropdown links active states.
Route::get('/buttons/text', function () {
    return view('buttons-showcase.text');
})->middleware(['auth'])->name('buttons.text');

Route::get('/buttons/icon', function () {
    return view('buttons-showcase.icon');
})->middleware(['auth'])->name('buttons.icon');

Route::get('/buttons/text-icon', function () {
    return view('buttons-showcase.text-icon');
})->middleware(['auth'])->name('buttons.text-icon');

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
