@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('sub-areas.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.sub_areas.edit_title')
            </h4>

            <x-form
                method="PUT"
                action="{{ route('sub-areas.update', $subArea) }}"
                has-files
                class="mt-4"
            >
                @include('app.sub_areas.form-inputs')

                <div class="mt-4">
                    <a
                        href="{{ route('sub-areas.index') }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>

                    <a
                        href="{{ route('sub-areas.create') }}"
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

            <livewire:sub-area-surveys-detail :subArea="$subArea" />
        </div>
    </div>
    @endcan @can('view-any', App\Models\Equipment::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Equipments</h4>

            <livewire:sub-area-equipments-detail :subArea="$subArea" />
        </div>
    </div>
    @endcan @can('view-any', App\Models\MaintenanceDocument::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Maintenance Documents</h4>

            <livewire:sub-area-maintenance-documents-detail
                :subArea="$subArea"
            />
        </div>
    </div>
    @endcan
</div>
@endsection
