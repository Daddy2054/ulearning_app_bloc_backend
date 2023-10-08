<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Webhook;
use Stripe\Customer;
use Stripe\Price;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\UnexpectedValueException;
use Stripe\Exception\SignatureVerificationException;
use App\Models\Course;

class PayController extends Controller
{
    //
    public function checkout(Request $request)
    {
        try {
            //code...
            $user = $request->user();

            $token = $user->token;
            $course_id = $request->id;

            //
            // Stripe api key
            //

            $course_result = Course::where('id', '=', $course_id)->first();

            if (empty($course_result)) {
                return response()->json([
                    'code' => 400,
                    'msg' => 'Course does not exist'
                ], 400);
            }
            return response()->json([
                'code' => 200,
                'msg' => 'Course found',
                'data' => ''
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }
}

// php artisan make:controller Api/PayController
//
//composer require stripe/stripe-php