@extends('layouts.admin')

@section('title','RentalCar')


@section('main-content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">ভাড়ায় গাড়ির রিপোর্ট</h4>
                        </div>
                        <div class="card-body">
                            <form method="get" action="{{route('report.rentalcar_report_print')}}" target="_blank">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="rentalcar_form_Date"> তারিখ(হতে)<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control form-control-sm" name="from_date" id="from_date"
                                                   placeholder=" তারিখ প্রদান করুন">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="rentalcar_to_Date"> তারিখ(পর্যন্ত)<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control form-control-sm" name="to_date" id="to_date" placeholder=" তারিখ প্রদান করুন">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit" id="rentalcar_report" class="btn btn-info btn-block"
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

@section('js')
    <script>
        $("#from_date").datepicker({dateFormat: 'yy-mm-dd'});
        $("#to_date").datepicker({dateFormat: 'yy-mm-dd'});

        {{--let useless_url = '{{ route("report.rentalcar_report_print") }}';--}}
        {{--$('#rentalcar_report').click(function() {--}}

        {{--    if($("#from_date").val() == "" || $("#to_date").val() == "" )--}}
        {{--    {--}}
        {{--        swal.fire('সঠিক করে সিলেক্ট করুন।','','error');--}}
        {{--        return false;--}}
        {{--    }--}}
        {{--    window.open(useless_url +'/' + $("#from_date").val() +'/' + $("#to_date").val(),'_blank');--}}
        {{--});--}}
    </script>
@endsection
