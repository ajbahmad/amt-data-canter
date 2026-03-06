<?php

namespace App\Services;

use App\Models\ClassRoomHomeroomTeacher;

class ClassRoomHomeroomTeacherService
{
    public function all()
    {
        return ClassRoomHomeroomTeacher::with(['classRoom', 'teacher.person'])->get();
    }

    public function getById($id)
    {
        return ClassRoomHomeroomTeacher::with(['classRoom', 'teacher.person'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return ClassRoomHomeroomTeacher::create($data);
    }

    public function update($id, array $data)
    {
        $classRoomHomeroomTeacher = ClassRoomHomeroomTeacher::findOrFail($id);
        $classRoomHomeroomTeacher->update($data);
        return $classRoomHomeroomTeacher;
    }

    public function delete($id)
    {
        $classRoomHomeroomTeacher = ClassRoomHomeroomTeacher::findOrFail($id);
        return $classRoomHomeroomTeacher->delete();
    }
}
