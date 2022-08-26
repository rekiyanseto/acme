<div>
    <div class="mb-4">
        @can('create', App\Models\Equipment::class)
            <button class="btn btn-primary" wire:click="newEquipment">
                <i class="icon ion-md-add"></i>
                @lang('crud.common.new')
            </button>
            @endcan @can('delete-any', App\Models\Equipment::class)
            <button class="btn btn-danger" {{ empty($selected) ? 'disabled' : '' }}
                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                <i class="icon ion-md-trash"></i>
                @lang('crud.common.delete_selected')
            </button>
        @endcan
    </div>

    <x-modal id="sub-area-equipments-modal" wire:model="showingModal">
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
                        <x-inputs.text name="equipment.equipment_name" label="Equipment Name"
                            wire:model="equipment.equipment_name" maxlength="255" placeholder="Equipment Name">
                        </x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text name="equipment.equipment_code" label="Equipment Code"
                            wire:model="equipment.equipment_code" maxlength="255" placeholder="Equipment Code">
                        </x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea name="equipment.equipment_description" label="Equipment Description"
                            wire:model="equipment.equipment_description" maxlength="255"></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.select name="equipment.maintenance_by" label="Maintenance By"
                            wire:model="equipment.maintenance_by">
                            <option value="Internal" {{ $selected == 'Internal' ? 'selected' : '' }}>Internal</option>
                            <option value="Eksternal" {{ $selected == 'Eksternal' ? 'selected' : '' }}>Eksternal
                            </option>
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
                        @lang('crud.sub_area_equipments.inputs.equipment_name')
                    </th>
                    <th class="text-left">
                        @lang('crud.sub_area_equipments.inputs.equipment_code')
                    </th>
                    <th class="text-left">
                        @lang('crud.sub_area_equipments.inputs.equipment_description')
                    </th>
                    <th class="text-left">
                        @lang('crud.sub_area_equipments.inputs.maintenance_by')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($equipments as $equipment)
                    <tr class="hover:bg-gray-100">
                        <td class="text-left">
                            <input type="checkbox" value="{{ $equipment->id }}" wire:model="selected" />
                        </td>
                        <td class="text-left">
                            {{ $equipment->equipment_name ?? '-' }}
                        </td>
                        <td class="text-left">
                            {{ $equipment->equipment_code ?? '-' }}
                        </td>
                        <td class="text-left">
                            {{ $equipment->equipment_description ?? '-' }}
                        </td>
                        <td class="text-left">
                            {{ $equipment->maintenance_by ?? '-' }}
                        </td>
                        <td class="text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $equipment)
                                    <button type="button" class="btn btn-light"
                                        wire:click="editEquipment({{ $equipment->id }})">
                                        <i class="icon ion-md-create"></i>
                                    </button>
                                    @endcan @can('view', $equipment)
                                    <a href="{{ route('equipments.show', $equipment) }}">
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
                    <td colspan="5">{{ $equipments->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
