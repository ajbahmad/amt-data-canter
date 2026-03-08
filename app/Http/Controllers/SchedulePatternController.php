<?php

namespace App\Http\Controllers;

use App\DataTables\SchedulePatternDataTable;
use App\Http\Requests\SchedulePatternRequest;
use App\Http\Requests\SchoolDayScheduleRequest;
use App\Models\SchedulePattern;
use App\Models\SchoolDaySchedule;
use App\Services\SchedulePatternService;
use Illuminate\Http\Request;

class SchedulePatternController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.schedule-patterns.';
    protected $route = 'schedule-patterns';
    protected $title = 'Pola Jadwal Sekolah';

    public function __construct()
    {
        $this->service = new SchedulePatternService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SchedulePatternDataTable $dataTable, Request $request)
    {
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
            'schoolInstitutions' => \App\Models\SchoolInstitution::where('is_active', true)->get(),
            'schoolLevels' => \App\Models\SchoolLevel::where('is_active', true)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchedulePatternRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Pola jadwal berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchedulePattern $schedulePattern)
    {   
        return view($this->viewDir.'view', compact('schedulePattern'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchedulePattern $schedulePattern)
    {
        return view($this->viewDir.'update', [
            'schedulePattern' => $schedulePattern,
            'schoolInstitutions' => \App\Models\SchoolInstitution::where('is_active', true)->get(),
            'schoolLevels' => \App\Models\SchoolLevel::where('is_active', true)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SchedulePatternRequest $request, SchedulePattern $schedulePattern)
    {
        $this->service->update($schedulePattern, $request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Pola jadwal berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchedulePattern $schedulePattern)
    {
        $this->service->delete($schedulePattern);
        return redirect()->route($this->route.'.index')->with('success', 'Pola jadwal berhasil dihapus');
    }
}
