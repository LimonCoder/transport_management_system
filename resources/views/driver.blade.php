@extends('layouts.admin')

@section('title','Driver')


@section('main-content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">ড্রাইভারের তালিকা</h4>
                            @if(\Illuminate\Support\Facades\Auth::user()->type != 3)
                                <a href="javascript:void(0)" onclick="add_driver()" class="btn btn-primary btn-xs
                            float-right"><i
                                        class="fas fa-plus"></i>
                                    যোগ
                                    করুন</a>
                            @endif
                        </div>


                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered dt-responsive nowrap driver_table"
                                    id="driver_table">
                                    <thead>
                                    <tr>
                                        <th width="10%">নং</th>
                                        <th width="10%">ছবি</th>
                                        <th width="15%">নাম</th>
                                        <th width="20%">মোবাইল নং</th>
                                        <th width="15%">গাড়ির নং</th>
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
        <div class="modal fade" id="driver_modal" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">যোগ করুন</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:void(0)" method="post" id="driver_form" onsubmit="driver_save
                    ()" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">ড্রাইভারের নাম <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control form-control-sm" name="name"
                                               id="name"
                                               placeholder="ড্রাইভারের নাম প্রদান করুন" required=""
                                               data-parsley-required-message=" নাম প্রদান করুন">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="mobile_no">মোবাইল নং </label>
                                        <input class="form-control form-control-sm" name="mobile_no" id="mobile_no"
                                               placeholder="মোবাইল নাম্বার প্রদান করুন" data-parsley-mobilenumber="">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="picture">ছবি <span class="text-danger">*</span> </label>
                                        <input type="file" class="form-control form-control-sm" name="picture"
                                               id="picture"
                                               accept="image/*">
                                        <input type="hidden" name="previous_picture" id="previous_picture" value="">
                                        <img class="mt-2 d-none" src="default.png" id="driver_image_preview" width="80"
                                             height="80">
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="row_id" id="row_id">
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
    <script src="{{ asset('/assets/js/custom/driver.js') }}"></script>
    <script>
        driver_list();
    </script>

@endsection
