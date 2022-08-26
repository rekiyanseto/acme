<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubCategoryResource;
use App\Http\Resources\SubCategoryCollection;

class CategorySubCategoriesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Category $category)
    {
        $this->authorize('view', $category);

        $search = $request->get('search', '');

        $subCategories = $category
            ->subCategories()
            ->search($search)
            ->latest()
            ->paginate();

        return new SubCategoryCollection($subCategories);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
        $this->authorize('create', SubCategory::class);

        $validated = $request->validate([
            'category_code' => [
                'required',
                'unique:sub_categories,category_code',
                'max:255',
                'string',
            ],
            'category_name' => ['required', 'max:255', 'string'],
        ]);

        $subCategory = $category->subCategories()->create($validated);

        return new SubCategoryResource($subCategory);
    }
}
