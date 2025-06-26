<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Repositories\TripRepositoryInterface;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class TripController extends Controller
{
    protected $tripRepo;

    public function __construct(TripRepositoryInterface $tripRepo)
    {
        $this->tripRepo = $tripRepo;
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
            $this->tripRepo->createTripWithAuditLog($validated);

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
        // Unlimited execution time
        set_time_limit(0);

        // Validate input
        $validated = $request->validate([
            'report_type' => 'required|in:month,date',
            'month'       => 'required_if:report_type,month',
            'start_date'  => 'required_if:report_type,date|date',
            'end_date'    => 'required_if:report_type,date|date|after_or_equal:start_date',
            'driver_id'   => 'nullable|integer|exists:drivers,id',
            'route_id'    => 'nullable|integer|exists:routes,id',
        ]);

        // Collect filters
        $filters = [
            'report_type' => $request->report_type,
            'month'       => $request->month,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'driver_id'   => $request->driver_id,
            'route_id'    => $request->route_id,
        ];

        try {
            // Get filtered trips (you can limit to test performance)
            $trips = $this->tripRepo->getTripsForReport($filters);
            // $trips = $trips->take(300); // Optional: limit for testing performance

            // Load optimized view for PDF
            $pdf = PDF::loadView('v2.report.trip-report-pdf', [
                'trips'   => $trips,
                'filters' => $filters,
            ]);

            // Return as download
            // return $pdf->download('trip-report.pdf');

            // OR for testing in browser:
            return $pdf->stream('trip-report.pdf');

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

} 