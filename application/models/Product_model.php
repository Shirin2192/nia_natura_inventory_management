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
            GROUP_CONCAT(DISTINCT tbl_product_attributes.fk_product_types_id) as fk_product_types_id,
            GROUP_CONCAT(DISTINCT tbl_product_attributes.fk_attribute_id) as fk_attribute_id,
            GROUP_CONCAT(DISTINCT tbl_product_attributes.fk_attribute_value_id) as fk_attribute_value_id,,
            GROUP_CONCAT(DISTINCT tbl_attribute_master.attribute_name) as attribute_name,
            GROUP_CONCAT(DISTINCT tbl_product_types.product_type_name) as product_type_name,
            GROUP_CONCAT(DISTINCT tbl_attribute_values.attribute_value) as attribute_value,
            tbl_product_price.purchase_price,
            tbl_product_inventory.total_quantity,
           
        ');
        $this->db->from('tbl_product_master');
        $this->db->join('tbl_product_attributes', 'tbl_product_attributes.fk_product_id = tbl_product_master.id', 'left');
        $this->db->join('tbl_attribute_master', 'tbl_product_attributes.fk_attribute_id = tbl_attribute_master.id', 'left');
        $this->db->join('tbl_attribute_values', 'tbl_product_attributes.fk_attribute_value_id = tbl_attribute_values.id', 'left');
        $this->db->join('tbl_product_types', 'tbl_product_attributes.fk_product_types_id = tbl_product_types.id', 'left');
        $this->db->join('tbl_product_price', 'tbl_product_price.fk_product_id = tbl_product_master.id', 'left');
        $this->db->join('tbl_product_inventory', 'tbl_product_inventory.fk_product_id = tbl_product_master.id', 'left');
        $this->db->join('tbl_sku_code_master', 'tbl_product_master.product_sku_code = tbl_sku_code_master.id', 'left');
        $this->db->where('tbl_product_master.is_delete', '1');
        $this->db->where('tbl_product_inventory.used_status', 1);
        $this->db->order_by('tbl_product_master.id', 'DESC');
        $this->db->group_by('tbl_product_master.id');
 // Group by product ID to avoid duplicates
        $query = $this->db->get(); // Execute the query
        return $query->result_array(); // Return the result as an array
    }
    public function get_product_by_id($product_id) {
        $this->db->select('
            tbl_product_master.*,
            tbl_sku_code_master.sku_code,
            GROUP_CONCAT(DISTINCT tbl_product_attributes.fk_product_types_id) as fk_product_types_id,
            GROUP_CONCAT(DISTINCT tbl_product_attributes.fk_attribute_id) as fk_attribute_id,
            GROUP_CONCAT(DISTINCT tbl_product_attributes.fk_attribute_value_id) as fk_attribute_value_id,
            GROUP_CONCAT(DISTINCT tbl_attribute_master.id) as attribute_id,
            GROUP_CONCAT(DISTINCT tbl_attribute_master.attribute_name) as attribute_name,
            GROUP_CONCAT(DISTINCT tbl_product_types.product_type_name) as product_type_name,
            GROUP_CONCAT(DISTINCT tbl_attribute_values.attribute_value) as attribute_value,
            GROUP_CONCAT(DISTINCT tbl_product_price.purchase_price) as purchase_price,
            GROUP_CONCAT(DISTINCT tbl_product_price.MRP) as MRP,
            GROUP_CONCAT(DISTINCT tbl_product_price.selling_price) as selling_price,
            GROUP_CONCAT(DISTINCT tbl_product_inventory.total_quantity ORDER BY tbl_product_inventory.id DESC) as total_quantity,
            GROUP_CONCAT(DISTINCT tbl_product_inventory.id) as inventory_id,
            GROUP_CONCAT(tbl_product_inventory.channel_type) as channel_type,
            GROUP_CONCAT(DISTINCT tbl_product_inventory.fk_sale_channel_id)as fk_sale_channel_id,
            GROUP_CONCAT(DISTINCT tbl_product_batches.batch_no) as batch_no,
            GROUP_CONCAT(DISTINCT tbl_product_batches.expiry_date) as expiry_date,
            GROUP_CONCAT(DISTINCT tbl_product_batches.manufactured_date) as manufactured_date,
            GROUP_CONCAT(DISTINCT tbl_product_batches.id) as batch_id,
            tbl_stock_availability.stock_availability,
            GROUP_CONCAT(tbl_sale_channel.sale_channel) as sale_channel,
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
        $this->db->join('tbl_stock_availability', 'tbl_product_master.fk_stock_availability_id=tbl_stock_availability.id', 'left');
        $this->db->join('tbl_sale_channel', 'tbl_product_inventory.fk_sale_channel_id=tbl_sale_channel.id', 'left');
        $this->db->where('tbl_product_master.id', $product_id);
        $this->db->where('tbl_product_master.is_delete', '1');
        $this->db->where('tbl_product_inventory.used_status', 1);
        $this->db->order_by('tbl_product_master.id', 'DESC');
        $this->db->group_by('tbl_product_master.id'); // Group by product ID to avoid duplicates
        $query = $this->db->get(); // Execute the query
        return $query->row_array(); // Return the result as an array
    }

    public function get_inventory_by_product_and_batch()
    {
        $this->db->select('
            tbl_product_master.id as product_id,
            tbl_product_master.product_name,
            tbl_product_master.product_sku_code,
            tbl_product_batches.batch_no,
            tbl_product_batches.id as batch_id,
            tbl_product_inventory.total_quantity,
            tbl_product_inventory.created_at,
            tbl_sku_code_master.sku_code
        ');
        $this->db->from('tbl_product_master');
        $this->db->join('tbl_product_inventory', 'tbl_product_master.id = tbl_product_inventory.fk_product_id');
        $this->db->join('tbl_product_batches', 'tbl_product_inventory.fk_batch_id = tbl_product_batches.id');
        $this->db->join('tbl_sku_code_master', 'tbl_product_master.product_sku_code = tbl_sku_code_master.id');
        // $this->db->where('tbl_product_inventory.used_status', 1);
        $this->db->order_by('tbl_product_master.product_name ASC, tbl_product_inventory.total_quantity ASC');

        $results = $this->db->get()->result_array();

        // Group the results product-wise
        $grouped = [];
        foreach ($results as $row) {
            $productKey = $row['product_name'] . ' (' . $row['sku_code'] . ')';

            $grouped[$productKey][] = [
                'batch_no' => $row['batch_no'],
                'quantity' => $row['total_quantity'],
                'date' => $row['created_at'],
            ];
        }

        return $grouped;
    }
    // public function get_all_orders()
    // {
    //     $this->db->select('
    //         tbl_product_master.product_name,
    //         tbl_product_master.product_sku_code,
    //         tbl_product_batches.batch_no,
    //         tbl_product_batches.id as batch_id,
    //         tbl_product_inventory.total_quantity,
    //         tbl_product_inventory.created_at,
    //         tbl_product_inventory.channel_type,
    //         tbl_product_inventory.fk_sale_channel_id,
    //         tbl_product_inventory.deduct_quantity,
    //         tbl_sku_code_master.sku_code,
    //         tbl_sale_channel.sale_channel,
    //     ');
    //     $this->db->from('tbl_product_master');
    //     $this->db->join('tbl_product_inventory', 'tbl_product_master.id = tbl_product_inventory.fk_product_id');
    //     $this->db->join('tbl_product_batches', 'tbl_product_inventory.fk_batch_id = tbl_product_batches.id');
    //     $this->db->join('tbl_sku_code_master', 'tbl_product_master.product_sku_code = tbl_sku_code_master.id');
    //     $this->db->join('tbl_sale_channel', 'tbl_product_inventory.fk_sale_channel_id = tbl_sale_channel.id');
    //     $this->db->where('tbl_product_inventory.deduct_quantity IS NOT NULL');
    //     $this->db->order_by('tbl_product_master.product_name ASC, tbl_product_inventory.created_at DESC');

    //     return $this->db->get()->result_array();
    // }

    public function get_orders($start, $length) {
        $this->db->select('
            tbl_product_master.product_name,
            tbl_sku_code_master.sku_code,
            tbl_product_batches.batch_no,
            tbl_product_inventory.channel_type,
            tbl_sale_channel.sale_channel,
            tbl_product_inventory.deduct_quantity,
            tbl_product_inventory.total_quantity,
            tbl_product_inventory.created_at
        ');
        $this->db->from('tbl_product_master');
        $this->db->join('tbl_product_inventory', 'tbl_product_master.id = tbl_product_inventory.fk_product_id');
        $this->db->join('tbl_product_batches', 'tbl_product_inventory.fk_batch_id = tbl_product_batches.id');
        $this->db->join('tbl_sku_code_master', 'tbl_product_master.product_sku_code = tbl_sku_code_master.id');
        $this->db->join('tbl_sale_channel', 'tbl_product_inventory.fk_sale_channel_id = tbl_sale_channel.id');
        $this->db->where('tbl_product_inventory.deduct_quantity IS NOT NULL');
        $this->db->order_by('tbl_product_inventory.id DESC');
        $this->db->limit($length, $start);
    
        return $this->db->get()->result_array();
    }
    

    public function get_total_orders() {
        $this->db->from('tbl_product_inventory');
        $this->db->where('tbl_product_inventory.deduct_quantity IS NOT NULL');
        return $this->db->count_all_results();
    }
    
}
