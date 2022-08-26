<div>
    <div class="mb-4">
        @can('create', App\Models\SurveyResult::class)
        <button class="btn btn-primary" wire:click="newSurveyResult">
            <i class="icon ion-md-add"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\SurveyResult::class)
        <button
            class="btn btn-danger"
             {{ empty($selected) ? 'disabled' : '' }} 
            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
            wire:click="destroySelected"
        >
            <i class="icon ion-md-trash"></i>
            @lang('crud.common.delete_selected')
        </button>
        @endcan
    </div>

    <x-modal id="survey-survey-results-modal" wire:model="showingModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $modalTitle }}</h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div>
                    <x-inputs.group class="col-sm-12">
                        <x-inputs.select
                            name="surveyResult.survey_result_condition"
                            label="Survey Result Condition"
                            wire:model="surveyResult.survey_result_condition"
                        >
                            <option value="Oke Running Well" {{ $selected == 'Oke Running Well' ? 'selected' : '' }} >Oke Running Well</option>
                            <option value="Oke Standby" {{ $selected == 'Oke Standby' ? 'selected' : '' }} >Oke Standby</option>
                            <option value="Dengan Catatan" {{ $selected == 'Dengan Catatan' ? 'selected' : '' }} >Dengan Catatan</option>
                            <option value="Tidak Beroperasi" {{ $selected == 'Tidak Beroperasi' ? 'selected' : '' }} >Tidak Beroperasi</option>
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text
                            name="surveyResult.survey_result_note"
                            label="Survey Result Note"
                            wire:model="surveyResult.survey_result_note"
                            maxlength="255"
                            placeholder="Survey Result Note"
                        ></x-inputs.text>
                    </x-inputs.group>
                </div>
            </div>

            @if($editing) @endif

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-light float-left"
                    wire:click="$toggle('showingModal')"
                >
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
                        <input
                            type="checkbox"
                            wire:model="allSelected"
                            wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}"
                        />
                    </th>
                    <th>
                        Creation Date
                    </th>
                    <th class="text-left">
                        @lang('crud.survey_survey_results.inputs.survey_result_condition')
                    </th>
                    <th class="text-left">
                        @lang('crud.survey_survey_results.inputs.survey_result_note')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($surveyResults as $surveyResult)
                <tr class="hover:bg-gray-100">
                    <td class="text-left">
                        <input
                            type="checkbox"
                            value="{{ $surveyResult->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="text-left">
                        {{ $surveyResult->created_at ?? '-' }}
                    </td>
                    <td class="text-left">
                        @php
                            $color = '';
                            switch ($surveyResult->survey_result_condition) {
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
                        <p class="badge badge-{{ $color }}">{{ $surveyResult->survey_result_condition ?? '-' }}</p>
                    </td>
                    <td class="text-left">
                        {{ $surveyResult->survey_result_note ?? '-' }}
                    </td>
                    <td class="text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $surveyResult)
                            <button
                                type="button"
                                class="btn btn-light"
                                wire:click="editSurveyResult({{ $surveyResult->id }})"
                            >
                                <i class="icon ion-md-create"></i>
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">{{ $surveyResults->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
