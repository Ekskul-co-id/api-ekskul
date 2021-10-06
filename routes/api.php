<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ComentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LivestreamController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
    return response()->json([
        "works" => "it workss"
    ], 200);
});

Route::get('fresh-db', function () {
    Artisan::call('migrate:fresh --seed --force');

    return response()->json([
        "status" => "success",
        "message" => "Success fresh database.",
        "data" => null
    ], 200);
});

Route::get('refresh-cache', function () {
    Artisan::call('optimize');
    Artisan::call('optimize:clear');

    return response()->json([
        "status" => "success",
        "message" => "Success refresh cache.",
        "data" => null
    ], 200);
});

Route::group(['prefix' => 'auth'], function () {
    Route::get('/{provider}', [AuthController::class, 'redirectToProvider']);
    Route::get('/{provider}/callback', [AuthController::class, 'handleProviderCallback']);
    Route::post('/handle-oauth', [AuthController::class, 'handleOauth']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/verify', [VerifyEmailController::class, 'verify'])->middleware('auth:sanctum')->name('verification.verify');
    Route::post('/verify/resend', [VerifyEmailController::class, 'resend'])->middleware('auth:sanctum')->name('verification.send');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'forgot']);
    Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'reset']);
});
// Payment handling
Route::post('/webhooks', [WebhookController::class, 'midtransHandler']);

Route::group(['prefix' => 'v1', 'middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/', function () {
        return response()->json([
            "status" => "success",
            "message" => "Api Ekskul.co.id v1",
            "data" => null
        ], 200);
    });

    Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {
        Route::get('/', function () {
            return response()->json([
                "status" => "success",
                "message" => "Welcome admin.",
                "data" => null
            ], 200);
        });

        // User handling
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
            Route::get('/{user:id}', [UserController::class, 'show']);
            Route::put('/{user:id}', [UserController::class, 'update']);
            Route::delete('/{user:id}', [UserController::class, 'destroy']);
        });

        // Settings
        Route::group(['prefix' => 'settings'], function () {
            Route::get('/', [SettingController::class, 'index']);
            Route::post('/', [SettingController::class, 'store']);
            Route::get('/{setting:id}', [SettingController::class, 'show']);
            Route::post('/{setting:id}', [SettingController::class, 'update']);
            Route::get('/{setting:id}', [SettingController::class, 'destroy']);
        });

        // Course
        Route::group(['prefix' => 'courses'], function () {
            Route::get('/', [CourseController::class, 'index']);
            Route::post('/', [CourseController::class, 'store']);
            Route::get('/{course:id}', [CourseController::class, 'show']);
            Route::post('/{course:id}', [CourseController::class, 'update']);
            Route::get('/{course:id}', [CourseController::class, 'destroy']);
        });

        // Playlist
        Route::group(['prefix' => 'playlists'], function () {
            Route::get('/', [PlaylistController::class, 'index']);
            Route::post('/', [PlaylistController::class, 'store']);
            Route::get('/{playlist:id}', [PlaylistController::class, 'show']);
            Route::post('/{playlist:id}', [PlaylistController::class, 'update']);
            Route::get('/{playlist:id}', [PlaylistController::class, 'destroy']);
        });

        // Category
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::post('/', [CategoryController::class, 'store']);
            Route::get('/{category:id}', [CategoryController::class, 'show']);
            Route::put('/{category:id}', [CategoryController::class, 'update']);
            Route::delete('/{category:id}', [CategoryController::class, 'destroy']);
        });

        // Roles
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [RoleController::class, 'index']);
            Route::post('/', [RoleController::class, 'store']);
            Route::get('/{role:id}', [RoleController::class, 'show']);
            Route::put('/{role:id}', [RoleController::class, 'update']);
            Route::delete('/{role:id}', [RoleController::class, 'destroy']);
        });

        // Video Managemnt
        Route::group(['prefix' => 'videos'], function () {
            Route::get('/', [VideoController::class, 'index']);
            Route::post('/', [VideoController::class, 'store']);
            Route::get('/{video:id}', [VideoController::class, 'show']);
            Route::put('/{video:id}', [VideoController::class, 'update']);
            Route::delete('/{video:id}', [VideoController::class, 'destroy']);
        });

        // Livestream
        Route::group(['prefix' => 'livestreams'], function () {
            Route::get('/', [LivestreamController::class, 'index']);
            Route::post('/', [LivestreamController::class, 'store']);
            Route::get('/{livestream:id}', [LivestreamController::class, 'show']);
            Route::put('/{livestream:id}', [LivestreamController::class, 'update']);
            Route::delete('/{livestream:id}', [LivestreamController::class, 'destroy']);
        });

        // Comment livestream
        Route::group(['prefix' => 'comments'], function () {
            Route::get('/', [ComentController::class, 'index']);
            Route::post('/', [ComentController::class, 'store']);
            Route::get('/{comment:id}', [ComentController::class, 'show']);
            Route::put('/{comment:id}', [ComentController::class, 'update']);
            Route::delete('/{comment:id}', [ComentController::class, 'destroy']);
        });

        // Rating
        Route::group(['prefix' => 'ratings'], function () {
            Route::get('/', [RatingController::class, 'index']);
            Route::post('/', [RatingController::class, 'store']);
            Route::get('/{rating:id}', [RatingController::class, 'show']);
            Route::put('/{rating:id}', [RatingController::class, 'update']);
            Route::delete('/{rating:id}', [RatingController::class, 'destroy']);
        });

        // Payment log
        Route::group(['prefix' => 'logs'], function () {
            Route::get('/', [LogController::class, 'index']);
            Route::post('/', [LogController::class, 'store']);
            Route::get('/{log:id}', [LogController::class, 'show']);
            Route::put('/{log:id}', [LogController::class, 'update']);
            Route::delete('/{log:id}', [LogController::class, 'destroy']);
        });

        // Announcement
        Route::group(['prefix' => 'announcements'], function () {
            Route::get('/', [AnnouncementController::class, 'index']);
            Route::post('/', [AnnouncementController::class, 'store']);
            Route::get('/{announcement:id}', [AnnouncementController::class, 'show']);
            Route::put('/{announcement:id}', [AnnouncementController::class, 'update']);
            Route::delete('/{announcement:id}', [AnnouncementController::class, 'destroy']);
        });

        // Company
        Route::group(['prefix' => 'companies'], function () {
            Route::get('/', [CompanyController::class, 'index']);
            Route::post('/', [CompanyController::class, 'store']);
            Route::get('/{company:slug}', [CompanyController::class, 'show']);
            Route::put('/{company:slug}', [CompanyController::class, 'update']);
            Route::delete('/{company:slug}', [CompanyController::class, 'destroy']);
        });
    });

    // Menu
    Route::get('/banner', [SettingController::class, 'index']);

    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'store']);
        Route::get('/{checkout:id}', [OrderController::class, 'show']);
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [MenuController::class, 'listCategory']); // list semua category
        Route::get('/{category:slug}', [MenuController::class, 'detailCategory']); // show detail category dengan list course berdasarkan category yang di pilih
    });

    Route::group(['prefix' => 'courses'], function () {
        Route::get('/', [MenuController::class, 'listCourse']); // list semua course
        Route::get('/popular', [MenuController::class, 'popularCourse']);
        Route::get('/{course:slug}', [MenuController::class, 'detailCourse']); // detail course beserta video
        Route::post('/{course:slug}/ratings', [MenuController::class, 'storeRating']);
        Route::put('/{course:slug}/ratings', [MenuController::class, 'updateRating']);
    });

    Route::group(['prefix' => 'livestreams'], function () {
        Route::get('/', [MenuController::class, 'listLivestream']);
        Route::get('/{livestream:slug}', [MenuController::class, 'detailLivestream']);
    });
    
    Route::group(['prefix' => 'companies'], function () {
        Route::get('/', [MenuController::class, 'listCompany']);
        Route::get('/{company:slug}', [MenuController::class, 'detailCompany']);
        Route::get('/{company:slug}/courses', [MenuController::class, 'coursesCompany']);
    });

    // User menu
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'index']);
        Route::put('/', [ProfileController::class, 'update']);
        Route::put('/password', [ProfileController::class, 'changePassword']);
    });

    Route::get('/my-courses', [MenuController::class, 'myCourse']);
    Route::get('/my-courses/{course:slug}', [MenuController::class, 'detailMyCourse']);
    Route::post('/my-courses/{course:slug}/mark-watched', [MenuController::class, 'markWatched']);
    Route::get('/my-announcements', [MenuController::class, 'myAnnouncement']);
    Route::get('/my-announcements/{announcement:id}', [MenuController::class, 'detailMyAnnouncement']);
    Route::get('/my-livestreams', [MenuController::class, 'myLivestream']);
    Route::get('/my-livestreams/{livestream:slug}', [MenuController::class, 'detailMyLivestream']);
});