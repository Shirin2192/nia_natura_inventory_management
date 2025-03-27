$(document).ready(function() {
    let table = $('#productTable').DataTable({
        ajax: 'ProductTypesController/fetch',
        columns: [
            { data: 'id' },
            { data: 'product_type_name' },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-info viewBtn" data-id="${row.id}">View</button>
                        <button class="btn btn-warning editBtn" data-id="${row.id}">Edit</button>
                        <button class="btn btn-danger deleteBtn" data-id="${row.id}">Delete</button>
                    `;
                }
            }
        ]
    });

    // View product
    $('#productTable').on('click', '.viewBtn', function() {
        let id = $(this).data('id');
        $.get('ProductTypesController/get/' + id, function(data) {
            $('#viewId').text(data.id);
            $('#viewName').text(data.product_type_name);
            $('#viewModal').modal('show');
        }, 'json');
    });

    // Edit product
    $('#productTable').on('click', '.editBtn', function() {
        let id = $(this).data('id');
        $.get('ProductTypesController/get/' + id, function(data) {
            $('#editId').val(data.id);
            $('#editName').val(data.product_type_name);
            $('#editModal').modal('show');
        }, 'json');
    });

    $('#updateBtn').click(function() {
        let id = $('#editId').val();
        let name = $('#editName').val();
        $.post('ProductTypesController/update/' + id, { product_type_name: name }, function() {
            $('#editModal').modal('hide');
            table.ajax.reload();
        });
    });

    // Add product
    $('#addBtn').click(function() {
        let name = $('#addName').val();
        $.post('ProductTypesController/add', { product_type_name: name }, function() {
            $('#addModal').modal('hide');
            table.ajax.reload();
        });
    });

    // Delete product
    $('#productTable').on('click', '.deleteBtn', function() {
        if (confirm('Are you sure you want to delete?')) {
            let id = $(this).data('id');
            $.post('ProductTypesController/delete/' + id, function() {
                table.ajax.reload();
            });
        }
    });
});