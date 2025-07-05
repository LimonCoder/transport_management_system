// Get base URL from meta tag
var url = $('meta[name="path"]').attr('content');

var organization_table;
function organization_list() {
    organization_table = $("#organization_table").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/organizations/list_data",
            type: "GET",
            dataType: "JSON",
            error: function(xhr, error, thrown) {
                console.error('DataTables AJAX error:', error, thrown);
                console.error('Response:', xhr.responseText);
                console.error('Status:', xhr.status);
                
                // Try to parse response for better error message
                let errorMessage = 'Unable to load organization data. Please refresh the page and try again.';
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
            { data: 'org_code', name: 'org_code' },
            { data: 'name', name: 'name' },
            { 
                data: 'address', 
                name: 'address',
                render: function(data, type, row) {
                    if (data && data.length > 50) {
                        return data.substring(0, 50) + '...';
                    }
                    return data || '';
                }
            },
            { data: 'org_type', name: 'org_type' },
            { data: 'operator_username', name: 'operator_username' },
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
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false
            },
        ]
    });
}

function add_organization() {
    $("#organization_form")[0].reset();
    $("#organization_id").val(''); // Clear organization_id for new organization
    parslyInit("organization_form");

    // Enable organization code field for new organization
    $("#organization_code").prop('readonly', false);

    $("#organizationModalLabel").text("Add Organization");
    $("#organization_modal").modal('show');
}

function organization_save() {
    let organization_data = new FormData($("#organization_form")[0]);

    // Clear previous validation errors
    $(".text-danger").text("");

    if (parslyValid("organization_form")) {
        $.ajax({
            url: url + '/organizations/store',
            type: 'POST',
            data: organization_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                    $("#organization_modal").modal('hide');
                    $("#organization_form")[0].reset();

                    Swal.fire({
                        title: 'success',
                        text: response.message,
                        icon: 'success'
                    });

                $("#organization_table").DataTable().draw(true);
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        $(`#${field}_error`).text(errors[field][0]);
                    }
                } else {
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
            }
        });
    }
}

function organization_edit(organization_id) {
    $("#organization_form")[0].reset();

    // Get organization data via AJAX
    $.ajax({
        url: url + '/organizations/' + organization_id,
        type: 'GET',
        dataType: 'JSON',
        success: function (response) {
            if (response.status === "success") {
                let organization_data = response.data;
                
                // Populate form fields
                $("#organization_code").val(organization_data.org_code);
                $("#name").val(organization_data.name);
                $("#address").val(organization_data.address);
                $("#org_type").val(organization_data.org_type);
                $("#organization_id").val(organization_data.id);
                
                // Disable organization code field for editing
                $("#organization_code").prop('readonly', true);
                
                $("#organizationModalLabel").text("Edit Organization");
                $("#organization_modal").modal('show');
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response.message || 'Failed to load organization data',
                    icon: 'error',
                    buttons: false
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', xhr.responseText);
            Swal.fire({
                title: 'Error',
                text: 'Failed to load organization data',
                icon: 'error',
                buttons: false
            });
        }
    });
}

function organization_update() {
    let organization_data = new FormData($("#organization_form")[0]);

    if (parslyValid("organization_form")) {
        $.ajax({
            url: url + '/organizations/update',
            type: 'POST',
            data: organization_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                if (response.status === "success") {
                    $("#organization_modal").modal('hide');
                }

                Swal.fire({
                    title: response.title,
                    text: response.message,
                    icon: response.status,
                    buttons: false
                });

                $("#organization_table").DataTable().draw(true);
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

function organization_delete(organization_id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url + '/organizations/delete',
                type: 'POST',
                data: {
                    organization_id: organization_id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'JSON',
                success: function (response) {
                    Swal.fire({
                        title: response.title,
                        text: response.message,
                        icon: response.status,
                        buttons: false
                    });

                    $("#organization_table").DataTable().draw(true);
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
                        title: response.title || 'Delete Failed!',
                        text: response.message || 'Something went wrong',
                        icon: 'error',
                        buttons: false
                    });
                }
            });
        }
    });
}

function impersonate_login(user_id) {
    Swal.fire({
        title: 'Impersonate User',
        text: "Are you sure you want to login as this organization's operator?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, impersonate!'
    }).then((result) => {
        
        if (result.value) {
            $.ajax({
                url: url + '/organizations/impersonate',
                type: 'POST',
                data: {
                    user_id: user_id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'JSON',
                success: function (response) {
                    Swal.fire({
                        title: response.title,
                        text: response.message,
                        icon: response.status,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        if (response.status === 'success' && response.redirect_url) {
                            window.location.href = response.redirect_url;
                        }
                    });
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
                        title: response.title || 'Impersonate Failed!',
                        text: response.message || 'Something went wrong',
                        icon: 'error',
                        buttons: false
                    });
                }
            });
        }
    });
}

function switch_back() {
    Swal.fire({
        title: 'Switch Back',
        text: "Are you sure you want to switch back to your original account?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, switch back!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url + '/organizations/switch-back',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'JSON',
                success: function (response) {
                    Swal.fire({
                        title: response.title,
                        text: response.message,
                        icon: response.status,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        if (response.status === 'success' && response.redirect_url) {
                            window.location.href = response.redirect_url;
                        }
                    });
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
                        title: response.title || 'Switch Back Failed!',
                        text: response.message || 'Something went wrong',
                        icon: 'error',
                        buttons: false
                    });
                }
            });
        }
    });
} 