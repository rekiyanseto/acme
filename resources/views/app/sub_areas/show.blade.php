@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-4">
                <div class="card h-100">
                    <div id="treeview" class="card-body p-3"></div>
                    <script>
                        $(() => {
                            const treeView = $('#treeview').dxTreeView({
                                items: {!! str_replace('\/', '/', $tree_json) !!},
                                height: 454,
                                searchEnabled: true,
                                itemTemplate(item) {
                                    return `<a href="${item.link}" style="color:black;">${item.text}</a>`;
                                },
                            }).dxTreeView('instance');

                            treeView.selectItem("{{ $current_node }}");
                            treeView.scrollToItem("{{ $current_node }}");
                        });
                    </script>
                </div>
            </div>
            {{-- <div class="col-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="{{ route('sub-areas.index') }}" class="mr-4"><i
                                            class="icon ion-md-arrow-back"></i></a>
                                    @lang('crud.sub_areas.show_title')
                                </h4>

                                <div class="mt-1">
                                    <div class="mb-1">
                                        <h5>@lang('crud.sub_areas.inputs.area_id')</h5>
                                        <span>{{ optional($subArea->area)->area_name ?? '-' }}</span>
                                    </div>
                                    <div class="mb-1">
                                        <h5>@lang('crud.sub_areas.inputs.sub_area_code')</h5>
                                        <span>{{ $subArea->sub_area_code ?? '-' }}</span>
                                    </div>
                                    <div class="mb-1">
                                        <h5>@lang('crud.sub_areas.inputs.sub_area_name')</h5>
                                        <span>{{ $subArea->sub_area_name ?? '-' }}</span>
                                    </div>
                                    <div class="mb-1">
                                        <h5>@lang('crud.sub_areas.inputs.maintenance_by')</h5>
                                        <span>{{ $subArea->maintenance_by ?? '-' }}</span>
                                    </div>
                                    <div class="mb-1">
                                        <h5>@lang('crud.sub_areas.inputs.sub_area_description')</h5>
                                        <span>{{ $subArea->sub_area_description ?? '-' }}</span>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('sub-areas.index') }}" class="btn btn-light">
                                        <i class="icon ion-md-return-left"></i>
                                        @lang('crud.common.back')
                                    </a>

                                    @can('create', App\Models\SubArea::class)
                                        <a href="{{ route('sub-areas.create') }}" class="btn btn-light">
                                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div> --}}

            @if ($subArea->sub_area_site_plan)
                <div class="col-8">
                    <div class="card h-100">
                        <div class="card-body">
                            <div id="myPanzoom" class="panzoom" style="height: 500px;">
                                <img class="panzoom__content" src="{{ asset(\Storage::url($subArea->sub_area_site_plan)) }}"
                                    alt="" />
                            </div>
                            <script>
                                const myPanzoom = new Panzoom(document.querySelector("#myPanzoom"), {
                                    option: {
                                        friction: 0,
                                        maxScale: 10,
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            @endif
        </div>


        @can('view-any', App\Models\Survey::class)
            <div class="card mt-2">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Surveys</h4>

                    <livewire:sub-area-surveys-detail :subArea="$subArea" />
                </div>
            </div>
            @endcan @can('view-any', App\Models\Equipment::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Equipments</h4>

                    <livewire:sub-area-equipments-detail :subArea="$subArea" />
                </div>
            </div>
        @endcan
    </div>
@endsection
