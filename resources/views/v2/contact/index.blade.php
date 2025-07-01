@extends('layouts.admin')

@section('title', 'Contact Management')

@section('main-content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">@lang('message.contact-list')</h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="contact_table">
                                    <thead>
                                    <tr>
                                        <th>@lang('message.no')</th>
                                        <th>@lang('message.org_code')</th>
                                        <th>@lang('message.name')</th>
                                        <th>@lang('message.email')</th>
                                        <th>@lang('message.message')</th>
                                        <th>@lang('message.created-At')</th>
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

    </div>
@endsection

@section('js')
    <script src="{{ asset('/assets/js/custom/v2/contact.js') }}"></script>
    <script>

        // Initialize DataTable when document is ready
        $(document).ready(function() {
            console.log('Initializing notice DataTable...');
            console.log('Base URL:', url);
            notice_list();
        });

    </script>
@endsection 