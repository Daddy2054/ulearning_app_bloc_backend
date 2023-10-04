<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// create command
// php artisan make:controller Api/CourseController
class CourseController extends Controller
{
     //course list
    public function courseList(){
        return response()->json([
            'code' => 200,
            'msg' => 'My course list is here',
            'data' => 'My data is here'
        ], 200);
    }
}
