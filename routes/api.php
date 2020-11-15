<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WebhooksController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\LivestreamController;

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

Route::post('/login',[UsersController::class,'login'])->name('login');
Route::post('/register',[UsersController::class,'register'])->name('register');
Route::get('/verify/{id}',[UsersController::class,'verify'])->name('verify');

// payment handling
Route::post('/webhooks',[WebhooksController::class,'midtransHandler']);

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    // user handling
    Route::get('/user',[UsersController::class,'show']);
    Route::get('/user/{id}',[UsersController::class,'show']);
    Route::get('/logout',[UsersController::class,'logout']);
    Route::post('/edit/{id}',[UsersController::class,'update']);
    Route::get('/destroy/{id}',[UsersController::class,'destroy']);

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
    Route::get('/playlist',[PlaylistController::class,'index']);
    Route::get('/playlist/{id}',[PlaylistController::class,'index']);
    Route::get('/playlist/cat/{id}',[PlaylistController::class,'show']);
    Route::post('/create/playlist',[PlaylistController::class,'create']);
    Route::post('/update/playlist/{id}',[PlaylistController::class,'update']);
    Route::get('/destroy/playlist/{id}',[PlaylistController::class,'destroy']);

    // category
    Route::get('/category',[CategoryController::class,'index']);
    Route::get('/category/{id}',[CategoryController::class,'index']);
    Route::post('/create/category',[CategoryController::class,'store']);
    Route::post('/update/category/{id}',[CategoryController::class,'update']);
    Route::get('/destroy/category/{id}',[CategoryController::class,'destroy']);

    // roles
    Route::get('/roles',[RoleController::class,'index']);
    Route::get('/roles/{id}',[RoleController::class,'index']);
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

});
