<?php
class Role_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
    public function check_permission($module_name, $action) {
        $role_id = $this->session->userdata('fk_role_id');
        print_r($role_id);die;
        $this->db->select("p.can_$action");
        $this->db->from('permissions p');
        $this->db->join('modules m', 'p.module_id = m.id');
        $this->db->where('p.role_id', $role_id);
        $this->db->where('m.module_name', $module_name);
        $query = $this->db->get()->row_array();
        return isset($query["can_$action"]) && $query["can_$action"] == 1;
    }

    public function get_role_permission($role_id) {
        $this->db->select('tbl_permissions.*, tbl_role.role_name, tbl_role.id as role_id, tbl_sidebar.sidebar_name, tbl_sidebar.id as sidebar_id');
        $this->db->from('tbl_permissions');
        $this->db->join('tbl_role', 'tbl_permissions.fk_role_id = tbl_role.id');
        $this->db->join('tbl_sidebar', 'tbl_permissions.fk_sidebar_id = tbl_sidebar.id');
        $this->db->where('tbl_permissions.fk_role_id', $role_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_permissions_by_role($role_id="")
    {
        $this->db->select('fk_sidebar_id, can_view, can_add, can_edit, can_delete, has_access');
        $this->db->from('tbl_permissions');
        $this->db->where('fk_role_id', $role_id);
        $query = $this->db->get();

        $permissions = [];
        foreach ($query->result_array() as $row) {
            $permissions[$row['fk_sidebar_id']] = [
                'view' => $row['can_view'],
                'add' => $row['can_add'],
                'edit' => $row['can_edit'],
                'delete' => $row['can_delete'],
                'access' => $row['has_access'] // Include access for dashboard
            ];
        }

        return $permissions;
    }

}