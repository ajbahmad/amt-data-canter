<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Application;
use App\Models\Role;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.users.';
    protected $route = 'users';
    protected $title = 'User';

    public function __construct()
    {
        $this->service = new UserService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $dataTable, Request $request)
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
        $applications = Application::active()->get();
        $roles = Role::active()->get();
        $persons = \App\Models\Person::active()->get();
        
        return view($this->viewDir.'create', compact('applications', 'roles', 'persons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        
        $user = $this->service->create($validated);

        // Assign roles if provided
        if ($request->has('application_roles') && is_array($request->application_roles)) {
            foreach ($request->application_roles as $appId => $roleIds) {
                if (is_array($roleIds)) {
                    foreach ($roleIds as $roleId) {
                        $this->service->assignRole(
                            $user->id,
                            $roleId,
                            $appId,
                            $request->input("institution_id_{$appId}"),
                            $request->input("school_level_id_{$appId}")
                        );
                    }
                }
            }
        }

        return redirect()->route($this->route.'.index')->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {   
        $user->load('userRoles.role.application', 'userRoles.institution', 'userRoles.schoolLevel', 'person');
        return view($this->viewDir.'view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->load('userRoles.role.application', 'person');
        $applications = Application::active()->get();
        $roles = Role::active()->get();
        $persons = \App\Models\Person::active()->get();
        
        return view($this->viewDir.'update', compact('user', 'applications', 'roles', 'persons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $validated = $request->validated();
        
        $this->service->update($user->id, $validated);

        // Update roles if provided
        if ($request->has('application_roles') && is_array($request->application_roles)) {
            // Delete existing roles and create new ones
            $user->userRoles()->delete();

            foreach ($request->application_roles as $appId => $roleIds) {
                if (is_array($roleIds)) {
                    foreach ($roleIds as $roleId) {
                        $this->service->assignRole(
                            $user->id,
                            $roleId,
                            $appId,
                            $request->input("institution_id_{$appId}"),
                            $request->input("school_level_id_{$appId}")
                        );
                    }
                }
            }
        }

        return redirect()->route($this->route.'.index')->with('success', 'User berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->service->delete($user->id);
        return redirect()->route($this->route.'.index')->with('success', 'User berhasil dihapus');
    }

    /**
     * Get roles for application (AJAX)
     */
    public function getRolesForApplication(Request $request)
    {
        $applicationId = $request->get('application_id');
        
        $roles = Role::where('application_id', $applicationId)
            ->active()
            ->get(['id', 'name', 'slug']);

        return response()->json($roles);
    }
}
