var vehicle_table;
var row_index = 1;

function vehicle_list() {
    vehicle_table = $("#vehicle_table").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/vehicle/list_data"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {
                data: 'images',
                name: 'images',
                render: function (data, type, row, meta) {
                    if (row.images) {
                        return '<img src="' + url + '/' + row.images + '" width="80" height="80">';
                    } else {
                        return '<img src="' + url + '/storage/vehicles/default.png" width="80" height="80">';
                    }
                }
            },
            {data: 'org_code', name: 'org_code'},
            {data: 'registration_number', name: 'registration_number'},
            {data: 'model', name: 'model'},
            {data: 'capacity', name: 'capacity'},
            {data: 'fuel_type_id', name: 'fuel_type_id'}, // পরিবর্তন করা হয়েছে
            {data: 'status', name: 'status'},
            {
                data: 'id',
                name: 'id',
                render: function (data, type, row, meta) {
                        return `
                            <a href='javascript:void(0)' class='btn btn-warning btn-xs  m-1' onclick='vehicle_edit(${meta.row})'><i class='fa fa-edit'></i> এডিট</a>
                            <a href='javascript:void(0)' class='btn btn-danger btn-xs' onclick='vehicle_delete(${meta.row})'><i class='fa fa-trash'></i> ডিলিট</a>
                        `;
                }
            },
        ]
    });
}



function add_vehicle() {

    $("#vehicle_form").attr('onsubmit', 'vehicle_save()')

    $("#previous_images").addClass('d-none');

    $("#vehicle_form")[0].reset()
    // parsly init
    parslyInit("vehicle_form");

    $("#vehicle_modal").modal('toggle');
}


function vehicle_save() {

    let vehicle_data = new FormData($("#vehicle_form")[0]);

    // check validation //
    if (parslyValid("vehicle_form")) {
        $.ajax({
            url: url + '/vehicle/store',
            type: 'POST',
            data: vehicle_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {


             if (response.success) {
                        $("#vehicle_modal").modal('hide');

                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $("#vehicle_table").DataTable().draw(true);
                        $("#vehicle_form")[0].reset(); // ফর্ম রিসেট (optional)
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                        });
                    }


            }
        })
    }

}

function vehicle_edit(row_index) {
    $("#vehicle_form").attr('onsubmit', 'vehicle_update()');

    let vehicle_data = vehicle_table.row(row_index).data();
    let html = '';

    let vehicle_images = vehicle_data.images
        ? (vehicle_data.images.includes("##") ? vehicle_data.images.split("##") : [vehicle_data.images])
        : [];

    $("#org_code").val(vehicle_data.org_code);
    $("#registration_number").val(vehicle_data.registration_number);
    $("#model").val(vehicle_data.model);
    $("#capacity").val(vehicle_data.capacity);
    $("#fuel_type_id").val(vehicle_data.fuel_type_id);
    $("#status1").val(vehicle_data.status1);
    $("#row_id").val(vehicle_data.id);

    $("#previous_images").removeClass('d-none');

    vehicle_images.forEach(function (item) {
        html += `<img class="m-1" src="${url}/storage/app/public/vehicles/${item}" width="50" height="50">`;
    });

    $("#previous_images").html(html || '<p>No previous images.</p>');
    $("#vehicle_modal").modal('toggle');
}

function vehicle_update() {
    let vehicle_data = new FormData($("#vehicle_form")[0]);

    // check validation //
    if (parslyValid("vehicle_form")) {
        $.ajax({
            url: url + '/vehicle/update',
            type: 'POST',
            data: vehicle_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {

                // ✅ Success Handling
                if (response.success === true) {
                    $("#vehicle_modal").modal('toggle');
                    $("#vehicle_table").DataTable().draw(true);

                    Swal.fire({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "OK"
                    });

                } else {
                    // ❌ Failed but not server error (like validation)
                    Swal.fire({
                        title: "Error!",
                        text: response.message,
                        icon: "error",
                        confirmButtonText: "OK"
                    });

                    // ✅ Optional: show validation errors on form
                    if (response.errors) {
                        if (response.errors.registration_number) {
                            $("#vehicle_reg_no_error").text(response.errors.registration_number[0]);
                        }
                        // আরও error থাকলে এখানেও দেখাতে পারো
                    }
                }
            },
            error: function (xhr) {
                // ❌ Server Error Handling
                let response = xhr.responseJSON;

                Swal.fire({
                    title: "Error!",
                    text: response?.message || "Something went wrong!",
                    icon: "error",
                    confirmButtonText: "OK"
                });

                if (response?.errors) {
                    if (response.errors.registration_number) {
                        $("#vehicle_reg_no_error").text(response.errors.registration_number[0]);
                    }
                    // অন্যান্য ফিল্ড এর error এখানেও চাইলে দেখানো যাবে
                }
            }
        });
    }
}


// delete
function vehicle_delete(row_index) {

    let vehicle_data = vehicle_table.row(row_index).data();


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
                url: url + '/vehicle/delete',
                type: 'POST',
                data: {
                    'row_id': vehicle_data.id,
                },
                dataType: 'JSON',
                success: function (response) {

                    Swal.fire(response.tittle, response.message, response.status);

                    $("#vehicle_table").DataTable().draw(true);


                }
            })


        }
    });
}

function addInputPictures() {
    row_index++;
    let htmlmapping = '<div class="row mt-1" id="picture_input' + row_index + '">' +
        '                                            <div class="col-sm-6">' +
        '                                                <input class="form-control-file picture"' +
        '  type="file"' +
        ' name="picture[]" onchange="inputImageShow(this)" accept="image/*" data-pi_no="' + row_index + '">' +
        '                                            </div>' +
        '                                            <div class="col-md-4">' +
        '                                                <img class="d-none image_preview" id="image_preview' + row_index + '" style="height:50px; width:80px; border-radious: 5px;">' +
        '                                            </div>' +
        '                                            <div class="col-sm-2">' +
        '                                                <button type="button" class="btn btn-sm btn-danger"' +
        '                                                        onclick="removePicture(' + row_index + ')"' +
        '                                                ><i class="fa' +
        '                                                fa-trash"></i></button>' +
        '                                            </div>' +
        '                                        </div>';
    $(".picture_inputs").append(htmlmapping);
}



function removePicture(index) {
    $("#picture_input" + index).remove();
}

function inputImageShow(object) {
    let row_id = $(object).data("pi_no");
    //custom.js
    image_preview(object, "image_preview" + row_id)
}

// Unuseless vehicle //

function add_useless_vehicle(vehicle_id) {


    $("#useless_vehicle_form")[0].reset()
    // parsly init
    parslyInit("useless_vehicle_form");
    $("#vehicle_id").val(vehicle_id);
    $("#useless_vehicle_modal").modal('toggle');
}

function unuseless_vehicle_list() {
    $("#unuseless_vehicle").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/vehicle/uselessVehicleList"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {

                data: 'image', name: 'image', render: function (data, type, row, meta) {
                    let picture = row.images.includes("##") ? row.images.split("##")[0] : row.images;
                    htmlmap = '<img src="' + url + '/storage/app/public/vehicles/' + picture + '" id="image_preview"' +
                        ' width="80" ' +
                        '                                             height="80" >';
                    return htmlmap;
                }
            },
            {data: 'vehicle_reg_no', name: 'vehicle_reg_no'},
            {data: 'body_type', name: 'body_type'},
            {data: 'chassis_no', name: 'chassis_no'},
            {data: 'engine_no', name: 'engine_no'},
            {data: 'useless_date', name: 'useless_date'},

        ]

    })
}

function useless_vehicle_save() {
    let vehicle_data = new FormData($("#useless_vehicle_form")[0]);

    // check validation //
    if (parslyValid("useless_vehicle_form")) {
        $.ajax({
            url: url + '/vehicle/uselessVehicleStore',
            type: 'POST',
            data: vehicle_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {


                if (response.status == "success") {
                    $("#useless_vehicle_modal").modal('toggle');
                }

                Swal.fire(
                    {
                        title: response.title,
                        text: response.message,
                        type: response.status,
                        buttons: false
                    }
                )

                $("#vehicle_table").DataTable().draw(true);


            }
        })
    }
}