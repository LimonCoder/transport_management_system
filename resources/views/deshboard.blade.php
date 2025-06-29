@extends('layouts.admin')

@section('title','Deshboard')

@section('main-content')
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                @if(Auth::user()->user_type == 'system-admin')
                    <!-- System Admin Dashboard -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>
                            <h4 class="header-title mt-0 mb-4">মোট অফিস</h4>
                            <div class="widget-chart-1">
                                <div class="widget-detail-1 text-right">
                                    <h2 class="font-weight-normal pt-2 mb-1"> {{ $bnConverter->bnNum($total_organizations) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-success progress-sm">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 100%;">
                                        <span class="sr-only">100% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                    <h2 class="font-weight-normal pt-2 mb-1"> {{ $bnConverter->bnNum($total_drivers) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-info progress-sm">
                                    <div class="progress-bar bg-info" role="progressbar"
                                         aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 85%;">
                                        <span class="sr-only">85% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>
                            <h4 class="header-title mt-0 mb-4">মোট অপারেটর</h4>
                            <div class="widget-chart-1">
                                <div class="widget-detail-1 text-right">
                                    <h2 class="font-weight-normal pt-2 mb-1"> {{ $bnConverter->bnNum($total_operators) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-pink progress-sm">
                                    <div class="progress-bar bg-pink" role="progressbar"
                                         aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 70%;">
                                        <span class="sr-only">70% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>
                            <h4 class="header-title mt-0 mb-4">মোট গাড়ি</h4>
                            <div class="widget-chart-1">
                                <div class="widget-detail-1 text-right">
                                    <h2 class="font-weight-normal pt-2 mb-1"> {{ $bnConverter->bnNum($total_vehicles) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-warning progress-sm">
                                    <div class="progress-bar bg-warning" role="progressbar"
                                         aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 90%;">
                                        <span class="sr-only">90% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @elseif(Auth::user()->user_type == 'operator')
                    <!-- Operator Dashboard -->
                    <div class="col-xl-4 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>
                            <h4 class="header-title mt-0 mb-3">মোট ড্রাইভার</h4>
                            <div class="widget-box-2">
                                <div class="widget-detail-2 text-right">
                                    <h2 class="font-weight-normal mb-1"> {{ $bnConverter->bnNum($total_drivers_in_org) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-success progress-sm">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 85%;">
                                        <span class="sr-only">85% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>
                            <h4 class="header-title mt-0 mb-3">মোট গাড়ি</h4>
                            <div class="widget-box-2">
                                <div class="widget-detail-2 text-right">
                                    <h2 class="font-weight-normal mb-1"> {{ $bnConverter->bnNum($total_vehicles_in_org) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-info progress-sm">
                                    <div class="progress-bar bg-info" role="progressbar"
                                         aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 75%;">
                                        <span class="sr-only">75% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>
                            <h4 class="header-title mt-0 mb-3">মেইনটেনেন্স গাড়ি</h4>
                            <div class="widget-box-2">
                                <div class="widget-detail-2 text-right">
                                    <h2 class="font-weight-normal mb-1"> {{ $bnConverter->bnNum($total_maintenance_vehicles_in_org) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-warning progress-sm">
                                    <div class="progress-bar bg-warning" role="progressbar"
                                         aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 60%;">
                                        <span class="sr-only">60% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @elseif(Auth::user()->user_type == 'driver')
                    <!-- Driver Dashboard -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>
                            <h4 class="header-title mt-0 mb-3">মোট ট্রিপ</h4>
                            <div class="widget-box-2">
                                <div class="widget-detail-2 text-right">
                                    <h2 class="font-weight-normal mb-1"> {{ $bnConverter->bnNum($total_trips) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-success progress-sm">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 100%;">
                                        <span class="sr-only">100% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>
                            <h4 class="header-title mt-0 mb-3">শুরু করা ট্রিপ</h4>
                            <div class="widget-box-2">
                                <div class="widget-detail-2 text-right">
                                    <h2 class="font-weight-normal mb-1"> {{ $bnConverter->bnNum($total_initiate_trips) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-info progress-sm">
                                    <div class="progress-bar bg-info" role="progressbar"
                                         aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 70%;">
                                        <span class="sr-only">70% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>
                            <h4 class="header-title mt-0 mb-3">সম্পন্ন ট্রিপ</h4>
                            <div class="widget-box-2">
                                <div class="widget-detail-2 text-right">
                                    <h2 class="font-weight-normal mb-1"> {{ $bnConverter->bnNum($total_completed_trips) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-success progress-sm">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 85%;">
                                        <span class="sr-only">85% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>
                            <h4 class="header-title mt-0 mb-3">বাতিল ট্রিপ</h4>
                            <div class="widget-box-2">
                                <div class="widget-detail-2 text-right">
                                    <h2 class="font-weight-normal mb-1"> {{ $bnConverter->bnNum($total_rejected_trips) }} </h2>
                                </div>
                                <div class="progress progress-bar-alt-danger progress-sm">
                                    <div class="progress-bar bg-danger" role="progressbar"
                                         aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 15%;">
                                        <span class="sr-only">15% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @endif
            </div>
            <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
@endsection
