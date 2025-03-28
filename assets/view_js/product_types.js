$(document).ready(function() {
    loadTable();
});

function loadTable() {
    $("#productTypeTable").DataTable({
        "processing": true,
        "serverSide": false,
        "destroy": true,
        "ajax": {
            "url": frontend + "admin/fetch_product_type",
            "type": "GET",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" },
            { "data": "product_type_name" },
            // { 
            //     "data": "status",
            //     "render": function(status) {
            //         return status == 1 ? 
            //             '<span class="badge badge-success">Active</span>' : 
            //             '<span class="badge badge-danger">Inactive</span>';
            //     }
            // },
            {
                "data": "id",
                "render": function(id) {
                    return `
                    <button class="btn btn-primary btn-sm view_Product_type" data-id="${id}" data-toggle="modal" data-target="#viewProductTypeModal"><i class="icon-eye menu-icon"></i></button>
                    <button class="btn btn-warning btn-sm edit_Product_type" data-id="${id}" data-toggle="modal" data-target="#editProductTypeModal"> <i class="icon-pencil menu-icon"></i></button>
                    <button class="btn btn-danger btn-sm delete_Product_type" data-id="${id}"> <i class="icon-trash menu-icon"></i></button>`;
                }
            }
        ]
    });
}
$("#ProductTypeForm").on("submit", function (event) {
    event.preventDefault(); // Prevent page reload
    $.ajax({
        url: frontend + "admin/save_product_types", // URL to controller function
        type: "POST",
        data: $(this).serialize(), // Serialize form data
        dataType: "json",
        success: function (response) {
            if (response.status === "error") {
                // Show validation error below the textbox
                $("#product_type_name_error").html(response.product_type_name_error);
            } else {
                swal({
                    title: "Success!",
                    text: response.message,
                    icon: "success",
                    button: false,
                    timer: 2000 // Auto close after 2 seconds
                });

                $("#ProductTypeForm")[0].reset(); // Reset form
                $("#product_type_name_error").text(""); // Clear error message
                $('#ProductTypeTable').DataTable().ajax.reload(); // Reload DataTable
            }
        }
    });
});
 // When "View" button is clicked
 $(document).on("click", ".view_Product_type", function () {
    var id = $(this).data("id"); // Get the product type ID from data-id attribute

    $.ajax({
        url: frontend + "admin/get_product_types_details", // URL to controller function
        type: "POST",
        data: { id: id }, // Sending data as POST
        dataType: "json",
        success: function (data) {
            // Populate modal fields with fetched data
            $("#view_id").text(data.product_type.id);
            $("#view_product_type_name").text(data.product_type.product_type_name);
           
        },
        error: function () {
            alert("Error fetching data.");
        }
    });
});
$(document).on("click", ".edit_Product_type", function () {
    var id = $(this).data("id"); // Get the product type ID

    $.ajax({
        url: frontend + "admin/get_product_types_details", // Fetch data URL
        type: "POST",
        data: { id: id },
        dataType: "json",
        success: function (data) {
            $("#edit_id").val(data.product_type.id);
            $("#edit_product_type_name").val(data.product_type.product_type_name);
            $("#editProductTypeModal").modal("show"); // Open modal
        },
        error: function () {
            alert("Error fetching data.");
        }
    });
});

 // Handle form submission for update
 $("#editProductTypeForm").submit(function (e) {
    e.preventDefault();

    $.ajax({
        url: frontend + "admin/update_product_types", // Update data URL
        type: "POST",
        data: $(this).serialize(), // Serialize form data
        dataType: "json",
        success: function (response) {
            if (response.status == "success") {
                swal({
                    title: "Update!",
                    text: response.message,
                    icon: "success",
                    button: false,
                    timer: 2000 // Auto close after 2 seconds
                });
                $("#editProductTypeModal").modal("hide");
                $('#ProductTypeTable').DataTable().ajax.reload(); // Reload DataTable
                location.reload(); // Reload page
            } else {
                alert("Error updating data.");
            }
        },
        error: function () {
            alert("Error processing request.");
        }
    });
});
$(document).on("click", ".delete_Product_type", function() {
    var id = $(this).data("id"); // Get product ID from button
    $("#confirm-delete").data("id", id); // Store ID in delete button
    $("#deleteModal").modal("show"); // Show the delete confirmation modal
});

// Handle delete confirmation
$("#confirm-delete").on("click", function() {
    var id = $(this).data("id");
    $.ajax({
        url: frontend + "admin/delete_product_type", // Your API endpoint
        type: "POST",
        data: { id: id },
        dataType: "json",
        success: function(response) {
            if (response.status == "success") {
                swal({
                    icon: "success",
                    title: "Deleted!",
                    text: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });     
                $("#deleteModal").modal("hide"); // Hide modal after delete
                $('#ProductTypeTable').DataTable().ajax.reload(); // Reload DataTable
                location.reload(); // Reload page
            } else {
                swal({
                    icon: "error",
                    title: "Error!",
                    text: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });   
            }
        },
        error: function(error) {
            console.error("Error deleting product:", error);
            swal({
                icon: "error",
                title: "Error!",
                text: response.message,
                showConfirmButton: false,
                timer: 2000
            });     
        }
    });
});
