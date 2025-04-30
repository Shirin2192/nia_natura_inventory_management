<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nia Natura Inventory Management</title>
    <!-- Favicon icon -->
    <?php include('common/css_files.php')?>
    <style>
    #attribute_fields_container select {
        width: 100% !important;
    }
    </style>
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
                        <li class="breadcrumb-item"><a href="<?=base_url()?><?= $controller_name?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="<?=base_url()?><?= $controller_name?>/add_staff">Add
                                Product</a></li>
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
                                <form id="ProductForm" enctype="multipart/form-data">
                                    <div class="form-validation">
                                        <!-- Product Information -->
                                        <div class="row">

                                            <!-- Product ID/SKU -->
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="product_sku_code">Product SKU
                                                        Code <span class="text-danger">*</span></label>
                                                    <!-- <input type="text" class="form-control" id="product_sku_code"
                                                        name="product_sku_code" placeholder="Enter Product SKU Code"> -->
                                                    <select class="chosen-select form-control" id="product_sku_code"
                                                        name="product_sku_code">
                                                        <option value=""></option>
                                                        <?php foreach($product_sku_code as $product_sku_code_key => $product_sku_code_row) {?>
                                                        <option value="<?= $product_sku_code_row['id']?>">
                                                            <?= $product_sku_code_row['sku_code']?></option>
                                                        <?php } ?>
                                                    </select>
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
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="product_name">Product Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="product_name"
                                                        name="product_name" placeholder="Enter Product Name">
                                                    <div class="text-danger"><?= form_error('product_name'); ?></div>
                                                </div>
                                            </div>
                                            <!-- Flavor -->
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="fk_product_types_id">Product Type
                                                        <span class="text-danger">*</span></label>
                                                    <select class="chosen-select form-control" id="fk_product_types_id"
                                                        name="fk_product_types_id">
                                                        <option value=""></option>
                                                        <?php foreach($product_types as $product_types_key => $product_types_row) {?>
                                                        <option value="<?= $product_types_row['id']?>">
                                                            <?= $product_types_row['product_type_name']?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="text-danger"><?= form_error('fk_product_types_id'); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Select Attribute -->

                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label"
                                                        for="fk_product_attribute_id">Attribute <span
                                                            class="text-danger">*</span></label>
                                                    <div id="attributes_container">
                                                        <select
                                                            class="chosen-select form-control fk_product_attribute_id"
                                                            id="fk_product_attribute_id_1"
                                                            name="fk_product_attribute_id[]">
                                                            <option value="">Select Attribute</option>
                                                            <?php foreach($product_attributes as $attribute): ?>
                                                            <option value="<?= $attribute['id'] ?>">
                                                                <?= $attribute['attribute_name'] ?>
                                                            </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="text-danger">
                                                        <?= form_error('fk_product_attribute_id'); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 mb-3">
                                                <div class="form-group">
                                                    <!-- <label class="col-form-label"
                                                        for="attribute_value">Attribute Value <span
                                                            class="text-danger">*</span></label> -->
                                                    <div id="attribute_fields_container">

                                                    </div>
                                                    <div class="text-danger">
                                                        <?= form_error('attribute_value'); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Add More Button -->
                                            <!-- Add More Button -->

                                            <div class="col-lg-2 mb-3 d-flex align-items-end">
                                                <button type="button" class="btn btn-success w-100"
                                                    id="add_more_attributes">Add More</button>
                                            </div>
                                        </div>
                                        <div class="row">
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
                                                    <label class="col-form-label" for="manufacture_date">Manufacture
                                                        Date <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="manufacture_date"
                                                        name="manufacture_date" placeholder="Select Manufacture Date">
                                                    <div class="text-danger"><?= form_error('manufacture_date'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="expiry_date">Expiry Date <span
                                                            class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="expiry_date"
                                                        name="expiry_date" placeholder="Select Expiry Date">
                                                    <div class="text-danger"><?= form_error('expiry_date'); ?></div>
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
                                                <label class="col-form-label" for="fk_sourcing_partner_id">Sourcing Partner <span class="text-danger">*</span></label>
                                                <select class="chosen-select form-control" id="fk_sourcing_partner_id"
                                                    name="fk_sourcing_partner_id">
                                                    <option value=""></option>
                                                    <?php foreach($fk_sourcing_partner_id as $fk_sourcing_partner_id_key => $fk_sourcing_partner_id_row) {?>
                                                    <option value="<?= $fk_sourcing_partner_id_row['id']?>">
                                                        <?= $fk_sourcing_partner_id_row['name']?></option>
                                                    <?php } ?>
                                                </select>
                                                <div class="text-danger"><?= form_error('fk_sourcing_partner_id'); ?></div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg-6 mb-3">
                                            <div class="form-group">
                                                <label class="col-form-label" for="channel_type">Channel
                                                    Type<span class="text-danger">*</span></label>
                                                <div><select class=" chosen-select form-control" id="channel_type"
                                                        name="channel_type">
                                                        <option value=""></option>
                                                        <option value="Online">Online</option>
                                                        <option value="Offline">Offline</option>
                                                    </select></div>
                                                <div class="text-danger"><?= form_error('channel_type'); ?>
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
                                        </div> -->
                                        <div class="col-lg-6 mb-3">
                                            <div class="form-group">
                                                <label class="col-form-label" for="reason">Reason
                                                    Quantity <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="reason"
                                                    name="reason" placeholder="Enter Reason">
                                                <div class="text-danger"><?= form_error('reason'); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Submit Button -->
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
                            <div class="card-header">
                                <h4 class="card-title">Excel Upload</h4>
                            </div>
                            <div class="card-body">
                                <form id="productTypeForm">
                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <label class="col-form-label" for="fk_product_types_ids">Product Type
                                                <span class="text-danger">*</span></label>
                                            <select class="chosen-select form-control" id="fk_product_types_ids"
                                                name="fk_product_types_ids">
                                                <option value=""></option>
                                                <?php foreach($product_types as $product_types_key => $product_types_row) { ?>
                                                <option value="<?= $product_types_row['id']?>">
                                                    <?= $product_types_row['product_type_name']?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                            <div class="text-danger"><?= form_error('fk_product_types_ids'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group">
                                        <div class="col-lg-8 ml-auto">
                                            <button type="button" onclick="downloadSampleExcel()"
                                                class="btn btn-primary">Download Sample Excel</button>
                                        </div>
                                    </div>

                                </form>
                                <form id="excelUploadForm" enctype="multipart/form-data" method="post">

                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <label class="col-form-label" for="product_excel">Upload Excel File <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="product_excel"
                                                name="product_excel" accept=".xls, .xlsx">
                                            <small class="text-muted">Only .xls and .xlsx files are allowed</small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-8 ml-auto">
                                            <button type="submit" class="btn btn-success">Upload and Import</button>
                                        </div>
                                    </div>
                                </form>
                                <div id="RejectedExcelDownload"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>

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
                                                <th></th> <!-- Expand/Collapse Button -->
                                                <th>ID</th>
                                                <th>Product Name</th>
                                                <th>SKU CODE</th>
                                                <th>Purchase Price</th>
                                                <th>Total Quantity</th>
                                                <th>Product Types</th>
                                                <th>Action</th>
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
        <div class="modal-dialog modal-xl custom-modal-fullwidth">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewProductLabel">Product Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <!-- Inside your modal-body -->
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6><strong>Product Name:</strong></h6>
                                    <p id="view_product_name" class="text-muted"></p>
                                </div>
                                <div class="mb-3">
                                    <h6><strong>Attributes:</strong></h6>
                                    <div id="view_product_attributes"></div> <!-- Changed to div -->
                                </div>
                                <div class="mb-3">
                                    <h6><strong>Barcode:</strong></h6>
                                    <p id="view_barcode" class="text-muted"></p>
                                </div>

                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6><strong>Product SKU Code:</strong></h6>
                                    <p id="view_product_sku" class="text-muted"></p>
                                </div>
                                <div class="mb-3">
                                    <h6><strong>Product Types:</strong></h6>
                                    <p id="view_product_type" class="text-muted"></p>
                                </div>
                                <div class="mb-3">
                                    <h6><strong>Available Status:</strong></h6>
                                    <p id="view_available_status" class="text-muted"></p>
                                </div>
                                <div class="mb-3">
                                    <h6><strong>Description:</strong></h6>
                                    <p id="view_description" class="text-muted"></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h6><strong>Batch Details:</strong></h6>
                                <div id="view_batches"></div> <!-- New Div for batch list -->
                            </div>
                            <!-- <div class="mb-3">
                                    <h6><strong>Channel & Pricing Info:</strong></h6>
                                    <div id="view_channels"></div> 
                                </div> -->


                            <!-- Full Width Images -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <h6><strong>Images:</strong></h6>
                                    <div id="view_images" class="d-flex flex-wrap gap-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="updateProductModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl custom-modal-fullwidth">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="UpdateProductForm" enctype="multipart/form-data">
                    <input type="hidden" id="update_product_id" name="update_product_id">
                    <input type="hidden" id="update_inventory_id" name="update_inventory_id">
                    <input type="hidden" id="product_price_id" name="product_price_id">
                    <input type="hidden" id="update_product_image" name="update_product_image">
                    <input type="hidden" id="update_batch_id" name="update_batch_id">
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
                                    <label class="col-form-label" for="update_product_sku">Product SKU Code <span
                                            class="text-danger">*</span></label>
                                    <p id="update_product_sku" class="text-muted"></p>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_fk_product_types_id">Product Type<span
                                            class="text-danger">*</span></label>
                                    <select class=" chosen-select form-control" id="update_fk_product_types_id"
                                        name="update_fk_product_types_id">
                                        <option value=""></option>
                                        <?php foreach($product_types as $product_types_key => $product_types_row) {?>
                                        <option value="<?= $product_types_row['id']?>">
                                            <?= $product_types_row['product_type_name']?></option>
                                        <?php } ?>
                                    </select>

                                    <div class="text-danger"><?= form_error('update_fk_product_types_id'); ?></div>
                                </div>
                            </div>
                        </div>
                        <!-- Dynamic Attribute Fields -->
                        <div id="attribute_fields_container_edit"></div>
                        <!-- Add More Attributes (dropdown + button) – move this BELOW -->
                        <div id="attributes_container_edit"></div>
                        <!-- Add More Attributes Button -->
                        <div class="row mt-3">
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn btn-success" id="add_more_attributes_edit">
                                    + Add More Attributes
                                </button>
                            </div>
                        </div>
                        <div class="row">
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
                                        Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="update_description" name="update_description"
                                        placeholder="Enter Product Description"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_product_images">Product Image <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="update_product_images"
                                        name="update_product_images[]" multiple>
                                </div>

                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_availability_status">Availability
                                        Status <span class="text-danger">*</span></label>
                                    <div><select class=" chosen-select form-control" id="update_availability_status"
                                            name="update_availability_status">
                                            <option value=""></option>
                                            <?php foreach($stock_availability as $stock_availability_key => $stock_availability_row) {?>
                                            <option value="<?= $stock_availability_row['id']?>">
                                                <?= $stock_availability_row['stock_availability']?></option>
                                            <?php } ?>
                                        </select></div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_reason">Reason <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="update_reason" id="update_reason" placeholder="Enter Reason"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div id="update_images"></div>
                            </div>
                        </div>
                        <!-- Pricing and Cost Information -->
                        <hr>
                        <div class="row">
                            <div id="batch_fields_container_edit"></div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_batch_no">Batch No <span
                                            class="text-danger">*</span></label>
                                    <p class="form-control text-muted" id="update_batch_no"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_manufacture_date">Manufacture Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="update_manufacture_date"
                                        name="update_manufacture_date" placeholder="Select Manufacture Date">
                                    <div class="text-danger"><?= form_error('update_manufacture_date'); ?></div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_expiry_date">Expiry Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="update_expiry_date"
                                        name="update_expiry_date" placeholder="Select Expiry Date">
                                    <div class="text-danger"><?= form_error('update_expiry_date'); ?></div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_purchase_price">Purchase Price <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="update_purchase_price"
                                        name="update_purchase_price" placeholder="Enter Purchase Price">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_mrp">MRP <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="update_mrp" name="update_mrp"
                                        placeholder="Enter MRP">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_selling_price">Selling Price <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="update_selling_price"
                                        name="update_selling_price" placeholder="Enter Selling Price">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_total_quantity">Current Stock
                                        Quantity <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="update_total_quantity"
                                        name="update_total_quantity" placeholder="Enter Stock Quantity">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_channel_type">Channel Type <span
                                            class="text-danger">*</span></label>
                                    <div><select class=" chosen-select form-control" id="update_channel_type"
                                            name="update_channel_type">
                                            <option value=""></option>
                                            <option value="Online">Online</option>
                                            <option value="Offline">Offline</option>

                                        </select></div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_sale_channel">Sales Channels <span
                                            class="text-danger">*</span></label>
                                    <div><select class=" chosen-select form-control" id="update_sale_channel"
                                            name="update_sale_channel">

                                        </select></div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="update_reason">Reason <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="update_reason" name="update_reason"
                                        placeholder="Enter Reason">
                                </div>
                            </div>
                        </div> -->
                        <!-- Add New Batch Section -->
                        <hr>
                        <h5>Add New Batch</h5>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="add_new_batch_no">Add New Batch No <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="add_new_batch_no"
                                        name="add_new_batch_no" placeholder="Enter Add New Batch No">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="add_new_quantity">Add New Stock
                                        Quantity <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="add_new_quantity"
                                        name="add_new_quantity" placeholder="Enter Add New Stock Quantity">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="add_new_manufacture_date">Manufacture Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="add_new_manufacture_date"
                                        name="add_new_manufacture_date" placeholder="Select Manufacture Date">
                                    <div class="text-danger"><?= form_error('add_new_manufacture_date'); ?></div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="add_new_expiry_date">Expiry Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="add_new_expiry_date"
                                        name="add_new_expiry_date" placeholder="Select Expiry Date">
                                    <div class="text-danger"><?= form_error('add_new_expiry_date'); ?></div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="add_new_purchase_price">Purchase Price <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="add_new_purchase_price"
                                        name="add_new_purchase_price" placeholder="Enter Purchase Price">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="add_new_mrp">MRP <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="add_new_mrp" name="add_new_mrp"
                                        placeholder="Enter MRP">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="add_new_selling_price">Selling Price <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="add_new_selling_price"
                                        name="add_new_selling_price" placeholder="Enter Selling Price">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="add_new_reason">Reason <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="add_new_reason" name="add_new_reason"
                                        placeholder="Enter Reason">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="add_new_channel_type">Channel Type <span
                                            class="text-danger">*</span></label>
                                    <div><select class="chosen-select form-control" id="add_new_channel_type"
                                            name="add_new_channel_type">
                                            <option value=""></option>
                                            <option value="Online">Online</option>
                                            <option value="Offline">Offline</option>

                                        </select></div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="add_new_sale_channel">Sales Channels <span
                                            class="text-danger">*</span></label>
                                    <div><select class=" chosen-select form-control" id="add_new_sale_channel"
                                            name="add_new_sale_channel">

                                        </select></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
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