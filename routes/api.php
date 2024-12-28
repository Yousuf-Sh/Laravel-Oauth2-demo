<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

Route::post('/register',[UserController::class,'register']);
Route::middleware('auth:api')->group(function(){
    Route::get('/user/{username}',[UserController::class, 'getUser']);

});