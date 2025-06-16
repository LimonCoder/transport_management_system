@extends('layouts.admin')

@section('title','Rentalcar')


@section('main-content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">ভাড়ায় গাড়ির তালিকা</h4>
                            <a href="javascript:void(0)" onclick="add_rentalcar()" class="btn btn-primary btn-xs
                    float-right"><i class="fas fa-plus"></i>
                                যোগ
                                করুন</a>
                        </div>


                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered dt-responsive nowrap repairs_table"
                                           id="rentalcar_table">
                                    <thead>
                                    <tr>
                                        <th>নং</th>
                                        <th>তারিখ </th>
                                        <th>গাড়ির নং</th>
                                        <th>গাড়ির ধরন</th>
                                        <th>মোট দিন</th>
                                        <th>মোট টাকা</th>
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
        <div class="modal fade" id="rentalcar_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 137%;left: -43px">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">যোগ করুন</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:void(0)" method="post" id="rentalcar_form"onsubmit="rentalcar_save()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="vehicle_id">গাড়ির নং <span class="text-danger">*</span> </label>
                                        <select class="form-control form-control-sm" name="vehicle_id" id="vehicle_id" required="" data-parsley-required-message="গাড়ির নং নির্বাচন করুন">
                                            <option value="">গাড়ির নং নির্বাচন করুন</option>
                                            @foreach($vehicle_setup as $item)
                                                <option value="{{$item->id}}">{{$item->vehicle_reg_no}}|{{$item->body_type}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="insert_date">তারিখ(হতে)<span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control form-control-sm" name="from_date" id="from_date"
                                               onkeyup="calculation()" value="" placeholder="তারিখ প্রদান করুন" required=""
                                               data-parsley-required-message="তারিখ প্রদান করুন">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="insert_date">তারিখ(পর্যন্ত)<span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control form-control-sm" name="to_date" id="to_date"
                                               onkeyup="calculation()" value=""
                                               placeholder="তারিখ প্রদান করুন" required="" data-parsley-required-message="তারিখ প্রদান করুন">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total_day">মোট দিন<span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control form-control-sm" name="total_day" id="total_day"
                                               placeholder="মোট দিন প্রদান করুন" required=""
                                               data-parsley-type="number" data-parsley-required-message="মোট দিন
                                               প্রদান করুন" data-parsley-type-message="সঠিক পরিমান প্রদান করুন" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total_cost">ভাড়া<span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control form-control-sm" name="amount" id="amount"
                                               onkeyup="calculate()"
                                               placeholder="টাকার পরিমান প্রদান করুন" required=""
                                               data-parsley-type="number" data-parsley-required-message="টাকার পরিমান
                                               প্রদান করুন" data-parsley-type-message="সঠিক পরিমান প্রদান করুন">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total_cost">ভ্যাট(১৫%)<span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control form-control-sm" name="vat" id="vat"
                                               placeholder="মোট খরচের পরিমান প্রদান করুন" required=""
                                               data-parsley-type="number" data-parsley-required-message="মোট খরচের
                                               পরিমান প্রদান করুন" data-parsley-type-message="সঠিক পরিমান প্রদান
                                               করুন" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="income_tax">আয় কর(৫%)<span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control form-control-sm" name="income_tax" id="income_tax"
                                               placeholder="আয়করের পরিমান প্রদান করুন" required=""
                                               data-parsley-type="number" data-parsley-required-message="আয়করের
                                               পরিমান প্রদান করুন" data-parsley-type-message="সঠিক পরিমান প্রদান
                                               করুন" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total_amount">মোট টাকা<span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control form-control-sm" name="total_amount" id="total_amount"
                                               placeholder="মোট টাকা" required="" data-parsley-type="number"
                                               data-parsley-required-message="মোট টাকার পরিমান প্রদান করুন"
                                               data-parsley-type-message="সঠিক পরিমান প্রদান করুন" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total_cost">ঠিকাদারের নাম<span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control form-control-sm" name="contractor_name" id="contractor_name"
                                               placeholder="ঠিকাদারের নাম প্রদান করুন">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total_cost">ঠিকানা<span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control form-control-sm" name="address" id="address"
                                               placeholder="ঠিকানা প্রদান করুন"></textarea>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="modal-footer">
{{--                            <input type="hidden" name="repairs_id" id="repairs_id">--}}
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
    <script src="{{ asset('/assets/js/custom/rentalcar.js') }}"></script>
    <script>
        rentalcar_list();
        // $("#from_date").datepicker({dateFormat: 'yy-mm-dd'});
        // $("#to_date").datepicker({dateFormat: 'yy-mm-dd'});

        $("#from_date").datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $("#to_date").datepicker({dateFormat: 'yy-mm-dd',
            onSelect: function () {
                calculation();
            }
        });

        function calculation(){

                let from_date = $("#from_date").datepicker("getDate");
                let to_date = $("#to_date").datepicker("getDate");
                let days = 0;
                let total_day=0;

                days = (to_date - from_date) / (1000 * 60 * 60 * 24);
                total_day = (Math.round(days)+1);

            $("#total_day").val(total_day);
        }

        function calculate() {
            var percentage = $('#amount').val(),
                calcVat = ((percentage * 15)/100),
                calcIncomeTax = ((percentage*5)/100),
            totalAmount = parseFloat(percentage) + parseFloat(calcVat) + parseFloat(calcIncomeTax)

            $('#vat').val(calcVat);
            $('#income_tax').val(calcIncomeTax);
            $('#total_amount').val(totalAmount);

        }
    </script>

@endsection
