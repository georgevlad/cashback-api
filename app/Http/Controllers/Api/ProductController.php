<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Helpers\ApiResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15); // Default 15 per page, customizable via request

        $merchants = Product::paginate($perPage);

        return ApiResponse::success([
            'items' => ProductResource::collection($merchants->items()),
            'pagination' => [
                'total' => $merchants->total(),
                'per_page' => $merchants->perPage(),
                'current_page' => $merchants->currentPage(),
                'last_page' => $merchants->lastPage(),
                'next_page_url' => $merchants->nextPageUrl(),
                'prev_page_url' => $merchants->previousPageUrl(),
            ]
        ], 'Products retrieved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $merchant)
    {
        return ApiResponse::success(new ProductResource($merchant), 'Product retrieved successfully.');
    }

    // Method to get the latest 5 products
    public function latest()
    {
        $latest = Product::take(5)->get();

        return ApiResponse::success(ProductResource::collection($latest), 'Latest products retrieved successfully.');
    }
}
