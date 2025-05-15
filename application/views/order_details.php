<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Nia Natura Inventory Management</title>
    <!-- Favicon icon -->
    <?php include('common/css_files.php')?>
</head>

<body>
    <!--*******************
         Preloader start
         ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
         Preloader end
         ********************-->
    <!--**********************************
         Main wrapper start
         ***********************************-->
    <div id="main-wrapper">
        <!--**********************************
            Nav header start
            ***********************************-->
        <?php include('common/nav_head.php')?>
        <!--**********************************
            Nav header end
            ***********************************-->
        <!--**********************************
            Header start
            ***********************************-->
        <?php include('common/header.php')?>
        <!--**********************************
            Header end ti-comment-alt
            ***********************************-->
        <!--**********************************
            Sidebar start
            ***********************************-->
        <?php include('common/sidebar.php')?>
        <!--**********************************
            Sidebar end
            ***********************************-->
        <!--**********************************
            Content body start
            ***********************************-->
        <div class="content-body">
            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=base_url()?><?= $controller_name ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a
                                href="<?=base_url()?><?= $controller_name ?>/order_details">Order Details</a></li>
                    </ol>
                </div>
            </div>
            <?php
                $sidebar_id = $current_sidebar_id;            
                $can_add = isset($permissions[$sidebar_id]['can_add']) && $permissions[$sidebar_id]['can_add'] == 1;
            ?>
            <?php if ($can_add): ?>
            <!-- row -->
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="OrderForm">
                                    <div class="row">
                                        <input type="hidden" name="product_id" id="product_id">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="sku_code">SKU Code <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select class=" chosen-select form-control" id="sku_code"
                                                    name="sku_code" data-placeholder="Select SKU Code">
                                                    <option value="">Select SKU Code</option>
                                                    <?php foreach ($sku_code as $sku_code_row) { ?>
                                                    <option value="<?= $sku_code_row['id'] ?>">
                                                        <?= $sku_code_row['sku_code'] ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                                <small class="text-danger" id="sku_code_error"></small>
                                                <!-- Error message here -->
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="fk_batch_id">Batch Id <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select class=" chosen-select form-control" id="fk_batch_id"
                                                    name="fk_batch_id" data-placeholder="Select Batch Id">
                                                    <option value="">Select Product</option>

                                                </select>
                                                <small class="text-danger" id="fk_batch_id_error"></small>
                                                <!-- Error message here -->
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
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

                                                </select>
                                                <div class="text-danger"><?= form_error('sale_channel'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="form-group">
                                                <label class="col-form-label" for="order_quantity">Quantity <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" name="order_quantity" id="order_quantity"
                                                    class="form-control">
                                                <div class="text-danger"><?= form_error('order_quantity'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="form-group">
                                                <label class="col-form-label" for="reason">Reason <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="reason" id="reason"
                                                    class="form-control">
                                                <div class="text-danger"><?= form_error('reason'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="inventory_type">Order Type <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select class=" chosen-select form-control" id="inventory_type"
                                                    name="inventory_type" data-placeholder="Select Order Type">
                                                    <option value=""></option>
                                                    <?php foreach ($inventory_type as $inventory_type_row) { ?>
                                                    <option value="<?= $inventory_type_row['id'] ?>">
                                                        <?= $inventory_type_row['name'] ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                                <small class="text-danger" id="inventory_type_error"></small>
                                                <!-- Error message here -->
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

                                <!-- Excel Upload Section -->
                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <form id="ExcelOrderUploadForm" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="excel_file">Upload Excel File <span
                                                        class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="excel_file"
                                                    id="excel_file" accept=".xls,.xlsx">
                                                <small class="text-danger" id="excel_file_error"></small>
                                            </div>
                                            <button type="submit" class="btn btn-success">Upload Orders</button>

                                        </form>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-info" role="alert">
                                            <strong>Note:</strong> Please ensure that the Excel file contains the
                                            correct
                                            format and data before uploading.
                                        </div>
                                        <div class="alert alert-warning" role="alert">
                                            <strong>Download Sample Excel:</strong> <a
                                                href="<?= base_url('assets/sample_excel/order_details_sample.xlsx') ?>"
                                                class="btn btn-primary btn-sm">Download</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php endif ?>
                    <!-- Row for DataTable -->
                 <div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5>Order Management</h5>

                    <!-- Tabs Nav -->
                    <ul class="nav nav-tabs" id="orderTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="sale-tab" data-toggle="tab" href="#saleOrder" role="tab">Sale Order</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="return-tab" data-toggle="tab" href="#returnOrder" role="tab">Return Order</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="damaged-tab" data-toggle="tab" href="#damagedOrder" role="tab">Damaged Order</a>
                        </li>
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content mt-3" id="orderTabContent">
                        <!-- Sale Order Tab -->
                        <div class="tab-pane fade show active" id="saleOrder" role="tabpanel">
                            <table id="OrderTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Product Name</th>
                                        <th>SKU CODE</th>
                                        <th>Batch No</th>
                                        <th>Channel Type</th>
                                        <th>Sales Channel</th>
                                        <th>Deducted Quantity</th>
                                        <th>Total Quantity</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <!-- Return Order Tab -->
                        <div class="tab-pane fade" id="returnOrder" role="tabpanel">
                            <table id="ReturnOrderTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Product Name</th>
                                        <th>SKU CODE</th>
                                        <th>Batch No</th>
                                        <th>Channel Type</th>
                                        <th>Sales Channel</th>
                                        <th>Returned Quantity</th>
                                        <th>Total Quantity</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <!-- Damaged Order Tab -->
                        <div class="tab-pane fade" id="damagedOrder" role="tabpanel">
                            <table id="DamagedOrderTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Product Name</th>
                                        <th>SKU CODE</th>
                                        <th>Batch No</th>
                                        <th>Channel Type</th>
                                        <th>Sales Channel</th>
                                        <th>Damaged Quantity</th>
                                        <th>Total Quantity</th>
                                        <th>Date</th>
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
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
         Content body end
         ***********************************-->
        <!-- View Sale Channel Details Modal -->
        <div class="modal fade" id="sale_channelModal" tabindex="-1" role="dialog"
            aria-labelledby="sale_channelModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sale_channelModalLabel">Sale Channel Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="sale_channelContent">
                        <!-- Flavour details will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Sale Channel Modal -->
        <div class="modal fade" id="edit_sale_channel_modal" tabindex="-1" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Sale Channel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="edit_sale_channel_form">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <input type="hidden" name="edit_sale_channel_id" id="edit_sale_channel_id">
                                        <label class="col-form-label" for="edit_sale_channel">Sale Channel <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="edit_sale_channel"
                                            name="edit_sale_channel" placeholder="Enter Sale Channel">
                                        <small class="text-danger" id="edit_sale_channel_error"></small>
                                        <!-- Error message here -->
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                        <h5 class="modal-title" id="deleteModalLabel">Delete Sale Channel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Sale Channel?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirm-delete">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
         Footer start
         ***********************************-->
        <?php include('common/footer.php')?>
        <!--**********************************
         Footer end
         ***********************************-->
    </div>
    <!--**********************************
         Main wrapper end
         ***********************************-->
    <!--**********************************
         Scripts
         ***********************************-->
    <?php include('common/js_files.php')?>
    <script src="<?= base_url()?>assets/view_js/order_details.js"></script>
</body>

</html>