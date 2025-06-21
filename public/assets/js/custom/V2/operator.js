var operator_table;
function operator_list() {
    operator_table = $("#operator_table").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/operator/list_data"
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, // ✅ fix here
            { data: 'name', name: 'name' },
            { data: 'designation', name: 'designation' },
            { data: 'mobile_number', name: 'mobile_number' },
            { data: 'user.username', name: 'user.username' },
            {
                data: 'id',
                name: 'id',
                render: function (data, type, row, meta) {
                    let html = '';
                        html =
                            "<a href='javascript:void(0)' class='btn btn-warning btn-xs m-1'" +
                            " onclick='operator_edit(" + meta.row + ")'><i class='fa fa-edit'></i> " + message_edit + "</a>" +
                            " <a href='javascript:void(0)' class='btn btn-danger btn-xs'" +
                            " onclick='operator_delete(" + meta.row + ")'><i class='fa fa-trash'></i> " + message_delete  + " </a>";

                    return html;
                }
            },
        ]
    });
}


function add_operator() {
    $("#operator_form").attr('onsubmit', 'operator_save()');
    $("#operator_form")[0].reset();
    parslyInit("operator_form");
    $("#operator_modal").modal('toggle');
}

function operator_save() {
    let operator_data = new FormData($("#operator_form")[0]);

    if (parslyValid("operator_form")) {
        $.ajax({
            url: url + '/operator/store',
            type: 'POST',
            data: operator_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                if (response.status === "success") {
                    $("#operator_modal").modal('toggle');
                }

                Swal.fire({
                    title: response.title,
                    text: response.message,
                    icon: response.status,
                    buttons: false
                });

                if (typeof response.errors !== "undefined") {
                    if (response.errors.username) {
                        let error_msg = response.errors.username[0];
                        $("#username_error").text(error_msg);
                    }
                }

                $("#operator_table").DataTable().draw(true);
            }
        });
    }
}

function operator_edit(row_index) {
    $("#operator_form").attr('onsubmit', 'operator_update()');
    $("#operator_form")[0].reset();

    let operator_data = operator_table.row(row_index).data();

    $("#name").val(operator_data.name);
    $("#designation").val(operator_data.designation);
    $("#phone").val(operator_data.mobile_number);
    $("#email").val(operator_data.email);
    $("#operator_id").val(operator_data.id);
    $("#user_id").val(operator_data.user_id);
    $("#preview_image").attr('src', url + '/storage/app/public/operators/' + operator_data.picture);
    $("#operator_modal").modal('toggle');
}

function operator_update() {
    let operator_data = new FormData($("#operator_form")[0]);

    if (parslyValid("operator_form")) {
        $.ajax({
            url: url + '/operator/update',
            type: 'POST',
            data: operator_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                if (response.status === "success") {
                    $("#operator_modal").modal('toggle');
                }

                Swal.fire({
                    title: response.title,
                    text: response.message,
                    icon: response.status,
                    buttons: false
                });

                if (typeof response.errors !== "undefined") {
                    if (response.errors.username) {
                        let error_msg = response.errors.username[0];
                        $("#username_error").text(error_msg);
                    }
                }

                $("#operator_table").DataTable().draw(true);
            }
        });
    }
}

function operator_delete(row_index) {
    let operator_data = operator_table.row(row_index).data();

    Swal.fire({
        title: "Response",
        text: "আপনি কি ডিলিট করতে চান ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "হ্যা",
        cancelButtonText: "না",
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: url + '/operator/delete',
                type: 'POST',
                data: {
                    'operator_id': operator_data.id,
                    'user_id': operator_data.user_id
                },
                dataType: 'JSON',
                success: function (response) {
                    Swal.fire(response.title, response.message, response.status);
                    $("#operator_table").DataTable().draw(true);
                }
            });
        }
    });
}
