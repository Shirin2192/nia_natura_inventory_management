$(".chosen-select").chosen({
    allow_single_deselect: true,
    heigth: '100%'
});

$('#RoleAccessForm').on('submit', function (e) {
    e.preventDefault();

    let form = $(this);
    let formData = form.serialize();

    $.ajax({
        url: frontend + controllerName+'/save_permissions',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            // Clear previous error messages
            $("#role_id_error").html('');
            $("#permissions_error").html('');

            if (response.status === true) {
                swal({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    timer: 2000,
                    buttons: false
                });

                // Optional: reset form or refresh page
                // form[0].reset();
                // location.reload();

            } else if (response.status === false && response.errors) {
                // Show validation errors
                if (response.errors.role_id_error) {
                    $("#role_id_error").html(response.errors.role_id_error);
                }
                if (response.errors.permissions_error) {
                    $("#permissions_error").html(response.errors.permissions_error);
                }
            } else if (response.status === false && response.message) {
                // Other errors like duplicate permission check
                swal({
                    icon: 'warning',
                    title: 'Warning',
                    text: response.message
                });
            }
        },
        error: function () {
            swal({
                icon: 'error',
                title: 'Oops!',
                text: 'Something went wrong. Try again.',
            });
        }
    });
});

