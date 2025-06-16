@extends('layouts.admin')

@section('title','Repairs')


@section('main-content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">যন্ত্রাংশ রিপোর্ট</h4>
                        </div>
                        <div class="card-body">
                            <form method="get" action="{{route('report.repairs_report_print')}}" target="_blank">
                                <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="vehicle_reg_no"> গাড়ির নং <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control form-control-sm" name="vehicle_reg_no"
                                                id="vehicle_reg_no">
                                            <option value="">গাড়ির নং নির্বাচন করুন</option>
                                            @foreach($vehicle as $item)<option
                                                value="{{$item->vehicle_reg_no}}">{{$item->vehicle_reg_no}} |{{$item->driver_name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="date"> তারিখ(হতে)<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control form-control-sm" name="from_date" id="from_date" required placeholder=" তারিখ প্রদান করুন">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="to_date"> তারিখ(পর্যন্ত)<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control form-control-sm" name="to_date" id="to_date" required  placeholder=" তারিখ প্রদান করুন">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary btn-block"
                                            style="margin-top:
                                        25px"><i
                                            class=" fas
                                            fa-print" style="font-size: 18px;" ></i>
                                    </button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->

    </div>

@endsection
{{--@section('js')--}}
{{--    <script>--}}

{{--        let repairs_url = '{{ route("report.repairs_report_print") }}';--}}

{{--        $('#repairs_report').click(function() {--}}

{{--            if($("#vehicle_reg_no").val() == "")--}}
{{--            {--}}
{{--                swal.fire('সঠিক করে সিলেক্ট করুন।','','error');--}}
{{--                return false;--}}
{{--            }--}}
{{--            window.open(repairs_url +'/' + $("#vehicle_reg_no").val(), '_blank');--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}

@section('js')
    <script>
        $(function () {
            $("#from_date").datepicker({dateFormat: 'yy-mm-dd'});
            $("#to_date").datepicker({dateFormat: 'yy-mm-dd'});
        });

        {{--let repairs_report = '{{ route("report.repairs_report_print") }}';--}}
        {{--$('#repairs_report').click(function() {--}}

        {{--    if($("#from_date").val() == "" || $("#to_date").val() == "")--}}
        {{--    {--}}
        {{--        swal.fire('সঠিক করে সিলেক্ট করুন।','','error');--}}
        {{--        return false;--}}
        {{--    }--}}
        {{--    window.open(repairs_report +'/' +$("#vehicle_reg_no").val() +'/' + $("#from_date").val() +'/' + $("#to_date")--}}
        {{--        .val(),'_blank');--}}
        {{--});--}}
    </script>
@endsection
