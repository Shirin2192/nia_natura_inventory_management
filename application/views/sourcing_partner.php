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
                        <li class="breadcrumb-item active"><a
                                href="<?=base_url()?><?= $controller_name?>/sourcing_partner">Sourcing Partner</a></li>
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
                                <form id="sourcing_partner_form">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="name">Name <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="Enter First Name">
                                                <small class="text-danger" id="name_error"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="email">Email <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Enter Email">
                                                <small class="text-danger" id="email_error"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="contact_no">Contact No <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="contact_no"
                                                    name="contact_no" placeholder="Enter contact_no">
                                                <small class="text-danger" id="contact_no_error"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="address">Address <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <textarea type="address" class="form-control" id="address"
                                                    name="address" placeholder="Enter address">
                                                </textarea><small class="text-danger" id="address_error"></small>
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
            <!-- Row for DataTable -->
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5>Sourcing partner List</h5>
                                <table id="sourcing_partner_table" class="display">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact No</th>
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
    <!-- View User Modal -->
    <div class="modal fade" id="viewSourcingPartnar" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl custom-modal-fullwidth">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewUserModalLabel">View Sourcing Partner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="view_name"></span></p>
                    <p><strong>Email:</strong> <span id="view_email"></span></p>
                    <p><strong>Contact No:</strong> <span id="view_contact_no"></span></p>
                    <p><strong>Address:</strong> <span id="view_address"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editSourcingPartnar" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl custom-modal-fullwidth">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Staff</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="update_sourcing_partner_form">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="hidden" id="id" name="id">
                                    <label class="col-form-label" for="edit_name">First Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_name" name="edit_name"
                                        placeholder="Enter First Name">
                                    <small class="text-danger" id="edit_name_error"></small>
                                </div>
                            </div>                            
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_email">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="edit_email" name="edit_email"
                                        placeholder="Enter Email">
                                    <small class="text-danger" id="edit_email_error"></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_contact_no">Contact No <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_contact_no" name="edit_contact_no"
                                        placeholder="Enter Contact No">
                                    <small class="text-danger" id="edit_contact_no_error"></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_address">Address <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_address" name="edit_address"
                                        placeholder="Enter Address">
                                    <small class="text-danger" id="edit_address_error"></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteSourcingPartnerModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteSourcingPartnerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header ">
                        <h5 class="modal-title" id="deleteSourcingPartnerModalLabel">
                            Confirm Delete
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body text-center">
                        <p class="font-weight-bold text-dark">
                            Are you sure you want to delete this Sourcing Partner?
                        </p>
                        <input type="hidden" id="delete_id" name="delete_id"> <!-- Hidden field for attribute ID -->
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">

                        <button type="button" class="btn btn-primary" id="confirmDeleteSourceingPartnerBtn">
                            Delete
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Cancel
                        </button>
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
    <script src="<?= base_url()?>assets/view_js/sourcing_partner.js"></script>
</body>

</html>