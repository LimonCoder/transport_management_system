// Get base URL from meta tag
var url = $('meta[name="path"]').attr('content');

var trip_details_table;

function trip_details_list() {
    trip_details_table = $("#trip_details_table").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/trip/details/list_data",
            type: "GET",
            dataType: "JSON",
            error: function(xhr, error, thrown) {
                console.error('DataTables AJAX error:', error, thrown);
                console.error('Response:', xhr.responseText);
                console.error('Status:', xhr.status);
                
                let errorMessage = 'Unable to load trip details data. Please refresh the page and try again.';
                try {
                    let response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        errorMessage = response.error;
                    }
                } catch (e) {
                    // Use default message
                }
                
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
            { data: 'route_name', name: 'route_name' },
            { data: 'driver_name', name: 'driver_name' },
            { data: 'vehicle_registration_number', name: 'vehicle_registration_number' },
            { data: 'trip_initiate_date', name: 'trip_initiate_date' },
            { data: 'start_location', name: 'start_location' },
            { data: 'destination', name: 'destination' },
            { data: 'start_time', name: 'start_time' },
            { data: 'end_time', name: 'end_time' },
            { data: 'distance_km', name: 'distance_km' },
            { data: 'purpose', name: 'purpose' },
            { data: 'fuel_cost', name: 'fuel_cost' },
            { data: 'total_cost', name: 'total_cost' },
            { data: 'status', name: 'status' },
            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    let html = '';
                    html = "<a href='javascript:void(0)' class='btn btn-warning btn-xs m-1'" +
                        " onclick='trip_details_edit(" + meta.row + ")'><i class='fa fa-edit'></i> " + message_edit + "</a>";
                    return html;
                }
            },
        ]
    });
}

function trip_details_edit(row_index) {
    $("#trip_details_form")[0].reset();
    
    let trip_data = trip_details_table.row(row_index).data();
    
    // Set form values
    $("#trip_id").val(trip_data.id);
    $("#start_location").val(trip_data.start_location || '');
    $("#destination").val(trip_data.destination || '');
    $("#distance_km").val(trip_data.distance_km || '');
    $("#purpose").val(trip_data.purpose || '');
    $("#fuel_cost").val(trip_data.fuel_cost || '');
    $("#total_cost").val(trip_data.total_cost || '');
    $("#status").val(trip_data.status || 'initiate');
    $("#reject_reason").val(trip_data.reject_reason || '');
    
    // Format datetime for datetime-local input
    if (trip_data.start_time) {
        $("#start_time").val(formatDateTimeForInput(trip_data.start_time));
    }
    if (trip_data.end_time) {
        $("#end_time").val(formatDateTimeForInput(trip_data.end_time));
    }
    
    // Show/hide reject reason field based on current status
    if (trip_data.status === 'reject') {
        $('#reject_reason_field').show();
        $('#reject_reason').attr('required', true);
    } else {
        $('#reject_reason_field').hide();
        $('#reject_reason').attr('required', false);
    }
    
    $("#tripDetailsModalLabel").text("Update Trip Details");
    $("#trip_details_modal").modal('show');
}

function trip_details_update() {
    let trip_details_data = new FormData($("#trip_details_form")[0]);
    
    if (parslyValid("trip_details_form")) {
        $.ajax({
            url: url + '/trip/details/update',
            type: 'POST',
            data: trip_details_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                if (response.status === "success") {
                    $("#trip_details_modal").modal('toggle');
                }
                
                Swal.fire({
                    title: response.title,
                    text: response.message,
                    icon: response.status,
                    buttons: false
                });
                
                $("#trip_details_table").DataTable().draw(true);
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

function formatDateTimeForInput(dateTimeString) {
    if (!dateTimeString) return '';
    
    // Parse the datetime string and format it for datetime-local input
    let date = new Date(dateTimeString);
    if (isNaN(date.getTime())) return '';
    
    // Format as YYYY-MM-DDTHH:MM for datetime-local input
    let year = date.getFullYear();
    let month = String(date.getMonth() + 1).padStart(2, '0');
    let day = String(date.getDate()).padStart(2, '0');
    let hours = String(date.getHours()).padStart(2, '0');
    let minutes = String(date.getMinutes()).padStart(2, '0');
    
    return `${year}-${month}-${day}T${hours}:${minutes}`;
} 