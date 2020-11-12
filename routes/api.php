<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WebhooksController;

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

});
