$(document).ready(function () {
	$(".chosen-select").chosen({
		allow_single_deselect: true,
		heigth: '100%'
	});
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
// SKU Code change → fetch Product ID
$("#sku_code").off("change").on("change", function () {
    var sku_code = $(this).val();
    if (sku_code) {
        $.ajax({
            url: frontend + controllerName + "/get_product_id_on_sku_code",
            type: "POST",
            data: { sku_code: sku_code },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    $("#product_id").val(response.product_id).trigger("change"); // Set and trigger
                } else {
                    alert("Product ID not found for the selected SKU Code.");
                    $("#product_id").val("").trigger("change");
                }
            },
            error: function () {
                alert("An error occurred while fetching the Product ID.");
                $("#product_id").val("").trigger("change");
            }
        });
    } else {
        $("#product_id").val("").trigger("change");
    }
});

// Product ID change → fetch Batch Numbers
$("#product_id").off("change").on("change", function () {
    var product_id = $(this).val();
    if (product_id) {
        $.ajax({
            url: frontend + controllerName + "/get_batch_no_on_product_id",
            type: "POST",
            data: { product_id: product_id },
            dataType: "json",
            success: function (response) {
                console.log(response);
                var batch_no_option = '<option value="" disabled selected>Select Batch Number</option>';

                if (response.data.length === 0) {
                    batch_no_option += '<option value="" disabled>No Batch Number available</option>';
                }

                if (response.data && typeof response.data === "object") {
                    batch_no_option += `<option value="${response.data.id}">${response.data.batch_no}</option>`;
                } else {
                    batch_no_option += '<option value="" disabled>No Batch Number available</option>';
                }

                $("#fk_batch_id").html(batch_no_option);

                // Re-initialize or update chosen
                if ($("#fk_batch_id").data('chosen')) {
                    $("#fk_batch_id").trigger("chosen:updated");
                } else {
                    $("#fk_batch_id").chosen({ width: "100%" });
                }
            },
            error: function () {
                alert("An error occurred while fetching the Batch Numbers.");
                $("#fk_batch_id").html('<option value="">Select Batch Number</option>');
                if ($("#fk_batch_id").data('chosen')) {
                    $("#fk_batch_id").trigger("chosen:updated");
                }
            }
        });
    } else {
        // Clear fk_batch_id dropdown
        $("#fk_batch_id").html('<option value="">Select Batch Number</option>');
        if ($("#fk_batch_id").data('chosen')) {
            $("#fk_batch_id").trigger("chosen:updated");
        }
    }
});

// Submit Order Form using form serialization
$("#OrderForm").submit(function (e) {
    e.preventDefault();
    $(".error").remove(); // Remove previous errors

    let formData = new FormData(this);
    $.ajax({
        url: frontend + controllerName + "/submit_order_form",
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

                $("#OrderForm")[0].reset(); // Reset form
                // Clear Chosen-select dropdowns
                $(".chosen-select").val('').trigger('chosen:updated');

                $('#OrderTable').DataTable().ajax.reload(); // Refresh DataTable
            }
        },
        error: function () {
            alert("Something went wrong. Please try again.");
        }
    });
});

// Initialize DataTable
$(document).ready(function () {
   $('#OrderTable').DataTable({
    dom: 'Bfrtip',  // B = Buttons, f = filter, r = process info, t = table, i = info, p = paginate
    buttons: [
        'csv', 'excel'
    ],
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: {
        url: frontend + controllerName + "/get_all_orders",
        type: "POST"
    },
    columns: [
        {
            data: null,
            title: "Sr. No",
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        { data: "product_name", title: "Product Name" },
        { data: "sku_code", title: "SKU CODE" },
        { data: "batch_no", title: "Batch No" },
        { data: "channel_type", title: "Channel Type" },
        { data: "sale_channel", title: "Sales Channel" },
        { data: "deduct_quantity", title: "Deducted Quantity" },
        { data: "total_quantity", title: "Total Quantity" },
        { data: "created_at", title: "Date" }
    ],
    order: [[7, "desc"]],
    responsive: true,
    language: {
        emptyTable: "No orders available",
        processing: "Loading..."
    }
});

});
$('#ExcelOrderUploadForm').on('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    $.ajax({
        url: frontend + controllerName + "/upload_order_excel",
        type: "POST",
        data: formData,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status === "success") {
                swal({
                    icon: "success",
                    title: "Added!",
                    text: response.message,
                    button: false, // ✅ Use "button" instead of "showConfirmButton"
                    timer: 2000
                });
                $('#ExcelOrderUploadForm')[0].reset();
            } else if (response.status === "partial") {
                swal({
                    icon: "warning",
                    title: "Warning!",
                    text: response.message,
                    button: false, // ✅ Use "button" instead of "showConfirmButton"
                    timer: 2000
                });
        
                if (response.rejected_url) {
                    const link = document.createElement("a");
                    link.href = response.rejected_url;
                    link.download = response.rejected_url.split("/").pop();
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
        
            } else {
                swal({
                    icon: "error",
                    title: "Error!",
                    text: response.message,
                    button: false, // ✅ Use "button" instead of "showConfirmButton"
                    timer: 2000
                });
            }
        },
        
        error: function () {
            swal({
                icon: "error",
                title: "Error!",
                text: response.message,
                button: false, // ✅ Use "button" instead of "showConfirmButton"
                timer: 2000
            });
        }
    });
});
