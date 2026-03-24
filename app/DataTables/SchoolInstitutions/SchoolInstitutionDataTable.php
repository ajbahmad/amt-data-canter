<?php

namespace App\DataTables\SchoolInstitutions;

use App\Models\SchoolInstitution;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SchoolInstitutionDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'pages.school-institutions.actions')
            ->addColumn('status', function ($row) {
                return $row->is_active 
                    ? '<span class="badge badge-success">Active</span>' 
                    : '<span class="badge badge-danger">Inactive</span>';
            })
            ->setRowId('id')
            ->rawColumns(['action', 'status']);
    }

    /**
     * Build the DataTable HTML.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('school-institutions-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create'),
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get the dataTable columns definition.
     */
    private function getColumns(): array
    {
        return [
            Column::make('id')
                ->title('ID')
                ->width(100),
            Column::make('code')
                ->title('Code')
                ->width(120),
            Column::make('name')
                ->title('Institution Name')
                ->width(200),
            Column::make('email')
                ->title('Email')
                ->width(180),
            Column::make('phone')
                ->title('Phone')
                ->width(140),
            Column::make('city')
                ->title('City')
                ->width(120),
            Column::make('status')
                ->title('Status')
                ->width(100),
            Column::make('created_at')
                ->title('Created At')
                ->width(150),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SchoolInstitutions_' . date('YmdHis');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SchoolInstitution $model): QueryBuilder
    {
        return $model->newQuery();
    }
}
