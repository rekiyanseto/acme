@php $editing = isset($area) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-md-4">
        <x-inputs.select
            name="functional_location_id"
            label="Functional Location"
            required
        >
            @php $selected = old('functional_location_id', ($editing ? $area->functional_location_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Functional Location</option>
            @foreach($functionalLocations as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-4">
        <x-inputs.text
            name="area_code"
            label="Area Code"
            value="{{ old('area_code', ($editing ? $area->area_code : '')) }}"
            maxlength="255"
            placeholder="Area Code"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-4">
        <x-inputs.text
            name="area_name"
            label="Area Name"
            value="{{ old('area_name', ($editing ? $area->area_name : '')) }}"
            maxlength="255"
            placeholder="Area Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div
            x-data="imageViewer('{{ $editing && $area->area_site_plan ? asset(\Storage::url($area->area_site_plan)) : '' }}')"
        >
            <x-inputs.partials.label
                name="area_site_plan"
                label="Area Site Plan"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="area_site_plan"
                    id="area_site_plan"
                    @change="fileChosen"
                />
            </div>

            @error('area_site_plan')
            @include('components.inputs.partials.error') @enderror
        </div>
    </x-inputs.group>
</div>
