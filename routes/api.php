        <?php

use App\Http\Controllers\Websockets\WebsocketHandlers\ChatRoomHandler as WebsocketHandlersChatRoomHandler;
use App\Http\Websockets\WebsocketHandlers\ChatRoomHandler;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
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
        Route::get('/Account/hoppies', [App\Http\Controllers\Api\AppUserController::class, 'getHoppies'])->name('getHoppies');
        Route::post('/Account/hoppies/Add', [App\Http\Controllers\Api\AppUserController::class, 'addHoppy'])->name('addHoppy');
        Route::get('/Account/designs/all/{id}', [App\Http\Controllers\Api\AppUserController::class, 'getUserDesigns'])->name('getUserDesigns');
        Route::get('/Account/getUSerByTag/{tag}', [App\Http\Controllers\Api\AppUserController::class, 'getUSerByTag'])->name('getUSerByTag');
        Route::get('/Account/gifts/all/{id}', [App\Http\Controllers\Api\AppUserController::class, 'getUserGifts'])->name('getUserGifts');
        Route::get('/Account/getUserLevelsData/{id}', [App\Http\Controllers\Api\AppUserController::class, 'getUserLevelsData'])->name('getUserLevelsData');

        
        

        Route::post('/Account/name/update', [App\Http\Controllers\Api\AppUserController::class, 'updateUserName'])->name('updateUserName');
        Route::post('/Account/birthdate/update', [App\Http\Controllers\Api\AppUserController::class, 'updateUserBirthdate'])->name('updateUserBirthdate');
        Route::post('/Account/country/update', [App\Http\Controllers\Api\AppUserController::class, 'updateUserCountry'])->name('updateUserCountry');
        Route::post('/Account/img/update', [App\Http\Controllers\Api\AppUserController::class, 'updateUserProfile'])->name('updateUserProfile');
        Route::post('/Account/cover/update', [App\Http\Controllers\Api\AppUserController::class, 'updateUserCoverPhoto'])->name('updateUserCoverPhoto');
        Route::post('/Account/status/update', [App\Http\Controllers\Api\AppUserController::class, 'updateUserStatus'])->name('updateUserStatus');
        Route::post('/Account/reportUser', [App\Http\Controllers\Api\AppUserController::class, 'reportUser'])->name('reportUser');
        Route::post('/Account/blockUser', [App\Http\Controllers\Api\AppUserController::class, 'blockUser'])->name('blockUser');
        Route::post('/Account/unblockUser', [App\Http\Controllers\Api\AppUserController::class, 'unblockUser'])->name('unblockUser');
        Route::post('/Account/followUser', [App\Http\Controllers\Api\AppUserController::class, 'followUser'])->name('followUser');
        Route::post('/Account/unfollowkUser', [App\Http\Controllers\Api\AppUserController::class, 'unfollowkUser'])->name('unfollowkUser');
        Route::post('/Account/updateToken', [App\Http\Controllers\Api\AppUserController::class, 'updateUserToken'])->name('updateUserToken');
        Route::post('/Account/updateUserGender', [App\Http\Controllers\Api\AppUserController::class, 'updateUserGender'])->name('updateUserGender');
        Route::get('/Account/checkUserISAgencyMember/{user_id}', [App\Http\Controllers\Api\AppUserController::class, 'checkUserISAgencyMember'])->name('checkUserISAgencyMember');


        

        

        Route::get('/Banners/getAll', [App\Http\Controllers\Api\BannerController::class, 'index'])->name('getAllBanners');
        Route::get('/Countries/getAll', [App\Http\Controllers\Api\CountryController::class, 'index'])->name('getAllCountries');
        
        Route::get('/chatRooms/getAll', [App\Http\Controllers\Api\ChatRoomController::class, 'index'])->name('getAllChatRooms');
        Route::get('/chatRooms/getRoom/{user_id}', [App\Http\Controllers\Api\ChatRoomController::class, 'checkRoom'])->name('checkRoom');
        Route::get('/chatRooms/getBasicData', [App\Http\Controllers\Api\ChatRoomController::class, 'getRoomBasicData'])->name('getRoomBasicData');
        Route::post('/chatRooms/updateName', [App\Http\Controllers\Api\ChatRoomController::class, 'updateRoomName'])->name('updateName');
        Route::post('/chatRooms/updateHello', [App\Http\Controllers\Api\ChatRoomController::class, 'updateRoomHelloText'])->name('updateHello');
        Route::post('/chatRooms/updatePassword', [App\Http\Controllers\Api\ChatRoomController::class, 'updateRoomPassword'])->name('updatePassword');
        Route::get('/chatRooms/getRoomById/{room_id}', [App\Http\Controllers\Api\ChatRoomController::class, 'getRoom'])->name('getRoomById');
        Route::get('/chatRooms/getRoomByAdmin/{admin_id}', [App\Http\Controllers\Api\ChatRoomController::class, 'getRoomByAdmin'])->name('getRoomByAdmin');
        Route::get('/chatRooms/trackUser/{user_id}', [App\Http\Controllers\Api\ChatRoomController::class, 'trackUser'])->name('trackUser');

        Route::post('/chatRooms/updateRoomImage', [App\Http\Controllers\Api\ChatRoomController::class, 'updateRoomImage'])->name('updateRoomImage');
        Route::post('/chatRooms/updateRoomCategory', [App\Http\Controllers\Api\ChatRoomController::class, 'updateRoomCategory'])->name('updateRoomCategory');
        Route::post('/chatRooms/addAdmin', [App\Http\Controllers\Api\ChatRoomController::class, 'addRoomAdmin'])->name('addRoomAdmin');
        Route::post('/chatRooms/removeAdmin', [App\Http\Controllers\Api\ChatRoomController::class, 'removeRoomAdmin'])->name('removeRoomAdmin');
        Route::get('/chatRooms/toggleCounter/{room_id}', [App\Http\Controllers\Api\ChatRoomController::class, 'toggleCounter'])->name('toggleCounter');



        Route::post('/chatRooms/enterRoom', [App\Http\Controllers\Api\ChatRoomController::class, 'enterRoom'])->name('enterRoom');
        Route::post('/chatRooms/exitRoom', [App\Http\Controllers\Api\ChatRoomController::class, 'exitRoom'])->name('exitRoom');
        Route::post('/chatRooms/lockMic', [App\Http\Controllers\Api\ChatRoomController::class, 'lockMic'])->name('lockMic');
        Route::post('/chatRooms/unlockMic', [App\Http\Controllers\Api\ChatRoomController::class, 'unlockMic'])->name('unlockMic');
        Route::post('/chatRooms/useMic', [App\Http\Controllers\Api\ChatRoomController::class, 'useMic'])->name('useMic');
        Route::post('/chatRooms/leaveMic', [App\Http\Controllers\Api\ChatRoomController::class, 'leaveMic'])->name('leaveMic');
        Route::post('/chatRooms/chnageRoomBg', [App\Http\Controllers\Api\ChatRoomController::class, 'chnageRoomBg'])->name('chnageRoomBg');
        Route::get('/chatRooms/getRoomCup/{room_id}', [App\Http\Controllers\Api\ChatRoomController::class, 'getRoomCup'])->name('getRoomCup');


        
        
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
        Route::get('/posts/getUserPosts/{user}', [App\Http\Controllers\Api\PostsController::class, 'getUserPosts'])->name('getUserPosts');

        
    
        Route::get('/store/cats/all', [App\Http\Controllers\Api\StoreController::class, 'getAllStoreCategory'])->name('getAllStoreCategory');
        Route::get('/store/designs/all', [App\Http\Controllers\Api\StoreController::class, 'getAllDesigns'])->name('getAllDesigns');
        Route::post('/store/design/purchase', [App\Http\Controllers\Api\StoreController::class, 'purchaseDesign'])->name('purchaseDesign');
        Route::get('/notifications/all/{user_id}', [App\Http\Controllers\Api\UserNotificationController::class, 'getAllUserNotifications'])->name('getAllUserNotifications');
      
        Route::post('/wallet/charge', [App\Http\Controllers\Api\WalletController::class, 'ChargeWallet'])->name('ChargeWallet');
        Route::get('/wallet/getWallet/{user_id}', [App\Http\Controllers\Api\WalletController::class, 'getWallet'])->name('getWallet');
        Route::post('/wallet/exchangeDiamond', [App\Http\Controllers\Api\WalletController::class, 'exchangeDiamond'])->name('exchangeDiamond');
        Route::get('/wallet/getChargingTransactions/{user_id}', [App\Http\Controllers\Api\WalletController::class, 'getChargingTransactions'])->name('getChargingTransactions');
        Route::get('/wallet/getSettings', [App\Http\Controllers\Api\WalletController::class, 'getTransactionSettings'])->name('getSettings');

        
        Route::get('/levels/getLevels', [App\Http\Controllers\Api\LevelsController::class, 'getLevels'])->name('getLevels');

        Route::post('/createUserNotification', [App\Http\Controllers\Api\UserNotificationController::class, 'createUserNotification'])->name('getLevels');

        Route::get('/designa/all', [App\Http\Controllers\Api\DesignController::class, 'getAllCatsWithDesigns'])->name('getAllCatsWithDesigns');
        Route::post('/designa/use', [App\Http\Controllers\Api\StoreController::class, 'useDesign'])->name('useDesign');


        Route::get('/chats/all/{user_id}', [App\Http\Controllers\Api\ChatController::class, 'getUserChats'])->name('getUserChats');
        Route::post('/chats/sendMsg', [App\Http\Controllers\Api\ChatController::class, 'sendMessage'])->name('sendMsg');


        Route::get('/vip/all', [App\Http\Controllers\Api\VipController::class, 'index'])->name('getVip');
        Route::get('/vip/getAll', [App\Http\Controllers\Api\VipController::class, 'getVip'])->name('getVipAll');
        Route::post('/vip/purchaseVip', [App\Http\Controllers\Api\VipController::class, 'purchaseVip'])->name('purchaseVip');
        Route::get('/vip/getUserVips/{user_id}', [App\Http\Controllers\Api\VipController::class, 'getUserVips'])->name('getUserVips');
        Route::post('/vip/use', [App\Http\Controllers\Api\VipController::class, 'useVip'])->name('useVip');


        
        
        Route::get('/designs/medal/all', [App\Http\Controllers\Api\DesignController::class, 'getAllMedals'])->name('getAllMedals');


        Route::post('/chargingAgency/addBalance', [App\Http\Controllers\Api\ChargingAgencyController::class, 'AddBalanceToUser'])->name('AddBalanceToUser');
        Route::get('/chargingAgency/getAgency/{user_id}', [App\Http\Controllers\Api\ChargingAgencyController::class, 'getAgency'])->name('getAgency');
        Route::get('/chargingAgency/operations/{agency_id}', [App\Http\Controllers\Api\ChargingAgencyController::class, 'getAgencyOperations'])->name('getAgencyOperations');

        Route::get('/hostAgency/getAgencyByTag/{tag}', [App\Http\Controllers\Api\HostAgencyController::class, 'getAgencyByTag'])->name('getAgencyByTag');
        Route::post('/hostAgency/JoinAgencyRequest', [App\Http\Controllers\Api\HostAgencyController::class, 'JoinAgencyRequest'])->name('JoinAgencyRequest');

        Route::get('/hostAgency/getAgencyMembers/{agent_id}', [App\Http\Controllers\Api\HostAgencyController::class, 'getAgencyMembers'])->name('getAgencyMembers');
        Route::get('/hostAgency/getAgencyMemberStatics/{user_id}', [App\Http\Controllers\Api\HostAgencyController::class, 'getAgencyMemberStatics'])->name('getAgencyMemberStatics');


        Route::get('/hostAgency/testStat/{user_id}/{state}', [App\Http\Controllers\Api\ChatRoomController::class, 'updateHostAgencyRecords'])->name('updateHostAgencyRecords');

        Route::post('/gifts/sendGift', [App\Http\Controllers\Api\GiftController::class, 'sendGiftToUser'])->name('sendGiftToUser');

        Route::get('/app/appCup', [App\Http\Controllers\Api\ChatRoomController::class, 'getAppCup'])->name('getAppCup');

        