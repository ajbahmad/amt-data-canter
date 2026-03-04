<?php

namespace App\DataTables;

use App\DataTables\Config\GlobalConfigDatatable;
use App\Models\SchoolLevel;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SubjectDataTable extends DataTable
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
                $showUrl = route('subjects.show', $row->id);
                $editUrl = route('subjects.edit', $row->id);
                $deleteUrl = route('subjects.destroy', $row->id);
                $data = '
                <div class="flex justify-center items-center gap-2">
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-info text-info hover:bg-info hover:text-white p-0 btn-sm" onclick="window.location.href=\''.$showUrl.'\'" title="Lihat"><i class="ti ti-eye"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-warning text-warning hover:bg-warning hover:text-white p-0 btn-sm" onclick="editData(\''.$row->id.'\', \''.$editUrl.'\')" title="Edit"><i class="ti ti-edit"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white text-error border border-error hover:bg-error hover:text-white p-0 btn-sm" onclick="deleteData(\''.$row->id.'\', \''.$deleteUrl.'\')" title="Hapus"><i class="ti ti-trash"></i></button>
                </div>
                ';
                return $data;
            })
            ->addColumn('school_level_name', function($row){
                return $row->schoolLevel->name ?? '-';
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
            ->orderColumn('code', function($query, $direction) {
                $query->orderBy('code', $direction);
            })
            ->orderColumn('school_level_id', function($query, $direction) {
                $query->orderBy('school_level_id', $direction);
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
            ->filterColumn('code', function($query, $keyword) {
                $query->where('code', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('school_level_name', function($query, $keyword) {
                $query->where('school_level_id', 'ILIKE', "%{$keyword}%");
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
    public function query(Subject $model): QueryBuilder
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

    private function getSchoolLevel()
    {
        $schoolLevels = SchoolLevel::pluck('name', 'id')->toArray();
        $options = [
            ['label'=>'Filter Semua', 'value' => '']
        ];
        foreach ($schoolLevels as $id => $name) {
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
        $column[] = Column::make('name')->name('name')->title('Nama Mata Pelajaran')->attributes(['data-type' => 'text', 'data-name' => 'name', 'data-label' => 'Nama Mata Pelajaran', 'data-value' => null]);
        $column[] = Column::make('code')->name('code')->title('Kode')->attributes(['data-type' => 'text', 'data-name' => 'code', 'data-label' => 'Kode', 'data-value' => null]);
        $column[] = Column::make('school_level_name')->name('school_level_name')->title('Jenjang Sekolah')->attributes(['data-type' => 'select', 'data-name' => 'school_level_name', 'data-label' => 'Jenjang Sekolah', 'data-value' => $this->getSchoolLevel()]);
        $column[] = Column::make('is_active')->name('is_active')->title('Status')->attributes(['data-type' => 'select', 'data-name' => 'is_active', 'data-label' => 'Status', 'data-value' => $json]);
        $column[] = Column::make('created_at')->name('created_at')->title('Dibuat')->attributes(['data-type' => 'date', 'data-name' => 'created_at', 'data-label' => 'Dibuat']);
        return $column;
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'Subjects_' . date('YmdHis');
    }
}
