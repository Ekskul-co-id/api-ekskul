<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WebhooksController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\CategoryController;

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
    Route::get('/urlsnap',[OrderController::class,'createOrder']);

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

    // category
    Route::post('/create/category',[CategoryController::class,'store']);

});
