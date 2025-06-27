@extends('layouts.admin')

@section('title', 'Organization Management')

@section('main-content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">Organization List</h4>
                            <a href="javascript:void(0)" onclick="add_organization()" class="btn btn-primary btn-xs float-right">
                                <i class="fas fa-plus"></i> Add Organization
                            </a>
                            @if(session('original_user_id'))
                                <button type="button" onclick="switch_back()" class="btn btn-info btn-xs float-right mr-2">
                                    <i class="fas fa-user-check"></i> Switch Back to Original Account
                                </button>
                            @endif
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="organization_table">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Org Code</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Type</th>
                                        <th>Operator</th>
                                        <th>Created At</th>
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
        <div class="modal fade" id="organization_modal" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="organizationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <form id="organization_form" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="organizationModalLabel">Add Organization</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body row">
                            <!-- Organization Code -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="organization_code">Organization Code <span class="text-danger">*</span></label>
                                    <input type="text" name="organization_code" id="organization_code" class="form-control form-control-sm" required maxlength="50" placeholder="Enter organization code">
                                    <small id="organization_code_error" class="text-danger"></small>
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Organization Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control form-control-sm" required maxlength="100" placeholder="Enter organization name">
                                    <small id="name_error" class="text-danger"></small>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="address">Organization Address</label>
                                    <input type="text" name="address" id="address" class="form-control form-control-sm" maxlength="200" placeholder="Enter organization address">
                                    <small id="address_error" class="text-danger"></small>
                                </div>
                            </div>

                            <!-- Organization Type -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="org_type">Organization Type <span class="text-danger">*</span></label>
                                    <select name="org_type" id="org_type" class="form-control form-control-sm" required>
                                        <option value="">Select Type</option>
                                        <option value="university">University</option>
                                        <option value="college">College</option>
                                    </select>
                                    <small id="org_type_error" class="text-danger"></small>
                                </div>
                            </div>

                            <!-- Hidden fields -->
                            <input type="hidden" name="created_by" id="created_by" value="{{ auth()->user()->id ?? 1 }}">
                            <input type="hidden" name="updated_by" id="updated_by" value="{{ auth()->user()->id ?? 1 }}">

                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="organization_id" id="organization_id">
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
    <script src="{{ asset('/assets/js/custom/v1/custom.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/v2/organization.js') }}"></script>
    <script>
        const message_edit = "Edit";
        const message_delete = "Delete";

        // Initialize DataTable when document is ready
        $(document).ready(function() {
            console.log('Initializing organization DataTable...');
            console.log('Base URL:', url);
            organization_list();
        });

        $(document).on('submit', '#organization_form', function (e) {
            e.preventDefault();
            
            // Check if organization_id has a value to determine if it's an edit or add operation
            let organization_id = $('#organization_id').val();
            
            if (organization_id && organization_id !== '') {
                // Edit operation
                organization_update();
            } else {
                // Add operation
                organization_save();
            }
        });

    </script>
@endsection 