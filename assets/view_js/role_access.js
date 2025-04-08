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
                    title: "Success!",
                    text: response.message,
                    icon: "success",
                    button: false,
                    timer: 2000 // Auto close after 2 seconds
                });

                // Optional: reset form or refresh page
                // form[0].reset();
                location.reload();

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


    // Trigger when a role is selected
    $(document).on('change', '#role', function () {
        const roleId = $(this).val();
              
        if (roleId) {
            $.ajax({
                url: frontend + controllerName+'/get_role_permissions', // Backend URL to fetch permissions
                type: 'POST',
                data: { role_id: roleId },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                       // Reset all checkboxes
                    $('input[type="checkbox"]').prop('checked', false);

                    // Populate checkboxes with existing permissions
                    $.each(response.permissions, function (moduleId, permissions) {
                        // Handle dashboard access permission
                        if (permissions.access === '1') {
                            $(`#access_${moduleId}`).prop('checked', true);
                        }

                        // Handle other permissions (view, add, edit, delete)
                        $.each(permissions, function (permType, isChecked) {
                            if (isChecked === '1') {
                                $(`#${permType}_${moduleId}`).prop('checked', true);
                            }
                        });
                    });
                    } else {
                        swal({
                            icon: 'warning',
                            title: 'warning!',
                            text: response.message,
                            timer: 2000,
                            buttons: false
                        });
                    }
                },
                error: function () {
                    alert('An error occurred while fetching permissions.');
                }
            });
        }
    });
