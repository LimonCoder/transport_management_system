var driver_table;

function driver_list() {
    driver_table = $("#driver_table").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/driver/list_data"
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'license_number', name: 'license_number' },
            { data: 'mobile_number', name: 'mobile_number' },
            { data: 'username', name: 'username' },
            {
                data: 'id',
                name: 'id',
                render: function (data, type, row, meta) {
                    return `
                        <a href="javascript:void(0)" class="btn btn-warning btn-xs m-1" onclick="driver_edit(${meta.row})">
                            <i class="fa fa-edit"></i> ${message_edit}
                        </a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="driver_delete(${meta.row})">
                            <i class="fa fa-trash"></i> ${message_delete}
                        </a>
                    `;
                }
            },
        ]
    });
}

function add_driver() {
    $("#driver_form").attr('onsubmit', 'driver_save()');
    $("#driver_form")[0].reset();
    parslyInit("driver_form");

    // Show username and password fields
    $("#userName").show();
    $("#passwordHide").show();

    $("#driver_modal").modal('show');
}

function driver_save() {
    let driver_data = new FormData($("#driver_form")[0]);

    // Clear previous error messages
    $('.text-danger').text('');

    if (parslyValid("driver_form")) {
        $.ajax({
            url: url + '/driver/store',
            type: 'POST',
            data: driver_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                if (response.status === "success") {
                    $("#driver_modal").modal('toggle');
                    $("#driver_form")[0].reset();
                    $("#driver_table").DataTable().draw(true);
                    Swal.fire({
                        title: response.title,
                        text: response.message,
                        icon: 'success'
                    });
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        $(`#${field}_error`).text(errors[field][0]);
                    }
                } else {
                    Swal.fire("Error", xhr.responseJSON?.message || "Something went wrong", "error");
                }
            }
        });
    }
}


function driver_edit(row_index) {
    $("#driver_form").attr('onsubmit', 'driver_update()');
    $("#driver_form")[0].reset();

    let driver_data = driver_table.row(row_index).data();

    $("#driver_id").val(driver_data.id);
    $("#name").val(driver_data.name);
    $("#username").val(driver_data.username); // If user relation exists
    $("#mobile_number").val(driver_data.mobile_number);
    $("#license_number").val(driver_data.license_number);
    $("#date_of_joining").val(driver_data.date_of_joining);
    $("#address").val(driver_data.address);
    $("#org_code").val(driver_data.org_code);

    // Hide password and username on edit
    $("#userName").hide();
    $("#passwordHide").hide();

    $("#driver_modal").modal('show');
}

function driver_update() {
    let driver_data = new FormData($("#driver_form")[0]);

    if (parslyValid("driver_form")) {
        $.ajax({
            url: url + '/driver/update',
            type: 'POST',
            data: driver_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                if (response.status === "success") {
                    $("#driver_modal").modal('toggle');
                }

                Swal.fire({
                    title: response.title,
                    text: response.message,
                    icon: response.status,
                    buttons: false
                });

                if (typeof response.errors !== "undefined") {
                    if (response.errors.username) {
                        $("#username_error").text(response.errors.username[0]);
                    }
                }

                $("#driver_table").DataTable().draw(true);
            }
        });
    }
}

function driver_delete(row_index) {
    let driver_data = driver_table.row(row_index).data();

    Swal.fire({
        title: "Response",
        text: "Do you want to delete the driver?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: url + '/driver/destroy',
                type: 'POST',
                data: {
                    'driver_id': driver_data.id,
                },
                dataType: 'JSON',
                success: function (response) {
                    Swal.fire(response.title, response.message, response.status);
                    $("#driver_table").DataTable().draw(true);
                },
                error: function (xhr, status, error) {
                    let responseJSON = xhr.responseJSON;
                    let title = "Error";
                    let message = "Something went wrong!";
                    let icon = "error";

                    if (responseJSON && responseJSON.message) {
                        message = responseJSON.message;
                    }

                    Swal.fire(title, message, icon);
                }
            });
        }
    });
}
