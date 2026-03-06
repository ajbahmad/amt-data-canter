<?php

namespace App\Http\Controllers;

use App\DataTables\SemesterDataTable;
use App\Http\Requests\SemesterRequest;
use App\Models\Semester;
use App\Services\SemesterService;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.semesters.';
    protected $route = 'semesters';
    protected $title = 'Semester';

    public function __construct()
    {
        $this->service = new SemesterService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SemesterDataTable $dataTable, Request $request)
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
            'schoolYears' => \App\Models\SchoolYear::where('is_active', true)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SemesterRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Semester berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Semester $semester)
    {   
        return view($this->viewDir.'view', compact('semester'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Semester $semester)
    {
        return view($this->viewDir.'update', [
            'semester' => $semester,
            'schoolInstitutions' => \App\Models\SchoolInstitution::where('is_active', true)->get(),
            'schoolYears' => \App\Models\SchoolYear::where('is_active', true)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SemesterRequest $request, Semester $semester)
    {
        $this->service->update($semester, $request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Semester berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Semester $semester)
    {
        $this->service->delete($semester);
        return redirect()->route($this->route.'.index')->with('success', 'Semester berhasil dihapus');
    }
}
