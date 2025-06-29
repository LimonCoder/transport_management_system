
// url
var url = $('meta[name="path"]').attr('content');

var auth_type = $("#auth_type").val();

// ajax header setting
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// image preview //
function image_preview(input, destination) {

    $('#' + destination).removeClass("d-none");

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#' + destination).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}


// bd phone number validation parsly.js
window.Parsley.addValidator('mobilenumber', {
    validateString: function (value) {
        var mobile = value;

        var bd_rgx = /\+?(88)?0?1[3256789][0-9]{8}\b/;

        if (mobile.length == 11) {

            if (mobile.match(bd_rgx)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }


    },
    messages: {
        en: 'মোবাইল নাম্বার সঠিক নয়',
        fr: "মোবাইল নাম্বার সঠিক নয়"
    }
});

// valid number function
function isNumber(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
    return true;
}


function isEmpty(str) {
    return (!str || 0 === str.length);
}

function removeSpecialCharecter(str) {
    return str.replace("_", " ");
}


function validation(parameters) {
    let status = 0;
    $.each(parameters, function (key, value) {
        let el = "#" + key;

        if ($(el).parent().children('#' + key + '_error')) {
            $(el).parent().children('#' + key + '_error').html('');
        }

        if (value == 'required' && isEmpty($(el).val())) {
            var html = '';
            var field = removeSpecialCharecter(key);
            field = field.charAt(0).toUpperCase() + field.slice(1);
            html = '<p class="field_error" style="color:red;" id="' + key + '_error">' + field + ' field is required</p>';
            $(el).parent().append(html);
            status = 1;
        }

    });
    return status;
}

// parsly custom function
function parslyInit(form_name){
    $('#'+form_name).parsley();

}

function parslyValid(form_name){
    return $('#'+form_name).parsley().isValid();
}

