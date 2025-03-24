function error_msg(data) {
    for (var key in data) {
        if (data[key] != '') {
            $("#" + key + "_error").html(data[key]).show();
        } else {
            $("#" + key + "_error").html('').hide();
        }
    }
    $('.error_msg').delay(5000).fadeOut();
}

function success_message(data) {
    for (var key in data) {
        if (data[key] != '') {
            $("#" + key + "_success").html(data[key]).show();
        } else {
            $("#" + key + "_success").html('').hide();
        }
    }
    $('.success_message').delay(5000).fadeOut();
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;

    return true;
}







