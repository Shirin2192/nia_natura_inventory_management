$(".chosen-select").chosen({
    allow_single_deselect: true,
    heigth: '100%'
});
$("#userForm").on("submit", function (event) {
    event.preventDefault(); // Prevent page reload

    $.ajax({
        url: frontend + "admin/save_user", // URL to controller function
        type: "POST",
        data: $(this).serialize(), // Serialize form data
        dataType: "json",
        beforeSend: function () {
            $(".btn-primary").prop("disabled", true).text("Submitting...");
            $(".error-message").remove(); // Remove previous error messages
        },
        success: function (response) {
            if (response.status ="success") {
                swal({
                    icon: "success",
                    title: "Added!",
                    text: response.message,
                    button: false, // Use "button" instead of "showConfirmButton"
                    timer: 2000
                });

                $("#userForm")[0].reset(); // Reset form
                $('#userTable').DataTable().ajax.reload(); // Refresh DataTable
            } else {
                // Display validation errors
                $.each(response.errors, function (key, message) {
                    var input = $('[name="' + key + '"]');
                    input.after('<span class="error-message" style="color: red;">' + message + '</span>');
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Error submitting form:", error);
        },
        complete: function () {
            $(".btn-primary").prop("disabled", false).text("Submit");
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
                        <button class="btn btn-info btn-sm" onclick="viewSaleChannel(${row.id})">
                            <i class="icon-eye menu-icon"></i>
                        </button>
                        <button class="btn btn-warning btn-sm" onclick="editSaleChannel(${row.id})">
                            <i class="icon-pencil menu-icon"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteSaleChannel(${row.id})">
                            <i class="icon-trash menu-icon"></i>
                        </button>
                    `;
                }
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
