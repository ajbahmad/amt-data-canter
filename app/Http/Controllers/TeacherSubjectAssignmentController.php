<?php

namespace App\Http\Controllers;

use App\DataTables\TeacherSubjectAssignmentDataTable;
use App\Http\Requests\TeacherSubjectAssignmentRequest;
use App\Models\ClassRoom;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherSubjectAssignment;
use App\Services\TeacherSubjectAssignmentService;
use Illuminate\Http\Request;

class TeacherSubjectAssignmentController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.teacher-subject-assignments.';
    protected $route = 'teacher-subject-assignments';
    protected $title = 'Penugasan Guru Mapel';

    public function __construct(TeacherSubjectAssignmentService $service)
    {
        $this->service = $service;
    }

    public function index(TeacherSubjectAssignmentDataTable $dataTable, Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['viewDir'] = $this->viewDir;
        return $dataTable->render($this->viewDir.'index', $data);
    }

    public function create()
    {
        $teachers = Teacher::with('person')->get();
        $subjects = Subject::all();
        $classRooms = ClassRoom::all();
        $semesters = Semester::all();
        return view($this->viewDir.'create', compact('teachers', 'subjects', 'classRooms', 'semesters'));
    }

    public function store(TeacherSubjectAssignmentRequest $request)
    {
        try {
            $this->service->create($request->validated());
            return redirect()->route($this->route.'.index')->with('success', 'Data penugasan guru mapel berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data penugasan guru mapel: ' . $e->getMessage());
        }
    }

    public function show(TeacherSubjectAssignment $teacherSubjectAssignment)
    {
        $teacherSubjectAssignment->load(['teacher.person', 'subject', 'classRoom', 'semester']);
        return view($this->viewDir.'view', compact('teacherSubjectAssignment'));
    }

    public function edit(TeacherSubjectAssignment $teacherSubjectAssignment)
    {
        $teachers = Teacher::with('person')->get();
        $subjects = Subject::all();
        $classRooms = ClassRoom::all();
        $semesters = Semester::all();
        return view($this->viewDir.'edit', compact('teacherSubjectAssignment', 'teachers', 'subjects', 'classRooms', 'semesters'));
    }

    public function update(TeacherSubjectAssignmentRequest $request, TeacherSubjectAssignment $teacherSubjectAssignment)
    {
        try {
            $this->service->update($teacherSubjectAssignment->id, $request->validated());
            return redirect()->route($this->route.'.show', $teacherSubjectAssignment->id)->with('success', 'Data penugasan guru mapel berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data penugasan guru mapel: ' . $e->getMessage());
        }
    }

    public function destroy(TeacherSubjectAssignment $teacherSubjectAssignment)
    {
        try {
            $this->service->delete($teacherSubjectAssignment->id);
            return redirect()->route($this->route.'.index')->with('success', 'Data penugasan guru mapel berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data penugasan guru mapel: ' . $e->getMessage());
        }
    }
}
