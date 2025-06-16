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
                        <h4 class="float-left">যন্ত্রাংশের তালিকা</h4>
                        <a href="javascript:void(0)" onclick="add_repair()" class="btn btn-primary btn-xs
                    float-right"><i class="fas fa-plus"></i>
                            যোগ
                            করুন</a>
                    </div>


                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive nowrap repairs_table" id="repairs_table">
                                <thead>
                                    <tr>
                                        <th>নং</th>
                                        <th>তারিখ </th>
                                        <th>গাড়ির নং</th>
                                        <th>কর্মকর্তার নাম</th>
                                        <th>ড্রাইভারের নাম</th>
                                        <th>নষ্ট যন্ত্রাংশ</th>
                                        <th>নতুন যন্ত্রাংশ</th>
                                        <th>যন্ত্রাংশের দোকান / সার্ভিস সেন্টার</th>
                                        <th>খরচের পরিমাণ</th>
                                        <th>সমস্যার কারন</th>
                                        <th>অ্যাকশন</th>
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


    <!-- repairs modal --->
    <!-- Modal -->
    <div class="modal fade" id="repairs_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 137%;left: -43px">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">যোগ করুন</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:void(0)" method="post" id="repairs_form" onsubmit="repair_save()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="insert_date">তারিখ <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control form-control-sm" name="insert_date" id="insert_date" placeholder="তারিখ প্রদান করুন" required="" data-parsley-required-message="তারিখ প্রদান করুন">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="vehicle_id">গাড়ির নং <span class="text-danger">*</span> </label>
                                    <select class="form-control form-control-sm" name="vehicle_id" id="vehicle_id" required="" data-parsley-required-message="গাড়ির নং নির্বাচন করুন">
                                        <option value="">গাড়ির নং নির্বাচন করুন</option>
                                        @foreach($vehicle_setup as $item)
                                        <option value="{{$item->id}}">{{$item->vehicle_reg_no}}|{{$item->driver_info->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="employee_id">কর্মকর্তার নাম <span class="text-danger">*</span> </label>
                                    <select class="form-control form-control-sm" name="employee_id" id="employee_id" required="" data-parsley-required-message="কর্মকর্তার নাম নির্বাচন করুন">
                                        <option value="">কর্মকর্তা নির্বাচন করুন</option>
                                        @foreach($employees as $item)
                                            <option value="{{$item->id}}">{{$item->name}}| {{
                                                $item->designation->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="cause_of_problems">মেরামতের যন্ত্রাংশ <span class="text-danger">*</span> </label>
                                    <textarea class="form-control form-control-sm" name="cause_of_problems" id="cause_of_problems" placeholder="সমস্যার কারন প্রদান করুন" required="" data-parsley-required-message="সমস্যার কারন প্রদান করুন"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="damage_parts">নষ্ট যন্ত্রাংশ <span class="text-danger">*</span> </label>
                                    <input class="form-control form-control-sm" name="damage_parts" id="damage_parts" required="" placeholder="নষ্ট যন্ত্রের নাম প্রদান করুন" data-parsley-required-message="নষ্ট যন্ত্রের নাম প্রদান করুন">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="new_parts">নতুন যন্ত্রাংশ <span class="text-danger">*</span> </label>
                                    <input class="form-control form-control-sm" name="new_parts" id="new_parts" required="" placeholder="নতুন যন্ত্রের নাম প্রদান করুন" data-parsley-required-message="নতুন যন্ত্রের নাম প্রদান করুন">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="shop_name"> ক্রয়কৃত যন্ত্রাংশের দোকান / সার্ভিস সেন্টারে নাম <span class="text-danger">*</span> </label>
                                    <input class="form-control form-control-sm" name="shop_name" id="shop_name" required="" placeholder="ক্রয়কৃত যন্ত্রাংশের দোকান / সার্ভিস সেন্টারে নাম প্রদান করুন" data-parsley-required-message="ক্রয়কৃত যন্ত্রাংশের দোকান / সার্ভিস সেন্টারে নাম প্রদান করুন">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="total_cost">খরচের পরিমাণ <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control form-control-sm" name="total_cost" id="total_cost" placeholder="মোট খরচের পরিমান প্রদান করুন" required="" data-parsley-type="number" data-parsley-required-message="মোট খরচের পরিমান প্রদান করুন" data-parsley-type-message="সঠিক পরিমান প্রদান করুন">
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                            <input type="hidden" name="repairs_id" id="repairs_id">
                            <input type="hidden" name="row_id" id="row_id" value="" >
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
<script src="{{ asset('/assets/js/custom/repairs.js') }}"></script>
<script>
    repairs_list();
    $("#insert_date").datepicker({dateFormat: 'yy-mm-dd'});
</script>

@endsection
