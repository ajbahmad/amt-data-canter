<?php

namespace App\Services\Api\SchoolInstitutions;

use App\Models\SchoolInstitution;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SchoolInstitutionService
{
    /**
     * Get paginated school institutions with search
     */
    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = SchoolInstitution::query();

        // Apply search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get school institutions for DataTable
     */
    public function getDataTableData(array $filters = []): array
    {
        $query = SchoolInstitution::query();

        // Apply search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        if (!empty($filters['orderColumn']) && !empty($filters['orderDir'])) {
            $columns = ['id', 'code', 'name', 'email', 'phone', 'address', 'created_at'];
            if (isset($columns[$filters['orderColumn']])) {
                $query->orderBy($columns[$filters['orderColumn']], $filters['orderDir']);
            }
        }

        // Get counts
        $totalCount = SchoolInstitution::count();
        $filteredCount = $query->count();

        // Apply pagination
        $start = $filters['start'] ?? 0;
        $length = $filters['length'] ?? 10;
        $data = $query->offset($start)->limit($length)->get();

        return [
            'draw' => $filters['draw'] ?? 0,
            'recordsTotal' => $totalCount,
            'recordsFiltered' => $filteredCount,
            'data' => $this->formatDataTableRows($data),
        ];
    }

    /**
     * Create a new school institution
     */
    public function create(array $data): SchoolInstitution
    {
        return SchoolInstitution::create($data);
    }

    /**
     * Get school institution by ID
     */
    public function getById(string $id): SchoolInstitution
    {
        return SchoolInstitution::findOrFail($id);
    }

    /**
     * Update school institution
     */
    public function update(SchoolInstitution $schoolInstitution, array $data): SchoolInstitution
    {
        $schoolInstitution->update($data);
        return $schoolInstitution;
    }

    /**
     * Delete school institution
     */
    public function delete(SchoolInstitution $schoolInstitution): bool
    {
        return $schoolInstitution->delete();
    }

    /**
     * Format data for DataTable response
     */
    private function formatDataTableRows(Collection $data): array
    {
        return $data->map(function ($item) {
            return [
                'id' => $item->id,
                'code' => $item->code,
                'name' => $item->name,
                'email' => $item->email,
                'phone' => $item->phone,
                'address' => $item->address,
                'created_at' => $item->created_at?->format('Y-m-d H:i:s'),
            ];
        })->toArray();
    }

    /**
     * Check if school institution code exists
     */
    public function codeExists(string $code, string $excludeId = null): bool
    {
        $query = SchoolInstitution::where('code', $code);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }

    /**
     * Get all active school institutions
     */
    public function getAllActive(): Collection
    {
        return SchoolInstitution::where('is_active', true)
            ->orderBy('name')
            ->get();
    }
}
