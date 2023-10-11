<?php

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

Route::group(['namespace' => 'Api'], function () {

   // Route::post('/login', [UserController::class, 'createUser']);
    Route::post('/login', 'UserController@createUser');
    
    // authentication middleware
    Route::group(['middleware'=>'auth:sanctum'], function(){

        Route::any('/courseList', 'CourseController@courseList');
        Route::any('/courseDetail', 'CourseController@courseDetail');
        Route::any('/checkout', 'PayController@checkout');
    });
    //https://42d6-158-148-62-206.ngrok-free.app/
    Route::any('/web_go_hooks','PayController@web_go_hooks');

});

// if change /add namespace, run these commands
//php artisan cache:clear
//php artisan config:clear
//php artisan route:clear
