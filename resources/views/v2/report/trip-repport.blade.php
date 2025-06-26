@extends('layouts.admin')

@section('title', __('message.trip_report_title'))

@section('main-content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">@lang('message.trip_report_title')</h4>
                        </div>
                        <div class="col-md-6 card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form id="tripReportFilterForm" action="{{ route('trip.report.print') }}" method="POST" class="mb-3">
                                @csrf
                                <div class="form-group">
                                    <label for="report_type">@lang('message.report_type')</label>
                                    <select class="form-control form-control-sm" id="report_type" name="report_type">
                                        <option value="month">@lang('message.monthly_report')</option>
                                        <option value="date">@lang('message.date_to_date_report')</option>
                                    </select>
                                </div>
                                <div class="form-group" id="monthPicker">
                                    <label for="month">@lang('message.select_month')</label>
                                    <input type="month" class="form-control form-control-sm" id="month" name="month">
                                </div>
                                <div class="form-group d-none" id="dateRangePicker">
                                    <label for="start_date">@lang('message.select_start_date')</label>
                                    <input type="date" class="form-control form-control-sm mb-1" id="start_date" name="start_date">
                                    <label for="end_date">@lang('message.select_end_date')</label>
                                    <input type="date" class="form-control form-control-sm" id="end_date" name="end_date">
                                </div>
                                <div class="form-group">
                                    <select class="form-control form-control-sm" id="driver_id" name="driver_id">
                                        <option value="">@lang('message.select_driver')</option>
                                        @foreach($drivers as $driver)
                                            <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control form-control-sm" id="route_id" name="route_id">
                                        <option value="">@lang('message.select_route')</option>
                                        @foreach($routes as $route)
                                            <option value="{{ $route->id }}">{{ $route->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-secondary btn-sm ml-1" id="resetBtn">@lang('message.reset')</button>
                                    <button type="submit" class="btn btn-info btn-sm ml-1" id="printBtn">@lang('message.print')</button>
                                </div>
                            </form>

                            <div id="printReportSection" class="d-none">
                                <h4 class="text-center">@lang('message.trip_report_title')</h4>
                                <!-- You can customize the print layout here -->
                                <div id="printReportContent"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$(function() {
    // Toggle month/date range picker
    $('#report_type').on('change', function() {
        if ($(this).val() === 'month') {
            $('#monthPicker').removeClass('d-none');
            $('#dateRangePicker').addClass('d-none');
        } else {
            $('#monthPicker').addClass('d-none');
            $('#dateRangePicker').removeClass('d-none');
        }
    });

});
</script>
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #printReportSection, #printReportSection * {
        visibility: visible;
    }
    #printReportSection {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        background: #fff;
        padding: 20px;
    }
}
</style>
@endsection