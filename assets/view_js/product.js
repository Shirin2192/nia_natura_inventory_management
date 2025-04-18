$(document).ready(function () {
	$(".chosen-select").chosen({
		allow_single_deselect: true,
		heigth: '100%'
	});

	//Save Product Details
	$("#ProductForm").submit(function (e) {
		e.preventDefault();
		$(".error").remove(); // Remove previous errors

		let formData = new FormData(this);
		$.ajax({
			url: frontend + controllerName + "/save_product",
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			dataType: "json",
			success: function (response) {
				if (response.status === "error") {
					$.each(response.errors, function (key, value) {
						// Avoid duplicate error messages
							const inputElement = $("#" + key);
							inputElement.next(".error").remove();

							// Append new error
							const errorMsg = $('<span class="error text-danger">' + value + '</span>');
							inputElement.after(errorMsg);

							// Auto-remove after 3 seconds
							setTimeout(() => {
								errorMsg.fadeOut(300, function () {
									$(this).remove();
								});
							}, 3000);
					});
				} else if (response.status === "success") {
					swal({
						icon: "success",
						title: "Added!",
						text: response.message,
						button: false, // ✅ Use "button" instead of "showConfirmButton"
						timer: 2000
					});

					$("#ProductForm")[0].reset(); // Reset form
					// Clear Chosen-select dropdowns
					$(".chosen-select").val('').trigger('chosen:updated');

					$('#product_table').DataTable().ajax.reload(); // Refresh DataTable
				}
			},
			error: function () {
				alert("Something went wrong. Please try again.");
			}
		});
	});


	function formatDetails(d) {
		let attributeTable = '<table style="border-collapse: collapse; margin-left: 50px; width: 80%;">' +
			'<thead style="background-color: #f2f2f2; text-align: left;">' +
			'<tr>' +
			'<th style="padding: 10px; border: 1px solid #ddd;">Attribute</th>' +
			'<th style="padding: 10px; border: 1px solid #ddd;">Value</th>' +
			'</tr>' +
			'</thead>' +
			'<tbody>';
	
		d.attributes.forEach(attr => {
			attributeTable += `<tr><td>${attr.name}</td><td>${attr.value}</td></tr>`;
		});
		attributeTable += '</tbody></table>';
	
		let productTypes = d.product_types.join(", ");
	
		return `<b>Product Types:</b> ${productTypes}<br><br>` + attributeTable;
	}
	
	let currentPermission = {};
	let table = $('#product_table').DataTable({
	
		dom: 'Bfrtip', // ✅ Add buttons
		buttons: [
			{
				extend: 'excelHtml5',
				text: 'Export Nested Excel',
				title: 'Product with Attributes',
				exportOptions: {
					columns: [1, 2, 3, 4, 5, 6] // exporting only visible main columns
				},
				customizeData: function (data) {
					let newBody = [];
	
					table.rows({ search: 'applied' }).every(function () {
						let rowData = this.data();
	
						// Parent row
						newBody.push([
							rowData.id,
							rowData.product_name,
							rowData.sku_code,
							rowData.purchase_price,
							rowData.total_quantity,
							rowData.product_types.join(", ")
						]);
	
						// Child Attributes (Nested rows)
						if (rowData.attributes && rowData.attributes.length > 0) {
							rowData.attributes.forEach(attr => {
								newBody.push([
									'', // ID empty
									"↳ " + attr.name, // Attribute name with arrow
									attr.value, // Attribute value
									'', '', '', '' // Empty other columns
								]);
							});
						}
					});
	
					data.body = newBody;
				}
			}
		],
	
		ajax: {
			url: frontend + controllerName + "/fetch_product_details",
			dataSrc: function (json) {
				const permissions = json.permissions;
				const currentSidebarId = json.current_sidebar_id;
				currentPermission = permissions[currentSidebarId]; // store for global access
	
				return json.data; // return product details to datatable
			}
		},
	
		columns: [
			{
				className: 'details-control',
				orderable: false,
				data: null,
				defaultContent: '<button class="btn btn-sm btn-info toggle-details">+</button>'
			},
			{ data: 'id' },
			{ data: 'product_name' },
			{ data: 'sku_code' },
			{ data: 'purchase_price' },
			{ data: 'total_quantity' },
			{
				data: 'product_types',
				render: function (data) {
					return data.join(", ");
				}
			},
			{
				data: 'id',
				render: function (id, type, row, meta) {
					let buttons = '';
	
					if (currentPermission?.can_view === "1") {
						buttons += `<button class="btn btn-primary btn-sm view-product" data-id="${id}" data-toggle="modal" data-target="#viewProductModal">
							<i class="icon-eye menu-icon"></i>
						</button> `;
					}
					if (currentPermission?.can_edit === "1") {
						buttons += `<button class="btn btn-warning btn-sm update-product" data-id="${id}" data-toggle="modal" data-target="#editProductModal">
							<i class="icon-pencil menu-icon"></i>
						</button> `;
					}
					if (currentPermission?.can_delete === "1") {
						buttons += `<button class="btn btn-danger btn-sm delete-product" data-id="${id}">
							<i class="icon-trash menu-icon"></i>
						</button>`;
					}
					return buttons;
				}
			}
		],
	
		order: [[1, 'asc']]
	});
	
	// ✅ Handle Row Expansion (Plus/Minus toggle)
	$('#product_table tbody').on('click', 'td.details-control .toggle-details', function () {
		let tr = $(this).closest('tr');
		let row = table.row(tr);
		let button = $(this);
	
		if (row.child.isShown()) {
			row.child.hide();
			tr.removeClass('shown');
			button.text('+').removeClass('btn-danger').addClass('btn-info'); // plus
		} else {
			row.child(formatDetails(row.data())).show();
			tr.addClass('shown');
			button.text('-').removeClass('btn-info').addClass('btn-danger'); // minus
		}
	});
	
	
});
$(document).ready(function () {
	// Initialize chosen-select
	$(".chosen-select").chosen({ width: "100%" });

	// Unbind any existing change event to prevent duplicate bindings
	$("#fk_product_types_id").off("change").on("change", function () {
		var productTypeId = $(this).val(); // Get selected Product Type ID

		if (productTypeId) {
			$.ajax({
				url: frontend + controllerName + "/get_attribute_on_product_types_id", // API to get attributes
				type: "POST",
				data: { fk_product_types_id: productTypeId },
				dataType: "json",
				success: function (response) {
					var options = '<option value="" disabled selected>Select Attribute</option>';

					if (response.data.length === 0) {
						options += '<option value="" disabled selected>No attributes available</option>';
					}

					$.each(response.data, function (index, item) {
						options += `<option value="${item.id}" data-type="${item.attribute_type}">${item.attribute_name}</option>`;
					});

					$(".fk_product_attribute_id").html(options).trigger("chosen:updated");
					$("#attribute_fields_container").empty(); // Clear fields when product type changes
				},
				error: function () {
					alert("Failed to fetch attributes. Try again.");
				}
			});
		} else {
			$(".fk_product_attribute_id").html('<option value="">Select Attribute</option>').trigger("chosen:updated");
			$("#attribute_fields_container").empty();
		}
	});

	$("#channel_type").off("change").on("change", function () {
		var channel_type = $(this).val(); // Get selected Product Type ID
		if (channel_type) {
			$.ajax({
				url: frontend + controllerName + "/get_sales_channel_on_channel_type", // API to get attributes
				type: "POST",
				data: { channel_type: channel_type },
				dataType: "json",
				success: function (response) {
					var options = '<option value="" disabled>Select Sale Channel</option>';

					if (response.data.length === 0) {
						options += '<option value="" disabled>No Sale Channel available</option>';
					}

					$.each(response.data, function (_, item) {
						options += `<option value="${item.id}">${item.sale_channel}</option>`;
					});

					$("#sale_channel").html(options);

					const preselectedValue = "3"; // Replace with your dynamic value
					$("#sale_channel").val(preselectedValue); // Set selected value here

					if ($("#sale_channel").data('chosen')) {
						$("#sale_channel").trigger("chosen:updated");
					} else {
						$("#sale_channel").chosen({ width: "100%" });
					}
				}
			});
		} else {
			$("#sale_channel").html('<option value="">Select Sale Channel</option>');
			if ($("#sale_channel").data('chosen')) {
				$("#sale_channel").trigger("chosen:updated");
			}
		}

	});
});

document.addEventListener("DOMContentLoaded", function () {
	// Initialize chosen plugin for existing selects
	$(".chosen-select").chosen({ width: "100%" });

	let attributeIndex = 2; // Track new attribute indexes
	let selectedAttributes = new Set(); // Track selected attribute IDs

	/**
	 * Add new attribute field
	 */
	document.getElementById('add_more_attributes').addEventListener('click', function () {
		// Get the attributes container
		let attributesContainer = document.getElementById('attributes_container');

		// Create a new div for the attribute
		let newAttributeDiv = document.createElement('div');
		newAttributeDiv.classList.add('col-lg-6', 'mb-3');
		newAttributeDiv.setAttribute('data-index', attributeIndex); // Add a data-index for tracking

		// Create a form group for the attribute
		let formGroupDiv = document.createElement('div');
		formGroupDiv.classList.add('form-group');

		// Create label for the select dropdown
		let label = document.createElement('label');
		label.classList.add('col-form-label');
		label.setAttribute('for', 'fk_product_attribute_id_' + attributeIndex);
		label.innerHTML = 'Attribute <span class="text-danger">*</span>';

		// Create new attribute select dropdown
		let select = document.createElement('select');
		select.classList.add('chosen-select', 'form-control', 'fk_product_attribute_id');
		select.setAttribute('id', 'fk_product_attribute_id_' + attributeIndex);
		select.setAttribute('name', 'fk_product_attribute_id[]');
		select.setAttribute('style', 'width: 100%;'); // Set width to 100% for Chosen select

		// Copy existing options from the first dropdown but disable already selected options
		let firstDropdown = document.querySelector('.fk_product_attribute_id');
		if (firstDropdown) {
			// Clone options but handle disabled state
			Array.from(firstDropdown.options).forEach(option => {
				let newOption = document.createElement('option');
				newOption.value = option.value;
				newOption.text = option.text;

				// Copy data attributes
				if (option.dataset.type) {
					newOption.dataset.type = option.dataset.type;
				}

				// Disable if this attribute is already selected
				if (selectedAttributes.has(option.value) && option.value !== "") {
					newOption.disabled = true;
				}

				select.appendChild(newOption);
			});
		}
		// Create a new div for the attribute
		let newAttributeRemoveDiv = document.createElement('div');
		newAttributeRemoveDiv.classList.add('col-lg-6');
		newAttributeRemoveDiv.setAttribute('data-index', attributeIndex); // Add a data-index for tracking
		
		// Create remove button
		let removeButton = document.createElement('button');
		removeButton.type = 'button';
		removeButton.classList.add('btn', 'btn-danger', 'mt-2', 'remove-attribute');
		removeButton.textContent = 'Remove';
		

		// Append elements
		formGroupDiv.appendChild(label);
		formGroupDiv.appendChild(select);
		formGroupDiv.appendChild(removeButton);
		newAttributeDiv.appendChild(formGroupDiv);
		// attributesContainer.appendChild(newAttributeDiv);
		// Wrap the new field in a row
		let rowWrapper = document.createElement('div');
		rowWrapper.classList.add('row');
		rowWrapper.appendChild(newAttributeDiv);

		attributesContainer.appendChild(rowWrapper);

		// Initialize Chosen plugin for the new select
		$("#" + select.id).chosen({ width: "100%" });

		// Increment index for the next attribute
		attributeIndex++;
	});

	/**
	 * Remove attribute field when "Remove" button is clicked
	 */
	document.getElementById('attributes_container').addEventListener('click', function (e) {
		if (e.target.classList.contains('remove-attribute')) {
			// Get the parent div (the attribute div)
			let attributeDiv = e.target.closest('.col-lg-6');
			let attributeIndex = attributeDiv.getAttribute('data-index'); // Get the index of the attribute

			// Get the attribute ID that was selected in this row
			let selectedElement = attributeDiv.querySelector('.fk_product_attribute_id');
			let selectedValue = selectedElement ? selectedElement.value : null;

			// Remove the corresponding attribute value row
			document.querySelectorAll(`#attribute_fields_container [data-index="${attributeIndex}"]`).forEach(el => el.remove());

			// If a value was selected, remove it from our tracking Set and update other dropdowns
			if (selectedValue && selectedValue !== "") {
				selectedAttributes.delete(selectedValue);
				updateAllDropdowns();
			}

			// Remove the attribute div itself
			attributeDiv.remove();
		}
	});

	/**
	 * Update all dropdowns to reflect current selections
	 */
	function updateAllDropdowns() {
		// Get all attribute dropdowns
		let allDropdowns = document.querySelectorAll('.fk_product_attribute_id');

		allDropdowns.forEach(dropdown => {
			let selected = dropdown.value;

			// Update each option's disabled state
			Array.from(dropdown.options).forEach(option => {
				if (option.value === "" || option.value === selected) {
					option.disabled = false;
				} else {
					option.disabled = selectedAttributes.has(option.value);
				}
			});

			// Update chosen
			$(dropdown).trigger("chosen:updated");
		});
	}

	/**
	 * Handle attribute selection change
	 */
	$(document).on("change", ".fk_product_attribute_id", function () {
		var $this = $(this);
		var selectedType = $this.find("option:selected").data("type");
		var attributeName = $this.find("option:selected").text();
		var attributeId = $this.val();
		var attributeDiv = $this.closest('.col-lg-6');
		var attributeIndex = attributeDiv.attr('data-index') || '1'; // Default to 1 for first dropdown
		var previousValue = $this.data('previous-value');

		// Remove previous selection from tracking
		if (previousValue && previousValue !== "") {
			selectedAttributes.delete(previousValue);
		}

		// Store current selection for future reference
		$this.data('previous-value', attributeId);

		// Add new selection to tracking if not empty
		if (attributeId && attributeId !== "") {
			selectedAttributes.add(attributeId);
		}

		// Update all dropdowns with new disabled states
		updateAllDropdowns();

		if (!attributeId) {
			// If no attribute is selected, remove the corresponding value field
			$("#attribute_fields_container").find(`[data-index="${attributeIndex}"]`).remove();
			return;
		}

		// Fetch additional data related to selected attribute type dynamically
		$.ajax({
			url: frontend + controllerName + "/get_attribute_values_on_product_attributes_id",
			type: "POST",
			data: { attribute_id: attributeId },
			dataType: "json",
			success: function (response) {
				// Create a div to contain this attribute value, using column approach to avoid overlapping
				var fieldHtml = `<div class="mb-3" data-index="${attributeIndex}"><label class="col-form-label">${attributeName}</label>`;

				if (selectedType === "text") {
					fieldHtml += `<input type="text" name="attributes_value[]" id="attributes_value_${attributeIndex}" class="form-control" placeholder="Enter ${attributeName}">`;
				} else if (selectedType === "dropdown") {
					fieldHtml += `<select class="chosen-select form-control" name="attributes_value[]" id="attributes_value_${attributeIndex}" style="width:100%;">                                    
                    <option value="" disabled selected>Select ${attributeName}</option>`;
					$.each(response.data, function (index, item) {
						fieldHtml += `<option value="${item.id}">${item.attribute_value}</option>`;
					});
					fieldHtml += `</select>`;
				} else if (selectedType === "checkbox") {
					$.each(response.data, function (index, item) {
						fieldHtml += `<div>
                                         <input type="checkbox" name="attributes_value[]" id="attributes_value_${attributeIndex}_${index}" value="${item.attribute_value}"> ${item.label}
                                       </div>`;
					});
				}
				fieldHtml += `</div>`; // Close wrapper

				// Check if there's already a field for this index
				var existingField = $("#attribute_fields_container").find(`[data-index="${attributeIndex}"]`);
				if (existingField.length > 0) {
					existingField.replaceWith(fieldHtml);
				} else {
					$("#attribute_fields_container").append(fieldHtml);
				}

				// Initialize Chosen plugin for new dropdowns with a slight delay to ensure DOM is ready
				setTimeout(function () {
					$(".chosen-select").chosen("destroy"); // Just in case
					$(".chosen-select").chosen({ width: "100%" }).trigger("chosen:updated");
				}, 50);
			},
			error: function () {
				alert("Failed to fetch attribute type values.");
			}
		});
	});

	// Initialize tracking of already selected attributes on page load
	function initializeSelectedAttributes() {
		const existingDropdowns = document.querySelectorAll('.fk_product_attribute_id');
		existingDropdowns.forEach(dropdown => {
			const value = dropdown.value;
			if (value && value !== "") {
				selectedAttributes.add(value);
				$(dropdown).data('previous-value', value);
			}
		});

		// Initial update of all dropdowns
		updateAllDropdowns();
	}

	// Run initialization
	initializeSelectedAttributes();
});

$(document).on("click", ".view-product", function () {
    var product_id = $(this).data("id");

    $.ajax({
        url: frontend + controllerName + "/view_product",
        type: "POST",
        data: { product_id: product_id },
        dataType: "json",
        success: function (response) {
            if (response.product) {
                const product = response.product;

                // Static fields
                $('#view_product_name').text(product.product_name);
                $('#view_product_sku').text(product.sku_code);
                $('#view_product_type').text([...new Set(product.product_type_name.split(','))].join(', '));
                $('#view_barcode').text(product.barcode);
                $('#view_available_status').text(product.stock_availability);
                $('#view_description').html(product.description.replace(/\r\n/g, '<br>').replace(/\n/g, '<br>'));

                // Attributes Dynamic
                let attributesHtml = '<table class="table table-bordered">';
                let attributeNames = product.attribute_name ? product.attribute_name.split(',') : [];
                let attributeValues = product.attribute_value ? product.attribute_value.split(',') : [];

                attributeNames.forEach((attr, index) => {
                    attributesHtml += `<tr><td><strong>${attr.trim()}</strong></td><td>${attributeValues[index] ? attributeValues[index].trim() : ''}</td></tr>`;
                });
                attributesHtml += '</table>';
                $('#view_product_attributes').html(attributesHtml);

                // Batches Dynamic
                let batchHtml = '<table class="table table-bordered">';
                batchHtml += '<thead><tr><th>Batch No</th><th>Manufacture Date</th><th>Expiry Date</th><th>Channel Type</th><th>Sales Channel</th><th>Purchase Price</th><th>MRP</th><th>Selling Price</th></tr></thead><tbody>';
                let batchNos = product.batch_no ? product.batch_no.split(',') : [];
                let manufactureDates = product.manufactured_date ? product.manufactured_date.split(',') : [];
                let expiryDates = product.expiry_date ? product.expiry_date.split(',') : [];
				let channel_type = product.channel_type ? product.channel_type.split(',') : [];
                let channels = product.sale_channel ? product.sale_channel.split(',') : [];
                let purchasePrices = product.purchase_price ? product.purchase_price.split(',') : [];
                let mrps = product.MRP ? product.MRP.split(',') : [];
                let sellingPrices = product.selling_price ? product.selling_price.split(',') : [];
				let totalQuantities = product.total_quantity ? product.total_quantity.split(',') : [];
                batchNos.forEach((batchNo, index) => {
					const quantity = totalQuantities[index] ? parseInt(totalQuantities[index].trim()) : 0;
					const status = quantity > 0 ? '<span class="badge bg-success">Available</span>' : '<span class="badge bg-danger">Out of Stock</span>';
                    batchHtml += `<tr><td>${batchNo.trim()}</td><td>${manufactureDates[index] ? manufactureDates[index].trim() : ''}</td><td>${expiryDates[index] ? expiryDates[index].trim() : ''}</td><td>${channel_type[index] ? channel_type[index].trim() :''}</td>
                        <td>${channels[index] ? channels[index].trim() :''}</td>
                        <td>${purchasePrices[index] ? purchasePrices[index].trim() :''}</td>
                        <td>${mrps[index] ? mrps[index].trim() : ''}</td>
                        <td>${sellingPrices[index] ? sellingPrices[index].trim() : ''}</td> 
						</tr>`;
                });
                batchHtml += '</tbody></table>';
                $('#view_batches').html(batchHtml);
                // Images
                var imagesContainer = $("#view_images");
                imagesContainer.empty();

                if (product.images) {
                    var imageArray = product.images.split(",");
                    imageArray.forEach(function (image) {
                        var imageTag = `<img src="${frontend + 'uploads/products/' + image.trim()}" class="img-fluid m-2" width="100" height="100" alt="Product Image">`;
                        imagesContainer.append(imageTag);
                    });
                } else {
                    imagesContainer.append("<p>No images available</p>");
                }

                $("#viewProductModal").modal("show");
            } else {
                alert('No product details found.');
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching product details:", error);
        }
    });
});



// $(document).on("click", ".update-product", function () {
// 	var product_id = $(this).data("id");

// 	$.ajax({
// 		url: frontend + controllerName + "/view_product",
// 		type: "POST",
// 		data: { product_id: product_id },
// 		dataType: "json",
// 		success: function (response) {
// 			const product = response.product;
// 			const sale_channel = response.sale_channel;
// 			const attribute_master = response.attribute_master;

// 			 // Clear previous batch details
// 			 $("#batch_fields_container_edit").empty();
        
// 			 // Extract batch data from response (comma-separated)
// 			 const batchIds = product.batch_id.split(",");
// 			 const batchNos = product.batch_no.split(",");
// 			 const manufacturedDates = product.manufactured_date.split(",");
// 			 const expiryDates = product.expiry_date.split(",");
// 			 const quantities = product.total_quantity.split(","); // Adjust as per the response
// 			 const purchasePrices = product.purchase_price.split(",");
// 			 const mrpPrices = product.MRP.split(",");
// 			 const sellingPrices = product.selling_price.split(",");

// 			// Fill general product fields
// 			$("#update_product_id").val(product.id);
// 			$('#update_inventory_id').val(product.inventory_id);
// 			$("#update_product_name").val(product.product_name);
// 			$("#update_product_sku").text(response.product.sku_code);
// 			$("#update_batch_no").text(response.product.batch_no);
// 			$("#update_barcode").val(product.barcode);
// 			$("#update_purchase_price").val(product.purchase_price);
// 			$("#update_mrp").val(product.MRP);
// 			$("#update_selling_price").val(product.selling_price);
// 			$("#update_total_quantity").val(product.total_quantity);
// 			$("#update_description").val(product.description);
// 			$("#update_product_image").val(product.images);
// 			$("#update_availability_status").val(product.fk_stock_availability_id).trigger("chosen:updated");
// 			$("#update_channel_type").val(product.channel_type).trigger("chosen:updated");
// 			$('#attribute_id').val(product.attribute_id);
// 			$('#update_manufacture_date').val(product.manufactured_date);
// 			$('#update_expiry_date').val(product.expiry_date);
// 			$('#update_batch_id').val(product.batch_id);

// 			batchIds.forEach((batchId, index) => {
// 				const batchRow = `
// 				<div class="card mb-3 batch-card" data-index="${index + 1}">
// 					<div class="card-body">
// 						<div class="row">
// 							<input type="hidden" name="batch_id[]" value="${batchId}">
	
// 							<div class="col-md-4">
// 								<div class="form-group">
// 									<label>Batch No.</label>
// 									<input type="text" name="batch_no[]" class="form-control" value="${batchNos[index]}" readonly>
// 								</div>
// 							</div>
	
// 							<div class="col-md-4">
// 								<div class="form-group">
// 									<label>Manufacture Date</label>
// 									<input type="date" name="manufacture_date[]" class="form-control" value="${manufacturedDates[index]}">
// 								</div>
// 							</div>
	
// 							<div class="col-md-4">
// 								<div class="form-group">
// 									<label>Expiry Date</label>
// 									<input type="date" name="expiry_date[]" class="form-control" value="${expiryDates[index]}">
// 								</div>
// 							</div>
	
// 							<div class="col-md-4 mt-2">
// 								<div class="form-group">
// 									<label>Quantity</label>
// 									<input type="number" name="batch_quantity[]" class="form-control" value="${quantities[index]}">
// 								</div>
// 							</div>
	
// 							<div class="col-md-4 mt-2">
// 								<div class="form-group">
// 									<label>Purchase Price</label>
// 									<input type="text" name="batch_purchase_price[]" class="form-control" value="${purchasePrices[index]}">
// 								</div>
// 							</div>
	
// 							<div class="col-md-4 mt-2">
// 								<div class="form-group">
// 									<label>MRP</label>
// 									<input type="text" name="batch_mrp[]" class="form-control" value="${mrpPrices[index]}">
// 								</div>
// 							</div>
	
// 							<div class="col-md-4 mt-2">
// 								<div class="form-group">
// 									<label>Selling Price</label>
// 									<input type="text" name="batch_selling_price[]" class="form-control" value="${sellingPrices[index]}">
// 								</div>
// 							</div>
// 						</div>
// 					</div>
// 				</div>
// 				`;
// 				$("#batch_fields_container_edit").append(batchRow);
// 			});
			

// 			// Populate image preview
// 			var imageArray = product.images ? product.images.split(",") : [];
// 			var imagePreview = imageArray.map(img =>
// 				`<img src="${frontend + 'uploads/products/' + img.trim()}" class="img-fluid m-2" width="100" height="100">`
// 			).join('');
// 			$("#update_images").html(imagePreview || "<p>No images available</p>");

// 			// Build sale channel options dynamically
// 			let saleChannelOptions = '<option value="" disabled>Select Sale Channel</option>';

// 			if (sale_channel && sale_channel.length > 0) {
// 				sale_channel.forEach(item => {
// 					const selected = item.id == product.fk_sale_channel_id ? 'selected' : '';
// 					saleChannelOptions += `<option value="${item.id}" ${selected}>${item.sale_channel}</option>`;
// 				});
// 			} else {
// 				saleChannelOptions += '<option value="" disabled>No Sale Channel Available</option>';
// 			}

// 			$("#update_sale_channel").html(saleChannelOptions);

// 			// Update Chosen dropdown
// 			if ($("#update_sale_channel").data('chosen')) {
// 				$("#update_sale_channel").trigger("chosen:updated");
// 			} else {
// 				$("#update_sale_channel").chosen({ width: "100%" });
// 			}

// 			// Handle dynamic attributes
// 			$("#attributes_container_edit").empty();
// 			$("#attribute_fields_container_edit").empty();

// 			let Productattribute_id = product.attribute_id.split(",");
// 			let attributeIds = product.fk_attribute_id.split(",");
// 			let attributeTypes = product.attribute_name.split(",");
// 			let attributeValues = product.attribute_value.split(",");
// 			let attributeTypeIds = product.fk_product_types_id.split(",");
// 			let valueIds = product.fk_attribute_value_id.split(",");

// 			$("#update_fk_product_types_id").val(attributeTypeIds).trigger("chosen:updated");

// 			attributeIds.forEach((attrId, index) => {
// 				let attributeIndex = index + 1;
// 				let attributeName = attributeTypes[index];
// 				let attributeValue = attributeValues[index];
// 				let attributeValueId = valueIds[index];
// 				let Productattribute_ids = Productattribute_id[index];

// 				let attributeOptions1 = '<option value="" disabled>Select Attribute</option>';
// 				$.each(response.attribute_master, function (index, item) {
// 					let selected = item.id == attrId ? "selected" : "";
// 					attributeOptions1 += `<option value="${item.id}" data-type="${item.attribute_type}" ${selected}>${item.attribute_name}</option>`;
// 				});
// 				// Create attribute row
// 				let attributeRow = `
// 				<div class="row attribute-row mb-2" data-index="${attributeIndex}">
// 				<input type="hidden" name="attribute_id[]" id="attribute_id${attributeIndex}" value="${Productattribute_ids}">
// 						<div class="col-lg-6">
// 							<div class="form-group">
// 								<label for="fk_product_attribute_id_${attributeIndex}">
// 									${attributeName} <span class="text-danger">*</span>
// 								</label>
// 								<select id="fk_product_attribute_id_${attributeIndex}" name="edit_fk_product_attribute_id[]" 
// 									class="chosen-select form-control fk_product_attribute_id_edit attribute-dropdown" 
// 									data-index="${attributeIndex}" style="width: 100%;">
// 									${attributeOptions1}
// 								</select>
// 							</div>
// 						</div>
// 						<div class="col-lg-6" id="attribute_value_container_${attributeIndex}">
// 							<div class="form-group">
// 								<label>${attributeName} Value</label>
// 								<div id="attribute_input_${attributeIndex}">Loading...</div>
// 							</div>
// 						</div>
// 					</div>
// 				`;
// 				$("#attribute_fields_container_edit").append(attributeRow);

				
// 				// Fetch attribute value options and append selected
// 				$.ajax({
// 					url: frontend + controllerName + "/get_attribute_values_on_product_attributes_id",
// 					type: "POST",
// 					data: { attribute_id: attrId },
// 					dataType: "json",
// 					success: function (res) {
// 						let type = res.type || "dropdown"; // Assuming API returns `type`
// 						let inputHtml = "";

// 						if (type === "text") {
// 							inputHtml = `<input type="text" name="edit_attributes_value[]" 
// 												id="edit_attributes_value_${attributeIndex}" 
// 												class="form-control" placeholder="Enter ${attributeName}" 
// 												value="${attributeValue}">`;
// 						} else if (type === "dropdown") {
// 							inputHtml = `<select name="edit_attributes_value[]" id="edit_attributes_value_${attributeIndex}" 
// 												class="chosen-select form-control" style="width: 100%;">
// 												<option value="">Select ${attributeName}</option>`;
// 							$.each(res.data, function (i, item) {
// 								let selected = item.id == attributeValueId ? "selected" : "";
// 								inputHtml += `<option value="${item.id}" ${selected}>${item.attribute_value}</option>`;
// 							});
// 							inputHtml += `</select>`;
// 						} else if (type === "checkbox") {
// 							$.each(res.data, function (i, item) {
// 								let checked = attributeValue.includes(item.attribute_value) ? "checked" : "";
// 								inputHtml += `<div class="form-check">
// 									<input class="form-check-input" type="checkbox" 
// 										name="edit_attributes_value[${attributeIndex}][]" 
// 										value="${item.attribute_value}" ${checked}>
// 									<label class="form-check-label">${item.attribute_value}</label>
// 								</div>`;
// 							});
// 						}

// 						$(`#attribute_input_${attributeIndex}`).html(inputHtml);
// 						$(".chosen-select").chosen({ width: "100%" }).trigger("chosen:updated");
// 						disableDuplicateAttributeOptions();
// 					}
// 				});

// 			});
// 		},
// 	});
// 	// Show the modal
// 	$("#updateProductModal").modal("show");
// });

$(document).on("click", ".update-product", function () {
	var product_id = $(this).data("id");

	$.ajax({
		url: frontend + controllerName + "/view_product",
		type: "POST",
		data: { product_id: product_id },
		dataType: "json",
		success: function (response) {
			const product = response.product;
			const sale_channel = response.sale_channel;
			const attribute_master = response.attribute_master;

			// Clear previous batch details
			$("#batch_fields_container_edit").empty();
			// Extract batch data from response (comma-separated)
			const batchIds = product.batch_id ? product.batch_id.split(",") : [];
			const batchNos = product.batch_no ? product.batch_no.split(",") : [];
			const manufacturedDates = product.manufactured_date ? product.manufactured_date.split(",") : [];
			const expiryDates = product.expiry_date ? product.expiry_date.split(",") : [];
			const quantities = product.total_quantity ? product.total_quantity.split(",") : [];
			const purchasePrices = product.purchase_price ? product.purchase_price.split(",") : [];
			const mrpPrices = product.MRP ? product.MRP.split(",") : [];
			const sellingPrices = product.selling_price ? product.selling_price.split(",") : [];
			const channelTypes = product.channel_type ? product.channel_type.split(",") : [];
			const saleChannelIds = product.fk_sale_channel_id ? product.fk_sale_channel_id.split(",") : [];
			const saleChannels = product.sale_channel ? product.sale_channel.split(",") : [];

			// Fill general product fields
			$("#update_product_id").val(product.id);
			$('#update_inventory_id').val(product.inventory_id);
			$("#update_product_name").val(product.product_name);
			$("#update_product_sku").text(response.product.sku_code);
			$("#update_batch_no").text(response.product.batch_no);
			$("#update_barcode").val(product.barcode);
			$("#update_purchase_price").val(product.purchase_price);
			$("#update_mrp").val(product.MRP);
			$("#update_selling_price").val(product.selling_price);
			$("#update_total_quantity").val(product.total_quantity);
			$("#update_description").val(product.description);
			$("#update_product_image").val(product.images);
			$("#update_availability_status").val(product.fk_stock_availability_id).trigger("chosen:updated");
			$("#update_channel_type").val(product.channel_type).trigger("chosen:updated");
			$('#attribute_id').val(product.attribute_id);
			$('#update_manufacture_date').val(product.manufactured_date);
			$('#update_expiry_date').val(product.expiry_date);
			$('#update_batch_id').val(product.batch_id);


			// Populate image preview
			var imageArray = product.images ? product.images.split(",") : [];
			var imagePreview = imageArray.map(img =>
				`<img src="${frontend + 'uploads/products/' + img.trim()}" class="img-fluid m-2" width="100" height="100">`
			).join('');
			$("#update_images").html(imagePreview || "<p>No images available</p>");
// Build sale channel options dynamically
let saleChannelOptions = '<option value="" disabled>Select Sale Channel</option>';
if (sale_channel && sale_channel.length > 0) {
	sale_channel.forEach(item => {
		const selected = String(item.id) === String(product.fk_sale_channel_id) ? 'selected' : '';
		saleChannelOptions += `<option value="${item.id}" ${selected}>${item.sale_channel}</option>`;
	});
} else {
	saleChannelOptions += '<option value="" disabled>No Sale Channel Available</option>';
}
$("#update_sale_channel").html(saleChannelOptions);
// Update Chosen dropdown
if ($("#update_sale_channel").data('chosen')) {
	$("#update_sale_channel").trigger("chosen:updated");
} else {
	$("#update_sale_channel").chosen({ width: "100%" });
}
			// Handle dynamic attributes
			$("#attributes_container_edit").empty();
			$("#attribute_fields_container_edit").empty();

			let Productattribute_id = product.attribute_id.split(",");
			let attributeIds = product.fk_attribute_id.split(",");
			let attributeTypes = product.attribute_name.split(",");
			let attributeValues = product.attribute_value.split(",");
			let attributeTypeIds = product.fk_product_types_id.split(",");
			let valueIds = product.fk_attribute_value_id.split(",");

			$("#update_fk_product_types_id").val(attributeTypeIds).trigger("chosen:updated");

			attributeIds.forEach((attrId, index) => {
				let attributeIndex = index + 1;
				let attributeName = attributeTypes[index];
				let attributeValue = attributeValues[index];
				let attributeValueId = valueIds[index];
				let Productattribute_ids = Productattribute_id[index];

				let attributeOptions1 = '<option value="" disabled>Select Attribute</option>';
				$.each(response.attribute_master, function (index, item) {
					let selected = item.id == attrId ? "selected" : "";
					attributeOptions1 += `<option value="${item.id}" data-type="${item.attribute_type}" ${selected}>${item.attribute_name}</option>`;
				});
				// Create attribute row
				let attributeRow = `
				<div class="row attribute-row mb-2" data-index="${attributeIndex}">
				<input type="hidden" name="attribute_id[]" id="attribute_id${attributeIndex}" value="${Productattribute_ids}">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="fk_product_attribute_id_${attributeIndex}">
									${attributeName} <span class="text-danger">*</span>
								</label>
								<select id="fk_product_attribute_id_${attributeIndex}" name="edit_fk_product_attribute_id[]" 
									class="chosen-select form-control fk_product_attribute_id_edit attribute-dropdown" 
									data-index="${attributeIndex}" style="width: 100%;">
									${attributeOptions1}
								</select>
							</div>
						</div>
						<div class="col-lg-6" id="attribute_value_container_${attributeIndex}">
							<div class="form-group">
								<label>${attributeName} Value</label>
								<div id="attribute_input_${attributeIndex}">Loading...</div>
							</div>
						</div>
					</div>
				`;
				$("#attribute_fields_container_edit").append(attributeRow);

				
				// Fetch attribute value options and append selected
				$.ajax({
					url: frontend + controllerName + "/get_attribute_values_on_product_attributes_id",
					type: "POST",
					data: { attribute_id: attrId },
					dataType: "json",
					success: function (res) {
						let type = res.type || "dropdown"; // Assuming API returns `type`
						let inputHtml = "";

						if (type === "text") {
							inputHtml = `<input type="text" name="edit_attributes_value[]" 
												id="edit_attributes_value_${attributeIndex}" 
												class="form-control" placeholder="Enter ${attributeName}" 
												value="${attributeValue}">`;
						} else if (type === "dropdown") {
							inputHtml = `<select name="edit_attributes_value[]" id="edit_attributes_value_${attributeIndex}" 
												class="chosen-select form-control" style="width: 100%;">
												<option value="">Select ${attributeName}</option>`;
							$.each(res.data, function (i, item) {
								let selected = item.id == attributeValueId ? "selected" : "";
								inputHtml += `<option value="${item.id}" ${selected}>${item.attribute_value}</option>`;
							});
							inputHtml += `</select>`;
						} else if (type === "checkbox") {
							$.each(res.data, function (i, item) {
								let checked = attributeValue.includes(item.attribute_value) ? "checked" : "";
								inputHtml += `<div class="form-check">
									<input class="form-check-input" type="checkbox" 
										name="edit_attributes_value[${attributeIndex}][]" 
										value="${item.attribute_value}" ${checked}>
									<label class="form-check-label">${item.attribute_value}</label>
								</div>`;
							});
						}

						$(`#attribute_input_${attributeIndex}`).html(inputHtml);
						$(".chosen-select").chosen({ width: "100%" }).trigger("chosen:updated");
						disableDuplicateAttributeOptions();
					}
				});

			});

							// Define channel type options
			const channelTypeOptions = [
				{ value: 'Online', label: 'Online' },
				{ value: 'Offline', label: 'Offline' },
				{ value: 'Both', label: 'Both' }
			];
			
			// Add console logs for debugging
			console.log("Channel Types:", channelTypes);
			console.log("Sale Channel IDs:", saleChannelIds);
			console.log("Sale Channels:", sale_channel);
			
			// Loop through each batch and add it to the UI
			batchIds.forEach((batchId, index) => {
				// Create channel type dropdown HTML with string comparison
				let channelTypeOptionsHtml = channelTypeOptions.map(option => {
					const selected = String(option.value) === String(channelTypes[index] || '') ? 'selected' : '';
					return `<option value="${option.value}" ${selected}>${option.label}</option>`;
				}).join('');
				
				// Create sale channel dropdown HTML with string comparison
				let saleChannelOptionsHtml = '';
				if (sale_channel && sale_channel.length > 0) {
					saleChannelOptionsHtml = sale_channel.map(sc => {
						const selected = String(sc.id) === String(saleChannelIds[index] || '') ? 'selected' : '';
						return `<option value="${sc.id}" ${selected}>${sc.sale_channel}</option>`;
					}).join('');
				}
				
				const batchRow = `
				<div class="card mb-3 batch-card" data-index="${index + 1}">
					<div class="card-body">
						<div class="row">
							<input type="hidden" name="batch_id[]" value="${batchId}">
	
							<div class="col-md-4">
								<div class="form-group">
									<label>Batch No.</label>
									<input type="text" name="batch_no[]" class="form-control" value="${batchNos[index] || ''}" readonly>
								</div>
							</div>
	
							<div class="col-md-4">
								<div class="form-group">
									<label>Manufacture Date</label>
									<input type="date" name="update_manufacture_date[]" class="form-control" value="${manufacturedDates[index] || ''}">
								</div>
							</div>
	
							<div class="col-md-4">
								<div class="form-group">
									<label>Expiry Date</label>
									<input type="date" name="expiry_date[]" class="form-control" value="${expiryDates[index] || ''}">
								</div>
							</div>
	
							<div class="col-md-4 mt-2">
								<div class="form-group">
									<label>Quantity</label>
									<input type="number" name="batch_quantity[]" class="form-control" value="${quantities[index] || '0'}">
								</div>
							</div>
	
							<div class="col-md-4 mt-2">
								<div class="form-group">
									<label>Purchase Price</label>
									<input type="text" name="batch_purchase_price[]" class="form-control" value="${purchasePrices[index] || '0'}">
								</div>
							</div>
	
							<div class="col-md-4 mt-2">
								<div class="form-group">
									<label>MRP</label>
									<input type="text" name="batch_mrp[]" class="form-control" value="${mrpPrices[index] || '0'}">
								</div>
							</div>
	
							<div class="col-md-4 mt-2">
								<div class="form-group">
									<label>Selling Price</label>
									<input type="text" name="batch_selling_price[]" class="form-control" value="${sellingPrices[index] || '0'}">
								</div>
							</div>
							<div class="col-md-4 mt-2">
								<div class="form-group">
									<label>Channel Type</label>
									<select name="batch_channel_type[]" class="form-control batch-channel-type">
										<option value="">Select Channel Type</option>
										${channelTypeOptionsHtml}
									</select>
								</div>
							</div>
							<div class="col-md-4 mt-2">
								<div class="form-group">
									<label>Sale Channel</label>
									<select name="batch_sale_channel[]" class="form-control batch-sale-channel">
										<option value="">Select Sale Channel</option>
										${saleChannelOptionsHtml}
									</select>
								</div>
							</div>
							<div class="col-md-4 mt-2">
								<div class="form-group">
									<label>Status</label>
									<span class="badge ${parseInt(quantities[index] || '0') > 0 ? 'bg-success' : 'bg-danger'}">
										${parseInt(quantities[index] || '0') > 0 ? 'In Stock' : 'Out of Stock'}
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				`;
				$("#batch_fields_container_edit").append(batchRow);
			});
			
			// Initialize any chosen dropdowns inside new batch rows
			$(".batch-channel-type, .batch-sale-channel").chosen({
				width: '100%',
				no_results_text: "Oops, nothing found!"
			});
		},
	});
	// Show the modal
	$("#updateProductModal").modal("show");
});
$(document).ready(function () {
	let editAttributeIndex = 1000;

	// Add More Attributes Dynamically
	$('#add_more_attributes_edit').on('click', function () {
		let productTypeId = $('#update_fk_product_types_id').val(); // Get current selected Product Type

		if (!productTypeId) {
			alert("Please select a Product Type first.");
			return;
		}

		// Fetch attribute options based on selected product type
		$.ajax({
			url: frontend + 'admin/get_attribute_on_product_types_id',
			type: 'POST',
			data: { fk_product_types_id: productTypeId },
			dataType: 'json',
			success: function (response) {
				let attributeOptions = '<option value="" disabled selected>Select Attribute</option>';
				$.each(response.data, function (index, item) {
					attributeOptions += `<option value="${item.id}" data-type="${item.attribute_type}">${item.attribute_name}</option>`;
				});
				// Create new attribute select field with options
				let newDiv = $(`
									<div class="row" data-index="${editAttributeIndex}">
										<div class="col-lg-6 mb-3">
											<div class="form-group">
												<label for="fk_product_attribute_id_edit_${editAttributeIndex}">
													Attribute <span class="text-danger">*</span>
												</label>
												<select class="chosen-select form-control fk_product_attribute_id_edit" 
														id="fk_product_attribute_id_edit_${editAttributeIndex}" 
														name="add_new_fk_product_attribute_id[]" 
														data-index="${editAttributeIndex}" 
														style="width: 100%;">
													${attributeOptions}
												</select>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label>Attribute Value</label>
												<div id="attribute_value_container_${editAttributeIndex}">
													<!-- Attribute value input will be dynamically added here -->
												</div>
											</div>
										</div>
										<div class="col-lg-12 text-right">
											<button type="button" class="btn btn-danger mt-2 remove-attribute-edit">Remove</button>
										</div>
									</div>
								`);

				$('#attributes_container_edit').append(newDiv);
				$(".chosen-select").chosen({ width: "100%" }).trigger("chosen:updated");
				editAttributeIndex++;
				disableDuplicateAttributeOptions();
			},
			error: function () {
				alert("Error loading attributes.");
			}
		});
	});

	// Remove added attribute fields
	$('#attributes_container_edit').on('click', '.remove-attribute-edit', function () {
		let parent = $(this).closest('.row');
		let index = parent.data('index');

		parent.remove();
		$(`#attribute_fields_container_edit [data-index="${index}"]`).remove();
	});
});

// Handle attribute selection change (Edit Form)
$(document).on('change', '.fk_product_attribute_id_edit', function () {
	
	let selectedAttributeId = $(this).val();
    let currentIndex = $(this).data('index');

    // Step 1: Collect all selected attribute IDs (except current)
    let selectedIds = [];
    $(".fk_product_attribute_id_edit").each(function () {
        if ($(this).data("index") != currentIndex) {
            let val = $(this).val();
            if (val) selectedIds.push(val);
        }
    });

    // Step 2: Loop through all selects and disable options already selected
    $(".fk_product_attribute_id_edit").each(function () {
        let $select = $(this);
        let currentVal = $select.val();

        $select.find("option").each(function () {
            let optionVal = $(this).val();
            if (selectedIds.includes(optionVal) && optionVal !== currentVal) {
                $(this).attr("disabled", true);
            } else {
                $(this).removeAttr("disabled");
            }
        });

        // Refresh chosen
        $select.trigger("chosen:updated");
    });
	let selectedType = $(this).find("option:selected").data("type");
	let attributeName = $(this).find("option:selected").text();
	let attributeId = $(this).val();
	let attributeIndex = $(this).data('index');

	if (!attributeId) {
		$(`#attribute_value_container_${attributeIndex}`).empty();
		return;
	}

	$.ajax({
		url: frontend + controllerName + "/get_attribute_values_on_product_attributes_id",
		type: "POST",
		data: { attribute_id: attributeId },
		dataType: "json",
		success: function (response) {
			let html = "";

			if (selectedType === "text") {
				html = `<input type="text" name="add_new_attributes_value[]" class="form-control" placeholder="Enter ${attributeName}">`;
			} else if (selectedType === "dropdown") {
				html = `<select name="add_new_attributes_value[]" class="chosen-select form-control" style="width: 100%;">
									<option value="" disabled selected>Select ${attributeName}</option>`;
				$.each(response.data, function (i, item) {
					html += `<option value="${item.id}">${item.attribute_value}</option>`;
				});
				html += `</select>`;
			} else if (selectedType === "checkbox") {
				$.each(response.data, function (i, item) {
					html += `<div><input type="checkbox" name="add_new_attributes_value[]" value="${item.attribute_value}"> ${item.label}</div>`;
				});
			}

			$(`#attribute_value_container_${attributeIndex}`).html(html);
			$(".chosen-select").chosen({ width: "100%" }).trigger("chosen:updated");
			disableDuplicateAttributeOptions();
		},
		error: function () {
			alert("Failed to fetch attribute values.");
		}
	});
	
});
function disableDuplicateAttributeOptions() {
	let selectedValues = [];

	// Step 1: Collect selected attribute values
	$(".fk_product_attribute_id_edit").each(function () {
		let val = $(this).val();
		if (val) selectedValues.push(val);
	});

	// Step 2: Disable already-selected values in other dropdowns
	$(".fk_product_attribute_id_edit").each(function () {
		let $select = $(this);
		let currentVal = $select.val();

		$select.find("option").each(function () {
			let optionVal = $(this).val();

			if (optionVal === "" || optionVal === currentVal) {
				// Leave empty and current selected option enabled
				$(this).prop("disabled", false);
			} else if (selectedValues.includes(optionVal)) {
				// Disable if already selected in another dropdown
				$(this).prop("disabled", true);
			} else {
				$(this).prop("disabled", false);
			}
		});

		// Update Chosen dropdown UI
		$select.trigger("chosen:updated");
	});
}

$("#update_channel_type").off("change").on("change", function () {
	var channel_type = $(this).val(); // Get selected Product Type ID

	if (channel_type) {
		$.ajax({
			url: frontend + controllerName + "/get_sales_channel_on_channel_type", // API to get attributes
			type: "POST",
			data: { channel_type: channel_type },
			dataType: "json",
			success: function (response) {
				var update_options = '<option value="" disabled>Select Sale Channel</option>';

				if (response.data.length === 0) {
					update_options += '<option value="" disabled>No Sale Channel available</option>';
				}

				$.each(response.data, function (_, item) {
					update_options += `<option value="${item.id}">${item.sale_channel}</option>`;
				});

				$("#update_sale_channel").html(update_options);

				const preselectedValue = "3"; // Replace with your dynamic value
				$("#update_sale_channel").val(preselectedValue); // Set selected value here

				if ($("#update_sale_channel").data('chosen')) {
					$("#update_sale_channel").trigger("chosen:updated");
				} else {
					$("#update_sale_channel").chosen({ width: "100%" });
				}
			}
		});
	} else {
		$("#update_sale_channel").html('<option value="">Select Sale Channel</option>');
		if ($("#update_sale_channel").data('chosen')) {
			$("#update_sale_channel").trigger("chosen:updated");
		}
	}

});
$("#add_new_channel_type").off("change").on("change", function () {
	var add_new_channel_type = $(this).val(); // Get selected Product Type ID

	if (add_new_channel_type) {
		$.ajax({
			url: frontend + controllerName + "/get_sales_channel_on_channel_type", // API to get attributes
			type: "POST",
			data: { channel_type: add_new_channel_type },
			dataType: "json",
			success: function (response) {
				var add_new_options = '<option value="" disabled>Select Sale Channel</option>';

				if (response.data.length === 0) {
					add_new_options += '<option value="" disabled>No Sale Channel available</option>';
				}

				$.each(response.data, function (_, item) {
					add_new_options += `<option value="${item.id}">${item.sale_channel}</option>`;
				});

				$("#add_new_sale_channel").html(add_new_options);

				const preselectedValue = "3"; // Replace with your dynamic value
				$("#add_new_sale_channel").val(preselectedValue); // Set selected value here

				if ($("#add_new_sale_channel").data('chosen')) {
					$("#add_new_sale_channel").trigger("chosen:updated");
				} else {
					$("#add_new_sale_channel").chosen({ width: "100%" });
				}
			}
		});
	} else {
		$("#add_new_sale_channel").html('<option value="">Select Sale Channel</option>');
		if ($("#add_new_sale_channel").data('chosen')) {
			$("#add_new_sale_channel").trigger("chosen:updated");
		}
	}

});

$("#UpdateProductForm").on("submit", function (e) {
	e.preventDefault();

	var formData = new FormData(this);
	$("#save-changes-btn").prop("disabled", true).text("Saving...");

	$.ajax({
		url: frontend + controllerName + "/update_product",
		type: "POST",
		data: formData,
		dataType: "json",
		contentType: false,
		processData: false,
		success: function (response) {
			$("#save-changes-btn").prop("disabled", false).text("Save Changes");

			if (response.status === "success") {
				swal({
					icon: "success",
					title: "Updated!",
					text: response.message,
					showConfirmButton: false,
					timer: 2000
				});
				$("#updateProductModal").modal("hide");
				$('#product_table').DataTable().ajax.reload(); // Refresh DataTable
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
		error: function (xhr, status, error) {
			console.error("Error updating product:", error);
			$("#save-changes-btn").prop("disabled", false).text("Save Changes");
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
$(document).on("click", ".delete-product", function () {
	var product_id = $(this).data("id"); // Get product ID from button
	$("#confirm-delete").data("id", product_id); // Store ID in delete button
	$("#deleteModal").modal("show"); // Show the delete confirmation modal
});

// Handle delete confirmation
$("#confirm-delete").on("click", function () {
	var product_id = $(this).data("id");

	$.ajax({
		url: frontend + controllerName + "/delete_product", // Your API endpoint
		type: "POST",
		data: { product_id: product_id },
		dataType: "json",
		success: function (response) {
			if (response.success) {
				swal({
					icon: "success",
					title: "Deleted!",
					text: response.message,
					showConfirmButton: false,
					timer: 2000
				});
				$("#deleteModal").modal("hide"); // Hide modal after delete
				$('#product_table').DataTable().ajax.reload(); // Refresh DataTable
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
		error: function (xhr, status, error) {
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

function downloadSampleExcel() {
    const formData = $('#productTypeForm').serialize(); // grabs product_type_id as query string
    console.log(formData); // Debug the serialized data here.
    const downloadUrl = frontend + controllerName + "/downloadProductSampleExcel?" + formData;
    console.log(downloadUrl); // Debug the full URL here.
    window.location.href = downloadUrl; // triggers Excel download
}

$(document).ready(function() {
	$('#excelUploadForm').on('submit', function(e) {
		e.preventDefault();
		var formData = new FormData(this);
	
		$.ajax({
			url: frontend + controllerName + '/importProductExcel',
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			success: function(response) {
				// Ensure response is parsed JSON
				if (typeof response === "string") {
					response = JSON.parse(response);
				}
	
				// Reset form and UI
				$("#excelUploadForm")[0].reset();
				$(".chosen-select").val('').trigger('chosen:updated');
				$('#product_table').DataTable().ajax.reload();
	
				if (response.status === "success") {
					swal({
						icon: "success",
						title: "Added!",
						text: response.message,
						showConfirmButton: false,
						timer: 2000
					});
				} else if (response.status === "error" && response.download_url) {
					// Download rejected Excel file
					const a = document.createElement('a');
					a.href = response.download_url;
					a.setAttribute('download', '');
					document.body.appendChild(a);
					a.click();
					document.body.removeChild(a);
	
					swal({
						icon: "warning",
						title: "Partial Import",
						text: response.message
					});
				} else {
					// Other errors
					swal({
						icon: "error",
						title: "Error",
						text: response.message
					});
				}
			},
			error: function(xhr, status, error) {
				alert('An error occurred: ' + error);
			}
		});
	});
	
});
