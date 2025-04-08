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
                        <li class="breadcrumb-item"><a href="<?= base_url()?><?= $controller_name?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a
                                href="<?= base_url()?><?= $controller_name?>/add_product_attributes_value">Product Attribute Value</a>
                        </li>
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
                                <form id="productAttributeValueForm">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="fk_attribute_id">Select Attribute
                                                    <span class="text-danger">*</span></label>
                                                <select class="chosen-select form-control" id="fk_attribute_id"
                                                    name="fk_attribute_id" aria-placeholder="Select Attribute">
                                                    <option value=""></option>
                                                    <?php foreach ($product_attributes as $product_attributes_key => $product_attributes_row): ?>
                                                    <option value="<?= $product_attributes_row['id'] ?>">
                                                        <?= $product_attributes_row['attribute_name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <small class="text-danger" id="fk_attribute_id_error"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="attribute_value">Attribute Value
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="attribute_value"
                                                    name="attribute_value" placeholder="Enter Attribute Name">
                                                <small class="text-danger" id="attribute_value_error"></small>
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
                                <h5>Product Attribute Value List</h5>
                                <table id="ProductAttributeValueTable" class="display">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Attribute Name</th>
                                            <th>Attribute Value</th>
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
            <div class="modal-dialog modal-xl custom-modal-fullwidth">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewProductAttributeModalLabel">View Attribute Value</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Attribute Name:</strong> <span id="view_attribute_name" class="text-muted"></span>
                        </p>
                        <p><strong>Attribute Type:</strong> <span id="view_attribute_value" class="text-muted"></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Product Attribute Modal -->
        <div class="modal fade" id="editProductAttributeValueModal" tabindex="-1" role="dialog"
            aria-labelledby="editProductAttributeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl custom-modal-fullwidth">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                <h5 class="modal-title" id="editProductAttributeModalLabel">
                    Edit Attribute Value
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                <form id="editAttributeValueForm">

                    <!-- Hidden Input for Attribute ID -->
                    <input type="hidden" id="edit_attribute_value_id" name="edit_attribute_value_id">

                    <!-- Product Type (Readonly) -->
                    <div class="form-group">
                    <label for="edit_attribute_name">Attribute Name</label>
                    <span class="form-control" id="edit_attribute_name" name="edit_attribute_name"
                        readonly></span>
                    </div>

                    <!-- Attribute Name -->
                    <div class="form-group">
                    <label for="edit_attribute_value">Attribute Value Name</label>
                    <input type="text" class="form-control" id="edit_attribute_value"
                        name="edit_attribute_value" placeholder="Enter Attribute Value Name" required>
                    <small class="text-danger" id="edit_attribute_value_error"></small>
                    </div>
                    <!-- Save Button -->
                    <div class="text-right">
                    <button type="submit" class="btn btn-primary">
                        Save Changes
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                    </div>

                </form>
                </div>
            </div>
            </div>
        </div>
        <div class="modal fade" id="deleteProductAttributeValueModal" tabindex="-1" role="dialog"
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
                            Are you sure you want to delete this attribute value?
                        </p>
                        <input type="hidden" id="delete_attribute_value_id"> <!-- Hidden field for attribute ID -->
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
    <script src="<?= base_url() ?>assets/view_js/product_attribute_value.js"></script>
</body>

</html>