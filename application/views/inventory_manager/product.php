<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nia Natura Inventory Management</title>
    <!-- Favicon icon -->
    <?php include('common/css_files.php')?>
</head>

<body>
    <!--******************* Preloader start ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--******************* Preloader end ********************-->
    <!-- Main wrapper start -->
    <div id="main-wrapper">
        <!-- Nav header start -->
        <?php include('common/nav_head.php')?>
        <!-- Nav header end -->
        <!-- Header start -->
        <?php include('common/header.php')?>
        <!-- Header end -->
        <!-- Sidebar start -->
        <?php include('common/sidebar.php')?>
        <!-- Sidebar end -->
        <!-- Content body start -->
        <div class="content-body">
            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="<?=base_url()?>admin/add_staff">Add Product</a></li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="ProductForm" enctype="multipart/form-data">
                                    <div class="form-validation">
                                        <!-- Product Information -->
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="product_name">Product Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="product_name"
                                                        name="product_name" placeholder="Enter Product Name">
                                                    <div class="text-danger"><?= form_error('product_name'); ?></div>
                                                </div>
                                            </div>
                                            <!-- Product ID/SKU -->
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="product_sku_code">Product SKU
                                                        Code <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="product_sku_code"
                                                        name="product_sku_code" placeholder="Enter Product SKU Code">
                                                    <div class="text-danger"><?= form_error('product_sku_code'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Batch No -->
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="batch_no">Batch No </label>
                                                    <input type="text" class="form-control" id="batch_no"
                                                        name="batch_no" placeholder="Enter Batch No">
                                                    <div class="text-danger"><?= form_error('batch_no'); ?></div>
                                                </div>
                                            </div>
                                            <!-- Flavor -->
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="fk_flavour_id">Category <span
                                                            class="text-danger">*</span></label>
                                                    <select class="chosen-select form-control" id="fk_flavour_id"
                                                        name="fk_flavour_id">
                                                        <option value=""></option>
                                                        <?php foreach($flavour as $flavour_key => $flavour_row) {?>
                                                        <option value="<?= $flavour_row['id']?>">
                                                            <?= $flavour_row['flavour_name']?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="text-danger"><?= form_error('fk_flavour_id'); ?></div>
                                                </div>
                                            </div>
                                            <!-- Bottle Size -->
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="fk_bottle_size_id">Bottle Size
                                                        <span class="text-danger">*</span></label>
                                                    <select class="chosen-select form-control" id="fk_bottle_size_id"
                                                        name="fk_bottle_size_id">
                                                        <option value=""></option>
                                                        <?php foreach($bottle_size as $bottle_size_key => $bottle_size_row) {?>
                                                        <option value="<?= $bottle_size_row['id']?>">
                                                            <?= $bottle_size_row['bottle_size']?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="text-danger"><?= form_error('fk_bottle_size_id'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Bottle Type -->
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="fk_bottle_type_id">Bottle Type
                                                        <span class="text-danger">*</span></label>
                                                    <div><select class="chosen-select form-control"
                                                            data-placeholder="Select an option..."
                                                            id="fk_bottle_type_id" name="fk_bottle_type_id">
                                                            <option value=""></option>

                                                            <?php foreach($bottle_type as $bottle_type_key => $bottle_type_row) {?>
                                                            <option value="<?= $bottle_type_row['id']?>">
                                                                <?= $bottle_type_row['bottle_type']?></option>
                                                            <?php } ?>
                                                        </select></div>
                                                    <div class="text-danger"><?= form_error('fk_bottle_type_id'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Barcode -->
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="barcode">Barcode</label>
                                                    <input type="text" class="form-control" id="barcode" name="barcode"
                                                        placeholder="Enter Barcode">
                                                </div>
                                            </div>
                                            <!-- Product Description -->
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="description">Product
                                                        Description <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="description" name="description"
                                                        placeholder="Enter Product Description"></textarea>
                                                    <div class="text-danger"><?= form_error('description'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="product_image">Product
                                                        Image <span class="text-danger">*</span></label>
                                                    <input type="file" class="form-control" id="product_image"
                                                        name="product_image[]" multiple>
                                                    <small class="text-muted">You can upload multiple images</small>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Pricing and Cost Information -->
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="purchase_price">Purchase
                                                        Price <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="purchase_price"
                                                        name="purchase_price" placeholder="Enter Purchase Price">
                                                    <div class="text-danger"><?= form_error('purchase_price'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="mrp">MRP <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="mrp" name="mrp"
                                                        placeholder="Enter MRP">
                                                    <div class="text-danger"><?= form_error('mrp'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="selling_price">Selling
                                                        Price <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="selling_price"
                                                        name="selling_price" placeholder="Enter Selling Price">
                                                    <div class="text-danger"><?= form_error('selling_price'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="add_quantity">Stock
                                                        Quantity <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="add_quantity"
                                                        name="add_quantity" placeholder="Enter Stock Quantity">
                                                    <div class="text-danger"><?= form_error('add_quantity'); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Availability and Product Features -->
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="stock_availability">Availability
                                                        Status <span class="text-danger">*</span></label>
                                                    <select class="chosen-select form-control" id="stock_availability"
                                                        name="stock_availability">

                                                        <option value=""></option>
                                                        <?php foreach($stock_availability as $stock_availability_key => $stock_availability_row) {?>
                                                        <option value="<?= $stock_availability_row['id']?>">
                                                            <?= $stock_availability_row['stock_availability']?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="text-danger"><?= form_error('stock_availability'); ?>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="sale_channel">Sales
                                                        Channels <span class="text-danger">*</span></label>
                                                    <select class="chosen-select form-control" id="sale_channel"
                                                        name="sale_channel">
                                                        <option value=""></option>
                                                        <?php foreach($sale_channel as $sale_channel_key => $sale_channel_row) {?>
                                                        <option value="<?= $sale_channel_row['id']?>">
                                                            <?= $sale_channel_row['sale_channel']?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="text-danger"><?= form_error('sale_channel'); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Submit Button -->
                                        <div class="form-group">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table to show added products -->
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Product List</h4>
                                <div class="table-responsive">
                                    <table id="product_table" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Flavor</th>
                                                <th>Bottle Size</th>
                                                <th>Price</th>
                                                <th>Stock</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>

                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- Content body end -->
    <!-- View Product Modal -->
    <div class="modal fade" id="viewProductModal" tabindex="-1" role="dialog" aria-labelledby="viewProductLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewProductLabel">Product Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <p><strong>Product Name:</strong> <span id="view_product_name"></span></p>
                                <p><strong>Product SKU Code:</strong> <span id="view_product_sku_code"></span></p>
                                <p><strong>Batch No:</strong> <span id="view_batch_no"></span></p>
                                <p><strong>Category Name:</strong> <span id="view_flavour_name"></span></p>
                                <p><strong>Bottle Size:</strong> <span id="view_bottle_size"></span></p>
                                <p><strong>Bottle Type:</strong> <span id="view_bottle_type"></span></p>
                                <p><strong>Barcode:</strong> <span id="view_barcode"></span></p>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <p><strong>Product Description:</strong> <span id="view_description"></span></p>

                                <p><strong>Purchase Price:</strong> <span id="view_purchase_price"></span></p>
                                <p><strong>MRP:</strong> <span id="view_mrp"></span></p>
                                <p><strong>Selling Price:</strong> <span id="view_selling_price"></span></p>
                                <p><strong>Stock Quantity:</strong> <span id="view_total_quantity"></span></p>
                                <p><strong>Availability Status:</strong> <span id="view_availability_status"></span></p>
                                <p><strong>Sales Channels:</strong> <span id="view_sale_channel"></span></p>
                            </div>
                            <div class="col-md-12">
                                <p><strong>Images:</strong> <span id="view_images"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="updateProductModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="UpdateProductForm" enctype="multipart/form-data">
                    <input type="hidden" id="update_product_id" name="update_product_id">
                    <input type="hidden" id="fk_product_category_id" name="fk_product_category_id">
                    <input type="hidden" id="fk_product_type_id" name="fk_product_type_id">
                    <input type="hidden" id="fk_product_price_id" name="fk_product_price_id">
                    <input type="hidden" id="update_product_image" name="update_product_image">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_product_name">Product Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="update_product_name"
                                        name="update_product_name" placeholder="Enter Product Name">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_product_sku_code">Product SKU Code <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="update_product_sku_code"
                                        name="update_product_sku_code" placeholder="Enter Product SKU Code">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_batch_no">Batch No <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="update_batch_no" name="update_batch_no"
                                        placeholder="Enter Batch No">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_flavour_name">Category Name <span
                                            class="text-danger">*</span></label>
                                    <div><select class=" chosen-select form-control" id="update_flavour_name"
                                            name="update_flavour_name">

                                        </select></div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_bottle_size">Bottle Size <span
                                            class="text-danger">*</span></label>
                                    <div><select class=" chosen-select form-control" id="update_bottle_size"
                                            name="update_bottle_size">

                                        </select></div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_bottle_type">Bottle Type</label>
                                    <div><select class=" chosen-select form-control" id="update_bottle_type"
                                            name="update_bottle_type">

                                        </select></div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_barcode">Barcode</label>
                                    <input type="text" class="form-control" id="update_barcode" name="update_barcode"
                                        placeholder="Enter Barcode">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_description">Product
                                        Description</label>
                                    <textarea class="form-control" id="update_description" name="update_description"
                                        placeholder="Enter Product Description"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_product_images">Product Image</label>
                                    <input type="file" class="form-control" id="update_product_images"
                                        name="update_product_images[]" multiple>
                                </div>

                            </div>
                            <div class="col-lg-12">
                                <div id="update_images"></div>
                            </div>
                        </div>
                        <!-- Pricing and Cost Information -->
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_purchase_price">Purchase Price</label>
                                    <input type="number" class="form-control" id="update_purchase_price"
                                        name="update_purchase_price" placeholder="Enter Purchase Price">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_mrp">MRP</label>
                                    <input type="number" class="form-control" id="update_mrp" name="update_mrp"
                                        placeholder="Enter MRP">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_selling_price">Selling Price</label>
                                    <input type="number" class="form-control" id="update_selling_price"
                                        name="update_selling_price" placeholder="Enter Selling Price">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_total_quantity">Current Stock Quantity</label>
                                        <input type="number" class="form-control" id="update_total_quantity"
                                            name="update_total_quantity" placeholder="Enter Stock Quantity">                                   
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="add_new_quantity">Add New Stock Quantity</label>
                                        <input type="number" class="form-control" id="add_new_quantity"
                                            name="add_new_quantity" placeholder="Enter Add New Stock Quantity">                                   
                                </div>
                            </div>
                        </div>
                        <!-- Availability and Product Features -->
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_availability_status">Availability
                                        Status</label>
                                    <div><select class=" chosen-select form-control" id="update_availability_status"
                                            name="update_availability_status">

                                        </select></div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_sale_channel">Sales Channels</label>
                                    <div><select class=" chosen-select form-control" id="update_sale_channel"
                                            name="update_sale_channel">

                                        </select></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="save-changes-btn" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer start -->
    <?php include('common/footer.php')?>

    <!-- Footer end -->
    </div>
    <!-- Main wrapper end -->
    <!-- Scripts -->
    <?php include('common/js_files.php')?>
    <script src="<?= base_url()?>assets/view_js/product.js"></script>
</body>

</html>