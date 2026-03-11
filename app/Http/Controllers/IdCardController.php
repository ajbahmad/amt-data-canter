<?php

namespace App\Http\Controllers;

use App\DataTables\IdCardDataTable;
use App\Http\Requests\IdCardRequest;
use App\Models\IdCard;
use App\Models\Person;
use App\Models\SchoolInstitution;
use App\Models\SchoolLevel;
use App\Services\IdCardService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class IdCardController extends Controller
{
    private $service;
    protected $viewDir = 'pages.id_cards.';
    protected $route = 'id_cards';
    protected $title = 'Kartu ID';

    public function __construct(IdCardService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of id cards (DataTable)
     */
    public function index(IdCardDataTable $dataTable)
    {
        return $dataTable->render($this->viewDir . 'index');
    }

    /**
     * Show the form for creating a new id card
     */
    public function create(): View
    {
        return view($this->viewDir . 'create', [
            'persons' => Person::get(),
            'schoolInstitutions' => SchoolInstitution::orderBy('name')->get(),
            'schoolLevels' => SchoolLevel::orderBy('name')->get(),
            'statuses' => [
                'active' => 'Aktif',
                'lost' => 'Hilang',
                'blocked' => 'Diblokir',
                'expired' => 'Expired',
            ],
        ]);
    }

    /**
     * Store a newly created id card in database
     */
    public function store(IdCardRequest $request): RedirectResponse
    {
        try {
            $this->service->create($request->validated());

            return redirect()
                ->route($this->route . '.index')
                ->with('success', $this->title . ' berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan ' . $this->title);
        }
    }

    /**
     * Display the specified id card
     */
    public function show($id): View
    {
        $idCard = $this->service->getById($id);
        $history = $this->service->getHistory($id, 20);

        return view($this->viewDir . 'view', [
            'idCard' => $idCard,
            'history' => $history,
        ]);
    }

    /**
     * Show the form for editing the specified id card
     */
    public function edit($id): View
    {
        $idCard = $this->service->getById($id);

        return view($this->viewDir . 'update', [
            'idCard' => $idCard,
            'persons' => Person::get(),
            'schoolInstitutions' => SchoolInstitution::orderBy('name')->get(),
            'schoolLevels' => SchoolLevel::orderBy('name')->get(),
            'statuses' => [
                'active' => 'Aktif',
                'lost' => 'Hilang',
                'blocked' => 'Diblokir',
                'expired' => 'Expired',
            ],
        ]);
    }

    /**
     * Update the specified id card in database
     */
    public function update($id, IdCardRequest $request): RedirectResponse
    {
        try {
            $this->service->update($id, $request->validated());

            return redirect()
                ->route($this->route . '.show', $id)
                ->with('success', $this->title . ' berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui ' . $this->title . ': ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified id card from database
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $this->service->delete($id);

            return redirect()
                ->route($this->route . '.index')
                ->with('success', $this->title . ' berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus ' . $this->title . ': ' . $e->getMessage());
        }
    }

    /**
     * Get statistics via AJAX
     */
    public function statistics()
    {
        return response()->json($this->service->getStatistics());
    }
}
