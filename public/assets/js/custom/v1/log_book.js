var log_book_table;

function log_book_list() {
    log_book_table = $("#logbook_table").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/logbook/list_data"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'employee_name', name: 'employee_name'},
            {data: 'designation_name', name: 'designation_name'},
            {data: 'driver_name', name: 'driver_name'},
            {data: 'vehicle_reg_no', name: 'vehicle_reg_no'},
            {data: 'out_time', name: 'out_time'},
            {data: 'in_time', name: 'in_time'},
            {data: 'destination', name: 'destination'},
            {
                data: 'status', name: 'status', render: function (data, type, row, meta) {
                    let status = (row.status == 1) ? {color: 'green', text: 'সম্পূর্ণ'} : {
                        color: 'red',
                        text: 'অসম্পূর্ণ'
                    };

                    return '<span style="color: ' + status.color + '" >' + status.text + '</span>'


                }
            },
            {
                data: 'id', name: 'id', render: function (data, type, row, meta) {
                    let html = '';
                    if (auth_type == 2) {

                        html = "<a href='javascript:void(0)' class='btn btn-warning btn-xs  m-1'" +
                            " onclick='log_book_edit(" + meta.row + ")' ><i class='fa fa-edit' ></i> এডিট</a>" +
                            " <a href='javascript:void(0)' class='btn btn-danger btn-xs'" +
                            " onclick='log_book_delete(" + meta.row + ")' ><i class='fa fa-trash' ></i> ডিলিট</a>";


                    } else {
                        html = 'N/A';
                    }


                    return html;
                }
            },
        ]

    })
}


function add_log_book() {

    $("#logbook_form").attr('onsubmit', 'log_book_save()')

    $("#logbook_form")[0].reset()
    // parsly init
    parslyInit("logbook_form");

    $("#logbook_modal").modal('toggle');
}


function log_book_save() {

    let log_book_data = new FormData($("#logbook_form")[0]);

    // check validation //
    if (parslyValid("logbook_form")) {
        $.ajax({
            url: url + '/logbook/store',
            type: 'POST',
            data: log_book_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {


                if (response.status == "success") {
                    $("#logbook_modal").modal('toggle');
                }

                Swal.fire(
                    {
                        title: response.title,
                        text: response.message,
                        type: response.status,
                        buttons: false
                    }
                )

                $("#logbook_table").DataTable().draw(true);


            }
        })
    }

}

function log_book_edit(row_index) {

    $("#logbook_form").attr('onsubmit', 'log_book_update()')

    let log_book_data = log_book_table.row(row_index).data();

    $("#driver_id").val(log_book_data.driver_id);
    $("#vehicle_id").val(log_book_data.vehicle_id);
    $("#employee_id").val(log_book_data.employee_id);
    $("#from").val(log_book_data.from);
    $("#out_time").val(log_book_data.out_time);
    $("#destination").val(log_book_data.destination);
    $("#journey_time").val(log_book_data.journey_time);
    $("#journey_cause").val(log_book_data.journey_cause);
    $("#out_km").val(log_book_data.out_km);
    $("#in_km").val(log_book_data.in_km);
    $("#in_time").val(log_book_data.in_time);
    $("#type").val(log_book_data.oil_type);
    $("#in").val(log_book_data.in);
    $("#out").val(log_book_data.out);
    $("#previous_stock").val(log_book_data.previous_stock);
    $("#payment").val(log_book_data.payment);
    $("#log_book_id").val(log_book_data.log_book_id);
    $("#meter_id").val(log_book_data.meter_id);
    $("#fuel_oil_id").val(log_book_data.fuel_oil_id);

    getCurrentStock(log_book_data.vehicle_id,log_book_data.log_book_id);
    calculation();
    $("#logbook_modal").modal('toggle');
}

function log_book_update() {
    let log_book_data = new FormData($("#logbook_form")[0]);

    // check validation //
    if (parslyValid("logbook_form")) {
        $.ajax({
            url: url + '/logbook/update',
            type: 'POST',
            data: log_book_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {

                if (response.status == "success") {
                    $("#logbook_modal").modal('toggle');
                }

                Swal.fire(
                    {
                        title: response.title,
                        text: response.message,
                        type: response.status,
                        buttons: false
                    }
                )

                $("#logbook_table").DataTable().draw(true);





            }
        })
    }
}

// delete
function log_book_delete(row_index) {

    let log_book_data = log_book_table.row(row_index).data();


    console.log(log_book_data);


    Swal.fire({
        title: "Response",
        text: "আপনি কি ডিলিট করতে চান ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "হ্যা",
        cancelButtonText: "না",
    }).then(function (result) {
        if (result.value) {

            $.ajax({
                url: url + '/logbook/delete',
                type: 'POST',
                data: {
                    'log_book_id': log_book_data.log_book_id,
                    'meter_id': log_book_data.meter_id,
                    'fuel_oil_id': log_book_data.fuel_oil_id
                },
                dataType: 'JSON',
                success: function (response) {

                    Swal.fire(response.tittle, response.message, response.status);

                    $("#logbook_table").DataTable().draw(true);


                }
            })


        }
    });
}


function getCurrentStock(vehicle_id,log_book_id = null) {

    if (vehicle_id != "") {
        $.ajax({
            url: url + '/logbook/getCurrentStock',
            type: 'POST',
            data: {'vehicle_id': vehicle_id, 'log_book_id':log_book_id},
            dataType: 'JSON',
            success: function (response) {
                $("#previous_stock").val(response.data);
            }
        })
    } else {
        $("#previous_stock").val('');
    }


}


