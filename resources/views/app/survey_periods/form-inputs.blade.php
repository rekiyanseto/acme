@php $editing = isset($surveyPeriod) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="periode_name"
            label="Periode Name"
            value="{{ old('periode_name', ($editing ? $surveyPeriod->periode_name : '')) }}"
            maxlength="255"
            placeholder="Periode Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="periode_description"
            label="Periode Description"
            value="{{ old('periode_description', ($editing ? $surveyPeriod->periode_description : '')) }}"
            maxlength="255"
            placeholder="Periode Description"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="periode_status" label="Periode Status">
            @php $selected = old('periode_status', ($editing ? $surveyPeriod->periode_status : '')) @endphp
            <option value="Active" {{ $selected == 'Active' ? 'selected' : '' }} >Active</option>
            <option value="Inactive" {{ $selected == 'Inactive' ? 'selected' : '' }} >Inactive</option>
        </x-inputs.select>
    </x-inputs.group>
</div>
