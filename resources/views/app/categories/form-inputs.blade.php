@php $editing = isset($category) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="category_code"
            label="Category Code"
            value="{{ old('category_code', ($editing ? $category->category_code : '')) }}"
            maxlength="255"
            placeholder="Category Code"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="category_name"
            label="Category Name"
            value="{{ old('category_name', ($editing ? $category->category_name : '')) }}"
            maxlength="255"
            placeholder="Category Name"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
