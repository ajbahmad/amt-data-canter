<?php

namespace App\Http\Controllers;

use App\DataTables\CalendarDataTable;
use App\Http\Requests\CalendarRequest;
use App\Models\Calendar;
use App\Models\SchoolInstitution;
use App\Models\SchoolLevel;
use App\Models\ClassRoom;
use App\Services\CalendarService;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    protected CalendarService $service;
    protected string $viewDir = 'pages.calendars.';

    public function __construct(CalendarService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the calendars
     */
    public function index(CalendarDataTable $dataTable)
    {
        $institutions = SchoolInstitution::where('is_active', true)
            ->orderBy('name')
            ->get();

        $levels = SchoolLevel::where('is_active', true)
            ->orderBy('name')
            ->get();

        $classRooms = ClassRoom::where('is_active', true)
            ->orderBy('name')
            ->get();

        return $dataTable->render($this->viewDir . 'index', compact('institutions', 'levels', 'classRooms'));
    }

    /**
     * Display calendar grid view
     */
    public function grid()
    {
        $institutions = SchoolInstitution::where('is_active', true)
            ->orderBy('name')
            ->get();

        $levels = SchoolLevel::where('is_active', true)
            ->orderBy('name')
            ->get();

        $classRooms = ClassRoom::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view($this->viewDir . 'grid', compact('institutions', 'levels', 'classRooms'));
    }

    /**
     * Get calendar events for FullCalendar (AJAX)
     */
    public function events(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $events = $this->service->getEvents($start, $end);

        return response()->json($events);
    }

    /**
     * Store a newly created calendar in storage (AJAX)
     */
    public function store(CalendarRequest $request)
    {
        try {
            $calendar = $this->service->create($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Calendar event created successfully',
                'data' => [
                    'id' => $calendar->id,
                    'title' => $calendar->title,
                    'start' => $calendar->start_date->format('Y-m-d'),
                    'end' => $calendar->end_date ? $calendar->end_date->addDay()->format('Y-m-d') : $calendar->start_date->addDay()->format('Y-m-d'),
                    'color' => $calendar->color,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Get a specific calendar event (for editing)
     */
    public function show(Calendar $calendar)
    {
        return response()->json($this->service->getForEdit($calendar->id));
    }

    /**
     * Update a calendar event (AJAX)
     */
    public function update(CalendarRequest $request, Calendar $calendar)
    {
        try {
            $updated = $this->service->update($calendar, $request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Calendar event updated successfully',
                'data' => [
                    'id' => $updated->id,
                    'title' => $updated->title,
                    'start' => $updated->start_date->format('Y-m-d'),
                    'end' => $updated->end_date ? $updated->end_date->addDay()->format('Y-m-d') : $updated->start_date->addDay()->format('Y-m-d'),
                    'color' => $updated->color,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Delete a calendar event (AJAX)
     */
    public function destroy(Calendar $calendar)
    {
        try {
            $this->service->delete($calendar);

            return response()->json([
                'status' => true,
                'message' => 'Calendar event deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
