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
            url: frontend + "admin/save_product",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status === "error") {
                    $.each(response.errors, function (key, value) {
                        $("#" + key).after('<span class="error text-danger">' + value + '</span>');
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


//     var table = $('#product_table').DataTable({
//         "processing": true,
//         "serverSide": false,
//         "ajax": {
//             "url": frontend + "admin/fetch_product_details",
//             "type": "GET",
//             "dataSrc": "products"
//         },
//         "columns": [
//             { "data": "product_name" },
//             { "data": "product_type_name" },
//             { "data": "flavour_name" },
//             { "data": "bottle_size" },
//             { "data": "purchase_price" },
//             { "data": "total_quantity" },
//             { 
//                 "data": null, 
//                 "render": function(data, type, row) {
//                     return `
//                         <button class="btn btn-primary btn-sm view-product" data-id="${row.id}" data-toggle="modal" data-target="#viewProductModal">
//                             <i class="icon-eye menu-icon"></i>
//                         </button>
//                         <button class="btn btn-warning btn-sm update-product" data-id="${row.id}" data-toggle="modal" data-target="#editProductModal">
//                             <i class="icon-pencil menu-icon"></i>
//                         </button>
//                         <button class="btn btn-danger btn-sm delete-product" data-id="${row.id}">
//                             <i class="icon-trash menu-icon"></i>
//                         </button>
//                     `;
//                 }
//             }
//         ]
//     });
    
// });
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

    let table = $('#product_table').DataTable({
        ajax: frontend + "admin/fetch_product_details", // Adjust the URL
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
                render: function(data) {
                    return data.join(", ");
                }
            },
            { 
                data: 'id',
                render: function(data) {
                    return `
                         <button class="btn btn-primary btn-sm view-product" data-id="${data}" data-toggle="modal" data-target="#viewProductModal">
                             <i class="icon-eye menu-icon"></i>
                         </button>
                         <button class="btn btn-warning btn-sm update-product" data-id="${data}" data-toggle="modal" data-target="#editProductModal">
                             <i class="icon-pencil menu-icon"></i>
                         </button>
                         <button class="btn btn-danger btn-sm delete-product" data-id="${data}">
                             <i class="icon-trash menu-icon"></i>
                         </button>
                     `;
                }
            }
        ],
        order: [[1, 'asc']]
    });

    // Handle row expansion with plus/minus toggle
    $('#product_table tbody').on('click', 'td.details-control .toggle-details', function() {
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
                url: frontend + "admin/get_attribute_on_product_types_id", // API to get attributes
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

    // Unbind and rebind change event for attribute selection
    $(".fk_product_attribute_id").off("change").on("change", function () {
        var selectedType = $(".fk_product_attribute_id option:selected").data("type");
        var attributeName = $(".fk_product_attribute_id option:selected").text();
        var attributeId = $(this).val();

        if (!attributeId) {
            $("#attribute_fields_container").empty();
            return;
        }

        // Fetch additional data related to selected attribute type dynamically
        $.ajax({
            url: frontend + "admin/get_attribute_values_on_product_attributes_id", // API to get additional values
            type: "POST",
            data: { attribute_id: attributeId },
            dataType: "json",
            success: function (response) {
                var fieldHtml = `<div class="form-group"><label>${attributeName}</label>`;
                if (selectedType === "text") {
                    fieldHtml += `<input type="text" name="attributes_value[]" id="attributes_value_${attributeId}" class="form-control" placeholder="Enter ${attributeName}">`;
                } else if (selectedType === "dropdown") {
                    fieldHtml += `<select name="attributes_value[]" id="attributes_value_${attributeId}" class="chosen-select form-control" style="width: 100%;">                                    
                    <option value="" disabled selected>Select ${attributeName}</option>`;
                    $.each(response.data, function (index, item) {
                        fieldHtml += `<option value="${item.id}">${item.attribute_value}</option>`;
                    });
                    fieldHtml += `</select>`;
                } else if (selectedType === "checkbox") {
                    $.each(response.data, function (index, item) {
                        fieldHtml += `<div>
                                        <input type="checkbox" name="attributes_value[]" id="attributes_value_${attributeId}" value="${item.attribute_value}"> ${item.label}
                                      </div>`;
                    });
                }
                fieldHtml += `</div>`;
                $("#attribute_fields_container").html(fieldHtml);
                // Reinitialize Chosen Select for newly added dropdowns
                $(".chosen-select").chosen({ width: "100%" }).trigger("chosen:updated");
            },
            error: function () {
                alert("Failed to fetch attribute type values.");
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    $(".chosen-select").chosen({ width: "100%" });
    let attributeIndex = 2; // Track new attribute indexes

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

        // Copy existing options from the first dropdown
        let firstDropdown = document.querySelector('.fk_product_attribute_id');
        if (firstDropdown) {
            select.innerHTML = firstDropdown.innerHTML;
        }

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
        attributesContainer.appendChild(newAttributeDiv);

        // Initialize Chosen plugin for the new select
        $(".chosen-select").chosen({ width: "100%" });

        // Increment index for the next attribute
        attributeIndex++;
    });

    // Remove attribute field when "Remove" button is clicked
    document.getElementById('attributes_container').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-attribute')) {
            // Get the parent div (the attribute div)
            let attributeDiv = e.target.closest('.col-lg-6');
            let attributeIndex = attributeDiv.getAttribute('data-index'); // Get the index of the attribute

            // Remove the corresponding attribute value row
            document.querySelectorAll(`#attribute_fields_container [data-index="${attributeIndex}"]`).forEach(el => el.remove());

            // Remove the attribute div itself
            attributeDiv.remove();
        }
    });

    // When an attribute is selected, append corresponding input field dynamically
    $(document).on("change", ".fk_product_attribute_id", function () {
        var selectedType = $(this).find("option:selected").data("type");
        var attributeName = $(this).find("option:selected").text();
        var attributeId = $(this).val();
        var attributeDiv = $(this).closest('.col-lg-6');
        var attributeIndex = attributeDiv.attr('data-index'); // Get the index for this attribute

        if (!attributeId) {
            $("#attribute_fields_container").find(`[data-index="${attributeIndex}"]`).remove();
            return;
        }

        // Fetch additional data related to selected attribute type dynamically
        $.ajax({
            url: frontend + "admin/get_attribute_values_on_product_attributes_id", // API to get additional values
            type: "POST",
            data: { attribute_id: attributeId },
            dataType: "json",
            success: function (response) {
                var fieldHtml = `<div class="form-group" data-index="${attributeIndex}"><label>${attributeName}</label>`;
                if (selectedType === "text") {
                    fieldHtml += `<input type="text" name="attributes_value[]" id="attributes_value_${attributeIndex}" class="form-control" placeholder="Enter ${attributeName}">`;
                } else if (selectedType === "dropdown") {
                    fieldHtml += `<select name="attributes_value[]" id="attributes_value_${attributeIndex}" class="chosen-select form-control" style="width: 100%;">                                    
                    <option value="" disabled selected>Select ${attributeName}</option>`;
                    $.each(response.data, function (index, item) {
                        fieldHtml += `<option value="${item.id}">${item.attribute_value}</option>`;
                    });
                    fieldHtml += `</select>`;
                } else if (selectedType === "checkbox") {
                    $.each(response.data, function (index, item) {
                        fieldHtml += `<div>
                                        <input type="checkbox" name="attributes_value[]" id="attributes_value_${attributeIndex}" value="${item.attribute_value}"> ${item.label}
                                      </div>`;
                    });
                }
                fieldHtml += `</div>`;

                // Append or update the attribute fields container
                var existingField = $("#attribute_fields_container").find(`[data-index="${attributeIndex}"]`);
                if (existingField.length > 0) {
                    existingField.replaceWith(fieldHtml);
                } else {
                    $("#attribute_fields_container").append(fieldHtml);
                }

                // Reinitialize Chosen Select for newly added dropdowns
                $(".chosen-select").chosen({ width: "100%" }).trigger("chosen:updated");
            },
            error: function () {
                alert("Failed to fetch attribute type values.");
            }
        });
    });
});



$(document).on("click", ".view-product", function() {
    var product_id = $(this).data("id");    
    $.ajax({
        url: frontend + "admin/view_product",
        type: "POST",
        data: { product_id: product_id }, // Sending data as POST
        dataType: "json",
        success: function(response) {
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
                imageArray.forEach(function(image) {
                    var imageTag = `<img src="${frontend + 'uploads/products/' + image.trim()}" class="img-fluid m-2" width="100" height="100" alt="Product Image">`;
                    imagesContainer.append(imageTag);
                });
            } else {
                imagesContainer.append("<p>No images available</p>");
            }

            $("#productModal").modal("show"); // Open the Bootstrap modal
        },
        error: function(xhr, status, error) {
            console.error("Error fetching product details:", error);
        }
    });
});

$(document).on("click", ".update-product", function () {
    var product_id = $(this).data("id");
    console.log(product_id);

    $.ajax({
        url: frontend + "admin/view_product",
        type: "POST",
        data: { product_id: product_id }, // Sending data as POST
        dataType: "json",
        success: function (response) {
            $("#update_product_id").val(product_id);
            $("#update_product_name").val(response.product.product_name);
            $("#update_product_sku_code").val(response.product.product_sku_code);
            $("#update_batch_no").val(response.product.batch_no);
            $("#update_purchase_price").val(response.product.purchase_price);
            $("#update_mrp").val(response.product.MRP);
            $("#update_selling_price").val(response.product.selling_price);
            $("#update_total_quantity").val(response.product.total_quantity);
            $("#update_description").val(response.product.description);
            $("#update_barcode").val(response.product.barcode);
            $("#update_old_images").val(response.product.images); // Store old images
            $("#fk_product_category_id").val(response.product.fk_product_category_id);
            $("#fk_product_type_id").val(response.product.fk_product_type_id);
            $("#fk_product_price_id").val(response.product.fk_product_price_id);
            $("#update_product_image").val(response.product.images);
          


            // Populate Select Options
            populateFlavourSelect("#update_flavour_name", response.flavour, response.product.flavour_id);
            populateBottleSizeSelect("#update_bottle_size", response.bottle_size, response.product.bottle_size_id);
            populateBottleTypeSelect("#update_bottle_type", response.bottle_type, response.product.bottle_type_id);
            populateAvailabilityStatusSelect("#update_availability_status", response.stock_availability, response.product.stock_availability_id);
            populateSaleChannelSelect("#update_sale_channel", response.sale_channel, response.product.sale_channel_id);

            // Reinitialize Chosen Select
            $(".chosen-select").chosen('destroy').chosen({
                allow_single_deselect: true,
                width: "100%"
            });

            // Handle multiple images
            var imagesContainer = $("#update_images");
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

            $("#updateProductModal").modal("show"); // Open the Bootstrap modal
        },
        error: function (xhr, status, error) {
            console.error("Error fetching product details:", error);
        }
    });
});

// Function to Populate Select Dropdowns
function populateFlavourSelect(selector, dataArray, selectedValue) {
    var selectElement = $(selector);
    selectElement.empty(); // Clear existing options
    selectElement.append(`<option value="">Select Flavour</option>`); // Default option

    $.each(dataArray, function (index, item) {
        var selected = item.id == selectedValue ? "selected" : "";
        selectElement.append(`<option value="${item.id}" ${selected}>${item.flavour_name}</option>`);
    });

    selectElement.trigger("chosen:updated"); // Update Chosen Select
}

function populateBottleSizeSelect(selector, dataArray, selectedValue) {
    var selectElement = $(selector);
    selectElement.empty(); // Clear existing options
    selectElement.append(`<option value="">Select Bottle Size</option>`); // Default option

    $.each(dataArray, function (index, item) {
        var selected = item.id == selectedValue ? "selected" : "";
        selectElement.append(`<option value="${item.id}" ${selected}>${item.bottle_size}</option>`);
    });

    selectElement.trigger("chosen:updated"); // Update Chosen Select
}

function populateBottleTypeSelect(selector, dataArray, selectedValue) {
    var selectElement = $(selector);
    selectElement.empty(); // Clear existing options
    selectElement.append(`<option value="">Select Bottle Type</option>`); // Default option

    $.each(dataArray, function (index, item) {
        var selected = item.id == selectedValue ? "selected" : "";
        selectElement.append(`<option value="${item.id}" ${selected}>${item.bottle_type}</option>`);
    });

    selectElement.trigger("chosen:updated"); // Update Chosen Select
}

function populateAvailabilityStatusSelect(selector, dataArray, selectedValue) {
    var selectElement = $(selector);
    selectElement.empty(); // Clear existing options
    selectElement.append(`<option value="">Select Availability Status</option>`); // Default option

    $.each(dataArray, function (index, item) {
        var selected = item.id == selectedValue ? "selected" : "";
        selectElement.append(`<option value="${item.id}" ${selected}>${item.stock_availability}</option>`);
    });

    selectElement.trigger("chosen:updated"); // Update Chosen Select
}

function populateSaleChannelSelect(selector, dataArray, selectedValue) {
    var selectElement = $(selector);
    selectElement.empty(); // Clear existing options
    selectElement.append(`<option value="">Select Sale Channel</option>`); // Default option

    $.each(dataArray, function (index, item) {
        var selected = item.id == selectedValue ? "selected" : "";
        selectElement.append(`<option value="${item.id}" ${selected}>${item.sale_channel}</option>`);
    });

    selectElement.trigger("chosen:updated"); // Update Chosen Select

    // $(".chosen-select").chosen({
    //     allow_single_deselect: true,
    //     width: "100%"
    // });
}

$("#UpdateProductForm").on("submit", function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    $("#save-changes-btn").prop("disabled", true).text("Saving...");

    $.ajax({
        url: frontend + "admin/update_product",
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
$(document).on("click", ".delete-product", function() {
    var product_id = $(this).data("id"); // Get product ID from button
    $("#confirm-delete").data("id", product_id); // Store ID in delete button
    $("#deleteModal").modal("show"); // Show the delete confirmation modal
});

// Handle delete confirmation
$("#confirm-delete").on("click", function() {
    var product_id = $(this).data("id");

    $.ajax({
        url: frontend + "admin/delete_product", // Your API endpoint
        type: "POST",
        data: { product_id: product_id },
        dataType: "json",
        success: function(response) {
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
        error: function(xhr, status, error) {
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


