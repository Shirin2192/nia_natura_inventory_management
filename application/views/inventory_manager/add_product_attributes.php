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
                        <li class="breadcrumb-item active"><a href="<?= base_url() ?>admin/add_product_type_name">Product Type</a></li>
                    </ol>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="productAttributeForm">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="fk_product_type_id">Product Type <span class="text-danger">*</span></label>
                                                <select class="chosen-select form-control" id="fk_product_type_id" name="fk_product_type_id" aria-placeholder="Select Product Type">
                                                    <option value=""></option>
                                                    <?php foreach ($product_types as $product_types_key => $product_type_row): ?>
                                                        <option value="<?= $product_type_row['id'] ?>"><?= $product_type_row['product_type_name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <small class="text-danger" id="fk_product_type_id_error"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="attribute_name">Attribute Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="attribute_name" name="attribute_name" placeholder="Enter Attribute Name">
                                                <small class="text-danger" id="attribute_name_error"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="product_type_name">Attribute Type <span class="text-danger">*</span></label>
                                                <select class="chosen-select form-control" id="attribute_type" name="attribute_type">
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

        <div class="modal fade" id="viewProductTypeModal" tabindex="-1" aria-labelledby="viewProductTypeLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewProductTypeLabel">View Product Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Product Type Name:</strong> <span id="view_product_type_name"></span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editProductTypeModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Product Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editProductTypeForm">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="edit_id" name="edit_id">
                                        <label class="col-form-label" for="edit_product_type_name">Product Type <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="edit_product_type_name" name="edit_product_type_name" placeholder="Enter Product Type Name">
                                        <span id="edit_product_type_name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Product Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this product type?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="close btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirm-delete">Delete</button>
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
