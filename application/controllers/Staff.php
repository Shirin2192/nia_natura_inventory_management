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
		$this->load->model('user_model'); 
		$this->load->model('Product_attribute_model'); 
		$this->load->model('Role_model'); 
		$this->load->model('model'); 

		$staff_session = $this->session->userdata('staff_session');
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
			$this->load->view('user/dashboard');
		}
	}
	public function add_product_type()
	{
		$staff_session = $this->session->userdata('staff_session');
		if (!$staff_session) {
			redirect(base_url('common/index'));
		} else {
			$data['permissions'] = $this->permissions; // Pass full permissions array
			$data['current_sidebar_id'] = 3; // Set the sidebar ID for the current view
			$this->load->view('add_product_type',$data);
		}
	}
	public function fetch_product_type()
	{
		$response = $this->model->selectWhereData('tbl_product_types', array('is_delete' => 1), "*", false, array('id', "DESC"));
		$data['permissions'] = $this->permissions; // Pass full permissions array
		$data['current_sidebar_id'] = 3; // Set the sidebar ID for the current view
		// echo json_encode('response'=>$response, 'data'=>$data);
		echo json_encode(['response' => $response, 'data' => $data]);
	}
	public function get_product_types_details()
	{
		$id = $this->input->post('id'); // Retrieve flavour ID from POST request		
		if (!$id) {
			echo json_encode(["status" => "error", "message" => "Invalid request"]);
			return;
		}
		$product_types = $this->model->selectWhereData('tbl_product_types', array('id' => $id, 'is_delete' => 1));
		if ($product_types) {
			echo json_encode(["status" => "success", "product_type" => $product_types]);
		} else {
			echo json_encode(["status" => "error", "message" => "Flavour not found"]);
		}
	}
	public function add_product_attributes(){
		$staff_session = $this->session->userdata('staff_session');
		if (!$staff_session) {
			redirect(base_url('common/index')); // Redirect to login page if session is not active
		} else {
			$response['product_types'] = $this->model->selectWhereData('tbl_product_types', array('is_delete' => 1), "*", false, array('id', "DESC"));
			$response['permissions'] = $this->permissions; // Pass full permissions array
			$response['current_sidebar_id'] = 4; // Set the sidebar ID for the current view
			$this->load->view('add_product_attributes',$response);
		}
		
	}
	public function get_product_attribute_detail()
	{
		$response['data'] = $this->Product_attribute_model->get_product_attribute_detail(); // Correctly access the model
		$response['permissions'] = $this->permissions; // Pass full permissions array
		$response['current_sidebar_id'] = 4; // Set the sidebar ID for the current view
		echo json_encode($response);
	}
	public function get_product_attribute_detail_id()
	{
		$id = $this->input->post('id'); 	
		$product_attributes = $this->Product_attribute_model->get_product_attribute_detail_id($id);
		if ($product_attributes) {
			echo json_encode(["status" => "success", "data" => $product_attributes]);
		} else {
			echo json_encode(["status" => "error", "message" => "Product Attribute not found"]);
		}
	}
	public function add_product_attributes_value(){
		$staff_session = $this->session->userdata('staff_session');
		if (!$staff_session) {
			redirect(base_url('common/index')); // Redirect to login page if session is not active
		} else {
			$response['product_attributes'] = $this->model->selectWhereData('tbl_attribute_master', array('is_delete' => 1), "*", false, array('id', "DESC"));
			$response['permissions'] = $this->permissions; // Pass full permissions array
			$response['current_sidebar_id'] = 5; // Set the sidebar ID for the current view
			$this->load->view('add_product_attributes_value',$response);
		}
	}
	public function get_product_attributes_value_detail()
	{
		$response['data'] = $this->Product_attribute_model->get_product_attributes_value_detail(); // Correctly access the model
		$response['permissions'] = $this->permissions; // Pass full permissions array
		$response['current_sidebar_id'] = 5; // Set the sidebar ID for the current view
		echo json_encode($response);
	}
	public function get_product_attributes_value_detail_id()
	{
		$id = $this->input->post('id'); 	
		$product_attributes_values = $this->Product_attribute_model->get_product_attributes_value_detail_id($id);
		if ($product_attributes_values) {
			echo json_encode(["status" => "success", "data" => $product_attributes_values]);
		} else {
			echo json_encode(["status" => "error", "message" => "Product Attribute Value not found"]);
		}
	}
	public function add_sale_channel()
	{
		$staff_session = $this->session->userdata('staff_session');
		if (!$staff_session) {
			redirect(base_url('common/index'));
		} else {
			$response['permissions'] = $this->permissions; // Pass full permissions array
			$response['current_sidebar_id'] = 6; // Set the sidebar ID for the current view
			$this->load->view('add_sales_channel',$response);
		}
	}
	public function fetch_sale_channel()
	{
		$response = $this->model->selectWhereData('tbl_sale_channel', array('is_delete' => 1), "*", false, array('id', "DESC"));
		$data['permissions'] = $this->permissions; // Pass full permissions array
		$data['current_sidebar_id'] = 6; // Set the sidebar ID for the current view
		echo json_encode(['response' => $response, 'data' => $data]);
	}
	public function get_sale_channel_details()
	{
		$id = $this->input->post('id'); // Retrieve Bottle SIze ID from POST request
		if (!$id) {
			echo json_encode(["status" => "error", "message" => "Invalid request"]);
			return;
		}
		$sale_channel = $this->model->selectWhereData('tbl_sale_channel', array('id' => $id, 'is_delete' => 1));
		if ($sale_channel) {
			echo json_encode(["status" => "success", "sale_channel" => $sale_channel]);
		} else {
			echo json_encode(["status" => "error", "message" => "Sale Channel not found"]);
		}
	}
	public function add_product()
	{
		$staff_session = $this->session->userdata('staff_session');
		if (!$staff_session) {
			redirect(base_url('common/index'));
		} else {
			$response['product_types'] = $this->model->selectWhereData('tbl_product_types', array('is_delete' => 1), "*", false, array('id', "DESC"));
			$response['stock_availability'] = $this->model->selectWhereData('tbl_stock_availability', array('is_delete' => 1), "*", false, array('id', "DESC"));
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
	public function view_product()
	{
		$id = $this->input->post('product_id');
		$data['product'] = $this->Product_model->get_product_by_id($id);
		$channel_type = $data['product']['channel_type'];
		$sale_channel = $this->model->selectWhereData('tbl_sale_channel', array('channel_type'=>$channel_type,'is_delete' => 1), "*", false, array('id', "DESC"));
		$data['sale_channel'] = $sale_channel;
		echo json_encode($data);
	}


}