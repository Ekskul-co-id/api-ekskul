<?php

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
        'works' => 'it workss',
    ], 200);
});

Route::get('fresh-db', function () {
    Artisan::call('migrate:fresh --seed --force');

    return response()->json([
        'status' => 'success',
        'message' => 'Success fresh database.',
        'data' => null,
    ], 200);
});

Route::get('refresh-cache', function () {
    Artisan::call('optimize');
    Artisan::call('optimize:clear');

    return response()->json([
        'status' => 'success',
        'message' => 'Success refresh cache.',
        'data' => null,
    ], 200);
});

Route::group(['prefix' => 'auth'], function () {
    Route::get('/{provider}', 'AuthController@redirectToProvider');
    Route::get('/{provider}/callback', 'AuthController@handleProviderCallback');
    Route::post('/handle-oauth', 'AuthController@handleOauth');
    Route::post('/login', 'AuthController@login')->name('login');
    Route::post('/register', 'AuthController@register')->name('register');
    Route::post('/logout', 'AuthController@logout')->middleware('auth:sanctum');
    Route::post('/verify', 'VerifyEmailController@verify')->middleware('auth:sanctum')->name('verification.verify');
    Route::post('/verify/resend', 'VerifyEmailController@resend')->middleware('auth:sanctum')->name('verification.send');
    Route::post('/forgot-password', 'ForgotPasswordController@forgot');
    Route::post('/forgot-password/reset', 'ForgotPasswordController@reset');
});
// Payment handling
Route::post('/webhooks', 'WebhookController@midtransHandler');

Route::group(['prefix' => 'v1', 'middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/', function () {
        return response()->json([
            'status' => 'success',
            'message' => 'Api Ekskul.co.id v1',
            'data' => null,
        ], 200);
    });

    Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {
        Route::get('/', function () {
            return response()->json([
                'status' => 'success',
                'message' => 'Welcome admin.',
                'data' => null,
            ], 200);
        });

        // User handling
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'UserController@index');
            Route::post('/', 'UserController@store');
            Route::get('/{user:id}', 'UserController@show');
            Route::put('/{user:id}', 'UserController@update');
            Route::delete('/{user:id}', 'UserController@destroy');
        });

        // Settings
        Route::group(['prefix' => 'settings'], function () {
            Route::get('/', 'SettingController@index');
            Route::post('/', 'SettingController@store');
            Route::get('/{setting:id}', 'SettingController@show');
            Route::post('/{setting:id}', 'SettingController@update');
            Route::get('/{setting:id}', 'SettingController@destroy');
        });

        // Course
        Route::group(['prefix' => 'courses'], function () {
            Route::get('/', 'CourseController@index');
            Route::post('/', 'CourseController@store');
            Route::get('/{course:id}', 'CourseController@show');
            Route::post('/{course:id}', 'CourseController@update');
            Route::get('/{course:id}', 'CourseController@destroy');
        });

        // Playlist
        Route::group(['prefix' => 'playlists'], function () {
            Route::get('/', 'PlaylistController@index');
            Route::post('/', 'PlaylistController@store');
            Route::get('/{playlist:id}', 'PlaylistController@show');
            Route::post('/{playlist:id}', 'PlaylistController@update');
            Route::get('/{playlist:id}', 'PlaylistController@destroy');
        });

        // Category
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', 'CategoryController@index');
            Route::post('/', 'CategoryController@store');
            Route::get('/{category:id}', 'CategoryController@show');
            Route::put('/{category:id}', 'CategoryController@update');
            Route::delete('/{category:id}', 'CategoryController@destroy');
        });

        // Roles
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', 'RoleController@index');
            Route::post('/', 'RoleController@store');
            Route::get('/{role:id}', 'RoleController@show');
            Route::put('/{role:id}', 'RoleController@update');
            Route::delete('/{role:id}', 'RoleController@destroy');
        });

        // Video Managemnt
        Route::group(['prefix' => 'videos'], function () {
            Route::get('/', 'VideoController@index');
            Route::post('/', 'VideoController@store');
            Route::get('/{video:id}', 'VideoController@show');
            Route::put('/{video:id}', 'VideoController@update');
            Route::delete('/{video:id}', 'VideoController@destroy');
        });

        // Livestream
        Route::group(['prefix' => 'livestreams'], function () {
            Route::get('/', 'LivestreamController@index');
            Route::post('/', 'LivestreamController@store');
            Route::get('/{livestream:id}', 'LivestreamController@show');
            Route::put('/{livestream:id}', 'LivestreamController@update');
            Route::delete('/{livestream:id}', 'LivestreamController@destroy');
        });

        // Comment livestream
        Route::group(['prefix' => 'comments'], function () {
            Route::get('/', 'ComentController@index');
            Route::post('/', 'ComentController@store');
            Route::get('/{comment:id}', 'ComentController@show');
            Route::put('/{comment:id}', 'ComentController@update');
            Route::delete('/{comment:id}', 'ComentController@destroy');
        });

        // Rating
        Route::group(['prefix' => 'ratings'], function () {
            Route::get('/', 'RatingController@index');
            Route::post('/', 'RatingController@store');
            Route::get('/{rating:id}', 'RatingController@show');
            Route::put('/{rating:id}', 'RatingController@update');
            Route::delete('/{rating:id}', 'RatingController@destroy');
        });

        // Payment log
        Route::group(['prefix' => 'logs'], function () {
            Route::get('/', 'LogController@index');
            Route::post('/', 'LogController@store');
            Route::get('/{log:id}', 'LogController@show');
            Route::put('/{log:id}', 'LogController@update');
            Route::delete('/{log:id}', 'LogController@destroy');
        });

        // Announcement
        Route::group(['prefix' => 'announcements'], function () {
            Route::get('/', 'AnnouncementController@index');
            Route::post('/', 'AnnouncementController@store');
            Route::get('/{announcement:id}', 'AnnouncementController@show');
            Route::put('/{announcement:id}', 'AnnouncementController@update');
            Route::delete('/{announcement:id}', 'AnnouncementController@destroy');
        });

        // Company
        Route::group(['prefix' => 'companies'], function () {
            Route::get('/', 'CompanyController@index');
            Route::post('/', 'CompanyController@store');
            Route::get('/{company:slug}', 'CompanyController@show');
            Route::put('/{company:slug}', 'CompanyController@update');
            Route::delete('/{company:slug}', 'CompanyController@destroy');
        });
    });

    // Menu
    Route::get('/banner', 'SettingController@index');

    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', 'OrderController@index');
        Route::post('/', 'OrderController@store');
        Route::get('/{checkout:id}', 'OrderController@show');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'MenuController@listCategory'); // list semua category
        Route::get('/{category:slug}', 'MenuController@detailCategory'); // show detail category dengan list course berdasarkan category yang di pilih
    });

    Route::group(['prefix' => 'courses'], function () {
        Route::get('/', 'MenuController@listCourse'); // list semua course
        Route::get('/popular', 'MenuController@popularCourse');
        Route::get('/{course:slug}', 'MenuController@detailCourse'); // detail course beserta video
        Route::post('/{course:slug}/ratings', 'MenuController@storeRating');
        Route::put('/{course:slug}/ratings', 'MenuController@updateRating');
    });

    Route::group(['prefix' => 'livestreams'], function () {
        Route::get('/', 'MenuController@listLivestream');
        Route::get('/{livestream:slug}', 'MenuController@detailLivestream');
    });

    Route::group(['prefix' => 'companies'], function () {
        Route::get('/', 'MenuController@listCompany');
        Route::get('/{company:slug}', 'MenuController@detailCompany');
        Route::get('/{company:slug}/courses', 'MenuController@coursesCompany');
    });

    // User menu
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', 'ProfileController@index');
        Route::put('/', 'ProfileController@update');
        Route::put('/password', 'ProfileController@changePassword');
    });

    Route::get('/my-courses', 'MenuController@myCourse');
    Route::get('/my-courses/{course:slug}', 'MenuController@detailMyCourse');
    Route::post('/my-courses/{course:slug}/mark-watched', 'MenuController@markWatched');
    Route::get('/my-announcements', 'MenuController@myAnnouncement');
    Route::get('/my-announcements/{announcement:id}', 'MenuController@detailMyAnnouncement');
    Route::get('/my-livestreams', 'MenuController@myLivestream');
    Route::get('/my-livestreams/{livestream:slug}', 'MenuController@detailMyLivestream');
});
