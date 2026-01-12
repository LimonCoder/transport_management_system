// Get base URL from meta tag
var url = $('meta[name="path"]').attr('content');

var contact_table;
function notice_list() {
    notice_table = $("#contact_table").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/contact/list_data",
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
            { data: 'org_code', name: 'org_code' },
            { 
                data: 'name', 
                name: 'name'
            },
            { 
                data: 'email', 
                name: 'email'
            },
            { 
                data: 'message', 
                name: 'message',
                render: function(data, type, row) {
                    // Truncate long text for display
                    if (data && data.length > 50) {
                        return data.substring(0, 50) + '...';
                    }
                    return data || '';
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
        ]
    });
}
