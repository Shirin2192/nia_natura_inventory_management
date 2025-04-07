<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Nia Natura Inventory Management</title>
    <?php include('common/css_files.php') ?>
	<style>
		/* Bigger checkboxes */
.larger-checkbox {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

/* Make it more visible on light backgrounds */
.form-check-input {
    border: 2px solid #555;
    background-color: #fff;
}

/* On checked */
.form-check-input:checked {
    background-color: #28a745;
    border-color: #28a745;
}

/* Label spacing for better alignment */
.form-check-label {
    font-weight: normal;
    font-size: 14px;
}

	</style>
</head>

<body>
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>

    <div id="main-wrapper">
        <?php include('common/nav_head.php') ?>
        <?php include('common/header.php') ?>
        <?php include('common/sidebar.php') ?>

        <div class="content-body">
            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="<?= base_url() ?>admin/role_and_access">Role &
                                Access</a></li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <form id="RoleAccessForm">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="role_id">Select Role<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select name="role_id" id="role" class="chosen-select form-select">
                                                    <option value="" disabled selected>Select a Role</option>
                                                    <?php foreach ($roles as $role_key => $role_row): ?>
                                                    <option value="<?= $role_row['id'] ?>"><?= $role_row['role_name'] ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <small class="text-danger" id="role_id_error"></small>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt-4">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0">Role & Access Permissions</h5>
                            </div>
                            <div class="card-body">
                                <table id="ProductAttributeTable" class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Module</th>
                                            <th>View</th>
                                            <th>Add</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($modules as $module_key => $module_row): ?>
                                        <tr>
                                            <td><strong><?= ucfirst($module_row['sidebar_name']) ?></strong></td>

                                            <?php if (strtolower($module_row['sidebar_name']) === 'dashboard'): ?>
												<td colspan="4" class="text-center">
                                                <div
                                                    class="form-check">
                                                    <input class="form-check-input larger-checkbox" type="checkbox"
                                                        name="permissions[<?= $module_row['id'] ?>][access]" value="1"
                                                        id="access_<?= $module_row['id'] ?>">
                                                    <label class="form-check-label ms-2"
                                                        for="access_<?= $module_row['id'] ?>">Show in Sidebar</label>
                                                    <small class="text-danger" id="permissions_error"></small>
                                                </div>
                                            </td>
                                            <?php else: ?>
                                            <?php foreach (['view', 'add', 'edit', 'delete'] as $perm): ?>
                                            <td class="text-center align-middle">
                                                <div
                                                    class="form-check d-flex justify-content-center align-items-center">
                                                    <input class="form-check-input larger-checkbox" type="checkbox"
                                                        name="permissions[<?= $module_row['id'] ?>][<?= $perm ?>]"
                                                        value="1" id="<?= $perm ?>_<?= $module_row['id'] ?>">
                                                    <label class="form-check-label ms-2"
                                                        for="<?= $perm ?>_<?= $module_row['id'] ?>"></label>
                                                    <small class="text-danger" id="permissions_error"></small>
                                                </div>
                                            </td>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>

                                </table>
                                <div class="text-right mt-3">
                                    <button type="submit" class="btn btn-success">
                                        <i class="icon-save"></i> Save Permissions
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>


        <div class="modal fade" id="viewProductAttributeModal" tabindex="-1" role="dialog"
            aria-labelledby="viewProductAttributeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewProductAttributeModalLabel">View Attribute</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Product Type:</strong> <span id="view_product_type"></span></p>
                        <p><strong>Attribute Name:</strong> <span id="view_attribute_name"></span></p>
                        <p><strong>Attribute Type:</strong> <span id="view_attribute_type"></span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Product Attribute Modal -->
        <div class="modal fade" id="editProductAttributeModal" tabindex="-1" role="dialog"
            aria-labelledby="editProductAttributeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editProductAttributeModalLabel">
                            <i class="icon-pencil"></i> Edit Attribute
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form id="editAttributeForm">

                            <!-- Hidden Input for Attribute ID -->
                            <input type="hidden" id="edit_attribute_id" name="edit_attribute_id">

                            <!-- Product Type (Readonly) -->
                            <div class="form-group">
                                <label for="edit_product_type">Product Type</label>
                                <span class="form-control bg-light" id="edit_product_type" name="edit_product_type"
                                    readonly></span>
                            </div>

                            <!-- Attribute Name -->
                            <div class="form-group">
                                <label for="edit_attribute_name">Attribute Name</label>
                                <input type="text" class="form-control" id="edit_attribute_name"
                                    name="edit_attribute_name" required>
                            </div>

                            <!-- Attribute Type -->
                            <div class="form-group">
                                <label for="edit_attribute_type">Attribute Type</label>
                                <select class="chosen-select form-control" id="edit_attribute_type"
                                    name="edit_attribute_type">
                                    <option value="text">Text</option>
                                    <option value="dropdown">Dropdown</option>
                                </select>
                            </div>

                            <!-- Save Button -->
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">
                                    Save Changes
                                </button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    <i class="icon-close"></i> Cancel
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteProductAttributeModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteProductAttributeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header ">
                        <h5 class="modal-title" id="deleteProductAttributeModalLabel">
                            Confirm Delete
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body text-center">
                        <p class="font-weight-bold text-dark">
                            Are you sure you want to delete this attribute type?
                        </p>
                        <input type="hidden" id="delete_attribute_id"> <!-- Hidden field for attribute ID -->
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">

                        <button type="button" class="btn btn-primary" id="confirmDeleteAttribute">
                            Delete
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Cancel
                        </button>
                    </div>

                </div>
            </div>
        </div>



        <?php include('common/footer.php') ?>
    </div>

    <?php include('common/js_files.php') ?>
    <script src="<?= base_url() ?>assets/view_js/role_access.js"></script>
</body>

</html>
