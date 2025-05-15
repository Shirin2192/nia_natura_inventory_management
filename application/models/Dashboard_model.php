<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
        // Get Total Product Count
    public function getTotalProducts() {
        $this->db->select('COUNT(*) AS product_count');
        $this->db->from('tbl_product_master');
        $query = $this->db->get();
        return $query->row_array(); // Return as associative array
    }

    // Fetch Stock Levels by Product
     // Fetch Stock Levels by Product
     public function fetch_stock_levels() {
        $this->db->select('p.product_name,scm.sku_code, SUM(b.total_quantity) AS total_quantity');
        $this->db->from('tbl_product_inventory b');
        $this->db->join('tbl_product_master p', 'b.fk_product_id = p.id','left');
        $this->db->join('tbl_sku_code_master scm', 'p.product_sku_code = scm.id','left');
        $this->db->where('b.used_status',1);
        $this->db->group_by('p.id');
        $query = $this->db->get();
        return $query->result_array(); // Return as array of rows
    }

    // Get Count of Near Expiry Batches
    public function getProductBatchExpirySummary($days = 30) {
        $today = date('Y-m-d');
        $futureDate = date('Y-m-d', strtotime("+$days days"));
    
        // Near Expiry batches
        $this->db->select('p.product_name, COUNT(b.id) as near_expiry_count');
        $this->db->from('tbl_product_batches b');
        $this->db->join('tbl_product_master p', 'b.fk_product_id = p.id', 'left');
        $this->db->where('b.expiry_date <=', $futureDate);
        $this->db->where('b.expiry_date >=', $today);
        $this->db->group_by('p.product_name');
        $nearExpiry = $this->db->get()->result_array();
    
        // Healthy batches
        $this->db->select('p.product_name, COUNT(b.id) as healthy_count');
        $this->db->from('tbl_product_batches b');
        $this->db->join('tbl_product_master p', 'b.fk_product_id = p.id', 'left');
        $this->db->where('b.expiry_date >', $futureDate);
        $this->db->group_by('p.product_name');
        $healthy = $this->db->get()->result_array();
    
        return [
            'near_expiry' => $nearExpiry,
            'healthy' => $healthy
        ];
    }
    // Get Top 5 Products by Quantity
    public function getTop5Products() {
        $this->db->select('p.product_name, SUM(i.deduct_quantity) AS total_quantity');
        $this->db->from('tbl_product_inventory i');
        $this->db->join('tbl_product_master p', 'i.fk_product_id = p.id', 'inner');
        $this->db->where('i.is_delete', '0');  // Exclude deleted records
        $this->db->group_by('i.fk_product_id');
        $this->db->order_by('total_quantity', 'DESC');
        $this->db->limit(5);
        
        $query = $this->db->get();
        return $query->result();
    }
    
    // Get Out of Stock Trends (Weekly or Monthly)
    public function getOutOfStockTrends() {
        // Example SQL Query to track out-of-stock events
        $this->db->select('DATE_FORMAT(created_at, "%Y-%m-%d") AS period_label, COUNT(*) AS out_of_stock_count');
        $this->db->from('tbl_product_inventory');
        $this->db->where('total_quantity', 0);
        $this->db->group_by('period_label');
        $this->db->order_by('period_label');
        $query = $this->db->get();
        return $query->result_array(); // Return as array of rows
    }

}
?>
