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
                                <h2>{{ $title }} {{ $stmtUser->name }}</h2>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <form action="{{ route('manajemen-user.update', $stmtUser->id) }}" class="form"
                                method="POST">
                                @method('put')
                                @csrf
                                <div class="fv-row mb-7">
                                    <label for="id_role" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">Role</span>
                                    </label>
                                    <select class="form-select @error('id_role') is-invalid @enderror" id="id_role"
                                        name="id_role" data-control="select2" data-placeholder="---Pilih Role---">
                                        <option></option>
                                        @foreach ($stmtRole as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('id_role', $stmtUser->id_role) == $role->id ? 'selected' : '' }}>
                                                {{ $role->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_role')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7">
                                    <label for="name" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">Nama</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Masukkan nama lengkap"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name', $stmtUser->name) }}" id="name" />
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7">
                                    <label for="nrik" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">NRIK</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="NRIK harus berbeda dengan yang sudah ada dan maksimal 8 karakter"></i>
                                    </label>
                                    <input type="text" maxlength="8"
                                        class="form-control form-control-solid @error('nrik') is-invalid @enderror"
                                        name="nrik" value="{{ old('nrik', $stmtUser->nrik) }}" id="nrik" />
                                    @error('nrik')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7">
                                    <label for="email" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">Email</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Email harus berbeda dengan yang sudah ada"></i>
                                    </label>
                                    <input type="email"
                                        class="form-control form-control-solid @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email', $stmtUser->email) }}" id="email" />
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">Tanggal Lahir</span>
                                    </label>
                                    <input class="form-control form-control-solid" placeholder="Pilih Tanggal Lahir"
                                        id="kt_default_daterangepicker" name="tanggal_lahir"
                                        value="{{ old('tanggal_lahir', $stmtUser->tanggal_lahir) }}" />
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7">
                                    <label for="id_unit_kerja" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">Unit Kerja</span>
                                    </label>
                                    <select class="form-select @error('id_unit_kerja') is-invalid @enderror"
                                        id="id_unit_kerja" name="id_unit_kerja" data-control="select2"
                                        data-placeholder="---Pilih Unit Kerja---">
                                        <option></option>
                                        @foreach ($stmtUnitKerja as $unitKerja)
                                            <option value="{{ $unitKerja->id }}"
                                                {{ old('id_unit_kerja', $stmtUser->id_unit_kerja) == $unitKerja->id ? 'selected' : '' }}>
                                                {{ $unitKerja->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_unit_kerja')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
