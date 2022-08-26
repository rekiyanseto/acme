@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('equipments.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.equipments.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.equipments.inputs.sub_area_id')</h5>
                    <span
                        >{{ optional($equipment->subArea)->sub_area_name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.equipments.inputs.equipment_code')</h5>
                    <span>{{ $equipment->equipment_code ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.equipments.inputs.equipment_name')</h5>
                    <span>{{ $equipment->equipment_name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.equipments.inputs.maintenance_by')</h5>
                    <span>{{ $equipment->maintenance_by ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.equipments.inputs.equipment_description')
                    </h5>
                    <span>{{ $equipment->equipment_description ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('equipments.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Equipment::class)
                <a
                    href="{{ route('equipments.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>

    @can('view-any', App\Models\Survey::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Surveys</h4>

            <livewire:equipment-surveys-detail :equipment="$equipment" />
        </div>
    </div>
    @endcan
</div>
@endsection
