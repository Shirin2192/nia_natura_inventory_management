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
		// attributeTable += '<tr><th>Attribute</th><th>Value</th></tr>';
		d.attributes.forEach(attr => {
			attributeTable += `<tr><td>${attr.name}</td><td>${attr.value}</td></tr>`;
		});
		attributeTable += '</table>';

		let productTypes = d.product_types.join(", ");

		return `<b>Product Types:</b> ${productTypes}<br><br>` + attributeTable;
	}
	let currentPermission = {};
	let table = $('#product_table').DataTable({
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

	// Handle row expansion with plus/minus toggle
	$('#product_table tbody').on('click', 'td.details-control .toggle-details', function () {
		let tr = $(this).closest('tr');
		let row = table.row(tr);
		let button = $(this);

		if (row.child.isShown()) {
			row.child.hide();
			tr.removeClass('shown');
			button.text('+').removeClass('btn-danger').addClass('btn-info'); // Change to plus sign
		} else {
			row.child(formatDetails(row.data())).show();
			tr.addClass('shown');
			button.text('-').removeClass('btn-info').addClass('btn-danger'); // Change to minus sign
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


	// $(".fk_product_attribute_id").off("change").on("change", function () {
	// 	// $(document).off("change", ".fk_product_attribute_id").on("change", ".fk_product_attribute_id", function () {

	// 	var selectedType = $(".fk_product_attribute_id option:selected").data("type");
	// 	var attributeName = $(".fk_product_attribute_id option:selected").text();
	// 	var attributeId = $(this).val();

	// 	if (!attributeId) {
	//         $("#attribute_fields_container").empty(); // Clear the container if no attribute is selected
	//         return;
	//     }
	// 	// Optional: Clear the container before AJAX to avoid visual stacking
	//     $("#attribute_fields_container").empty();
	// 	// Fetch additional data related to selected attribute type dynamically
	// 	$.ajax({
	// 		url: frontend + controllerName + "/get_attribute_values_on_product_attributes_id", // API to get additional values
	// 		type: "POST",
	// 		data: { attribute_id: attributeId },
	// 		dataType: "json",
	// 		success: function (response) {
	// 			var fieldHtml = `<div class="col-lg-6 mb-3"><div class="form-group"><label class="col-form-label">${attributeName}</label>`;
	// 			if (selectedType === "text") {
	// 				fieldHtml += `<input type="text" name="attributes_value[]" id="attributes_value_${attributeId}" class="form-control" placeholder="Enter ${attributeName}">`;
	// 			} else if (selectedType === "dropdown") {
	// 				fieldHtml += `<select class="chosen-select form-control"  name="attributes_value[]" id="attributes_value_${attributeId}" style="width:100%;">                                    
	//                 <option value="" disabled selected>Select ${attributeName}</option>`;
	// 				$.each(response.data, function (index, item) {
	// 					fieldHtml += `<option value="${item.id}">${item.attribute_value}</option>`;
	// 				});
	// 				fieldHtml += `</select>`;
	// 			} else if (selectedType === "checkbox") {
	// 				$.each(response.data, function (index, item) {
	// 					fieldHtml += `<div>
	//                                     <input type="checkbox" name="attributes_value[]" id="attributes_value_${attributeId}" value="${item.attribute_value}"> ${item.label}
	//                                   </div>`;
	// 				});
	// 			}
	// 			fieldHtml += `</div></div>`;
	// 			$("#attribute_fields_container").html(fieldHtml);
	// 			// Make sure select is visible and in DOM before initializing
	// 			setTimeout(function () {
	// 				$(".chosen-select").chosen("destroy"); // Just in case
	// 				$(".chosen-select").chosen({ width: "100%" }).trigger("chosen:updated").trigger("resize.chosen");
	// 			}, 50);
	// 		},
	// 		error: function () {
	// 			alert("Failed to fetch attribute type values.");
	// 		}
	// 	});
	// });

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

// document.addEventListener("DOMContentLoaded", function () {
// 	$(".chosen-select").chosen({ width: "100%" });
// 	let attributeIndex = 2; // Track new attribute indexes
// 	let selectedAttributes = new Set(); // Track selected attribute IDs

// 	document.getElementById('add_more_attributes').addEventListener('click', function () {
// 		// Get the attributes container
// 		let attributesContainer = document.getElementById('attributes_container');


// 		// Create a new div for the attribute
// 		let newAttributeDiv = document.createElement('div');
// 		newAttributeDiv.classList.add('col-lg-6', 'mb-3');
// 		newAttributeDiv.setAttribute('data-index', attributeIndex); // Add a data-index for tracking

// 		// Create a form group for the attribute
// 		let formGroupDiv = document.createElement('div');
// 		formGroupDiv.classList.add('form-group');

// 		// Create label for the select dropdown
// 		let label = document.createElement('label');
// 		label.classList.add('col-form-label');
// 		label.setAttribute('for', 'fk_product_attribute_id_' + attributeIndex);
// 		label.innerHTML = 'Attribute <span class="text-danger">*</span>';

// 		// Create new attribute select dropdown
// 		let select = document.createElement('select');
// 		select.classList.add('chosen-select', 'form-control', 'fk_product_attribute_id');
// 		select.setAttribute('id', 'fk_product_attribute_id_' + attributeIndex);
// 		select.setAttribute('name', 'fk_product_attribute_id[]');
// 		select.setAttribute('style', 'width: 100%;'); // Set width to 100% for Chosen select

// 		// Copy existing options from the first dropdown
// 		let firstDropdown = document.querySelector('.fk_product_attribute_id');
// 		if (firstDropdown) {
// 			//select.innerHTML = firstDropdown.innerHTML;
// 			Array.from(firstDropdown.options).forEach(option => {
//                 let newOption = document.createElement('option');
//                 newOption.value = option.value;
//                 newOption.text = option.text;

//                 // Copy data attributes
//                 if (option.dataset.type) {
//                     newOption.dataset.type = option.dataset.type;
//                 }

//                 // Disable if this attribute is already selected
//                 if (selectedAttributes.has(option.value) && option.value !== "") {
//                     newOption.disabled = true;
//                 }

//                 select.appendChild(newOption);
//             });
// 		}

// 		// Create remove button
// 		let removeButton = document.createElement('button');
// 		removeButton.type = 'button';
// 		removeButton.classList.add('btn', 'btn-danger', 'mt-2', 'remove-attribute');
// 		removeButton.textContent = 'Remove';

// 		// Append elements
// 		formGroupDiv.appendChild(label);
// 		formGroupDiv.appendChild(select);
// 		formGroupDiv.appendChild(removeButton);
// 		newAttributeDiv.appendChild(formGroupDiv);
// 		attributesContainer.appendChild(newAttributeDiv);

// 		// Initialize Chosen plugin for the new select
//         $("#" + select.id).chosen({ width: "100%" });

// 		// Initialize Chosen plugin for the new select
// 		//$(".chosen-select").chosen({ width: "100%" });

// 		// Increment index for the next attribute
// 		attributeIndex++;
// 	});

// 	// Remove attribute field when "Remove" button is clicked
// 	document.getElementById('attributes_container').addEventListener('click', function (e) {
// 		if (e.target.classList.contains('remove-attribute')) {
// 			// Get the parent div (the attribute div)
// 			let attributeDiv = e.target.closest('.col-lg-6');
// 			let attributeIndex = attributeDiv.getAttribute('data-index'); // Get the index of the attribute


//             // Get the attribute ID that was selected in this row
//             let selectedElement = attributeDiv.querySelector('.fk_product_attribute_id');
//             let selectedValue = selectedElement ? selectedElement.value : null;

// 			// Remove the corresponding attribute value row
// 			document.querySelectorAll(`#attribute_fields_container [data-index="${attributeIndex}"]`).forEach(el => el.remove());
// 				// If a value was selected, remove it from our tracking Set and update other dropdowns
// 				if (selectedValue && selectedValue !== "") {
// 					selectedAttributes.delete(selectedValue);
// 					updateAllDropdowns();
// 				}

// 				// Remove the attribute div itself
// 				attributeDiv.remove();
// 		}
// 	});

// 	/**
//      * Update all dropdowns to reflect current selections
//      */
//     function updateAllDropdowns() {
//         // Get all attribute dropdowns
//         let allDropdowns = document.querySelectorAll('.fk_product_attribute_id');

//         allDropdowns.forEach(dropdown => {
//             let selected = dropdown.value;

//             // Update each option's disabled state
//             Array.from(dropdown.options).forEach(option => {
//                 if (option.value === "" || option.value === selected) {
//                     option.disabled = false;
//                 } else {
//                     option.disabled = selectedAttributes.has(option.value);
//                 }
//             });

//             // Update chosen
//             $(dropdown).trigger("chosen:updated");
//         });
//     }

// 	// When an attribute is selected, append corresponding input field dynamically
// 	$(document).on("change", ".fk_product_attribute_id", function () {
// 		var selectedType = $(this).find("option:selected").data("type");
// 		var attributeName = $(this).find("option:selected").text();
// 		var attributeId = $(this).val();
// 		var attributeDiv = $(this).closest('.col-lg-6');
// 		var attributeIndex = attributeDiv.attr('data-index'); // Get the index for this attribute

// 		if (!attributeId) {
// 			$("#attribute_fields_container").find(`[data-index="${attributeIndex}"]`).remove();
// 			return;
// 		}

// 		// Fetch additional data related to selected attribute type dynamically
// 		$.ajax({
// 			url: frontend + controllerName + "/get_attribute_values_on_product_attributes_id", // API to get additional values
// 			type: "POST",
// 			data: { attribute_id: attributeId },
// 			dataType: "json",
// 			success: function (response) {
// 				var fieldHtml_addmore = `<div class="form-group" data-index="${attributeIndex}"><label>${attributeName}</label>`;
// 				if (selectedType === "text") {
// 					fieldHtml_addmore += `<input type="text" name="attributes_value[]" id="attributes_value_${attributeIndex}" class="form-control" placeholder="Enter ${attributeName}">`;
// 				} else if (selectedType === "dropdown") {
// 					fieldHtml_addmore += `<select name="attributes_value[]" id="attributes_value_${attributeIndex}" class="chosen-select form-control" style="width: 100%;">                                    
//                     <option value="" disabled selected>Select ${attributeName}</option>`;
// 					$.each(response.data, function (index, item) {
// 						fieldHtml_addmore += `<option value="${item.id}">${item.attribute_value}</option>`;
// 					});
// 					fieldHtml_addmore += `</select>`;
// 				} else if (selectedType === "checkbox") {
// 					$.each(response.data, function (index, item) {
// 						fieldHtml_addmore += `<div>
//                                         <input type="checkbox" name="attributes_value[]" id="attributes_value_${attributeIndex}" value="${item.attribute_value}"> ${item.label}
//                                       </div>`;
// 					});
// 				}
// 				fieldHtml_addmore += `</div>`;

// 				// Append or update the attribute fields container
// 				var existingField = $("#attribute_fields_container").find(`[data-index="${attributeIndex}"]`);
// 				if (existingField.length > 0) {
// 					existingField.replaceWith(fieldHtml_addmore);
// 				} else {
// 					$("#attribute_fields_container").append(fieldHtml_addmore);
// 				}

// 				// Reinitialize Chosen Select for newly added dropdowns
// 				$(".chosen-select").chosen({ width: "100%" }).trigger("chosen:updated");
// 			},
// 			error: function () {
// 				alert("Failed to fetch attribute type values.");
// 			}
// 		});
// 	});
// });

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
		data: { product_id: product_id }, // Sending data as POST
		dataType: "json",
		success: function (response) {
			$('#view_product_name').text(response.product.product_name);
			$('#view_product_sku').text(response.product.product_sku_code);
			$('#view_product_type').text([...new Set(response.product.product_type_name.split(','))].join(', '));
			let attributes = response.product.attribute_name.split(',').map((name, index) => {
				return `<p><strong>${name.trim()}:</strong> ${response.product.attribute_value.split(',')[index].trim()}</p>`;
			}).join('');
			$('#view_product_attributes').html(attributes);
			$('#view_barcode').text(response.product.barcode);
			$('#view_batch_no').text(response.product.batch_no);
			$('#view_mrp').text(response.product.MRP);
			$('#view_product_price').text(response.product.purchase_price);
			$('#view_selling_price').text(response.product.selling_price);
			$('#view_product_quantity').text(response.product.total_quantity);
			$('#view_description').text(response.product.description.replace(/\r\n/g, '<br>'));

			// Handle multiple images
			var imagesContainer = $("#view_images");
			imagesContainer.empty(); // Clear previous images

			if (response.product.images) {
				var imageArray = response.product.images.split(","); // Convert string to array
				imageArray.forEach(function (image) {
					var imageTag = `<img src="${frontend + 'uploads/products/' + image.trim()}" class="img-fluid m-2" width="100" height="100" alt="Product Image">`;
					imagesContainer.append(imageTag);
				});
			} else {
				imagesContainer.append("<p>No images available</p>");
			}

			$("#productModal").modal("show"); // Open the Bootstrap modal
		},
		error: function (xhr, status, error) {
			console.error("Error fetching product details:", error);
		}
	});
});


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

			// Fill general product fields
			$("#update_product_id").val(product.id);
			$('#update_inventory_id').val(product.inventory_id);
			$("#update_product_name").val(product.product_name);
			$("#update_product_sku_code").val(product.product_sku_code);
			$("#update_batch_no").val(product.batch_no);
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
					const selected = item.id == product.fk_sale_channel_id ? 'selected' : '';
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
									class="chosen-select form-control fk_product_attribute_id" 
									data-index="${attributeIndex}" style="width: 100%;">
									<option value="${attrId}" selected>${attributeName}</option>
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
					}
				});

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
		},
		error: function () {
			alert("Failed to fetch attribute values.");
		}
	});
});
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


