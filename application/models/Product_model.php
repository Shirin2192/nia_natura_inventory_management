<?php
class Product_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

    public function get_product_detail()
    {
        $this->db->select('tbl_product.product_name,tbl_product.id,tbl_product_category.fk_flavour_id,tbl_flavour.flavour_name,tbl_product_type.fk_bottle_size_id,tbl_bottle_size.bottle_size,tbl_product_price.purchase_price,tbl_product_inventory.total_quantity');
        $this->db->from('tbl_product');
        $this->db->join('tbl_product_category','tbl_product_category.fk_product_id=tbl_product.id','left');
        $this->db->join('tbl_flavour','tbl_product_category.fk_flavour_id=tbl_flavour.id','left');
        $this->db->join('tbl_product_type','tbl_product_type.fk_product_id=tbl_product.id','left');
        $this->db->join('tbl_bottle_size','tbl_product_type.fk_bottle_size_id=tbl_bottle_size.id','left');
        $this->db->join('tbl_product_price','tbl_product_price.fk_product_id=tbl_product.id','left');
        $this->db->join('tbl_product_inventory','tbl_product_inventory.fk_product_id=tbl_product.id','left');
        $this->db->where('tbl_product.is_delete',1);
        $this->db->order_by('tbl_product.id','DESC');
        $query = $this->db->get(); // Execute the query
        return $query->result_array(); // Return the result as an array
    }
    public function get_product_by_id($product_id) {
        $this->db->select('
            p.id AS product_id,
            p.product_name,
            pc.*,
            f.flavour_name,
            pt.*,
            bs.bottle_size,
            bt.bottle_type,
            sc.sale_channel,
            sa.stock_availability,
            pp.*,
            pi.*,
        ');
        $this->db->from('tbl_product p');
        $this->db->join('tbl_product_category pc', 'pc.fk_product_id = p.id', 'left');
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

        $query = $this->db->get();
        return $query->row_array(); // Return a single product row
    }
}