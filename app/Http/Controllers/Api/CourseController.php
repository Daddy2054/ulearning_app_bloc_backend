<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    //return all course list
    public function courseList()
    {
        // select fields
        try {
            //code...
            $result = Course::select(
                'name',
                'thumbnail',
                'description',
                'lesson_num',
                'price',
                'id',
            )
                ->get();

            return response()->json([
                'code' => 200,
                'msg' => 'My course list is here',
                'data' => $result,
            ], 200);
        } catch (\Throwable $throw) {
            //throw $th;
            return response()->json([
                'code' => 500,
                'msg' => 'The column does not exist or you have a syntax error',
                'data' => $throw->getMessage()
            ], 500);
        }
    }


    //return all the course detail
    public function courseDetail(Request $request)
    {
        //course id
        $id = $request->id;
        // select fields
        try {
            //code...
            $result = Course::where('id', '=', $id)
                ->select(
                    'id',
                    'name',
                    'user_token',
                    'description',
                    'price',
                    'lesson_num',
                    'video_length',
                    'thumbnail',
                )
                ->get();

            return response()->json([
                'code' => 200,
                'msg' => 'My course detail list is here',
                'data' => $result,
            ], 200);
        } catch (\Throwable $throw) {
            //throw $th;
            return response()->json([
                'code' => 500,
                'msg' => 'The column does not exist or you have a syntax error',
                'data' => $throw->getMessage()
            ], 500);
        }
    }
}
    
    // create command
    // php artisan make:controller Api/CourseController
