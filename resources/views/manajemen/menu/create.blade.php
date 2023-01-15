@extends('main')
@section('page.title', 'Form Menu')
@section('content')

    @include('layouts.toolbar')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="card card-flush h-lg-100">
                        <div class="card-header pt-7">
                            <div class="card-title">
                                <span class="svg-icon svg-icon-1 me-2">
                                    {!! file_get_contents('metronic/demo2/assets/media/icons/duotune/general/gen010.svg') !!}
                                </span>
                                <h2>{{ $title }}</h2>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <form role="form" method="POST" id="form"
                                action="{{ $menu->id == null ? route('menu.store') : route('menu.update', ['id' => $menu->id]) }}">
                                @csrf
                                @if ($menu->id == null)
                                    <div class="fv-row mb-7">
                                        <label for="id" class="fs-6 fw-semibold form-label mt-3">
                                            <span class="required">id</span>
                                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                                title="Id Wajib diisi"></i>
                                        </label>
                                        <input type="number" min="1"
                                            class="form-control form-control-solid @error('id') is-invalid @enderror"
                                            name="id" value="{{ old('id', $menu->id) }}" id="id" />
                                        @error('id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                @endif
                                <div class="fv-row mb-7">
                                    <label for="name" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">Nama Menu</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Nama Menu tidak boleh sama dengan yang sudah ada dan minimal berisi 2 karakter"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name', $menu->name) }}" id="name" />
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7">
                                    <label for="route" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">Route</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Masukkan 'index' jika route belum dibuat"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('route') is-invalid @enderror"
                                        name="route" value="{{ old('route', $menu->route) }}" id="route"
                                        placeholder="index" />
                                    @error('route')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7">
                                    <label for="icon" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">Ikon</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Icon wajib diisi"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('icon') is-invalid @enderror"
                                        name="icon" value="{{ old('icon', 'fa-dashboard', $menu->icon) }}" id="icon"
                                        placeholder="fa-dashboard" />
                                    @error('icon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7">
                                    <label for="order" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">Order</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Order adalah urutan menu. Order hanya bisa diisi dengan angka, minimal 1"></i>
                                    </label>
                                    <input type="number" min="1"
                                        class="form-control form-control-solid @error('order') is-invalid @enderror"
                                        name="order" value="{{ old('order', $menu->order) }}" id="order" />
                                    @error('order')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7">
                                    <label for="roles" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">Role</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Role bisa dipilih lebih dari 1"></i>
                                    </label>
                                    <select class="form-select form-select-solid" multiple data-control="select2"
                                        data-placeholder="Pilih Role" id="roles" name="roles[]">
                                        <option></option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ in_array($role->id, $menuRoles) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7">
                                    <label for="parent_id" class="fs-6 fw-semibold form-label mt-3">
                                        <span class="required">Parent</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Parent_id wajib dipilih, default '--Root--'"></i>
                                    </label>
                                    <select class="form-select form-select-solid" data-control="select2" id="parent_id"
                                        name="parent_id">
                                        <option value="0" {{ 0 == $menu->parent_id ? 'selected' : '' }}>--Root--
                                        </option>
                                        @foreach ($menus as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $menu->parent_id ? 'selected' : '' }}>
                                                {!! $item->name !!}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="separator mb-6"></div>
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-light me-3">Reset</button>
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">
                                            {{ $menu->id == null ? 'Simpan' : 'Perbarui' }}
                                        </span>
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
    <script>
        $(document).ready(function() {
            $('#parent, #roles').select2({});

            const container = document.querySelector("#kt_content");

            const blockContainer = new KTBlockUI(container, {
                message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Sedang menyimpan data...</div>',
            });

            $('#form').on('submit', function() {
                if (!blockContainer.isBlocked()) {
                    blockContainer.block();
                }
            });
        });
    </script>
@endpush
