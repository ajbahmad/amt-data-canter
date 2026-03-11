<?php

namespace App\Http\Controllers;

use App\DataTables\SchoolYearDataTable;
use App\Http\Requests\SchoolYearRequest;
use App\Models\SchoolYear;
use App\Services\SchoolYearService;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.school_years.';
    protected $route = 'school_years';
    protected $title = 'Tahun Akademik';

    public function __construct()
    {
        $this->service = new SchoolYearService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SchoolYearDataTable $dataTable, Request $request)
    {
        if (request()->expectsJson() && !request()->columns) {
            $getByFilter = $this->service->filterBySchoolLevel($request->school_level_id);
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
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchoolYearRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Tahun akademik berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolYear $schoolYear)
    {   
        return view($this->viewDir.'view', compact('schoolYear'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolYear $schoolYear)
    {
        return view($this->viewDir.'update', [
            'schoolYear' => $schoolYear,
            'schoolInstitutions' => \App\Models\SchoolInstitution::get(),
            'schoolLevels' => \App\Models\SchoolLevel::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SchoolYearRequest $request, SchoolYear $schoolYear)
    {
        $this->service->update($schoolYear, $request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Tahun akademik berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolYear $schoolYear)
    {
        $this->service->delete($schoolYear);
        return redirect()->route($this->route.'.index')->with('success', 'Tahun akademik berhasil dihapus');
    }
}
