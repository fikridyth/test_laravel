@extends('main')
@section('page.title', 'Manajemen Role')

@push('content_styles')
    <link href="{{ asset('dual-listbox/dual-listbox.css') }}" rel="stylesheet" />
@endpush
@section('content')

    @include('layouts.toolbar')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title">
                                <span class="svg-icon svg-icon-1 me-2">
                                    {!! file_get_contents('metronic/demo2/assets/media/icons/duotune/communication/com006.svg') !!}
                                </span>
                                <h2> {{ $role->id == null ? 'Tambah Role' : 'Ubah Role' }} </h2>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <form role="form" method="POST"
                                action="{{ $role->id == null ? route('role.store') : route('role.update', ['id' => $role->id]) }}">
                                @csrf
                                <div class="fv-row mb-7">
                                    <label for="id" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">id</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Id Wajib diisi"></i>
                                    </label>
                                    <input type="number" min="1"
                                        class="form-control form-control-solid @error('id') is-invalid @enderror"
                                        name="id" value="{{ old('id', $role->id) }}" id="id"
                                        {{ $role->id == null ? '' : 'readonly' }} />
                                    @error('id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7">
                                    <label for="name" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">Nama Role</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Nama Role tidak boleh sama dengan yang sudah ada, minimal berisi 2 karakter dan maksimal 50 karakter"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name', $role->name) }}" id="name" />
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7">
                                    <label for="guard_name" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">Nama Guard</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Guard Name minimal berisi 2 karakter dan maksimal 50 karakter"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('guard_name') is-invalid @enderror"
                                        name="guard_name" value="{{ old('guard_name', $role->guard_name) }}"
                                        id="guard_name" />
                                    @error('guard_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label required">Permissions</label>
                                    <select class="form-control" id="permissions" name="permissions[]" multiple="">
                                        @foreach ($permissions as $item)
                                            <option value="{{ $item->name }}"
                                                {{ in_array($item->name, old('permissions') ?? []) ? 'selected' : (in_array($item->name, $rolePermissions) ? 'selected' : '') }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="separator mb-6"></div>
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-light me-3">Reset</button>
                                    <button type="submit" class="btn btn-primary">
                                        <span
                                            class="indicator-label">{{ $role->id == null ? 'Simpan' : 'Perbarui' }}</span>
                                        <span class="indicator-progress">Harap tunggu...
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

@push('content_scripts')
    <script src="{{ asset('dual-listbox/dual-listbox.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            let dlb1 = new DualListbox('#permissions');
        });
    </script>
@endpush
