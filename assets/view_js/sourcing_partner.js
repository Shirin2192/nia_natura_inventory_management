$("#sourcing_partner_form").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: frontend + controllerName + "/save_sourcing_partner",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function (response) {
            if (response.status === "error") {
                if (response.errors.name) {
                    $("#name_error").html(response.errors.name);
                    setTimeout(() => { $("#name_error").html(""); }, 4000);
                }
                if (response.errors.email) {
                    $("#email_error").html(response.errors.email);
                    setTimeout(() => { $("#email_error").html(""); }, 4000);
                }
                if (response.errors.contact_no) {
                    $("#contact_no_error").html(response.errors.contact_no);
                    setTimeout(() => { $("#contact_no_error").html(""); }, 4000);
                }
                if (response.errors.address) {
                    $("#address_error").html(response.errors.address);
                    setTimeout(() => { $("#address_error").html(""); }, 4000);
                }
            } else if (response.status === "success") {
                swal({
                    icon: "success",
                    title: "Added!",
                    text: response.message,
                    button: false,
                    timer: 2000
                });
                $("#sourcing_partner_form")[0].reset();
                location.reload();
            } else {
                swal({
                    icon: "error",
                    title: "Error!",
                    text: response.message,
                    button: false,
                    timer: 2000
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
});
//
// Initialize the DataTable for sourcing partners
$(document).ready(function () {
    $('#sourcing_partner_table').DataTable({
        ajax: {
            url: frontend + controllerName + "/get_sourcing_partner_list",
            type: "POST",
            dataSrc: function (json) {
                const permissions = json.permissions;
                const currentSidebarId = json.current_sidebar_id;
                currentPermission = permissions[currentSidebarId];

                if (!json.data) {
                    json.data = [];
                }
                return json.data.map((item, index) => {
                    item.sr_no = index + 1; // Add Sr. No. as an auto-increment field
                    return item;
                });
            }
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;  // Auto-increment the serial number
                }
            },
            { data: 'name' },
            { data: 'email' },
            { data: 'contact_no' },
            {
                data: null,
                render: function (data, type, row) {
                    let actions = '';

                    // ✅ Check if currentPermission is available
                    if (currentPermission) {
                        if (currentPermission.can_view === "1") {
                            actions += `
                                <button class="btn btn-info btn-sm view_sourcing_partner" data-id="${row.id}">
                                    <i class="icon-eye menu-icon"></i>
                                </button>`;
                        }
                        if (currentPermission.can_edit === "1") {
                            actions += `
                                <button class="btn btn-warning btn-sm edit_sourcing_partner" data-id="${row.id}">
                                    <i class="icon-pencil menu-icon"></i>
                                </button>`;
                        }
                        if (currentPermission.can_delete === "1") {
                            actions += `<button class="btn btn-sm btn-danger delete_sourcing_partner" 
                                data-id="${row.id}" 
                                data-toggle="modal" data-target="#deleteSourcingPartnerModal">
                                <i class="icon-trash menu-icon"></i>
                            </button>`;
                        }
                    }

                    return actions || '-';
                }
            }
        ],
        dom: 'Bfrtip',  // Add the buttons container
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                title: 'Sourcing_Partners',  // Optional: Set the default filename for the Excel export
                className: 'btn btn-success btn-sm'  // Customize button style
            },
            {
                extend: 'csvHtml5',
                text: 'Export to CSV',
                title: 'Sourcing_Partners',  // Optional: Set the default filename for the CSV export
                className: 'btn btn-primary btn-sm'  // Customize button style
            }
        ]
    });
});


$(document).on("click", ".view_sourcing_partner", function () {
    var id = $(this).data("id"); // Get the sourcing partner ID from the button

    $.ajax({
        url: frontend + controllerName + "/view_sourcing_partner",
        type: "POST",
        data: { id: id },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var sourcing_partner = response.sourcing_partner; // Extract sourcing partner details
                
                // Populate the modal fields
                $("#view_name").text(sourcing_partner.name);
                $("#view_email").text(sourcing_partner.email);
                $("#view_contact_no").text(sourcing_partner.contact_no);
                $("#view_address").text(sourcing_partner.address);
                
                // Show the modal
                $("#viewSourcingPartnar").modal("show");
            } else {
                // If no data is found, show an error message
                alert("Error: " + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching sourcing partner details:", error);
            alert("An error occurred while fetching details.");
        }
    });
});



// Open Edit Modal and Fetch Staff Data
$(document).on("click", ".edit_sourcing_partner", function () {
    var id = $(this).data("id"); // Get the sourcing partner ID from the button

    $.ajax({
        url: frontend + controllerName + "/view_sourcing_partner",
        type: "POST",
        data: { id: id },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var sourcing_partner = response.sourcing_partner; // Extract sourcing partner details
                
                $("#id").val(sourcing_partner.id);
                $("#edit_name").val(sourcing_partner.name);
                $("#edit_email").val(sourcing_partner.email);
                $("#edit_contact_no").val(sourcing_partner.contact_no);
                $("#edit_address").val(sourcing_partner.address);
                $("#editSourcingPartnar").modal("show"); // Show modal
            } else {
                alert(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching staff details:", error);
        }
    });
});

// Update Sourcing Partner

$("#update_sourcing_partner_form").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: frontend + controllerName + "/update_sourcing_partner",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function (response) {
            if (response.status === "error") {
                if (response.errors.edit_name) {
                    $("#edit_name_error").html(response.errors.edit_name);
                    setTimeout(() => { $("#edit_name_error").html(""); }, 4000);
                }
                if (response.errors.edit_email) {
                    $("#edit_email_error").html(response.errors.edit_email);
                    setTimeout(() => { $("#edit_email_error").html(""); }, 4000);
                }
                if (response.errors.edit_contact_no) {
                    $("#edit_contact_no_error").html(response.errors.edit_contact_no);
                    setTimeout(() => { $("#edit_contact_no_error").html(""); }, 4000);
                }
                if (response.errors.edit_address) {
                    $("#edit_address_error").html(response.errors.edit_address);
                    setTimeout(() => { $("#edit_address_error").html(""); }, 4000);
                }
            } else if (response.status === "success") {
                swal({
                    icon: "success",
                    title: "Update!",
                    text: response.message,
                    button: false,
                    timer: 2000
                });
                $("#update_sourcing_partner_form")[0].reset();
                location.reload();
            } else {
                swal({
                    icon: "error",
                    title: "Error!",
                    text: response.message,
                    button: false,
                    timer: 2000
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
});

 // Delete Attribute
 $(document).on("click", ".delete_sourcing_partner", function () {
    var attrId = $(this).data("id"); // Get Attribute ID
   
    // Set the attribute details in the modal
    $("#delete_id").val(attrId);

    // Show the delete modal
    $("#deleteSourcingPartnerModal").modal("show");
});
// Handle the confirm delete button click
$("#confirmDeleteSourceingPartnerBtn").on("click", function () {
    var attrId = $("#delete_id").val(); // Get the attribute ID from hidden input
    $.ajax({
        url: frontend + controllerName+"/delete_sourcing_partner", // Backend URL
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
                $("#deleteSourcingPartnerModal").modal("hide"); // Hide modal after successful deletion
                location.reload(); // Refresh the page or update the table dynamically
            } else {
                alert("Error: Unable to delete Sourcing Partner.");
            }
        },
        error: function () {
            alert("Error: Could not connect to the server.");
        }
    });
});
