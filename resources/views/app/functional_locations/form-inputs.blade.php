@php $editing = isset($functionalLocation) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-md-4">
        <x-inputs.select name="business_unit_id" label="Business Unit" required>
            @php $selected = old('business_unit_id', ($editing ? $functionalLocation->business_unit_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Business Unit</option>
            @foreach($businessUnits as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-4">
        <x-inputs.text
            name="functional_location_code"
            label="Functional Location Code"
            value="{{ old('functional_location_code', ($editing ? $functionalLocation->functional_location_code : '')) }}"
            maxlength="255"
            placeholder="Functional Location Code"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-4">
        <x-inputs.text
            name="functional_location_name"
            label="Functional Location Name"
            value="{{ old('functional_location_name', ($editing ? $functionalLocation->functional_location_name : '')) }}"
            maxlength="255"
            placeholder="Functional Location Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div
            x-data="imageViewer('{{ $editing && $functionalLocation->functional_location_site_plan ? asset(\Storage::url($functionalLocation->functional_location_site_plan)) : '' }}')"
        >
            <x-inputs.partials.label
                name="functional_location_site_plan"
                label="Functional Location Site Plan"
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
                    name="functional_location_site_plan"
                    id="functional_location_site_plan"
                    @change="fileChosen"
                />
            </div>

            @error('functional_location_site_plan')
            @include('components.inputs.partials.error') @enderror
        </div>
    </x-inputs.group>
</div>
