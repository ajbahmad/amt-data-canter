<?php

namespace App\DataTables;

use App\DataTables\Config\GlobalConfigDatatable;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StudentDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action','person_name','status','is_active','created_at'])
            ->addColumn('action', function ($row) {
                $showUrl = route('students.show', $row->id);
                $editUrl = route('students.edit', $row->id);
                $deleteUrl = route('students.destroy', $row->id);
                return '
                <div class="flex justify-center items-center gap-2">
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-info text-info hover:bg-info hover:text-white p-0 btn-sm" onclick="window.location.href=\''.$showUrl.'\'" title="Lihat"><i class="ti ti-eye"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-warning text-warning hover:bg-warning hover:text-white p-0 btn-sm" onclick="editData(\''.$row->id.'\', \''.$editUrl.'\')" title="Edit"><i class="ti ti-edit"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white text-error border border-error hover:bg-error hover:text-white p-0 btn-sm" onclick="deleteData(\''.$row->id.'\', \''.$deleteUrl.'\')" title="Hapus"><i class="ti ti-trash"></i></button>
                </div>
                ';
            })
            ->addColumn('school_institution_id', function($row) {
                return $row->schoolInstitution ? $row->schoolInstitution->name : 'N/A';
            })
            ->addColumn('person_name', function ($row) {
                if ($row->person->photo) {
                    $urlPhoto = '<img src="'.asset('storage/'.$row->person->photo).'" alt="'.$row->person->full_name.'" class="w-10 h-10 rounded-full object-cover">';
                } else {
                    $urlPhoto = '<img src="https://ui-avatars.com/api/?name='.urlencode($row->person->full_name).'" alt="'.$row->person->full_name.'" class="w-10 h-10 rounded-full object-cover">';
                }
                return '
                <div class="flex items-center gap-2">
                    '.$urlPhoto.'
                    <div>
                        <div class="font-medium text-gray-900">'. $row->person->full_name .'</div>
                        <div class="text-sm text-gray-500">'. $row->person->email .'</div>
                    </div>
                </div>';
                return $row->schoolInstitution ? $row->schoolInstitution->name : 'N/A';
            })
            ->addColumn('status', function($row){
                $statusLabels = [
                    'active' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200"><i class="ti ti-circle-check mr-1"></i>Aktif</span>',
                    'graduated' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200"><i class="ti ti-circle-check mr-1"></i>Lulus</span>',
                    'dropped_out' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200"><i class="ti ti-circle-x mr-1"></i>Keluar</span>',
                    'suspended' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200"><i class="ti ti-circle-x mr-1"></i>Suspend</span>',
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
            ->orderColumn('school_institution_id', function($query, $direction) {
                $query->orderBy('school_institution_id', $direction);
            })
            ->orderColumn('student_id', function($query, $direction) {
                $query->orderBy('student_id', $direction);
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
            
            ->filterColumn('school_institution_id', function($query, $keyword) {
                $query->where('school_institution_id', $keyword);
            })
            ->filterColumn('student_id', function($query, $keyword) {
                $query->where('student_id', 'ILIKE', "%{$keyword}%");
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

    public function query(Student $model): QueryBuilder
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
        $statusJson = json_encode([
            ['label'=>'Filter Semua', 'value' => ''],
            ['label'=>'Aktif', 'value' => 'active'],
            ['label'=>'Lulus', 'value' => 'graduated'],
            ['label'=>'Keluar', 'value' => 'dropped_out'],
            ['label'=>'Suspend', 'value' => 'suspended'],
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
        $column[] = Column::make('school_institution_id')->name('school_institution_id')->title('Lembaga')->attributes(['data-type' => 'select', 'data-name' => 'school_institution_id', 'data-label' => 'Lembaga', 'data-value' => GlobalConfigDatatable::getSchoolInstitutions()]);
        $column[] = Column::make('person_name')->name('person_id')->title('Nama Siswa')->attributes(['data-type' => 'text', 'data-name' => 'person_name', 'data-label' => 'Nama Siswa', 'data-value' => null]);
        $column[] = Column::make('student_id')->name('student_id')->title('NIS')->attributes(['data-type' => 'text', 'data-name' => 'student_id', 'data-label' => 'NIS', 'data-value' => null]);
        $column[] = Column::make('status')->name('status')->title('Status')->attributes(['data-type' => 'select', 'data-name' => 'status', 'data-label' => 'Status', 'data-value' => $statusJson]);
        $column[] = Column::make('is_active')->name('is_active')->title('Aktif')->attributes(['data-type' => 'select', 'data-name' => 'is_active', 'data-label' => 'Aktif', 'data-value' => $activeJson]);
        $column[] = Column::make('created_at')->name('created_at')->title('Tanggal Buat')->attributes(['data-type' => 'date', 'data-name' => 'created_at', 'data-label' => 'Tanggal Buat']);
        return $column;
    }

    protected function filename(): string
    {
        return 'Student_' . date('YmdHis');
    }
}
