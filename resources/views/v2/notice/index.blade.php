@extends('layouts.admin')

@section('title', 'Notice Management')

@section('main-content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">@lang('message.notice-list')</h4>
                            <a href="javascript:void(0)" onclick="add_notice()" class="btn btn-primary btn-xs float-right">
                                <i class="fas fa-plus"></i> @lang('message.add')
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="notice_table">
                                    <thead>
                                    <tr>
                                        <th>@lang('message.no')</th>
                                        <th>@lang('message.title')</th>
                                        <th>@lang('message.details')</th>
                                        <th>@lang('message.status')</th>
                                        <th>@lang('message.created-At')</th>
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
        <div class="modal fade" id="notice_modal" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="noticeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <form id="notice_form" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="noticeModalLabel">@lang('message.add-notice')</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body row">
                            <!-- Title -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="title">@lang('message.notice-title')<span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control form-control-sm" required maxlength="150" placeholder="Enter notice title">
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="details">@lang('message.details')<span class="text-danger">*</span></label>
                                    <textarea name="details" id="details" class="form-control form-control-sm" required rows="4" placeholder="Enter notice details"></textarea>
                                </div>
                            </div>

                            <!-- Hidden fields - org_code will be set automatically from Auth::user()->org_code -->
                            <input type="hidden" name="org_code" id="org_code" value="{{ auth()->user()->org_code ?? '' }}">
                            <input type="hidden" name="created_by" id="created_by" value="{{ auth()->user()->id ?? 1 }}">
                            <input type="hidden" name="updated_by" id="updated_by" value="{{ auth()->user()->id ?? 1 }}">

                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="notice_id" id="notice_id">
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
    <script src="{{ asset('/assets/js/custom/v2/notice.js') }}"></script>
    <script>
        const message_edit = "Edit";
        const message_delete = "Delete";

        // Initialize DataTable when document is ready
        $(document).ready(function() {
            console.log('Initializing notice DataTable...');
            console.log('Base URL:', url);
            notice_list();
        });

        $(document).on('submit', '#notice_form', function (e) {
            e.preventDefault();
            
            // Check if notice_id has a value to determine if it's an edit or add operation
            let notice_id = $('#notice_id').val();
            
            if (notice_id && notice_id !== '') {
                // Edit operation
                notice_update();
            } else {
                // Add operation
                notice_save();
            }
        });

    </script>
@endsection 