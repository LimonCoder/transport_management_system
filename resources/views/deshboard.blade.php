@extends('layouts.admin')

@section('title','Deshboard')


@section('main-content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">
                @if(Auth::user()->user_type == 2)
                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>

                            </div>

                            <h4 class="header-title mt-0 mb-4">মোট গাড়ি রেজিস্ট্রেশন
                            </h4>

                            <div class="widget-chart-1">

                                <div class="widget-detail-1 text-right">
                                    <h2 class="font-weight-normal pt-2 mb-1"> {{ $bnConverter->bnNum($total_vehicle) }} </h2>
                                </div>

                                <div class="progress progress-bar-alt-success progress-sm">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 50%;">
                                        <span class="sr-only">50% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- end col -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>

                            </div>

                            <h4 class="header-title mt-0 mb-4">মোট অকেজো গাড়ি </h4>

                            <div class="widget-chart-1">

                                <div class="widget-detail-1 text-right">
                                    <h2 class="font-weight-normal pt-2 mb-1"> {{ $bnConverter->bnNum($useless_total_vehicle) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-info progress-sm">
                                    <div class="progress-bar bg-info" role="progressbar"
                                         aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 30%;">
                                        <span class="sr-only">30% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>

                            <h4 class="header-title mt-0 mb-4">মোট কর্মকর্তা</h4>

                            <div class="widget-chart-1">
                                <div class="widget-detail-1 text-right">
                                    <h2 class="font-weight-normal pt-2 mb-1"> {{ $bnConverter->bnNum($total_employee) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-pink progress-sm">
                                    <div class="progress-bar bg-pink" role="progressbar"
                                         aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 77%;">
                                        <span class="sr-only">77% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>

                            <h4 class="header-title mt-0 mb-4">মোট ড্রাইভার</h4>

                            <div class="widget-chart-1">
                                <div class="widget-detail-1 text-right">
                                    <h2 class="font-weight-normal pt-2 mb-1"> {{ $bnConverter->bnNum($total_driver) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-gray progress-sm">
                                    <div class="progress-bar bg-gray" role="progressbar"
                                         aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 77%;">
                                        <span class="sr-only">77% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>

                            <h4 class="header-title mt-0 mb-4">মোট যন্ত্রাংশ খরচ </h4>

                            <div class="widget-chart-1">
                                <div class="widget-detail-1 text-right">
                                    <h2 class="font-weight-normal pt-2 mb-1"> {{ $bnConverter->bnCommaLakh($repairs_total_cost) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-secondary progress-sm">
                                    <div class="progress-bar bg-secondary" role="progressbar"
                                         aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 77%;">
                                        <span class="sr-only">77% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>

                            <h4 class="header-title mt-0 mb-4">মোট লুব্রিক্যান্ট খরচ</h4>

                            <div class="widget-chart-1">
                                <div class="widget-detail-1 text-right">
                                    <h2 class="font-weight-normal pt-2 mb-1"> {{ $bnConverter->bnCommaLakh($lubricant_total_cost) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-warning progress-sm">
                                    <div class="progress-bar bg-warning" role="progressbar"
                                         aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 77%;">
                                        <span class="sr-only">77% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- end col -->


                @else

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>

                            <h4 class="header-title mt-0 mb-3">মোট অফিস</h4>

                            <div class="widget-box-2">
                                <div class="widget-detail-2 text-right">
                                    <h2 class="font-weight-normal mb-1"> {{ $bnConverter->bnNum($total_org) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-success progress-sm">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 77%;">
                                        <span class="sr-only">77% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>

                            <h4 class="header-title mt-0 mb-3">মোট গাড়ি রেজিস্ট্রেশন</h4>

                            <div class="widget-box-2">
                                <div class="widget-detail-2 text-right">
                                    <h2 class="font-weight-normal mb-1"> {{ $bnConverter->bnNum($grand_total_vehicle) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-gray progress-sm">
                                    <div class="progress-bar bg-gray" role="progressbar"
                                         aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 77%;">
                                        <span class="sr-only">77% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>

                            <h4 class="header-title mt-0 mb-3">মোট ড্রাইভার</h4>

                            <div class="widget-box-2">
                                <div class="widget-detail-2 text-right">
                                    <h2 class="font-weight-normal mb-1"> {{ $bnConverter->bnNum($grand_total_driver) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-warning progress-sm">
                                    <div class="progress-bar bg-warning" role="progressbar"
                                         aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 77%;">
                                        <span class="sr-only">77% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>

                            <h4 class="header-title mt-0 mb-3">মোট অকেজো গাড়ি</h4>

                            <div class="widget-box-2">
                                <div class="widget-detail-2 text-right">
                                    <h2 class="font-weight-normal mb-1"> {{ $bnConverter->bnNum($grand_useless_total_vehicle) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-info progress-sm">
                                    <div class="progress-bar bg-info" role="progressbar"
                                         aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 77%;">
                                        <span class="sr-only">77% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- end col -->

                @endif
            </div>
            <!-- end row -->



        </div> <!-- container-fluid -->

    </div>
@endsection
