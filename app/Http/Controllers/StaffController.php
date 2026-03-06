<?php

namespace App\Http\Controllers;

use App\DataTables\StaffDataTable;
use App\Http\Requests\StaffRequest;
use App\Models\Person;
use App\Models\SchoolInstitution;
use App\Models\Staff;
use App\Services\StaffService;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.staffs.';
    protected $route = 'staffs';
    protected $title = 'Staf';

    public function __construct(StaffService $service)
    {
        $this->service = $service;
    }

    public function index(StaffDataTable $dataTable, Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['viewDir'] = $this->viewDir;
        return $dataTable->render($this->viewDir.'index', $data);
    }

    public function create()
    {
        $persons = Person::all();
        $schoolInstitutions = SchoolInstitution::all();
        return view($this->viewDir.'create', compact('persons', 'schoolInstitutions'));
    }

    public function store(StaffRequest $request)
    {
        try {
            $this->service->create($request->validated());
            return redirect()->route($this->route.'.index')->with('success', 'Data staf berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data staf: ' . $e->getMessage());
        }
    }

    public function show(Staff $staff)
    {
        $staff->load('person', 'schoolInstitution');
        return view($this->viewDir.'view', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $persons = Person::all();
        $schoolInstitutions = SchoolInstitution::all();
        return view($this->viewDir.'edit', compact('staff', 'persons', 'schoolInstitutions'));
    }

    public function update(StaffRequest $request, Staff $staff)
    {
        try {
            $this->service->update($staff, $request->validated());
            return redirect()->route($this->route.'.show', $staff->id)->with('success', 'Data staf berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data staf: ' . $e->getMessage());
        }
    }

    public function destroy(Staff $staff)
    {
        try {
            $this->service->delete($staff);
            return redirect()->route($this->route.'.index')->with('success', 'Data staf berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data staf: ' . $e->getMessage());
        }
    }
}

