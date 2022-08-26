@php $editing = isset($businessUnit) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-md-4">
        <x-inputs.select name="company_id" label="Company" required>
            @php $selected = old('company_id', ($editing ? $businessUnit->company_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Company</option>
            @foreach($companies as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-4">
        <x-inputs.text
            name="business_unit_code"
            label="Business Unit Code"
            value="{{ old('business_unit_code', ($editing ? $businessUnit->business_unit_code : '')) }}"
            maxlength="255"
            placeholder="Business Unit Code"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-4">
        <x-inputs.text
            name="business_unit_name"
            label="Business Unit Name"
            value="{{ old('business_unit_name', ($editing ? $businessUnit->business_unit_name : '')) }}"
            maxlength="255"
            placeholder="Business Unit Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div
            x-data="imageViewer('{{ $editing && $businessUnit->business_unit_site_plan ? asset(\Storage::url($businessUnit->business_unit_site_plan)) : '' }}')"
        >
            <x-inputs.partials.label
                name="business_unit_site_plan"
                label="Business Unit Site Plan"
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
                    name="business_unit_site_plan"
                    id="business_unit_site_plan"
                    @change="fileChosen"
                />
            </div>

            @error('business_unit_site_plan')
            @include('components.inputs.partials.error') @enderror
        </div>
    </x-inputs.group>
</div>
