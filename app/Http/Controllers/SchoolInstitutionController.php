<?php

namespace App\Http\Controllers;

use App\DataTables\SchoolInstitutionDataTable;
use App\Http\Requests\SchoolInstitutionRequest;
use App\Models\SchoolInstitution;
use App\Services\SchoolInstitutionService;
use Illuminate\Http\Request;

class SchoolInstitutionController extends Controller
{
    protected $serviceLembaga;
    protected $serviceKelas;
    protected $viewDir = 'pages.school_institutions.';
    protected $route = 'school_institutions';
    protected $title = 'Lembaga';

    public function __construct()
    {
        $this->serviceLembaga = new SchoolInstitutionService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SchoolInstitutionDataTable $dataTable, Request $request)
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
        return view($this->viewDir.'.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchoolInstitutionRequest $request)
    {
        $this->serviceLembaga->create($request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Lembaga sekolah berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolInstitution $schoolInstitution)
    {   
        return view($this->viewDir.'.view', compact('schoolInstitution'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolInstitution $schoolInstitution)
    {
        return view($this->viewDir.'.update', compact('schoolInstitution'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SchoolInstitutionRequest $request, SchoolInstitution $schoolInstitution)
    {
        $this->serviceLembaga->update($schoolInstitution->id, $request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Lembaga sekolah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolInstitution $schoolInstitution)
    {
        $this->serviceLembaga->delete($schoolInstitution->id);
        return redirect()->route($this->route.'.index')->with('success', 'Lembaga sekolah berhasil dihapus');
    }

}
