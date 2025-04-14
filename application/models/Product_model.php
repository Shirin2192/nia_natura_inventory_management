<?php
class Product_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

    public function get_product_detail()
    {
        $this->db->select('
            tbl_product_master.*,
             tbl_sku_code_master.sku_code,
            GROUP_CONCAT(tbl_product_attributes.fk_product_types_id) as fk_product_types_id,
            GROUP_CONCAT(tbl_product_attributes.fk_attribute_id) as fk_attribute_id,
            GROUP_CONCAT(tbl_product_attributes.fk_attribute_value_id) as fk_attribute_value_id,,
            GROUP_CONCAT(tbl_attribute_master.attribute_name) as attribute_name,
            GROUP_CONCAT(tbl_product_types.product_type_name) as product_type_name,
            GROUP_CONCAT(tbl_attribute_values.attribute_value) as attribute_value,
            tbl_product_price.purchase_price,
            tbl_product_inventory.total_quantity,
            tbl_product_batches.batch_no,
            tbl_product_batches.expiry_date,
            tbl_product_batches.manufactured_date,
        ');
        $this->db->from('tbl_product_master');
        $this->db->join('tbl_product_attributes', 'tbl_product_attributes.fk_product_id = tbl_product_master.id', 'left');
        $this->db->join('tbl_attribute_master', 'tbl_product_attributes.fk_attribute_id = tbl_attribute_master.id', 'left');
        $this->db->join('tbl_attribute_values', 'tbl_product_attributes.fk_attribute_value_id = tbl_attribute_values.id', 'left');
        $this->db->join('tbl_product_types', 'tbl_product_attributes.fk_product_types_id = tbl_product_types.id', 'left');
        $this->db->join('tbl_product_price', 'tbl_product_price.fk_product_id = tbl_product_master.id', 'left');
        $this->db->join('tbl_product_inventory', 'tbl_product_inventory.fk_product_id = tbl_product_master.id', 'left');
        $this->db->join('tbl_sku_code_master', 'tbl_product_master.product_sku_code = tbl_sku_code_master.id', 'left');
        $this->db->join('tbl_product_batches', 'tbl_product_batches.fk_product_id=tbl_product_master.id', 'left');
        $this->db->where('tbl_product_master.is_delete', '1');
        $this->db->where('tbl_product_inventory.used_status', 1);
        $this->db->order_by('tbl_product_master.id', 'DESC');
        $this->db->group_by('tbl_product_master.id'); // Group by product ID to avoid duplicates
        $query = $this->db->get(); // Execute the query
        return $query->result_array(); // Return the result as an array
    }
    public function get_product_by_id($product_id) {
        $this->db->select('
            tbl_product_master.*,
            tbl_sku_code_master.sku_code,
            GROUP_CONCAT(tbl_product_attributes.fk_product_types_id) as fk_product_types_id,
            GROUP_CONCAT(tbl_product_attributes.fk_attribute_id) as fk_attribute_id,
            GROUP_CONCAT(tbl_product_attributes.fk_attribute_value_id) as fk_attribute_value_id,,
            GROUP_CONCAT(tbl_attribute_master.id) as attribute_id,
            GROUP_CONCAT(tbl_attribute_master.attribute_name) as attribute_name,
            GROUP_CONCAT(tbl_product_types.product_type_name) as product_type_name,
            GROUP_CONCAT(tbl_attribute_values.attribute_value) as attribute_value,
            tbl_product_price.purchase_price,
            tbl_product_price.MRP,
            tbl_product_price.selling_price,
            tbl_product_inventory.total_quantity,
            tbl_product_inventory.id as inventory_id,
            tbl_product_inventory.channel_type,
            tbl_product_inventory.fk_sale_channel_id,
             tbl_product_batches.batch_no,
            tbl_product_batches.expiry_date,
            tbl_product_batches.manufactured_date,
            tbl_product_batches.id as batch_id,
        ');
        $this->db->from('tbl_product_master');
        $this->db->join('tbl_product_attributes', 'tbl_product_attributes.fk_product_id = tbl_product_master.id', 'left');
        $this->db->join('tbl_attribute_master', 'tbl_product_attributes.fk_attribute_id = tbl_attribute_master.id', 'left');
        $this->db->join('tbl_attribute_values', 'tbl_product_attributes.fk_attribute_value_id = tbl_attribute_values.id', 'left');
        $this->db->join('tbl_product_types', 'tbl_product_attributes.fk_product_types_id = tbl_product_types.id', 'left');
        $this->db->join('tbl_product_price', 'tbl_product_price.fk_product_id = tbl_product_master.id', 'left');
        $this->db->join('tbl_product_inventory', 'tbl_product_inventory.fk_product_id = tbl_product_master.id', 'left');
        $this->db->join('tbl_sku_code_master', 'tbl_product_master.product_sku_code = tbl_sku_code_master.id', 'left');
        $this->db->join('tbl_product_batches', 'tbl_product_batches.fk_product_id=tbl_product_master.id', 'left');
        $this->db->where('tbl_product_master.id', $product_id);
        $this->db->where('tbl_product_master.is_delete', '1');
        $this->db->where('tbl_product_inventory.used_status', 1);
        $this->db->order_by('tbl_product_master.id', 'DESC');
        $this->db->group_by('tbl_product_master.id'); // Group by product ID to avoid duplicates
        $query = $this->db->get(); // Execute the query
        return $query->row_array(); // Return the result as an array
    }
}
