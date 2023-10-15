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
        Route::any('/lessonList', 'LessonController@lessonList');
        Route::any('/lessonDetail', 'LessonController@lessonDetail');
    });
    // this is call from Stripe.com, no authentication
    Route::any('/web_go_hooks','PayController@web_go_hooks');

});

// if change /add namespace, run these commands
//php artisan cache:clear
//php artisan config:clear
//php artisan route:clear
