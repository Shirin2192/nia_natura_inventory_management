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
                        <button class="btn btn-warning btn-sm edit-btn" data-id="${row.id}" data-toggle="modal" data-target="#editProductModal">
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
    console.log(product_id);
    
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
