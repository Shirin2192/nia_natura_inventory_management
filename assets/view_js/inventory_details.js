const table = $('#productInventoryTable').DataTable({
    ajax: {
        url: frontend + controllerName + "/get_inventory_by_product_and_batch",
        dataSrc: function (json) {
            if (json.status === "success") {
                const rows = [];
                let id = 1;
                for (let product in json.data) {
                    rows.push({
                        id: id++,
                        product_name: product,
                        sku_code: product.split('(')[1]?.replace(')', '').trim(),
                        batches: json.data[product]
                    });
                }
                return rows;
            } else {
                return [];
            }
        }
    },

    columns: [
        {
            className: 'dt-control',
            orderable: false,
            data: null,
            defaultContent: '',
        },
        { data: 'id', title: "ID" },
        { data: 'product_name', title: "Product Name" },
        { data: 'sku_code', title: "SKU Code" },
    ],

    order: [[1, 'asc']],
    pageLength: 10,
    responsive: true,

    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'excelHtml5',
            text: 'Export to Excel',
            title: 'Product Inventory',

            customizeData: function (data) {
                let newBody = [];

                table.rows({ search: 'applied' }).every(function () {
                    const rowData = this.data();

                    // Push parent (product) row
                    newBody.push([
                        '', // control
                        rowData.id,
                        rowData.product_name,
                        rowData.sku_code
                    ]);

                    // Push each batch as nested row
                    rowData.batches.forEach(batch => {
                        newBody.push([
                            '', // control
                            '', // id empty for nested
                            "↳ Batch: " + batch.batch_no,
                            `Qty: ${batch.quantity}`, `Date: ${batch.date}`
                        ]);
                    });
                });

                data.body = newBody;
            }
        }
    ]
});

// ✅ Expand/collapse manually when clicked
$('#productInventoryTable tbody').on('click', 'td.dt-control', function () {
    const tr = $(this).closest('tr');
    const row = table.row(tr);

    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
        $(this).html('');
    } else {
        row.child(format(row.data().batches)).show();
        tr.addClass('shown');
        $(this).html('<b>-</b>');
    }
});

// ✅ Format nested (child) batch table
function format(batchList) {
    let html = `
        <table class="table table-sm table-bordered mb-0">
            <thead>
                <tr>
                    <th>Batch No</th>
                    <th>Total Quantity</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
    `;

    batchList.forEach(batch => {
        html += `
            <tr>
                <td>${batch.batch_no}</td>
                <td>${batch.quantity}</td>
                <td>${batch.date}</td>
            </tr>
        `;
    });

    html += `</tbody></table>`;
    return html;
}
