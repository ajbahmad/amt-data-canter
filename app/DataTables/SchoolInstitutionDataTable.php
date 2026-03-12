<?php

namespace App\DataTables;

use App\DataTables\Config\GlobalConfigDatatable;
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

class SchoolInstitutionDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        // $query = $this->modelSiswa->where('status', 'aktif')->get();
        return (new EloquentDataTable($query))
            ->rawColumns(['action','is_active','created_at'])
            ->addColumn('action', function ($row) {
                $showUrl = route('school_institutions.show', $row->id);
                $editUrl = route('school_institutions.edit', $row->id);
                $deleteUrl = route('school_institutions.destroy', $row->id);
                $data = '
                <div class="flex justify-center items-center gap-2">
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-info text-info hover:bg-info hover:text-white p-0 btn-sm" onclick="window.location.href=\''.$showUrl.'\'" title="Lihat"><i class="ti ti-eye"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-warning text-warning hover:bg-warning hover:text-white p-0 btn-sm" onclick="editData(\''.$row->id.'\', \''.$editUrl.'\')" title="Edit"><i class="ti ti-edit"></i></button>
                </div>
                ';
                return $data;
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
            ->orderColumn('code', function($query, $direction) {
                $query->orderBy('code', $direction);
            })
            ->orderColumn('name', function($query, $direction) {
                $query->orderBy('name', $direction);
            })
            ->orderColumn('npsn', function($query, $direction) {
                $query->orderBy('npsn', $direction);
            })
            ->orderColumn('address', function($query, $direction) {
                $query->orderBy('address', $direction);
            })
            ->orderColumn('phone', function($query, $direction) {
                $query->orderBy('phone', $direction);
            })
            ->orderColumn('email', function($query, $direction) {
                $query->orderBy('email', $direction);
            })
            ->orderColumn('is_active', function($query, $direction) {
                $query->orderBy('is_active', $direction);
            })
            ->orderColumn('created_at', function($query, $direction) {
                $query->orderBy('created_at', $direction);
            })

            // filterable
            ->filterColumn('code', function($query, $keyword) {
                $query->where('code', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('name', function($query, $keyword) {
                $query->where('name', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('npsn', function($query, $keyword) {
                $query->where('npsn', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('address', function($query, $keyword) {
                $query->where('address', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('phone', function($query, $keyword) {
                $query->where('phone', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('email', function($query, $keyword) {
                $query->where('email', 'ILIKE', "%{$keyword}%");
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
    public function query(SchoolInstitution $model): QueryBuilder
    {
        return $model->withoutGlobalScope('is_active')->newQuery();
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
        $column[] = Column::make('code')->name('code')->title('Kode')->attributes(['data-type' => 'text', 'data-name' => 'code', 'data-label' => 'Kode', 'data-value' => null]);
        $column[] = Column::make('name')->name('name')->title('Nama Lembaga')->attributes(['data-type' => 'text', 'data-name' => 'name', 'data-label' => 'Nama Lembaga', 'data-value' => null]);
        $column[] = Column::make('npsn')->name('npsn')->title('NPSN')->attributes(['data-type' => 'text', 'data-name' => 'npsn', 'data-label' => 'NPSN', 'data-value' => null]);
        $column[] = Column::make('address')->name('address')->title('Alamat')->attributes(['data-type' => 'text', 'data-name' => 'address', 'data-label' => 'Alamat', 'data-value' => null]);
        $column[] = Column::make('phone')->name('phone')->title('Telepon')->attributes(['data-type' => 'text', 'data-name' => 'phone', 'data-label' => 'Telepon', 'data-value' => null]);
        $column[] = Column::make('email')->name('email')->title('Email')->attributes(['data-type' => 'text', 'data-name' => 'email', 'data-label' => 'Email', 'data-value' => null]);
        $column[] = Column::make('is_active')->name('is_active')->title('Status')->attributes(['data-type' => 'select', 'data-name' => 'is_active', 'data-label' => 'Status', 'data-value' => $json]);
        $column[] = Column::make('created_at')->name('created_at')->title('Tanggal Buat')->attributes(['data-type' => 'date', 'data-name' => 'created_at', 'data-label' => 'Tanggal Buat']);
        return $column;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SchoolInstitution_' . date('YmdHis');
    }
}
