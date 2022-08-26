<div>
    <div class="mb-4">
        @can('create', App\Models\InitialTest::class)
        <button class="btn btn-primary" wire:click="newInitialTest">
            <i class="icon ion-md-add"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\InitialTest::class)
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

    <x-modal id="survey-initial-tests-modal" wire:model="showingModal">
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
                        <x-inputs.text
                            name="initialTest.initial_test_tool"
                            label="Initial Test Tool"
                            wire:model="initialTest.initial_test_tool"
                            maxlength="255"
                            placeholder="Initial Test Tool"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text
                            name="initialTest.initial_test_result"
                            label="Initial Test Result"
                            wire:model="initialTest.initial_test_result"
                            maxlength="255"
                            placeholder="Initial Test Result"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text
                            name="initialTest.initial_test_standard"
                            label="Initial Test Standard"
                            wire:model="initialTest.initial_test_standard"
                            maxlength="255"
                            placeholder="Initial Test Standard"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea
                            name="initialTest.initial_test_note"
                            label="Initial Test Note"
                            wire:model="initialTest.initial_test_note"
                            maxlength="255"
                        ></x-inputs.textarea>
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
                    <th class="text-left">
                        @lang('crud.survey_initial_tests.inputs.initial_test_tool')
                    </th>
                    <th class="text-left">
                        @lang('crud.survey_initial_tests.inputs.initial_test_result')
                    </th>
                    <th class="text-left">
                        @lang('crud.survey_initial_tests.inputs.initial_test_standard')
                    </th>
                    <th class="text-left">
                        @lang('crud.survey_initial_tests.inputs.initial_test_note')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($initialTests as $initialTest)
                <tr class="hover:bg-gray-100">
                    <td class="text-left">
                        <input
                            type="checkbox"
                            value="{{ $initialTest->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="text-left">
                        {{ $initialTest->initial_test_tool ?? '-' }}
                    </td>
                    <td class="text-left">
                        {{ $initialTest->initial_test_result ?? '-' }}
                    </td>
                    <td class="text-left">
                        {{ $initialTest->initial_test_standard ?? '-' }}
                    </td>
                    <td class="text-left">
                        {{ $initialTest->initial_test_note ?? '-' }}
                    </td>
                    <td class="text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $initialTest)
                            <button
                                type="button"
                                class="btn btn-light"
                                wire:click="editInitialTest({{ $initialTest->id }})"
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
                    <td colspan="5">{{ $initialTests->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
