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
