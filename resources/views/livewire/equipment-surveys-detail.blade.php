<div>
    <div class="mb-4">
        @can('create', App\Models\Survey::class)
            <button class="btn btn-primary" wire:click="newSurvey">
                <i class="icon ion-md-add"></i>
                @lang('crud.common.new')
            </button>
            @endcan @can('delete-any', App\Models\Survey::class)
            <button class="btn btn-danger" {{ empty($selected) ? 'disabled' : '' }}
                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                <i class="icon ion-md-trash"></i>
                @lang('crud.common.delete_selected')
            </button>
        @endcan
    </div>

    <x-modal id="equipment-surveys-modal" wire:model="showingModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $modalTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div>
                    <x-inputs.group class="col-sm-12">
                        <x-inputs.select name="survey.survey_period_id" label="Survey Period"
                            wire:model="survey.survey_period_id">
                            <option value="null" disabled>Please select the Survey Period</option>
                            @foreach ($surveyPeriodsForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.select name="survey.sub_category_id" label="Sub Category"
                            wire:model="survey.sub_category_id">
                            <option value="null" disabled>Please select the Sub Category</option>
                            @foreach ($subCategoriesForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>
                </div>
            </div>

            @if ($editing)
            @endif

            <div class="modal-footer">
                <button type="button" class="btn btn-light float-left" wire:click="$toggle('showingModal')">
                    <i class="icon ion-md-close"></i>
                    @lang('crud.common.cancel')
                </button>

                <button type="button" class="btn btn-primary" wire:click="save">
                    <i class="icon ion-md-save"></i>
                    @lang('crud.common.save')
                </button>
            </div>
        </div>
    </x-modal>

    <div class="table-responsive">
        <table class="table table-borderless table-hover">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}" />
                    </th>
                    <th class="text-left">
                        @lang('crud.equipment_surveys.inputs.survey_period_id')
                    </th>
                    <th class="text-left">
                        @lang('crud.equipment_surveys.inputs.sub_category_id')
                    </th>
                    <th class="text-left">
                        Survey Result
                    </th>
                    <th class="text-left">
                        After Settlement
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($surveys as $survey)
                    <tr class="hover:bg-gray-100">
                        <td class="text-left">
                            <input type="checkbox" value="{{ $survey->id }}" wire:model="selected" />
                        </td>
                        <td class="text-left">
                            {{ optional($survey->surveyPeriod)->periode_name ?? '-' }}
                        </td>
                        <td class="text-left">
                            {{ optional($survey->subCategory)->category_name ?? '-' }}
                        </td>
                        <td class="text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $survey)
                                    <button type="button" class="btn btn-light"
                                        wire:click="editSurvey({{ $survey->id }})">
                                        <i class="icon ion-md-create"></i>
                                    </button>
                                    @endcan @can('view', $survey)
                                    <a href="{{ route('surveys.show', $survey) }}">
                                        <button type="button" class="btn btn-light">
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">{{ $surveys->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
