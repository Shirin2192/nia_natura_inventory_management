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
                                <form>
                                    <div class="form-validation">
                                        <!-- Product Information -->
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="product_name">Product Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="product_name"
                                                        name="product_name" placeholder="Enter Product Name">
                                                </div>
                                            </div>
                                            <!-- Product ID/SKU -->
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="product_sku_code">Product SKU
                                                        Code <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="product_sku_code"
                                                        name="product_sku_code" placeholder="Enter Product SKU Code">
                                                </div>
                                            </div>
                                            <!-- Batch No -->
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="batch_no">Batch No <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="batch_no"
                                                        name="batch_no" placeholder="Enter Batch No">
                                                </div>
                                            </div>
                                            <!-- Flavor -->
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="flavor">Flavor <span
                                                            class="text-danger">*</span></label>
                                                    <select class="chosen-select form-control" id="flavor"
                                                        name="flavor">
                                                        <option value="Neem">Neem</option>
                                                        <option value="Tulsi">Tulsi</option>
                                                        <option value="Himalaya">Himalaya</option>
                                                        <option value="Jamun">Jamun</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Bottle Size -->
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="bottle_size">Bottle Size <span
                                                            class="text-danger">*</span></label>
                                                    <select class="chosen-select form-control" id="bottle_size"
                                                        name="bottle_size">
                                                        <option value="250ml">250ml</option>
                                                        <option value="500ml">500ml</option>
                                                        <option value="1L">1L</option>
                                                        <option value="2L">2L</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Bottle Type -->
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="bottle_type">Bottle Type</label>
                                                    <div><select class="chosen-select form-control"
                                                            data-placeholder="Select an option..." id="bottle_type"
                                                            name="bottle_type">
                                                            <option value=""></option>
                                                            <!-- Empty option for deselect -->
                                                            <option value="1">Option 1</option>
                                                            <option value="2">Option 2</option>
                                                            <option value="3">Option 3</option>
                                                        </select></div>
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
                                                    <label class="col-form-label" for="product_description">Product
                                                        Description</label>
                                                    <textarea class="form-control" id="product_description"
                                                        name="product_description"
                                                        placeholder="Enter Product Description"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="product_image">Product
                                                        Image</label>
                                                    <input type="file" class="form-control" id="product_image"
                                                        name="product_image">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Pricing and Cost Information -->
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="purchase_price">Purchase
                                                        Price</label>
                                                    <input type="number" class="form-control" id="purchase_price"
                                                        name="purchase_price" placeholder="Enter Purchase Price">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="mrp">MRP</label>
                                                    <input type="number" class="form-control" id="mrp" name="mrp"
                                                        placeholder="Enter MRP">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="selling_price">Selling
                                                        Price</label>
                                                    <input type="number" class="form-control" id="selling_price"
                                                        name="selling_price" placeholder="Enter Selling Price">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="stock_quantity">Stock
                                                        Quantity</label>
                                                    <input type="number" class="form-control" id="stock_quantity"
                                                        name="stock_quantity" placeholder="Enter Stock Quantity">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Availability and Product Features -->
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="availability_status">Availability
                                                        Status</label>
                                                    <select class="chosen-select form-control" id="availability_status"
                                                        name="availability_status">
                                                        <option value="in_stock">In Stock</option>
                                                        <option value="out_of_stock">Out of Stock</option>
                                                        <option value="backordered">Backordered</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="sales_channels">Sales
                                                        Channels</label>
                                                    <select class="chosen-select form-control" id="sales_channels"
                                                        name="sales_channels">
                                                        <option value="online">Online</option>
                                                        <option value="in_store">Offline</option>
                                                        <option value="both">Both</option>
                                                    </select>
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
            <div class="row">
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
                                    <tbody>
                                        <!-- Example of product data -->
                                        <tr>
                                            <td>Wildflower Honey</td>
                                            <td>Wildflower</td>
                                            <td>500ml</td>
                                            <td>$10.99</td>
                                            <td>50</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm edit-btn" data-toggle="modal"
                                                    data-target="#editModal" data-id="1">Edit</button>
                                                <button class="btn btn-danger btn-sm delete-btn" data-toggle="modal"
                                                    data-target="#deleteModal" data-id="1">Delete</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Acacia Honey</td>
                                            <td>Acacia</td>
                                            <td>1L</td>
                                            <td>$15.99</td>
                                            <td>30</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm edit-btn" data-toggle="modal"
                                                    data-target="#editModal" data-id="2">Edit</button>
                                                <button class="btn btn-danger btn-sm delete-btn" data-toggle="modal"
                                                    data-target="#deleteModal" data-id="2">Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
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
    <!-- Edit Product Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-product-form">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_product_name">Product Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_product_name" name="product_name"
                                        placeholder="Enter Product Name">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_product_sku_code">Product SKU Code <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_product_sku_code"
                                        name="product_sku_code" placeholder="Enter Product SKU Code">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_batch_no">Batch No <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_batch_no" name="batch_no"
                                        placeholder="Enter Batch No">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_flavor">Flavor <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="edit_flavor" name="flavor">
                                        <option value="Neem">Neem</option>
                                        <option value="Tulsi">Tulsi</option>
                                        <option value="Himalaya">Himalaya</option>
                                        <option value="Jamun">Jamun</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_bottle_size">Bottle Size <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="edit_bottle_size" name="bottle_size">
                                        <option value="250ml">250ml</option>
                                        <option value="500ml">500ml</option>
                                        <option value="1L">1L</option>
                                        <option value="2L">2L</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_bottle_type">Bottle Type</label>
                                    <select class="form-control" id="edit_bottle_type" name="bottle_type">
                                        <option value="glass">Glass</option>
                                        <option value="plastic">Plastic</option>
                                        <option value="jar">Jar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_barcode">Barcode</label>
                                    <input type="text" class="form-control" id="edit_barcode" name="barcode"
                                        placeholder="Enter Barcode">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_product_description">Product
                                        Description</label>
                                    <textarea class="form-control" id="edit_product_description"
                                        name="product_description" placeholder="Enter Product Description"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_product_image">Product Image</label>
                                    <input type="file" class="form-control" id="edit_product_image"
                                        name="product_image">
                                </div>
                            </div>
                        </div>
                        <!-- Pricing and Cost Information -->
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_purchase_price">Purchase Price</label>
                                    <input type="number" class="form-control" id="edit_purchase_price"
                                        name="purchase_price" placeholder="Enter Purchase Price">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_mrp">MRP</label>
                                    <input type="number" class="form-control" id="edit_mrp" name="mrp"
                                        placeholder="Enter MRP">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_selling_price">Selling Price</label>
                                    <input type="number" class="form-control" id="edit_selling_price"
                                        name="selling_price" placeholder="Enter Selling Price">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_stock_quantity">Stock Quantity</label>
                                    <input type="number" class="form-control" id="edit_stock_quantity"
                                        name="stock_quantity" placeholder="Enter Stock Quantity">
                                </div>
                            </div>
                        </div>
                        <!-- Availability and Product Features -->
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_availability_status">Availability
                                        Status</label>
                                    <select class="form-control" id="edit_availability_status"
                                        name="availability_status">
                                        <option value="in_stock">In Stock</option>
                                        <option value="out_of_stock">Out of Stock</option>
                                        <option value="backordered">Backordered</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_sales_channels">Sales Channels</label>
                                    <select class="form-control" id="edit_sales_channels" name="sales_channels">
                                        <option value="online">Online</option>
                                        <option value="in_store">Offline</option>
                                        <option value="both">Both</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="save-changes-btn" class="btn btn-primary">Save Changes</button>
                </div>
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
    <script>
    $(document).ready(function() {
        $(".chosen-select").chosen({
            allow_single_deselect: true,
            heigth: '100%'
        });
        // Initialize DataTable
        $('#product_table').DataTable();

        // Edit button functionality
        $('.edit-btn').on('click', function() {
            var productId = $(this).data('id');
            // You can fetch data from the server or use a predefined dataset for the modal
            // Example: Fill modal fields dynamically based on productId
            $('#edit_product_name').val("Sample Product " + productId);
            $('#edit_flavor').val("Sample Flavor");
            $('#edit_bottle_size').val("500ml");
            $('#edit_bottle_type').val("Glass");
            $('#edit_product_id').val(productId);
        });

        // Save changes button functionality
        $('#save-changes-btn').on('click', function() {
            var formData = $('#edit-product-form').serialize();
            // Perform AJAX request to save changes
            $.ajax({
                url: 'your-server-endpoint-url', // Replace with your server endpoint
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert('Changes saved successfully!');
                    $('#editModal').modal('hide');
                    // Optionally, refresh the product list or update the table
                },
                error: function(error) {
                    alert('An error occurred while saving changes.');
                }
            });
        });

        // Delete button functionality
        $('.delete-btn').on('click', function() {
            var productId = $(this).data('id');
            $('#confirm-delete').on('click', function() {
                // Perform delete operation (send to server)
                alert("Product " + productId + " deleted.");
                // Close the modal
                $('#deleteModal').modal('hide');
            });
        });
    });
    </script>
</body>

</html>