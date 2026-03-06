<?php

namespace App\Http\Controllers;

use App\DataTables\TimeSlotDataTable;
use App\Http\Requests\TimeSlotRequest;
use App\Models\SchoolInstitution;
use App\Models\SchoolLevel;
use App\Models\TimeSlot;
use App\Services\TimeSlotService;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.time-slots.';
    protected $route = 'time_slots';
    protected $title = 'Jam Pelajaran';

    public function __construct(TimeSlotService $service)
    {
        $this->service = $service;
    }

    public function index(TimeSlotDataTable $dataTable, Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['viewDir'] = $this->viewDir;
        return $dataTable->render($this->viewDir.'index', $data);
    }

    public function create()
    {
        $schoolInstitutions = SchoolInstitution::all();
        $schoolLevels = SchoolLevel::all();
        return view($this->viewDir.'create', compact('schoolInstitutions', 'schoolLevels'));
    }

    public function store(TimeSlotRequest $request)
    {
        try {
            $this->service->create($request->validated());
            return redirect()->route($this->route.'.index')->with('success', 'Data jam pelajaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data jam pelajaran: ' . $e->getMessage());
        }
    }

    public function show(TimeSlot $timeSlot)
    {
        $timeSlot->load('schoolInstitution', 'schoolLevel');
        return view($this->viewDir.'view', compact('timeSlot'));
    }

    public function edit(TimeSlot $timeSlot)
    {
        $schoolInstitutions = SchoolInstitution::all();
        $schoolLevels = SchoolLevel::all();
        return view($this->viewDir.'edit', compact('timeSlot', 'schoolInstitutions', 'schoolLevels'));
    }

    public function update(TimeSlotRequest $request, TimeSlot $timeSlot)
    {
        try {
            $this->service->update($timeSlot->id, $request->validated());
            return redirect()->route($this->route.'.show', $timeSlot->id)->with('success', 'Data jam pelajaran berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data jam pelajaran: ' . $e->getMessage());
        }
    }

    public function destroy(TimeSlot $timeSlot)
    {
        try {
            $this->service->delete($timeSlot->id);
            return redirect()->route($this->route.'.index')->with('success', 'Data jam pelajaran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data jam pelajaran: ' . $e->getMessage());
        }
    }
}
