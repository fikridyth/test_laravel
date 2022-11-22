@extends('layouts.master')
@section('content')

    @php
        use App\Models\CustomClass;
    @endphp

    @if ($aksesSubMenu != 1)
        @include('errors.405')
    @else
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title"></h3>
            </div>

            @if (count($errors) > 0)
                <div class="card-footer">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif


            @if (isset($stmtGetUser))
                <form id="quickForm" action="{{ app(CustomClass::class)->rootApp() }}/manajemenUser/edit/proses" method="post"
                    enctype="multipart/form-data">
                @else
                    <form id="quickForm" action="{{ app(CustomClass::class)->rootApp() }}/manajemenUser/tambah/proses"
                        method="post" enctype="multipart/form-data">
            @endif

            {{ csrf_field() }}

            @if (isset($stmtGetUser))
                @foreach ($stmtGetUser as $dataGetUser)
                    <input type="hidden" name="id" value="{{ $dataGetUser->id }}" class="form-control">
                @endforeach
            @endif

            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">NRIK</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="nrik"
                            value="{{ isset($dataGetUser) ? $dataGetUser->nrik : '' }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Karyawan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name"
                            value="{{ isset($dataGetUser) ? $dataGetUser->name : '' }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="tanggal_lahir"
                            value="{{ isset($dataGetUser) ? $dataGetUser->tanggal_lahir : '' }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="email"
                            value="{{ isset($dataGetUser) ? $dataGetUser->email : '' }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Role</label>
                    <div class="col-sm-3">
                        <select class="custom-select rounded-0 select2" name="id_role" required>
                            <option value="">--Pilih Role--</option>
                            @if (isset($stmtGetUser))
                                @foreach ($stmtListRole as $dataListRole)
                                    <option value="{{ $dataListRole->id }}"
                                        {{ $dataListRole->id == $dataGetUser->id_role ? 'selected' : '' }}>
                                        {{ $dataListRole->nama }}
                                    </option>
                                @endforeach
                            @else
                                @foreach ($stmtListRole as $dataListRole)
                                    <option value="{{ $dataListRole->id }}">{{ $dataListRole->nama }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Unit Kerja</label>
                    <div class="col-sm-3">
                        <select class="custom-select rounded-0 select2" name="id_unit_kerja" required>
                            <option value="">--Pilih Unit Kerja--</option>
                            @if (isset($stmtGetUser))
                                @foreach ($stmtListUnitKerja as $dataListUnitKerja)
                                    <option value="{{ $dataListUnitKerja->id }}"
                                        {{ $dataListUnitKerja->id == $dataGetUser->id_unit_kerja ? 'selected' : '' }}>
                                        {{ $dataListUnitKerja->nama }}
                                    </option>
                                @endforeach
                            @else
                                @foreach ($stmtListUnitKerja as $dataListUnitKerja)
                                    <option value="{{ $dataListUnitKerja->id }}">{{ $dataListUnitKerja->nama }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status Data</label>
                    <div class="col-sm-3">
                        <select class="custom-select rounded-0 select2" name="status_data" required>
                            <option value="" disabled>--Pilih Status Data--</option>
                            @if (isset($stmtGetUser))
                                <option value="1" {{ $stmtGetUser[0]->status_data == 1 ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="0" {{ $stmtGetUser[0]->status_data == 0 ? 'selected' : '' }}>Tidak
                                    Aktif
                                </option>
                            @else
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="submit" class="btn btn-primary" name="button"
                    value="submit">{{ isset($stmtGetUser) ? 'Update' : 'Submit' }}</button>
            </div>
            </form>

        </div>
    @endif

@endsection
