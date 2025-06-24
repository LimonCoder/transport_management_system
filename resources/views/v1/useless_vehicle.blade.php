@extends('layouts.admin')

@section('title','Useless-Vehicle')


@section('main-content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">অকেজো যানবাহনের তালিকা</h4>
                        </div>


                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered dt-responsive nowrap  unuseless_vehicle"
                                    id="unuseless_vehicle">
                                    <thead>
                                    <tr>
                                        <th width="5%">নং</th>
                                        <th width="5%">ছবি</th>
                                        <th width="10%">গাড়ির নং</th>
                                        <th width="10%">বডি টাইপ</th>
                                        <th width="10%">চেসিস নং</th>
                                        <th width="10%">ইন্জিন নং</th>
                                        <th width="10%"> অকেজোর তারিখ</th>
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
            <!-- end row -->


        </div> <!-- container-fluid -->

    </div>

@endsection

@section('js')
    <script src="{{ asset('/assets/js/custom/vehicle.js') }}"></script>

    <script>

        $(function () {
            unuseless_vehicle_list();

        });
    </script>

@endsection
