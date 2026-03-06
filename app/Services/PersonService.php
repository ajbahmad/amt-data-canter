<?php

namespace App\Services;

use App\Models\Person;
use Illuminate\Support\Facades\Storage;

class PersonService
{
    /**
     * Get all persons with filtering and pagination
     */
    public function all($filters = [], $limit = 10)
    {
        $query = Person::query();

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'ILIKE', "%{$search}%")
                  ->orWhere('last_name', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%")
                  ->orWhere('phone', 'ILIKE', "%{$search}%");
            });
        }

        if (isset($filters['gender']) && $filters['gender']) {
            $query->where('gender', $filters['gender']);
        }

        if (isset($filters['is_active']) && $filters['is_active'] !== '') {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->orderBy('created_at', 'DESC')->paginate($limit);
    }

    /**
     * Get person by id
     */
    public function getById($id)
    {
        return Person::findOrFail($id);
    }

    /**
     * Create new person
     */
    public function create($data)
    {
        // Handle photo upload
        if (isset($data['photo'])) {
            $photoPath = $data['photo']->store('persons', 'public');
            $data['photo'] = $photoPath;
        }

        return Person::create($data);
    }

    /**
     * Update person
     */
    public function update($person, $data)
    {
        // Handle photo upload
        if (isset($data['photo'])) {
            // Delete old photo
            if ($person->photo) {
                Storage::disk('public')->delete($person->photo);
            }
            
            $photoPath = $data['photo']->store('persons', 'public');
            $data['photo'] = $photoPath;
        } else {
            // Remove photo key if not provided
            unset($data['photo']);
        }

        $person->update($data);
        return $person;
    }

    /**
     * Delete person
     */
    public function delete($person)
    {
        // Delete photo
        if ($person->photo) {
            Storage::disk('public')->delete($person->photo);
        }
        
        return $person->delete();
    }

    /**
     * Get person with all relationships
     */
    public function withRelations($person)
    {
        return $person->load('memberships.personType', 'student', 'teacher', 'staff');
    }
}
