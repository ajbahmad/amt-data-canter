<?php

namespace App\Http\Controllers;

use App\DataTables\TeacherDataTable;
use App\Http\Requests\TeacherRequest;
use App\Models\Person;
use App\Models\SchoolInstitution;
use App\Models\Teacher;
use App\Services\TeacherService;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.teachers.';
    protected $route = 'teachers';
    protected $title = 'Guru';

    public function __construct(TeacherService $service)
    {
        $this->service = $service;
    }

    public function index(TeacherDataTable $dataTable, Request $request)
    {
        if (request()->expectsJson() && !request()->columns) {
            $getByFilter = $this->service->filterBySchoolInstitution($request->school_institution_id);
            return response()->json($getByFilter);
        }
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

    public function store(TeacherRequest $request)
    {
        try {
            $this->service->create($request->validated());
            return redirect()->route($this->route.'.index')->with('success', 'Data guru berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data guru: ' . $e->getMessage());
        }
    }

    public function show(Teacher $teacher)
    {
        $teacher->load('person', 'schoolInstitution');
        return view($this->viewDir.'view', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $persons = Person::all();
        $schoolInstitutions = SchoolInstitution::all();
        return view($this->viewDir.'edit', compact('teacher', 'persons', 'schoolInstitutions'));
    }

    public function update(TeacherRequest $request, Teacher $teacher)
    {
        try {
            $this->service->update($teacher, $request->validated());
            return redirect()->route($this->route.'.show', $teacher->id)->with('success', 'Data guru berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data guru: ' . $e->getMessage());
        }
    }

    public function destroy(Teacher $teacher)
    {
        try {
            $this->service->delete($teacher);
            return redirect()->route($this->route.'.index')->with('success', 'Data guru berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data guru: ' . $e->getMessage());
        }
    }
}

