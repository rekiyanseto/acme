<div>
    <div class="mb-4">
        @can('create', App\Models\MaintenanceDocument::class)
        <button class="btn btn-primary" wire:click="newMaintenanceDocument">
            <i class="icon ion-md-add"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\MaintenanceDocument::class)
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
        id="sub-area-maintenance-documents-modal"
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
                            name="maintenanceDocument.document_name"
                            label="Document Name"
                            wire:model="maintenanceDocument.document_name"
                            maxlength="255"
                            placeholder="Document Name"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea
                            name="maintenanceDocument.document_remarks"
                            label="Document Remarks"
                            wire:model="maintenanceDocument.document_remarks"
                            maxlength="255"
                        ></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.partials.label
                            name="maintenanceDocumentDocumentFile"
                            label="Document File"
                        ></x-inputs.partials.label
                        ><br />

                        <input
                            type="file"
                            name="maintenanceDocumentDocumentFile"
                            id="maintenanceDocumentDocumentFile{{ $uploadIteration }}"
                            wire:model="maintenanceDocumentDocumentFile"
                            class="form-control-file"
                        />

                        @if($editing && $maintenanceDocument->document_file)
                        <div class="mt-2">
                            <a
                                href="{{ asset(\Storage::url($maintenanceDocument->document_file)) }}"
                                target="_blank"
                                ><i class="icon ion-md-download"></i
                                >&nbsp;Download</a
                            >
                        </div>
                        @endif @error('maintenanceDocumentDocumentFile')
                        @include('components.inputs.partials.error') @enderror
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
                        @lang('crud.sub_area_maintenance_documents.inputs.document_name')
                    </th>
                    <th class="text-left">
                        @lang('crud.sub_area_maintenance_documents.inputs.document_remarks')
                    </th>
                    <th class="text-left">
                        @lang('crud.sub_area_maintenance_documents.inputs.document_file')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($maintenanceDocuments as $maintenanceDocument)
                <tr class="hover:bg-gray-100">
                    <td class="text-left">
                        <input
                            type="checkbox"
                            value="{{ $maintenanceDocument->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="text-left">
                        {{ $maintenanceDocument->document_name ?? '-' }}
                    </td>
                    <td class="text-left">
                        {{ $maintenanceDocument->document_remarks ?? '-' }}
                    </td>
                    <td class="text-left">
                        @if($maintenanceDocument->document_file)
                        <a
                            href="{{ asset(\Storage::url($maintenanceDocument->document_file)) }}"
                            target="blank"
                            ><i class="icon ion-md-download"></i
                            >&nbsp;Download</a
                        >
                        @else - @endif
                    </td>
                    <td class="text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $maintenanceDocument)
                            <button
                                type="button"
                                class="btn btn-light"
                                wire:click="editMaintenanceDocument({{ $maintenanceDocument->id }})"
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
                    <td colspan="4">{{ $maintenanceDocuments->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
