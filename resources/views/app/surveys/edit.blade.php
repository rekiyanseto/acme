@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('surveys.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.surveys.edit_title')
                </h4>

                <x-form method="PUT" action="{{ route('surveys.update', $survey) }}" class="mt-4">
                    @include('app.surveys.form-inputs')

                    <div class="mt-4">
                        <a href="{{ route('surveys.index') }}" class="btn btn-light">
                            <i class="icon ion-md-return-left text-primary"></i>
                            @lang('crud.common.back')
                        </a>

                        <a href="{{ route('surveys.create') }}" class="btn btn-light">
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

        @can('view-any', App\Models\InitialTest::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Initial Tests</h4>

                    <livewire:survey-initial-tests-detail :survey="$survey" />
                </div>
            </div>
            @endcan @can('view-any', App\Models\SurveyResult::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Survey Results</h4>

                    <livewire:survey-survey-results-detail :survey="$survey" />
                </div>
            </div>
            @endcan @can('view-any', App\Models\Photo::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Photos</h4>
    
                    <livewire:survey-photos-detail :survey="$survey" />
                </div>
            </div>
            @endcan @can('view-any', App\Models\Settlement::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Settlements</h4>

                    <livewire:survey-settlements-detail :survey="$survey" />
                </div>
            </div>
            @endcan @can('view-any', App\Models\SettlementByBusinessUnit::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Settlement By Business Units</h4>

                    <livewire:survey-settlement-by-business-units-detail :survey="$survey" />
                </div>
            </div>
        @endcan  
    </div>
@endsection
