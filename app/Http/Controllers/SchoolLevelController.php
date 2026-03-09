<?php

namespace App\Http\Controllers;

use App\DataTables\SchoolLevelDataTable;
use App\Http\Requests\SchoolLevelRequest;
use App\Models\SchoolLevel;
use App\Services\SchoolLevelService;
use Illuminate\Http\Request;

class SchoolLevelController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.school_levels.';
    protected $route = 'school_levels';
    protected $title = 'Level Sekolah';

    public function __construct()
    {
        $this->service = new SchoolLevelService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SchoolLevelDataTable $dataTable, Request $request)
    {
        if (request()->expectsJson() && !request()->columns) {
            $getByFilter = $this->service->filter($request->school_institution_id);
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
            'schoolInstitutions' => \App\Models\SchoolInstitution::where('is_active', true)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchoolLevelRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Level sekolah berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolLevel $schoolLevel)
    {
        return view($this->viewDir.'.view', compact('schoolLevel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolLevel $schoolLevel)
    {
        return view($this->viewDir.'update', [
            'schoolLevel' => $schoolLevel,
            'schoolInstitutions' => \App\Models\SchoolInstitution::where('is_active', true)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SchoolLevelRequest $request, SchoolLevel $schoolLevel)
    {
        $this->service->update($schoolLevel->id, $request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Level sekolah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolLevel $schoolLevel)
    {
        $this->service->delete($schoolLevel->id);
        return redirect()->route($this->route.'.index')->with('success', 'Level sekolah berhasil dihapus');
    }
}
