@extends('layouts.admin')

@section('title', 'Trip Management')

@section('main-content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">Trip List</h4>
                            <a href="javascript:void(0)" onclick="add_trip()" class="btn btn-primary btn-xs float-right">
                                <i class="fas fa-plus"></i> Add Trip
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="trip_table">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Driver</th>
                                        <th>Vehicle</th>
                                        <th>Start Location</th>
                                        <th>Destination</th>
                                        <th>Start Time</th>
                                        <th>Status</th>
                                        <th>Is Locked</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="trip_modal" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="tripModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <form id="trip_form" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tripModalLabel">Add Trip</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body row">
                            <!-- Route ID -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="route_id">Route ID <span class="text-danger">*</span></label>
                                    <input type="number" name="route_id" id="route_id" class="form-control form-control-sm" required>
                                </div>
                            </div>

                            <!-- Driver ID -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="driver_id">Driver ID <span class="text-danger">*</span></label>
                                    <input type="number" name="driver_id" id="driver_id" class="form-control form-control-sm" required>
                                </div>
                            </div>

                            <!-- Driver Name -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="driver_name">Driver Name <span class="text-danger">*</span></label>
                                    <input type="text" name="driver_name" id="driver_name" class="form-control form-control-sm" required>
                                </div>
                            </div>

                            <!-- Vehicle ID -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="vehicle_id">Vehicle ID <span class="text-danger">*</span></label>
                                    <input type="number" name="vehicle_id" id="vehicle_id" class="form-control form-control-sm" required>
                                </div>
                            </div>

                            <!-- Vehicle Registration Number -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="vehicle_registration_number">Vehicle Registration <span class="text-danger">*</span></label>
                                    <input type="text" name="vehicle_registration_number" id="vehicle_registration_number" class="form-control form-control-sm" required>
                                </div>
                            </div>

                            <!-- Start Location -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="start_location">Start Location <span class="text-danger">*</span></label>
                                    <input type="text" name="start_location" id="start_location" class="form-control form-control-sm" required>
                                </div>
                            </div>

                            <!-- Destination -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="destination">Destination <span class="text-danger">*</span></label>
                                    <input type="text" name="destination" id="destination" class="form-control form-control-sm" required>
                                </div>
                            </div>

                            <!-- Start Time -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="start_time">Start Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="start_time" id="start_time" class="form-control form-control-sm" required>
                                </div>
                            </div>

                            <!-- End Time -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="end_time">End Time</label>
                                    <input type="datetime-local" name="end_time" id="end_time" class="form-control form-control-sm">
                                </div>
                            </div>

                            <!-- Distance KM -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="distance_km">Distance (KM)</label>
                                    <input type="number" step="0.01" name="distance_km" id="distance_km" class="form-control form-control-sm">
                                </div>
                            </div>

                            <!-- Purpose -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="purpose">Purpose</label>
                                    <input type="text" name="purpose" id="purpose" class="form-control form-control-sm">
                                </div>
                            </div>

                            <!-- Fuel Cost -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fuel_cost">Fuel Cost</label>
                                    <input type="number" step="0.01" name="fuel_cost" id="fuel_cost" class="form-control form-control-sm">
                                </div>
                            </div>

                            <!-- Total Cost -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="total_cost">Total Cost</label>
                                    <input type="number" step="0.01" name="total_cost" id="total_cost" class="form-control form-control-sm">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control form-control-sm">
                                        <option value="pending">Pending</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="trip_id" id="trip_id">
                            <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success btn-xs">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('/assets/js/custom/v2/trip.js') }}"></script>
    <script>
        const message_edit = "Edit";
        const message_delete = "Delete";

        trip_list();

        $(document).on('submit', '#trip_form', function (e) {
            e.preventDefault();
            trip_save();
        });

    </script>
@endsection 