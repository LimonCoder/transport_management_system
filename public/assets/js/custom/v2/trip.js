// Get base URL from meta tag
var url = $('meta[name="path"]').attr('content');

var trip_table;
function trip_list() {
    trip_table = $("#trip_table").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/trip/list_data",
            type: "GET",
            dataType: "JSON",
            error: function(xhr, error, thrown) {
                console.error('DataTables AJAX error:', error, thrown);
                console.error('Response:', xhr.responseText);
                console.error('Status:', xhr.status);
                
                // Try to parse response for better error message
                let errorMessage = 'Unable to load trip data. Please refresh the page and try again.';
                try {
                    let response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        errorMessage = response.error;
                    }
                } catch (e) {
                    // Use default message
                }
                
                // Show user-friendly error message
                Swal.fire({
                    title: 'Error Loading Data',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { 
                data: 'route_name', 
                name: 'route_name'
            },
            { data: 'driver_name', name: 'driver_name' },
            { data: 'vehicle_registration_number', name: 'vehicle_registration_number' },
            { data: 'trip_initiate_date', name: 'trip_initiate_date' },
            { data: 'is_locked', name: 'is_locked' },
            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
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

// Load routes data for dropdown
function loadRoutes() {
    $.ajax({
        url: url + '/routes/list',
        type: 'GET',
        dataType: 'JSON',
        success: function(response) {
            let options = '<option value="">Select Route</option>';
            if(response.data && response.data.length > 0) {
                response.data.forEach(function(route) {
                    options += `<option value="${route.id}">${route.name || 'Route #' + route.id}</option>`;
                });
            }
            $('#route_id').html(options);
        },
        error: function(xhr, status, error) {
            console.error('Error loading routes:', error);
        }
    });
}

// Load drivers data for dropdown
function loadDrivers() {
    $.ajax({
        url: url + '/drivers/list',
        type: 'GET',
        dataType: 'JSON',
        success: function(response) {
            let options = '<option value="">Select Driver</option>';
            if(response.data && response.data.length > 0) {
                response.data.forEach(function(driver) {
                    options += `<option value="${driver.id}">${driver.name || driver.first_name + ' ' + driver.last_name}</option>`;
                });
            }
            $('#driver_id').html(options);
        },
        error: function(xhr, status, error) {
            console.error('Error loading drivers:', error);
        }
    });
}

// Load vehicles data for dropdown
function loadVehicles() {
    $.ajax({
        url: url + '/vehicles/list',
        type: 'GET',
        dataType: 'JSON',
        success: function(response) {
            let options = '<option value="">Select Vehicle</option>';
            if(response.data && response.data.length > 0) {
                response.data.forEach(function(vehicle) {
                    options += `<option value="${vehicle.id}">${vehicle.registration_number || vehicle.model}</option>`;
                });
            }
            $('#vehicle_id').html(options);
        },
        error: function(xhr, status, error) {
            console.error('Error loading vehicles:', error);
        }
    });
}

function add_trip() {
    $("#trip_form")[0].reset();
    $("#trip_id").val(''); // Clear trip_id for new trip
    parslyInit("trip_form");

    // Load dropdown data
    loadRoutes();
    loadDrivers();
    loadVehicles();

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

function trip_edit(row_index) {
    $("#trip_form")[0].reset();

    // Load dropdown data
    loadRoutes();
    loadDrivers();
    loadVehicles();

    let trip_data = trip_table.row(row_index).data();

    // Set timeout to ensure dropdowns are loaded before setting values
    setTimeout(function() {
        $("#route_id").val(trip_data.route_id);
        $("#driver_id").val(trip_data.driver_id);
        $("#vehicle_id").val(trip_data.vehicle_id);
        $("#trip_initiate_date").val(trip_data.trip_initiate_date);
        $("#trip_id").val(trip_data.id);
    }, 500);
    
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