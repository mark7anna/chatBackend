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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['prefix' => LaravelLocalization::setLocale(),
'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],

function()

{

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/levels/{type}', [App\Http\Controllers\LevelController::class, 'index'])->name('levels');
    Route::post('/levelStore', [App\Http\Controllers\LevelController::class, 'store'])->name('levelStore');
    Route::get('/getLevel/{id}', [App\Http\Controllers\LevelController::class, 'show'])->name('getLevel');
    Route::get('/deleteLevel/{id}', [App\Http\Controllers\LevelController::class, 'destroy'])->name('deleteLevel');

    Route::get('/badges', [App\Http\Controllers\BadgeController::class, 'index'])->name('badges');
    Route::post('/badgeStore', [App\Http\Controllers\BadgeController::class, 'store'])->name('badgeStore');
    Route::get('/getBadge/{id}', [App\Http\Controllers\BadgeController::class, 'show'])->name('getBadge');
    Route::get('/deleteBadge/{id}', [App\Http\Controllers\BadgeController::class, 'destroy'])->name('deleteBadge');

    Route::get('/countries', [App\Http\Controllers\CountryController::class, 'index'])->name('countries');
    Route::post('/countryStore', [App\Http\Controllers\CountryController::class, 'store'])->name('countryStore');
    Route::get('/getCountry/{id}', [App\Http\Controllers\CountryController::class, 'show'])->name('getCountry');
    Route::get('/deleteCountry/{id}', [App\Http\Controllers\CountryController::class, 'destroy'])->name('deleteCountry');

    Route::get('/banners', [App\Http\Controllers\BannerController::class, 'index'])->name('banners');
    Route::post('/bannerStore', [App\Http\Controllers\BannerController::class, 'store'])->name('bannerStore');
    Route::get('/getBanner/{id}', [App\Http\Controllers\BannerController::class, 'show'])->name('getBanner');
    Route::get('/deleteBanner/{id}', [App\Http\Controllers\BannerController::class, 'destroy'])->name('deleteBanner');

    Route::get('/vip', [App\Http\Controllers\VipController::class, 'index'])->name('vip');
    Route::post('/updateVip', [App\Http\Controllers\VipController::class, 'update'])->name('updateVip');
    Route::get('/getVip/{id}', [App\Http\Controllers\VipController::class, 'show'])->name('getVip');


    Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
    Route::post('/CategoryStore', [App\Http\Controllers\CategoryController::class, 'store'])->name('CategoryStore');
    Route::get('/getCategory/{id}', [App\Http\Controllers\CategoryController::class, 'show'])->name('getCategory');
    Route::get('/deleteCategory/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('deleteCategory');


    Route::get('/giftCategories', [App\Http\Controllers\GiftCategoryController::class, 'index'])->name('giftCategories');
    Route::post('/giftCategoryStore', [App\Http\Controllers\GiftCategoryController::class, 'store'])->name('giftCategoryStore');
    Route::get('/getGiftCategory/{id}', [App\Http\Controllers\GiftCategoryController::class, 'show'])->name('getGiftCategory');
    Route::get('/deleteGiftCategory/{id}', [App\Http\Controllers\GiftCategoryController::class, 'destroy'])->name('deleteGiftCategory');

    Route::get('/designs', [App\Http\Controllers\DesignController::class, 'index'])->name('designs');
    Route::post('/designStore', [App\Http\Controllers\DesignController::class, 'store'])->name('designStore');
    Route::get('/getDesign/{id}', [App\Http\Controllers\DesignController::class, 'show'])->name('getDesign');
    Route::get('/deleteDesign/{id}', [App\Http\Controllers\DesignController::class, 'destroy'])->name('deleteDesign');

    Route::get('/admins', [App\Http\Controllers\AdminController::class, 'index'])->name('admins');
    Route::post('/adminStore', [App\Http\Controllers\AdminController::class, 'store'])->name('adminStore');
    Route::get('/getAdmin/{id}', [App\Http\Controllers\AdminController::class, 'show'])->name('getAdmin');
    Route::get('/deleteAdmin/{id}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('deleteAdmin');

    Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles');
    Route::post('/roleStore', [App\Http\Controllers\RoleController::class, 'store'])->name('roleStore');
    Route::get('/getRole/{id}', [App\Http\Controllers\RoleController::class, 'show'])->name('getRole');
    Route::get('/deleteRole/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('deleteRole');

    Route::get('/themes', [App\Http\Controllers\ThemesController::class, 'index'])->name('themes');
    Route::post('/themeStore', [App\Http\Controllers\ThemesController::class, 'store'])->name('themeStore');
    Route::get('/getTheme/{id}', [App\Http\Controllers\ThemesController::class, 'show'])->name('getTheme');
    Route::get('/deleteTheme/{id}', [App\Http\Controllers\ThemesController::class, 'destroy'])->name('deleteTheme');

    Route::get('/emotions', [App\Http\Controllers\EmossionsController::class, 'index'])->name('emotions');
    Route::post('/emotionStore', [App\Http\Controllers\EmossionsController::class, 'store'])->name('emotionStore');
    Route::get('/getEmotion/{id}', [App\Http\Controllers\EmossionsController::class, 'show'])->name('getEmotion');
    Route::get('/deleteEmotion/{id}', [App\Http\Controllers\EmossionsController::class, 'destroy'])->name('deleteEmotion');

    Route::get('/specialUID', [App\Http\Controllers\SpecialIDController::class, 'index'])->name('specialUID');
    Route::post('/specialUIDStore', [App\Http\Controllers\SpecialIDController::class, 'store'])->name('specialUIDStore');
    Route::get('/getSpecialUID/{id}', [App\Http\Controllers\SpecialIDController::class, 'show'])->name('getSpecialUID');
    Route::get('/deleteSpecialUID/{id}', [App\Http\Controllers\SpecialIDController::class, 'destroy'])->name('deleteSpecialUID');

    Route::get('/designPurchases', [App\Http\Controllers\DesignPurchaseController::class, 'index'])->name('designPurchases');

    Route::get('/appUsers/{enable}', [App\Http\Controllers\AppUserController::class, 'index'])->name('appUsers');
    Route::get('/chargeAppUserBalance', [App\Http\Controllers\AppUserController::class, 'chargeAppUserBalance'])->name('chargeAppUserBalance');
    Route::get('/userNotifications', [App\Http\Controllers\AppUserController::class, 'userNotifications'])->name('userNotifications');
    Route::get('/getAppUserByTag/{tag}', [App\Http\Controllers\AppUserController::class, 'show'])->name('getAppUserByTag');
    Route::get('/getAppUserById/{id}', [App\Http\Controllers\AppUserController::class, 'showById'])->name('getAppUserById');

    Route::post('/updateDiamondWallet', [App\Http\Controllers\AppUserController::class, 'updateDiamondWallet'])->name('updateDiamondWallet');
    Route::post('/updateGoldWallet', [App\Http\Controllers\AppUserController::class, 'updateGoldWallet'])->name('updateGoldWallet');

    Route::post('/sendNotification', [App\Http\Controllers\AppUserController::class, 'sendNotification'])->name('sendNotification');
    Route::get('/deleteNotification/{id}', [App\Http\Controllers\AppUserController::class, 'destroy'])->name('deleteNotification');
    Route::post('/updateAppUser', [App\Http\Controllers\AppUserController::class, 'Update'])->name('updateAppUser');

    Route::get('/rooms/{state}', [App\Http\Controllers\ChatRoomController::class, 'index'])->name('chatRooms');

    Route::get('/festival_banners', [App\Http\Controllers\FestivalBannerController::class, 'index'])->name('festival_banners');
    Route::post('/festivalBannerStore', [App\Http\Controllers\FestivalBannerController::class, 'store'])->name('festivalBannerStore');
    Route::get('/getFestivalBanner/{id}', [App\Http\Controllers\FestivalBannerController::class, 'show'])->name('getFestivalBanner');

    Route::get('/gift_transactions', [App\Http\Controllers\GiftTransactionController::class, 'index'])->name('gift_transactions');

    Route::get('/tags', [App\Http\Controllers\TagController::class, 'index'])->name('tags');
    Route::post('/tagStore', [App\Http\Controllers\TagController::class, 'store'])->name('tagStore');
    Route::get('/getTag/{id}', [App\Http\Controllers\TagController::class, 'show'])->name('getTag');
    Route::get('/deleteTag/{id}', [App\Http\Controllers\TagController::class, 'destroy'])->name('deleteTag');

    Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts');
    Route::get('/getPost/{id}', [App\Http\Controllers\PostController::class, 'show'])->name('getPost');
    Route::get('/deletePost/{id}', [App\Http\Controllers\PostController::class, 'destroy'])->name('deletePost');
    Route::get('/acceptPost/{id}', [App\Http\Controllers\PostController::class, 'acceptPost'])->name('acceptPost');

    Route::get('/targets', [App\Http\Controllers\TargetController::class, 'index'])->name('targets');
    Route::get('/getTarget/{id}', [App\Http\Controllers\TargetController::class, 'show'])->name('getTarget');
    Route::get('/deleteTarget/{id}', [App\Http\Controllers\TargetController::class, 'destroy'])->name('deleteTarget');
    Route::post('/targetStore', [App\Http\Controllers\TargetController::class, 'store'])->name('targetStore');

    Route::get('/agencies', [App\Http\Controllers\HostAgencyController::class, 'index'])->name('agencies');
    Route::get('/getAgency/{id}', [App\Http\Controllers\HostAgencyController::class, 'show'])->name('getAgency');
    Route::get('/deleteAgency/{id}', [App\Http\Controllers\HostAgencyController::class, 'destroy'])->name('deleteAgency');
    Route::post('/agencyStore', [App\Http\Controllers\HostAgencyController::class, 'store'])->name('agencyStore');
    Route::get('/getAgencyTag', [App\Http\Controllers\HostAgencyController::class, 'create'])->name('getAgencyTag');

});
