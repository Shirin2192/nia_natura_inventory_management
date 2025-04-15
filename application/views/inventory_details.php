<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Nia Natura Inventory Management</title>
    <!-- Favicon icon -->
    <?php include('common/css_files.php')?>
    <style>
    td.dt-control {
        text-align: center;
        cursor: pointer;
    }

    tr.shown td.dt-control::before {
        content: "-";
        font-weight: bold;
    }

    td.dt-control::before {
        content: "+";
        font-weight: bold;
    }
</style>

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
                        <li class="breadcrumb-item active"><a href="<?=base_url()?><?= $controller_name?>/add_staff">Add
                                Staff</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            <?php
    $sidebar_id = $current_sidebar_id;
   
    $can_add = isset($permissions[$sidebar_id]['can_add']) && $permissions[$sidebar_id]['can_add'] == 1;
?>
            <?php if ($can_add): ?>

            <?php endif; ?>
            <!-- Row for DataTable -->
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5>Inventory Details</h5>
                                <table id="productInventoryTable" class="display nowrap table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th> <!-- For plus/minus toggle -->
                                            <th>ID</th>
                                            <th>Product Name</th>
                                            <th>SKU Code</th>
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
    <script src="<?= base_url()?>assets/view_js/inventory_details.js"></script>
</body>

</html>