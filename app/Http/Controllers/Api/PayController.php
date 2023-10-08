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
use App\Models\Order;

class PayController extends Controller
{
    //
    public function checkout(Request $request)
    {
        try {
            //code...
            $user = $request->user();

            $token = $user->token;
            $courseId = $request->id;

            //
            // Stripe api key
            //

            $courseResult = Course::where('id', '=', $courseId)->first();

            if (empty($courseResult)) {
                return response()->json([
                    'code' => 400,
                    'msg' => 'Course does not exist'
                ], 400);
            }

            $orderMap = [];
            $orderMap['course_id'] = $courseId;
            $orderMap['user_token'] = $token;
            $orderMap['status'] = 1;

            //
            // if the order has been placed before or not
            // so we need Order model/table
            //
             
            $orderRes = Order::where($orderMap)->first();
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