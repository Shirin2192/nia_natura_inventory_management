<?php

$session_types = ['admin_session', 'inventory_session', 'staff_session'];
$admin_session = null;

foreach ($session_types as $session_type_row) {
    $session_data = $this->session->userdata($session_type_row);
    if ($session_data) {
        $admin_session = $session_data;
        break;
    }
}
// print_r($admin_session); die;// Debugging line to check session data

if (!$admin_session) {
    // Handle case where no session is found
    $admin_session = ['role_id' => null]; // Default or error handling
}
$role_id = $admin_session['role_id'];

$role_permission = $this->Role_model->get_role_permission($role_id);

$accessible_sidebars = array_filter($role_permission, function ($permission) {
    if (isset($permission['fk_sidebar_id']) && $permission['fk_sidebar_id'] == 1) {
        return $permission['has_access'] == 1; // Only include if has_access is 1 for the dashboard
    }

    // For other modules, include them if fk_sidebar_id is set
    return isset($permission['fk_sidebar_id']);
});

$accessible_sidebar_ids = array_column($accessible_sidebars, 'fk_sidebar_id');
// Get the current controller name dynamically using the router class
$current_controller = $this->router->fetch_class();

?>
<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <?php if (in_array(1, $accessible_sidebar_ids)) : ?>
            <li>
                <a href="<?= base_url() . $current_controller ?>" aria-expanded="false">
                    <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if (in_array(2, $accessible_sidebar_ids)) : ?>
            <li>
                <a href="<?= base_url() . $current_controller ?>/add_staff" aria-expanded="false">
                    <i class="icon-user menu-icon"></i> <span class="nav-text"> Staff</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if (in_array(3, $accessible_sidebar_ids)) : ?>
            <li>
                <a href="<?= base_url() . $current_controller ?>/add_product_type" aria-expanded="false">
                    <i class="icon-star menu-icon"></i> <span class="nav-text"> Product Type</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if (in_array(4, $accessible_sidebar_ids)) : ?>
            <li>
                <a href="<?= base_url() . $current_controller ?>/add_product_attributes" aria-expanded="false">
                    <i class="icon-star menu-icon"></i> <span class="nav-text"> Product Attribute</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if (in_array(5, $accessible_sidebar_ids)) : ?>
            <li>
                <a href="<?= base_url() . $current_controller ?>/add_product_attributes_value" aria-expanded="false">
                    <i class="icon-star menu-icon"></i> <span class="nav-text"> Product Attribute Value</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if (in_array(6, $accessible_sidebar_ids)) : ?>
            <li>
                <a href="<?= base_url() . $current_controller ?>/add_sale_channel" aria-expanded="false">
                    <i class="icon-star menu-icon"></i> <span class="nav-text"> Sale Channel</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if (in_array(7, $accessible_sidebar_ids)) : ?>
            <li>
                <a href="<?= base_url() . $current_controller ?>/add_product" aria-expanded="false">
                    <i class="icon-star menu-icon"></i> <span class="nav-text"> Product</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if (in_array(8, $accessible_sidebar_ids)) : ?>
            <li>
                <a href="<?= base_url() . $current_controller ?>/order_details" aria-expanded="false">
                    <i class="icon-star menu-icon"></i> <span class="nav-text">Order Details</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if (in_array(9, $accessible_sidebar_ids)) : ?>
            <li>
                <a href="<?= base_url() . $current_controller ?>/role_and_access" aria-expanded="false">
                    <i class="icon-star menu-icon"></i> <span class="nav-text">Role & Access</span>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
?>
