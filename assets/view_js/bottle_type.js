$(document).ready(function () {
    loadBottleSize();

    // Load DataTable
    function loadBottleSize() {
        $.ajax({
            url: frontend + "admin/fetch_bottle_type",
            type: "GET",
            dataType: "json",
            success: function (data) {

                if ($.fn.DataTable.isDataTable("#bottleSizeTable")) {
                    $("#bottleSizeTable").DataTable().destroy(); // Destroy previous instance
                }
                $("#bottleSizeTable").DataTable({
                    destroy: true, // Ensure it gets reinitialized
                    data: data,
                    columns: [
                        { data: "bottle_type" },
                        {
                            data: "id",
                            render: function (data) {
                                return `
                                    <button class="btn btn-info btn-sm" onclick="viewBottleSize(${data})">
                                        <i class="icon-eye menu-icon"></i>
                                    </button>
                                    <button class="btn btn-warning btn-sm" onclick="editBottleSize(${data})">
                                        <i class="icon-pencil menu-icon"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteBottleType(${data})">
                                        <i class="icon-trash menu-icon"></i>
                                    </button>`;
                            }
                        }
                    ]
                });
            },
            error: function () {
                console.error("Error fetching Bottle Size.");
            }
        });
    }
    
    $("#bottleTypeForm").on("submit", function (event) {
        event.preventDefault(); // Prevent page reload
    
        $.ajax({
            url: frontend + "admin/save_bottle_type", // URL to controller function
            type: "POST",
            data: $(this).serialize(), // Serialize form data
            dataType: "json",
            success: function (response) {
                if (response.status === "error") {
                    // Show validation error below the textbox
                    $("#bottle_type_error").html(response.bottle_type_error);
                } else {
                    swal({
                        icon: "success",
                        title: "Added!",
                        text: response.message,
                        button: false, // ✅ Use "button" instead of "showConfirmButton"
                        timer: 2000
                    });
    
                    $("#bottleTypeForm")[0].reset(); // Reset form
                    $("#bottle_type_error").text(""); // Clear error message
                    setTimeout(() => {
                        loadBottleSize(); // Reload DataTable
                    }, 500);
                }
            }
        });
    });
});

function viewBottleSize(id) {
    $.ajax({
        url: frontend + "admin/get_bottle_type_details", // Ensure this function exists in the controller
        type: "POST",
        data: { id: id }, // Sending ID as POST data
        dataType: "json",
        success: function (data) {
            console.log(data);
            
            if (data.status === "success") {
                $("#bottle_typeContent").html("<strong>Bottle Type:</strong> " + data.bottle_type.bottle_type);
                $("#BottleTypeModal").modal("show"); // Open the modal
            } else {
                swal({
                    icon: "error",
                    title: "Oops...",
                    text: "Error fetching flavour details!",
                });
            }
        },
        error: function () {
            console.error("Failed to fetch flavour details.");
        }
    });
}

function editBottleSize(id) {
    $.ajax({
        url: frontend + "admin/get_bottle_type_details", // Backend route to get details
        type: "POST",
        data: { id: id },
        dataType: "json",
        success: function (data) {
            if (data.status === "success") {
                $("#edit_bottle_type_id").val(data.bottle_type.id); // Set hidden input for ID
                $("#edit_bottle_type").val(data.bottle_type.bottle_type); // Set input field
                $("#edit_bottle_type_modal").modal("show"); // Open the modal
            } else {
                swal({
                    icon: "error",
                    title: "Oops...",
                    text: "Error fetching flavour details!",
                });               
            }
        },
        error: function () {
            console.error("Failed to fetch flavour details.");
        }
    });
}


// Save updated flavour
$("#edit_bottle_type_form").on("submit", function (event) {
    event.preventDefault(); // Prevent page reload

    $.ajax({
        url: frontend + "admin/update_bottle_type", // Save updates
        type: "POST",
        data: $(this).serialize(), // Serialize form data
        dataType: "json",
        success: function (response) {
            if (response.status === "error") {
                $("#edit_bottle_type_error").html(response.bottle_type_error); // Show validation error
            } else {
               
                swal({
                    icon: "success",
                    title: "Updated!",
                    text: response.message,
                    button: false, // ✅ Use "button" instead of "showConfirmButton"
                    timer: 2000
                });
                $("#edit_bottle_type_modal").modal("hide"); // Close modal
                $("#edit_bottle_type_form")[0].reset(); // Reset form
                // setTimeout(() => {
                //     loadBottleSize(); // Reload DataTable
                // }, 500);
                location.reload();
              
            }
        },
        error: function () {
            console.error("Error updating Bottle Size.");
        }
    });
});

function deleteBottleType(id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this flavour!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: frontend + "admin/delete_bottle_type",
                type: "POST",
                data: { id: id },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        swal("Deleted!", response.message, "success");
                        // setTimeout(() => {
                        //     loadBottleSize(); // Reload DataTable
                        // }, 500);
                        location.reload();
                    } else {
                        swal("Error!", response.message, "error");
                    }
                },
                error: function () {
                    swal("Error!", "Something went wrong.", "error");
                }
            });
        }
    });
}
