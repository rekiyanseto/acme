@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('survey-periods.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.survey_periods.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.survey_periods.inputs.periode_name')</h5>
                    <span>{{ $surveyPeriod->periode_name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.survey_periods.inputs.periode_description')
                    </h5>
                    <span>{{ $surveyPeriod->periode_description ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.survey_periods.inputs.periode_status')</h5>
                    <span>{{ $surveyPeriod->periode_status ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('survey-periods.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\SurveyPeriod::class)
                <a
                    href="{{ route('survey-periods.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
