<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\SubCategory;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategorySubCategoriesDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Category $category;
    public SubCategory $subCategory;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New SubCategory';

    protected $rules = [
        'subCategory.category_code' => [
            'required',
            'unique:sub_categories,category_code',
            'max:255',
            'string',
        ],
        'subCategory.category_name' => ['required', 'max:255', 'string'],
    ];

    public function mount(Category $category)
    {
        $this->category = $category;
        $this->resetSubCategoryData();
    }

    public function resetSubCategoryData()
    {
        $this->subCategory = new SubCategory();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newSubCategory()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.category_sub_categories.new_title');
        $this->resetSubCategoryData();

        $this->showModal();
    }

    public function editSubCategory(SubCategory $subCategory)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.category_sub_categories.edit_title');
        $this->subCategory = $subCategory;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        if (!$this->subCategory->category_id) {
            $this->validate();
        } else {
            $this->validate([
                'subCategory.category_code' => [
                    'required',
                    Rule::unique('sub_categories', 'category_code')->ignore(
                        $this->subCategory
                    ),
                    'max:255',
                    'string',
                ],
                'subCategory.category_name' => [
                    'required',
                    'max:255',
                    'string',
                ],
            ]);
        }

        if (!$this->subCategory->category_id) {
            $this->authorize('create', SubCategory::class);

            $this->subCategory->category_id = $this->category->id;
        } else {
            $this->authorize('update', $this->subCategory);
        }

        $this->subCategory->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', SubCategory::class);

        SubCategory::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetSubCategoryData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->category->subCategories as $subCategory) {
            array_push($this->selected, $subCategory->id);
        }
    }

    public function render()
    {
        return view('livewire.category-sub-categories-detail', [
            'subCategories' => $this->category->subCategories()->paginate(20),
        ]);
    }
}
