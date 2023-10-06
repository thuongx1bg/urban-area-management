<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('buildings')->group(function (){
        Route::get('/',[ \App\Http\Controllers\Be\BuildingController::class,'index'])->name('building.index');
        Route::get('/create',[ \App\Http\Controllers\Be\BuildingController::class,'create'])->name('building.create');
        Route::post('/store',[ \App\Http\Controllers\Be\BuildingController::class,'store'])->name('building.store');
        Route::get('/edit/{id}',[ \App\Http\Controllers\Be\BuildingController::class,'edit'])->name('building.edit');
        Route::post('/update/{id}',[ \App\Http\Controllers\Be\BuildingController::class,'update'])->name('building.update');
        Route::get('/delete/{id}',[ \App\Http\Controllers\Be\BuildingController::class,'delete'])->name('building.delete');
    });

Route::prefix('users')->group(function (){
    Route::get('/',[ \App\Http\Controllers\Be\UserController::class,'index'])->name('user.index');
    Route::get('/create',[ \App\Http\Controllers\Be\UserController::class,'create'])->name('user.create');
    Route::post('/store',[ \App\Http\Controllers\Be\UserController::class,'store'])->name('user.store');
    Route::get('/edit/{id}',[ \App\Http\Controllers\Be\UserController::class,'edit'])->name('user.edit');
    Route::post('/update/{id}',[ \App\Http\Controllers\Be\UserController::class,'update'])->name('user.update');
    Route::get('/delete/{id}',[ \App\Http\Controllers\Be\UserController::class,'delete'])->name('user.delete');
    Route::get('profile/{id}',[\App\Http\Controllers\Be\UserController::class,'profile'])->name('user.profile');
});

Route::prefix('qr-code')->group(function () {
    Route::get('/',[\App\Http\Controllers\Be\QrController::class,'index'])->name('qr.index');
    Route::get('/check/{si}/{username}/{idQr}',[\App\Http\Controllers\Be\QrController::class,'check'])->name('qr.check');
    Route::get('/edit/{id}',[ \App\Http\Controllers\Be\QrController::class,'edit'])->name('qr.edit');
    Route::get('/delete/{id}',[ \App\Http\Controllers\Be\QrController::class,'delete'])->name('qr.delete');
    Route::get('/create',[ \App\Http\Controllers\Be\QrController::class,'create'])->name('qr.create');
    Route::post('/store',[ \App\Http\Controllers\Be\QrController::class,'store'])->name('qr.store');
    Route::post('/update/{id}',[ \App\Http\Controllers\Be\QrController::class,'update'])->name('qr.update');
    Route::get('/infor/{qr_id}',[\App\Http\Controllers\Be\QrController::class,'infor'])->name('qr.infor');
    Route::post('/check',[\App\Http\Controllers\Be\QrController::class,'check'])->name('qr.check');
    Route::get('/checkForm',[\App\Http\Controllers\Be\QrController::class,'checkForm'])->name('qr.checkForm');





});
