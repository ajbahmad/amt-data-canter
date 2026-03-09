<?php

namespace App\DataTables;

use App\DataTables\Config\GlobalConfigDatatable;
use App\Models\SchoolLevel;
use App\Models\Grade;
use App\Models\SchoolInstitution;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class GradeDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action', 'is_active', 'created_at'])
            ->addColumn('action', function ($row) {
                $showUrl = route('grades.show', $row->id);
                $editUrl = route('grades.edit', $row->id);
                $deleteUrl = route('grades.destroy', $row->id);
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
            ->orderColumn('school_institution_id', function($query, $direction) {
                $query->orderBy('school_institution_id', $direction);
            })
            ->orderColumn('school_level_id', function($query, $direction) {
                $query->orderBy('school_level_id', $direction);
            })
            ->orderColumn('name', function($query, $direction) {
                $query->orderBy('name', $direction);
            })
            ->orderColumn('school_level_id', function($query, $direction) {
                $query->orderBy('school_level_id', $direction);
            })
            ->orderColumn('order_no', function($query, $direction) {
                $query->orderBy('order_no', $direction);
            })
            ->addColumn('is_active', function($row){
                return $row->is_active ? '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            <i class="ti ti-circle-check mr-2"></i>Aktif
                        </span>' : '<span style="white-space: nowrap;" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            <i class="ti ti-circle-x mr-2"></i>Non Aktif
                        </span>';
            })
            ->orderColumn('created_at', function($query, $direction) {
                $query->orderBy('created_at', $direction);
            })

            // filterable
            ->filterColumn('school_institution_id', function($query, $keyword) {
                $query->where('school_institution_id', $keyword);
            })
            ->filterColumn('school_level_id', function($query, $keyword) {
                $query->where('school_level_id', $keyword);
            })
            ->filterColumn('name', function($query, $keyword) {
                $query->where('name', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('school_level_name', function($query, $keyword) {
                $query->where('school_level_id', 'ILIKE', "%{$keyword}%");
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
    public function query(Grade $model): QueryBuilder
    {
        return $model->newQuery()->with('schoolLevel');
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
        $json = json_encode([
            ['label'=>'Filter Semua', 'value' => ''],
            ['label'=>'Aktif', 'value' => 'true'],
            ['label'=>'Non Aktif', 'value' => 'false'],
        ]);
        $column[] = Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')->attributes(['data-type' => 'select', 'data-name' => 'action', 'data-label' => 'Action', 'data-value' => GlobalConfigDatatable::lines()]);
        $column[] = Column::make('school_institution_id')->name('school_institution_id')->title('Lembaga')->attributes(['data-type' => 'select', 'data-name' => 'school_institution_id', 'data-label' => 'Institusi', 'data-value' => $this->getSchoolInstitutions()]);
        $column[] = Column::make('school_level_id')->name('school_level_id')->title('Level Sekolah')->attributes(['data-type' => 'select', 'data-name' => 'school_level_id', 'data-label' => 'Level Sekolah', 'data-value' => $this->getSchoolLevels()]);
        $column[] = Column::make('name')->name('name')->title('Nama Kelas')->attributes(['data-type' => 'text', 'data-name' => 'name', 'data-label' => 'Nama Kelas', 'data-value' => null]);
        $column[] = Column::make('order_no')->name('order_no')->title('Urutan')->attributes(['data-type' => 'number', 'data-name' => 'order_no', 'data-label' => 'Urutan', 'data-value' => null]);
        $column[] = Column::make('is_active')->name('is_active')->title('Status')->attributes(['data-type' => 'select', 'data-name' => 'is_active', 'data-label' => 'Status', 'data-value' => $json]);
        $column[] = Column::make('created_at')->name('created_at')->title('Dibuat')->attributes(['data-type' => 'date', 'data-name' => 'created_at', 'data-label' => 'Dibuat']);
        return $column;
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'Grades_' . date('YmdHis');
    }
}
