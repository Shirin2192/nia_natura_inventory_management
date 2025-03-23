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



var search_option = {
    url: function(phrase) {
        return frontend_path + "ecom/search_list_data";
    },

    getValue: function(element) {
        return element.product_name;
    },

    ajaxSettings: {
        dataType: "json",
        method: "POST",
        data: {
            dataType: "json"
        }
    },

    preparePostData: function(data) {
        data.phrase = $("#search").val();
        return data;
    },
    list: {
        match: {
            enabled: true
        }
    },
    requestDelay: 400
};
$("#search").easyAutocomplete(search_option);


$(document).on("change", "#search", function() {
    var search_data = $('#search').val();
    $.ajax({
        type: "POST",
        url: frontend_path + "Ecom/get_sub_id_on_search_data",
        data: {
            search_data: search_data,
        },
        dataType: "json",
        cache: false,
        success: function(result) {
            if (result.status == 'success') {
                window.open(result["url"], '_blank');
            }
        }
    });
});

$("#search").keypress(function(event) {

    if (event.which == 13) {
        search_data = $('#search').val();

        if (search_data == "") {
            // swal("Please Enter The Link", "info", {
            //   button: "Ok",
            // });
            swal("Please Enter The Link");

        } else {
            $.ajax({
                url: frontend_path + "ecom/mailpack_search",
                method: "POST",
                data: {
                    search_data: search_data,
                },
                dataType: "json",
                beforeSend: function() {
                    // $("#loader1").fadeIn("slow");
                    document.getElementById('loader1').style.visibility = "visible";
                },
                success: function(response) {
                    document.getElementById('loader1').style.visibility = "hidden";
                    window.location.replace(response['url']);
                }
            });
        }
    }
});

function mailpack_search() {
    search_data = $('#search').val();
    if (search_data == "") {
        // swal("Please Enter The Link", "info", {
        //   button: "Ok",
        // });
        swal("Please Enter The Link");

    } else {
        $.ajax({
            url: frontend_path + "ecom/mailpack_search",
            method: "POST",
            data: {
                search_data: search_data,
            },
            dataType: "json",
            beforeSend: function() {
                // $("#loader1").fadeIn("slow");
                document.getElementById('loader1').style.visibility = "visible";
            },
            success: function(response) {
                document.getElementById('loader1').style.visibility = "hidden";
                window.location.replace(response['url']);
            }
        });
    }
}


function myFunction(x) {
    // x.style.background = "yellow";

    $.ajax({
        url: frontend_path + "ecom/get_external_link",
        method: "POST",
        dataType: "json",

        success: function(response) {
            // console.log(response);
            var info = response['link'];
            console.log(info);
            // x.info['link'];

            $.each(info, function(key, value) {
                // alert(key + ": " + value['link']);
                // $(this).autocomplete("search", x.value['link'];
                x.autocomplete('search ', value[' link ']);
            });
        }
    });
}

