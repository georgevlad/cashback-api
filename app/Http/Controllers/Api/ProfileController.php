<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return ApiResponse::success(
            ['user' => $request->user()],
            __('messages.profile_retrieved')
        );
    }
}
