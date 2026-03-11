<?php

namespace App\Http\Controllers;

use App\DataTables\ClassRoomDataTable;
use App\Http\Requests\ClassRoomRequest;
use App\Models\ClassRoom;
use App\Models\SchedulePattern;
use App\Services\ClassRoomService;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.class_rooms.';
    protected $route = 'class_rooms';
    protected $title = 'Rombel';

    public function __construct()
    {
        $this->service = new ClassRoomService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ClassRoomDataTable $dataTable, Request $request)
    {
        if (request()->expectsJson() && !request()->columns) {
            $getByFilter = $this->service->filter($request->school_level_id);
            return response()->json($getByFilter);
        }
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['viewDir'] = $this->viewDir;
        return $dataTable->render($this->viewDir.'index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->viewDir.'create', [
            'schoolInstitutions' => \App\Models\SchoolInstitution::get(),
            'schoolLevels' => \App\Models\SchoolLevel::get(),
            'grades' => \App\Models\Grade::orderBy('order_no')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassRoomRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Rombel berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassRoom $classRoom)
    {   
        return view($this->viewDir.'view', compact('classRoom'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassRoom $classRoom)
    {
        return view($this->viewDir.'update', [
            'classRoom' => $classRoom,
            'schoolInstitutions' => \App\Models\SchoolInstitution::get(),
            'schoolLevels' => \App\Models\SchoolLevel::get(),
            'grades' => \App\Models\Grade::orderBy('order_no')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassRoomRequest $request, ClassRoom $classRoom)
    {
        $this->service->update($classRoom, $request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Rombel berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassRoom $classRoom)
    {
        $this->service->delete($classRoom);
        return redirect()->route($this->route.'.index')->with('success', 'Rombel berhasil dihapus');
    }


    function setSchedule(){
        return view($this->viewDir.'set_schedule', [
            'schoolInstitutions' => \App\Models\SchoolInstitution::get(),
            'schoolLevels' => \App\Models\SchoolLevel::get(),
            'classRooms' => ClassRoom::with('grade')->get(),
            'schedulePatterns' => SchedulePattern::orderBy('name')->get(),
        ]);    
    }

    function updateSchedule(Request $request){
        $this->service->updateSchedule($request);
        return redirect()->route('class_rooms.set_schedule')->with('success', 'Pengaturan jadwal berhasil diperbarui');

    }
}
