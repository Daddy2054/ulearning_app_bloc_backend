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
use Carbon\Carbon;

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
            Stripe::setApiKey('sk_test_51NzMXaHDqtNmz2BIvGZSB8UwUjGwAC9bzTK8Yu6PaTxQwsgoO4Yd9k2FSbW8jNnWHIpDctev4yjMyD157WK7zQU300uy7PK2zx');

            $courseResult = Course::where('id', '=', $courseId)->first();
            // invalid request
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
            if (!empty($orderRes)) {
                return response()->json([
                    'code' => 400,
                    'msg' => 'You already bought this course',
                    'data' => $orderRes,
                ], 400);
            }

            // new order for the user and let's submit
            $YOUR_DOMAIN = env('APP_URL');
            $map = [];
            $map['user_token'] = $token;
            $map['course_id'] = $courseId;
            $map['total_amount'] = $courseResult->price;
            $map['status'] = 0;
            $map['created_at'] = Carbon::now();
            $orderNum = Order::insertGetId($map);
            //create payment session

            $checkoutSession = Session::create(
                [
                    'line_items' => [[
                        'price_data' => [
                            'currency' => 'USD',
                            'product_data' => [
                                'name' => $courseResult->name,
                                'description' => $courseResult->description,
                            ],
                            'unit_amount' => intval(($courseResult->price) * 100),
                        ],
                        'quantity' => 1,
                    ]],
                    'payment_intent_data' => [
                        'metadata' => ['order_num' => $orderNum, 'user_token' => $token],
                    ],
                    'metadata' => ['order_num' => $orderNum, 'user_token' => $token],
                    'mode' => 'payment',
                    'success_url' => $YOUR_DOMAIN . 'success',
                    'cancel_url' => $YOUR_DOMAIN . 'cancel'
                ]
            );

//returning stripe payment url
            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'data' => $checkoutSession->url,
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