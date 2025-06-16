@extends('layouts.admin')

@section('title','Log_book')


@section('main-content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">
                                লগ বইয়ের রিপোর্ট</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="vehicle_reg_no"> তারিখ(হতে)<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control form-control-sm" id="from_date" placeholder=" তারিখ প্রদান করুন">
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
                                    <button id="log_book_report" type="submit" class="btn btn-primary btn-block"
                                            style="margin-top:
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
        $(function () {
            $("#from_date").datepicker({dateFormat: 'yy-mm-dd'});
            $("#to_date").datepicker({dateFormat: 'yy-mm-dd'});
        });

        let log_book_url = '{{ route("report.log_book_report_print") }}';
        $('#log_book_report').click(function() {

            if($("#from_date").val() == "" || $("#to_date").val() == "" )
            {
                swal.fire('সঠিক করে সিলেক্ট করুন।','','error');
                return false;
            }
            window.open(log_book_url +'/' + $("#from_date").val() +'/' + $("#to_date").val(), '_blank');
        });
    </script>
@endsection
