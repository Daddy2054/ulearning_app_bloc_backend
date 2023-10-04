<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
class CourseController extends Controller
{
    
    //course list
    public function courseList()
    {
        $result = Course::select(
            'name', 
            'thumbnail', 
            'lesson_num', 
            'price', 
            'id',
            )->get();
            
            return response()->json([
                'code' => 200,
                'msg' => 'My course list is here',
                'data' => $result,
            ], 200);
        }
    }
    
    // create command
    // php artisan make:controller Api/CourseController
