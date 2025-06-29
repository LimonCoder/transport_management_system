@extends('layouts.admin')

@section('title', 'Trip Management')

@section('main-content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">@lang('message.trip-list')</h4>
                            <a href="javascript:void(0)" onclick="add_trip()" class="btn btn-primary btn-xs float-right">
                                <i class="fas fa-plus"></i> @lang('message.add')
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="trip_table">
                                    <thead>
                                    <tr>
                                        <th>@lang('message.no')</th>
                                        <th>@lang('message.route-name')</th>
                                        <th>@lang('message.driver-name')</th>
                                        <th>@lang('message.vehicle-number')</th>
                                        <th>@lang('message.trip-initiate-date')</th>
                                        <th>@lang('message.is_locked')</th>
                                        <th>@lang('message.action')</th>
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
                            <h5 class="modal-title" id="tripModalLabel">@lang('message.add-trip')</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body row">
                            <!-- Route ID -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="route_id">@lang('message.route') <span class="text-danger">*</span></label>
                                    <select name="route_id" id="route_id" class="form-control form-control-sm" required>
                                        <option value="">Select Route</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Driver ID -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="driver_id">@lang('message.driver') <span class="text-danger">*</span></label>
                                    <select name="driver_id" id="driver_id" class="form-control form-control-sm" required>
                                        <option value="">@lang('message.select-driver')</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Vehicle ID -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="vehicle_id">@lang('message.vehicle') <span class="text-danger">*</span></label>
                                    <select name="vehicle_id" id="vehicle_id" class="form-control form-control-sm" required>
                                        <option value="">@lang('message.select-vehicle')</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Trip Initiate Date -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="trip_initiate_date">@lang('message.trip-initiate-date') <span class="text-danger">*</span></label>
                                    <input type="date" name="trip_initiate_date" id="trip_initiate_date" class="form-control form-control-sm" required>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="trip_id" id="trip_id">
                            <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">@lang('message.close')</button>
                            <button type="submit" class="btn btn-success btn-xs">@lang('message.save')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('/assets/js/custom/v1/custom.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/v2/trip.js') }}"></script>
    <script>
        const message_edit = "Edit";
        const message_delete = "Delete";

        // Initialize DataTable when document is ready
        $(document).ready(function() {
            console.log('Initializing trip DataTable...');
            console.log('Base URL:', url);
            trip_list();
        });

        $(document).on('submit', '#trip_form', function (e) {
            e.preventDefault();
            
            // Check if trip_id has a value to determine if it's an edit or add operation
            let trip_id = $('#trip_id').val();
            
            if (trip_id && trip_id !== '') {
                // Edit operation
                trip_update();
            } else {
                // Add operation
                trip_save();
            }
        });

    </script>
@endsection 