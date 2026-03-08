<?php

namespace App\DataTables;

use App\DataTables\Config\GlobalConfigDatatable;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PersonDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action', 'full_name', 'tetala', 'is_active','created_at'])
            ->addColumn('action', function ($row) {
                $showUrl = route('persons.show', $row->id);
                $editUrl = route('persons.edit', $row->id);
                $deleteUrl = route('persons.destroy', $row->id);
                return '
                <div class="flex justify-center items-center gap-2">
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-info text-info hover:bg-info hover:text-white p-0 btn-sm" onclick="window.location.href=\''.$showUrl.'\'" title="Lihat"><i class="ti ti-eye"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-warning text-warning hover:bg-warning hover:text-white p-0 btn-sm" onclick="editData(\''.$row->id.'\', \''.$editUrl.'\')" title="Edit"><i class="ti ti-edit"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white text-error border border-error hover:bg-error hover:text-white p-0 btn-sm" onclick="deleteData(\''.$row->id.'\', \''.$deleteUrl.'\')" title="Hapus"><i class="ti ti-trash"></i></button>
                </div>
                ';
            })
            ->addColumn('full_name', function ($row) {
                if ($row->photo) {
                    $urlPhoto = '<img src="'.asset('storage/'.$row->photo).'" alt="'.$row->full_name.'" class="w-10 h-10 rounded-full object-cover">';
                } else {
                    $urlPhoto = '<img src="https://ui-avatars.com/api/?name='.urlencode($row->full_name).'" alt="'.$row->full_name.'" class="w-10 h-10 rounded-full object-cover">';
                }
                return '
                <div class="flex items-center gap-2">
                    '.$urlPhoto.'
                    <div>
                        <div class="font-medium text-gray-900">'. $row->full_name .'</div>
                        <div class="text-sm text-gray-500">'. $row->email .'</div>
                    </div>
                </div>
                ';
            })
            ->addColumn('tetala', function($row){
                return $row->birth_place. ', '.Carbon::parse($row->birth_date)->translatedFormat('d F Y');
            })
            ->addColumn('gender', function ($row){
                return $row->gender == 'male' ? 'Laki - Laki' : 'Perempuan';
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
            ->orderColumn('full_name', function($query, $direction) {
                $query->orderBy('first_name', $direction);
            })
            ->orderColumn('tetala', function($query, $direction){
                $query->orderBy('birth_date', $direction);
            })
            ->orderColumn('email', function($query, $direction) {
                $query->orderBy('email', $direction);
            })
            ->orderColumn('phone', function($query, $direction) {
                $query->orderBy('phone', $direction);
            })
            ->orderColumn('gender', function($query, $direction) {
                $query->orderBy('gender', $direction);
            })
            ->orderColumn('is_active', function($query, $direction) {
                $query->orderBy('is_active', $direction);
            })
            ->orderColumn('created_at', function($query, $direction) {
                $query->orderBy('created_at', $direction);
            })
            ->filterColumn('full_name', function($query, $keyword) {
                $query->where(function($query) use ($keyword) {
                    $query->where('first_name', 'ILIKE', "%{$keyword}%")
                          ->orWhere('last_name', 'ILIKE', "%{$keyword}%")
                          ->orWhere('email', 'ILIKE', "%{$keyword}%");
                });
            })
            ->filterColumn('last_name', function($query, $keyword) {
                $query->where('last_name', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('tetala', function($query, $keyword){
                $query->where(function($query) use ($keyword) {
                    $query->where('birth_place', 'ILIKE', "%{$keyword}%")
                          ->orWhere('birth_date', 'ILIKE', "%{$keyword}%");
                });
            })
            ->filterColumn('email', function($query, $keyword) {
                $query->where('email', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('phone', function($query, $keyword) {
                $query->where('phone', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('gender', function($query, $keyword) {
                $query->where('gender', $keyword);
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

    public function query(Person $model): QueryBuilder
    {
        return $model->newQuery();
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
        $statusJson = json_encode([
            ['label'=>'Filter Semua', 'value' => ''],
            ['label'=>'Aktif', 'value' => 'true'],
            ['label'=>'Non Aktif', 'value' => 'false'],
        ]);
        $genderJson = json_encode([
            ['label'=>'Filter Semua', 'value' => ''],
            ['label'=>'Laki-laki', 'value' => 'male'],
            ['label'=>'Perempuan', 'value' => 'female'],
        ]);
        
        $column[] = Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')->attributes(['data-type' => 'select', 'data-name' => 'action', 'data-label' => 'Action', 'data-value' => GlobalConfigDatatable::lines()]);
        $column[] = Column::make('full_name')->name('first_name')->title('Nama Lengkap')->attributes(['data-type' => 'text', 'data-name' => 'full_name', 'data-label' => 'Nama Lengkap', 'data-value' => null]);
        $column[] = Column::make('phone')->name('phone')->title('Telepon')->attributes(['data-type' => 'text', 'data-name' => 'phone', 'data-label' => 'Telepon', 'data-value' => null]);
        $column[] = Column::make('tetala')->name('tetala')->title('Tetala')->attributes(['data-type' => 'text', 'data-name' => 'tetala', 'data-label' => 'Tetala', 'data-value' => null]);
        $column[] = Column::make('gender')->name('gender')->title('Jenis Kelamin')->attributes(['data-type' => 'select', 'data-name' => 'gender', 'data-label' => 'Jenis Kelamin', 'data-value' => $genderJson]);
        $column[] = Column::make('is_active')->name('is_active')->title('Status')->attributes(['data-type' => 'select', 'data-name' => 'is_active', 'data-label' => 'Status', 'data-value' => $statusJson]);
        $column[] = Column::make('created_at')->name('created_at')->title('Tanggal Buat')->attributes(['data-type' => 'date', 'data-name' => 'created_at', 'data-label' => 'Tanggal Buat']);
        return $column;
    }

    protected function filename(): string
    {
        return 'Person_' . date('YmdHis');
    }
}
