<div>
    <div class="mb-4">
        @can('create', App\Models\SubArea::class)
        <button class="btn btn-primary" wire:click="newSubArea">
            <i class="icon ion-md-add"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\SubArea::class)
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

    <x-modal id="area-sub-areas-modal" wire:model="showingModal">
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
                            name="subArea.sub_area_code"
                            label="Sub Area Code"
                            wire:model="subArea.sub_area_code"
                            maxlength="255"
                            placeholder="Sub Area Code"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text
                            name="subArea.sub_area_name"
                            label="Sub Area Name"
                            wire:model="subArea.sub_area_name"
                            maxlength="255"
                            placeholder="Sub Area Name"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.select
                            name="subArea.maintenance_by"
                            label="Maintenance By"
                            wire:model="subArea.maintenance_by"
                        >
                            <option value="Internal" {{ $selected == 'Internal' ? 'selected' : '' }} >Internal</option>
                            <option value="Eksternal" {{ $selected == 'Eksternal' ? 'selected' : '' }} >Eksternal</option>
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea
                            name="subArea.sub_area_description"
                            label="Sub Area Description"
                            wire:model="subArea.sub_area_description"
                            maxlength="255"
                        ></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <div
                            image-url="{{ $editing && $subArea->sub_area_site_plan ? \Storage::url($subArea->sub_area_site_plan) : '' }}"
                            x-data="imageViewer()"
                            @refresh.window="refreshUrl()"
                        >
                            <x-inputs.partials.label
                                name="subAreaSubAreaSitePlan"
                                label="Sub Area Site Plan"
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
                                    name="subAreaSubAreaSitePlan"
                                    id="subAreaSubAreaSitePlan{{ $uploadIteration }}"
                                    wire:model="subAreaSubAreaSitePlan"
                                    @change="fileChosen"
                                />
                            </div>

                            @error('subAreaSubAreaSitePlan')
                            @include('components.inputs.partials.error')
                            @enderror
                        </div>
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
                        @lang('crud.area_sub_areas.inputs.sub_area_code')
                    </th>
                    <th class="text-left">
                        @lang('crud.area_sub_areas.inputs.sub_area_name')
                    </th>
                    <th class="text-left">
                        @lang('crud.area_sub_areas.inputs.maintenance_by')
                    </th>
                    <th class="text-left">
                        @lang('crud.area_sub_areas.inputs.sub_area_description')
                    </th>
                    <th class="text-left">
                        @lang('crud.area_sub_areas.inputs.sub_area_site_plan')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($subAreas as $subArea)
                <tr class="hover:bg-gray-100">
                    <td class="text-left">
                        <input
                            type="checkbox"
                            value="{{ $subArea->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="text-left">
                        {{ $subArea->sub_area_code ?? '-' }}
                    </td>
                    <td class="text-left">
                        {{ $subArea->sub_area_name ?? '-' }}
                    </td>
                    <td class="text-left">
                        {{ $subArea->maintenance_by ?? '-' }}
                    </td>
                    <td class="text-left">
                        {{ $subArea->sub_area_description ?? '-' }}
                    </td>
                    <td class="text-left">
                        <x-partials.thumbnail
                            src="{{ $subArea->sub_area_site_plan ? \Storage::url($subArea->sub_area_site_plan) : '' }}"
                        />
                    </td>
                    <td class="text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $subArea)
                            <button
                                type="button"
                                class="btn btn-light"
                                wire:click="editSubArea({{ $subArea->id }})"
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
                    <td colspan="6">{{ $subAreas->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
