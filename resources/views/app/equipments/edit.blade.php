@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('equipments.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.equipments.edit_title')
            </h4>

            <x-form
                method="PUT"
                action="{{ route('equipments.update', $equipment) }}"
                class="mt-4"
            >
                @include('app.equipments.form-inputs')

                <div class="mt-4">
                    <a
                        href="{{ route('equipments.index') }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>

                    <a
                        href="{{ route('equipments.create') }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-add text-primary"></i>
                        @lang('crud.common.create')
                    </a>

                    <button type="submit" class="btn btn-primary float-right">
                        <i class="icon ion-md-save"></i>
                        @lang('crud.common.update')
                    </button>
                </div>
            </x-form>
        </div>
    </div>

    @can('view-any', App\Models\Survey::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Surveys</h4>

            <livewire:equipment-surveys-detail :equipment="$equipment" />
        </div>
    </div>
    @endcan @can('view-any', App\Models\MaintenanceDocument::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Maintenance Documents</h4>

            <livewire:equipment-maintenance-documents-detail
                :equipment="$equipment"
            />
        </div>
    </div>
    @endcan
</div>
@endsection
