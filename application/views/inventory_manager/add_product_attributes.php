<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Nia Natura Inventory Management</title>
    <?php include('common/css_files.php') ?>
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
                        <li class="breadcrumb-item active"><a
                                href="<?= base_url() ?>admin/add_product_attributes">Product Attribute</a></li>
                    </ol>
                </div>
            </div>
            <?php
                $sidebar_id = $current_sidebar_id;            
                $can_add = isset($permissions[$sidebar_id]['can_add']) && $permissions[$sidebar_id]['can_add'] == 1;
            ?>
            <?php if ($can_add): ?>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="productAttributeForm">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="fk_product_type_id">Product Type
                                                    <span class="text-danger">*</span></label>
                                                <select class="chosen-select form-control" id="fk_product_type_id"
                                                    name="fk_product_type_id" aria-placeholder="Select Product Type">
                                                    <option value=""></option>
                                                    <?php foreach ($product_types as $product_types_key => $product_type_row): ?>
                                                    <option value="<?= $product_type_row['id'] ?>">
                                                        <?= $product_type_row['product_type_name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <small class="text-danger" id="fk_product_type_id_error"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="attribute_name">Attribute Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="attribute_name"
                                                    name="attribute_name" placeholder="Enter Attribute Name">
                                                <small class="text-danger" id="attribute_name_error"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="product_type_name">Attribute Type
                                                    <span class="text-danger">*</span></label>
                                                <select class="chosen-select form-control" id="attribute_type"
                                                    name="attribute_type">
                                                    <option value=""></option>
                                                    <option value="text">Text</option>
                                                    <option value="dropdown">Dropdown</option>
                                                </select>
                                                <small class="text-danger" id="attribute_type_error"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-8 ml-auto">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5>Product Attribute List</h5>
                                <table id="ProductAttributeTable" class="display">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Product Type</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    <script src="<?= base_url() ?>assets/view_js/product_attributes.js"></script>
</body>

</html>