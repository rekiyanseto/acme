<div>
    <div class="mb-4">
        @can('create', App\Models\Photo::class)
        <button class="btn btn-primary" wire:click="newPhoto">
            <i class="icon ion-md-add"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\Photo::class)
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

    <x-modal id="equipment-photos-modal" wire:model="showingModal">
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
                            name="photo.survey_period_id"
                            label="Survey Period"
                            wire:model="photo.survey_period_id"
                        >
                            <option value="null" disabled>Please select the Survey Period</option>
                            @foreach($surveyPeriodsForSelect as $value => $label)
                            <option value="{{ $value }}"  >{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <div
                            image-url="{{ $editing && $photo->photo ? asset(url($photo->photo)) : '' }}"
                            x-data="imageViewer()"
                            @refresh.window="refreshUrl()"
                        >
                            <x-inputs.partials.label
                                name="photoPhoto"
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
                                    name="photoPhoto"
                                    id="photoPhoto{{ $uploadIteration }}"
                                    wire:model="photoPhoto"
                                    @change="fileChosen"
                                />
                            </div>

                            @error('photoPhoto')
                            @include('components.inputs.partials.error')
                            @enderror
                        </div>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea
                            name="photo.remarks"
                            label="Remarks"
                            wire:model="photo.remarks"
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
                        @lang('crud.equipment_photos.inputs.survey_period_id')
                    </th>
                    <th class="text-left">
                        @lang('crud.equipment_photos.inputs.photo')
                    </th>
                    <th class="text-left">
                        @lang('crud.equipment_photos.inputs.remarks')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($photos as $photo)
                <tr class="hover:bg-gray-100">
                    <td class="text-left">
                        <input
                            type="checkbox"
                            value="{{ $photo->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="text-left">
                        {{ optional($photo->surveyPeriod)->periode_name ?? '-'
                        }}
                    </td>
                    <td class="text-left">
                        <x-partials.thumbnail
                            src="{{ $photo->photo ? \Storage::url($photo->photo) : '' }}"
                        />
                    </td>
                    <td class="text-left">{{ $photo->remarks ?? '-' }}</td>
                    <td class="text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $photo)
                            <button
                                type="button"
                                class="btn btn-light"
                                wire:click="editPhoto({{ $photo->id }})"
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
                    <td colspan="4">{{ $photos->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
