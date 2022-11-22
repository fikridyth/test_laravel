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
                                <h2>Add New Menu</h2>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <form action="{{ route('manajemen-menu.store') }}" class="form" method="POST">
                                @csrf
                                <div class="fv-row mb-7">
                                    <label for="nama" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">Nama Menu</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Nama Menu tidak boleh sama dengan yang sudah ada dan maksimal 100 karakter"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('nama') is-invalid @enderror"
                                        name="nama" value="{{ old('nama') }}" id="nama" />
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7">
                                    <label for="link" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">Link</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Masukkan '#' jika tidak memiliki submenu"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('link') is-invalid @enderror"
                                        id="link" name="link" value="{{ old('link') }}" />
                                    @error('link')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7">
                                    <label for="urutan" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">Urutan Menu</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Urutan tidak boleh sama dengan yang sudah ada"></i>
                                    </label>
                                    <input type="number" min="1"
                                        class="form-control form-control-solid @error('urutan') is-invalid @enderror"
                                        id="urutan" name="urutan" value="{{ old('urutan') }}" />
                                    @error('urutan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="separator mb-6"></div>
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-light me-3">Cancel</button>
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Save</span>
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
