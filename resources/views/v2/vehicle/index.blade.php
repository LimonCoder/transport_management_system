@extends('layouts.admin')

@section('title','Vehicle')

@section('main-content')
<div class="content">
    <div class="container-fluid">
        <div class="row mb-3 align-items-center">
            <div class="col-md-6">
                <h4 class="mb-0">যানবাহনের তালিকা</h4>
            </div>
            <div class="col-md-6 text-md-right mt-2 mt-md-0">
                <button onclick="add_vehicle()" class="btn btn-primary">
                    <i class="fas fa-plus"></i> নতুন যানবাহন
                </button>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered vehicle_table" id="vehicle_table">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Org Code</th>
                                <th>Registration</th>
                                <th>Model</th>
                                <th>Capacity</th>
                                <th>Fuel</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data loaded via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Vehicle Modal -->
        <div class="modal fade" id="vehicle_modal" tabindex="-1" role="dialog" aria-labelledby="vehicleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="vehicle_form" enctype="multipart/form-data" onsubmit="vehicle_save(); return false;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="vehicleModalLabel">নতুন যানবাহন</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="registration_number">Registration Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="registration_number" id="registration_number" required placeholder="গাড়ি রেজিস্ট্রেশন নং প্রদান করুন">
                                    <div class="invalid-feedback" id="vehicle_reg_no_error"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="model">Model</label>
                                    <input type="text" class="form-control" name="model" id="model" placeholder="Model">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="capacity">Capacity</label>
                                    <input type="text" class="form-control" name="capacity" id="capacity" placeholder="Capacity">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="fuel_type_id">Fuel Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="fuel_type_id" id="fuel_type_id" required>
                                        <option value="">Select Fuel Type</option>
                                        <option value="1">Petrol</option>
                                        <option value="2">Diesel</option>
                                        <option value="3">CNG</option>
                                        <option value="4">Electric</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="status1">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" name="status" id="status1" required>
                                        <option value="">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Maintenance">Maintenance</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>ছবি</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="picture" name="images" accept="image/*" onchange="inputImageShow(this)" data-pi_no="1">
                                        <label class="custom-file-label" for="picture">Choose file</label>
                                    </div>
                                    <div class="mt-2">
                                        <img id="image_preview1" class="img-thumbnail d-none" style="height:60px; width:90px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" id="row_id">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('/assets/js/custom/v2/vehicle.js') }}"></script>
<script>
    $(function () {
        vehicle_list();
        // Datepickers if needed
        // $("#assignment_date, #useless_date").datepicker({dateFormat: 'yy-mm-dd'});
    });
    // Optional: Show filename in custom file input
    $(document).on('change', '.custom-file-input', function (e) {
        var fileName = e.target.files[0]?.name;
        $(this).next('.custom-file-label').html(fileName);
    });
</script>
@endsection
