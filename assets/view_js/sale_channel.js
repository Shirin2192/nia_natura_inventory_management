$(document).ready(function () {
    loadSaleChannel();

    // Load DataTable
    function loadSaleChannel() {
        $.ajax({
            url: frontend + "admin/fetch_sale_channel",
            type: "GET",
            dataType: "json",
            success: function (data) {

                if ($.fn.DataTable.isDataTable("#SalechannelTable")) {
                    $("#SalechannelTable").DataTable().destroy(); // Destroy previous instance
                }
                $("#SalechannelTable").DataTable({
                    destroy: true, // Ensure it gets reinitialized
                    data: data,
                    columns: [
                        { data: "sale_channel" },
                        {
                            data: "id",
                            render: function (data) {
                                return `
                                    <button class="btn btn-info btn-sm" onclick="viewSaleChannel(${data})">
                                        <i class="icon-eye menu-icon"></i>
                                    </button>
                                    <button class="btn btn-warning btn-sm" onclick="editSaleChannel(${data})">
                                        <i class="icon-pencil menu-icon"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteSaleChannel(${data})">
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
    
    $("#SaleChannelForm").on("submit", function (event) {
        event.preventDefault(); // Prevent page reload
    
        $.ajax({
            url: frontend + "admin/save_sale_channel", // URL to controller function
            type: "POST",
            data: $(this).serialize(), // Serialize form data
            dataType: "json",
            success: function (response) {
                if (response.status === "error") {
                    // Show validation error below the textbox
                    $("#sale_channel_error").html(response.sale_channel_error);
                } else {
                    swal({
                        icon: "success",
                        title: "Added!",
                        text: response.message,
                        button: false, // ✅ Use "button" instead of "showConfirmButton"
                        timer: 2000
                    });
    
                    $("#SaleChannelForm")[0].reset(); // Reset form
                    $("#sale_channel_error").text(""); // Clear error message
                    setTimeout(() => {
                        loadSaleChannel(); // Reload DataTable
                    }, 500);
                }
            }
        });
    });
});

function viewSaleChannel(id) {
    $.ajax({
        url: frontend + "admin/get_sale_channel_details", // Ensure this function exists in the controller
        type: "POST",
        data: { id: id }, // Sending ID as POST data
        dataType: "json",
        success: function (data) {
            console.log(data);
            
            if (data.status === "success") {
                $("#sale_channelContent").html("<strong>Sale Channel:</strong> " + data.sale_channel.sale_channel);
                $("#sale_channelModal").modal("show"); // Open the modal
            } else {
                swal({
                    icon: "error",
                    title: "Oops...",
                    text: "Error fetching Sale Channel details!",
                });
            }
        },
        error: function () {
            console.error("Failed to fetch Sale Channel details.");
        }
    });
}

function editSaleChannel(id) {
    $.ajax({
        url: frontend + "admin/get_sale_channel_details", // Backend route to get details
        type: "POST",
        data: { id: id },
        dataType: "json",
        success: function (data) {
            if (data.status === "success") {
                $("#edit_sale_channel_id").val(data.sale_channel.id); // Set hidden input for ID
                $("#edit_sale_channel").val(data.sale_channel.sale_channel); // Set input field
                $("#edit_sale_channel_modal").modal("show"); // Open the modal
            } else {
                swal({
                    icon: "error",
                    title: "Oops...",
                    text: "Error fetching Sale Channel details!",
                });               
            }
        },
        error: function () {
            console.error("Failed to fetch Sale Channel details.");
        }
    });
}


// Save updated Sale Channel
$("#edit_sale_channel_form").on("submit", function (event) {
    event.preventDefault(); // Prevent page reload

    $.ajax({
        url: frontend + "admin/update_sale_channel", // Save updates
        type: "POST",
        data: $(this).serialize(), // Serialize form data
        dataType: "json",
        success: function (response) {
            if (response.status === "error") {
                $("#edit_sale_channel_error").html(response.sale_channel_error); // Show validation error
            } else {               
                swal({
                    icon: "success",
                    title: "Updated!",
                    text: response.message,
                    button: false, // ✅ Use "button" instead of "showConfirmButton"
                    timer: 2000
                });
                $("#edit_sale_channel_modal").modal("hide"); // Close modal
                $("#edit_sale_channel_form")[0].reset(); // Reset form
                // setTimeout(() => {
                //     loadSaleChannel(); // Reload DataTable
                // }, 500);
                location.reload();  
              
            }
        },
        error: function () {
            console.error("Error updating Bottle Size.");
        }
    });
});

function deleteSaleChannel(id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this Sale Channel!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: frontend + "admin/delete_sale_channel",
                type: "POST",
                data: { id: id },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        swal("Deleted!", response.message, "success");
                        // setTimeout(() => {
                        //     loadSaleChannel(); // Reload DataTable
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
