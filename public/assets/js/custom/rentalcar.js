var rentalcar_table;

function rentalcar_list() {
    rentalcar_table = $("#rentalcar_table").DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: url + "/rentalcar/list_data"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'insert_date', name: 'insert_date'},
            {data: 'vehicle_reg_no', name: 'vehicle_reg_no'},
            {data: 'body_type', name: 'body_type'},
            {data: 'total_day', name: 'total_day'},
            {data: 'total_amount', name: 'total_amount'},
            {
                data: 'id', name: 'id', render: function (data, type, row, meta) {
                    let html = '';
                    if (auth_type == 2){
                        html = "<a href='javascript:void(0)' class='btn btn-warning btn-xs  m-1'" +
                            " onclick='rentalcar_edit(" + meta.row + ")' ><i class='fa fa-edit' ></i> এডিট</a>" +
                            " <a href='javascript:void(0)' class='btn btn-danger btn-xs'" +
                            " onclick='rentalcar_delete(" + meta.row + ")' ><i class='fa fa-trash' ></i> ডিলিট</a>";
                    }else{
                        html = 'N/A';
                    }

                    return html;
                }
            },
        ]

    })
}

function add_rentalcar() {

    $("#rentalcar_form").attr('onsubmit', 'rentalcar_save()')

    $("#rentalcar_form")[0].reset()
    // parsly init
    parslyInit("rentalcar_form");

    $("#rentalcar_modal").modal('toggle');
}

function rentalcar_save(){

    let rentalcar_data = new FormData($("#rentalcar_form")[0]);

    if (parslyValid("rentalcar_form")) {
        $.ajax( {
           url: url+'/rentalcar/store',
           type:'POST',
           data:rentalcar_data,
            processData:false,
            contentType:false,
            dataType:'JSON',
            success: function (response) {

               if (response.status == "success"){

                   $("#rentalcar_modal").modal('toggle');
               }
                Swal.fire(
                    {
                        title: response.title,
                        text: response.message,
                        type: response.status,
                        buttons: false
                    }
                )
                $("#rentalcar_table").DataTable().draw(true)
            }
        });
    }


}

function rentalcar_edit(row_index){

    $("#rentalcar_form").attr('onsubmit','rentalcar_update()')

    let rentalcar_data = rentalcar_table.row(row_index).data();

    $("#vehicle_id").val(rentalcar_data.vehicle_id);
    $("#from_date").val(rentalcar_data.from_date);
    $("#to_date").val(rentalcar_data.to_date);
    $("#total_day").val(rentalcar_data.total_day);
    $("#amount").val(rentalcar_data.amount);
    $("#vat").val(rentalcar_data.vat);
    $("#total_amount").val(rentalcar_data.total_amount);
    $("#income_tax").val(rentalcar_data.income_tax);
    $("#contractor_name").val(rentalcar_data.contractor_name);
    $("#address").val(rentalcar_data.address);
    $("#row_id").val(rentalcar_data.id);

    $("#rentalcar_modal").modal('toggle');


}

function rentalcar_update(){

    let rentalcar_data = new FormData($("#rentalcar_form")[0]);

    //validation
    if (parslyValid("rentalcar_form")) {
        $.ajax({
            url: url + '/rentalcar/update',
            type: 'POST',
            data: rentalcar_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {

                if (response.status == "success") {
                    $("#rentalcar_modal").modal('toggle');
                }

                Swal.fire(
                    {
                        title: response.title,
                        text: response.message,
                        type: response.status,
                        buttons: false
                    }
                )

                $("#rentalcar_table").DataTable().draw(true);

            }
        })
    }

}

function rentalcar_delete(row_index){

    let rentalcar_data = rentalcar_table.row(row_index).data();
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
                url: url + '/rentalcar/delete',
                type: 'POST',
                data: {
                    'row_id': rentalcar_data.id,
                },
                dataType: 'JSON',
                success: function (response) {

                    Swal.fire(response.tittle, response.message, response.status);

                    $("#rentalcar_table").DataTable().draw(true);


                }
            })


        }
    });
}
