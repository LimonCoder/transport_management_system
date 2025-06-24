var trip_table;
function trip_list() {
    trip_table = $("#trip_table").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/trip/list_data"
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'driver_name', name: 'driver_name' },
            { data: 'vehicle_registration_number', name: 'vehicle_registration_number' },
            { data: 'start_location', name: 'start_location' },
            { data: 'destination', name: 'destination' },
            { data: 'start_time', name: 'start_time' },
            { data: 'status', name: 'status' },
            { data: 'is_locked', name: 'is_locked' },
            {
                data: 'id',
                name: 'id',
                render: function (data, type, row, meta) {
                    let html = '';
                    html =
                        "<a href='javascript:void(0)' class='btn btn-warning btn-xs m-1'" +
                        " onclick='trip_edit(" + meta.row + ")'><i class='fa fa-edit'></i> " + message_edit + "</a>" +
                        " <a href='javascript:void(0)' class='btn btn-danger btn-xs'" +
                        " onclick='trip_delete(" + meta.row + ")'><i class='fa fa-trash'></i> " + message_delete  + " </a>";

                    return html;
                }
            },
        ]
    });
}

function add_trip() {
    $("#trip_form").attr('onsubmit', 'trip_save()');
    $("#trip_form")[0].reset();
    parslyInit("trip_form");

    $("#tripModalLabel").text("Add Trip");
    $("#trip_modal").modal('show');
}

function trip_save() {

    let trip_data = new FormData($("#trip_form")[0]);

    if (parslyValid("trip_form")) {
        $.ajax({
            url: url + '/trip/store',
            type: 'POST',
            data: trip_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                if (response.status == "success") {
                    $("#trip_modal").modal('toggle');
                }

                Swal.fire({
                    title: response.title,
                    text: response.message,
                    icon: response.status,
                    buttons: false
                });

                $("#trip_table").DataTable().draw(true);
            },
            error: function(xhr, status, error) {
                let response = JSON.parse(xhr.responseText);
                Swal.fire({
                    title: response.title || 'Error',
                    text: response.message || 'Something went wrong',
                    icon: 'error',
                    buttons: false
                });
            }
        });
    }
}

function trip_edit(row_index) {
    $("#trip_form").attr('onsubmit', 'trip_update()');
    $("#trip_form")[0].reset();

    let trip_data = trip_table.row(row_index).data();

    $("#route_id").val(trip_data.route_id);
    $("#driver_id").val(trip_data.driver_id);
    $("#driver_name").val(trip_data.driver_name);
    $("#vehicle_id").val(trip_data.vehicle_id);
    $("#vehicle_registration_number").val(trip_data.vehicle_registration_number);
    $("#start_location").val(trip_data.start_location);
    $("#destination").val(trip_data.destination);
    $("#start_time").val(formatDateTimeForInput(trip_data.start_time));
    $("#end_time").val(formatDateTimeForInput(trip_data.end_time));
    $("#distance_km").val(trip_data.distance_km);
    $("#purpose").val(trip_data.purpose);
    $("#fuel_cost").val(trip_data.fuel_cost);
    $("#total_cost").val(trip_data.total_cost);
    $("#status").val(trip_data.status);
    $("#trip_id").val(trip_data.id);
    
    $("#tripModalLabel").text("Edit Trip");
    $("#trip_modal").modal('show');
}

function trip_update() {
    let trip_data = new FormData($("#trip_form")[0]);

    if (parslyValid("trip_form")) {
        $.ajax({
            url: url + '/trip/update',
            type: 'POST',
            data: trip_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                if (response.status === "success") {
                    $("#trip_modal").modal('toggle');
                }

                Swal.fire({
                    title: response.title,
                    text: response.message,
                    icon: response.status,
                    buttons: false
                });

                $("#trip_table").DataTable().draw(true);
            },
            error: function(xhr, status, error) {
                let response = JSON.parse(xhr.responseText);
                Swal.fire({
                    title: response.title || 'Error',
                    text: response.message || 'Something went wrong',
                    icon: 'error',
                    buttons: false
                });
            }
        });
    }
}

function trip_delete(row_index) {
    let trip_data = trip_table.row(row_index).data();

    Swal.fire({
        title: "Confirm Delete",
        text: "Are you sure you want to delete this trip?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: url + '/trip/destroy',
                type: 'POST',
                data: {
                    'trip_id': trip_data.id,
                },
                dataType: 'JSON',
                success: function (response) {
                    Swal.fire(response.title, response.message, response.status);
                    $("#trip_table").DataTable().draw(true);
                },
                error: function(xhr, status, error) {
                    let response = JSON.parse(xhr.responseText);
                    Swal.fire(response.title || 'Error', response.message || 'Something went wrong', 'error');
                }
            });
        }
    });
}

// Helper function to format datetime for input field
function formatDateTimeForInput(dateTimeString) {
    if (!dateTimeString) return '';
    
    try {
        let date = new Date(dateTimeString);
        let year = date.getFullYear();
        let month = String(date.getMonth() + 1).padStart(2, '0');
        let day = String(date.getDate()).padStart(2, '0');
        let hours = String(date.getHours()).padStart(2, '0');
        let minutes = String(date.getMinutes()).padStart(2, '0');
        
        return `${year}-${month}-${day}T${hours}:${minutes}`;
    } catch (e) {
        return '';
    }
} 