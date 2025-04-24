$(".chosen-select").chosen({
    allow_single_deselect: true,
    heigth: '100%'
});

$(document).ready(function () {
    loadSkuCode();

    function loadSkuCode() {
        $.ajax({
            url: frontend + controllerName + "/get_sku_code_detail",
            type: "POST",
            dataType: "json",
            success: function (response) {
                console.log("AJAX Success:", response); // debug

                const tableData = response.data || []; // ← No filter now
                const currentSidebarId = response.current_sidebar_id; // Get the current sidebar ID
                const permissions = response.permissions || {}; // Get permissions

                // Get the permissions for the current sidebar
                const currentPermission = permissions[currentSidebarId] || {};

                if ($.fn.DataTable.isDataTable("#SKUCodeTable")) {
                    $("#SKUCodeTable").DataTable().clear().destroy();
                }

                $("#SKUCodeTable").DataTable({
                    dom: 'Bfrtip',  // B = Buttons, f = filter, r = process info, t = table, i = info, p = paginate
                    buttons: [
                        'csv', 'excel'
                    ],
                    data: tableData,
                    columns: [
                        { data: null, title: "Sr. No", render: (data, type, row, meta) => meta.row + 1 },
                        { data: "sku_code", title: "SKU Code" },
                        {
                            data: "id",
                            title: "Actions",
                            render: function (data) {
                                let actions = '';
                                
                                // Check if the user has permission to view, edit, or delete
                                if (currentPermission.can_view === "1") {
                                    actions += `<button class="btn btn-info btn-sm view-sku-code" data-id="${data}">
                                                    <i class="icon-eye menu-icon"></i>
                                                 </button>`;
                                }
                                if (currentPermission.can_edit === "1") {
                                    actions += `<button class="btn btn-warning btn-sm edit-sku-code" data-id="${data}">
                                                    <i class="icon-pencil menu-icon"></i>
                                                 </button>`;
                                }
                                if (currentPermission.can_delete === "1") {
                                    actions += `<button class="btn btn-danger btn-sm" onclick="deleteSaleChannel(${data})">
                                                    <i class="icon-trash menu-icon"></i>
                                                 </button>`;
                                }

                                // If no permissions, return a placeholder
                                return actions || '-';
                            }
                        }
                    ]
                });
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    }
});



$("#SkuCodeForm").on("submit", function (event) {
    event.preventDefault(); // Prevent page reload
    $.ajax({
        url: frontend + controllerName+"/save_sku_code",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function (response) {
            if (response.status === "error") {
                $("#sku_code_error").html(response.sku_code_error);
                setTimeout(() => {
                    $("#sku_code_error").fadeOut("slow", function () {
                        $(this).html("").show(); // Clear the error message and reset visibility
                    });
                }, 1000); // Hide error message after 3 seconds
            } else {
                swal({
                    icon: "success",
                    title: "Added!",
                    text: response.message,
                    button: false,
                    timer: 2000
                });
                $("#SkuCodeForm")[0].reset();
                $("#sku_code_error").text("");
                setTimeout(() => {
                    loadSaleChannel();
                }, 500);
            }
        }
    });
});

$(document).on("click", ".view-sku-code", function () {
    var id = $(this).data("id");
    $.ajax({
        url: frontend + controllerName+"/get_sku_code_details_on_id",
        type: "POST",
        data: { id: id },
        dataType: "json",
        success: function (response) {
            if (response.status == "success") {
                var modalContent = `
                  
                    <p><strong>Sku Code:</strong> ${response.sku_code.sku_code}</p>
                `;
                $("#sku_code_Content").html(modalContent);
                $("#sku_code_Modal").modal("show");
            } else {
                alert("Error: Unable to fetch sale channel details.");
            }
        },
        error: function () {
            alert("Error: Could not retrieve data.");
        }
    });
});

$(document).on("click", ".edit-sku-code", function () {
    var channelId = $(this).data("id");
    $.ajax({
        url: frontend + controllerName+"/get_sku_code_details_on_id",
        type: "POST",
        data: { id: channelId },
        dataType: "json",
        success: function (response) {
            if (response.status == "success") {
                $("#edit_sku_code_id").val(response.sku_code.id);
               
                $("#edit_sku_code").val(response.sku_code.sku_code);
                $("#edit_sku_code_modal").modal("show");
            } else {
                alert("Error: Unable to fetch details.");
            }
        },
        error: function () {
            alert("Error: Could not retrieve data.");
        }
    });
});

$("#edit_sku_code_form").on("submit", function (event) {
    event.preventDefault();
    $.ajax({
        url: frontend + controllerName+"/update_sku_code",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function (response) {
            if (response.status === "error") {
                $("#edit_sku_code_error").html(response.errors.edit_sku_code);
            } else {
                swal({
                    icon: "success",
                    title: "Updated!",
                    text: response.message,
                    button: false,
                    timer: 2000
                });
                $("#edit_sku_code_modal").modal("hide");
                $("#edit_sku_code_form")[0].reset();
                location.reload();
            }
        },
        error: function () {
            console.error("Error updating Bottle Size.");
        }
    });
});

function deleteSaleChannel(id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this Sale Channel!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: frontend + controllerName+"/delete_sku_code",
                type: "POST",
                data: { id: id },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        swal("Deleted!", response.message, "success");
                        location.reload();
                    } else {
                        swal("Error!", response.message, "error");
                    }
                },
                error: function () {
                    swal("Error!", "Something went wrong.", "error");
                }
            });
        }
    });
}
