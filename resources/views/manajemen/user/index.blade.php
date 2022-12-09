@extends('main')

@section('content')
    @include('layouts.toolbar')

    @php
        use Illuminate\Support\Carbon;
    @endphp

    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <form action="{{ route('manajemen-user.index') }}">
                                <div class="d-flex align-items-center position-relative my-1">
                                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                        {!! file_get_contents('metronic/demo2/assets/media/icons/duotune/general/gen021.svg') !!}
                                    </span>
                                    <div class="me-4">
                                        <input type="search" name="nama"
                                            class="form-control form-control-solid w-290px ps-14"
                                            placeholder="Cari berdasarkan nama" autocomplete="off" value="{{ request('nama') }}">
                                    </div>
                                    <button type="submit" class="btn btn-secondary btn-lg">Cari</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end">
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
                                <div class="px-7 py-5" data-kt-user-table-filter="form">
                                    <form action="{{ route('manajemen-user.index') }}">
                                        <div class="mb-10">
                                            <label class="form-label fs-6 fw-semibold">Role :</label>
                                            <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                                data-placeholder="Pilih Role" data-allow-clear="true"
                                                data-kt-user-table-filter="two-step" data-hide-search="true" name="role">
                                                <option></option>
                                                @foreach ($stmtRole as $role)
                                                    @if (request('role') === $role->name)
                                                        <option value="{{ $role->name }}" selected>{{ $role->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-10">
                                            <label class="form-check form-switch form-check-custom form-check-solid"
                                                for="status_blokir">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="status_blokir" name="status_blokir"
                                                    {{ request('status_blokir') == 1 ? 'checked' : '' }} />
                                                <span class="form-check-label">
                                                    User Terblokir
                                                </span>
                                            </label>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="reset"
                                                class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                                data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>
                                            <button type="submit" class="btn btn-primary fw-semibold px-6"
                                                data-kt-menu-dismiss="true"
                                                data-kt-user-table-filter="filter">Apply</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <a href="{{ route('manajemen-user.create') }}" type="button" class="btn btn-primary">
                                <span class="svg-icon svg-icon-2">
                                    {!! file_get_contents('metronic/demo2/assets/media/icons/duotune/arrows/arr075.svg') !!}
                                </span>
                                Tambah User
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body py-4">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 kt_default_datatable">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>No.</th>
                                <th>NRIK</th>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Unit Kerja</th>
                                <th class="text-center">Status Blokir</th>
                                <th>IP Adress</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold">
                            @foreach ($stmtUser as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->nrik }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ Carbon::parse($user->tanggal_lahir)->locale('id')->translatedFormat('j F Y') }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>
                                    <td>{{ $user->unitKerja->nama }}</td>
                                    <td class="text-center">
                                        <span
                                            class="{{ $user->is_blokir === 1 ? 'badge badge-light-danger' : '' }}">
                                            <a href="{{ route('manajemen-user.buka-blokir', $user->id) }}"
                                                style="color:inherit; text-decoration: none">
                                                {{ $user->is_blokir === 1 ? 'User Terblokir' : '-' }}
                                            </a>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="{{ $user->ip_address ? 'badge badge-light-primary' : '' }}">
                                            <a
                                                href="{{ route('manajemen-user.lepas-ip', $user->id) }}">{{ $user->ip_address }}</a>
                                        </span>
                                    </td>
                                    <td><a href="{{ route('manajemen-user.edit', $user->id) }}" class="btn btn-primary btn-sm">Ubah</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    @if (!$stmtUser->isEmpty())
                        <div class="pagination">
                            <div class="d-flex flex-row">
                                <div class="d-flex flex-column flex-row-auto flex-center w-200px">
                                    <div class="d-flex flex-column-auto">Showing {{ $stmtUser->firstItem() }} to
                                        {{ $stmtUser->lastItem() }} of {{ $stmtUser->total() }} entries</div>
                                </div>
                                <div class="d-flex flex-column flex-row-fluid">
                                    {{ $stmtUser->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
