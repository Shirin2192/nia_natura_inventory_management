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
                    
                    // setTimeout(() => {
                    //     loadSaleChannel(); // Reload DataTable
                    // }, 500);
                }
            },
            error: function () {
                alert("Something went wrong. Please try again.");
            }
        });
    });


    var table = $('#product_table').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": frontend + "admin/fetch_product_details",
            "type": "GET",
            "dataSrc": "products"
        },
        "columns": [
            { "data": "product_name" },
            { "data": "flavour_name" },
            { "data": "bottle_size" },
            { "data": "purchase_price" },
            { "data": "total_quantity" },
            { 
                "data": null, 
                "render": function(data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm view-product" data-id="${row.id}" data-toggle="modal" data-target="#viewProductModal">
                            <i class="icon-eye menu-icon"></i>
                        </button>
                        <button class="btn btn-warning btn-sm update-product" data-id="${row.id}" data-toggle="modal" data-target="#editProductModal">
                            <i class="icon-pencil menu-icon"></i>
                        </button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}">
                            <i class="icon-trash menu-icon"></i>
                        </button>
                    `;
                }
            }
        ]
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
            $("#view_product_name").text(response.product.product_name);
            $("#view_product_sku_code").text(response.product.product_sku_code);
            $("#view_batch_no").text(response.product.batch_no);
            $("#view_flavour_name").text(response.product.flavour_name);
            $("#view_bottle_size").text(response.product.bottle_size);
            $("#view_bottle_type").text(response.product.bottle_type);
            $("#view_purchase_price").text(response.product.purchase_price);
            $("#view_mrp").text(response.product.MRP);
            $("#view_selling_price").text(response.product.selling_price);
            $("#view_total_quantity").text(response.product.total_quantity);
            $("#view_description").text(response.product.description);           
            $("#view_availability_status").text(response.product.stock_availability);           
            $("#view_sale_channel").text(response.product.sale_channel);          
            $("#view_barcode").text(response.product.barcode);

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
                location.reload(); // Refresh to update product list
            } else {
                toastr.error(response.message);
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


