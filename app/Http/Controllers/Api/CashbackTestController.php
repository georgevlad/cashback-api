<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CashbackTestController extends Controller
{
    /**
     * Handle purchase test endpoint
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function purchase(Request $request): JsonResponse
    {
        return ApiResponse::success([], __('messages.action_successful'));
    }

    /**
     * Handle settle transaction test endpoint
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function settleTransaction(Request $request): JsonResponse
    {
        return ApiResponse::success([], __('messages.action_successful'));
    }
}
