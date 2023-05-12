<?php

use App\Http\Controllers\UAM\RoleController;
use App\Http\Controllers\UAM\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>['auth']],function(){
    Route::resource('users', UserController::class);
    Route::resource('roles',RoleController::class);
    Route::get('dt/roles',[RoleController::class,'getListDT'])->name('roles.listdt');
    Route::any ('search-user','App\Http\Controllers\uam\UserController@searchUser')->name('users.search');


});
