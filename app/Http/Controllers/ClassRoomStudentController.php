<?php

namespace App\Http\Controllers;

use App\DataTables\ClassRoomStudentDataTable;
use App\Http\Requests\ClassRoomStudentRequest;
use App\Models\ClassRoom;
use App\Models\ClassRoomStudent;
use App\Models\SchoolInstitution;
use App\Models\SchoolLevel;
use App\Models\Student;
use App\Services\ClassRoomStudentService;
use Illuminate\Http\Request;

class ClassRoomStudentController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.class-room-students.';
    protected $route = 'class-room-students';
    protected $title = 'Siswa Kelas';

    public function __construct(ClassRoomStudentService $service)
    {
        $this->service = $service;
    }

    public function index(ClassRoomStudentDataTable $dataTable, Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['viewDir'] = $this->viewDir;
        return $dataTable->render($this->viewDir.'index', $data);
    }

    public function create()
    {
        $classRooms = ClassRoom::all();
        $schoolInstitutions = SchoolInstitution::orderBy('name')->get();
        $schoolLevels = SchoolLevel::orderBy('name')->get();
        $students = Student::with('person')->get();
        return view($this->viewDir.'create', compact('classRooms', 'schoolInstitutions', 'schoolLevels', 'students'));
    }

    public function store(ClassRoomStudentRequest $request)
    {
        try {
            $this->service->create($request->validated());
            return redirect()->route($this->route.'.index')->with('success', 'Data siswa kelas berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data siswa kelas: ' . $e->getMessage());
        }
    }

    public function show(ClassRoomStudent $classRoomStudent)
    {
        $classRoomStudent->load(['classRoom', 'student.person']);
        return view($this->viewDir.'view', compact('classRoomStudent'));
    }

    public function edit(ClassRoomStudent $classRoomStudent)
    {
        $classRooms = ClassRoom::all();
        $schoolInstitutions = SchoolInstitution::orderBy('name')->get();
        $schoolLevels = SchoolLevel::orderBy('name')->get();
        $students = Student::with('person')->get();
        return view($this->viewDir.'edit', compact('classRoomStudent', 'classRooms', 'schoolInstitutions', 'schoolLevels', 'students'));
    }

    public function update(ClassRoomStudentRequest $request, ClassRoomStudent $classRoomStudent)
    {
        try {
            $this->service->update($classRoomStudent->id, $request->validated());
            return redirect()->route($this->route.'.show', $classRoomStudent->id)->with('success', 'Data siswa kelas berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data siswa kelas: ' . $e->getMessage());
        }
    }

    public function destroy(ClassRoomStudent $classRoomStudent)
    {
        try {
            $this->service->delete($classRoomStudent->id);
            return redirect()->route($this->route.'.index')->with('success', 'Data siswa kelas berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data siswa kelas: ' . $e->getMessage());
        }
    }
}
