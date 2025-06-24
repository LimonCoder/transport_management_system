<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Repositories\TripRepositoryInterface;
use Illuminate\Http\Request;

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

    public function listData()
    {
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
            'route_id'                     => 'required|integer',
            'driver_id'                    => 'required|integer',
            'driver_name'                  => 'required|string|max:100',
            'vehicle_id'                   => 'required|integer',
            'vehicle_registration_number'  => 'required|string|max:50',
            'start_location'               => 'required|string|max:255',
            'destination'                  => 'required|string|max:255',
            'start_time'                   => 'required|date',
            'end_time'                     => 'nullable|date|after:start_time',
            'distance_km'                  => 'nullable|numeric|min:0',
            'purpose'                      => 'nullable|string|max:100',
            'fuel_cost'                    => 'nullable|numeric|min:0',
            'total_cost'                   => 'nullable|numeric|min:0',
            'status'                       => 'nullable|in:pending,completed,cancelled',
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
            'route_id'                     => 'required|integer',
            'driver_id'                    => 'required|integer',
            'driver_name'                  => 'required|string|max:100',
            'vehicle_id'                   => 'required|integer',
            'vehicle_registration_number'  => 'required|string|max:50',
            'start_location'               => 'required|string|max:255',
            'destination'                  => 'required|string|max:255',
            'start_time'                   => 'required|date',
            'end_time'                     => 'nullable|date|after:start_time',
            'distance_km'                  => 'nullable|numeric|min:0',
            'purpose'                      => 'nullable|string|max:100',
            'fuel_cost'                    => 'nullable|numeric|min:0',
            'total_cost'                   => 'nullable|numeric|min:0',
            'status'                       => 'nullable|in:pending,completed,cancelled',
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
} 