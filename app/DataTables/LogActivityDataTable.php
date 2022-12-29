<?php

namespace App\DataTables;

use App\Models\LogActivity;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LogActivityDataTable extends DataTable
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
                $query
                    ->with('user', 'user.roles')
                    ->filter(request(['user', 'role']))
            )
            ->editColumn('id_user', function ($row) {
                $routeUser = route('manajemen-user.show', $row->id_user);
                return '<a href="' . $routeUser . '" target="_blank" rel="noopener noreferrer">' . $row->user->name . '</a>';
            })
            ->addColumn('role', function ($row) {
                $roles = [];
                foreach ($row->user->roles->pluck('name') as $role) {
                    $roles[] = $role;
                }
                return implode(', ', $roles);
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->locale(config('app.locale'))->translatedFormat('j F Y, H:i:s');
            })
            ->rawColumns(['id_user', 'role']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LogActivity $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LogActivity $model)
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
            ->fixedColumns(['left' => 2, 'right' => 1])
            ->language(['processing' => '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>'])
            ->orderBy(0)
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
            Column::make('id_user')->orderable(false)->searchable(false)->title('User')->addClass('text-center'),
            Column::make('role')->orderable(false)->searchable(false),
            Column::make('activity_content')->title('Aktivitas'),
            Column::make('ip_access')->title('IP Address'),
            Column::make('url')->title('URL'),
            Column::make('method'),
            Column::make('operating_system'),
            Column::make('device_type')->title('Tipe Perangkat'),
            Column::make('browser_name')->title('Peramban'),
            Column::make('created_at')->title('Diakses Pada'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'LogActivity_' . date('YmdHis');
    }
}
