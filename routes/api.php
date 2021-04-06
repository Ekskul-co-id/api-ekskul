<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WebhooksController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\LivestreamController;
use App\Http\Controllers\ComentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Artisan;

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

Route::post('/login',[AuthController::class,'login'])->name('login');
Route::post('/register',[AuthController::class,'register'])->name('register');
Route::post('/logout',[AuthController::class,'logout']);
Route::post('/verify', [VerifyEmailController::class,'verify'])->middleware('auth:sanctum')->name('verification.verify');
Route::post('/verify/resend',[VerifyEmailController::class,'resend'])->middleware('auth:sanctum')->name('verification.send');


// payment handling
Route::post('/webhooks',[WebhooksController::class,'midtransHandler']);

Route::group(['prefix' => 'v1', 'middleware' => ['auth:sanctum', 'verified']], function () {

    // user handling
    Route::get('/user',[UserController::class,'index']);
    Route::get('/user/{id}',[UserController::class,'show']);
    Route::post('/edit/{id}',[UserController::class,'update']);
    Route::get('/destroy/{id}',[UserController::class,'destroy']);

    // payment handling
    Route::post('/create/order',[OrderController::class,'createOrder']);
    Route::get('/orders',[OrderController::class,'index']);
    Route::get('/orders/{id}',[OrderController::class,'index']);

    // settings
    Route::get('/setings',[SettingsController::class,'index']);
    Route::get('/setings/{id}',[SettingsController::class,'index']);
    Route::post('upload/setings',[SettingsController::class,'store']);
    Route::post('update/setings/{id}',[SettingsController::class,'update']);
    Route::get('destroy/setings/{id}',[SettingsController::class,'destroy']);

    // playlist
    Route::get('/playlists/{id}',[PlaylistController::class,'showDetails']);
    Route::get('/playlist/{id}',[PlaylistController::class,'index']);
    Route::get('/playlist/cat/{id}',[PlaylistController::class,'show']);
    Route::post('/create/playlist',[PlaylistController::class,'create']);
    Route::post('/update/playlist/{id}',[PlaylistController::class,'update']);
    Route::get('/destroy/playlist/{id}',[PlaylistController::class,'destroy']);
    Route::post('/search/playlist',[PlaylistController::class,'search']);

    // category
    Route::get('/category',[CategoryController::class,'index']);
    Route::get('/category/{id}',[CategoryController::class,'index']);
    Route::post('/create/category',[CategoryController::class,'store']);
    Route::post('/update/category/{id}',[CategoryController::class,'update']);
    Route::get('/destroy/category/{id}',[CategoryController::class,'destroy']);

    // roles
    Route::get('/roles',[RoleController::class,'index']);
    Route::get('/roles/{id}',[RoleController::class,'show']);
    Route::post('/create/roles',[RoleController::class,'store']);
    Route::post('/update/roles/{id}',[RoleController::class,'update']);
    Route::get('/destroy/roles/{id}',[RoleController::class,'destroy']);

    // Video Managemnt
    Route::get('/videos',[VideoController::class,'index']);
    Route::get('/videos/{id}',[VideoController::class,'index']);
    Route::post('/create/videos',[VideoController::class,'store']);
    Route::post('/update/videos/{id}',[VideoController::class,'update']);
    Route::get('/destroy/videos/{id}',[VideoController::class,'destroy']);

    // livestream 
    Route::get('livestream',[LivestreamController::class,'show']);
    Route::get('livestream/{id}',[LivestreamController::class,'show']);
    Route::post('create/livestream',[LivestreamController::class,'store']);
    Route::post('update/livestream/{id}',[LivestreamController::class,'update']);
    Route::get('destroy/livestream/{id}',[LivestreamController::class,'destroy']);

    // coment livestream
    Route::get('/coment',[ComentController::class,'show']);
    Route::get('/coment/{id}',[ComentController::class,'show']);
    Route::post('create/coment',[ComentController::class,'store']);
    Route::post('update/coment/{id}',[ComentController::class,'update']);
    Route::get('destroy/coment/{id}',[ComentController::class,'destroy']);


});
