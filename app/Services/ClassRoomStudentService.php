<?php

namespace App\Services;

use App\Models\ClassRoomStudent;

class ClassRoomStudentService
{
    public function all()
    {
        return ClassRoomStudent::with(['classRoom', 'student.person'])->get();
    }

    public function getById($id)
    {
        return ClassRoomStudent::with(['classRoom', 'student.person'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return ClassRoomStudent::create($data);
    }

    public function update($id, array $data)
    {
        $classRoomStudent = ClassRoomStudent::findOrFail($id);
        $classRoomStudent->update($data);
        return $classRoomStudent;
    }

    public function delete($id)
    {
        $classRoomStudent = ClassRoomStudent::findOrFail($id);
        return $classRoomStudent->delete();
    }
}
