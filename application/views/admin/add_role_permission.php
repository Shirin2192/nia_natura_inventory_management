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
                        <li class="breadcrumb-item active"><a href="<?=base_url()?>admin/add_staff">Role Permissions
                            </a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="module">Module <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="module" name="module"
                                                    placeholder="Enter Module">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="permission_name">Permission Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="permission_name"
                                                    name="permission_name" placeholder="Enter Permission Name">
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
                                <h5>Role Permission List</h5>
                                <table id="permissionsTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Module</th>
                                            <th>Permission Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Example Data (Replace with Database Data) -->
                                        <tr>
                                            <td>Inventory</td>
                                            <td>View</td>
                                            <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-toggle="modal" data-target="#edit_role_permission_modal" data-id="1">Edit</button>
                                            <button class="btn btn-danger btn-sm delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="1">Delete</button>
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
    <!-- #/ container -->
    </div>
    <!--**********************************
         Content body end
         ***********************************-->
    <!-- Edit Modal -->
    <div class="modal fade" id="edit_role_permission_modal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-staff-form">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_module">Module <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_module" name="edit_module"
                                        placeholder="Enter Module">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="edit_permission_name">Permission Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_permission_name" name="edit_permission_name"
                                        placeholder="Enter Permission Name">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" form="edit-product-form" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Role Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this staff member?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    </div>
    <!--**********************************
         Footer start
         ***********************************-->
    <div class="footer">
        <div class="copyright">
            <p>Copyright &copy; Designed & Developed by <a href="https://themeforest.net/user/quixlab">Quixlab</a> 2018
            </p>
        </div>
    </div>
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
    <script>
    $(document).ready(function() {
        $(".chosen-select").chosen({
            allow_single_deselect: true,
            heigth: '100%'
        });
        $('#staffTable').DataTable();

        // Edit button click event
        $('.edit-btn').on('click', function() {
            var id = $(this).data('id');
            // Populate the edit modal fields using AJAX or dummy data
            $('#edit_first_name').val('John');
            $('#edit_last_name').val('Doe');
            $('#edit_email').val('john.doe@example.com');
            $('#edit_phone').val('1234567890');
            $('#edit_role').val('admin');
        });

        // Delete button click event
        $('.delete-btn').on('click', function() {
            var id = $(this).data('id');
            $('#confirmDelete').on('click', function() {
                // Call delete API or perform delete action
                console.log('Deleting staff with ID: ' + id);
                // Close modal
                $('#deleteModal').modal('hide');
            });
        });
    });
    </script>
</body>

</html>