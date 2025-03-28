<?php
class Product_attribute_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_product_attribute_detail()
    {
        $this->db->select('GROUP_CONCAT(tbl_product_attributes.attribute_name) as attribute_names, 
                        GROUP_CONCAT(tbl_product_attributes.attribute_type) as attribute_types, 
                        tbl_product_types.product_type_name');
        $this->db->from('tbl_product_attributes');
        $this->db->join('tbl_product_types', 'tbl_product_types.id = tbl_product_attributes.fk_product_type_id', 'left');
        $this->db->where('tbl_product_attributes.is_delete', '1');
        $this->db->order_by('tbl_product_attributes.id', 'DESC');
        $this->db->group_by('tbl_product_attributes.fk_product_type_id');
        $query = $this->db->get();
        return $data = $query->result_array();
    }
}
