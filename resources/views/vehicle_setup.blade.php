@extends('layouts.admin')

@section('title','Vehicle')


@section('main-content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">যানবাহনের তালিকা</h4>
                            @if(\Illuminate\Support\Facades\Auth::user()->type == 2)
                                <a href="javascript:void(0)" onclick="add_vehicle()" class="btn btn-primary btn-xs
                            float-right"><i
                                        class="fas fa-plus"></i>
                                    যোগ
                                    করুন</a>

                            @endif
                        </div>


                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered dt-responsive nowrap vehicle_table"
                                    id="vehicle_table">
                                    <thead>
                                    <tr>
                                        <th width="5%">নং</th>
                                        <th width="5%">ছবি</th>
                                        <th width="10%">কর্মকর্তার নাম</th>
                                        <th width="10%">কর্মকর্তার পদবী</th>
                                        <th width="10%">ড্রাইভারের নাম</th>
                                        <th width="10%">গাড়ির নং</th>
                                        <th width="10%">বডি টাইপ</th>
                                        <th width="10%">চেসিস নং</th>
                                        <th width="10%">ইন্জিন নং</th>
                                        <th width="10%">বরাদ্দ প্রাপ্তির তারিখ</th>
                                        <th width="20%">অ্যাকশন</th>
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


        <!-- Vehicle modal --->
        <div class="modal fade" id="vehicle_modal" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 137%;left: -43px">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">যোগ করুন</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:void(0)" method="post" id="vehicle_form" onsubmit="vehicle_save
                    ()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="employee_id">কর্মকর্তার নাম <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control form-control-sm" name="employee_id"
                                                id="employee_id" required=""
                                                data-parsley-required-message="কর্মকর্তার নাম প্রদান করুন">
                                            <option value="">সিলেক্ট করুন</option>
                                            @foreach($employees as $item )
                                                <option value="{{ $item->id  }}">{{ $item->name  }}</option>
                                            @endforeach
                                        </select>


                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="driver_id">ড্রাইভারের নাম <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control form-control-sm" name="driver_id"
                                                id="driver_id" required=""
                                                data-parsley-required-message="ড্রাইভারের নাম প্রদান করুন">
                                            <option value="">সিলেক্ট করুন</option>
                                            @foreach($drivers as $item )
                                                <option value="{{ $item->id  }}">{{ $item->name  }}</option>
                                            @endforeach
                                        </select>


                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="vehicle_reg_no ">গাড়ি রেজিস্ট্রেশন নং <span
                                                class="text-danger">*</span> </label>
                                        <input class="form-control form-control-sm" name="vehicle_reg_no"
                                               id="vehicle_reg_no" required=""
                                               data-parsley-required-message="গাড়ি রেজিস্ট্রেশন নং প্রদান করুন"
                                               placeholder="গাড়ি রেজিস্ট্রেশন নং প্রদান করুন">
                                        <span class="text-danger" id="vehicle_reg_no_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="body_type">গাড়ির ধরন </label>
                                        <input class="form-control form-control-sm" name="body_type" id="body_type"
                                               placeholder="বডির ধরন প্রদান করুন"
                                        >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="chassis_no">চেসিস নং </label>
                                        <input type="text" class="form-control form-control-sm" name="chassis_no"
                                               id="chassis_no"
                                               placeholder="চেসিস নং প্রদান করুন">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="engine_no">ইন্জিন নং </label>
                                        <input type="text" class="form-control form-control-sm" name="engine_no"
                                               id="engine_no"
                                               placeholder="ইন্জিন নং প্রদান করুন">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="develop_year">তৈরী সন </label>
                                        <input type="text" class="form-control form-control-sm" name="develop_year"
                                               id="develop_year"
                                               placeholder="তৈরী সন প্রদান করুন">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="fitness_duration">ফিটনেস মেয়াদ </label>
                                        <input type="text" class="form-control form-control-sm" name="fitness_duration"
                                               id="fitness_duration"
                                               placeholder="ফিটনেস মেয়াদ প্রদান করুন">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="tax_token_duration">ট্যাক্স টোকেন মেয়াদ </label>
                                        <input type="text" class="form-control form-control-sm"
                                               name="tax_token_duration"
                                               id="tax_token_duration"
                                               placeholder="ট্যাক্স টোকেন মেয়াদ প্রদান করুন">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="assignment_date">বরাদ্দ প্রাপ্তির তারিখ </label>
                                        <input type="text" class="form-control form-control-sm" name="assignment_date"
                                               id="assignment_date"
                                               placeholder="বরাদ্দ প্রাপ্তির তারিখ প্রদান করুন">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">ছবি: </label>
                                    <div class="col-md-9">

                                        <div class="row" id="picture_input1">
                                            <div class="col-sm-6">
                                                <input class="form-control-file picture" type="file" name="picture[]"
                                                       data-pi_no="1" onchange="inputImageShow(this)" accept="image/*">
                                            </div>
                                            <div class="col-md-4">
                                                <img class="d-none image_preview" id="image_preview1"
                                                     style="height:50px; width:80px; border-radious: 5px;">
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" class="btn btn-sm btn-primary"
                                                        onclick="addInputPictures()"
                                                ><i class="fa
                                                fa-plus"></i></button>
                                            </div>
                                        </div>

                                        <div class="picture_inputs"></div>

                                        <div class="d-none" id="previous_images" >

                                            <img src="storage/app/public/vehicles/default.png" width="50" height="50">
                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="row_id" id="row_id" value="" >
                            <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success btn-xs">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Useless modal -->
        <div class="modal fade" id="useless_vehicle_modal" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">যোগ করুন</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:void(0)" method="post" id="useless_vehicle_form"
                          onsubmit="useless_vehicle_save
                    ()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">অকেজোর তারিখ  <span class="text-danger">*</span> </label>
                                        <input class="form-control form-control-sm" name="useless_date" id="useless_date"
                                               placeholder="অকেজোর তারিখ  প্রদান করুন" required=""
                                               data-parsley-required-message="অকেজোর তারিখ প্রদান করুন" >
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="vehicle_id" id="vehicle_id" >
                            <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success btn-xs">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('js')
    <script src="{{ asset('/assets/js/custom/vehicle.js') }}"></script>

    <script>

        $(function () {
            vehicle_list();
            $("#assignment_date").datepicker({dateFormat: 'yy-mm-dd'});
            $("#useless_date").datepicker({dateFormat: 'yy-mm-dd'});
        });
    </script>

@endsection
