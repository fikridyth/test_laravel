@extends('main')
@section('page.title', 'Manajemen Menu')
@section('content')
    @include('layouts.toolbar')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header border-0 pt-6">
                            <div class="card-title"></div>
                            @can('menu_create')
                                <div class="card-toolbar">
                                    <a href="{{ route('menus.create') }}" type="button" class="btn btn-primary">
                                        <span class="svg-icon svg-icon-2">
                                            {!! file_get_contents('metronic/demo2/assets/media/icons/duotune/arrows/arr075.svg') !!}
                                        </span>
                                        Tambah Menu
                                    </a>
                                </div>
                            @endcan
                        </div>
                        <div class="card-body py-4">
                            {!! $html !!}
                        </div>
                        <div class="card-footer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('content_scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('.btn-del').on('click', function() {
                return confirm('Are you sure want to delete?');
            });
        });
    </script>
@endpush
