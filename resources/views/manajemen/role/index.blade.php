@extends('main')

@section('content')
    @include('layouts.toolbar')

    @php
        use App\Models\CustomClass;
    @endphp

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
                                class="form-control form-control-solid w-250px ps-14" placeholder="Search role" />
                        </div>
                    </div>
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <div class="d-flex justify-content-end" data-kt-menu-table-toolbar="base">
                            <a href="{{ route('manajemen-role.create') }}" type="button" class="btn btn-primary">
                                <span class="svg-icon svg-icon-2">
                                    {!! file_get_contents('metronic/demo2/assets/media/icons/duotune/arrows/arr075.svg') !!}
                                </span>
                                Add Role
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
                                <th class="min-w-125px">Nama Role</th>
                                <th class="min-w-125px">Menu</th>
                                <th class="min-w-125px">SubMenu</th>
                                <th class="text-end min-w-100px">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold">
                            @foreach ($stmtRole as $role)
                                <tr>
                                    <td class="d-flex align-items-center">{{ $loop->iteration }}</td>
                                    <td class="align-baseline">{{ $role->nama }}</td>
                                    <td class="align-baseline">
                                        <ol>
                                            @foreach (explode(',', $role->id_menu) as $id_menu)
                                                @if ($id_menu != 0 && $id_menu != '')
                                                    <li>{{ app(CustomClass::class)->getNamaMenu($id_menu) }}</li>
                                                @endif
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td class="align-baseline">
                                        <ol>
                                            @foreach (explode(',', $role->id_submenu) as $id_submenu)
                                                @if ($id_submenu != 0)
                                                    <li>
                                                        {{ app(CustomClass::class)->getNamaMenuFromSubmenu($id_submenu) }}
                                                        &#8594;{{ app(CustomClass::class)->getNamaSubmenu($id_submenu) }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td class="align-baseline text-end">
                                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                            <span class="svg-icon svg-icon-5 m-0">
                                                {!! file_get_contents('metronic/demo2/assets/media/icons/duotune/arrows/arr072.svg') !!}
                                            </span>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                            data-kt-menu="true">
                                            <div class="menu-item px-3">
                                                <a href="{{ route('manajemen-role.edit', $role->id) }}"
                                                    class="menu-link px-3">Edit</a>
                                            </div>
                                            <form action="{{ route('manajemen-role.destroy', $role->id) }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <div class="menu-item px-3">
                                                    <button type="submit" class="btn menu-link px-3">Delete</button>
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
