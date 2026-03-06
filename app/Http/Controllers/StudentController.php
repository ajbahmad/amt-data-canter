<?php

namespace App\Http\Controllers;

use App\DataTables\StudentDataTable;
use App\Http\Requests\StudentRequest;
use App\Models\Person;
use App\Models\SchoolInstitution;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.students.';
    protected $route = 'students';
    protected $title = 'Siswa';

    public function __construct(StudentService $service)
    {
        $this->service = $service;
    }

    public function index(StudentDataTable $dataTable, Request $request)
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

    public function store(StudentRequest $request)
    {
        try {
            $this->service->create($request->validated());
            return redirect()->route($this->route.'.index')->with('success', 'Data siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data siswa: ' . $e->getMessage());
        }
    }

    public function show(Student $student)
    {
        $student->load('person', 'schoolInstitution');
        return view($this->viewDir.'view', compact('student'));
    }

    public function edit(Student $student)
    {
        $persons = Person::all();
        $schoolInstitutions = SchoolInstitution::all();
        return view($this->viewDir.'edit', compact('student', 'persons', 'schoolInstitutions'));
    }

    public function update(StudentRequest $request, Student $student)
    {
        try {
            $this->service->update($student, $request->validated());
            return redirect()->route($this->route.'.show', $student->id)->with('success', 'Data siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data siswa: ' . $e->getMessage());
        }
    }

    public function destroy(Student $student)
    {
        try {
            $this->service->delete($student);
            return redirect()->route($this->route.'.index')->with('success', 'Data siswa berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data siswa: ' . $e->getMessage());
        }
    }
}

