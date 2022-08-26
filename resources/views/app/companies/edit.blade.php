@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('companies.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.companies.edit_title')
            </h4>

            <x-form
                method="PUT"
                action="{{ route('companies.update', $company) }}"
                has-files
                class="mt-4"
            >
                @include('app.companies.form-inputs')

                <div class="mt-4">
                    <a
                        href="{{ route('companies.index') }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>

                    <a
                        href="{{ route('companies.create') }}"
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

    @can('view-any', App\Models\BusinessUnit::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Business Units</h4>

            <livewire:company-business-units-detail :company="$company" />
        </div>
    </div>
    @endcan
</div>
@endsection
