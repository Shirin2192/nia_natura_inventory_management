<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>NIA NATURA - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include('common/css_files.php')?>
</head>

<body>

    <div id="main-wrapper">

        <?php include('common/nav_head.php')?>
        <?php include('common/header.php')?>
        <?php include('common/sidebar.php')?>

        <div class="content-body">
            <div class="container-fluid mt-4">

                <!-- TOP CARDS -->
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2"
                            style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff;">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">Total Products</h5>
                                    <h3><?= isset($total_product_count['product_count']) ? $total_product_count['product_count'] : '0' ?>
                                    </h3>
                                </div>
                                <div><i class="fa fa-cubes fa-3x" style="color: rgba(255,255,255,0.5);"></i></div>
                            </div>
                        </div>
                    </div>
                    <!-- Card 2 - Green Gradient -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2"
                            style="background: linear-gradient(135deg, #1cc88a, #17a673); color: #fff;">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">Total Orders</h5>
                                    <h3><?= isset($total_order_count['order_count']) ? $total_order_count['order_count'] : '0' ?>
                                    </h3>
                                </div>
                                <div><i class="fa fa-shopping-cart fa-3x" style="color: rgba(255,255,255,0.5);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card 4 - Orange Gradient -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2"
                            style="background: linear-gradient(135deg, #f6c23e, #dda20a); color: #fff;">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">Total Stock</h5>
                                    <h3><?= isset($total_stock['stock']) ? $total_stock['stock'] : '0' ?></h3>
                                </div>
                                <div><i class="fa fa-boxes fa-3x" style="color: rgba(255,255,255,0.5);"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CHARTS -->
            <div class="row">

                <!-- Stock Levels by Product -->
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">📦 Stock Levels by Product</h5>
                        </div>
                        <div class="card-body">
                           <canvas id="stockLevelChart" style="max-height: 500px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">

                <!-- Top 5 Products -->
                <div class="col-lg-6">
                    <div class="card shadow">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">🏆 Top 5 Products by Quantity</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="topProductsChart"></canvas>
                        </div>
                    </div>
                </div>

                

            </div>

        </div> <!-- /.container-fluid -->
    </div> <!-- /.content-body -->

    <?php include('common/footer.php')?>

    </div> <!-- /#main-wrapper -->

    <?php include('common/js_files.php')?>
    <script>
    // Injecting PHP variables into JavaScript
    // var stockProductNames = <?php echo json_encode($stock_product_names); ?>;
    // var stockQuantities = <?php echo json_encode($stock_quantities); ?>;
  
    var top5ProductNames = <?php echo json_encode($top5_product_names); ?>;
    var top5Quantities = <?php echo json_encode($top5_quantities); ?>;
     const stockProductNames = <?php echo json_encode($stock_product_names); ?>;
     const stockQuantities = <?php echo json_encode($stock_quantities); ?>;
    </script>

    <script src="<?= base_url()?>assets/view_js/admin_dashboard.js"></script>

</body>

</html>