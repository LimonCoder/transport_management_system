@extends('layouts.admin')

@section('title', __('message.driver_title'))

@section('main-content')
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="float-left">@lang('message.driver_list_title')</h4>
                        <a href="javascript:void(0)" onclick="add_driver()" class="btn btn-primary btn-xs float-right">
                            <i class="fas fa-plus"></i> @lang('message.add')
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="driver_table">
                                <thead>
                                    <tr>
                                        <th>@lang('message.no')</th>
                                        <th>@lang('message.name')</th>
                                        <th>@lang('message.license_number')</th>
                                        <th>@lang('message.mobile')</th>
                                        <th>@lang('message.username')</th>
                                        <th>@lang('message.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic Data -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="driver_modal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="driverModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="driver_form" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="driverModalLabel">@lang('message.add_driver')</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body row">
                        <!-- Name -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">@lang('message.name') <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control form-control-sm" required>
                                <small id="name_error" class="text-danger"></small>
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="col-sm-6" id="userName">
                            <div class="form-group">
                                <label for="username">@lang('message.username') <span class="text-danger">*</span></label>
                                <input type="text" name="username" id="username" class="form-control form-control-sm" required readonly>
                                <small id="username_error" class="text-danger"></small>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-sm-6" id="passwordHide">
                            <div class="form-group">
                                <label for="password">@lang('message.password') <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control form-control-sm" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" onclick="togglePassword()">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <small id="password_error" class="text-danger"></small>
                            </div>
                        </div>

                        <!-- License Number -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="license_number">@lang('message.license_number')</label>
                                <input type="text" name="license_number" id="license_number" class="form-control form-control-sm">
                                <small id="license_number_error" class="text-danger"></small>
                            </div>
                        </div>

                        <!-- Mobile Number -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="mobile_number">@lang('message.mobile')</label>
                                <input type="text" name="mobile_number" id="mobile_number" class="form-control form-control-sm">
                                <small id="mobile_number_error" class="text-danger"></small>
                            </div>
                        </div>


                        <!-- Date of Joining -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="date_of_joining">@lang('message.date_of_joining')</label>
                                <input type="date" name="date_of_joining" id="date_of_joining" class="form-control form-control-sm">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="address">@lang('message.address')</label>
                                <textarea name="address" id="address" rows="2" class="form-control form-control-sm"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="driver_id" id="driver_id">
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
<script src="{{ asset('/assets/js/custom/v2/driver.js') }}"></script>

<script>
    const message_edit = "{{ __('message.edit') }}";
    const message_delete = "{{ __('message.delete') }}";

    driver_list();

    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }

     document.getElementById('name').addEventListener('input', function () {
            const name = this.value;
            const slug = name
                .toLowerCase()
                .replace(/[^\u0980-\u09FF\w\s-]/g, '') // allow Bangla + English + digits
                .replace(/\s+/g, '-')                 // spaces to dashes
                .replace(/-+/g, '-')                  // collapse multiple dashes
                .trim();
            document.getElementById('username').value = slug;
        });

        $(document).on('submit', '#driver_form', function (e) {
            e.preventDefault();
            driver_save();
        });

</script>
@endsection