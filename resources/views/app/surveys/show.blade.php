@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('surveys.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.surveys.show_title')
                </h4>

                <div class="mt-4">
                    <div class="mb-4">
                        <h5>@lang('crud.surveys.inputs.survey_period_id')</h5>
                        <span>{{ optional($survey->surveyPeriod)->periode_name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.surveys.inputs.sub_category_id')</h5>
                        <span>{{ optional($survey->subCategory)->category_name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.surveys.inputs.sub_area_id')</h5>
                        <span>{{ optional($survey->subArea)->sub_area_name ??  '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.surveys.inputs.equipment_id')</h5>
                        <span>{{ optional($survey->equipment)->equipment_name ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('surveys.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Survey::class)
                        <a href="{{ route('surveys.create') }}" class="btn btn-light">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
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
