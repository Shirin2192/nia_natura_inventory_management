$(".chosen-select").chosen({
    allow_single_deselect: true,
    heigth: '100%'
});

$(document).ready(function () { 
    var table = $("#ProductAttributeTable").DataTable({
        processing: true,
        serverSide: false, // ✅ Change to false (since JSON is pre-processed)
        ajax: {
            url: frontend + "admin/get_product_attribute_detail",
            type: "POST",
            dataSrc: "data" // ✅ Ensure correct data parsing
        },
        columns: [
            {
                className: "dt-control", // Expand button column
                orderable: false,
                data: null,
                defaultContent: ''
            },
            { data: "product_type_name", title: "Product Type" }
        ],
        order: [[1, "asc"]],
        pageLength: 10,
        responsive: true
    });

    // ✅ Handle row expansion for nested table
    $("#ProductAttributeTable tbody").on("click", "td.dt-control", function () {
        var tr = $(this).closest("tr");
        var row = table.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass("shown");
        } else {
            var attributes = row.data().attribute_names.split(",");
            var attribute_types = row.data().attribute_types.split(",");

            row.child(formatChildTable(attributes, attribute_types)).show();
            tr.addClass("shown");
        }
    });

    // ✅ Function to create child table
    function formatChildTable(attributes, attribute_types) {
        var html = '<table class="table table-bordered"><thead><tr>' +
                   '<th>Attribute Name</th><th>Attribute Type</th>' +
                   '<th>Action</th>' +
                   '</tr></thead><tbody>';

        attributes.forEach(function (attr, index) {
            html += "<tr><td>" + attr + "</td><td>" + attribute_types[index] + 
                    '</td><td><button class="btn btn-sm btn-primary edit-attribute" data-attribute="' + attr + 
                    '" data-type="' + attribute_types[index] + '">Edit</button></td></tr>';
        });

        html += "</tbody></table>";
        return html;
    }
});



$("#productAttributeForm").on("submit", function (event) {
    event.preventDefault(); // Prevent page reload
    $.ajax({
        url: frontend + "admin/save_product_attributes", // URL to controller function
        type: "POST",
        data: $(this).serialize(), // Serialize form data
        dataType: "json",
        success: function (response) {
            if (response.status === "error") {
                // Show validation error below the textbox
                $("#attribute_name_error").html(response.attribute_name_error);
            } else {
                swal({
                    title: "Success!",
                    text: response.message,
                    icon: "success",
                    button: false,
                    timer: 2000 // Auto close after 2 seconds
                });
                $("#productAttributeForm")[0].reset(); // Reset form
                $("#fk_product_type_id_error").html(""); // Clear error message
                $("#attribute_name_error").html(""); // Clear error message
                $("#attribute_type_error").html(""); // Clear error message
                $(".chosen-select").val("").trigger("chosen:updated"); // Clear chosen select
                $('#ProductAttributeTable').DataTable().ajax.reload(); // Reload DataTable
                
            }
        }
    });
});
