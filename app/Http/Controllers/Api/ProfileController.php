<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return ApiResponse::success(
            ['user' => $request->user()],
            __('messages.profile_retrieved')
        );
    }

    public function stats(Request $request)
    {
        $data = [
            'balance' => 40.0,
            'balance_goal' => 50.0,
            'pending_cashback' => 14.35,
            'products_earned' => 6,
            'stores_earned' => 2,
            'orders_count' => 12,
            'currency' => 'EUR',
        ];

        return ApiResponse::success(
            $data,
            __('messages.stats_retrieved')
        );
    }

    public function orders(Request $request)
    {
        $orders = [
            [
                'id' => 1,
                'store_name' => 'NovaShop',
                'store_url' => 'https://novashop.com',
                'status' => 'pending',
                'ordered_at' => '15.03.2026 09:45 AM',
                'order_total' => 200.0,
                'cashback_amount' => 5.0,
                'currency' => 'EUR',
            ],
            [
                'id' => 2,
                'store_name' => 'TechZone',
                'store_url' => 'https://techzone.com',
                'status' => 'complete',
                'ordered_at' => '07.03.2026 10:00 AM',
                'order_total' => 150.0,
                'cashback_amount' => 3.0,
                'currency' => 'EUR',
            ],
            [
                'id' => 3,
                'store_name' => 'GadgetWorld',
                'store_url' => 'https://gadgetworld.com',
                'status' => 'pending',
                'ordered_at' => '20.03.2026 08:15 PM',
                'order_total' => 475.25,
                'cashback_amount' => 9.5,
                'currency' => 'USD',
            ],
            [
                'id' => 4,
                'store_name' => 'EcoMart',
                'store_url' => 'https://ecomart.com',
                'status' => 'complete',
                'ordered_at' => '01.04.2026 01:30 PM',
                'order_total' => 90.0,
                'cashback_amount' => 2.5,
                'currency' => 'EUR',
            ],
            [
                'id' => 5,
                'store_name' => 'DailyFresh',
                'store_url' => 'https://dailyfresh.com',
                'status' => 'complete',
                'ordered_at' => '12.04.2026 11:20 AM',
                'order_total' => 35.0,
                'cashback_amount' => 1.0,
                'currency' => 'EUR',
            ],
            [
                'id' => 6,
                'store_name' => 'StyleHub',
                'store_url' => 'https://stylehub.com',
                'status' => 'pending',
                'ordered_at' => '21.04.2026 05:00 PM',
                'order_total' => 220.0,
                'cashback_amount' => 6.0,
                'currency' => 'EUR',
            ],
            [
                'id' => 7,
                'store_name' => 'TravelEasy',
                'store_url' => 'https://traveleasy.com',
                'status' => 'complete',
                'ordered_at' => '28.04.2026 09:45 AM',
                'order_total' => 800.0,
                'cashback_amount' => 20.0,
                'currency' => 'USD',
            ],
            [
                'id' => 8,
                'store_name' => 'BookSpace',
                'store_url' => 'https://bookspace.com',
                'status' => 'pending',
                'ordered_at' => '02.05.2026 03:15 PM',
                'order_total' => 60.0,
                'cashback_amount' => 1.2,
                'currency' => 'EUR',
            ],
            [
                'id' => 9,
                'store_name' => 'PetParadise',
                'store_url' => 'https://petparadise.com',
                'status' => 'complete',
                'ordered_at' => '10.05.2026 12:30 PM',
                'order_total' => 110.0,
                'cashback_amount' => 2.75,
                'currency' => 'USD',
            ],
        ];

        return ApiResponse::success(
            $orders,
            __('messages.orders_retrieved')
        );
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(
                __('messages.validation_error'),
                $validator->errors(),
                422
            );
        }

        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return ApiResponse::success(
            ['user' => $user],
            __('messages.profile_updated')
        );
    }
}
