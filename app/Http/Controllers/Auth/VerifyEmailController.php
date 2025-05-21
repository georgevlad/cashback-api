<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return ApiResponse::error([], __('messages.verification_email_unauthenticated'), 401);

        }

        if ($user->hasVerifiedEmail()) {
            return ApiResponse::success([], __('messages.email_already_verified'));
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return ApiResponse::success([], __('messages.verification_email_sent'));
    }
}
