@extends('layouts.admin')

@section('title','Log Book')


@section('main-content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">লগ বইয়ের তালিকা</h4>
                            <a href="javascript:void(0)" onclick="add_log_book()" class="btn btn-primary btn-xs
                            float-right"><i
                                    class="fas fa-plus"></i>
                                যোগ
                                করুন</a>
                        </div>


                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered dt-responsive nowrap logbook_table"
                                    id="logbook_table">
                                    <thead>
                                    <tr>
                                        <th>নং</th>
                                        <th>কর্মকর্তার নাম</th>
                                        <th width="20%">পদবী</th>
                                        <th>ড্রাইভার নাম</th>
                                        <th>গাড়িং নং</th>
                                        <th>বাহির হওয়ার সময়</th>
                                        <th>আসার সময়</th>
                                        <th>গন্তব্য</th>
                                        <th>স্ট্যাটাস</th>
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


        <!-- log book modal --->
        <!-- Modal -->
        <div class="modal fade" id="logbook_modal" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 137%;left: -43px">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">যোগ করুন</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:void(0)" method="post" id="logbook_form" onsubmit="log_book_save
                    ()">
                        <div class="modal-body">
                            <div class="row">

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
                                        <label for="vehicle_id"> গাড়িং নং <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control form-control-sm" name="vehicle_id"
                                                id="vehicle_id" required="" onchange="getCurrentStock(this.value)"
                                                data-parsley-required-message="গাড়িং নং নির্বাচন করুন">
                                            <option value="">নির্বাচন করুন</option>
                                            @foreach($vehicles as $item )
                                                <option value="{{ $item->id  }}">{{ $item->vehicle_reg_no  }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="employee_id">ফরমাস দাতার নাম ও পদবী <span
                                                class="text-danger">*</span>
                                        </label>
                                        <select class="form-control form-control-sm" name="employee_id"
                                                id="employee_id" required=""
                                                data-parsley-required-message="কর্মকর্তার নাম প্রদান করুন">
                                            <option value="">সিলেক্ট করুন</option>
                                            @foreach($employees as $item )
                                                <option value="{{ $item->id  }}">{{ $item->name   }} | @if($item->designation)
                                                         {{ $item->designation->name }}
                                                    @else
                                                       Not Assigned
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>


                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="insert_date">তারিখ</label>
                                        <input class="form-control form-control-sm" name="insert_date" id="insert_date"
                                               placeholder="তারিখ প্রদান করুন" value="{{ date('Y-m-d') }}" required=""
                                               data-parsley-required-message="তারিখ প্রদান করুন">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="from">হইতে <span class="text-danger">*</span> </label>
                                        <input class="form-control form-control-sm" name="from" id="from"
                                               placeholder=" " required=""
                                               data-parsley-required-message="হইতে প্রদান করুন">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="out_time">বাহির হওয়ার সময় <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" name="out_time"
                                                   id="out_time"
                                                   placeholder="বাহির হওয়ার সময় প্রদান করুন" required=""
                                                   data-parsley-required-message="বাহির হওয়ার সময় প্রদান করুন">
                                            <div class="input-group-append"><span class="input-group-text"
                                                                                  style="font-size:11px"><i
                                                        class="mdi mdi-clock-outline"></i></span></div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="destination">গন্তব্য স্থান <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control form-control-sm" name="destination"
                                               id="destination"
                                               placeholder="গন্তব্য স্থান  প্রদান করুন" required=""
                                               data-parsley-required-message="গন্তব্য স্থান প্রদান করুন">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="journey_time">ভ্রমণ করিবার সময় <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" name="journey_time"
                                                   id="journey_time"
                                                   placeholder="ভ্রমণ করিবার সময় প্রদান করুন" required=""
                                                   data-parsley-required-message="ভ্রমণ করিবার সময় প্রদান করুন">
                                            <div class="input-group-append"><span class="input-group-text"
                                                                                  style="font-size:11px"><i
                                                        class="mdi mdi-clock-outline"></i></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="journey_cause">ভ্রমণ করিবার কারণ
                                        </label>
                                        <input type="text" class="form-control form-control-sm" name="journey_cause"
                                               id="journey_cause"
                                               placeholder="ভ্রমণ করিবার কারণ">
                                    </div>
                                </div>


                            </div>
                            <h5 style="padding: 7px 7px;background: #e3d7d7;"><img src="{{asset
                            ('/assets/images/kmh.png')}}" style="margin-top: -3px;"> কিলোমিটার</h5>
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="out_km">যাওয়ার সময়</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" name="out_km" id="out_km"
                                                   placeholder="কি.মি প্রদান করুন" value="" onkeyup="calculation()"
                                                   required=""
                                                   data-parsley-required-message="কি.মি প্রদান করুন">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="font-size: 12px">কি.মি</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="in_km"> আসার পর</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" name="in_km" id="in_km"
                                                   placeholder="কি.মি প্রদান করুন" value="" onkeyup="calculation()"
                                                   required=""
                                                   data-parsley-required-message="কি.মি প্রদান করুন">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="font-size: 12px">কি.মি</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total_km">মোট কি.মি</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" name="total_km" id="total_km"
                                                   readonly value="">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="font-size: 12px">কি.মি</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="in_time">গাড়ি আসার সময়</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" name="in_time" id="in_time"
                                                   value="" placeholder="গাড়ি আসার সময় প্রদান করুন ">
                                            <div class="input-group-append"><span class="input-group-text"
                                                                                  style="font-size:11px"><i
                                                        class="mdi mdi-clock-outline"></i></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h5 style="padding: 7px 7px;background: #e3d7d7;"><img src="{{asset
                            ('/assets/images/oil.png')}}" style="margin-top: -3px;"> লুব্রিক্যান্ট</h5>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="previous_stock">পূর্ববর্তী জমা</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" name="previous_stock"
                                                   id="previous_stock"
                                                   readonly value="">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="font-size: 12px">লিটার</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="type">লুব্রিক্যান্ট টাইপ</label>
                                        <select class="form-control form-control-sm" name="type"
                                                id="type" required=""
                                                data-parsley-required-message="লুব্রিক্যান্ট টাইপ সিলেক্ট করুন">
                                            <option value="">সিলেক্ট করুন</option>
                                            <option value="1">প্রেক্টল</option>
                                            <option value="2">ডিজেল</option>
                                            <option value="3">অকটেন</option>

                                        </select>

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="payment">মোট টাকা</label>
                                        <input type="text" class="form-control form-control-sm" name="payment"
                                               id="payment"
                                               placeholder="টাকা প্রদান করুন" required=""
                                               data-parsley-required-message="টাকা প্রদান করুন">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="in">নতুন সরবারহ <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" name="in"
                                                   id="in" onkeyup="calculation()"
                                                   placeholder="লিটারে প্রদান করুন" required=""
                                                   data-parsley-required-message="লিটারে প্রদান করুন">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="font-size: 12px">লিটার</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="out">খরচ <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" name="out"
                                                   id="out" onkeyup="calculation()"
                                                   placeholder="লিটারে প্রদান করুন" required=""
                                                   data-parsley-required-message="লিটারে প্রদান করুন">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="font-size: 12px">লিটার</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total_stock">মোট জমা</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" name="total_stock"
                                                   id="total_stock"
                                                   readonly value="">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="font-size: 12px">লিটার</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="log_book_id" id="log_book_id" value="">
                            <input type="hidden" name="meter_id" id="meter_id" value="">
                            <input type="hidden" name="fuel_oil_id" id="fuel_oil_id" value="">
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

    <script src=" {{ asset('/assets/libs/mask.js')}}"></script>

    <script src="{{ asset('/assets/js/custom/log_book.js') }}"></script>


    <script>

        log_book_list();

        calculation();

        function calculation() {
            let out_km = parseInt($("#out_km").val()) || 0;
            let in_km = parseInt($("#in_km").val()) || 0;
            let total_km = 0;

            let in_oil = parseInt($("#in").val()) || 0;
            let out_oil = parseInt($("#out").val()) || 0;
            let previous_stock = parseInt($("#previous_stock").val()) || 0;
            let total_oil = 0

            total_km = (Math.abs(out_km - in_km)).toString();
            total_oil = (Math.abs((in_oil - out_oil) + previous_stock)).toString();

            $("#total_km").val(total_km);
            $("#total_stock").val(total_oil);
        }

        $('#journey_time').mask('00:00:00');


        $("#insert_date").datepicker({dateFormat: 'yy-mm-dd'});


        jQuery('#out_time').timepicker({
            icons: {
                up: 'mdi mdi-chevron-up',
                down: 'mdi mdi-chevron-down'
            }
        }).on('show.timepicker', function (e) {
            $("#out_time").val(e.time.value);
        });



        jQuery('#in_time').timepicker({
            icons: {
                up: 'mdi mdi-chevron-up',
                down: 'mdi mdi-chevron-down'
            }
        }).on('show.timepicker', function (e) {
            $("#in_time").val(e.time.value);
        });







    </script>

@endsection
