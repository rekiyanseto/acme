<div>
    <div class="mb-4">
        @can('create', App\Models\Settlement::class)
            <button class="btn btn-primary" wire:click="newSettlement">
                <i class="icon ion-md-add"></i>
                @lang('crud.common.new')
            </button>
            @endcan @can('delete-any', App\Models\Settlement::class)
            <button class="btn btn-danger" {{ empty($selected) ? 'disabled' : '' }}
                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                <i class="icon ion-md-trash"></i>
                @lang('crud.common.delete_selected')
            </button>
        @endcan
    </div>

    <x-modal id="survey-settlements-modal" wire:model="showingModal">
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
                        <x-inputs.textarea name="settlement.settlement_note" label="Settlement Note"
                            wire:model="settlement.settlement_note" maxlength="255"></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.partials.label name="settlementSettlementDocument" label="Settlement Document">
                        </x-inputs.partials.label><br />

                        <input type="file" name="settlementSettlementDocument"
                            id="settlementSettlementDocument{{ $uploadIteration }}"
                            wire:model="settlementSettlementDocument" class="form-control-file" />

                        @if ($editing && $settlement->settlement_document)
                            <div class="mt-2">
                                <a href="{{ asset(\Storage::url($settlement->settlement_document)) }}" target="_blank"><i
                                        class="icon ion-md-download"></i>&nbsp;Download</a>
                            </div>
                        @endif @error('settlementSettlementDocument')
                        @include('components.inputs.partials.error')
                    @enderror
                </x-inputs.group>

                <x-inputs.group class="col-sm-12">
                    <x-inputs.select name="settlement.settlement_condition" label="Settlement Condition"
                        wire:model="settlement.settlement_condition">
                        <option value="Oke Running Well" {{ $selected == 'Oke Running Well' ? 'selected' : '' }}>Oke
                            Running Well</option>
                        <option value="Oke Standby" {{ $selected == 'Oke Standby' ? 'selected' : '' }}>Oke Standby
                        </option>
                        <option value="Dengan Catatan" {{ $selected == 'Dengan Catatan' ? 'selected' : '' }}>Dengan
                            Catatan</option>
                        <option value="Tidak Beroperasi" {{ $selected == 'Tidak Beroperasi' ? 'selected' : '' }}>
                            Tidak Beroperasi</option>
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
                    Creation Date
                </th>
                <th class="text-left">
                    @lang('crud.survey_settlements.inputs.settlement_condition')
                </th>
                <th class="text-left">
                    @lang('crud.survey_settlements.inputs.settlement_note')
                </th>
                <th class="text-left">
                    @lang('crud.survey_settlements.inputs.settlement_document')
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody class="text-gray-600">
            @foreach ($settlements as $settlement)
                <tr class="hover:bg-gray-100">
                    <td class="text-left">
                        <input type="checkbox" value="{{ $settlement->id }}" wire:model="selected" />
                    </td>
                    <td class="text-left">
                        {{ $settlement->created_at ?? '-' }}
                    </td>
                    <td class="text-left">
                        @php
                            $color = '';
                            switch ($settlement->settlement_condition) {
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
                        <p class="badge badge-{{ $color }}">{{ $settlement->settlement_condition ?? '-' }}</p>
                    </td>
                    <td class="text-left">
                        {{ $settlement->settlement_note ?? '-' }}
                    </td>
                    <td class="text-left">
                        @if ($settlement->settlement_document)
                            <a href="{{ asset(\Storage::url($settlement->settlement_document)) }}" target="blank"><i
                                    class="icon ion-md-download"></i>&nbsp;Download</a>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right" style="width: 134px;">
                        <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                            @can('update', $settlement)
                                <button type="button" class="btn btn-light"
                                    wire:click="editSettlement({{ $settlement->id }})">
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
                <td colspan="5">{{ $settlements->render() }}</td>
            </tr>
        </tfoot>
    </table>
</div>
</div>
