@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="searchbar mt-0 mb-4">
            <div class="row">
                <div class="col-md-6">
                    <form>
                        <div class="input-group">
                            <input id="indexSearch" type="text" name="search" placeholder="{{ __('crud.common.search') }}"
                                value="{{ $search ?? '' }}" class="form-control" autocomplete="off" />
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon ion-md-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    @can('create', App\Models\Survey::class)
                        <a href="{{ route('surveys.create') }}" class="btn btn-primary">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">@lang('crud.surveys.index_title')</h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead>
                            <tr>
                                <th class="text-left">
                                    @lang('crud.surveys.inputs.survey_period_id')
                                </th>
                                <th class="text-left">
                                    Business Unit
                                </th>
                                <th class="text-left">
                                    Functional Location
                                </th>
                                <th class="text-left">
                                    Area
                                </th>
                                <th class="text-left">
                                    @lang('crud.surveys.inputs.sub_area_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.surveys.inputs.equipment_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.surveys.inputs.sub_category_id')
                                </th>
                                <th class="text-left">
                                    Survey Result
                                </th>
                                <th class="text-left">
                                    Setlement
                                </th>
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($surveys as $survey)
                                <tr>
                                    <td>
                                        {{ optional($survey->surveyPeriod)->periode_name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ optional($survey->equipment)->subArea->area->functionalLocation->businessUnit->business_unit_name ??
                                            (optional($survey->subArea)->area->functionalLocation->businessUnit->business_unit_name ?? '-') }}
                                    </td>
                                    <td>
                                        {{ optional($survey->equipment)->subArea->area->functionalLocation->functional_location_name ??
                                            (optional($survey->subArea)->area->functionalLocation->functional_location_name ?? '-') }}
                                    </td>
                                    <td>
                                        {{ optional($survey->equipment)->subArea->area->area_name ??
                                            (optional($survey->subArea)->area->area_name ?? '-') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('sub-areas.show', optional($survey->equipment)->subArea->id ?? (optional($survey->subArea)->id ?? '0')) }}">
                                            {{ optional($survey->equipment)->subArea->sub_area_name ?? (optional($survey->subArea)->sub_area_name ?? '-') }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('equipments.show', optional($survey->equipment)->id ?? '0') }}">
                                            {{ optional($survey->equipment)->equipment_name ?? '-' }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ optional($survey->subCategory)->category_name ?? '-' }}
                                    </td>
                                    <td class="text-left">
                                        @php
                                            $surveyResults = optional($survey->surveyResults)[sizeOf($survey->surveyResults) - 1]->survey_result_condition ?? '-';
                                            $color = '';
                                            switch ($surveyResults) {
                                                case 'Oke Running Well':
                                                    $color = 'primary';
                                                    break;
                                                case 'Oke Standby':
                                                    $color = 'success';
                                                    break;
                                                case 'Dengan Catatan':
                                                    $color = 'warning';
                                                    break;
                                                case 'Tidak Beroperasi':
                                                    $color = 'danger';
                                                    break;
                                                default:
                                                    $color = 'secondary';
                                                    break;
                                            }
                                        @endphp
                                        <p class="badge badge-{{ $color }}">{{ $surveyResults ?? '-' }}</p>
                                    </td>
                                    <td class="text-left">
                                        @php
                                            $settlementByBusinessUnits = optional($survey->settlementByBusinessUnits)[sizeOf($survey->settlementByBusinessUnits) - 1]->condition ?? '-';
                                            $color = '';
                                            switch ($settlementByBusinessUnits) {
                                                case 'Oke Running Well':
                                                    $color = 'primary';
                                                    break;
                                                case 'Oke Standby':
                                                    $color = 'success';
                                                    break;
                                                case 'Dengan Catatan':
                                                    $color = 'warning';
                                                    break;
                                                case 'Tidak Beroperasi':
                                                    $color = 'danger';
                                                    break;
                                                default:
                                                    $color = 'secondary';
                                                    break;
                                            }
                                        @endphp
                                        <p class="badge badge-{{ $color }}">{{ $settlementByBusinessUnits ?? '-' }}
                                        </p>
                                    </td>
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            @can('update', $survey)
                                                <a href="{{ route('surveys.edit', $survey) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-create"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('view', $survey)
                                                <a href="{{ route('surveys.show', $survey) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-eye"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('delete', $survey)
                                                <form action="{{ route('surveys.destroy', $survey) }}" method="POST"
                                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-light text-danger">
                                                        <i class="icon ion-md-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">{!! $surveys->render() !!}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
