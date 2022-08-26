<div>
    <div class="mb-4">
        @can('create', App\Models\Document::class)
        <button class="btn btn-primary" wire:click="newDocument">
            <i class="icon ion-md-add"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\Document::class)
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

    <x-modal id="equipment-documents-modal" wire:model="showingModal">
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
                            name="document.document_name"
                            label="Document Name"
                            wire:model="document.document_name"
                            maxlength="255"
                            placeholder="Document Name"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea
                            name="document.document_description"
                            label="Document Description"
                            wire:model="document.document_description"
                            maxlength="255"
                        ></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.partials.label
                            name="documentDocumentLink"
                            label="Document Link"
                        ></x-inputs.partials.label
                        ><br />

                        <input
                            type="file"
                            name="documentDocumentLink"
                            id="documentDocumentLink{{ $uploadIteration }}"
                            wire:model="documentDocumentLink"
                            class="form-control-file"
                        />

                        @if($editing && $document->document_link)
                        <div class="mt-2">
                            <a
                                href="{{ asset(\Storage::url($document->document_link)) }}"
                                target="_blank"
                                ><i class="icon ion-md-download"></i
                                >&nbsp;Download</a
                            >
                        </div>
                        @endif @error('documentDocumentLink')
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
                        @lang('crud.equipment_documents.inputs.document_name')
                    </th>
                    <th class="text-left">
                        @lang('crud.equipment_documents.inputs.document_description')
                    </th>
                    <th class="text-left">
                        @lang('crud.equipment_documents.inputs.document_link')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($documents as $document)
                <tr class="hover:bg-gray-100">
                    <td class="text-left">
                        <input
                            type="checkbox"
                            value="{{ $document->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="text-left">
                        {{ $document->document_name ?? '-' }}
                    </td>
                    <td class="text-left">
                        {{ $document->document_description ?? '-' }}
                    </td>
                    <td class="text-left">
                        @if($document->document_link)
                        <a
                            href="{{ asset(\Storage::url($document->document_link)) }}"
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
                            @can('update', $document)
                            <button
                                type="button"
                                class="btn btn-light"
                                wire:click="editDocument({{ $document->id }})"
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
                    <td colspan="4">{{ $documents->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
