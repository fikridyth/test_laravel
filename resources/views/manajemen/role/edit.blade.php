@extends('main')

@section('content')
    @include('layouts.toolbar')

    <div id="kt_content_container" class="d-flex flex-column-auto align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="card card-flush h-lg-100" id="kt_contacts_main">
                        <div class="card-header pt-7" id="kt_chat_contacts_header">
                            <div class="card-title">
                                <span class="svg-icon svg-icon-1 me-2">
                                    {!! file_get_contents('metronic/demo2/assets/media/icons/duotune/general/gen010.svg') !!}
                                </span>
                                <h2>{{ $title }} {{ $stmtRole->nama }}</h2>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <form action="{{ route('manajemen-role.update', $stmtRole->id) }}" class="form"
                                method="POST">
                                @method('put')
                                @csrf
                                <div class="fv-row mb-7">
                                    <label for="nama" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">Nama Role</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Nama Role tidak boleh sama dengan yang sudah ada"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('nama') is-invalid @enderror"
                                        name="nama" value="{{ old('nama', $stmtRole->nama) }}" id="nama" />
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7">
                                    <div class="col-md-2">
                                        <label for="nama" class="fs-6 fw-semibold form-label mt-3">
                                            <span class="required">Menu</span>
                                        </label>
                                    </div>
                                    <div class="col-md-10">
                                        <ul>
                                            @foreach ($stmtMenu as $menu)
                                                <li style="list-style: none">
                                                    <label class="form-check form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox" name="id_menu[]"
                                                            value="{{ $menu->id }}"
                                                            {{ (is_array(old('id_menu', explode(',', $stmtRole->id_menu))) && in_array($menu->id, old('id_menu', explode(',', $stmtRole->id_menu)))) || (is_array(old('id_menu')) && in_array($menu->id, old('id_menu'))) ? ' checked' : '' }} />
                                                        <span class="form-check-label">
                                                            {{ $menu->nama }}
                                                        </span>
                                                    </label>
                                                </li>
                                                @foreach ($stmtSubMenu as $submenu)
                                                    @if ($menu->id == $submenu->id_menu)
                                                        <ul>
                                                            <li style="list-style: none">
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="id_submenu[]" value="{{ $submenu->id }}"
                                                                        {{ is_array(old('id_submenu', explode(',', $stmtRole->id_submenu))) && in_array($submenu->id, old('id_submenu', explode(',', $stmtRole->id_submenu))) ? ' checked' : '' }} />
                                                                    <span class="form-check-label">
                                                                        {{ $submenu->nama }}
                                                                    </span>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="separator mb-6"></div>
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-light me-3">Cancel</button>
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Update</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
