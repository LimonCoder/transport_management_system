@extends('layouts.admin')

@section('title','Useless')


@section('main-content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">অকেজো গাড়ির রিপোর্ট</h4>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="vehicle_reg_no"> তারিখ(হতে)<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control form-control-sm" id="from_date"
                                                   placeholder=" তারিখ প্রদান করুন">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="vehicle_reg_no"> তারিখ(পর্যন্ত)<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control form-control-sm" id="to_date" placeholder=" তারিখ প্রদান করুন">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit" id="useless_report" class="btn btn-info btn-block" style="margin-top:
                                        25px"><i
                                                class=" fas
                                            fa-print" style="font-size: 18px;" ></i>
                                        </button>
                                    </div>
                                </div>
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

        let useless_url = '{{ route("report.useless_report_print") }}';
        $('#useless_report').click(function() {

            if($("#from_date").val() == "" || $("#to_date").val() == "" )
            {
                swal.fire('সঠিক করে সিলেক্ট করুন।','','error');
                return false;
            }
            window.open(useless_url +'/' + $("#from_date").val() +'/' + $("#to_date").val(),'_blank');
        });
    </script>
@endsection
