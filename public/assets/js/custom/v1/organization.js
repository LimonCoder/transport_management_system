var organization_table;

function organization_list() {
    organization_table = $("#organization_table").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/organization/list_data"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'org_code', name: 'org_code'},
            {data: 'org_name', name: 'org_name'},
            {data: 'org_type_name', name: 'org_type_name'},
            {data: 'employee_name', name: 'employee_name'},
            {data: 'username', name: 'username'},
            {data: 'mobile_no', name: 'mobile_no'},
            {data: 'org_address', name: 'org_address'},
            {
                data: 'id', name: 'id', render: function (data, type, row, meta) {
                    let html = "<a href='javascript:void(0)' class='btn btn-warning btn-xs  m-1'" +
                        " onclick='organization_edit(" + meta.row + ")' ><i class='fa fa-edit' ></i> এডিট</a>" +
                        " <a href='javascript:void(0)' class='btn btn-danger btn-xs'" +
                        " onclick='organization_delete(" + meta.row + ")' ><i class='fa fa-trash' ></i> ডিলিট</a>" +
                        " <a href='" + url + "/impersonate/" + row.user_id + "' class='btn btn-secondary btn-xs'" +
                        " onclick='' ><i class='fas fa-sign-in-alt' ></i> লগইন</a>";

                    return html;
                }
            },
        ]

    })
}


function add_organization() {

    $("#organization_form").attr('onsubmit', 'organization_save()')

    $("#organization_form")[0].reset()
    // parsly init
    parslyInit("organization_form");

    $("#organization_modal").modal('toggle');
}


function organization_save() {

    let organization_data = new FormData($("#organization_form")[0]);

    // check validation //
    if (parslyValid("organization_form")) {
        $.ajax({
            url: url + '/organization/store',
            type: 'POST',
            data: organization_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {


                if (response.status == "success") {
                    $("#organization_modal").modal('toggle');
                }

                Swal.fire(
                    {
                        title: response.title,
                        text: response.message,
                        type: response.status,
                        buttons: false
                    }
                )

                $("#organization_table").DataTable().draw(true);


                //error msg
                if (response.errors.org_code) {
                    let error_msg = response.errors.org_code[0];
                    $("#org_code_error").text(error_msg);
                }
                if (response.errors.username) {
                    let error_msg = response.errors.username[0];
                    $("#username_error").text(error_msg);
                }


            }
        })
    }

}

function organization_edit(row_index) {

    $("#organization_form").attr('onsubmit', 'organization_update()')

    let organization_data = organization_table.row(row_index).data();

    $("#org_name").val(organization_data.org_name);
    $("#org_code").val(organization_data.org_code);
    $("#org_type").val(organization_data.org_type);
    $("#org_address").val(organization_data.org_address);
    $("#employee_name").val(organization_data.employee_name);
    $("#designation_id").val(organization_data.designation_id);
    $("#mobile_no").val(organization_data.mobile_no);
    $("#username").val(organization_data.username);
    $("#org_id").val(organization_data.org_id);
    $("#employee_id").val(organization_data.employee_id);
    $("#user_id").val(organization_data.user_id);

    $("#organization_modal").modal('toggle');
}

function organization_update() {
    let organization_data = new FormData($("#organization_form")[0]);

    // check validation //
    if (parslyValid("organization_form")) {
        $.ajax({
            url: url + '/organization/update',
            type: 'POST',
            data: organization_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {

                if (response.status == "success") {
                    $("#organization_modal").modal('toggle');
                }

                Swal.fire(
                    {
                        title: response.title,
                        text: response.message,
                        type: response.status,
                        buttons: false
                    }
                )

                $("#organization_table").DataTable().draw(true);


                if (typeof response.errors != "undefined") {
                    //error msg
                    if (response.errors.org_code) {
                        let error_msg = response.errors.org_code[0];
                        $("#org_code_error").text(error_msg);
                    }
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
function organization_delete(row_index) {

    let organization_data = organization_table.row(row_index).data();

    console.log(organization_data);

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
                url: url + '/organization/delete',
                type: 'POST',
                data: {
                    'org_id': organization_data.org_id,
                    'employee_id': organization_data.employee_id,
                    'user_id': organization_data.user_id
                },
                dataType: 'JSON',
                success: function (response) {

                    Swal.fire(response.tittle, response.message, response.status);

                    $("#organization_table").DataTable().draw(true);


                }
            })


        }
    });
}


