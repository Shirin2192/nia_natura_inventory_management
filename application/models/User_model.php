<?php
class User_model extends CI_Model
{
    public function get_total_users_count()
    {
        return $this->db->count_all("tbl_user");
    }

    public function get_paginated_users($start, $length)
    {
        $this->db->select("tbl_user.id, tbl_user.name, tbl_user.email, tbl_role.role_name");
        $this->db->from("tbl_user");
        $this->db->join("tbl_role", "tbl_user.fk_role_id = tbl_role.id", "left");
        $this->db->limit($length, $start);
        return $this->db->get()->result_array();
    }

    public function get_user_by_id($user_id)
    {
        $this->db->select('tbl_user.*, tbl_role.role_name');
        $this->db->from('tbl_user');
        $this->db->join('tbl_role', 'tbl_role.id = tbl_user.fk_role_id', 'left');
        $this->db->where('tbl_user.id', $user_id);
        $query = $this->db->get();

        return $query->row_array(); // Return single user data
    }
    
}