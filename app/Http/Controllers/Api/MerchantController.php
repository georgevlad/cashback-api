<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\MerchantResource;
use App\Models\Merchant;
use App\Helpers\ApiResponse;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15); // Default 15 per page, customizable via request

        $merchants = Merchant::paginate($perPage);

        return ApiResponse::success([
            'items' => MerchantResource::collection($merchants->items()),
            'pagination' => [
                'total' => $merchants->total(),
                'per_page' => $merchants->perPage(),
                'current_page' => $merchants->currentPage(),
                'last_page' => $merchants->lastPage(),
                'next_page_url' => $merchants->nextPageUrl(),
                'prev_page_url' => $merchants->previousPageUrl(),
            ]
        ], 'Merchants retrieved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Merchant $merchant)
    {
        return ApiResponse::success(new MerchantResource($merchant), 'Merchant retrieved successfully.');
    }

    // Method to get the latest 5 categories
    public function latest()
    {
        $latest = Merchant::orderBy('created_at', 'desc')->take(5)->get();

        return ApiResponse::success(MerchantResource::collection($latest), 'Latest merchants retrieved successfully.');
    }

}
