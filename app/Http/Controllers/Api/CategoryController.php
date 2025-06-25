<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Helpers\ApiResponse;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ApiResponse::success(CategoryResource::collection(Category::all()), __('messages.categories_retrieved'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return ApiResponse::success(new CategoryResource($category), __('messages.categories_retrieved'));
    }

    // Method to get the latest 5 categories
    public function latest()
    {
        $latestCategories = Category::orderBy('id', 'desc')->take(5)->get();

        return ApiResponse::success(CategoryResource::collection($latestCategories), __('messages.categories_retrieved'));
    }

    // Method to get the details of a single category
    public function details(Category $category)
    {
        // Fetch 4 random categories excluding the one being shown
        $related = Category::where('id', '!=', $category->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return ApiResponse::success([
            'item' => new CategoryResource($category),
            'related' => CategoryResource::collection($related),
        ], 'Category details retrieved successfully.');
    }




}
