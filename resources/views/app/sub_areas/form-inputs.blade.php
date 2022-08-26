@php $editing = isset($subArea) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-md-4">
        <x-inputs.select name="area_id" label="Area" required>
            @php $selected = old('area_id', ($editing ? $subArea->area_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Area</option>
            @foreach($areas as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-4">
        <x-inputs.text
            name="sub_area_code"
            label="Sub Area Code"
            value="{{ old('sub_area_code', ($editing ? $subArea->sub_area_code : '')) }}"
            maxlength="255"
            placeholder="Sub Area Code"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-4">
        <x-inputs.text
            name="sub_area_name"
            label="Sub Area Name"
            value="{{ old('sub_area_name', ($editing ? $subArea->sub_area_name : '')) }}"
            maxlength="255"
            placeholder="Sub Area Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-6">
        <x-inputs.select name="maintenance_by" label="Maintenance By">
            @php $selected = old('maintenance_by', ($editing ? $subArea->maintenance_by : '')) @endphp
            <option value="Internal" {{ $selected == 'Internal' ? 'selected' : '' }} >Internal</option>
            <option value="Eksternal" {{ $selected == 'Eksternal' ? 'selected' : '' }} >Eksternal</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-6">
        <x-inputs.textarea
            name="sub_area_description"
            label="Sub Area Description"
            maxlength="255"
            >{{ old('sub_area_description', ($editing ?
            $subArea->sub_area_description : '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div
            x-data="imageViewer('{{ $editing && $subArea->sub_area_site_plan ? asset(\Storage::url($subArea->sub_area_site_plan)) : '' }}')"
        >
            <x-inputs.partials.label
                name="sub_area_site_plan"
                label="Sub Area Site Plan"
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
                    name="sub_area_site_plan"
                    id="sub_area_site_plan"
                    @change="fileChosen"
                />
            </div>

            @error('sub_area_site_plan')
            @include('components.inputs.partials.error') @enderror
        </div>
    </x-inputs.group>
</div>
