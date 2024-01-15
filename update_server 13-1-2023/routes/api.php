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
Route::get('/posts/getAll', [App\Http\Controllers\Api\PostsController::class, 'index'])->name('getAllPosts');
Route::get('/posts/like/{id}/{user}', [App\Http\Controllers\Api\PostsController::class, 'likePost'])->name('likePost');
Route::get('/posts/unlike/{id}/{user}', [App\Http\Controllers\Api\PostsController::class, 'unlikePost'])->name('likePost');
Route::get('/posts/report/{id}/{user}/{type}', [App\Http\Controllers\Api\PostsController::class, 'reportPost'])->name('reportPost');
Route::post('/Comments/addComment', [App\Http\Controllers\Api\PostsController::class, 'addComment'])->name('addComment');
Route::post('/posts/add', [App\Http\Controllers\Api\PostsController::class, 'AddPost'])->name('addPost');
Route::get('/posts/tags/all', [App\Http\Controllers\Api\PostsController::class, 'getTags'])->name('getAllTags');
Route::get('/store/cats/all', [App\Http\Controllers\Api\StoreController::class, 'getAllStoreCategory'])->name('getAllStoreCategory');
Route::get('/store/designs/all', [App\Http\Controllers\Api\StoreController::class, 'getAllDesigns'])->name('getAllDesigns');
Route::post('/store/design/purchase', [App\Http\Controllers\Api\StoreController::class, 'purchaseDesign'])->name('purchaseDesign');
Route::get('/notifications/all/{user_id}', [App\Http\Controllers\Api\UserNotificationController::class, 'getAllUserNotifications'])->name('getAllUserNotifications');
Route::post('/wallet/charge', [App\Http\Controllers\Api\WalletController::class, 'ChargeWallet'])->name('ChargeWallet');
Route::get('/wallet/getWallet/{user_id}', [App\Http\Controllers\Api\WalletController::class, 'getWallet'])->name('getWallet');
Route::post('/wallet/exchangeDiamond', [App\Http\Controllers\Api\WalletController::class, 'exchangeDiamond'])->name('exchangeDiamond');
Route::get('/levels/getLevels', [App\Http\Controllers\Api\LevelsController::class, 'getLevels'])->name('getLevels');




