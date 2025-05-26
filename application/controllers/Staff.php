<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *"); // or use a specific domain instead of '*'
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

class Staff extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		// Prevent browser caching for all admin pages
		$this->output
			->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0")
			->set_header("Cache-Control: post-check=0, pre-check=0", false)
			->set_header("Pragma: no-cache");

		$this->load->model('Product_model');
		$this->load->model('Product_attribute_model');
		$this->load->model('model');
		$this->load->library('form_validation');

		$staff_session = $this->session->userdata('staff_session'); // Check if admin session exists
		$role_id = $staff_session['role_id'] ?? null;
		if ($role_id) {
			$role_permission = $this->Role_model->get_role_permission($role_id);

			foreach ($role_permission as $role_permission_row) {
				$sidebar_id = $role_permission_row['fk_sidebar_id'];

				$this->permissions[$sidebar_id] = [
					'can_view' => $role_permission_row['can_view'] ?? 0,
					'can_add' => $role_permission_row['can_add'] ?? 0,
					'can_edit' => $role_permission_row['can_edit'] ?? 0,
					'can_delete' => $role_permission_row['can_delete'] ?? 0,
					'has_access' => $role_permission_row['has_access'] ?? 0
				];
			}
		}
		$this->controller_name = $this->router->fetch_class();
		$this->load->vars(['controller_name' => $this->controller_name]);
	}
	public function index()
	{
		$staff_session = $this->session->userdata('staff_session'); // Check if admin session exists
		if (!$staff_session) {
			redirect(base_url('common/index')); 
		} else {
			$this->load->model('Dashboard_model');
			$response['total_product_count'] = $this->model->selectWhereData('tbl_product_master', array('is_delete' => 1), "COUNT(id) as product_count", true); // Get total product count
			$response['total_order_count'] = $this->model->selectWhereData(
				'tbl_product_inventory',
				array('deduct_quantity !=' => NULL),
				"COUNT(deduct_quantity) as order_count",
				true, // fetch single row
				array(),
				array() // no group by
			);
			// Total Stock
			$response['total_stock'] = $this->model->selectWhereData(
				'tbl_product_inventory',
				array('used_status' => 1, 'is_delete' => '1'),
				"SUM(total_quantity) as stock",
				true
			);

			// 2. Stock Levels
			$stock_data = $this->Dashboard_model->fetch_stock_levels();
			$stock_product_names = array_map(function($item) {
				return $item['product_name'];
			}, $stock_data);

			$stock_quantities = array_column($stock_data, 'total_quantity');

			$response['stock_product_names'] = $stock_product_names;
			$response['stock_quantities'] = $stock_quantities;

			// 4. Top 5 Products
			$top5 = $this->Dashboard_model->getTop5Products();
			$response['top5_product_names'] = array_column($top5, 'product_name');
			$response['top5_quantities'] = array_column($top5, 'total_quantity');

			// 5. Out of Stock Trends
			$trend = $this->Dashboard_model->getOutOfStockTrends();
			$response['trend_weeks_or_months'] = array_column($trend, 'period_label'); // Week1, Week2...
			$response['out_of_stock_counts'] = array_column($trend, 'out_of_stock_count');
			$this->load->view('user/dashboard',$response);
		}
	}
	public function add_product()
	{
		$staff_session = $this->session->userdata('staff_session'); // Check if admin session exists
		if (!$staff_session) {
			redirect(base_url('common/index'));
		} else {
			// $response['product_types'] = $this->model->selectWhereData('tbl_product_types', array('is_delete' => 1), "*", false, array('id', "DESC"));
			// $response['stock_availability'] = $this->model->selectWhereData('tbl_stock_availability', array('is_delete' => 1), "*", false, array('id', "DESC"));
			// $response['product_sku_code'] = $this->model->selectWhereData('tbl_sku_code_master', array('is_delete' => 1), "*", false, array('id', "DESC"));
			$response['permissions'] = $this->permissions; // Pass full permissions array
			$response['current_sidebar_id'] = 7; // Set the sidebar ID for the current view

			$this->load->view('product', $response);
		}
	}
	public function fetch_product_details()
	{
		$products = $this->Product_model->get_product_detail(); // Fetch product details
		$structuredData = [];

		foreach ($products as $product) {
			$attributes = explode(',', $product['attribute_name']);
			$values = explode(',', $product['attribute_value']);
			$types = explode(',', $product['product_type_name']);

			$productDetails = [
				'id' => $product['id'],
				'product_name' => $product['product_name'],
				'sku_code' => $product['sku_code'],
				'user_name' => $product['user_name'] ?? 'Unknown',
				'purchase_price' => $product['purchase_price'],
				'total_quantity' => $product['total_quantity'],
				'product_types' => array_unique($types),
				'attributes' => []
			];

			foreach ($attributes as $index => $attribute) {
				$productDetails['attributes'][] = [
					'name' => $attribute,
					'value' => $values[$index] ?? ''
				];
			}
			$structuredData[] = $productDetails;
		}
		echo json_encode(['data' => $structuredData, 'permissions' => $this->permissions, 'current_sidebar_id' => 7]); // Send JSON response
	}
	public function order_details()
	{
		$staff_session = $this->session->userdata('staff_session'); // Check if admin session exists
		if (!$staff_session) {
			redirect(base_url('common/index'));
		} else {
			$data['sku_code'] = $this->model->selectWhereData('tbl_sku_code_master', array('is_delete' => 1), "id,sku_code", false, array('id', "DESC"));
			$data['permissions'] = $this->permissions; // Pass full permissions array
			$data['current_sidebar_id'] = 8; // Set the sidebar ID for the current view
			$inventory_entry_type = $this->model->selectWhereData('tbl_inventory_entry_type', array('is_delete' => '1'), array('id','name'), false);
			$data['inventory_type'] = array_slice($inventory_entry_type, 2, 5);
			$this->load->view('order_details', $data);
		}
	}
	private function get_orders_common($type = 'sale')
	{
		$start = $this->input->post('start') ?? 0;
		$length = $this->input->post('length') ?? 10;
		$draw = intval($this->input->post('draw')) ?? 1;

		if ($type == 'sale') {
			$orders = $this->Product_model->get_orders($start, $length);
			$totalRecords = $this->Product_model->get_total_orders();
		} elseif ($type == 'return') {
			$orders = $this->Product_model->get_all_return_orders($start, $length);
			$totalRecords = $this->Product_model->get_return_total_orders();
		}elseif ($type == 'damage') {
			$orders = $this->Product_model->get_all_damage_orders($start, $length);
			$totalRecords = $this->Product_model->get_damage_total_orders();
		} else {
			$orders = [];
			$totalRecords = 0;
		}

		echo json_encode([
			"draw" => $draw,
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $totalRecords,
			"data" => $orders
		]);
	}

	public function get_all_orders()
	{
		$sss =  $this->get_orders_common('sale');
	}

	public function get_all_return_orders()
	{
		$this->get_orders_common('return');
	}
	public function get_all_damage_orders()
	{
		$this->get_orders_common('damage');
	}
	public function inventory_details()
	{
		$staff_session = $this->session->userdata('staff_session'); // Check if admin session exists
		if (!$staff_session) {
			redirect(base_url('common/index')); // Redirect to login page if session is not active
		} else {
			$response['permissions'] = $this->permissions; // Pass full permissions array
			$response['current_sidebar_id'] = 10; // Set the sidebar ID for the current view
			$this->load->view('inventory_details', $response);
		}
	}

	public function get_inventory_by_product_and_batch()
	{
		$this->load->model('Product_model');
		$data = $this->Product_model->get_inventory_by_product_and_batch();
		if (!empty($data)) {
			echo json_encode([
				'status' => 'success',
				'data' => $data
			]);
		} else {
			echo json_encode([
				'status' => 'error',
				'message' => 'No inventory data found.'
			]);
		}
	}	
}
// /usr/local/bin/php /home/fsrqglou/public_html/web/nia_inv_mgmt/index.php admin generate_inventory_report