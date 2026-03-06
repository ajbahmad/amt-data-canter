<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherSubjectAssignment extends BaseModel
{
    use HasUuids;

    protected $table = 'teacher_subject_assignments';

    protected $fillable = [
        'teacher_id',
        'subject_id',
        'class_room_id',
        'semester_id',
        'assigned_at',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'assigned_at' => 'datetime',
    ];

    /**
     * Get the teacher
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the subject
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the class room
     */
    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class);
    }

    /**
     * Get the semester
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }
}
