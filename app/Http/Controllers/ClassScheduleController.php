<?php

namespace App\Http\Controllers;

use App\DataTables\ClassScheduleDataTable;
use App\Http\Requests\ClassScheduleRequest;
use App\Models\ClassRoom;
use App\Models\ClassSchedule;
use App\Models\SchoolInstitution;
use App\Models\SchoolLevel;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TimeSlot;
use App\Services\ClassScheduleService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClassScheduleController extends Controller
{
    private $service;
    protected $viewDir = 'pages.class_schedules.';
    protected $route = 'class_schedules';
    protected $title = 'Jadwal Kelas';
    public function __construct(ClassScheduleService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of class schedules
     */
    public function index()
    {
        return view('pages.class_schedules.index', [
            'teachers' => Teacher::with('person', 'teacherSubjectAssignments.subject')->where('is_active', true)->get(),
            'schedules' => $this->service->getSchedulesByDay(null, null),
            'classes' => ClassRoom::get(),
            'sessionTimes' => TimeSlot::orderBy('start_time')->get(),
            'subjects' => Subject::get(),
            'semesters' => Semester::get(),
            'schoolInstitutions' => SchoolInstitution::get(),
            'schoolLevels' => SchoolLevel::get(),
        ]);
    }

    /**
     * Show the form for creating a new class schedule
     */
    public function create(): View
    {
        return view('pages.class_schedules.create', [
            'classRooms' => ClassRoom::get(),
            'schoolLevels' => SchoolLevel::get(),
            'teachers' => Teacher::with('person')->where('is_active', true)->get(),
            'subjects' => Subject::get(),
            'timeSlots' => TimeSlot::get(),
            'semesters' => Semester::get(),
        ]);
    }

    /**
     * Store a newly created class schedule in storage
     */
    public function store(ClassScheduleRequest $request)
    {
        $this->service->create($request->validated());
        if (request()->expectsJson()) {
            return response()->json([
                'status'  => true,
                'message' => 'Jadwal kelas berhasil ditambahkan'
            ]);
        } else {
            return redirect()->route('class_schedules.index')
            ->with('success', 'Jadwal kelas berhasil ditambahkan');
        }
    }

    /**
     * Display the specified class schedule
     */
    public function show(ClassSchedule $classSchedule)
    {
        $schedule = $this->service->getById($classSchedule->id);
        if (request()->expectsJson()) {
            return response()->json([
                'status'  => true,
                'data'    => $schedule
            ]);
        } else {
            return view('pages.class_schedules.view', [
                'schedule' => $schedule,
            ]);
        }
    }

    /**
     * Show the form for editing the specified class schedule
     */
    public function edit(ClassSchedule $classSchedule): View
    {
        $schedule = $this->service->getById($classSchedule->id);
        
        return view('pages.class_schedules.edit', [
            'schedule' => $schedule,
            'classRooms' => ClassRoom::get(),
            'schoolLevels' => SchoolLevel::get(),
            'teachers' => Teacher::with('person')->where('is_active', true)->get(),
            'subjects' => Subject::get(),
            'timeSlots' => TimeSlot::get(),
            'semesters' => Semester::get(),
        ]);
    }

    /**
     * Update the specified class schedule in storage
     */
    public function update(ClassScheduleRequest $request, ClassSchedule $classSchedule)
    {
        $this->service->update($classSchedule->id, $request->validated());
        if (request()->expectsJson()) {
            return response()->json([
                'status'  => true,
                'message' => 'Jadwal kelas berhasil diperbarui'
            ]);
        } else {
            return redirect()->route('class_schedules.show', $classSchedule->id)
            ->with('success', 'Jadwal kelas berhasil diperbarui');
        }
    }

    /**
     * Remove the specified class schedule from storage
     */
    public function destroy(ClassSchedule $classSchedule)
    {
        $this->service->delete($classSchedule->id);
        return response()->json([
            'status'  => true,
            'message' => 'Jadwal kelas berhasil dihapus'
        ]);
    }

    /**
     * Display class schedule grid view
     */
    public function grid(Request $request): View
    {
        $classRoomId = $request->query('class_room_id');
        $semesterId = $request->query('semester_id');

        $classRooms = ClassRoom::get();
        $semesters = Semester::get();
        
        $schedulesByDay = [];
        
        if ($classRoomId && $semesterId) {
            $schedulesByDay = $this->service->getSchedulesByDay($classRoomId, $semesterId);
        }

        return view('pages.class_schedules.grid', [
            'classRooms' => $classRooms,
            'semesters' => $semesters,
            'schedulesByDay' => $schedulesByDay,
            'selectedClassRoom' => $classRoomId,
            'selectedSemester' => $semesterId,
        ]);
    }
}
