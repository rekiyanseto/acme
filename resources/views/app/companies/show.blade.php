@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
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
            <div class="col-8 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="{{ route('companies.index') }}" class="mr-4"><i
                                    class="icon ion-md-arrow-back"></i></a>
                            @lang('crud.companies.show_title')
                        </h4>

                        <div class="mt-4">
                            <div class="mb-4">
                                <h5>@lang('crud.companies.inputs.company_code')</h5>
                                <span>{{ $company->company_code ?? '-' }}</span>
                            </div>
                            <div class="mb-4">
                                <h5>@lang('crud.companies.inputs.company_name')</h5>
                                <span>{{ $company->company_name ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('companies.index') }}" class="btn btn-light">
                                <i class="icon ion-md-return-left"></i>
                                @lang('crud.common.back')
                            </a>

                            @can('create', App\Models\Company::class)
                                <a href="{{ route('companies.create') }}" class="btn btn-light">
                                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($company->company_site_plan)
            <div class="row">
                <div class="col-1">
                </div>
                <div class="col-10">
                    <div class="card">
                        <div class="card-body">
                            <div id="myPanzoom" class="panzoom" style="height: 500px;">
                                <img class="panzoom__content" src="{{ asset(\Storage::url($company->company_site_plan)) }}"
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
                <div class="col-1">
                </div>
            </div>
        @endif
    </div>
@endsection
