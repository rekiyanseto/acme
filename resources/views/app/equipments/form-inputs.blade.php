@php $editing = isset($equipment) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-md-4">
        <x-inputs.select name="sub_area_id" label="Sub Area" required>
            @php $selected = old('sub_area_id', ($editing ? $equipment->sub_area_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Sub Area</option>
            @foreach($subAreas as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-4">
        <x-inputs.text
            name="equipment_code"
            label="Equipment Code"
            value="{{ old('equipment_code', ($editing ? $equipment->equipment_code : '')) }}"
            maxlength="255"
            placeholder="Equipment Code"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-4">
        <x-inputs.text
            name="equipment_name"
            label="Equipment Name"
            value="{{ old('equipment_name', ($editing ? $equipment->equipment_name : '')) }}"
            maxlength="255"
            placeholder="Equipment Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-6">
        <x-inputs.select name="maintenance_by" label="Maintenance By">
            @php $selected = old('maintenance_by', ($editing ? $equipment->maintenance_by : '')) @endphp
            <option value="Internal" {{ $selected == 'Internal' ? 'selected' : '' }} >Internal</option>
            <option value="Eksternal" {{ $selected == 'Eksternal' ? 'selected' : '' }} >Eksternal</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-6">
        <x-inputs.textarea
            name="equipment_description"
            label="Equipment Description"
            maxlength="255"
            >{{ old('equipment_description', ($editing ?
            $equipment->equipment_description : '')) }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
