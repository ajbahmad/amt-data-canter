<?php

namespace App\Http\Controllers;

use App\DataTables\RoleDataTable;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Models\Application;
use App\Models\SchoolInstitution;
use App\Models\SchoolLevel;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.roles.';
    protected $route = 'roles';
    protected $title = 'Role';

    public function __construct()
    {
        $this->service = new RoleService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(RoleDataTable $dataTable, Request $request)
    {
        if (request()->expectsJson() && !request()->columns) {
            $getByFilter = $this->service->filter($request->application_id);
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
        $applications = Application::active()->get();
        $institutions = SchoolInstitution::active()->get();
        $schoolLevels = SchoolLevel::where('is_active', true)->get();
        
        return view($this->viewDir.'create', compact('applications', 'institutions', 'schoolLevels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Role berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {   
        $role->load('application', 'permissions', 'institution', 'schoolLevel');
        return view($this->viewDir.'view', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $applications = Application::active()->get();
        $institutions = SchoolInstitution::active()->get();
        $schoolLevels = SchoolLevel::where('is_active', true)->get();
        
        return view($this->viewDir.'update', compact('role', 'applications', 'institutions', 'schoolLevels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $this->service->update($role->id, $request->validated());
        return redirect()->route($this->route.'.index')->with('success', 'Role berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->service->delete($role->id);
        return redirect()->route($this->route.'.index')->with('success', 'Role berhasil dihapus');
    }
}
