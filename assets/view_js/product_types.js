$(document).ready(function () {
	loadTable();
	let currentPermission = null; // Define it globally inside ready()
});

function loadTable() {
	$("#productTypeTable").DataTable({
		dom: "Bfrtip", // B = Buttons, f = filter, r = process info, t = table, i = info, p = paginate
		buttons: ["csv", "excel"],
		responsive: true,
		processing: true,
		serverSide: false,
		destroy: true,
		ajax: {
			url: frontend + controllerName + "/fetch_product_type",
			type: "POST",
			dataSrc: function (data) {
				const permissions = data.data.permissions;
				const currentSidebarId = data.data.current_sidebar_id;
				currentPermission = permissions[currentSidebarId];
				// ✅ Return the actual array of product types
				return data.response; // <-- Make sure `data.response` contains an array of product types
			},
		},
		columns: [
			{
				data: null,
				title: "Sr. No",
				render: function (data, type, row, meta) {
					return meta.row + 1;
				},
			},
			{ data: "product_type_name", title: "Product Type" },
			{
				data: "id",
				title: "Action",
				render: function (id, type, row) {
					let buttons = "";
					if (currentPermission.can_view === "1") {
						buttons += `<button class="btn btn-primary btn-sm view_Product_type" data-id="${id}" data-toggle="modal" data-target="#viewProductTypeModal"><i class="icon-eye menu-icon"></i></button> `;
					}
					if (currentPermission.can_edit === "1") {
						buttons += `<button class="btn btn-warning btn-sm edit_Product_type" data-id="${id}" data-toggle="modal" data-target="#editProductTypeModal"><i class="icon-pencil menu-icon"></i></button> `;
					}
					if (currentPermission.can_delete === "1") {
						buttons += `<button class="btn btn-danger btn-sm delete_Product_type" data-id="${id}"><i class="icon-trash menu-icon"></i></button>`;
					}
					return buttons;
				},
			},
		],
		language: {
			emptyTable: "No product types found",
		},
	});
}
$("#ProductTypeForm").on("submit", function (event) {
	event.preventDefault(); // Prevent page reload
	$.ajax({
		url: frontend + controllerName + "/save_product_types", // URL to controller function
		type: "POST",
		data: $(this).serialize(), // Serialize form data
		dataType: "json",
		success: function (response) {
			if (response.status === "error") {
				// Show validation error below the textbox
				$("#product_type_name_error").html(response.product_type_name_error);
				// Clear error message after 3 seconds
				setTimeout(function () {
					$("#product_type_name_error").text("");
				}, 1500);
			} else {
				swal({
					title: "Success!",
					text: response.message,
					icon: "success",
					button: false,
					timer: 2000, // Auto close after 2 seconds
				});

				$("#ProductTypeForm")[0].reset(); // Reset form
				$("#product_type_name_error").text(""); // Clear error message
				$("#productTypeTable").DataTable().ajax.reload(); // Reload DataTable
			}
		},
	});
});
// When "View" button is clicked
$(document).on("click", ".view_Product_type", function () {
	var id = $(this).data("id"); // Get the product type ID from data-id attribute

	$.ajax({
		url: frontend + controllerName + "/get_product_types_details", // URL to controller function
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
		},
	});
});
$(document).on("click", ".edit_Product_type", function () {
	var id = $(this).data("id"); // Get the product type ID

	$.ajax({
		url: frontend + controllerName + "/get_product_types_details", // Fetch data URL
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
		},
	});
});

// Handle form submission for update
$("#editProductTypeForm").submit(function (e) {
	e.preventDefault();

	$.ajax({
		url: frontend + controllerName + "/update_product_types", // Update data URL
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
					timer: 2000, // Auto close after 2 seconds
				});
				$("#editProductTypeModal").modal("hide");
				$("#productTypeTable").DataTable().ajax.reload(); // Reload DataTable
				location.reload(); // Reload page
			} else {
				alert("Error updating data.");
			}
		},
		error: function () {
			alert("Error processing request.");
		},
	});
});
$(document).on("click", ".delete_Product_type", function () {
	var id = $(this).data("id"); // Get product ID from button
	$("#confirm-delete").data("id", id); // Store ID in delete button
	$("#deleteModal").modal("show"); // Show the delete confirmation modal
});

// Handle delete confirmation
$("#confirm-delete").on("click", function () {
	var id = $(this).data("id");
	$.ajax({
		url: frontend + controllerName + "/delete_product_type", // Your API endpoint
		type: "POST",
		data: { id: id },
		dataType: "json",
		success: function (response) {
			if (response.status == "success") {
				swal({
					icon: "success",
					title: "Deleted!",
					text: response.message,
					showConfirmButton: false,
					timer: 2000,
				});
				$("#deleteModal").modal("hide"); // Hide modal after delete
				$("#productTypeTable").DataTable().ajax.reload(); // Reload DataTable
				// location.reload(); // Reload page
			} else {
				swal({
					icon: "error",
					title: "Error!",
					text: response.message,
					showConfirmButton: false,
					timer: 2000,
				});
			}
		},
		error: function (error) {
			console.error("Error deleting product:", error);
			swal({
				icon: "error",
				title: "Error!",
				text: response.message,
				showConfirmButton: false,
				timer: 2000,
			});
		},
	});
});
