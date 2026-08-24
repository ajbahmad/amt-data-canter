<?php

namespace App\Http\Controllers;

use App\DataTables\SchoolDayScheduleDataTable;
use App\Http\Requests\SchoolDayScheduleRequest;
use App\Models\SchoolDaySchedule;
use App\Services\SchedulePatternService;
use Illuminate\Http\Request;

class SchoolDayScheduleController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new SchedulePatternService();
    }

    /**
     * Display a listing of school day schedules.
     */
    public function index(SchoolDayScheduleDataTable $dataTable)
    {
        return $dataTable->render('pages.school-day-schedules.index');
    }

    /**
     * Show the specified school day schedule.
     */
    public function show(SchoolDaySchedule $schedule)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'data' => [
                    'id' => $schedule->id,
                    'day_name' => $schedule->day_name,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'is_holiday' => $schedule->is_holiday,
                    'schedule_pattern' => $schedule->schedulePattern ? $schedule->schedulePattern->name : null,
                    'institution' => $schedule->schoolInstitution ? $schedule->schoolInstitution->name : null,
                    'level' => $schedule->schoolLevel ? $schedule->schoolLevel->name : null,
                ]
            ]);
        }
        
        return view('pages.school-day-schedules.show', [
            'schedule' => $schedule
        ]);
    }

    /**
     * Show the form for editing the specified school day schedule.
     */
    public function edit(SchoolDaySchedule $schedule)
    {
        return view('pages.school-day-schedules.edit', [
            'schedule' => $schedule
        ]);
    }

    /**
     * Update the specified school day schedule.
     */
    public function update(SchoolDayScheduleRequest $request, SchoolDaySchedule $schedule)
    {
        $this->service->updateDaySchedule($schedule, $request->validated());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Jadwal hari berhasil diperbarui'
            ]);
        }
        
        return redirect()->route('school-day-schedules.index')->with('success', 'Jadwal hari berhasil diperbarui');
    }
}
