$(".chosen-select").chosen({
	allow_single_deselect: true,
	heigth: "100%",
});
$(document).ready(function () {
	let currentPermission = null;
	const table = $("#ProductAttributeTable").DataTable({
		processing: true,
		serverSide: false,
		ajax: {
			url: frontend + controllerName + "/get_product_attribute_detail",
			type: "POST",
			dataSrc: function (data) {
				const permissions = data.permissions;
				const currentSidebarId = data.current_sidebar_id;
				currentPermission = permissions[currentSidebarId];
				return data.data;
			},
		},
		columns: [
			{
				className: "dt-control",
				orderable: false,
				data: null,
				defaultContent: "",
			},
			{ data: "product_type_name", title: "Product Type" },
		],
		order: [[1, "asc"]],
		pageLength: 10,
		responsive: true,
		dom: "Bfrtip",
		buttons: [
			{
				extend: "excelHtml5",
				text: "Export to Excel",
				title: "Product Attributes",
				customizeData: function (data) {
					let newBody = [];

					table.rows({ search: "applied" }).every(function () {
						let rowData = this.data();
						// Push parent row first
						newBody.push([
							"", // Control column
							rowData.product_type_name,
						]);

						// Then push nested attribute rows
						const attributes = rowData.attribute_names.split(",");
						const attribute_types = rowData.attribute_types.split(",");

						attributes.forEach((attr, index) => {
							newBody.push([
								"", // control column
								"↳ " + attr + " (" + attribute_types[index] + ")",
							]);
						});
					});

					data.body = newBody;
				},
			},
		],
	});

	// ✅ Expand/collapse manually when clicked
	$("#ProductAttributeTable tbody").on("click", "td.dt-control", function () {
		var tr = $(this).closest("tr");
		var row = table.row(tr);

		if (row.child.isShown()) {
			row.child.hide();
			tr.removeClass("shown");
		} else {
			var attributes = row.data().attribute_names.split(",");
			var attribute_types = row.data().attribute_types.split(",");
			var attribute_ids = row.data().attribute_id.split(",");

			row
				.child(formatChildTable(attributes, attribute_types, attribute_ids))
				.show();
			tr.addClass("shown");
		}
	});

	// ✅ Format nested child table HTML
	function formatChildTable(attributes, attribute_types, attribute_ids) {
		let html =
			'<table class="table table-bordered"><thead><tr>' +
			"<th>Attribute Name</th><th>Attribute Type</th><th>Action</th>" +
			"</tr></thead><tbody>";

		attributes.forEach(function (attr, index) {
			html +=
				"<tr><td>" + attr + "</td><td>" + attribute_types[index] + "</td><td>";

			if (currentPermission?.can_view === "1") {
				html +=
					'<button class="btn btn-sm btn-primary view-attribute" data-attribute="' +
					attr +
					'" data-type="' +
					attribute_types[index] +
					'" data-id="' +
					attribute_ids[index] +
					'" data-toggle="modal" data-target="#viewProductAttributeModal">' +
					'<i class="icon-eye menu-icon"></i></button> ';
			}
			if (currentPermission?.can_edit === "1") {
				html +=
					'<button class="btn btn-sm btn-warning edit-attribute" data-attribute="' +
					attr +
					'" data-type="' +
					attribute_types[index] +
					'" data-id="' +
					attribute_ids[index] +
					'" data-toggle="modal" data-target="#editProductAttributeModal">' +
					'<i class="icon-pencil menu-icon"></i></button> ';
			}
			if (currentPermission?.can_delete === "1") {
				html +=
					'<button class="btn btn-sm btn-danger delete-attribute" data-attribute="' +
					attr +
					'" data-type="' +
					attribute_types[index] +
					'" data-id="' +
					attribute_ids[index] +
					'" data-toggle="modal" data-target="#deleteProductAttributeModal">' +
					'<i class="icon-trash menu-icon"></i></button>';
			}

			html += "</td></tr>";
		});

		html += "</tbody></table>";
		return html;
	}
});
$("#productAttributeForm").on("submit", function (event) {
	event.preventDefault(); // Prevent page reload
	$.ajax({
		url: frontend + controllerName + "/save_product_attributes", // URL to controller function
		type: "POST",
		data: $(this).serialize(), // Serialize form data
		dataType: "json",
		success: function (response) {
			if (response.status === "error") {
				// Show validation error below the textbox
				$("#attribute_name_error").html(response.attribute_name_error);
				$("#attribute_type_error").html(response.attribute_type_error);
				$("#fk_product_type_id_error").html(response.fk_product_type_id_error);
				setTimeout(function () {
					$("#attribute_name_error").text("");
					$("#attribute_type_error").text("");
					$("#fk_product_type_id_error").text("");
				}, 1500);
			} else {
				swal({
					title: "Success!",
					text: response.message,
					icon: "success",
					button: false,
					timer: 2000, // Auto close after 2 seconds
				});
				$("#productAttributeForm")[0].reset(); // Reset form
				$("#fk_product_type_id_error").html(""); // Clear error message
				$("#attribute_name_error").html(""); // Clear error message
				$("#attribute_type_error").html(""); // Clear error message
				$(".chosen-select").val("").trigger("chosen:updated"); // Clear chosen select
				$("#ProductAttributeTable").DataTable().ajax.reload(); // Reload DataTable
			}
		},
	});
});
// View Attribute
$(document).on("click", ".view-attribute", function () {
	var attrId = $(this).data("id"); // Get Attribute ID
	$.ajax({
		url: frontend + controllerName + "/get_product_attribute_detail_id", // Backend Controller URL
		type: "POST",
		data: { id: attrId }, // Send ID to Backend
		dataType: "json",
		success: function (response) {
			if (response.status == "success") {
				$("#view_product_type").text(response.data.product_type_name);
				$("#view_attribute_name").text(response.data.attribute_name);
				$("#view_attribute_type").text(response.data.attribute_type);
				$("#viewProductAttributeModal").modal("show"); // Show the Modal
			} else {
				alert("Error: Unable to fetch data.");
			}
		},
		error: function () {
			alert("Error: Could not retrieve data.");
		},
	});
});
// Edit Attribute
$(document).on("click", ".edit-attribute", function () {
	var attrId = $(this).data("id"); // Get Attribute ID

	$.ajax({
		url: frontend + controllerName + "/get_product_attribute_detail_id", // Backend Controller URL
		type: "POST",
		data: { id: attrId }, // Send ID to Backend
		dataType: "json",
		success: function (response) {
			if (response.status == "success") {
				$("#edit_product_type").val(response.data.product_type_name); // Set Product Type (Readonly)
				$("#edit_attribute_name").val(response.data.attribute_name); // Set Attribute Name
				// Destroy Chosen if already initialized
				if ($("#edit_attribute_type").data("chosen")) {
					$("#edit_attribute_type").chosen("destroy");
				}
				$("#edit_attribute_type")
					.val(response.data.attribute_type)
					.trigger("chosen:updated");
				$("#edit_attribute_type").chosen({ width: "100%" });

				$("#edit_attribute_id").val(response.data.id); // Set ID
				$("#editProductAttributeModal").modal("show"); // Show Modal
			} else {
				alert("Error: Unable to fetch data.");
			}
		},
		error: function () {
			alert("Error: Could not retrieve data.");
		},
	});
});
$("#editAttributeForm").on("submit", function (event) {
	event.preventDefault(); // Prevent page reload
	$.ajax({
		url: frontend + controllerName + "/update_product_attribute", // Save updates
		type: "POST",
		data: $(this).serialize(), // Serialize form data
		dataType: "json",
		success: function (response) {
			if (response.status === "error") {
				// Display validation errors for all fields
				$("#edit_attribute_name_error").html(
					response.attribute_name_error || ""
				);
				$("#edit_attribute_type_error").html(
					response.attribute_type_error || ""
				);
			} else {
				swal({
					icon: "success",
					title: "Updated!",
					text: response.message,
					showConfirmButton: false,
					timer: 2000,
				});
				$("#editProductAttributeModal").modal("hide"); // Close modal
				$("#editAttributeForm")[0].reset(); // Reset form
				$("#ProductAttributeTable").DataTable().ajax.reload(); // Reload DataTable
				location.reload();
			}
		},
		error: function () {
			console.error("Error updating flavour.");
		},
	});
});
// Delete Attribute
$(document).on("click", ".delete-attribute", function () {
	var attrId = $(this).data("id"); // Get Attribute ID
	var attrName = $(this).data("attribute"); // Get Attribute Name
	// Set the attribute details in the modal
	$("#delete_attribute_name").text(attrName);
	$("#delete_attribute_id").val(attrId);
	// Show the delete modal
	$("#deleteProductAttributeModal").modal("show");
});
// Handle the confirm delete button click
$("#confirmDeleteAttribute").on("click", function () {
	var attrId = $("#delete_attribute_id").val(); // Get the attribute ID from hidden input
	$.ajax({
		url: frontend + controllerName + "/delete_product_attribute", // Backend URL
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
					timer: 2000,
				});
				$("#deleteProductAttributeModal").modal("hide"); // Hide modal after successful deletion
                $("#ProductAttributeTable").DataTable().ajax.reload(); // Reload DataTable
				location.reload(); // Refresh the page or update the table dynamically
			} else {
				alert("Error: Unable to delete attribute.");
			}
		},
		error: function () {
			alert("Error: Could not connect to the server.");
		},
	});
});