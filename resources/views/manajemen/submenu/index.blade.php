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
                            <input type="text" data-kt-filter="search"
                                class="form-control form-control-solid w-250px ps-14" placeholder="Search submenu" />
                        </div>
                    </div>
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <div class="d-flex justify-content-end" data-kt-menu-table-toolbar="base">
                            <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                                <span class="svg-icon svg-icon-2">
                                    {!! file_get_contents('metronic/demo2/assets/media/icons/duotune/general/gen031.svg') !!}
                                </span>
                            </button>
                            <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                                <div class="px-7 py-5">
                                    <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                </div>
                                <div class="separator border-gray-200"></div>
                                <div class="px-7 py-5" data-kt-menu-table-filter="form">
                                    <form action="{{ route('manajemen-submenu.index') }}">
                                        <div class="mb-10">
                                            <label class="form-label fs-6 fw-semibold" for="status">Status:</label>
                                            <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                                data-placeholder="Pilih status" data-allow-clear="true"
                                                data-kt-menu-table-filter="two-step" data-hide-search="true" id="status"
                                                name="status">
                                                <option></option>
                                                @if (request('status') == 1)
                                                    <option value="1" selected>Aktif</option>
                                                    <option value="2">Tidak Aktif</option>
                                                @elseif(request('status') == 2)
                                                    <option value="1">Aktif</option>
                                                    <option value="2" selected>Tidak Aktif</option>
                                                @else
                                                    <option value="1">Aktif</option>
                                                    <option value="2">Tidak Aktif</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="mb-10">
                                            <label class="form-label fs-6 fw-semibold" for="menu">Menu:</label>
                                            <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                                data-placeholder="Pilih status" data-allow-clear="true"
                                                data-kt-menu-table-filter="two-step" data-hide-search="true" id="menu"
                                                name="menu">
                                                <option></option>
                                                @foreach ($stmtMenu as $menu)
                                                    @if (request('menu'))
                                                        <option value="{{ $menu->id }}" selected>{{ $menu->nama }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $menu->id }}">{{ $menu->nama }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="reset"
                                                class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                                data-kt-menu-dismiss="true" data-kt-menu-table-filter="reset">Reset</button>
                                            <button type="submit" class="btn btn-primary fw-semibold px-6"
                                                data-kt-menu-dismiss="true"
                                                data-kt-menu-table-filter="filter">Apply</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <a href="{{ route('manajemen-submenu.create') }}" type="button" class="btn btn-primary">
                                <span class="svg-icon svg-icon-2">
                                    {!! file_get_contents('metronic/demo2/assets/media/icons/duotune/arrows/arr075.svg') !!}
                                </span>
                                Add SubMenu
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body py-4">
                    <table
                        class="table align-middle table-row-dashed fs-6 gy-5 kt_datatable_responsive_with_actions kt_datatable_dynamic_search"
                        id="">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">No.</th>
                                <th class="min-w-125px">Nama Menu</th>
                                <th class="min-w-125px">ID SubMenu</th>
                                <th class="min-w-125px">Nama SubMenu</th>
                                <th class="min-w-125px">Link</th>
                                <th class="min-w-125px">Urutan SubMenu</th>
                                <th class="min-w-125px">Status</th>
                                <th class="text-end min-w-100px">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold">
                            @foreach ($stmtSubMenu as $submenu)
                                <tr>
                                    <td class="d-flex align-items-center">{{ $loop->iteration }}</td>
                                    <td>{{ $submenu->menu->nama }}</td>
                                    <td>{{ $submenu->id }}</td>
                                    <td>{{ $submenu->nama }}</td>
                                    <td align="d-flex align-items-center">
                                        <a href="{{ $submenu->link }}">{{ $submenu->link }}</a>
                                    </td>
                                    <td>{{ $submenu->urutan }}</td>
                                    <td>
                                        <div
                                            class="badge badge-light-{{ $submenu->status_data == 1 ? 'success' : 'danger' }} fw-bold">
                                            {{ $submenu->status_data == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                            <span class="svg-icon svg-icon-5 m-0">
                                                {!! file_get_contents('metronic/demo2/assets/media/icons/duotune/arrows/arr072.svg') !!}
                                            </span>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                            data-kt-menu="true">
                                            <div class="menu-item px-3">
                                                <a href="{{ route('manajemen-submenu.edit', $submenu->id) }}"
                                                    class="menu-link px-3">Edit</a>
                                            </div>
                                            <form
                                                action="{{ route($submenu->status_data == 1 ? 'manajemen-submenu.nonaktif' : 'manajemen-submenu.aktif', $submenu->id) }}"
                                                method="POST">
                                                @method('put')
                                                @csrf
                                                <div class="menu-item px-3">
                                                    <button type="submit"
                                                        class="btn menu-link px-3">{{ $submenu->status_data == 1 ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
