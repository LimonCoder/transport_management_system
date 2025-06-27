<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Repositories\TripRepositoryInterface;
use App\Services\NotificationService;
use App\Events\TripCreated;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class TripController extends Controller
{
    protected $tripRepo;
    protected $notificationService;

    public function __construct(TripRepositoryInterface $tripRepo, NotificationService $notificationService)
    {
        $this->tripRepo = $tripRepo;
        $this->notificationService = $notificationService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('v2.trip.index');
    }

    public function listData(){
        return $this->tripRepo->listDataForDataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'route_id'           => 'required|integer|exists:routes,id',
            'driver_id'          => 'required|integer|exists:drivers,id',
            'vehicle_id'         => 'required|integer|exists:vehicles,id',
            'trip_initiate_date' => 'required|date',
        ]);

        try {
            // Check if a trip already exists on the specified date
            if ($this->tripRepo->checkTripExistsByDate($validated['trip_initiate_date'])) {
                return response()->json([
                    'status' => 'error',
                    'title' => 'Trip Already Exists',
                    'message' => 'A trip has already been initiated on ' . $validated['trip_initiate_date'] . '. Please choose a different date.'
                ], 422);
            }

            $trip = $this->tripRepo->createTripWithAuditLog($validated);

            // Send notification to driver
            $this->sendTripNotification($trip);

            // Fire event for real-time notification
            event(new TripCreated($trip));

            return response()->json([
                'status' => 'success',
                "title" => "Success",
                'message' => 'Trip created successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'title' => 'Error',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'route_id'           => 'required|integer|exists:routes,id',
            'driver_id'          => 'required|integer|exists:drivers,id',
            'vehicle_id'         => 'required|integer|exists:vehicles,id',
            'trip_initiate_date' => 'required|date',
        ]);

        try {
            // Check if a trip already exists on the specified date (excluding current trip)
            if ($this->tripRepo->checkTripExistsByDate($validated['trip_initiate_date'], $request->trip_id)) {
                return response()->json([
                    'status' => 'error',
                    'title' => 'Trip Already Exists',
                    'message' => 'Another trip has already been initiated on ' . $validated['trip_initiate_date'] . '. Please choose a different date.'
                ], 422);
            }

            $this->tripRepo->updateTripWithAuditLog($request->trip_id, $validated);

            return response()->json([
                'status' => 'success',
                'title' => 'Updated!',
                'message' => 'Trip updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'title' => 'Update Failed!',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $this->tripRepo->delete($request->trip_id);

            return response()->json([
                'status' => 'success',
                'title' => 'Deleted!',
                'message' => 'Trip deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'title' => 'Delete Failed!',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function report()
    {
        $drivers = app(\App\Repositories\DriverRepository::class)->all();
        $routes = app(\App\Repositories\RouteRepository::class)->all();
        return view('v2.report.trip-repport', compact('drivers', 'routes'));
    }

    public function reportPrint(Request $request)
    {
        $reportType = $request->input('report_type');

        // Base validation rules
        $rules = [
            'report_type' => 'required|in:month,date',
            'driver_id'   => 'nullable|integer|exists:drivers,id',
            'route_id'    => 'nullable|integer|exists:routes,id',
        ];

        // Add conditional validation
        if ($reportType === 'month') {
            $rules['month'] = 'required';
        } elseif ($reportType === 'date') {
            $rules['start_date'] = 'required|date';
            $rules['end_date'] = 'required|date|after_or_equal:start_date';
        }

        // Validate the request
        $validated = $request->validate($rules);

        // Collect filters
        $filters = [
            'report_type' => $reportType,
            'month'       => $request->month,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'driver_id'   => $request->driver_id,
            'route_id'    => $request->route_id,
        ];

        try {
            $trips = $this->tripRepo->getTripsForReport($filters);

            if (!empty($filters['route_id'])) {
                $route = app(\App\Repositories\RouteRepository::class)->find($filters['route_id']);
                $routeName = $route->title; // Or use your actual route name column
            }

            if (!empty($filters['driver_id'])) {
                $driver = app(\App\Repositories\DriverRepository::class)->find($filters['driver_id']);
                $driverName = $driver->name; // Or whatever column holds the name
            }

            $total_distance_km = $trips->sum(fn($trip) => (float) ($trip->distance_km ?? 0));
            $total_cost = $trips->sum(fn($trip) => (float) ($trip->total_cost ?? 0));

            $pdf = PDF::loadView('v2.report.trip-report-pdf', [
                'trips' => $trips,
                'filters' => $filters,
                'total_distance_km' => $total_distance_km,
                'total_cost' => $total_cost,
                'routeName' => $routeName ?? '',
                'driverName' => $driverName ?? ''
            ]);

            return $pdf->stream('trip-report.pdf');

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display trip details management page
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        return view('v2.trip.details');
    }

    /**
     * Get trip details list for DataTable
     *
     * @return \Illuminate\Http\Response
     */
    public function detailsListData()
    {
        return $this->tripRepo->detailsListDataForDataTable();
    }

    /**
     * Update trip details
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateDetails(Request $request)
    {
        $validated = $request->validate([
            'trip_id'         => 'required|integer|exists:trips,id',
            'start_location'  => 'nullable|string|max:255',
            'destination'     => 'nullable|string|max:255',
            'start_time'      => 'nullable|date',
            'end_time'        => 'nullable|date|after_or_equal:start_time',
            'distance_km'     => 'nullable|numeric|min:0',
            'purpose'         => 'nullable|string|max:100',
            'fuel_cost'       => 'nullable|numeric|min:0',
            'total_cost'      => 'nullable|numeric|min:0',
            'status'          => 'required|in:initiate,completed,reject',
            'reject_reason'   => 'required_if:status,reject|nullable|string',
        ]);

        try {
            $this->tripRepo->updateTripDetails($validated['trip_id'], $validated);

            return response()->json([
                'status' => 'success',
                'title' => 'Updated!',
                'message' => 'Trip details updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'title' => 'Update Failed!',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send notification to driver when trip is created
     */
    private function sendTripNotification($trip)
    {
        try {
            $notificationData = [
                'driver_id' => $trip->driver_id,
                'trip_id' => $trip->id,
                'route_name' => $trip->route_name,
                'vehicle_registration' => $trip->vehicle_registration_number,
                'trip_date' => $trip->trip_initiate_date,
                'org_code' => $trip->org_code
            ];

            $this->notificationService->createTripNotification($notificationData);
        } catch (\Exception $e) {
            // Log error but don't fail the trip creation
            \Log::error('Failed to send trip notification: ' . $e->getMessage());
        }
    }

} 