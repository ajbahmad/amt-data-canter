<?php

namespace App\Http\Controllers;

use App\DataTables\SubjectDataTable;
use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use App\Services\SubjectService;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.subjects.';
    protected $route = 'subjects';
    protected $title = 'Mata Pelajaran';

    public function __construct()
    {
        $this->service = new SubjectService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SubjectDataTable $dataTable, Request $request)
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
            'schoolInstitutions' => \App\Models\SchoolInstitution::all(),
            'schoolLevels' => \App\Models\SchoolLevel::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Mata pelajaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {   
        return view($this->viewDir.'view', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view($this->viewDir.'update', [
            'subject' => $subject,
            'schoolInstitutions' => \App\Models\SchoolInstitution::all(),
            'schoolLevels' => \App\Models\SchoolLevel::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectRequest $request, Subject $subject)
    {
        $this->service->update($subject, $request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Mata pelajaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $this->service->delete($subject);
        return redirect()->route($this->route.'.index')->with('success', 'Mata pelajaran berhasil dihapus');
    }
}
