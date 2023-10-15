<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Models\Course;
use App\Models\Lesson;

class LessonController extends Controller
{
    //
    //this is for our lesson list for a particular course
    public function lessonList(Request $request)
    {
        $id = $request->id;
        try {

            $result = Lesson::where('course_id', '=', $id)
                ->select(
                    'id',
                    'name',
                    'description',
                    'thumbnail',
                    'video',
                )->get();
            return response()->json(
                [
                    'code' => 200,
                    'msg' => 'My lesson list is here',
                    'data' => $result,
                ],
                200
            );
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'code' => 500,
                    'msg' => 'Server internal error',
                    'data' => $e->getMessage()

                ],
                500
            );
            //throw $th;
        }
    }


    //this is for our lesson detail for a particular course
    // check: http://localhost:8000/api/lessonDetail?id=1
    public function lessonDetail(Request $request)
    {
        try {
            $lessonId = $request->id;
            $result
            = Lesson::where("id", "=", $lessonId)->first();;

            return response()->json([
                'code' => 200,
                'data' => $result->video,
                'msg' => "success"
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'code' => 200,
                'data' => "",
                'msg' => $e->getMessage()
            ], 500);
        }
    }
}
