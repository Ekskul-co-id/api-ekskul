<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ComentController;
use App\Http\Controllers\LivestreamController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
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
    ],200);
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

Route::post('/login',[AuthController::class,'login'])->name('login');
Route::post('/register',[AuthController::class,'register'])->name('register');
Route::post('/logout',[AuthController::class,'logout']);
Route::post('/verify',[VerifyEmailController::class,'verify'])->middleware('auth:sanctum')->name('verification.verify');
Route::post('/verify/resend',[VerifyEmailController::class,'resend'])->middleware('auth:sanctum')->name('verification.send');


// Payment handling
Route::post('/webhooks',[WebhookController::class,'midtransHandler']);

Route::group(['prefix' => 'v1', 'middleware' => ['auth:sanctum','verified']], function () {
    Route::get('/', function () {
        return response()->json([
            "status" => "success",
            "message" => "Api Ekskul.co.id v1",
            "data" => null
        ],200);
    });
    
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', function () {
            return response()->json([
                "status" => "success",
                "message" => "Welcome admin.",
                "data" => null
            ],200);
        });
        
        // User handling 
        Route::group(['prefix' => 'users'], function () {
            Route::get('/',[UserController::class,'index']);
            Route::post('/',[UserController::class,'store']);
            Route::get('/{id}',[UserController::class,'show']);
            Route::put('/{id}',[UserController::class,'update']);
            Route::delete('/{id}',[UserController::class,'destroy']);
        });

        // Settings 
        Route::group(['prefix' => 'settings'], function () {
            Route::get('/',[SettingsController::class,'index']);
            Route::post('/',[SettingsController::class,'store']);
            Route::get('/{id}',[SettingsController::class,'show']);
            Route::post('/{id}',[SettingsController::class,'update']);
            Route::get('/{id}',[SettingsController::class,'destroy']);
        });

        // Playlist 
        Route::group(['prefix' => 'playlists'], function () {
            Route::get('/',[PlaylistController::class,'index']);
            Route::post('/',[PlaylistController::class,'store']);
            Route::get('/{id}',[PlaylistController::class,'show']);
            Route::post('/{id}',[PlaylistController::class,'update']);
            Route::get('/{id}',[PlaylistController::class,'destroy']);
        });

        // Category 
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/',[CategoryController::class,'index']);
            Route::post('/',[CategoryController::class,'store']);
            Route::get('/{id}',[CategoryController::class,'show']);
            Route::put('/{id}',[CategoryController::class,'update']);
            Route::delete('/{id}',[CategoryController::class,'destroy']);
        });

        // Roles 
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/',[RoleController::class,'index']);
            Route::post('/',[RoleController::class,'store']);
            Route::get('/{id}',[RoleController::class,'show']);
            Route::put('/{id}',[RoleController::class,'update']);
            Route::delete('/{id}',[RoleController::class,'destroy']);
        });

        // Video Managemnt 
        Route::group(['prefix' => 'videos'], function () {
            Route::get('/',[VideoController::class,'index']);
            Route::post('/',[VideoController::class,'store']);
            Route::get('/{id}',[VideoController::class,'show']);
            Route::put('/{id}',[VideoController::class,'update']);
            Route::delete('/{id}',[VideoController::class,'destroy']);
        });

        // Livestream 
        Route::group(['prefix' => 'livestreams'], function () {
            Route::get('/',[LivestreamController::class,'index']);
            Route::post('/',[LivestreamController::class,'store']);
            Route::get('/{id}',[LivestreamController::class,'show']);
            Route::put('/{id}',[LivestreamController::class,'update']);
            Route::delete('/{id}',[LivestreamController::class,'destroy']);
        });

        // Comment livestream 
        Route::group(['prefix' => 'comments'], function () {
            Route::get('/',[ComentController::class,'index']);
            Route::post('/',[ComentController::class,'store']);
            Route::get('/{id}',[ComentController::class,'show']);
            Route::put('/{id}',[ComentController::class,'update']);
            Route::delete('/{id}',[ComentController::class,'destroy']);
        });

        // Rating
        Route::group(['prefix' => 'ratings'], function () {
            Route::get('/',[RatingController::class,'index']);
            Route::post('/',[RatingController::class,'store']);
            Route::get('/{id}',[RatingController::class,'show']);
            Route::put('/{id}',[RatingController::class,'update']);
            Route::delete('/{id}',[RatingController::class,'destroy']);
        });
    });

    // Menu
    Route::group(['prefix' => 'orders'], function () {
        Route::get('/',[OrderController::class,'index']);
        Route::post('/',[OrderController::class,'store']);
        Route::get('/{id}',[OrderController::class,'show']);
    });
    
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/',[MenuController::class,'listCategory']); // list semua category
        Route::get('/{slug}',[MenuController::class,'detailCategory']); // show detail category dengan list playlist berdasarkan category yang di pilih
    });
    
    Route::group(['prefix' => 'playlists'], function () {
        Route::get('/',[MenuController::class,'listPlaylist']); // list semua playlist
        Route::get('/{slug}',[MenuController::class,'detailPlaylist']); // detail playlist beserta video
        Route::post('/{slug}/ratings',[MenuController::class,'storeRating']);
        Route::put('/{slug}/ratings',[MenuController::class,'updateRating']);
    });
    
    // Profile
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/',[ProfileController::class,'index']);
        Route::put('/',[ProfileController::class,'update']);
        Route::put('/password',[ProfileController::class,'changePassword']);
    });
});
