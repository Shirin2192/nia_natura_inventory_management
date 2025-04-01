$(".chosen-select").chosen({
    allow_single_deselect: true,
    heigth: '100%'
});
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
                        { data: "channel_type" },
                        { data: "sale_channel" },
                        {
                            data: "id",
                            render: function (data) {
                                return `
                                    <button class="btn btn-info btn-sm view-sale-channel"data-id="${data}" data-target="#sale_channelModal">
                                        <i class="icon-eye menu-icon"></i>
                                    </button>
                                    <button class="btn btn-warning btn-sm edit-sale-channel" data-id="${data}" data-target="#edit_sale_channel_modal">
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

$(document).on("click", ".view-sale-channel", function () {
    var channelId = $(this).data("id");

    $.ajax({
        url: frontend + "admin/get_sale_channel_details", // Backend URL
        type: "POST",
        data: { id: channelId },
        dataType: "json",
        success: function (response) {
            if (response.status == "success") {
                // Populate modal content
                var modalContent = `
                    <p><strong>Channel Type:</strong> ${response.sale_channel.channel_type}</p>
                    <p><strong>Sale Channel:</strong> ${response.sale_channel.sale_channel}</p>
                  
                `;

                $("#sale_channelContent").html(modalContent);
                $("#sale_channelModal").modal("show"); // Show modal
            } else {
                alert("Error: Unable to fetch sale channel details.");
            }
        },
        error: function () {
            alert("Error: Could not retrieve data.");
        }
    });
});

$(document).on("click", ".edit-sale-channel", function () {
    var channelId = $(this).data("id");

    $.ajax({
        url: frontend + "admin/get_sale_channel_details", // Backend URL
        type: "POST",
        data: { id: channelId },
        dataType: "json",
        success: function (response) {
            if (response.status == "success") {
                // Populate fields in the modal
                $("#edit_sale_channel_id").val(response.sale_channel.id);
                $("#edit_sale_channel").val(response.sale_channel.sale_channel);
                $("#edit_channel_type").val(response.sale_channel.channel_type); // Select appropriate type
                $("#edit_sale_channel_modal").modal("show"); // Show modal
            } else {
                alert("Error: Unable to fetch details.");
            }
        },
        error: function () {
            alert("Error: Could not retrieve data.");
        }
    });
});



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
