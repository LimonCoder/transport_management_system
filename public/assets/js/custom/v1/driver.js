var driver_table;

function driver_list() {
    driver_table = $("#driver_table").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/driver/list_data"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {
                data: 'image', name: 'image', render: function (data, type, row, meta) {
                    htmlmap = '<img src="' + url + '/storage/app/public/drivers/' + row.image + '" id="image_preview"' +
                        ' width="80" ' +
                        '                                             height="80" >'
                    return htmlmap;
                }
            },
            {data: 'name', name: 'name'},
            {data: 'mobile_no', name: 'mobile_no'},
            {data: 'vehicle_reg_no', name: 'vehicle_reg_no'},
            {
                data: 'id', name: 'id', render: function (data, type, row, meta) {
                    let html = '';
                    if (auth_type == 2){
                        html = "<a href='javascript:void(0)' class='btn btn-warning btn-xs  m-1'" +
                            " onclick='driver_edit(" + meta.row + ")' ><i class='fa fa-edit' ></i> এডিট</a>" +
                            " <a href='javascript:void(0)' class='btn btn-danger btn-xs'" +
                            " onclick='driver_delete(" + meta.row + ")' ><i class='fa fa-trash' ></i> ডিলিট</a>";
                    }else{
                        html = 'N/A';
                    }

                    return html;
                }
            },
        ]

    })
}


function add_driver() {


    $("#driver_image_preview").addClass('d-none');

    $("#driver_form")[0].reset()
    $("#row_id").val('');
    // parsly init
    parslyInit("driver_form");

    $("#driver_modal").modal('toggle');
}


function driver_save() {

    let driver_data = new FormData($("#driver_form")[0]);

    // check validation //
    if (parslyValid("driver_form")) {
        $.ajax({
            url: url + '/driver/store',
            type: 'POST',
            data: driver_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {


                if (response.status == "success") {
                    $("#driver_modal").modal('toggle');
                }

                Swal.fire(
                    {
                        title: response.title,
                        text: response.message,
                        type: response.status,
                        buttons: false
                    }
                )

                $("#driver_table").DataTable().draw(true);


            }
        })
    }

}

function driver_edit(row_index) {


    let driver_data = driver_table.row(row_index).data();

    $("#name").val(driver_data.name);
    $("#mobile_no").val(driver_data.mobile_no);
    $("#row_id").val(driver_data.id);
    $("#driver_image_preview").removeClass('d-none');
    $("#driver_image_preview").attr('src',url+'/storage/app/public/drivers/'+driver_data.image);



    $("#driver_modal").modal('toggle');
}


// delete
function driver_delete(row_index) {

    let driver_data = driver_table.row(row_index).data();


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
                url: url + '/driver/delete',
                type: 'POST',
                data: {
                    'row_id': driver_data.id,
                },
                dataType: 'JSON',
                success: function (response) {

                    Swal.fire(response.tittle, response.message, response.status);

                    $("#driver_table").DataTable().draw(true);


                }
            })


        }
    });
}


