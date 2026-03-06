<?php

namespace App\DataTables;

use App\DataTables\Config\GlobalConfigDatatable;
use App\Models\ClassRoom;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherSubjectAssignment;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TeacherSubjectAssignmentDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action', 'is_active', 'assigned_at'])
            ->addColumn('action', function ($row) {
                $showUrl = route('teacher_subject_assignments.show', $row->id);
                $editUrl = route('teacher_subject_assignments.edit', $row->id);
                $deleteUrl = route('teacher_subject_assignments.destroy', $row->id);
                return '
                <div class="flex justify-center items-center gap-2">
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-info text-info hover:bg-info hover:text-white p-0 btn-sm" onclick="window.location.href=\''.$showUrl.'\'" title="Lihat"><i class="ti ti-eye"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-warning text-warning hover:bg-warning hover:text-white p-0 btn-sm" onclick="editData(\''.$row->id.'\', \''.$editUrl.'\')" title="Edit"><i class="ti ti-edit"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white text-error border border-error hover:bg-error hover:text-white p-0 btn-sm" onclick="deleteData(\''.$row->id.'\', \''.$deleteUrl.'\')" title="Hapus"><i class="ti ti-trash"></i></button>
                </div>
                ';
            })
            ->addColumn('teacher_name', function ($row) {
                return $row->teacher && $row->teacher->person ? $row->teacher->person->full_name : 'N/A';
            })
            ->addColumn('subject_name', function ($row) {
                return $row->subject ? $row->subject->name : 'N/A';
            })
            ->addColumn('class_room_name', function ($row) {
                return $row->classRoom ? $row->classRoom->name : 'N/A';
            })
            ->addColumn('semester_name', function ($row) {
                return $row->semester ? $row->semester->name : 'N/A';
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
            ->orderColumn('teacher_name', function($query, $direction) {
                $query->orderBy('teacher_id', $direction);
            })
            ->orderColumn('subject_name', function($query, $direction) {
                $query->orderBy('subject_id', $direction);
            })
            ->orderColumn('class_room_name', function($query, $direction) {
                $query->orderBy('class_room_id', $direction);
            })
            ->orderColumn('semester_name', function($query, $direction) {
                $query->orderBy('semester_id', $direction);
            })
            ->orderColumn('is_active', function($query, $direction) {
                $query->orderBy('is_active', $direction);
            })
            ->orderColumn('assigned_at', function($query, $direction) {
                $query->orderBy('assigned_at', $direction);
            })
            
            // ✅ Kolom yang bisa di-filter
            ->filterColumn('teacher_name', function($query, $keyword) {
                $query->where('teacher_id', $keyword);
            })
            ->filterColumn('subject_name', function($query, $keyword) {
                $query->where('subject_id', $keyword);
            })
            ->filterColumn('class_room_name', function($query, $keyword) {
                $query->where('class_room_id', $keyword);
            })
            ->filterColumn('semester_name', function($query, $keyword) {
                $query->where('semester_id', $keyword);
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

    public function query(TeacherSubjectAssignment $model): QueryBuilder
    {
        return $model->newQuery()->with(['teacher.person', 'subject', 'classRoom', 'semester']);
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

    private function getTeachers(){
        $teachers = Teacher::where('is_active', true)->get();
        $options[] = ['label' => 'Filter Semua', 'value' => ''];
        foreach ($teachers as $teacher) {
            $mapel = ($teacher->teacherSubjectAssignments->first()) ? ' | '.$teacher->teacherSubjectAssignments->first()->subject->code : '';
            $options[] = ['label' => $teacher->teacher_id . $mapel. ' | ' . $teacher->person->full_name, 'value' => $teacher->id];
        }
        return json_encode($options);
    }

    private function getSubjects()
    {
        $subjects = Subject::where('is_active', true)->get();
        $options[] = ['label' => 'Filter Semua', 'value' => ''];
        foreach ($subjects as $subject) {
            $options[] = ['label' => $subject->code . ' | ' . $subject->name, 'value' => $subject->id];
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

    private function getSemesters()
    {
        $semesters = Semester::where('is_active', true)->get();
        $options = [['label' => 'Filter Semua', 'value' => '']];
        foreach ($semesters as $semester) {
            $options[] = ['label' => $semester->name, 'value' => $semester->id];
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
        $column[] = Column::make('teacher_name')->name('teacher_name')->title('Guru')->attributes(['data-type' => 'select', 'data-name' => 'teacher_name', 'data-label' => 'Guru', 'data-value' => $this->getTeachers()]);
        $column[] = Column::make('subject_name')->name('subject_name')->title('Mata Pelajaran')->attributes(['data-type' => 'select', 'data-name' => 'subject_name', 'data-label' => 'Mata Pelajaran', 'data-value' => $this->getSubjects()]);
        $column[] = Column::make('class_room_name')->name('class_room_name')->title('Kelas')->attributes(['data-type' => 'select', 'data-name' => 'class_room_name', 'data-label' => 'Kelas', 'data-value' => $this->getClassRooms()]);
        $column[] = Column::make('semester_name')->name('semester_name')->title('Semester')->attributes(['data-type' => 'select', 'data-name' => 'semester_name', 'data-label' => 'Semester', 'data-value' => $this->getSemesters()]);
        $column[] = Column::make('is_active')->name('is_active')->title('Status')->attributes(['data-type' => 'select', 'data-name' => 'is_active', 'data-label' => 'Status', 'data-value' => $json]);
        $column[] = Column::make('assigned_at')->name('assigned_at')->title('Penugasan')->attributes(['data-type' => 'date', 'data-name' => 'assigned_at', 'data-label' => 'Penugasan']);
        return $column;
    }

    protected function filename(): string
    {
        return 'TeacherSubjectAssignment_' . date('YmdHis');
    }
}
