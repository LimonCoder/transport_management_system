var employee_table;

function employee_list() {
    employee_table = $("#employee_table").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/employee/list_data"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'employee_name', name: 'employee_name'},
            {data: 'designation_name', name: 'designation_name'},
            {data: 'mobile_no', name: 'mobile_no'},
            {data: 'username', name: 'username'},
            {
                data: 'type', name: 'type', render: function (data, type, row, meta) {
                    let htmlmap = '';
                    if (row.type == 2) {
                        htmlmap = '<span class="badge badge-success" >admin</span>';
                    } else {
                        htmlmap = '<span class="badge badge-success" >user</span>';
                    }
                    return htmlmap;
                }
            },
            {

                data: 'id', name: 'id', render: function (data, type, row, meta) {
                    let html = '';
                    if ( auth_type == 2 && row.type != 2 ) {
                        html = "<a href='javascript:void(0)' class='btn btn-warning btn-xs  m-1'" +
                            " onclick='employee_edit(" + meta.row + ")' ><i class='fa fa-edit' ></i> এডিট</a>" +
                            " <a href='javascript:void(0)' class='btn btn-danger btn-xs'" +
                            " onclick='employee_delete(" + meta.row + ")' ><i class='fa fa-trash' ></i> ডিলিট</a>";
                    } else {
                        html = 'N/A';
                    }

                    return html;
                }
            },
        ]

    })
}


function add_employee() {

    $("#employee_form").attr('onsubmit', 'employee_save()')


    $("#employee_form")[0].reset()
    // parsly init
    parslyInit("employee_form");

    $("#employee_modal").modal('toggle');
}


function employee_save() {


    let employee_data = new FormData($("#employee_form")[0]);

    // check validation //
    if (parslyValid("employee_form")) {
        $.ajax({
            url: url + '/employee/store',
            type: 'POST',
            data: employee_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {


                if (response.status == "success") {
                    $("#employee_modal").modal('toggle');
                }

                Swal.fire(
                    {
                        title: response.title,
                        text: response.message,
                        type: response.status,
                        buttons: false
                    }
                )

                if (typeof response.errors != "undefined") {
                    //error msg
                    if (response.errors.username) {
                        let error_msg = response.errors.username[0];
                        $("#username_error").text(error_msg);
                    }
                }


                $("#employee_table").DataTable().draw(true);


            }
        })
    }

}

function employee_edit(row_index) {

    $("#employee_form").attr('onsubmit', 'employee_update()')

    $("#employee_form")[0].reset()

    let employee_data = employee_table.row(row_index).data();

    $("#employee_name").val(employee_data.employee_name);
    $("#designation_id").val(employee_data.designation_id);
    $("#mobile_no").val(employee_data.mobile_no);
    $("#email").val(employee_data.email);
    $("#username").val(employee_data.username);
    $("#previous_picture").val(employee_data.image);

    $("#image_preview").attr('src', url + '/storage/app/public/employees/' + employee_data.image);


    $("#employee_id").val(employee_data.id);
    $("#user_id").val(employee_data.user_id);


    $("#employee_modal").modal('toggle');
}


function employee_update() {
    let employee_data = new FormData($("#employee_form")[0]);

    // check validation //
    if (parslyValid("employee_form")) {
        $.ajax({
            url: url + '/employee/update',
            type: 'POST',
            data: employee_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {

                if (response.status == "success") {
                    $("#employee_modal").modal('toggle');
                }

                Swal.fire(
                    {
                        title: response.title,
                        text: response.message,
                        type: response.status,
                        buttons: false
                    }
                )

                $("#employee_table").DataTable().draw(true);

                // error msg
                if (typeof response.errors != "undefined") {
                    if (response.errors.username) {
                        let error_msg = response.errors.username[0];
                        $("#username_error").text(error_msg);
                    }
                }


            }
        })
    }
}


// delete
function employee_delete(row_index) {

    let employee_data = employee_table.row(row_index).data();


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
                url: url + '/employee/delete',
                type: 'POST',
                data: {
                    'employee_id': employee_data.id,
                    'user_id':employee_data.user_id
                },
                dataType: 'JSON',
                success: function (response) {

                    Swal.fire(response.tittle, response.message, response.status);

                    $("#employee_table").DataTable().draw(true);


                }
            })


        }
    });
}


