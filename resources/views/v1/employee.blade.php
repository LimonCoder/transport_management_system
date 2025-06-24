@extends('layouts.admin')

@section('title','Employee')


@section('main-content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">কর্মকর্তার তালিকা</h4>
                            @if(\Illuminate\Support\Facades\Auth::user()->type != 3)
                                <a href="javascript:void(0)" onclick="add_employee()" class="btn btn-primary btn-xs
                            float-right"><i
                                        class="fas fa-plus"></i>
                                    যোগ
                                    করুন</a>
                            @endif
                        </div>


                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered dt-responsive nowrap employee_table"
                                    id="employee_table">
                                    <thead>
                                    <tr>
                                        <th width="10%">নং</th>
                                        <th width="15%">নাম</th>
                                        <th width="10%">পদবী</th>
                                        <th width="20%">মোবাইল নং</th>
                                        <th width="15%">ইউজারনেম</th>
                                        <th width="15%">ধরন</th>
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


        <!-- Organizatio modal --->
        <!-- Modal -->
        <div class="modal fade" id="employee_modal" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">যোগ করুন</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:void(0)" method="post" id="employee_form" onsubmit="employee_save
                    ()" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
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
                                        <label for="mobile_no">ইমেল </label>
                                        <input class="form-control form-control-sm" name="email" id="email"
                                               placeholder="ইমেল প্রদান করুন">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="username">ইউজারনেম <span class="text-danger">*</span> </label>
                                        <input class="form-control form-control-sm" name="username" id="username"
                                               placeholder="ইউজারনেম প্রদান করুন"
                                               data-parsley-required-message="ইউজারনেম প্রদান করুন">
                                        <span class="text-danger" id="username_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="password">পাসওয়ার্ড <span class="text-danger">*</span> </label>
                                        <input type="password" class="form-control form-control-sm" name="password"
                                               id="password"
                                               placeholder="পাসওয়ার্ড প্রদান করুন"
                                               data-parsley-required-message="পাসওয়ার্ড প্রদান করুন">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="picture">ছবি <span class="text-danger">*</span> </label>
                                        <input type="file" class="form-control form-control-sm" name="picture"
                                               id="picture"
                                               accept="image/*">
                                        <input type="hidden" name="previous_picture" id="previous_picture" value="">
                                        <img class="mt-2" src="default.png" id="image_preview" width="80" height="80">
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="modal-footer">
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
    <script src="{{ asset('/assets/js/custom/employee.js') }}"></script>
    <script>
        employee_list();
    </script>

@endsection
