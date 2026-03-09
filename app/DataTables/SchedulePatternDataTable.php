<?php

namespace App\DataTables;

use App\DataTables\Config\GlobalConfigDatatable;
use App\Models\SchoolInstitution;
use App\Models\SchoolLevel;
use App\Models\SchedulePattern;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SchedulePatternDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action', 'created_at'])
            ->addColumn('action', function ($row) {
                $showUrl = route('schedule-patterns.show', $row->id);
                $editUrl = route('schedule-patterns.edit', $row->id);
                $deleteUrl = route('schedule-patterns.destroy', $row->id);
                $data = '
                <div class="flex justify-center items-center gap-2">
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-warning text-warning hover:bg-warning hover:text-white p-0 btn-sm" onclick="editData(\''.$row->id.'\', \''.$editUrl.'\')" title="Edit"><i class="ti ti-edit"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white text-error border border-error hover:bg-error hover:text-white p-0 btn-sm" onclick="deleteData(\''.$row->id.'\', \''.$deleteUrl.'\')" title="Hapus"><i class="ti ti-trash"></i></button>
                </div>
                ';
                return $data;
            })
            ->addColumn('school_institution_id', function($row){
                return $row->schoolInstitution->name ?? '-';
            })
            ->addColumn('school_level_id', function($row){
                return $row->schoolLevel->name ?? '-';
            })
            ->addColumn('created_at', function ($row) {
                Carbon::setLocale('id');
                return Carbon::parse($row->created_at)->translatedFormat('d F Y');
            })

            // ✅ Kolom yang bisa diurut
            ->orderColumn('name', function($query, $direction) {
                $query->orderBy('name', $direction);
            })
            ->orderColumn('school_institution_id', function($query, $direction) {
                $query->orderBy('school_institution_id', $direction);
            })
            ->orderColumn('school_level_id', function($query, $direction) {
                $query->orderBy('school_level_id', $direction);
            })
            ->orderColumn('created_at', function($query, $direction) {
                $query->orderBy('created_at', $direction);
            })

            // Filterable
            ->filterColumn('name', function($query, $keyword) {
                $query->where('name', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('school_institution_id', function($query, $keyword) {
                $query->where('school_institution_id', $keyword);
            })
            ->filterColumn('school_level_id', function($query, $keyword) {
                $query->where('school_level_id', $keyword);
            })
            ->filterColumn('created_at', function($query, $keyword){
                if ($keyword) {
                    $query->whereDate('created_at', 'ILIKE', "%{$keyword}%");
                }
            })
            
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SchedulePattern $model): QueryBuilder
    {
        return $model->newQuery()->with(['schoolInstitution', 'schoolLevel']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $getColumns = $this->getColumns();
        $parameters = GlobalConfigDatatable::parameters($getColumns);
        return $this->builder()
            ->setTableId('datatable')
            ->columns($getColumns)
            ->minifiedAjax()
            ->ajax([
                'type' => 'GET',
                'beforeSend' => 'function() { $("#loading").removeClass("hide"); }',
                'complete' => GlobalConfigDatatable::getInitColumnSearchScript($getColumns)
            ])
            ->dom(GlobalConfigDatatable::dom())
            ->orderBy(count($getColumns) - 1, 'desc')
            ->parameters($parameters);
    }

    private function getSchoolInstitutions()
    {
        $institutions = SchoolInstitution::active()->get();
        $options = [
            ['label'=>'Filter Semua', 'value' => '']
        ];
        foreach ($institutions as $institution) {
            $options[] = ['label' => $institution->name, 'value' => $institution->id];
        }
        return json_encode($options);
    }

    private function getSchoolLevels()
    {
        $levels = SchoolLevel::active()->get();
        $options = [
            ['label'=>'Filter Semua', 'value' => '']
        ];
        foreach ($levels as $level) {
            $options[] = ['label' => $level->name, 'value' => $level->id];
        }
        return json_encode($options);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $column[] = Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')->attributes(['data-type' => 'select', 'data-name' => 'action', 'data-label' => 'Action', 'data-value' => GlobalConfigDatatable::lines()]);
        $column[] = Column::make('school_institution_id')->name('school_institution_id')->title('Lembaga')->attributes(['data-type' => 'select', 'data-name' => 'school_institution_id', 'data-label' => 'Institusi', 'data-value' => $this->getSchoolInstitutions()]);
        $column[] = Column::make('school_level_id')->name('school_level_id')->title('Level Sekolah')->attributes(['data-type' => 'select', 'data-name' => 'school_level_id', 'data-label' => 'Level Sekolah', 'data-value' => $this->getSchoolLevels()]);
        $column[] = Column::make('name')->name('name')->title('Nama Pola Jadwal')->attributes(['data-type' => 'text', 'data-name' => 'name', 'data-label' => 'Nama Pola Jadwal', 'data-value' => null]);
        $column[] = Column::make('created_at')->name('created_at')->title('Dibuat')->attributes(['data-type' => 'date', 'data-name' => 'created_at', 'data-label' => 'Dibuat']);
        return $column;
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'SchedulePatterns_' . date('YmdHis');
    }
}
