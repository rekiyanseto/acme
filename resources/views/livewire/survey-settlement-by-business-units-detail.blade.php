<div>
    <div class="mb-4">
        @can('create', App\Models\SettlementByBusinessUnit::class)
        <button
            class="btn btn-primary"
            wire:click="newSettlementByBusinessUnit"
        >
            <i class="icon ion-md-add"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\SettlementByBusinessUnit::class)
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

    <x-modal
        id="survey-settlement-by-business-units-modal"
        wire:model="showingModal"
    >
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
                            name="settlementByBusinessUnit.spk_no"
                            label="SPK No"
                            wire:model="settlementByBusinessUnit.spk_no"
                            maxlength="255"
                            placeholder="SPK No"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.number
                            name="settlementByBusinessUnit.progress"
                            label="Progress"
                            wire:model="settlementByBusinessUnit.progress"
                            max="100"
                            step="1"
                            placeholder="Progress"
                        ></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <div
                            image-url="{{ $editing && $settlementByBusinessUnit->photo ? asset(\Storage::url($settlementByBusinessUnit->photo)) : '' }}"
                            x-data="imageViewer()"
                            @refresh.window="refreshUrl()"
                        >
                            <x-inputs.partials.label
                                name="settlementByBusinessUnitPhoto"
                                label="Photo"
                            ></x-inputs.partials.label
                            ><br />

                            <!-- Show the image -->
                            <template x-if="imageUrl">
                                <img
                                    :src="imageUrl"
                                    class="
                                        object-cover
                                        rounded
                                        border border-gray-200
                                    "
                                    style="width: 100px; height: 100px;"
                                />
                            </template>

                            <!-- Show the gray box when image is not available -->
                            <template x-if="!imageUrl">
                                <div
                                    class="
                                        border
                                        rounded
                                        border-gray-200
                                        bg-gray-100
                                    "
                                    style="width: 100px; height: 100px;"
                                ></div>
                            </template>

                            <div class="mt-2">
                                <input
                                    type="file"
                                    name="settlementByBusinessUnitPhoto"
                                    id="settlementByBusinessUnitPhoto{{ $uploadIteration }}"
                                    wire:model="settlementByBusinessUnitPhoto"
                                    @change="fileChosen"
                                />
                            </div>

                            @error('settlementByBusinessUnitPhoto')
                            @include('components.inputs.partials.error')
                            @enderror
                        </div>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.select
                            name="settlementByBusinessUnit.condition"
                            label="Condition"
                            wire:model="settlementByBusinessUnit.condition"
                        >
                            <option value="Oke Running Well" {{ $selected == 'Oke Running Well' ? 'selected' : '' }} >Oke Running Well</option>
                            <option value="Oke Standby" {{ $selected == 'Oke Standby' ? 'selected' : '' }} >Oke Standby</option>
                            <option value="Dengan Catatan" {{ $selected == 'Dengan Catatan' ? 'selected' : '' }} >Dengan Catatan</option>
                            <option value="Tidak Beroperasi" {{ $selected == 'Tidak Beroperasi' ? 'selected' : '' }} >Tidak Beroperasi</option>
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea
                            name="settlementByBusinessUnit.note"
                            label="Note"
                            wire:model="settlementByBusinessUnit.note"
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
                    <th>
                        Creation Date
                    </th>
                    <th class="text-left">
                        @lang('crud.survey_settlement_by_business_units.inputs.condition')
                    </th>
                    <th class="text-left">
                        @lang('crud.survey_settlement_by_business_units.inputs.spk_no')
                    </th>
                    <th class="text-right">
                        @lang('crud.survey_settlement_by_business_units.inputs.progress')
                    </th>
                    <th class="text-left">
                        @lang('crud.survey_settlement_by_business_units.inputs.photo')
                    </th>
                    <th class="text-left">
                        @lang('crud.survey_settlement_by_business_units.inputs.note')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($settlementByBusinessUnits as $settlementByBusinessUnit)
                <tr class="hover:bg-gray-100">
                    <td class="text-left">
                        <input
                            type="checkbox"
                            value="{{ $settlementByBusinessUnit->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="text-left">
                        {{ $settlementByBusinessUnit->created_at ?? '-' }}
                    </td>
                    <td class="text-left">
                        @php
                            $color = '';
                            switch ($settlementByBusinessUnit->condition) {
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
                        <p class="badge badge-{{ $color }}">{{ $settlementByBusinessUnit->condition ?? '-' }}</p>
                    </td>
                    <td class="text-left">
                        {{ $settlementByBusinessUnit->spk_no ?? '-' }}
                    </td>
                    <td class="text-right">
                        {{ $settlementByBusinessUnit->progress ?? '-' }}
                    </td>
                    <td class="text-left">
                        <x-partials.thumbnail
                            src="{{ $settlementByBusinessUnit->photo ? asset(\Storage::url($settlementByBusinessUnit->photo)) : '' }}"
                        />
                    </td>
                    <td class="text-left">
                        {{ $settlementByBusinessUnit->note ?? '-' }}
                    </td>
                    <td class="text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $settlementByBusinessUnit)
                            <button
                                type="button"
                                class="btn btn-light"
                                wire:click="editSettlementByBusinessUnit({{ $settlementByBusinessUnit->id }})"
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
                    <td colspan="6">
                        {{ $settlementByBusinessUnits->render() }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
