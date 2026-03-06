<?php

namespace App\Http\Controllers;

use App\DataTables\ClassRoomHomeroomTeacherDataTable;
use App\Http\Requests\ClassRoomHomeroomTeacherRequest;
use App\Models\ClassRoom;
use App\Models\ClassRoomHomeroomTeacher;
use App\Models\Teacher;
use App\Services\ClassRoomHomeroomTeacherService;
use Illuminate\Http\Request;

class ClassRoomHomeroomTeacherController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.class-room-homeroom-teachers.';
    protected $route = 'class-room-homeroom-teachers';
    protected $title = 'Wali Kelas';

    public function __construct(ClassRoomHomeroomTeacherService $service)
    {
        $this->service = $service;
    }

    public function index(ClassRoomHomeroomTeacherDataTable $dataTable, Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['viewDir'] = $this->viewDir;
        return $dataTable->render($this->viewDir.'index', $data);
    }

    public function create()
    {
        $classRooms = ClassRoom::all();
        $teachers = Teacher::with('person')->get();
        return view($this->viewDir.'create', compact('classRooms', 'teachers'));
    }

    public function store(ClassRoomHomeroomTeacherRequest $request)
    {
        try {
            $this->service->create($request->validated());
            return redirect()->route($this->route.'.index')->with('success', 'Data wali kelas berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data wali kelas: ' . $e->getMessage());
        }
    }

    public function show(ClassRoomHomeroomTeacher $classRoomHomeroomTeacher)
    {
        $classRoomHomeroomTeacher->load(['classRoom', 'teacher.person']);
        return view($this->viewDir.'view', compact('classRoomHomeroomTeacher'));
    }

    public function edit(ClassRoomHomeroomTeacher $classRoomHomeroomTeacher)
    {
        $classRooms = ClassRoom::all();
        $teachers = Teacher::with('person')->get();
        return view($this->viewDir.'edit', compact('classRoomHomeroomTeacher', 'classRooms', 'teachers'));
    }

    public function update(ClassRoomHomeroomTeacherRequest $request, ClassRoomHomeroomTeacher $classRoomHomeroomTeacher)
    {
        try {
            $this->service->update($classRoomHomeroomTeacher->id, $request->validated());
            return redirect()->route($this->route.'.show', $classRoomHomeroomTeacher->id)->with('success', 'Data wali kelas berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data wali kelas: ' . $e->getMessage());
        }
    }

    public function destroy(ClassRoomHomeroomTeacher $classRoomHomeroomTeacher)
    {
        try {
            $this->service->delete($classRoomHomeroomTeacher->id);
            return redirect()->route($this->route.'.index')->with('success', 'Data wali kelas berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data wali kelas: ' . $e->getMessage());
        }
    }
}
