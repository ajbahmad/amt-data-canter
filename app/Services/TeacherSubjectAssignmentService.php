<?php

namespace App\Services;

use App\Models\TeacherSubjectAssignment;

class TeacherSubjectAssignmentService
{
    public function all()
    {
        return TeacherSubjectAssignment::with(['teacher.person', 'subject', 'classRoom', 'semester'])->get();
    }

    public function getById($id)
    {
        return TeacherSubjectAssignment::with(['teacher.person', 'subject', 'classRoom', 'semester'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return TeacherSubjectAssignment::create($data);
    }

    public function update($id, array $data)
    {
        $teacherSubjectAssignment = TeacherSubjectAssignment::findOrFail($id);
        $teacherSubjectAssignment->update($data);
        return $teacherSubjectAssignment;
    }

    public function delete($id)
    {
        $teacherSubjectAssignment = TeacherSubjectAssignment::findOrFail($id);
        return $teacherSubjectAssignment->delete();
    }
}
