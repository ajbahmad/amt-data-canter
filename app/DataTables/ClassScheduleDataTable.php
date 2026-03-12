<?php

namespace App\DataTables;

use App\Models\ClassSchedule;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClassScheduleDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'class_schedules.action')
            ->addColumn('teacher_name', function (ClassSchedule $row) {
                return $row->teacher && $row->teacher->person ? $row->teacher->person->full_name : '-';
            })
            ->addColumn('subject_name', function (ClassSchedule $row) {
                return $row->subject ? $row->subject->name : '-';
            })
            ->addColumn('class_room_name', function (ClassSchedule $row) {
                return $row->classRoom ? $row->classRoom->name : '-';
            })
            ->addColumn('school_level_name', function (ClassSchedule $row) {
                return $row->schoolLevel ? $row->schoolLevel->name : '-';
            })
            ->addColumn('time_range', function (ClassSchedule $row) {
                $start = $row->startTimeSlot ? $row->startTimeSlot->start_time : '-';
                $end = $row->endTimeSlot ? $row->endTimeSlot->end_time : '-';
                return $start . ' - ' . $end;
            })
            ->addColumn('day_name', function (ClassSchedule $row) {
                return $row->day_name;
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ClassSchedule $model): QueryBuilder
    {
        return $model->withoutGlobalScope('is_active')->newQuery()
            ->with([
                'schoolInstitution',
                'schoolLevel',
                'classRoom',
                'teacher.person',
                'subject',
                'startTimeSlot',
                'endTimeSlot',
                'semester'
            ]);
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('class_schedules-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(2, 'asc')
            ->selectStyleSingle()
            ->buttons([
                Button::make('create'),
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ])
            ->parameters([
                'stateSave' => true,
                'stateDuration' => 3600,
            ]);
    }

    /**
     * Get columns.
     */
    public function getColumns(): array
    {
        return [
            Column::make('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
            Column::make('teacher_name')
                ->title('Guru')
                ->addClass('text-center'),
            Column::make('subject_name')
                ->title('Mapel')
                ->addClass('text-center'),
            Column::make('school_level_name')
                ->title('Tingkat')
                ->addClass('text-center'),
            Column::make('class_room_name')
                ->title('Kelas')
                ->addClass('text-center'),
            Column::make('time_range')
                ->title('Jam')
                ->addClass('text-center'),
            Column::make('day_name')
                ->title('Hari')
                ->addClass('text-center'),
            Column::make('created_at')
                ->title('Dibuat')
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'ClassSchedule_' . date('YmdHis');
    }
}
