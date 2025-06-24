@extends('layouts.admin')

@section('title','Organization')


@section('main-content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">অফিসের তালিকা</h4>
                            <a href="javascript:void(0)" onclick="add_organization()" class="btn btn-primary btn-xs
                            float-right"><i
                                    class="fas fa-plus"></i>
                                যোগ
                                করুন</a>
                        </div>


                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered dt-responsive nowrap organization_table"
                                    id="organization_table">
                                    <thead>
                                    <tr>
                                        <th>নং</th>
                                        <th>অফিস কোড</th>
                                        <th width="20%">অফিসের নাম</th>
                                        <th width="10%">অফিসের ধরন</th>
                                        <th width="20%">কর্মকর্তার নাম</th>
                                        <th width="20%">ইউজারনেম</th>
                                        <th>মোবাইল</th>
                                        <th>ঠিকানা</th>
                                        <th width="10%">অ্যাকশন</th>
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


        <!-- Organizatio modal --->
        <!-- Modal -->
        <div class="modal fade" id="organization_modal" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 137%;left: -43px">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">যোগ করুন</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:void(0)" method="post" id="organization_form" onsubmit="organization_save
                    ()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">অফিসের নাম <span class="text-danger">*</span> </label>
                                        <input class="form-control form-control-sm" name="org_name" id="org_name"
                                               placeholder="অফিসের নাম প্রদান করুন" required=""
                                               data-parsley-required-message="অফিসের নাম প্রদান করুন">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">অফিসের কোড <span class="text-danger">*</span> </label>
                                        <input class="form-control form-control-sm" name="org_code" id="org_code"
                                               placeholder="অফিসের কোড প্রদান করুন" required=""
                                               data-parsley-type="number"
                                               data-parsley-required-message="অফিসের কোড প্রদান করুন"
                                               data-parsley-type-message="সঠিক অফিসের কোড প্রদান করুন">
                                        <span class="text-danger" id="org_code_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="upazila_id">অফিসের ধরণ <span class="text-danger">*</span> </label>
                                        <select class="form-control form-control-sm" name="org_type" id="org_type"
                                                required=""
                                                data-parsley-required-message="অফিসের ধরণ নির্বাচন করুন">
                                            <option value="">নির্বাচন করুন</option>
                                            <option value="1">জেলা প্রশাসক</option>
                                            <option value="2">পৌরসভা</option>
                                            <option value="3">উপজেলা</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="org_address">অফিসের ঠিকানা </label>
                                        <input class="form-control form-control-sm" name="org_address" id="org_address"
                                               placeholder="অফিসের ঠিকানা  প্রদান করুন">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="employee_name">কর্মকর্তার নাম <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control form-control-sm" name="employee_name"
                                               id="employee_name"
                                               placeholder="কর্মকর্তার নাম প্রদান করুন" required=""
                                               data-parsley-required-message="কর্মকর্তার নাম প্রদান করুন">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="designation_id"> পদবী <span class="text-danger">*</span> </label>
                                        <select class="form-control form-control-sm" name="designation_id"
                                                id="designation_id" required=""
                                                data-parsley-required-message="পদবী নির্বাচন করুন">
                                            <option value="">পদবী নির্বাচন করুন</option>
                                            @foreach($designations as $item)
                                                <option value="{{ $item->id  }}">{{ $item->name  }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mobile_no">মোবাইল নং </label>
                                        <input class="form-control form-control-sm" name="mobile_no" id="mobile_no"
                                               placeholder="মোবাইল নাম্বার প্রদান করুন" data-parsley-mobilenumber="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="username">ইউজারনেম <span class="text-danger">*</span> </label>
                                        <input class="form-control form-control-sm" name="username" id="username"
                                               placeholder="ইউজারনেম প্রদান করুন" required=""
                                               data-parsley-required-message="ইউজারনেম প্রদান করুন">
                                        <span class="text-danger" id="username_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="password">পাসওয়ার্ড <span class="text-danger">*</span> </label>
                                        <input type="password" class="form-control form-control-sm" name="password"
                                               id="password"
                                               placeholder="পাসওয়ার্ড প্রদান করুন" required=""
                                               data-parsley-required-message="পাসওয়ার্ড প্রদান করুন">
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="org_id" id="org_id">
                            <input type="hidden" name="employee_id" id="employee_id">
                            <input type="hidden" name="user_id" id="user_id">
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
    <script src="{{ asset('/assets/js/custom/organization.js') }}"></script>

    <script>
        organization_list();
    </script>

@endsection
