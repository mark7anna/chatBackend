<?php

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

Route::post('/Account/Create', [App\Http\Controllers\Api\AppUserController::class, 'checkUserLoginOrRegister'])->name('registerUser');
Route::get('/Account/GetUser/{id}', [App\Http\Controllers\Api\AppUserController::class, 'getUserData'])->name('GetUser');
Route::get('/Banners/getAll', [App\Http\Controllers\Api\BannerController::class, 'index'])->name('getAllBanners');
Route::get('/Countries/getAll', [App\Http\Controllers\Api\CountryController::class, 'index'])->name('getAllCountries');
Route::get('/chatRooms/getAll', [App\Http\Controllers\Api\ChatRoomController::class, 'index'])->name('getAllChatRooms');
Route::get('/festivalBanners/getAll', [App\Http\Controllers\Api\FestivalBannerController::class, 'index'])->name('getFestivalBanners');
Route::get('/users/Search/{txt}', [App\Http\Controllers\Api\AppUserController::class, 'search'])->name('usersSearch');
Route::get('/chatRooms/Search/{txt}', [App\Http\Controllers\Api\ChatRoomController::class, 'search'])->name('roomsSearch');

