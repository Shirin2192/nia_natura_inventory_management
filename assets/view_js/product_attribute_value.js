$(".chosen-select").chosen({
    allow_single_deselect: true,
    heigth: '100%'
});

$(document).ready(function () { 
    let currentPermission = null; // Define it globally inside ready()
    var table = $("#ProductAttributeValueTable").DataTable({
        processing: false, // No server-side processing
        serverSide: false, // Fetch data locally
        ajax: {
            url: frontend + controllerName+"/get_product_attributes_value_detail",
            type: "POST",
            dataSrc: function (json) {
                const permissions = json.permissions;
                const currentSidebarId = json.current_sidebar_id;
                currentPermission = permissions[currentSidebarId];
                return json.data; // Ensure data is correctly mapped
            }
        },
        columns: [
            // { data: "id", title: "ID" },  // ✅ New Column for ID
            { data: "attribute_name", title: "Attribute Name" },
            { data: "attribute_value", title: "Attribute Value" },
            {
                data: "id",
                title: "Action",
                orderable: false,
                render: function (data, type, row) {
                    let actions = '';

                    // ✅ Check if currentPermission is available
                    if (currentPermission) {
                        if (currentPermission.can_view === "1") {
                            actions += `
                        <button class="btn btn-sm btn-primary view-attribute" 
                            data-attribute="${row.attribute_name}" 
                            data-type="${row.attribute_value || ''}" 
                            data-id="${row.id}" 
                            data-toggle="modal" data-target="#viewProductAttributeModal">
                            <i class="icon-eye menu-icon"></i>
                        </button>`;

                       }
                        if (currentPermission.can_edit === "1") {
                            actions += ` <button class="btn btn-sm btn-warning edit-attribute" 
                            data-attribute="${row.attribute_name}" 
                            data-type="${row.attribute_value || ''}" 
                            data-id="${row.id}" 
                            data-toggle="modal" data-target="#editProductAttributeModal">
                            <i class="icon-pencil menu-icon"></i>
                        </button>`;
                    }
                    if (currentPermission.can_delete === "1") {
                        actions += `<button class="btn btn-sm btn-danger delete-attribute" 
                            data-attribute="${row.attribute_name}" 
                            data-type="${row.attribute_value || ''}" 
                            data-id="${row.id}" 
                            data-toggle="modal" data-target="#deleteProductAttributeValueModal">
                            <i class="icon-trash menu-icon"></i>
                        </button>`;
                    }
                }
                return actions || '-';
                }
            }
        ],
        order: [[0, "asc"]],  // ✅ Order by ID (optional)
        pageLength: 10,
        responsive: true
    });
});



$("#productAttributeValueForm").on("submit", function (event) {
    event.preventDefault(); // Prevent page reload
    $.ajax({
        url: frontend + controllerName+"/save_product_attributes_value", // URL to controller function
        type: "POST",
        data: $(this).serialize(), // Serialize form data
        dataType: "json",
        success: function (response) {
            if (response.status === "error") {
                // Show validation error below the textbox
                $("#fk_attribute_id_error").html(response.fk_attribute_id_error);
                $("#attribute_value_error").html(response.attribute_value_error);
                setTimeout(function () {
                    $("#fk_attribute_id_error").text("");
                    $("#attribute_value_error").text("");
                }, 1500);
            } else {
                swal({
                    title: "Success!",
                    text: response.message,
                    icon: "success",
                    button: false,
                    timer: 2000 // Auto close after 2 seconds
                });
                $("#productAttributeValueForm")[0].reset(); // Reset form
                
                $("#attribute_value_error").html(""); // Clear error message
                $("#fk_attribute_id_error").html(""); // Clear error message
                $(".chosen-select").val("").trigger("chosen:updated"); // Clear chosen select
                $('#ProductAttributeValueTable').DataTable().ajax.reload(); // Reload DataTable
                
            }
        }
    });
});

    // View Attribute
    $(document).on("click", ".view-attribute", function () {
        var attrId = $(this).data("id"); // Get Attribute ID
    
        $.ajax({
            url: frontend + controllerName+"/get_product_attributes_value_detail_id", // Backend Controller URL
            type: "POST",
            data: { id: attrId }, // Send ID to Backend
            dataType: "json",
            success: function (response) {
                if (response.status == "success") {
                    $("#view_attribute_name").text(response.data.attribute_name);
                    $("#view_attribute_value").text(response.data.attribute_value);
                    $("#viewProductAttributeModal").modal("show"); // Show the Modal
                } else {
                    alert("Error: Unable to fetch data.");
                }
            },
            error: function () {
                alert("Error: Could not retrieve data.");
            }
        });
    });
    

    // Edit Attribute
    $(document).on("click", ".edit-attribute", function () {
        var attrId = $(this).data("id"); // Get Attribute ID
    
        $.ajax({
            url: frontend + controllerName+"/get_product_attributes_value_detail_id", // Backend Controller URL
            type: "POST",
            data: { id: attrId }, // Send ID to Backend
            dataType: "json",
            success: function (response) {
                if (response.status == "success") {                
                    $("#edit_attribute_name").html(response.data.attribute_name); // Set Attribute Name                     
                    $("#edit_attribute_value").val(response.data.attribute_value);
                    
                    $("#edit_attribute_value_id").val(response.data.id); // Set ID
                    $("#editProductAttributeValueModal").modal("show"); // Show Modal
                } else {
                    alert("Error: Unable to fetch data.");
                }
            },
            error: function () {
                alert("Error: Could not retrieve data.");
            }
        });
    });
    
    $("#editAttributeValueForm").on("submit", function (event) {
        event.preventDefault(); // Prevent page reload
    
        $.ajax({
            url: frontend + controllerName+"/update_product_attributes_value", // Save updates
            type: "POST",
            data: $(this).serialize(), // Serialize form data
            dataType: "json",
            success: function (response) {
                if (response.status === "error") {
                    // Display validation errors for all fields
                    $("#edit_attribute_value_error").html(response.attribute_type_error || "");
                    setTimeout(function () {
                        $("#edit_attribute_value_error").text("");
                       
                    }, 1500);
                } else {
                   
                    swal({
                        icon: "success",
                        title: "Updated!",
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });     
                    $("#editProductAttributeValueModal").modal("hide"); // Close modal
                    $("#editAttributeValueForm")[0].reset(); // Reset form
                    // loadFlavours(); // Refresh DataTable         
                    location.reload();  
                  
                }
            },
            error: function () {
                console.error("Error updating flavour.");
            }
        });
    });

    // Delete Attribute
    $(document).on("click", ".delete-attribute", function () {
        var attrId = $(this).data("id"); // Get Attribute ID
        var attrName = $(this).data("attribute"); // Get Attribute Name
    
        // Set the attribute details in the modal
        $("#delete_attribute_name").text(attrName);
        $("#delete_attribute_value_id").val(attrId);
    
        // Show the delete modal
        $("#deleteProductAttributeModal").modal("show");
    });
    
    // Handle the confirm delete button click
    $("#confirmDeleteAttribute").on("click", function () {
        var attrId = $("#delete_attribute_value_id").val(); // Get the attribute ID from hidden input
    
        $.ajax({
            url: frontend + controllerName+"/delete_product_attributes_value", // Backend URL
            type: "POST",
            data: { id: attrId }, // Send ID to backend
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    swal({
                        icon: "success",
                        title: "Delete!",
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });   
                    $("#deleteProductAttributeValueModal").modal("hide"); // Hide modal after successful deletion
                    location.reload(); // Refresh the page or update the table dynamically
                } else {
                    alert("Error: Unable to delete attribute.");
                }
            },
            error: function () {
                alert("Error: Could not connect to the server.");
            }
        });
    });
    