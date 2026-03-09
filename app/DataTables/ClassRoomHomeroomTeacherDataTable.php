<?php

namespace App\DataTables;

use App\DataTables\Config\GlobalConfigDatatable;
use App\Models\ClassRoom;
use App\Models\ClassRoomHomeroomTeacher;
use App\Models\SchoolInstitution;
use App\Models\SchoolLevel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ClassRoomHomeroomTeacherDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action', 'is_active', 'assigned_at'])
            ->addColumn('action', function ($row) {
                $showUrl = route('class_room_homeroom_teachers.show', $row->id);
                $editUrl = route('class_room_homeroom_teachers.edit', $row->id);
                $deleteUrl = route('class_room_homeroom_teachers.destroy', $row->id);
                return '
                <div class="flex justify-center items-center gap-2">
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-info text-info hover:bg-info hover:text-white p-0 btn-sm" onclick="window.location.href=\''.$showUrl.'\'" title="Lihat"><i class="ti ti-eye"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-warning text-warning hover:bg-warning hover:text-white p-0 btn-sm" onclick="editData(\''.$row->id.'\', \''.$editUrl.'\')" title="Edit"><i class="ti ti-edit"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white text-error border border-error hover:bg-error hover:text-white p-0 btn-sm" onclick="deleteData(\''.$row->id.'\', \''.$deleteUrl.'\')" title="Hapus"><i class="ti ti-trash"></i></button>
                </div>
                ';
            })
            ->addColumn('school_institution_id', function($row){
                return $row->classRoom->schoolInstitution->name ?? '-';
            })
            ->addColumn('school_level_id', function($row){
                return $row->classRoom->schoolLevel->name ?? '-';
            })
            ->addColumn('class_room_id', function ($row) {
                return $row->classRoom ? $row->classRoom->name : 'N/A';
            })
            ->addColumn('teacher_name', function ($row) {
                return $row->teacher ? ($row->teacher->person ? $row->teacher->person->full_name : 'N/A') : 'N/A';
            })
            ->addColumn('is_active', function($row){
                return $row->is_active ? '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            <i class="ti ti-circle-check mr-2"></i>Aktif
                        </span>' : '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            <i class="ti ti-circle-x mr-2"></i>Tidak Aktif
                        </span>';
            })
            ->addColumn('assigned_at', function($row){
                return $row->assigned_at ? date('d M Y', strtotime($row->assigned_at)) : 'N/A';
            })
            
            // ✅ Kolom yang bisa diurut
            ->filterColumn('school_institution_id', function($query, $keyword) {
                $query->whereHas('classRoom.schoolInstitution', function($q) use ($keyword) {
                    $q->where('id', $keyword);
                });
            })
            ->filterColumn('school_level_id', function($query, $keyword) {
                $query->whereHas('classRoom.schoolLevel', function($q) use ($keyword) {
                    $q->where('id', $keyword);
                });
            })
            ->orderColumn('class_room_id', function($query, $direction) {
                $query->orderBy('class_room_id', $direction);
            })
            ->orderColumn('teacher_name', function($query, $direction) {
                $query->orderBy('teacher_id', $direction);
            })
            ->orderColumn('is_active', function($query, $direction) {
                $query->orderBy('is_active', $direction);
            })
            ->orderColumn('assigned_at', function($query, $direction) {
                $query->orderBy('assigned_at', $direction);
            })
            
            // ✅ Kolom yang bisa di-filter
            ->orderColumn('school_institution_id', function($query, $direction) {
                $query->orderBy('class_room_id', $direction);
            })
            ->orderColumn('school_level_id', function($query, $direction) {
                $query->orderBy('class_room_id', $direction);
            })
            ->filterColumn('class_room_id', function($query, $keyword) {
                $query->where('class_room_id', $keyword);
            })
            ->filterColumn('teacher_name', function($query, $keyword) {
                $query->whereHas('teacher.person', function($q) use ($keyword) {
                    $q->where('full_name', 'ILIKE', "%{$keyword}%");
                });
            })
            ->filterColumn('is_active', function($query, $keyword) {
                if ($keyword !== '') {
                    $isActive = strtolower($keyword) === 'true' ? true : (strtolower($keyword) === 'false' ? false : null);
                    if ($isActive !== null) {
                        $query->where('is_active', $isActive);
                    }
                }
            })
            
            ->setRowId('id');
    }

    public function query(ClassRoomHomeroomTeacher $model): QueryBuilder
    {
        return $model->newQuery()->with(['classRoom', 'teacher.person']);
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

    private function getClassRooms()
    {
        $classRooms = ClassRoom::where('is_active', true)->get();
        $options = [['label' => 'Filter Semua', 'value' => '']];
        foreach ($classRooms as $classRoom) {
            $options[] = ['label' => $classRoom->name, 'value' => $classRoom->id];
        }
        return json_encode($options);
    }

    public function getColumns(): array
    {
        $json = json_encode([
            ['label'=>'Filter Semua', 'value' => ''],
            ['label'=>'Aktif', 'value' => 'true'],
            ['label'=>'Tidak Aktif', 'value' => 'false'],
        ]);
        $column[] = Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(80)
                ->addClass('text-center')->attributes(['data-type' => 'select', 'data-name' => 'action', 'data-label' => 'Action', 'data-value' => GlobalConfigDatatable::lines()]);
        $column[] = Column::make('school_institution_id')->name('school_institution_id')->title('Sekolah')->attributes(['data-type' => 'select', 'data-name' => 'school_institution_id', 'data-label' => 'Sekolah', 'data-value' => $this->getSchoolInstitution()]);
        $column[] = Column::make('school_level_id')->name('school_level_id')->title('Jenjang Sekolah')->attributes(['data-type' => 'select', 'data-name' => 'school_level_id', 'data-label' => 'Jenjang Sekolah', 'data-value' => $this->getSchoolLevel()]);
        $column[] = Column::make('class_room_id')->name('class_room_id')->title('Kelas')->attributes(['data-type' => 'select', 'data-name' => 'class_room_id', 'data-label' => 'Kelas', 'data-value' => $this->getClassRooms()]);
        $column[] = Column::make('teacher_name')->name('teacher_name')->title('Nama Guru')->attributes(['data-type' => 'text', 'data-name' => 'teacher_name', 'data-label' => 'Nama Guru', 'data-value' => null]);
        $column[] = Column::make('is_active')->name('is_active')->title('Status')->attributes(['data-type' => 'select', 'data-name' => 'is_active', 'data-label' => 'Status', 'data-value' => $json]);
        $column[] = Column::make('assigned_at')->name('assigned_at')->title('Penugasan')->attributes(['data-type' => 'date', 'data-name' => 'assigned_at', 'data-label' => 'Penugasan']);
        return $column;
    }

    protected function filename(): string
    {
        return 'ClassRoomHomeroomTeacher_' . date('YmdHis');
    }
}
