<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.sub_categories.index',
            compact('subCategories', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', SubCategory::class);

        $categories = Category::pluck('category_name', 'id');

        return view('app.sub_categories.create', compact('categories'));
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

        return redirect()
            ->route('sub-categories.edit', $subCategory)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubCategory $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SubCategory $subCategory)
    {
        $this->authorize('view', $subCategory);

        return view('app.sub_categories.show', compact('subCategory'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubCategory $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SubCategory $subCategory)
    {
        $this->authorize('update', $subCategory);

        $categories = Category::pluck('category_name', 'id');

        return view(
            'app.sub_categories.edit',
            compact('subCategory', 'categories')
        );
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

        return redirect()
            ->route('sub-categories.edit', $subCategory)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('sub-categories.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
