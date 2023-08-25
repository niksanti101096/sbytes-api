<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SalesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('accounts', AccountsController::class);
// Route::resource('productCategory', ProductCategoryController::class);
Route::resource('products', ProductsController::class);
// Route::resource('sales', SalesController::class);
Route::post('/accounts/accountvalidation', [AccountsController::class, 'accountValidation'])->name('accounts.accountValidation');

Route::controller(AccountsController::class)->group(function () {
    Route::get('/accounts/accessedit/{account}', 'accessTypeEdit')->name('accounts.accessTypeEdit');
    
    Route::post('/accounts/login', 'login')->name('accounts.login');
    Route::post('/accounts/accessupdate/{account}', 'accessTypeUpdate')->name('accounts.accessTypeUpdate');
    Route::post('/accounts/accessupdate/{account}', 'accessTypeUpdate')->name('accounts.accessTypeUpdate');

    Route::get('/accounts/dashboard', 'mainDashboard')->name('accounts.dashboard');
});



Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin', [AccountsController::class, 'adminDashboard'])->name('admin.dashboard'); 
    
    Route::post('/accounts/logout', [AccountsController::class, 'logout'])->name('accounts.logout');
});