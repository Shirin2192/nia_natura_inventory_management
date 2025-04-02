<?php
class Product_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

    public function get_product_detail()
    {
        $this->db->select('
            tbl_product_master.*,
            GROUP_CONCAT(tbl_product_attributes.fk_product_types_id) as fk_product_types_id,
            GROUP_CONCAT(tbl_product_attributes.fk_attribute_id) as fk_attribute_id,
            GROUP_CONCAT(tbl_product_attributes.fk_attribute_value_id) as fk_attribute_value_id,,
            GROUP_CONCAT(tbl_attribute_master.attribute_name) as attribute_name,
            GROUP_CONCAT(tbl_product_types.product_type_name) as product_type_name,
            GROUP_CONCAT(tbl_attribute_values.attribute_value) as attribute_value,
            tbl_product_price.purchase_price,
            tbl_product_inventory.total_quantity
        ');
        $this->db->from('tbl_product_master');
        $this->db->join('tbl_product_attributes', 'tbl_product_attributes.fk_product_id = tbl_product_master.id', 'left');
        $this->db->join('tbl_attribute_master', 'tbl_product_attributes.fk_attribute_id = tbl_attribute_master.id', 'left');
        $this->db->join('tbl_attribute_values', 'tbl_product_attributes.fk_attribute_value_id = tbl_attribute_values.id', 'left');
        $this->db->join('tbl_product_types', 'tbl_product_attributes.fk_product_types_id = tbl_product_types.id', 'left');
        $this->db->join('tbl_product_price', 'tbl_product_price.fk_product_id = tbl_product_master.id', 'left');
        $this->db->join('tbl_product_inventory', 'tbl_product_inventory.fk_product_id = tbl_product_master.id', 'left');
        $this->db->where('tbl_product_master.is_delete', '1');
        $this->db->where('tbl_product_inventory.used_status', 1);
        $this->db->order_by('tbl_product_master.id', 'DESC');
        $this->db->group_by('tbl_product_master.id'); // Group by product ID to avoid duplicates
        $query = $this->db->get(); // Execute the query
        return $query->result_array(); // Return the result as an array
    }
    public function get_product_by_id($product_id) {
        $this->db->select('
            p.id AS product_id,
            p.product_name,
            pc.*, pc.fk_flavour_id as flavour_id,
            f.flavour_name,
            pt.*, pt.fk_bottle_size_id as bottle_size_id, pt.fk_bottle_type_id as bottle_type_id, pt.fk_sale_channel_id as sale_channel_id, pt.fk_stock_availability_id as stock_availability_id,
            bs.bottle_size,
            bt.bottle_type,
            sc.sale_channel,
            sa.stock_availability,
            pp.*,
            pi.*,
        ');
        $this->db->from('tbl_product_master p');
        $this->db->join('tbl_product_master_category pc', 'pc.fk_product_id = p.id', 'left');
        $this->db->join('tbl_flavour f', 'pc.fk_flavour_id = f.id', 'left');
        $this->db->join('tbl_product_type pt', 'pt.fk_product_id = p.id', 'left');
        $this->db->join('tbl_bottle_size bs', 'pt.fk_bottle_size_id = bs.id', 'left');
        $this->db->join('tbl_bottle_type bt', 'pt.fk_bottle_type_id = bt.id', 'left');
        $this->db->join('tbl_sale_channel sc', 'pt.fk_sale_channel_id = sc.id', 'left');
        $this->db->join('tbl_stock_availability sa', 'pt.fk_stock_availability_id = sa.id', 'left');        
        $this->db->join('tbl_product_price pp', 'pp.fk_product_id = p.id', 'left');
        $this->db->join('tbl_product_inventory pi', 'pi.fk_product_id = p.id', 'left');

        $this->db->where('p.id', $product_id);
        $this->db->where('p.is_delete', '1'); // Exclude deleted products
        $this->db->where('pi.used_status', '1'); // Exclude used products

        $query = $this->db->get();
        return $query->row_array(); // Return a single product row
    }
}