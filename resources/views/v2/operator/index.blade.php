@extends('layouts.admin')

@section('title', __('message.operator_title'))

@section('main-content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">@lang('message.list_title')</h4>
                            <a href="javascript:void(0)" onclick="add_operator()" class="btn btn-primary btn-xs float-right">
                                <i class="fas fa-plus"></i> @lang('message.add')
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="operator_table">
                                    <thead>
                                    <tr>
                                        <th>@lang('message.no')</th>
                                        <th>@lang('message.name')</th>
                                        <th>@lang('message.designation')</th>
                                        <th>@lang('message.mobile')</th>
                                        <th>@lang('message.user')</th>
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
        <div class="modal fade" id="operator_modal" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="operatorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="operator_form" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="operatorModalLabel">@lang('message.add_operator')</h5>
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

                            <!-- Username (auto-generated slug, readonly) -->
                            <div class="col-sm-6" id="userName">
                                <div class="form-group">
                                    <label for="username">@lang('message.username')</label>
                                    <input type="text" name="username" id="username" class="form-control form-control-sm" readonly>
                                    <small id="username_error" class="text-danger"></small>
                                </div>
                            </div>


                            <!-- Designation -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="designation">@lang('message.designation')</label>
                                    <input type="text" name="designation" id="designation" class="form-control form-control-sm">
                                    <small id="designation_error" class="text-danger"></small>
                                </div>
                            </div>

                            <!-- Date of Joining -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="date_of_joining">@lang('message.date_of_joining')</label>
                                    <input type="date" name="date_of_joining" id="date_of_joining" class="form-control form-control-sm">
                                </div>
                            </div>

                            <!-- Mobile -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="mobile_number">@lang('message.mobile')</label>
                                    <input type="text" name="mobile_number" id="mobile_number" class="form-control form-control-sm">
                                    <small id="mobile_number_error" class="text-danger"></small>
                                </div>
                            </div>
                            <!-- Password with show/hide -->
                            <div class="col-sm-6" id="passwordHide">
                                <div class="form-group">
                                    <label for="password">@lang('message.password')</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control form-control-sm">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-outline-secondary" type="button" onclick="togglePassword()">
                                                <i class="fas fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
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
                            <input type="hidden" name="operator_id" id="operator_id">
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
    <script src="{{ asset('/assets/js/custom/v2/operator.js') }}"></script>
    <script>
        const message_edit = "{{ __('message.edit') }}";
        const message_delete = "{{ __('message.delete') }}";

        operator_list();

        function togglePassword() {
            const pwd = document.getElementById('password');
            pwd.type = pwd.type === 'password' ? 'text' : 'password';
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
        $(document).on('submit', '#operator_form', function (e) {
            e.preventDefault();
            operator_save();
        });
    </script>
@endsection
