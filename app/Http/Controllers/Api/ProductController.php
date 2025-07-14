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

    // Method to get the details of a single product
    public function details(Product $product)
    {
        // Fetch 4 random products excluding the current one
        $related = Product::where('code', '!=', $product->code)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return ApiResponse::success([
            'item' => new ProductResource($product),
            'related' => ProductResource::collection($related),
        ], 'Product details retrieved successfully.');
    }

    // Dummy search endpoint
    public function search(Request $request)
    {
        $query = $request->query('query', 'Product');
        $limit = (int) $request->query('limit', 5);

        $results = [];
        for ($i = 1; $i <= $limit; $i++) {
            $results[] = [
                'title' => $query . " " . $i,
                'url' => 'https://example.com/products/' . $i,
                'merchant' => 'Example Merchant',
                'image' => 'https://example.com/images/product-' . $i . '.jpg',
                'price' => '$' . number_format(99.99 + $i, 2),
            ];
        }

        return ApiResponse::success($results, 'Search results retrieved successfully.');
    }
}
