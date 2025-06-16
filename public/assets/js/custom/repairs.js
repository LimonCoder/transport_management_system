var repairs_table;

function repairs_list() {
    repairs_table = $("#repairs_table").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/repairs/list_data"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'insert_date', name: 'insert_date'},
            {data: 'vehicle_reg_no', name: 'vehicle_reg_no'},
            {data: 'employee_name', name: 'employee_name'},
            {data: 'driver_name', name: 'driver_name'},
            {data: 'damage_parts', name: 'damage_parts'},
            {data: 'new_parts', name: 'new_parts'},
            {data: 'shop_name', name: 'shop_name'},
            {data: 'total_cost', name: 'total_cost'},
            {data: 'cause_of_problems', name: 'cause_of_problems'},
            {
                data: 'id', name: 'id', render: function (data, type, row, meta) {
                    let html = '';
                    if (auth_type == 2){
                        html = "<a href='javascript:void(0)' class='btn btn-warning btn-xs  m-1'" +
                            " onclick='repairs_edit(" + meta.row + ")' ><i class='fa fa-edit' ></i> এডিট</a>" +
                            " <a href='javascript:void(0)' class='btn btn-danger btn-xs'" +
                            " onclick='repairs_delete(" + meta.row + ")' ><i class='fa fa-trash' ></i> ডিলিট</a>";
                    }else{
                        html = 'N/A';
                    }

                    return html;
                }
            },
        ]

    })
}


function add_repair() {

    $("#repairs_form").attr('onsubmit', 'repair_save()')

    $("#repairs_form")[0].reset()
    // parsly init
    parslyInit("repairs_form");

    $("#repairs_modal").modal('toggle');
}

function repair_save() {

    let repairs_data = new FormData($("#repairs_form")[0]);

    // check validation //
    if (parslyValid("repairs_form")) {
        $.ajax({
            url: url + '/repairs/store',
            type: 'POST',
            data: repairs_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {


                if (response.status == "success") {
                    $("#repairs_modal").modal('toggle');
                }

                Swal.fire(
                    {
                        title: response.title,
                        text: response.message,
                        type: response.status,
                        buttons: false
                    }
                )

                $("#repairs_table").DataTable().draw(true)
            }
        })
    }

}
function repairs_edit(row_index) {

    $("#repairs_form").attr('onsubmit', 'repairs_update()')

    let repairs_data = repairs_table.row(row_index).data();

    $("#vehicle_id").val(repairs_data.vehicle_id);
    $("#employee_id").val(repairs_data.employee_id);
    $("#damage_parts").val(repairs_data.damage_parts);
    $("#new_parts").val(repairs_data.new_parts);
    $("#total_cost").val(repairs_data.total_cost);
    $("#shop_name").val(repairs_data.shop_name);
    $("#insert_date").val(repairs_data.insert_date);
    $("#cause_of_problems").val(repairs_data.cause_of_problems);
    $("#row_id").val(repairs_data.id);

    $("#repairs_modal").modal('toggle');
}
function repairs_update() {

    let repairs_data = new FormData($("#repairs_form")[0]);

    // check validation //
    if (parslyValid("repairs_form")) {
        $.ajax({
            url: url + '/repairs/update',
            type: 'POST',
            data: repairs_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {

                if (response.status == "success") {
                    $("#repairs_modal").modal('toggle');
                }

                Swal.fire(
                    {
                        title: response.title,
                        text: response.message,
                        type: response.status,
                        buttons: false
                    }
                )

                $("#repairs_table").DataTable().draw(true);

            }
        })
    }
}
function repairs_delete(row_index) {

    let repairs_data = repairs_table.row(row_index).data();

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
                url: url + '/repairs/delete',
                type: 'POST',
                data: {
                    'row_id': repairs_data.id,
                },
                dataType: 'JSON',
                success: function (response) {

                    Swal.fire(response.tittle, response.message, response.status);

                    $("#repairs_table").DataTable().draw(true);


                }
            })


        }
    });
}
