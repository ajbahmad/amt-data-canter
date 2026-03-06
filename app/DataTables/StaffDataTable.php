<?php

namespace App\DataTables;

use App\DataTables\Config\GlobalConfigDatatable;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StaffDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action','employment_type','status','is_active','created_at'])
            ->addColumn('action', function ($row) {
                $showUrl = route('staffs.show', $row->id);
                $editUrl = route('staffs.edit', $row->id);
                $deleteUrl = route('staffs.destroy', $row->id);
                return '
                <div class="flex justify-center items-center gap-2">
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-info text-info hover:bg-info hover:text-white p-0 btn-sm" onclick="window.location.href=\''.$showUrl.'\'" title="Lihat"><i class="ti ti-eye"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-warning text-warning hover:bg-warning hover:text-white p-0 btn-sm" onclick="editData(\''.$row->id.'\', \''.$editUrl.'\')" title="Edit"><i class="ti ti-edit"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white text-error border border-error hover:bg-error hover:text-white p-0 btn-sm" onclick="deleteData(\''.$row->id.'\', \''.$deleteUrl.'\')" title="Hapus"><i class="ti ti-trash"></i></button>
                </div>
                ';
            })
            ->addColumn('person_name', function ($row) {
                return $row->person ? $row->person->full_name : 'N/A';
            })
            ->addColumn('school_name', function ($row) {
                return $row->schoolInstitution?->name ?? 'N/A';
            })
            ->addColumn('employment_type', function($row){
                $typeLabels = [
                    'permanent' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Tetap</span>',
                    'contract' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Kontrak</span>',
                    'honorary' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Honorer</span>',
                ];
                return $typeLabels[$row->employment_type] ?? '<span>Unknown</span>';
            })
            ->addColumn('status', function($row){
                $statusLabels = [
                    'active' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Aktif</span>',
                    'retired' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">Pensiun</span>',
                    'resigned' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Resign</span>',
                    'on_leave' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">Cuti</span>',
                ];
                return $statusLabels[$row->status] ?? '<span>Unknown</span>';
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
            ->orderColumn('staff_id', function($query, $direction) {
                $query->orderBy('staff_id', $direction);
            })
            ->orderColumn('employment_type', function($query, $direction) {
                $query->orderBy('employment_type', $direction);
            })
            ->orderColumn('status', function($query, $direction) {
                $query->orderBy('status', $direction);
            })
            ->orderColumn('is_active', function($query, $direction) {
                $query->orderBy('is_active', $direction);
            })
            ->orderColumn('created_at', function($query, $direction) {
                $query->orderBy('created_at', $direction);
            })
            ->filterColumn('staff_id', function($query, $keyword) {
                $query->where('staff_id', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('employment_type', function($query, $keyword) {
                if ($keyword) {
                    $query->where('employment_type', $keyword);
                }
            })
            ->filterColumn('status', function($query, $keyword) {
                if ($keyword) {
                    $query->where('status', $keyword);
                }
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

    public function query(Staff $model): QueryBuilder
    {
        return $model->with('person', 'schoolInstitution')->newQuery();
    }

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

    public function getColumns(): array
    {
        $employmentJson = json_encode([
            ['label'=>'Filter Semua', 'value' => ''],
            ['label'=>'Tetap', 'value' => 'permanent'],
            ['label'=>'Kontrak', 'value' => 'contract'],
            ['label'=>'Honorer', 'value' => 'honorary'],
        ]);
        $statusJson = json_encode([
            ['label'=>'Filter Semua', 'value' => ''],
            ['label'=>'Aktif', 'value' => 'active'],
            ['label'=>'Pensiun', 'value' => 'retired'],
            ['label'=>'Resign', 'value' => 'resigned'],
            ['label'=>'Cuti', 'value' => 'on_leave'],
        ]);
        $activeJson = json_encode([
            ['label'=>'Filter Semua', 'value' => ''],
            ['label'=>'Aktif', 'value' => 'true'],
            ['label'=>'Non Aktif', 'value' => 'false'],
        ]);
        
        $column[] = Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')->attributes(['data-type' => 'select', 'data-name' => 'action', 'data-label' => 'Action', 'data-value' => GlobalConfigDatatable::lines()]);
        $column[] = Column::make('person_name')->name('person_id')->title('Nama Staf')->attributes(['data-type' => 'text', 'data-name' => 'person_name', 'data-label' => 'Nama Staf', 'data-value' => null]);
        $column[] = Column::make('staff_id')->name('staff_id')->title('ID Staf')->attributes(['data-type' => 'text', 'data-name' => 'staff_id', 'data-label' => 'ID Staf', 'data-value' => null]);
        $column[] = Column::make('school_name')->name('school_institution_id')->title('Sekolah')->attributes(['data-type' => 'text', 'data-name' => 'school_name', 'data-label' => 'Sekolah', 'data-value' => null]);
        $column[] = Column::make('employment_type')->name('employment_type')->title('Jenis Kerjasama')->attributes(['data-type' => 'select', 'data-name' => 'employment_type', 'data-label' => 'Jenis Kerjasama', 'data-value' => $employmentJson]);
        $column[] = Column::make('status')->name('status')->title('Status')->attributes(['data-type' => 'select', 'data-name' => 'status', 'data-label' => 'Status', 'data-value' => $statusJson]);
        $column[] = Column::make('is_active')->name('is_active')->title('Aktif')->attributes(['data-type' => 'select', 'data-name' => 'is_active', 'data-label' => 'Aktif', 'data-value' => $activeJson]);
        $column[] = Column::make('created_at')->name('created_at')->title('Tanggal Buat')->attributes(['data-type' => 'date', 'data-name' => 'created_at', 'data-label' => 'Tanggal Buat']);
        return $column;
    }

    protected function filename(): string
    {
        return 'Staff_' . date('YmdHis');
    }
}
