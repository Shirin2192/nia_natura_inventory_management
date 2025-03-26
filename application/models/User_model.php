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
    
}