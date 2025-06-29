@extends('layouts.admin')

@section('title', 'Trip Details Management')

@section('main-content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">@lang('message.trip-details-list')</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="trip_details_table">
                                    <thead>
                                    <tr>
                                        <th>@lang('message.no')</th>
                                        <th>@lang('message.route-name')</th>
                                        <th>@lang('message.driver-name')</th>
                                        <th>@lang('message.vehicle-number')</th>
                                        <th>@lang('message.trip-date')</th>
                                        <th>@lang('message.start-location')</th>
                                        <th>@lang('message.destination')</th>
                                        <th>@lang('message.start-time')</th>
                                        <th>@lang('message.end-time')</th>
                                        <th>@lang('message.distance')</th>
                                        <th>@lang('message.purpose')</th>
                                        <th>@lang('message.fuel-cost')</th>
                                        <th>@lang('message.total-cost')</th>
                                        <th>@lang('message.status')</th>
                                        <th>@lang('message.action')</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="trip_details_modal" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="tripDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <form id="trip_details_form" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tripDetailsModalLabel">Update Trip Details</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="start_location">Start Location</label>
                                    <input type="text" name="start_location" id="start_location" class="form-control form-control-sm" maxlength="255">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="destination">Destination</label>
                                    <input type="text" name="destination" id="destination" class="form-control form-control-sm" maxlength="255">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="start_time">Start Time</label>
                                    <input type="datetime-local" name="start_time" id="start_time" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="end_time">End Time</label>
                                    <input type="datetime-local" name="end_time" id="end_time" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="distance_km">Distance (km)</label>
                                    <input type="number" step="0.01" min="0" name="distance_km" id="distance_km" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="purpose">Purpose</label>
                                    <input type="text" name="purpose" id="purpose" class="form-control form-control-sm" maxlength="100">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fuel_cost">Fuel Cost</label>
                                    <input type="number" step="0.01" min="0" name="fuel_cost" id="fuel_cost" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="total_cost">Total Cost</label>
                                    <input type="number" step="0.01" min="0" name="total_cost" id="total_cost" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="trip_status" class="form-control form-control-sm" required>
                                        <option value="">Select Status</option>
                                        <option value="completed">Completed</option>
                                        <option value="reject">Reject</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6" id="reject_reason_field" style="display: none;">
                                <div class="form-group">
                                    <label for="reject_reason">Reject Reason <span class="text-danger">*</span></label>
                                    <textarea name="reject_reason" id="reject_reason" class="form-control form-control-sm" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="trip_id" id="trip_id">
                            <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success btn-xs">Update Trip Details</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/assets/js/custom/v1/custom.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/v2/trip-details.js') }}"></script>
    <script>
        const message_edit = "Edit";
        $(document).ready(function() {
            trip_details_list();
        });
        $(document).on('submit', '#trip_details_form', function (e) {
            e.preventDefault();
            trip_details_update();
        });
        $(document).on('change', '#trip_status', function() {
            if ($(this).val() === 'reject') {
                $('#reject_reason_field').show();
                $('#reject_reason').attr('required', true);
            } else {
                $('#reject_reason_field').hide();
                $('#reject_reason').attr('required', false);
                $('#reject_reason').val('');
            }
        });
    </script>
@endsection 