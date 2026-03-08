<?php

namespace App\DataTables;

use App\DataTables\Config\GlobalConfigDatatable;
use App\Models\SchoolDaySchedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SchoolDayScheduleDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action', 'start_time', 'end_time', 'is_holiday', 'created_at'])
            ->addColumn('action', function ($row) {
                $editUrl = route('school-day-schedules.edit', $row->id);
                $data = '
                <div class="flex justify-center items-center gap-2">
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-warning text-warning hover:bg-warning hover:text-white p-0 btn-sm" onclick="editData(\''.$row->id.'\', \''.$editUrl.'\')" title="Edit"><i class="ti ti-edit"></i></button>
                </div>
                ';
                return $data;
            })
            ->addColumn('schedule_pattern_name', function($row){
                return $row->schedulePattern->name ?? '-';
            })
            ->addColumn('school_institution_name', function($row){
                return $row->schoolInstitution->name ?? '-';
            })
            ->addColumn('school_level_name', function($row){
                return $row->schoolLevel->name ?? '-';
            })
            ->addColumn('day_of_week', function($row){
                $dayMap = [
                    0 => 'senin',
                    1 => 'selasa',
                    2 => 'rabu',
                    3 => 'kamis',
                    4 => 'jumat',
                    5 => 'sabtu',
                    6 => 'minggu',
                ];
                return $dayMap[$row->day_of_week];
            })
            ->addColumn('start_time', function($row){
                if ($row->is_holiday) {
                    return '-- : --';
                }
                return (Carbon::parse($row->start_time)->format('H:i') ?? '-') ;
            })
            ->addColumn('end_time', function($row){
                if ($row->is_holiday) {
                    return '-- : --';
                }
                return (Carbon::parse($row->end_time)->format('H:i') ?? '-');
            })
            ->addColumn('is_holiday', function($row){
                return $row->is_holiday ? '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            <i class="ti ti-circle-check mr-2"></i>Libur
                        </span>' : 'Hari Aktif';
            })
            ->addColumn('created_at', function ($row) {
                Carbon::setLocale('id');
                return Carbon::parse($row->created_at)->translatedFormat('d F Y');
            })

            // ✅ Kolom yang bisa diurut
            ->orderColumn('day_of_week', function($query, $direction) {
                $query->orderBy('day_of_week', $direction);
            })
            ->orderColumn('schedule_pattern_name', function($query, $direction) {
                $query->orderBy('schedule_pattern_id', $direction);
            })
            ->orderColumn('school_institution_name', function($query, $direction) {
                $query->orderBy('school_institution_id', $direction);
            })
            ->orderColumn('school_level_name', function($query, $direction) {
                $query->orderBy('school_level_id', $direction);
            })
            ->orderColumn('start_time', function($query, $direction) {
                $query->orderBy('start_time', $direction);
            })
            ->orderColumn('end_time', function($query, $direction) {
                $query->orderBy('end_time', $direction);
            })
            ->orderColumn('is_holiday', function($query, $direction) {
                $query->orderBy('is_holiday', $direction);
            })
            ->orderColumn('created_at', function($query, $direction) {
                $query->orderBy('created_at', $direction);
            })

            // filterable
            ->filterColumn('day_of_week', function($query, $keyword) {
                $query->where('day_of_week', $keyword);
            })
            ->filterColumn('schedule_pattern_name', function($query, $keyword) {
                $query->where('schedule_pattern_id', $keyword);
            })
            ->filterColumn('school_institution_name', function($query, $keyword) {
                $query->where('school_institution_id', $keyword);
            })
            ->filterColumn('school_level_name', function($query, $keyword) {
                $query->where('school_level_id', $keyword);
            })
            ->filterColumn('is_holiday', function($query, $keyword) {
                if ($keyword !== '') {
                    $isHoliday = strtolower($keyword) === 'true' || strtolower($keyword) === 'ya' ? true : (strtolower($keyword) === 'false' || strtolower($keyword) === 'tidak' ? false : null);
                    if ($isHoliday !== null) {
                        $query->where('is_holiday', $isHoliday);
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
    public function query(SchoolDaySchedule $model): QueryBuilder
    {
        return $model->newQuery()->with(['schedulePattern', 'schoolInstitution', 'schoolLevel']);
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

    private function getSchedulePatterns()
    {
        $patterns = \App\Models\SchedulePattern::all();
        $options = [
            ['label'=>'Filter Semua', 'value' => '']
        ];
        foreach ($patterns as $pattern) {
            $options[] = ['label' => $pattern->name, 'value' => $pattern->id];
        }
        return json_encode($options);
    }

    private function getSchoolInstitutions()
    {
        $institutions = \App\Models\SchoolInstitution::where('is_active', true)->get();
        $options = [
            ['label'=>'Filter Semua', 'value' => '']
        ];
        foreach ($institutions as $inst) {
            $options[] = ['label' => $inst->name, 'value' => $inst->id];
        }
        return json_encode($options);
    }

    private function getSchoolLevels()
    {
        $levels = \App\Models\SchoolLevel::where('is_active', true)->get();
        $options = [
            ['label'=>'Filter Semua', 'value' => '']
        ];
        foreach ($levels as $level) {
            $options[] = ['label' => $level->name, 'value' => $level->id];
        }
        return json_encode($options);
    }

    private function getDaysOfWeek() {
        $dayJson = json_encode([
            ['label'=>'Filter Semua', 'value' => ''],
            ['label'=>'Senin', 'value' => '0'],
            ['label'=>'Selasa', 'value' => '1'],
            ['label'=>'Rabu', 'value' => '2'],
            ['label'=>'Kamis', 'value' => '3'],
            ['label'=>'Jumat', 'value' => '4'],
            ['label'=>'Sabtu', 'value' => '5'],
            ['label'=>'Minggu', 'value' => '6'],
        ]);
        return $dayJson;
    }
    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $holidayJson = json_encode([
            ['label'=>'Filter Semua', 'value' => ''],
            ['label'=>'Ya', 'value' => 'true'],
            ['label'=>'Tidak', 'value' => 'false'],
        ]);

        $column[] = Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')->attributes(['data-type' => 'select', 'data-name' => 'action', 'data-label' => 'Action', 'data-value' => GlobalConfigDatatable::lines()]);
        $column[] = Column::make('day_of_week')->name('day_of_week')->title('Hari')->attributes(['data-type' => 'select', 'data-name' => 'day_of_week', 'data-label' => 'Hari', 'data-value' => $this->getDaysOfWeek()]);
        $column[] = Column::make('schedule_pattern_name')->name('schedule_pattern_name')->title('Pola Jadwal')->attributes(['data-type' => 'select', 'data-name' => 'schedule_pattern_name', 'data-label' => 'Pola Jadwal', 'data-value' => $this->getSchedulePatterns()]);
        $column[] = Column::make('school_institution_name')->name('school_institution_name')->title('Institusi')->attributes(['data-type' => 'select', 'data-name' => 'school_institution_name', 'data-label' => 'Institusi', 'data-value' => $this->getSchoolInstitutions()]);
        $column[] = Column::make('school_level_name')->name('school_level_name')->title('Level')->attributes(['data-type' => 'select', 'data-name' => 'school_level_name', 'data-label' => 'Level', 'data-value' => $this->getSchoolLevels()]);
        $column[] = Column::make('start_time')->name('start_time')->title('Jam Masuk')->searchable(false)->attributes(['data-type' => 'text', 'data-name' => 'start_time', 'data-label' => 'Jam Masuk', 'data-value' => null]);
        $column[] = Column::make('end_time')->name('end_time')->title('Jam Selesai')->searchable(false)->attributes(['data-type' => 'text', 'data-name' => 'end_time', 'data-label' => 'Jam Selesai', 'data-value' => null]);
        $column[] = Column::make('is_holiday')->name('is_holiday')->title('Status')->attributes(['data-type' => 'select', 'data-name' => 'is_holiday', 'data-label' => 'Status Libur', 'data-value' => $holidayJson]);
        $column[] = Column::make('created_at')->name('created_at')->title('Dibuat')->attributes(['data-type' => 'date', 'data-name' => 'created_at', 'data-label' => 'Dibuat']);
        return $column;
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'SchoolDaySchedules_' . date('YmdHis');
    }
}
