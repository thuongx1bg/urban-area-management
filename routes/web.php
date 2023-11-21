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

Route::prefix('buildings')->group(function () {
    Route::get('/', [\App\Http\Controllers\Be\BuildingController::class, 'index'])
        ->name('building.index')->middleware('can:list_building');
    Route::get('/create', [\App\Http\Controllers\Be\BuildingController::class, 'create'])
        ->name('building.create')->middleware('can:create_building');
    Route::post('/store', [\App\Http\Controllers\Be\BuildingController::class, 'store'])
        ->name('building.store')->middleware('can:create_building');
    Route::get('/edit/{id}', [\App\Http\Controllers\Be\BuildingController::class, 'edit'])
        ->name('building.edit')->middleware('can:update_building');
    Route::post('/update/{id}', [\App\Http\Controllers\Be\BuildingController::class, 'update'])
        ->name('building.update')->middleware('can:update_building');
    Route::get('/delete/{id}', [\App\Http\Controllers\Be\BuildingController::class, 'delete'])
        ->name('building.delete')->middleware('can:delete_building');
});

Route::prefix('roles')->group(function () {
    Route::get('/', [\App\Http\Controllers\Be\RoleController::class, 'index'])
        ->name('role.index')
        ->middleware('can:list_role');
    Route::get('/create', [\App\Http\Controllers\Be\RoleController::class, 'create'])
        ->name('role.create')->middleware('can:create_role');
    Route::post('/store', [\App\Http\Controllers\Be\RoleController::class, 'store'])
        ->name('role.store')->middleware('can:create_role');
    Route::get('/edit/{id}', [\App\Http\Controllers\Be\RoleController::class, 'edit'])
        ->name('role.edit')->middleware('can:update_role');
    Route::post('/update/{id}', [\App\Http\Controllers\Be\RoleController::class, 'update'])
        ->name('role.update')->middleware('can:update_role');
    Route::get('/delete/{id}', [\App\Http\Controllers\Be\RoleController::class, 'delete'])
        ->name('role.delete')->middleware('can:delete_role');
});

Route::prefix('users')->group(function () {
    Route::get('/', [\App\Http\Controllers\Be\UserController::class, 'index'])
        ->name('user.index')->middleware('can:list_user');
    Route::get('/create', [\App\Http\Controllers\Be\UserController::class, 'create'])
        ->name('user.create')->middleware('can:create_user');
    Route::post('/store', [\App\Http\Controllers\Be\UserController::class, 'store'])
        ->name('user.store')->middleware('can:create_user');
    Route::get('/edit/{id}', [\App\Http\Controllers\Be\UserController::class, 'edit'])
        ->name('user.edit')->middleware('can:update_user');
    Route::post('/update/{id}', [\App\Http\Controllers\Be\UserController::class, 'update'])
        ->name('user.update')->middleware('can:update_user');
    Route::get('/delete/{id}', [\App\Http\Controllers\Be\UserController::class, 'delete'])
        ->name('user.delete')->middleware('can:delete_user');
    Route::get('profile/{id}', [\App\Http\Controllers\Be\UserController::class, 'profile'])
        ->name('user.profile');
    Route::get('change_password/{id}', [\App\Http\Controllers\Be\UserController::class, 'changePassword'])
        ->name('user.change_password');
    Route::post('update_password/{id}', [\App\Http\Controllers\Be\UserController::class, 'updatePassword'])
        ->name('user.update_password');
});

Route::prefix('qr-code')->group(function () {
    Route::get('/', [\App\Http\Controllers\Be\QrController::class, 'index'])
        ->name('qr.index')->middleware('can:list_qrcode');
    Route::get('/check/{si}/{username}/{idQr}', [\App\Http\Controllers\Be\QrController::class, 'check'])
        ->name('qr.check')->middleware('can:check_qrcode');
    Route::get('/edit/{id}', [\App\Http\Controllers\Be\QrController::class, 'edit'])
        ->name('qr.edit')->middleware('can:update_qrcode');
    Route::get('/delete/{id}', [\App\Http\Controllers\Be\QrController::class, 'delete'])
        ->name('qr.delete')->middleware('can:delete_qrcode');
    Route::get('/create', [\App\Http\Controllers\Be\QrController::class, 'create'])
        ->name('qr.create')->middleware('can:create_qrcode');
    Route::post('/store', [\App\Http\Controllers\Be\QrController::class, 'store'])
        ->name('qr.store')->middleware('can:create_qrcode');
    Route::post('/update/{id}', [\App\Http\Controllers\Be\QrController::class, 'update'])
        ->name('qr.update')->middleware('can:update_qrcode');
    Route::get('/infor/{qr_id}', [\App\Http\Controllers\Be\QrController::class, 'infor'])
        ->name('qr.infor');
    Route::post('/check', [\App\Http\Controllers\Be\QrController::class, 'check'])
        ->name('qr.check')->middleware('can:check_qrcode');
    Route::get('/checkForm', [\App\Http\Controllers\Be\QrController::class, 'checkForm'])
        ->name('qr.checkForm')->middleware('can:check_qrcode');


});
