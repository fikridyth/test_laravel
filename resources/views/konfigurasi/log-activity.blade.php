@extends('main')

@section('content')
    @include('layouts.toolbar')

    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                {!! file_get_contents('metronic/demo2/assets/media/icons/duotune/general/gen021.svg') !!}
                            </span>
                            <input type="search" data-kt-filter="search"
                                class="form-control form-control-solid w-250px ps-14" placeholder="Search" />
                        </div>
                    </div>
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        {{-- @include('layouts.export-datatable') --}}
                    </div>
                </div>
                <div class="card-body py-4">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 kt_datatable_responsive kt_datatable_dynamic_search"
                        id="">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>No.</th>
                                <th>ID - User</th>
                                <th>Role</th>
                                <th>Activity</th>
                                <th>IP Adress</th>
                                <th>URL</th>
                                <th>Method</th>
                                <th>Operating System</th>
                                <th>Device Type</th>
                                <th>Browser</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold">
                            @foreach ($stmtUsersLogActivities as $item)
                                <tr>
                                    <td class="d-flex align-items-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->id_user . ' - ' . $item->user->name }}</td>
                                    <td>{{ $item->user->role->nama }}</td>
                                    <td>{{ $item->activity_content }}</td>
                                    <td>{{ $item->ip_access }}</td>
                                    <td>{{ $item->url }}</td>
                                    <td>{{ $item->method }}</td>
                                    <td>{{ $item->operating_system }}</td>
                                    <td>{{ $item->device_type }}</td>
                                    <td>{{ $item->browser_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
