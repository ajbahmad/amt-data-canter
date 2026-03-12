<?php

namespace App\Http\Controllers;

use App\DataTables\GradeDataTable;
use App\Http\Requests\GradeRequest;
use App\Models\Grade;
use App\Services\GradeService;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.grades.';
    protected $route = 'grades';
    protected $title = 'Kelas';

    public function __construct()
    {
        $this->service = new GradeService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GradeDataTable $dataTable, Request $request)
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
            'schoolInstitutions' => \App\Models\SchoolInstitution::all(),
            'schoolLevels' => \App\Models\SchoolLevel::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GradeRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {   
        return view($this->viewDir.'view', compact('grade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    { 
        return view($this->viewDir.'update', [
            'grade' => $grade,
            'schoolInstitutions' => \App\Models\SchoolInstitution::all(),
            'schoolLevels' => \App\Models\SchoolLevel::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GradeRequest $request, Grade $grade)
    {
        $this->service->update($grade, $request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Kelas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $this->service->delete($grade);
        return redirect()->route($this->route.'.index')->with('success', 'Kelas berhasil dihapus');
    }
}
