@php $editing = isset($subCategory) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="category_id" label="Category" required>
            @php $selected = old('category_id', ($editing ? $subCategory->category_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Category</option>
            @foreach($categories as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="category_code"
            label="Category Code"
            value="{{ old('category_code', ($editing ? $subCategory->category_code : '')) }}"
            maxlength="255"
            placeholder="Category Code"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="category_name"
            label="Category Name"
            value="{{ old('category_name', ($editing ? $subCategory->category_name : '')) }}"
            maxlength="255"
            placeholder="Category Name"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
