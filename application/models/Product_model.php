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
        tbl_user.name as user_name,
        GROUP_CONCAT(DISTINCT tbl_product_attributes.fk_product_types_id) as fk_product_types_id,
        GROUP_CONCAT(DISTINCT tbl_product_attributes.fk_attribute_id) as fk_attribute_id,
        GROUP_CONCAT(DISTINCT tbl_product_attributes.fk_attribute_value_id) as fk_attribute_value_id,
        GROUP_CONCAT(DISTINCT tbl_attribute_master.attribute_name) as attribute_name,
        GROUP_CONCAT(DISTINCT tbl_product_types.product_type_name) as product_type_name,
        GROUP_CONCAT(DISTINCT tbl_attribute_values.attribute_value) as attribute_value,
        tbl_product_price.purchase_price,
        IFNULL(product_inventory_sum.total_quantity, 0) as total_quantity
    ');

    $this->db->from('tbl_product_master');

    // ✅ Essential joins
    $this->db->join('tbl_product_attributes', 'tbl_product_attributes.fk_product_id = tbl_product_master.id', 'left');
    $this->db->join('tbl_attribute_master', 'tbl_product_attributes.fk_attribute_id = tbl_attribute_master.id', 'left');
    $this->db->join('tbl_attribute_values', 'tbl_product_attributes.fk_attribute_value_id = tbl_attribute_values.id', 'left');
    $this->db->join('tbl_product_types', 'tbl_product_attributes.fk_product_types_id = tbl_product_types.id', 'left');
    $this->db->join('tbl_product_price', 'tbl_product_price.fk_product_id = tbl_product_master.id', 'left');
    $this->db->join('tbl_sku_code_master', 'tbl_product_master.product_sku_code = tbl_sku_code_master.id', 'left');

    // ✅ Fix broken user join
    $this->db->join('tbl_product_inventory', 'tbl_product_inventory.fk_product_id = tbl_product_master.id', 'left');
    $this->db->join('tbl_user', 'tbl_product_inventory.fk_login_id = tbl_user.id', 'left');

    // ✅ Subquery join for inventory sum
    $this->db->join('(SELECT fk_product_id, SUM(total_quantity) AS total_quantity
                     FROM tbl_product_inventory
                     WHERE used_status = 1 AND is_delete = 1
                     GROUP BY fk_product_id) as product_inventory_sum',
                     'product_inventory_sum.fk_product_id = tbl_product_master.id', 'left');

    $this->db->where('tbl_product_master.is_delete', '1');
    $this->db->where('tbl_product_price.is_delete', 1);

    $this->db->group_by('tbl_product_master.id');
    $this->db->order_by('tbl_product_master.id', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
}

    // public function get_product_detail()
    // {
    //     $this->db->select('
    //         tbl_product_master.*,
    //         tbl_sku_code_master.sku_code,
    //         MAX(IFNULL(inv_user.name, "Unknown")) AS user_name,
    //         GROUP_CONCAT(DISTINCT tbl_product_attributes.fk_product_types_id) AS fk_product_types_id,
    //         GROUP_CONCAT(DISTINCT tbl_product_attributes.fk_attribute_id) AS fk_attribute_id,
    //         GROUP_CONCAT(DISTINCT tbl_product_attributes.fk_attribute_value_id) AS fk_attribute_value_id,
    //         GROUP_CONCAT(DISTINCT tbl_attribute_master.attribute_name) AS attribute_name,
    //         GROUP_CONCAT(DISTINCT tbl_product_types.product_type_name) AS product_type_name,
    //         GROUP_CONCAT(DISTINCT tbl_attribute_values.attribute_value) AS attribute_value,
    //         MAX(tbl_product_price.purchase_price) AS purchase_price,
    //         IFNULL(MAX(product_inventory_sum.total_quantity), 0) AS total_quantity
    //     ');    
    //     $this->db->from('tbl_product_master');
    //     // Joins
    //     $this->db->join('tbl_product_attributes', 'tbl_product_attributes.fk_product_id = tbl_product_master.id', 'left');
    //     $this->db->join('tbl_attribute_master', 'tbl_product_attributes.fk_attribute_id = tbl_attribute_master.id', 'left');
    //     $this->db->join('tbl_attribute_values', 'tbl_product_attributes.fk_attribute_value_id = tbl_attribute_values.id', 'left');
    //     $this->db->join('tbl_product_types', 'tbl_product_attributes.fk_product_types_id = tbl_product_types.id', 'left');
    //     $this->db->join('tbl_product_price', 'tbl_product_price.fk_product_id = tbl_product_master.id', 'left');
    //     $this->db->join('tbl_sku_code_master', 'tbl_product_master.product_sku_code = tbl_sku_code_master.id', 'left');
    //     // Latest inventory join
    //     $this->db->join('(
    //         SELECT pi.fk_product_id, pi.fk_login_id
    //         FROM tbl_product_inventory pi
    //         JOIN (
    //             SELECT fk_product_id, MAX(id) AS max_id
    //             FROM tbl_product_inventory
    //             WHERE is_delete = 1
    //             GROUP BY fk_product_id
    //         ) latest ON pi.fk_product_id = latest.fk_product_id AND pi.id = latest.max_id
    //     ) latest_inv', 'latest_inv.fk_product_id = tbl_product_master.id', 'left');
    //     $this->db->join('tbl_user AS inv_user', 'inv_user.id = latest_inv.fk_login_id', 'left');
    //     // Inventory SUM
    //     $this->db->join('(
    //         SELECT fk_product_id, SUM(total_quantity) AS total_quantity
    //         FROM tbl_product_inventory
    //         WHERE used_status = 1 AND is_delete = 1
    //         GROUP BY fk_product_id
    //     ) AS product_inventory_sum', 'product_inventory_sum.fk_product_id = tbl_product_master.id', 'left');
    //     // Filters
    //     $this->db->where('tbl_product_master.is_delete', 1);
    //     $this->db->where('tbl_product_price.is_delete', 1);
    //     // Grouping
    //     $this->db->group_by('tbl_product_master.id');
    //     $this->db->order_by('tbl_product_master.id', 'DESC');

    //     return $this->db->get()->result_array();
    // }
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
            GROUP_CONCAT(tbl_product_price.purchase_price ORDER BY tbl_product_price.fk_batch_id ASC) as purchase_price,
            GROUP_CONCAT(tbl_product_price.MRP ORDER BY tbl_product_price.fk_batch_id ASC) as MRP,
            GROUP_CONCAT(tbl_product_price.selling_price ORDER BY tbl_product_price.fk_batch_id ASC) as selling_price,
            GROUP_CONCAT(DISTINCT tbl_product_price.id ORDER BY tbl_product_price.fk_batch_id ASC) as product_price_id,            
            GROUP_CONCAT(tbl_product_inventory.total_quantity ORDER BY tbl_product_inventory.fk_batch_id ASC) as total_quantity,
            GROUP_CONCAT(DISTINCT tbl_product_inventory.reason ORDER BY tbl_product_inventory.fk_batch_id ASC) as reason,
            GROUP_CONCAT(DISTINCT tbl_product_inventory.id ORDER BY tbl_product_inventory.fk_batch_id ASC) as inventory_id,
            GROUP_CONCAT(tbl_product_inventory.fk_sale_channel_id ORDER BY tbl_product_inventory.fk_batch_id ASC) as fk_sale_channel_id,
            GROUP_CONCAT(tbl_product_inventory.fk_sourcing_partner_id ORDER BY tbl_product_inventory.fk_batch_id ASC) as fk_sourcing_partner_id,
            GROUP_CONCAT(DISTINCT tbl_product_batches.batch_no ORDER BY tbl_product_batches.id ASC) as batch_no,
            GROUP_CONCAT(tbl_product_batches.expiry_date ORDER BY tbl_product_batches.id ASC) as expiry_date,
            GROUP_CONCAT(tbl_product_batches.manufactured_date ORDER BY tbl_product_batches.id ASC) as manufactured_date,
            GROUP_CONCAT(tbl_product_batches.purchase_date ORDER BY tbl_product_batches.id ASC) as purchase_date,
            GROUP_CONCAT(tbl_product_inventory.fk_inventory_entry_type ORDER BY tbl_product_inventory.fk_batch_id ASC) as fk_inventory_entry_type,
            GROUP_CONCAT(DISTINCT tbl_product_batches.id ORDER BY tbl_product_batches.id ASC) as batch_id,
			GROUP_CONCAT(tbl_sourcing_partner.name ORDER BY tbl_sourcing_partner.id ASC) as sourcing_partner_name,
            GROUP_CONCAT(tbl_inventory_entry_type.name ORDER BY tbl_inventory_entry_type.id ASC) as inventory_entry_type_name,
            tbl_stock_availability.stock_availability,            
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
        $this->db->join('tbl_sourcing_partner', 'tbl_product_inventory.fk_sourcing_partner_id=tbl_sourcing_partner.id', 'left');
        $this->db->join('tbl_inventory_entry_type', 'tbl_product_inventory.fk_inventory_entry_type=tbl_inventory_entry_type.id', 'left');
        $this->db->where('tbl_product_master.id', $product_id);
        $this->db->where('tbl_product_inventory.used_status', 1);        
        $this->db->or_where('tbl_product_inventory.total_quantity', 0);
        $this->db->where('tbl_product_master.is_delete', '1');        
        // $this->db->order_by('tbl_product_master.id', 'DESC');
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
        $this->db->where('tbl_product_inventory.fk_inventory_entry_type_sale_id',3);
        $this->db->order_by('tbl_product_inventory.id DESC');
        $this->db->limit($length, $start);
    
        return $this->db->get()->result_array();
    }
    public function get_total_orders() {
        $this->db->from('tbl_product_inventory');
        $this->db->where('tbl_product_inventory.deduct_quantity IS NOT NULL');
        $this->db->where('tbl_product_inventory.fk_inventory_entry_type_sale_id',3);
        return $this->db->count_all_results();
    }
    public function get_all_return_orders($start, $length) {
        $this->db->select('
            tbl_product_master.product_name,
            tbl_sku_code_master.sku_code,
            tbl_product_batches.batch_no,
            tbl_product_inventory.channel_type,
            tbl_sale_channel.sale_channel,
            tbl_product_inventory.add_quantity,
            tbl_product_inventory.total_quantity,
            tbl_product_inventory.created_at
        ');
        $this->db->from('tbl_product_master');
        $this->db->join('tbl_product_inventory', 'tbl_product_master.id = tbl_product_inventory.fk_product_id');
        $this->db->join('tbl_product_batches', 'tbl_product_inventory.fk_batch_id = tbl_product_batches.id');
        $this->db->join('tbl_sku_code_master', 'tbl_product_master.product_sku_code = tbl_sku_code_master.id');
        $this->db->join('tbl_sale_channel', 'tbl_product_inventory.fk_sale_channel_id = tbl_sale_channel.id');
        $this->db->where('tbl_product_inventory.add_quantity IS NOT NULL');
        $this->db->where('tbl_product_inventory.fk_inventory_entry_type_return_id',4);
        $this->db->order_by('tbl_product_inventory.id DESC');
        $this->db->limit($length, $start);
    
        return $this->db->get()->result_array();
    }  

    public function get_return_total_orders() {
        $this->db->from('tbl_product_inventory');
        $this->db->where('tbl_product_inventory.add_quantity IS NOT NULL');
        $this->db->where('tbl_product_inventory.fk_inventory_entry_type_return_id',4);
        return $this->db->count_all_results();
    }

    public function get_all_damage_orders($start, $length) {
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
        $this->db->where('tbl_product_inventory.fk_inventory_entry_type_damage_id',5);
        $this->db->order_by('tbl_product_inventory.id DESC');
        $this->db->limit($length, $start);
    
        return $this->db->get()->result_array();
    }

    public function get_damage_total_orders() {
        $this->db->from('tbl_product_inventory');
        $this->db->where('tbl_product_inventory.deduct_quantity IS NOT NULL');
        $this->db->where('tbl_product_inventory.fk_inventory_entry_type_damage_id',5);
        return $this->db->count_all_results();
    }
    public function get_total_sold_quantity($product_id, $batch_id) {
    return $this->db->select_sum('deduct_quantity')
        ->from('tbl_product_inventory')
        ->where([
            'fk_product_id' => $product_id,
            'fk_batch_id' => $batch_id,
            'fk_inventory_entry_type_sale_id' => 3
        ])->get()->row()->deduct_quantity ?? 0;
}

public function get_total_returned_quantity($product_id, $batch_id) {
    return $this->db->select_sum('add_quantity')
        ->from('tbl_product_inventory')
        ->where([
            'fk_product_id' => $product_id,
            'fk_batch_id' => $batch_id,
            'fk_inventory_entry_type_return_id' => 4
        ])->get()->row()->add_quantity ?? 0;
}

public function get_total_damaged_quantity($product_id, $batch_id) {
    return $this->db->select_sum('deduct_quantity')
        ->from('tbl_product_inventory')
        ->where([
            'fk_product_id' => $product_id,
            'fk_batch_id' => $batch_id,
            'fk_inventory_entry_type_damage_id' => 5
        ])->get()->row()->deduct_quantity ?? 0;
}


}
