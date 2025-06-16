@extends('layouts.admin')

@section('title','Designation')


@section('main-content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left"  >পদবীর তালিকা</h4>
                            <a href="javascript:void(0)" onclick="add_designation()" class="btn btn-primary btn-xs
                            float-right"><i
                                    class="fas fa-plus"></i>
                                যোগ
                                করুন</a>
                        </div>


                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered dt-responsive nowrap designation_table"
                                    id="designation_table">
                                    <thead>
                                    <tr>
                                        <th width="10%">নং</th>
                                        <th width="30%" >নাম</th>
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


        <!-- Designation modal --->
        <!-- Modal -->
        <div class="modal fade" id="designation_modal" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">যোগ করুন</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:void(0)" method="post" id="designation_form" onsubmit="designation_save
                    ()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">পদবীর নাম <span class="text-danger">*</span> </label>
                                        <input class="form-control form-control-sm" name="name" id="name"
                                               placeholder="পদবী প্রদান করুন" required=""
                                               data-parsley-required-message="পদবী প্রদান করুন" >
                                    </div>
                                </div>




                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="row_id" id="row_id" >
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
    <script src="{{ asset('/assets/js/custom/designation.js') }}"></script>
    <script>
        designation_list();
    </script>

@endsection
