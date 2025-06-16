@extends('layouts.admin')

@section('title','Lobriant')


@section('main-content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">লুব্রিক্যান্ট তালিকা</h4>
                            <a href="javascript:void(0)" onclick="add_lubricant()" class="btn btn-primary btn-xs
                            float-right"><i class="fas fa-plus"></i>
                                যোগ
                                করুন</a>
                        </div>


                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered dt-responsive nowrap  lobriant_table"
                                    id="lobriant_table">
                                    <thead>
                                    <tr>
                                        <th width="5%">নং</th>
                                        <th width="10%">গাড়ির নং</th>
                                        <th width="10%">টাইপ</th>
                                        <th width="10%">সরবারহ</th>
                                        <th width="10%">মোট টাকা</th>
                                        <th width="10%">তারিখ</th>
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

        <!-- Modal -->
        <div class="modal fade" id="lubricant_modal" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 137%;left: -43px">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">যোগ করুন</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:void(0)" method="post" id="lubricant_form" onsubmit="">
                        <div class="modal-body">
                            <h5 style="padding: 7px 7px;background: #e3d7d7;"><img src="{{asset
                            ('/assets/images/oil.png')}}" style="margin-top: -3px;"> লুব্রিক্যান্ট</h5>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="vehicle_id"> গাড়িং নং <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control form-control-sm" name="vehicle_id"
                                                id="vehicle_id" required=""
                                                data-parsley-required-message="গাড়িং নং নির্বাচন করুন">
                                            <option value="">নির্বাচন করুন</option>
                                            @foreach($vehicle_setup as $item )
                                                <option value="{{ $item->id }}">{{
                                                $item->vehicle_reg_no}}||{{$item->driver_info->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <table
                                    class="table table-bordered dt-responsive nowrap  lobriant_table"
                                    id="lobriant_item_table">
                                    <thead>
                                    <tr>
                                        <th width="15%">লুব্রিক্যান্ট টাইপ</th>
                                        <th width="10%">পরিমান(লিটার)</th>
{{--                                        <th width="10%">সরবারহ</th>--}}
                                        <th width="10%">মোট টাকা</th>
                                        <th width="5%"><button type="button" name="add" id="add"  class="btn
                                            btn-warning
                                        btn-xs
                            float-right"><i class="fas fa-plus"></i> যোগ করুন</button></th>

                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tr>
                                        <td style="text-align: right;" colspan="2">সর্ব মোটঃ</td>
                                        <td style="text-align: right"><input type="text" readonly id="total_amount"
                                                                             value=""
                                                                             name="total_amount" class="form-control
                                                                             form-control-sm" ></td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                        <div class="modal-footer">
{{--                            <input type="hidden" name="log_book_id" id="log_book_id" value="">--}}
{{--                            <input type="hidden" name="meter_id" id="meter_id" value="">--}}
{{--                            <input type="hidden" name="fuel_oil_id" id="fuel_oil_id" value="">--}}
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

    <script>
        var lobriant_table;
        lobriant_list();

        function lobriant_list() {
            lobriant_table = $("#lobriant_table").DataTable({
                scrollCollapse: true,
                autoWidth: false,
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: url + "/lobriant/list_data"
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'vehicle_reg_no', name: 'vehicle_reg_no'},
                    {data: 'lobriant_type', name: 'lobriant_type'},
                    {
                        data: 'in', name: 'in', render: function (data, type, row, meta) {
                        return row.in +' লিটার';
                        }
                    },
                    {data: 'payment', name: 'payment'},
                    {data: 'insert_data', name: 'insert_data'},

                ]

            })
        }

        function add_lubricant() {

            $("#lubricant_form").attr('onsubmit', 'lubriant_save()')

            $("#lubricant_form")[0].reset()
            // parsly init
            parslyInit("lubricant_form");

            $("#lubricant_modal").modal('toggle');
        }


        $(document).ready(function (){
            $(document).on('click','#add',function (){
                var html = '';

                html += '<tr>';

                html += '<td><select name="type[]" class="form-control form-control-sm" required="" data-parsley-required-message="লুব্রিক্যান্ট টাইপ প্রদান করুন">' +
                    '<option value="">সিলেক্ট করুন</option>' +
                    '<option value="4">ইঞ্জিন অয়েল</option>' +
                    '<option value="5">গিয়ার অয়েল</option>' +
                    '<option value="6">গ্রীজ</option>' +
                    '<option value="7">পাওয়ার অয়েল</option>' +
                    '<option value="8">হাইড্রলীক অয়েল</option>' +
                    '<option value="9">ব্রেক অয়েল</option>' +
                    '</select></td>';

                html += '<td><input type="text" name="in_litter[]" class="form-control form-control-sm" ' +
                    'placeholder="লিটারে ' +
                    'প্রদান করুন" required="" ' +
                    'data-parsley-required-message="লিটারে প্রদান করুন"></td>';

                html += '<td><input type="text" class="form-control form-control-sm payment" name="payment[]" ' +
                    'onkeyup="calculation()" value="" ' +
                    'placeholder="টাকা প্রদান করুন" required="" ' +
                    'data-parsley-required-message="টাকা প্রদান করুন"></td>';

                html += '<td style="text-align: center; width: 10px" ><button type="button"  name="remove" class="btn btn-danger ' +
                    'btn-xs remove" ' +
                    '><i class="dripicons-clipboard"></i> Remove</button></td></tr>';

                $('#lobriant_item_table').append(html);


            });
            $(document).on('click', '.remove',function (){
               $(this).closest('tr').remove();
            });

        });

        function calculation(){
            var total = 0;

            $('.payment').each(function (i,e){
                var sum = parseInt($(this).val());
                total += sum;
            });
            $('#total_amount').val(total);
            // console.log(total);
        }
        function lubriant_save(){
            let lubriant_data = new FormData($("#lubricant_form")[0]);
            if (parslyValid("lubricant_form")) {
                $.ajax( {
                    url: url+'/lobriant/store',
                    type:'POST',
                    data:lubriant_data,
                    processData:false,
                    contentType:false,
                    dataType:'JSON',
                    success: function (response) {

                        if (response.status == "success"){

                            $("#lubricant_modal").modal('toggle');
                        }
                        Swal.fire(
                            {
                                title: response.title,
                                text: response.message,
                                type: response.status,
                                buttons: false
                            }
                        )
                        $("#lobriant_table").DataTable().draw(true)
                    }
                });
            }
        }


    </script>

@endsection
