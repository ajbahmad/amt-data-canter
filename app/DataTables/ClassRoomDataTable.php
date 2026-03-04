<?php

namespace App\DataTables;

use App\DataTables\Config\GlobalConfigDatatable;
use App\Models\SchoolInstitution;
use App\Models\SchoolYear;
use App\Models\ClassRoom;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClassRoomDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action','is_active','created_at'])
            ->addColumn('action', function ($row) {
                $showUrl = route('class-rooms.show', $row->id);
                $editUrl = route('class-rooms.edit', $row->id);
                $deleteUrl = route('class-rooms.destroy', $row->id);
                $data = '
                <div class="flex justify-center items-center gap-2">
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-info text-info hover:bg-info hover:text-white p-0 btn-sm" onclick="window.location.href=\''.$showUrl.'\'" title="Lihat"><i class="ti ti-eye"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-warning text-warning hover:bg-warning hover:text-white p-0 btn-sm" onclick="editData(\''.$row->id.'\', \''.$editUrl.'\')" title="Edit"><i class="ti ti-edit"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white text-error border border-error hover:bg-error hover:text-white p-0 btn-sm" onclick="deleteData(\''.$row->id.'\', \''.$deleteUrl.'\')" title="Hapus"><i class="ti ti-trash"></i></button>
                </div>
                ';
                return $data;
            })
            ->addColumn('school_institution_name', function($row){
                return $row->schoolInstitution->name ?? '-';
            })
            ->addColumn('school_year_name', function($row){
                return $row->schoolYear->name ?? '-';
            })
            ->addColumn('grade_name', function($row){
                return $row->grade->name ?? '-';
            })
            ->addColumn('is_active', function($row){
                return $row->is_active ? '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            <i class="ti ti-circle-check mr-2"></i>Aktif
                        </span>' : '<span style="white-space: nowrap;" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            <i class="ti ti-circle-x mr-2"></i>Non Aktif
                        </span>';
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
            ->orderColumn('school_year_id', function($query, $direction) {
                $query->orderBy('school_year_id', $direction);
            })
            ->orderColumn('grade_id', function($query, $direction) {
                $query->orderBy('grade_id', $direction);
            })
            ->orderColumn('capacity', function($query, $direction) {
                $query->orderBy('capacity', $direction);
            })
            ->orderColumn('is_active', function($query, $direction) {
                $query->orderBy('is_active', $direction);
            })
            ->orderColumn('created_at', function($query, $direction) {
                $query->orderBy('created_at', $direction);
            })

            // filterable
            ->filterColumn('name', function($query, $keyword) {
                $query->where('name', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('school_institution_name', function($query, $keyword) {
                $query->where('school_institution_id', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('school_year_name', function($query, $keyword) {
                $query->where('school_year_id', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('grade_name', function($query, $keyword) {
                $query->where('grade_id', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('is_active', function($query, $keyword) {
                if ($keyword !== '') {
                    $isActive = strtolower($keyword) === 'true' ? true : (strtolower($keyword) === 'false' ? false : null);
                    if ($isActive !== null) {
                        $query->where('is_active', $isActive);
                    }
                }
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
    public function query(ClassRoom $model): QueryBuilder
    {
        return $model->newQuery()->with('schoolInstitution', 'schoolYear', 'grade');
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

    private function getSchoolInstitution()
    {
        $schoolInstitutions = SchoolInstitution::pluck('name', 'id')->toArray();
        $options = [
            ['label'=>'Filter Semua', 'value' => '']
        ];
        foreach ($schoolInstitutions as $id => $name) {
            $options[] = ['label' => $name, 'value' => $id];
        }
        return json_encode($options);
    }

    private function getSchoolYear()
    {
        $schoolYears = SchoolYear::pluck('name', 'id')->toArray();
        $options = [
            ['label'=>'Filter Semua', 'value' => '']
        ];
        foreach ($schoolYears as $id => $name) {
            $options[] = ['label' => $name, 'value' => $id];
        }
        return json_encode($options);
    }

    private function getGrade()
    {
        $grades = \App\Models\Grade::pluck('name', 'id')->toArray();
        $options = [
            ['label'=>'Filter Semua', 'value' => '']
        ];
        foreach ($grades as $id => $name) {
            $options[] = ['label' => $name, 'value' => $id];
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
        $column[] = Column::make('name')->name('name')->title('Nama Rombel')->attributes(['data-type' => 'text', 'data-name' => 'name', 'data-label' => 'Nama Rombel', 'data-value' => null]);
        $column[] = Column::make('school_institution_name')->name('school_institution_name')->title('Sekolah')->attributes(['data-type' => 'select', 'data-name' => 'school_institution_name', 'data-label' => 'Sekolah', 'data-value' => $this->getSchoolInstitution()]);
        $column[] = Column::make('school_year_name')->name('school_year_name')->title('Tahun Akademik')->attributes(['data-type' => 'select', 'data-name' => 'school_year_name', 'data-label' => 'Tahun Akademik', 'data-value' => $this->getSchoolYear()]);
        $column[] = Column::make('grade_name')->name('grade_name')->title('Kelas')->attributes(['data-type' => 'select', 'data-name' => 'grade_name', 'data-label' => 'Kelas', 'data-value' => $this->getGrade()]);
        $column[] = Column::make('capacity')->name('capacity')->title('Kapasitas')->attributes(['data-type' => 'number', 'data-name' => 'capacity', 'data-label' => 'Kapasitas', 'data-value' => null]);
        $column[] = Column::make('is_active')->name('is_active')->title('Status')->attributes(['data-type' => 'select', 'data-name' => 'is_active', 'data-label' => 'Status', 'data-value' => $json]);
        $column[] = Column::make('created_at')->name('created_at')->title('Dibuat')->attributes(['data-type' => 'date', 'data-name' => 'created_at', 'data-label' => 'Dibuat']);
        return $column;
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'ClassRooms_' . date('YmdHis');
    }
}
