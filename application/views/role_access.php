<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Nia Natura Inventory Management</title>
    <?php include('common/css_files.php') ?>
    <style>
    /* Bigger checkboxes */
    .larger-checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    /* Make it more visible on light backgrounds */
    .form-check-input {
        border: 2px solid #555;
        background-color: #fff;
    }

    /* On checked */
    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }

    /* Label spacing for better alignment */
    .form-check-label {
        font-weight: normal;
        font-size: 14px;
    }
    </style>
</head>

<body>
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <div id="main-wrapper">
        <?php include('common/nav_head.php') ?>
        <?php include('common/header.php') ?>
        <?php include('common/sidebar.php') ?>

        <div class="content-body">
            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?><?= $controller_name?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a
                                href="<?= base_url() ?><?= $controller_name?>/role_and_access">Role &
                                Access</a></li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <form id="RoleAccessForm">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="role_id">Select Role<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select name="role_id" id="role" class="chosen-select form-select">
                                                    <option value="" disabled selected>Select a Role</option>
                                                    <?php foreach ($roles as $role_key => $role_row): ?>
                                                    <option value="<?= $role_row['id'] ?>"><?= $role_row['role_name'] ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <small class="text-danger" id="role_id_error"></small>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-4">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0">Role & Access Permissions</h5>
                            </div>
                            <div class="card-body">
                                <table id="ProductAttributeTable" class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Module</th>
                                            <th>View</th>
                                            <th>Add</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($modules as $module_key => $module_row): ?>
                                        <tr>
                                            <td><strong><?= ucfirst($module_row['sidebar_name']) ?></strong></td>

                                            <?php if (strtolower($module_row['sidebar_name']) === 'dashboard'): ?>
                                            <td colspan="4" class="text-center">
                                                <div class="form-check">
                                                    <!-- Hidden input to ensure the field is always sent -->
                                                    <input type="hidden"
                                                        name="permissions[<?= $module_row['id'] ?>][access]" value="0">
                                                    <input class="form-check-input larger-checkbox" type="checkbox"
                                                        name="permissions[<?= $module_row['id'] ?>][access]" value="1"
                                                        id="access_<?= $module_row['id'] ?>">
                                                    <label class="form-check-label ms-2"
                                                        for="access_<?= $module_row['id'] ?>">Show in Sidebar</label>
                                                    <small class="text-danger" id="permissions_error"></small>
                                                </div>
                                            </td>
                                            <?php else: ?>
                                            <?php foreach (['view', 'add', 'edit', 'delete'] as $perm): ?>
                                            <td class="text-center align-middle">
                                                <div
                                                    class="form-check d-flex justify-content-center align-items-center">
                                                    <input class="form-check-input larger-checkbox" type="checkbox"
                                                        name="permissions[<?= $module_row['id'] ?>][<?= $perm ?>]"
                                                        value="1" id="<?= $perm ?>_<?= $module_row['id'] ?>">
                                                    <label class="form-check-label ms-2"
                                                        for="<?= $perm ?>_<?= $module_row['id'] ?>"></label>
                                                    <small class="text-danger" id="permissions_error"></small>
                                                </div>
                                            </td>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>

                                </table>
                                <div class="text-right mt-3">
                                    <button type="submit" class="btn btn-success">
                                        <i class="icon-save"></i> Save Permissions
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>




        <?php include('common/footer.php') ?>
    </div>

    <?php include('common/js_files.php') ?>
    <script src="<?= base_url() ?>assets/view_js/role_access.js"></script>
</body>

</html>