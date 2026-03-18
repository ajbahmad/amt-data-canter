<?php

namespace App\Services;

use App\Models\Application;

class ApplicationService
{
    /**
     * Get all applications with pagination
     */
    public function getAll($page = 1, $perPage = 10, $search = null)
    {
        $query = Application::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Create new application
     */
    public function create(array $data)
    {
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }
        return Application::create($data);
    }

    /**
     * Get application by id
     */
    public function getById($id)
    {
        return Application::find($id);
    }

    /**
     * Update application
     */
    public function update($id, array $data)
    {
        $application = $this->getById($id);
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }
        $application->update($data);
        return $application;
    }

    /**
     * Delete application
     */
    public function delete($id)
    {
        $application = $this->getById($id);
        return $application->delete();
    }

    /**
     * Get application by slug
     */
    public function getBySlug($slug)
    {
        return Application::where('slug', $slug)->first();
    }
}
