@php $editing = isset($survey) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-md-4 col-lg-6">
        <x-inputs.select name="survey_period_id" label="Survey Period" required>
            @php $selected = old('survey_period_id', ($editing ? $survey->survey_period_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Survey Period</option>
            @foreach($surveyPeriods as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-4 col-lg-6">
        <x-inputs.select name="sub_category_id" label="Sub Category" required>
            @php $selected = old('sub_category_id', ($editing ? $survey->sub_category_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Sub Category</option>
            @foreach($subCategories as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-6">
        <x-inputs.select name="sub_area_id" label="Sub Area">
            @php $selected = old('sub_area_id', ($editing ? $survey->sub_area_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Sub Area</option>
            @foreach($subAreas as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-md-6">
        <x-inputs.select name="equipment_id" label="Equipment">
            @php $selected = old('equipment_id', ($editing ? $survey->equipment_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Equipment</option>
            @foreach($equipments as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
