<?php
class Inventory_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function get_start_of_day_inventory($date = null) {
        // Use current date if no date is provided
        $date = $date ?? date('Y-m-d');
        
        // Define the start of the day (midnight)
        $startOfDay = $date . ' 00:00:00';
    
        // Query to get total inventory quantity before the start of the given date
        $this->db->select("SUM(tbl_product_inventory.total_quantity) as total_inventory");
        $this->db->from("tbl_product_inventory");
        $this->db->where("tbl_product_inventory.created_at < ", $startOfDay);
        $this->db->where("tbl_product_inventory.used_status", 1);
        $this->db->where("tbl_product_inventory.is_delete", '1');
        
        // Execute the query and return the result
        $query = $this->db->get();
        $result = $query->row_array();
    
        // Return the total inventory count at the start of the day
        return $result['total_inventory'] ?? 0;
    }
    public function get_end_of_day_inventory($date = null) {
        // Use current date if no date is provided
        $date = $date ?? date('Y-m-d');
        
        // Define the end of the day (just before midnight)
        $endOfDay = $date . ' 23:59:59';        
        // Query to get total inventory quantity before the end of the given date
        $this->db->select("SUM(tbl_product_inventory.total_quantity) as total_inventory");
        $this->db->from("tbl_product_inventory");
        $this->db->where("tbl_product_inventory.created_at <= ", $endOfDay);
        $this->db->where("tbl_product_inventory.used_status", 1);
        // $this->db->where("tbl_product_inventory.is_delete", '1');
        
        // Execute the query and return the result
        $query = $this->db->get();
        $result = $query->row_array();
        
        // Return the total inventory count at the end of the day
        return $result['total_inventory'] ?? 0;
    }  
    public function get_quantity_on_hand_inventory($date = null) {
		$date = $date ?? date('Y-m-d');
	
		$this->db->select("
			tbl_product_master.product_name,
			tbl_product_master.product_sku_code,
			tbl_sku_code_master.sku_code,
			SUM(tbl_product_inventory.total_quantity) as qty_on_hand, 
			tbl_product_inventory.fk_product_id,			
		");
		$this->db->from("tbl_product_master");
		$this->db->join("tbl_sku_code_master", "tbl_product_master.product_sku_code = tbl_sku_code_master.id", "left");
		$this->db->join("tbl_product_inventory", "tbl_product_inventory.fk_product_id = tbl_product_master.id", "left");
		$this->db->where("tbl_product_inventory.used_status", 1);
		$this->db->where("tbl_product_inventory.is_delete", '1');
		$this->db->group_by("tbl_product_inventory.fk_product_id");
	
		return $this->db->get()->result_array();
	}
	
    // public function get_sold_quantity($product_id = "", $date = null) {
    //     // $date = $date ?? date('Y-m-d');
    
    //     $this->db->select("SUM(tbl_product_inventory.deduct_quantity) as sold_quantity, tbl_sale_channel.sale_channel");
    //     $this->db->from("tbl_product_inventory");
    //     $this->db->join("tbl_sale_channel", "tbl_product_inventory.fk_sale_channel_id = tbl_sale_channel.id", "left");
    //     $this->db->where("tbl_product_inventory.created_at >=", $date . " 00:00:00");
    //     $this->db->where("tbl_product_inventory.created_at <=", $date . " 23:59:59");
    //     $this->db->where("tbl_product_inventory.fk_product_id", $product_id);
    //     // $this->db->where("tbl_product_inventory.used_status", 1);
    //     // $this->db->where("tbl_product_inventory.is_delete", '1');
    //     $this->db->group_by("tbl_product_inventory.fk_sale_channel_id");
    
    //     return $this->db->get()->result_array();
    // }
	public function get_sold_quantity($product_id = "", $date = null) {
		if (!$date) {
			$date = date('Y-m-d');
		}

		$this->db->select("SUM(tbl_product_inventory.deduct_quantity) as sold_quantity, tbl_sale_channel.sale_channel");
		$this->db->from("tbl_product_inventory");
		$this->db->join("tbl_sale_channel", "tbl_product_inventory.fk_sale_channel_id = tbl_sale_channel.id", "left");
		$this->db->where("tbl_product_inventory.created_at >=", $date . " 00:00:00");
		$this->db->where("tbl_product_inventory.created_at <=", $date . " 23:59:59");
		$this->db->where("tbl_product_inventory.fk_product_id", $product_id);
		$this->db->group_by("tbl_product_inventory.fk_sale_channel_id");

		return $this->db->get()->result_array();
	}

    public function get_received_quantity($product_id = "", $date = null) {
        $date = $date ?? date('Y-m-d');
    
        $this->db->select("SUM(tbl_product_inventory.add_quantity) as received_quantity, tbl_sourcing_partner.name");
        $this->db->from("tbl_product_inventory");
        $this->db->join("tbl_sourcing_partner", "tbl_product_inventory.fk_sourcing_partner_id = tbl_sourcing_partner.id", "left");
        $this->db->where("tbl_product_inventory.created_at >=", $date . " 00:00:00");
        $this->db->where("tbl_product_inventory.created_at <=", $date . " 23:59:59");
        $this->db->where("tbl_product_inventory.fk_product_id", $product_id);
        $this->db->group_by("tbl_product_inventory.fk_sourcing_partner_id");
    
        return $this->db->get()->result_array();
    }
    public function get_product_name($product_id = "") {
		$this->db->select("	GROUP_CONCAT(tbl_product_attributes.fk_attribute_value_id) as fk_attribute_value_id,
			GROUP_CONCAT(tbl_attribute_values.attribute_value) as attribute_value,
			GROUP_CONCAT(DISTINCT tbl_product_types.product_type_name) as product_type_name,tbl_product_master.id, ");
		$this->db->from("tbl_product_master");
		$this->db->join("tbl_product_attributes", "tbl_product_attributes.fk_product_id = tbl_product_master.id", "left");
		$this->db->join("tbl_product_types", "tbl_product_master.fk_product_types_id = tbl_product_types.id", "left");
		$this->db->join("tbl_attribute_values", "tbl_product_attributes.fk_attribute_value_id = tbl_attribute_values.id", "left");
		$this->db->where("tbl_product_master.id", $product_id);	
		return $this->db->get()->row_array();
	}

    
    
}
