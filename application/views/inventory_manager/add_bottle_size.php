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
                        <li class="breadcrumb-item"><a href="<?=base_url()?>admin">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="<?=base_url()?>admin/add_bottle_size">Add Bottle
                                Size</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="bottleSizeForm">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="bottle_size">Bottle Size <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="bottle_size"
                                                    name="bottle_size" placeholder="Enter Bottle Size ">
                                                <small class="text-danger" id="bottle_size_error"></small>
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
            <!-- Row for DataTable -->
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5>Bottle Size List</h5>
                                <table id="bottleSizeTable" class="display">
                                    <thead>
                                        <tr>
                                            <th>Bottle Size</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Example Row -->
                                        <tr>
                                            <td>John</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm edit-btn" data-toggle="modal"
                                                    data-target="#edit_flavour_modal" data-id="1">Edit</button>
                                                <button class="btn btn-danger btn-sm delete-btn" data-toggle="modal"
                                                    data-target="#deleteModal" data-id="1">Delete</button>
                                            </td>
                                        </tr>
                                        <!-- More rows will be dynamically generated -->
                                    </tbody>
                                </table>
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
         <!-- Flavour Details Modal -->
<div class="modal fade" id="bottle_sizeModal" tabindex="-1" role="dialog" aria-labelledby="bottle_sizeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bottle_sizeModalLabel">Bottle Size Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="bottle_sizeContent">
                <!-- Flavour details will be loaded here -->
            </div>
        </div>
    </div>
</div>
    <!-- Edit Product Modal -->
    <div class="modal fade" id="edit_bottle_size_modal" tabindex="-1" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Bottle Size</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit_bottle_size_form">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                <input type="hidden" class="form-control" id="edit_bottle_size_id"
                                name="edit_bottle_size_id">
                                    <label class="col-form-label" for="edit_bottle_size">Bottle Size <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_bottle_size"
                                        name="edit_bottle_size" placeholder="Enter Bottle Size">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="close btn btn-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Close</button>
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
                    <button type="button" class="close btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Cancel</button>
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
    <script src="<?= base_url()?>assets/view_js/bottle_size.js"></script>
</body>

</html>