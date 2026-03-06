<?php

namespace App\Http\Controllers;

use App\DataTables\PersonDataTable;
use App\Http\Requests\PersonRequest;
use App\Models\Person;
use App\Services\PersonService;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    protected $service;
    protected $viewDir = 'pages.persons.';
    protected $route = 'persons';
    protected $title = 'Orang';

    public function __construct(PersonService $personService)
    {
        $this->service = $personService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PersonDataTable $dataTable, Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['viewDir'] = $this->viewDir;
        return $dataTable->render($this->viewDir.'index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->viewDir.'create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PersonRequest $request)
    {
        try {
            $this->service->create($request->validated());
            return redirect()->route($this->route.'.index')->with('success', 'Data orang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data orang: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        $person = $this->service->withRelations($person);
        return view($this->viewDir.'view', compact('person'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Person $person)
    {
        return view($this->viewDir.'edit', compact('person'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PersonRequest $request, Person $person)
    {
        try {
            $this->service->update($person, $request->validated());
            return redirect()->route($this->route.'.show', $person->id)->with('success', 'Data orang berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data orang: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        try {
            $this->service->delete($person);
            return redirect()->route($this->route.'.index')->with('success', 'Data orang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data orang: ' . $e->getMessage());
        }
    }
}

