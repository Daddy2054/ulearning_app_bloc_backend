<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayController extends Controller
{
    //
    public function checkout(Request $request)
    {

        $user = $request->user();

        return response()->json([
            'msg' => $user
        ]);
    }
}

// php artisan make:controller Api/PayController
//
//composer require stripe/stripe-php