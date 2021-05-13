<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return response()->json([
        "RestApi" => env('APP_NAME'),
        "date" => date('Y-m-d')
    ],200);
});

Route::get('/transaction-success', function () {
    return view('transactionSuccess');
});