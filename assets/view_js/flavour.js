$(document).ready(function () {
    loadFlavours();

    // Load DataTable
    function loadFlavours() {
        $.ajax({
            url: frontend + "admin/fetch_flavours",
            type: "GET",
            dataType: "json",
            success: function (data) {
                var table = $('#flavourTable').DataTable();
                table.clear(); // Clear existing data
                
                $.each(data, function (index, flavour) {
                    table.row.add([
                        flavour.flavour_name,
                    `<button class="btn btn-info btn-sm" onclick="viewFlavour(${flavour.id})">
                        <i class="icon-eye menu-icon"></i>
                    </button>
                    <button class="btn btn-warning btn-sm" onclick="editFlavour(${flavour.id})">
                        <i class="icon-pencil menu-icon"></i>
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="deleteFlavour(${flavour.id})">
                        <i class="icon-trash menu-icon"></i>
                    </button>`
                    ]).draw(false);
                });
            },
            error: function () {
                console.error("Error fetching flavours.");
            }
        });
    }
    
    $("#flavourForm").on("submit", function (event) {
        event.preventDefault(); // Prevent page reload
    
        $.ajax({
            url: frontend + "admin/save_flavour", // URL to controller function
            type: "POST",
            data: $(this).serialize(), // Serialize form data
            dataType: "json",
            success: function (response) {
                if (response.status === "error") {
                    // Show validation error below the textbox
                    $("#flavour_name_error").html(response.flavour_name_error);
                } else {
                    swal({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        button: false,
                        timer: 2000 // Auto close after 2 seconds
                    });
    
                    $("#flavourForm")[0].reset(); // Reset form
                    $("#flavour_name_error").text(""); // Clear error message
                    loadFlavours();
                    // location.reload();
                }
            }
        });
    });
});

function viewFlavour(id) {
    $.ajax({
        url: frontend + "admin/get_flavour_details", // Ensure this function exists in the controller
        type: "POST",
        data: { id: id }, // Sending ID as POST data
        dataType: "json",
        success: function (data) {
            if (data.status === "success") {
                $("#flavourContent").html("<strong>Flavour Name:</strong> " + data.flavour.flavour_name);
                $("#flavourModal").modal("show"); // Open the modal
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

function editFlavour(id) {
    $.ajax({
        url: frontend + "admin/get_flavour_details", // Backend route to get details
        type: "POST",
        data: { id: id },
        dataType: "json",
        success: function (data) {
            if (data.status === "success") {
                $("#edit_flavour_id").val(data.flavour.id); // Set hidden input for ID
                $("#edit_flavour_name").val(data.flavour.flavour_name); // Set input field
                $("#editFlavourModal").modal("show"); // Open the modal
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
$("#edit_flavour_form").on("submit", function (event) {
    event.preventDefault(); // Prevent page reload

    $.ajax({
        url: frontend + "admin/update_flavour", // Save updates
        type: "POST",
        data: $(this).serialize(), // Serialize form data
        dataType: "json",
        success: function (response) {
            if (response.status === "error") {
                $("#edit_flavour_name_error").html(response.flavour_name_error); // Show validation error
            } else {
               
                swal({
                    icon: "success",
                    title: "Updated!",
                    text: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });     
                $("#editFlavourModal").modal("hide"); // Close modal
                $("#edit_flavour_form")[0].reset(); // Reset form
                // loadFlavours(); // Refresh DataTable         
                location.reload();  
              
            }
        },
        error: function () {
            console.error("Error updating flavour.");
        }
    });
});

function deleteFlavour(id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this flavour!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: frontend + "admin/delete_flavour",
                type: "POST",
                data: { id: id },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        swal("Deleted!", response.message, "success");
                        // loadFlavours(); // Reload DataTable
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
