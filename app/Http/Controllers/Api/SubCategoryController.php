<?php

namespace App\Http\Controllers\Api;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubCategoryResource;
use App\Http\Resources\SubCategoryCollection;
use App\Http\Requests\SubCategoryStoreRequest;
use App\Http\Requests\SubCategoryUpdateRequest;

class SubCategoryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SubCategory::class);

        $search = $request->get('search', '');

        $subCategories = SubCategory::search($search)
            ->latest()
            ->paginate();

        return new SubCategoryCollection($subCategories);
    }

    /**
     * @param \App\Http\Requests\SubCategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoryStoreRequest $request)
    {
        $this->authorize('create', SubCategory::class);

        $validated = $request->validated();

        $subCategory = SubCategory::create($validated);

        return new SubCategoryResource($subCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubCategory $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SubCategory $subCategory)
    {
        $this->authorize('view', $subCategory);

        return new SubCategoryResource($subCategory);
    }

    /**
     * @param \App\Http\Requests\SubCategoryUpdateRequest $request
     * @param \App\Models\SubCategory $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(
        SubCategoryUpdateRequest $request,
        SubCategory $subCategory
    ) {
        $this->authorize('update', $subCategory);

        $validated = $request->validated();

        $subCategory->update($validated);

        return new SubCategoryResource($subCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubCategory $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SubCategory $subCategory)
    {
        $this->authorize('delete', $subCategory);

        $subCategory->delete();

        return response()->noContent();
    }
}
