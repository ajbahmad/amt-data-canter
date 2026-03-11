<?php

namespace App\Http\Controllers;

use App\DataTables\PersonTypeDataTable;
use App\Http\Requests\PersonTypeRequest;
use App\Models\PersonType;
use App\Models\SchoolInstitution;
use App\Services\PersonTypeService;
use Illuminate\Http\Request;

class PersonTypeController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.person_types.';
    protected $route = 'person_types';
    protected $title = 'Tipe Orang';

    public function __construct(PersonTypeService $service)
    {
        $this->service = $service;
    }

    public function index(PersonTypeDataTable $dataTable, Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['viewDir'] = $this->viewDir;
        return $dataTable->render($this->viewDir.'index', $data);
    }

    public function create()
    {
        $schoolInstitutions = SchoolInstitution::orderBy('name')->get();
        return view($this->viewDir.'create', compact('schoolInstitutions'));
    }

    public function store(PersonTypeRequest $request)
    {
        try {
            $this->service->create($request->validated());
            return redirect()->route($this->route.'.index')->with('success', 'Tipe orang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan tipe orang: ' . $e->getMessage());
        }
    }

    public function show(PersonType $personType)
    {
        $personType->load('memberships.person');
        return view($this->viewDir.'view', compact('personType'));
    }

    public function edit(PersonType $personType)
    {
        $schoolInstitutions = SchoolInstitution::orderBy('name')->get();
        return view($this->viewDir.'edit', compact('personType', 'schoolInstitutions'));
    }

    public function update(PersonTypeRequest $request, PersonType $personType)
    {
        try {
            $this->service->update($personType, $request->validated());
            return redirect()->route($this->route.'.show', $personType->id)->with('success', 'Tipe orang berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui tipe orang: ' . $e->getMessage());
        }
    }

    public function destroy(PersonType $personType)
    {
        try {
            $this->service->delete($personType);
            return redirect()->route($this->route.'.index')->with('success', 'Tipe orang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus tipe orang: ' . $e->getMessage());
        }
    }
}

