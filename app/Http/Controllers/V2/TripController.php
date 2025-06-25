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
} 