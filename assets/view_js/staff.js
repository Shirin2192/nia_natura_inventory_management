$(".chosen-select").chosen({
    allow_single_deselect: true,
    heigth: '100%'
});
$("#userForm").submit(function (e) {
    e.preventDefault();

    $.ajax({
        url: frontend + "admin/save_user",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function (response) {
            if (response.status === "error") {
                // Clear previous error messages
                $(".text-danger").text("");

                // Display validation errors
                if (response.errors.first_name) {
                    $("#first_name_error").html(response.errors.first_name);
                }
                if (response.errors.last_name) {
                    $("#last_name_error").html(response.errors.last_name);
                }
                if (response.errors.email) {
                    $("#email_error").html(response.errors.email);
                }
                if (response.errors.password) {
                    $("#password_error").html(response.errors.password);
                }
                if (response.errors.role) {
                    $("#role_error").html(response.errors.role);
                }
            } else if (response.status === "success") {
                swal({
                    icon: "success",
                    title: "Added!",
                    text: response.message,
                    button: false, // ✅ Use "button" instead of "showConfirmButton"
                    timer: 2000
                });
                $("#userForm")[0].reset(); // Reset form after success
                $('#userTable').DataTable().ajax.reload(); // Refresh DataTable
                // location.reload(); // Refresh the page
            } else {
                swal({
                    icon: "error",
                    title: "Error!",
                    text: response.message,
                    button: false, // ✅ Use "button" instead of "showConfirmButton"
                    timer: 2000
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
});

$(document).ready(function () {
    var userTable = $("#userTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: frontend + "admin/get_users",
            type: "POST",
            dataSrc: function (json) {
                if (!json.data) {
                    json.data = [];
                }
                return json.data;
            }
        },
        columns: [
            { data: "id", title: "ID" },
            { data: "name", title: "Name" },
            { data: "email", title: "Email" },
            { data: "role_name", title: "Role Name" },
            {
                data: null,
                title: "Actions",
                orderable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-info btn-sm view-user" data-id="${row.id}">
                            <i class="icon-eye menu-icon"></i>
                        </button>
                        <button class="btn btn-warning btn-sm editUser" data-id="${row.id}">
                            <i class="icon-pencil menu-icon"></i>
                        </button>
                     
                    `;
                }
            //     <button class="btn btn-danger btn-sm deleteUser" data-id="${row.id}">
            //     <i class="icon-trash menu-icon"></i>
            // </button>
            }
        ],
        order: [[0, "desc"]],
        responsive: true,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ users",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        }
    });
});
$(document).on("click", ".view-user", function () {
    var user_id = $(this).data("id"); // Get user ID from button

    $.ajax({
        url: frontend + "admin/view_user",
        type: "POST",
        data: { user_id: user_id },
        dataType: "json",
        success: function (response) {
            if (response.status === true) {
                var user = response.data.user; // Extract user details
                var roles = response.data.roles; // Extract roles data
                
                // Display user details in the modal
                $("#view_first_name").text(user.name);
                $("#view_email").text(user.email);
                $("#view_role").text(user.role_name);                
                // Open the modal
                $("#viewUserModal").modal("show");
            } else {
                alert(response.message); // Show error message
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching user details:", error);
        }
    });
});

// Open Edit Modal and Fetch Staff Data
$(document).on("click", ".editUser", function () {
    var user_id = $(this).data("id"); // Get user ID from button
    $.ajax({
        url: frontend + "admin/view_user",
        type: "POST",
        data: { user_id: user_id },
        dataType: "json",
        success: function (response) {
            if (response.status === true) {
                var user = response.data.user; // Extract user details
                var roles = response.data.roles; // Extract roles data
    
                var name = user.name.split(" ");
                var first_name = name[0];
                var last_name = name.length > 1 ? name[1] : '';    
                
                $("#staff_id").val(user.id);
                $("#edit_first_name").val(first_name);
                $("#edit_last_name").val(last_name);
                $("#edit_email").val(user.email);
                  // Destroy Chosen before modifying options
                  if ($(".chosen-select").hasClass("chosen-container")) {
                    $("#edit_role").chosen("destroy");
                }
                // Populate role dropdown dynamically
                var role_options = '<option value=""></option>';              
                $.each(roles, function(_, role) {
                   
                    var selected = (role.id == user.fk_role_id) ? "selected" : "";
                    role_options += `<option value="${role.id}" ${selected}>${role.role_name}</option>`;
                });
                $("#edit_role").html(role_options); // Append new options
                // Reinitialize Chosen plugin
                $("#edit_role").chosen().trigger("chosen:updated");

                // Ensure dropdown is visible
                $("#edit_role").css("display", "block");
                $("#edit_Staff_modal").modal("show"); // Show modal
            } else {
                alert(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching staff details:", error);
        }
    });
});
// Submit Edit Form
$("#edit-staff-form").submit(function (event) {
    event.preventDefault();
    var formData = $(this).serialize(); // Get form data
    $.ajax({
        url: frontend + "admin/update_staff",
        type: "POST",
        data: formData,
        dataType: "json",
        beforeSend: function () {
            $(".text-danger").text(""); // Clear previous errors
        },
        success: function (response) {
            if (response.status === "success") {
                swal({
                    icon: "success",
                    title: "Updated!",
                    text: response.message,
                    button: false, // ✅ Use "button" instead of "showConfirmButton"
                    timer: 2000
                });
                location.reload(); // Reload page after update
            } else {
                $.each(response.errors, function (key, value) {
                    $("#edit_" + key + "_error").text(value); // Show validation errors
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Error updating staff:", error);
        }
    });
});