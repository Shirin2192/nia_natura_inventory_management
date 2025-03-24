$(document).ready(function () {
    loadBottleSize();

    // Load DataTable
    function loadBottleSize() {
        $.ajax({
            url: frontend + "admin/fetch_bottle_size",
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
                        { data: "bottle_size" },
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
                                    <button class="btn btn-danger btn-sm" onclick="deleteBottleSize(${data})">
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
    
    $("#bottleSizeForm").on("submit", function (event) {
        event.preventDefault(); // Prevent page reload
    
        $.ajax({
            url: frontend + "admin/save_bottle_size", // URL to controller function
            type: "POST",
            data: $(this).serialize(), // Serialize form data
            dataType: "json",
            success: function (response) {
                if (response.status === "error") {
                    // Show validation error below the textbox
                    $("#bottle_size_error").html(response.bottle_size_error);
                } else {
                    swal({
                        icon: "success",
                        title: "Updated!",
                        text: response.message,
                        button: false, // ✅ Use "button" instead of "showConfirmButton"
                        timer: 2000
                    });
    
                    $("#bottleSizeForm")[0].reset(); // Reset form
                    $("#bottle_size_error").text(""); // Clear error message
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
        url: frontend + "admin/get_bottle_size_details", // Ensure this function exists in the controller
        type: "POST",
        data: { id: id }, // Sending ID as POST data
        dataType: "json",
        success: function (data) {
            console.log(data);
            
            if (data.status === "success") {
                $("#bottle_sizeContent").html("<strong>Bottle Size Name:</strong> " + data.bottle_size.bottle_size);
                $("#bottle_sizeModal").modal("show"); // Open the modal
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
        url: frontend + "admin/get_bottle_size_details", // Backend route to get details
        type: "POST",
        data: { id: id },
        dataType: "json",
        success: function (data) {
            if (data.status === "success") {
                $("#edit_bottle_size_id").val(data.bottle_size.id); // Set hidden input for ID
                $("#edit_bottle_size").val(data.bottle_size.bottle_size); // Set input field
                $("#edit_bottle_size_modal").modal("show"); // Open the modal
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
$("#edit_bottle_size_form").on("submit", function (event) {
    event.preventDefault(); // Prevent page reload

    $.ajax({
        url: frontend + "admin/update_bottle_size", // Save updates
        type: "POST",
        data: $(this).serialize(), // Serialize form data
        dataType: "json",
        success: function (response) {
            if (response.status === "error") {
                $("#edit_bottle_size_error").html(response.bottle_size_error); // Show validation error
            } else {
               
                swal({
                    icon: "success",
                    title: "Updated!",
                    text: response.message,
                    button: false, // ✅ Use "button" instead of "showConfirmButton"
                    timer: 2000
                });
                $("#edit_bottle_size_modal").modal("hide"); // Close modal
                $("#edit_bottle_size_form")[0].reset(); // Reset form
                setTimeout(() => {
                    loadBottleSize(); // Reload DataTable
                }, 500);
              
            }
        },
        error: function () {
            console.error("Error updating Bottle Size.");
        }
    });
});

function deleteBottleSize(id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this flavour!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: frontend + "admin/delete_bottle_size",
                type: "POST",
                data: { id: id },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        swal("Deleted!", response.message, "success");
                        setTimeout(() => {
                            loadBottleSize(); // Reload DataTable
                        }, 500);
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
