// Get base URL from meta tag
var url = $('meta[name="path"]').attr('content');

var route_table;
function route_list() {
    route_table = $("#route_table").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/routes/list_data",
            type: "GET",
            dataType: "JSON",
            error: function(xhr, error, thrown) {
                console.error('DataTables AJAX error:', error, thrown);
                console.error('Response:', xhr.responseText);
                console.error('Status:', xhr.status);
                
                // Try to parse response for better error message
                let errorMessage = 'Unable to load route data. Please refresh the page and try again.';
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
            { data: 'title', name: 'title' },
            { 
                data: 'details', 
                name: 'details',
                render: function(data, type, row) {
                    // Truncate long text for display
                    if (data && data.length > 50) {
                        return data.substring(0, 50) + '...';
                    }
                    return data || '';
                }
            },
            { 
                data: 'status', 
                name: 'status',
                render: function(data, type, row) {
                    if (data === 'active') {
                        return '<span class="badge badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-danger">Inactive</span>';
                    }
                }
            },
            { 
                data: 'created_at', 
                name: 'created_at',
                render: function(data, type, row) {
                    if (data) {
                        return new Date(data).toLocaleDateString();
                    }
                    return '';
                }
            },
            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    let html = '';
                    html =
                        "<a href='javascript:void(0)' class='btn btn-warning btn-xs m-1'" +
                        " onclick='route_edit(" + meta.row + ")'><i class='fa fa-edit'></i> " + message_edit + "</a>" +
                        " <a href='javascript:void(0)' class='btn btn-danger btn-xs'" +
                        " onclick='route_delete(" + meta.row + ")'><i class='fa fa-trash'></i> " + message_delete  + " </a>";

                    return html;
                }
            },
        ]
    });
}

function add_route() {
    $("#route_form")[0].reset();
    $("#route_id").val(''); // Clear route_id for new route
    parslyInit("route_form");

    $("#routeModalLabel").text("Add Route");
    $("#route_modal").modal('show');
}

function route_save() {
    let route_data = new FormData($("#route_form")[0]);

    if (parslyValid("route_form")) {
        $.ajax({
            url: url + '/routes/store',
            type: 'POST',
            data: route_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                if (response.status === "success") {
                    $("#route_modal").modal('hide');
                }

                Swal.fire({
                    title: response.title,
                    text: response.message,
                    icon: response.status,
                    buttons: false
                });

                $("#route_table").DataTable().draw(true);
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                let response;
                try {
                    response = JSON.parse(xhr.responseText);
                } catch (e) {
                    response = {
                        title: 'Error',
                        message: 'Something went wrong'
                    };
                }
                
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

function route_edit(row_index) {
    $("#route_form")[0].reset();

    let route_data = route_table.row(row_index).data();

    // Populate form fields (org_code and status are now handled automatically)
    $("#title").val(route_data.title);
    $("#details").val(route_data.details);
    $("#route_id").val(route_data.id);
    
    $("#routeModalLabel").text("Edit Route");
    $("#route_modal").modal('show');
}

function route_update() {
    let route_data = new FormData($("#route_form")[0]);

    if (parslyValid("route_form")) {
        $.ajax({
            url: url + '/routes/update',
            type: 'POST',
            data: route_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                if (response.status === "success") {
                    $("#route_modal").modal('hide');
                }

                Swal.fire({
                    title: response.title,
                    text: response.message,
                    icon: response.status,
                    buttons: false
                });

                $("#route_table").DataTable().draw(true);
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                let response;
                try {
                    response = JSON.parse(xhr.responseText);
                } catch (e) {
                    response = {
                        title: 'Error',
                        message: 'Something went wrong'
                    };
                }
                
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

function route_delete(row_index) {
    let route_data = route_table.row(row_index).data();

    Swal.fire({
        title: "Confirm Delete",
        text: "Are you sure you want to delete this route?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: url + '/route/destroy',
                type: 'POST',
                data: {
                    'route_id': route_data.id,
                },
                dataType: 'JSON',
                success: function (response) {
                    Swal.fire(response.title, response.message, response.status);
                    $("#route_table").DataTable().draw(true);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    let response;
                    try {
                        response = JSON.parse(xhr.responseText);
                    } catch (e) {
                        response = {
                            title: 'Error',
                            message: 'Something went wrong'
                        };
                    }
                    
                    Swal.fire(response.title || 'Error', response.message || 'Something went wrong', 'error');
                }
            });
        }
    });
} 