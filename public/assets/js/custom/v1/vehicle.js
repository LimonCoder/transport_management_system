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

                data: 'image', name: 'image', render: function (data, type, row, meta) {
                    let picture = row.images.includes("##") ? row.images.split("##")[0] : row.images;
                    htmlmap = '<img src="' + url + '/storage/app/public/vehicles/' + picture + '" id="image_preview"' +
                        ' width="80" ' +
                        '                                             height="80" >';
                    return htmlmap;
                }
            },
            {data: 'employee_name', name: 'employee_name'},
            {data: 'designation_name', name: 'designation_name'},
            {data: 'driver_name', name: 'driver_name'},
            {data: 'vehicle_reg_no', name: 'vehicle_reg_no'},
            {data: 'body_type', name: 'body_type'},
            {data: 'chassis_no', name: 'chassis_no'},
            {data: 'engine_no', name: 'engine_no'},
            {data: 'assignment_date', name: 'assignment_date'},
            {
                data: 'id', name: 'id', render: function (data, type, row, meta) {
                    let htmlmapping = '';
                    if (auth_type == 2) {
                        htmlmapping = "<a href='javascript:void(0)' class='btn btn-warning btn-xs  m-1'" +
                            " onclick='vehicle_edit(" + meta.row + ")' ><i class='fa fa-edit' ></i> এডিট</a>" +
                            " <a href='javascript:void(0)' class='btn btn-danger btn-xs'" +
                            " onclick='vehicle_delete(" + meta.row + ")' ><i class='fa fa-trash' ></i> ডিলিট</a>" +
                            " <a href='javascript:void(0)' class='btn btn-secondary btn-xs'" +
                            " onclick='add_useless_vehicle(" + row.id + ")' ><i class='fas fa-car-crash' ></i>" +
                            " অকেজো</a>";
                    } else {
                        htmlmapping = 'N/A';
                    }

                    return htmlmapping;
                }
            },
        ]

    })
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


                if (response.status == "success") {
                    $("#vehicle_modal").modal('toggle');
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

                // error msg
                if (typeof response.errors != "undefined") {
                    if (response.errors.vehicle_reg_no) {
                        let error_msg = response.errors.vehicle_reg_no[0];
                        $("#vehicle_reg_no_error").text(error_msg);
                    }
                }


            }
        })
    }

}

function vehicle_edit(row_index) {

    $("#vehicle_form").attr('onsubmit', 'vehicle_update()')

    let vehicle_data = vehicle_table.row(row_index).data();

    let vehicle_images = vehicle_data.images.includes("##") ? vehicle_data.images.split("##") : [vehicle_data.images];
    let html = '';

    $("#employee_id").val(vehicle_data.employee_id);
    $("#driver_id").val(vehicle_data.driver_id);
    $("#vehicle_reg_no").val(vehicle_data.vehicle_reg_no);
    $("#body_type").val(vehicle_data.body_type);
    $("#chassis_no").val(vehicle_data.chassis_no);
    $("#engine_no").val(vehicle_data.engine_no);
    $("#develop_year").val(vehicle_data.develop_year);
    $("#fitness_duration").val(vehicle_data.fitness_duration);
    $("#tax_token_duration").val(vehicle_data.tax_token_duration);
    $("#assignment_date").val(vehicle_data.assignment_date);
    $("#row_id").val(vehicle_data.id);

    $("#previous_images").removeClass('d-none');

    vehicle_images.forEach(function (item) {
        html += '<img class="m-1" src="' + url + '/storage/app/public/vehicles/' + item + '" width="50" height="50">';
    })
    $("#previous_images").html(html);


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

                if (response.status == "success") {
                    $("#vehicle_modal").modal('toggle');
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


                // error msg
                if (typeof response.errors != "undefined") {
                    if (response.errors.vehicle_reg_no) {
                        let error_msg = response.errors.vehicle_reg_no[0];
                        $("#vehicle_reg_no_error").text(error_msg);
                    }
                }


            }
        })
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

