<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent(
                $query->with('roles', 'unitKerja')
                    ->filter(request(['role', 'status_blokir']))
            )
            ->addColumn('aksi', function ($row) {
                $btnUpdate = '-';
                $routeEdit = route('manajemen-user.edit', $row->id);
                if (Gate::allows('User Edit')) {
                    $btnUpdate = '<a href="' . $routeEdit . '" class="btn btn-primary btn-sm">Ubah</a>';
                }
                return $btnUpdate;
            })
            ->addColumn('role', function ($row) {
                return $row->roles->pluck('name')->implode(', ');
            })
            ->editColumn('tanggal_lahir', function ($row) {
                return Carbon::parse($row->tanggal_lahir)->locale(config('app.locale'))->translatedFormat('j F Y');
            })
            ->editColumn('is_blokir', function ($row) {
                $btnUnblock = '-';
                $routeUnblock = route('manajemen-user.buka-blokir', $row->id);
                if ($row->is_blokir === 1) {
                    $btnUnblock = '<span class="badge badge-light-danger">
                                        <a href="' . $routeUnblock . '"
                                            style="color:inherit; text-decoration: none">
                                            User Terblokir
                                        </a>
                                </span>';
                }
                return $btnUnblock;
            })
            ->editColumn('ip_address', function ($row) {
                $btnIp = '';
                $routeIp = route('manajemen-user.lepas-ip', $row->id);
                if ($row->ip_address) {
                    $btnIp = '
                        <span class="badge badge-light-primary">
                            <a href="' . $routeIp . '">' . $row->ip_address . '</a>
                        </span>
                    ';
                }
                return $btnIp;
            })
            ->rawColumns(['aksi', 'role', 'is_blokir', 'ip_address']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('logactivity-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-sm-2'f><'col-sm-10'>>" . "<'row'<'col-sm-12'tr>>" . "<'row'<'col-sm-1 mt-1'l><'col-sm-4 mt-3'i><'col-sm-7'p>>")
            ->buttons([''])
            ->scrollX(true)
            ->scrollY('500px')
            ->fixedColumns(['left' => 3, 'right' => 3])
            ->language(['processing' => '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>'])
            ->orderBy(0, 'asc')
            ->parameters([
                "lengthMenu" => [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ]
            ])
            ->addTableClass('table align-middle table-rounded table-striped table-row-gray-300 fs-6 gy-5');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->searchable(false)->addClass('text-center'),
            Column::make('nrik')->title('NRIK'),
            Column::make('name')->title('Nama'),
            Column::make('tanggal_lahir'),
            Column::make('email'),
            Column::make('role')->searchable(false),
            Column::make('unit_kerja.nama')->title('Unit Kerja'),
            Column::make('is_blokir')->title('Status Blokir')
                ->searchable(false)
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('ip_address')->searchable(false)->title('IP Address')->addClass('text-center'),
            Column::computed('aksi')
                ->searchable(false)
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center min-w-100px'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'User_' . date('YmdHis');
    }
}