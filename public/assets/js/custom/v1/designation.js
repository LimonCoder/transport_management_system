var designation_table;

function designation_list() {
    designation_table = $("#designation_table").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/designation/list_data"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {
                data: 'id', name: 'id', render: function (data, type, row, meta) {
                    let html = "<a href='javascript:void(0)' class='btn btn-warning btn-xs  m-1'" +
                        " onclick='designation_edit(" + meta.row + ")' ><i class='fa fa-edit' ></i> এডিট</a>" +
                        " <a href='javascript:void(0)' class='btn btn-danger btn-xs'" +
                        " onclick='designation_delete(" + meta.row + ")' ><i class='fa fa-trash' ></i> ডিলিট</a>";
                    return html;
                }
            },
        ]

    })
}


function add_designation() {


    $("#designation_form")[0].reset()
    // parsly init
    parslyInit("designation_form");

    $("#designation_modal").modal('toggle');
}


function designation_save() {

    let designation_data = new FormData($("#designation_form")[0]);

    // check validation //
    if (parslyValid("designation_form")) {
        $.ajax({
            url: url + '/designation/store',
            type: 'POST',
            data: designation_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {



                if (response.status == "success") {
                    $("#designation_modal").modal('toggle');
                }

                Swal.fire(
                    {
                        title: response.title,
                        text: response.message,
                        type: response.status,
                        buttons: false
                    }
                )

                $("#designation_table").DataTable().draw(true);





            }
        })
    }

}

function designation_edit(row_index) {


    let designation_data = designation_table.row(row_index).data();

    $("#name").val(designation_data.name);
    $("#row_id").val(designation_data.id);


    $("#designation_modal").modal('toggle');
}



// delete
function designation_delete(row_index) {

    let designation_data = designation_table.row(row_index).data();


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
                url: url + '/designation/delete',
                type: 'POST',
                data: {
                    'row_id': designation_data.id,
                },
                dataType: 'JSON',
                success: function (response) {

                    Swal.fire(response.tittle, response.message, response.status);

                    $("#designation_table").DataTable().draw(true);


                }
            })


        }
    });
}


