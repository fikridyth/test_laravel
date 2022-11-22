@extends('layouts.master')
@section('content')
    @php
        use App\Models\CustomClass;
    @endphp

    @if ($aksesSubMenu != 1)
        @include('errors.405')
    @else
        <div class="container-fluid">
            <h3 class="text-black-50">Manajemen User</h3>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <a href="{{ app(CustomClass::class)->rootApp() }}/manajemenUser/tambah"
                                    class="btn btn-info"><i class='fa fa-plus'></i></a>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr align="center" class="alert-dark">
                                        <th>No.</th>
                                        <th>NRIK</th>
                                        <th>Nama Karyawan</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Unit Kerja</th>
                                        <th>Status Blokir</th>
                                        <th>IP Address</th>
                                        <th>Status Data</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stmtListUser as $dataListUser)
                                        <tr>
                                            <td align="center">{{ $loop->iteration }}</td>
                                            <td align="center">{{ $dataListUser->nrik }}</td>
                                            <td align="left">{{ $dataListUser->name }}</td>
                                            <td align="center">{{ $dataListUser->tanggal_lahir }}</td>
                                            <td align="left">{{ $dataListUser->email }}</td>
                                            <td align="center">
                                                {{ app(CustomClass::class)->getNamaRole($dataListUser->id_role) }}
                                            <td align="center">
                                                {{ app(CustomClass::class)->getNamaUnitKerja($dataListUser->id_unit_kerja) }}
                                            </td>
                                            <td align="center">
                                                {{ app(CustomClass::class)->ketStatusBlokir($dataListUser->is_blokir) }}
                                                @if (isset($dataListUser->is_blokir) && $dataListUser->is_blokir == 1)
                                                    | <a href="{{ app(CustomClass::class)->rootApp() }}/manajemenUser/bukaBlokir/{{ app(CustomClass::class)->enkrip($dataListUser->id) }}"
                                                        class="btn btn-danger">Buka Blokir</a>
                                                @endif
                                            </td>
                                            <td align="center">
                                                {{ $dataListUser->ip_address }}
                                                @if (isset($dataListUser->ip_address))
                                                    | <a href="{{ app(CustomClass::class)->rootApp() }}/manajemenUser/bukaIPNyangkut/{{ app(CustomClass::class)->enkrip($dataListUser->id) }}"
                                                        class="btn btn-danger">Lepaskan IP</a>
                                                @endif
                                            </td>
                                            <td align="center">
                                                {{ app(CustomClass::class)->ketStatusData($dataListUser->status_data) }}
                                            </td>
                                            <td align="center"><a
                                                    href="{{ app(CustomClass::class)->rootApp() }}/manajemenUser/edit/{{ app(CustomClass::class)->enkrip($dataListUser->id) }}"
                                                    class="btn btn-info"><i class='fa fa-pen'></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

        </div>
    @endif
@endsection
