<?php

namespace App\Http\Controllers\Api\SchoolInstitutions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolInstitutions\SchoolInstitutionRequest;
use App\Models\SchoolInstitution;
use App\Services\Api\SchoolInstitutions\SchoolInstitutionService;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SchoolInstitutionController extends Controller
{
    /**
     * @var SchoolInstitutionService
     */
    private $service;

    /**
     * Constructor
     */
    public function __construct(SchoolInstitutionService $service)
    {
        $this->service = $service;
    }

    /**
     * Get school institutions list with pagination and search
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $data = $this->service->getPaginated(
                ['search' => $request->input('search')],
                $request->input('per_page', 15)
            );

            return ResponseHelper::successWithPagination(
                $data,
                'School institutions retrieved successfully.'
            );
        } catch (\Exception $e) {
            return ResponseHelper::serverError(
                'Failed to retrieve school institutions.',
                $e->getMessage()
            );
        }
    }

    /**
     * Store a newly created school institution
     */
    public function store(SchoolInstitutionRequest $request): JsonResponse
    {
        try {
            $schoolInstitution = $this->service->create($request->validated());

            return ResponseHelper::created(
                $schoolInstitution,
                'School institution created successfully.'
            );
        } catch (\Exception $e) {
            return ResponseHelper::unprocessableEntity(
                'Failed to create school institution.',
                ['exception' => $e->getMessage()]
            );
        }
    }

    /**
     * Display the specified school institution
     */
    public function show(SchoolInstitution $schoolInstitution): JsonResponse
    {
        try {
            $data = $this->service->getById($schoolInstitution->id);

            return ResponseHelper::success(
                $data,
                'School institution retrieved successfully.'
            );
        } catch (\Exception $e) {
            return ResponseHelper::notFound('School institution not found.');
        }
    }

    /**
     * Update the specified school institution
     */
    public function update(SchoolInstitutionRequest $request, SchoolInstitution $schoolInstitution): JsonResponse
    {
        try {
            $data = $this->service->update($schoolInstitution, $request->validated());

            return ResponseHelper::updated(
                $data,
                'School institution updated successfully.'
            );
        } catch (\Exception $e) {
            return ResponseHelper::unprocessableEntity(
                'Failed to update school institution.',
                ['exception' => $e->getMessage()]
            );
        }
    }

    /**
     * Remove the specified school institution
     */
    public function destroy(SchoolInstitution $schoolInstitution): JsonResponse
    {
        try {
            $this->service->delete($schoolInstitution);

            return ResponseHelper::deleted(
                'School institution deleted successfully.'
            );
        } catch (\Exception $e) {
            return ResponseHelper::unprocessableEntity(
                'Failed to delete school institution.',
                ['exception' => $e->getMessage()]
            );
        }
    }

    /**
     * Get school institutions for DataTable (Server-side processing)
     */
    public function dataTable(Request $request): JsonResponse
    {
        try {
            $data = $this->service->getDataTableData([
                'search' => $request->input('search.value'),
                'orderColumn' => $request->input('order.0.column', 0),
                'orderDir' => $request->input('order.0.dir', 'asc'),
                'start' => $request->input('start', 0),
                'length' => $request->input('length', 10),
                'draw' => $request->input('draw', 0),
            ]);

            return ResponseHelper::dataTable(
                $data['draw'],
                $data['recordsTotal'],
                $data['recordsFiltered'],
                $data['data']
            );
        } catch (\Exception $e) {
            return ResponseHelper::serverError(
                'Failed to retrieve DataTable data.',
                $e->getMessage()
            );
        }
    }
}
