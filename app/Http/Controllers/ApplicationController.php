<?php

namespace App\Http\Controllers;

use App\DataTables\ApplicationDataTable;
use App\Http\Requests\ApplicationRequest;
use App\Models\Application;
use App\Services\ApplicationService;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.applications.';
    protected $route = 'applications';
    protected $title = 'Aplikasi';

    public function __construct()
    {
        $this->service = new ApplicationService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ApplicationDataTable $dataTable, Request $request)
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
        return view($this->viewDir.'create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApplicationRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Aplikasi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {   
        return view($this->viewDir.'view', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        return view($this->viewDir.'update', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApplicationRequest $request, Application $application)
    {
        $this->service->update($application->id, $request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Aplikasi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        $this->service->delete($application->id);
        return redirect()->route($this->route.'.index')->with('success', 'Aplikasi berhasil dihapus');
    }
}
