@php $editing = isset($company) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-md-6">
        <x-inputs.text
            name="company_code"
            label="Company Code"
            value="{{ old('company_code', ($editing ? $company->company_code : '')) }}"
            maxlength="255"
            placeholder="Company Code"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-6">
        <x-inputs.text
            name="company_name"
            label="Company Name"
            value="{{ old('company_name', ($editing ? $company->company_name : '')) }}"
            maxlength="255"
            placeholder="Company Name"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div
            x-data="imageViewer('{{ $editing && $company->company_site_plan ? asset(\Storage::url($company->company_site_plan)) : '' }}')"
        >
            <x-inputs.partials.label
                name="company_site_plan"
                label="Company Site Plan"
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
                    name="company_site_plan"
                    id="company_site_plan"
                    @change="fileChosen"
                />
            </div>

            @error('company_site_plan')
            @include('components.inputs.partials.error') @enderror
        </div>
    </x-inputs.group>
</div>
