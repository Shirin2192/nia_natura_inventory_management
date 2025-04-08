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
                        <li class="breadcrumb-item"><a href="<?=base_url()?><?= $controller_name?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="<?=base_url()?><?= $controller_name?>/add_flavour">Add Sales
                                Channel</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
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
                                    <form id="SaleChannelForm">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="sale_channel">Channel Type<span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <select class="chosen-select form-control" id="channel_type"
                                                        name="channel_type">
                                                        <option value=""></option>
                                                        <option value="Online">Online</option>
                                                        <option value="Offline">Offline</option>
                                                    </select>
                                                    <small class="text-danger" id="channel_type_error"></small>
                                                    <!-- Error message here -->
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="sale_channel">Sale Channel <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" id="sale_channel"
                                                        name="sale_channel" placeholder="Enter Sale Channel">
                                                    <small class="text-danger" id="sale_channel_error"></small>
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
            <?php endif ?>
            <!-- Row for DataTable -->
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5>Sale Channel List</h5>
                                <table id="SalechannelTable" class="display">
                                    <thead>
                                        <tr>
                                            <th>Channel Type</th>
                                            <th>Sale Channel</th>
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
    <!-- #/ container -->
    </div>
    <!--**********************************
         Content body end
         ***********************************-->
    <!-- View Sale Channel Details Modal -->
    <div class="modal fade" id="sale_channelModal" tabindex="-1" role="dialog" aria-labelledby="sale_channelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl custom-modal-fullwidth">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Sale Channel Modal -->
    <div class="modal fade" id="edit_sale_channel_modal" tabindex="-1" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl custom-modal-fullwidth">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Sale Channel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_sale_channel_form">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <input type="hidden" name="edit_sale_channel_id" id="edit_sale_channel_id">
                                    <label class="col-form-label" for="edit_channel_type">Channel Type<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_channel_type"
                                        name="edit_channel_type" placeholder="Enter Channel Type" readonly>
                                    <small class="text-danger" id="edit_channel_type_error"></small>
                                    <!-- Error message here -->
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">

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
    <script src="<?= base_url()?>assets/view_js/sale_channel.js"></script>
</body>

</html>