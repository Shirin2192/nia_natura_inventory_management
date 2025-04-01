<?php
class Product_attribute_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_product_attribute_detail()
    {
        $this->db->select('GROUP_CONCAT(tbl_attribute_master.id) as attribute_id,GROUP_CONCAT(tbl_attribute_master.attribute_name) as attribute_names, 
                        GROUP_CONCAT(tbl_attribute_master.attribute_type) as attribute_types, 
                        tbl_product_types.product_type_name');
        $this->db->from('tbl_attribute_master');
        $this->db->join('tbl_product_types', 'tbl_product_types.id = tbl_attribute_master.fk_product_type_id', 'left');
        $this->db->where('tbl_attribute_master.is_delete', '1');
        $this->db->order_by('tbl_attribute_master.id', 'DESC');
        $this->db->group_by('tbl_attribute_master.fk_product_type_id');
        $query = $this->db->get();
        return $data = $query->result_array();
    }

    public function get_product_attribute_detail_id($id)
    {
        $this->db->select('tbl_attribute_master.id,tbl_attribute_master.attribute_name,tbl_attribute_master.attribute_type,tbl_product_types.product_type_name');
        $this->db->from('tbl_attribute_master');
        $this->db->join('tbl_product_types', 'tbl_product_types.id = tbl_attribute_master.fk_product_type_id', 'left');
        $this->db->where('tbl_attribute_master.id', $id);
        $query = $this->db->get();
        return $data = $query->row_array();
    }

    function get_product_attributes_value_detail()
    {
        $this->db->select('tbl_attribute_values.id,tbl_attribute_values.attribute_value,tbl_attribute_master.attribute_name');
        $this->db->from('tbl_attribute_values');
        $this->db->join('tbl_attribute_master', 'tbl_attribute_master.id = tbl_attribute_values.fk_attribute_id', 'left');
        $this->db->where('tbl_attribute_values.is_delete', '1');
        $query = $this->db->get();
        return $data = $query->result_array();
        
    }
    function get_product_attributes_value_detail_id($id)
    {
        $this->db->select('tbl_attribute_values.*,tbl_attribute_master.attribute_name');
        $this->db->from('tbl_attribute_values');
        $this->db->join('tbl_attribute_master', 'tbl_attribute_master.id = tbl_attribute_values.fk_attribute_id', 'left');
        $this->db->where('tbl_attribute_values.id', $id);
        $query = $this->db->get();
        return $data = $query->row_array();
    }
    
}
