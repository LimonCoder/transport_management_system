// Get base URL from meta tag
var url = $('meta[name="path"]').attr('content');

var notice_table;
function notice_list() {
    notice_table = $("#notice_table").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/notice/list_data",
            type: "GET",
            dataType: "JSON",
            error: function(xhr, error, thrown) {
                console.error('DataTables AJAX error:', error, thrown);
                console.error('Response:', xhr.responseText);
                console.error('Status:', xhr.status);
                
                // Try to parse response for better error message
                let errorMessage = 'Unable to load notice data. Please refresh the page and try again.';
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
                name: 'status'
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
                        " onclick='notice_edit(" + meta.row + ")'><i class='fa fa-edit'></i> " + message_edit + "</a>" +
                        " <a href='javascript:void(0)' class='btn btn-danger btn-xs'" +
                        " onclick='notice_delete(" + meta.row + ")'><i class='fa fa-trash'></i> " + message_delete  + " </a>";

                    return html;
                }
            },
        ]
    });
}

function add_notice() {
    $("#notice_form")[0].reset();
    $("#notice_id").val(''); // Clear notice_id for new notice
    parslyInit("notice_form");

    $("#noticeModalLabel").text("Add Notice");
    $("#notice_modal").modal('show');
}

function notice_save() {
    let notice_data = new FormData($("#notice_form")[0]);

    if (parslyValid("notice_form")) {
        $.ajax({
            url: url + '/notice/store',
            type: 'POST',
            data: notice_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                if (response.success) {
                    $("#notice_modal").modal('hide');
                }

                Swal.fire({
                    title: response.title || 'Success!',
                    text: response.message,
                    icon: response.success ? 'success' : 'error',
                    buttons: false
                });

                $("#notice_table").DataTable().draw(true);
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

function notice_edit(row_index) {
    $("#notice_form")[0].reset();

    let notice_data = notice_table.row(row_index).data();

    // Populate form fields (org_code and status are now handled automatically)
    $("#title").val(notice_data.title);
    $("#details").val(notice_data.details);
    $("#notice_id").val(notice_data.id);
    
    $("#noticeModalLabel").text("Edit Notice");
    $("#notice_modal").modal('show');
}

function notice_update() {
    let notice_data = new FormData($("#notice_form")[0]);

    if (parslyValid("notice_form")) {
        $.ajax({
            url: url + '/notice/update',
            type: 'POST',
            data: notice_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                if (response.success) {
                    $("#notice_modal").modal('hide');
                }

                Swal.fire({
                    title: response.title || 'Success!',
                    text: response.message,
                    icon: response.success ? 'success' : 'error',
                    buttons: false
                });

                $("#notice_table").DataTable().draw(true);
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

function notice_delete(row_index) {
    let notice_data = notice_table.row(row_index).data();

    Swal.fire({
        title: "Confirm Delete",
        text: "Are you sure you want to delete this notice?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: url + '/notice/destroy',
                type: 'POST',
                data: {
                    'notice_id': notice_data.id,
                },
                dataType: 'JSON',
                success: function (response) {
                    Swal.fire(response.title, response.message, response.status);
                    $("#notice_table").DataTable().draw(true);
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