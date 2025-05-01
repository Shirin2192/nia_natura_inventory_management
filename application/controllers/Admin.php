<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *"); // or use a specific domain instead of '*'
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Ensure these use statements are at the top of the file, outside any class or function
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Prevent browser caching for all admin pages
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0")
			->set_header("Cache-Control: post-check=0, pre-check=0", false)
			->set_header("Pragma: no-cache");
		$this->load->model('Product_model');
		$this->load->model('user_model');
		$this->load->model('Product_attribute_model');
		$this->load->model('Role_model');
		$this->load->model('model');
		$this->load->library('form_validation');

		$admin_session = $this->session->userdata('admin_session');
		$role_id = $admin_session['role_id'] ?? null;
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
	// Default method for the Admin controller
	public function index()
	{
		$admin_session = $this->session->userdata('admin_session'); // Check if admin session exists			
		if (!$admin_session) {
			redirect(base_url('common/index')); // Redirect to login page if session is not active
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
		    // 			$response['stock_product_names'] = array_column($stock_data, 'product_name');
        	// 	$response['stock_sku_code'] = array_column($stock_data, 'sku_code');
            $response['stock_product_names'] = array_map(function($item) {
                return $item['product_name'] . ' (' . $item['sku_code'] . ')';
            }, $stock_data);
			$response['stock_quantities'] = array_column($stock_data, 'total_quantity');
			// 3. Batch Expiry - Fetch product wise expiry summary
			$batch_expiry = $this->Dashboard_model->getProductBatchExpirySummary(30); // 30 days
			$response['batch_expiry_near'] = $batch_expiry['near_expiry']; // Near Expiry batches
			$response['batch_expiry_healthy'] = $batch_expiry['healthy'];  // Healthy batches
			// 4. Top 5 Products
			$top5 = $this->Dashboard_model->getTop5Products();
			$response['top5_product_names'] = array_column($top5, 'product_name');
			$response['top5_quantities'] = array_column($top5, 'total_quantity');
			// 5. Out of Stock Trends
			$trend = $this->Dashboard_model->getOutOfStockTrends();
			$response['trend_weeks_or_months'] = array_column($trend, 'period_label'); // Week1, Week2...
			$response['out_of_stock_counts'] = array_column($trend, 'out_of_stock_count');
			$this->load->view('admin/dashboard', $response); // Load the admin dashboard view
		}
	}
	public function add_staff()
	{
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		} else {
			$response['role'] = $this->model->selectWhereData('tbl_role', array('is_delete' => 1), "*", false, array('id', "ASC"));
			$response['permissions'] = $this->permissions; // Pass full permissions array
			$response['current_sidebar_id'] = 2; // Set the sidebar ID for the current view
			$this->load->view('add_staff', $response);
		}
	}
	public function save_user()
	{
		$this->load->library('form_validation'); // Load validation library
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$role = $this->input->post('role');
		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];
		// Set validation rules
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|alpha');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[2]|alpha');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[tbl_user.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('role', 'Role', 'required');
		if ($this->form_validation->run() == FALSE) {
			// Validation failed, return error messages
			$response = [
				'status' => 'error',
				'errors' => array(
					'first_name' => form_error('first_name'),
					'last_name' => form_error('last_name'),
					'email' => form_error('email'),
					'password' => form_error('password'),
					'role' => form_error('role'),
				)
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_user', array('email' => $email));
			if ($count == 1) {
				$response = ["status" => "error", 'errors' => ['email' => "Email Already Exists"]];
			} else {
				$add_staff = array(
					'name' => $first_name . " " . $last_name,
					'email' => $email,
					'password' => decy_ency('encrypt', $password), // Encrypt password
					'fk_role_id' => $role,
				);
				$insert_status = $this->model->insertData('tbl_user', $add_staff);
				$this->model->addUserLog($login_id, 'Insert Staff Details', 'tbl_user', $add_staff);
				if ($insert_status) {
					$response = ["status" => "success", "message" => "User added successfully."];
				} else {
					$response = ["status" => "error", "message" => "Failed to add user."];
				}
			}
		}
		echo json_encode($response);
	}
	public function get_users()
	{
		$this->load->model("User_model");
		$draw = $this->input->post("draw");
		$start = $this->input->post("start");
		$length = $this->input->post("length");
		// Fetch total count
		$totalRecords = $this->user_model->get_total_users_count();
		// Fetch paginated data
		$users = $this->user_model->get_paginated_users($start, $length);
		$data = [];
		$response['permissions'] = $this->permissions; // Pass full permissions array
		$response['current_sidebar_id'] = 2; // Set the sidebar ID for the current view
		foreach ($users as $user) {
			$data[] = [
				"id" => $user['id'],
				"name" => $user['name'],
				"email" => $user['email'],
				"role_name" => $user['role_name']
			];
		}
		$response['draw'] = intval($draw);
		$response['recordsTotal'] = $totalRecords;
		$response['recordsFiltered'] = $totalRecords;
		$response['data'] = $data;
		echo json_encode($response);
	}

	public function view_user()
	{
		$user_id = $this->input->post('user_id');
		if (!$user_id) {
			echo json_encode(["status" => false, "message" => "Invalid user ID"]);
			return;
		}
		// Get user data
		$user = $this->user_model->get_user_by_id($user_id);
		if (!$user) {
			echo json_encode(["status" => false, "message" => "User not found"]);
			return;
		}
		$roles = $this->model->selectWhereData('tbl_role', array('is_delete' => 1), "*", false, array('id', "DESC"));
		// Prepare response
		$response = [
			"user" => $user,
			"roles" => $roles
		];
		echo json_encode(["status" => true, "data" => $response]);
	}
	public function update_staff()
	{
		$this->form_validation->set_rules('edit_first_name', 'First Name', 'required|trim');
		$this->form_validation->set_rules('edit_last_name', 'Last Name', 'required|trim');
		$this->form_validation->set_rules('edit_role', 'Role', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(["status" => false, "errors" => $this->form_validation->error_array()]);
		} else {
			$staff_id = $this->input->post('staff_id');
			$first_name = $this->input->post('edit_first_name');
			$last_name = $this->input->post('edit_last_name');
			$admin_session = $this->session->userdata('admin_session');
			$login_id = $admin_session['user_id'];
			$data = [
				'name' => $first_name . " " . $last_name,
				'fk_role_id' => $this->input->post('edit_role'),
			];
			$update_status = $this->model->updateData('tbl_user', $data, ['id' => $staff_id]);
			$this->model->addUserLog($login_id, 'Updated Staff Details', 'tbl_user', $data);
			if ($update_status) {
				echo json_encode(["status" => "success", "message" => "Staff updated successfully."]);
			} else {
				echo json_encode(["status" => false, "message" => "Failed to update staff."]);
			}
		}
	}
	public function add_sale_channel()
	{
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		} else {
			$response['permissions'] = $this->permissions; // Pass full permissions array
			$response['current_sidebar_id'] = 6; // Set the sidebar ID for the current view
			$this->load->view('add_sales_channel', $response);
		}
	}
	public function fetch_sale_channel()
	{
		$response = $this->model->selectWhereData('tbl_sale_channel', array('is_delete' => 1), "*", false, array('id', "DESC"));
		$data['permissions'] = $this->permissions; // Pass full permissions array
		$data['current_sidebar_id'] = 6; // Set the sidebar ID for the current view
		echo json_encode(['response' => $response, 'data' => $data]);
	}

	public function save_sale_channel()
	{	
		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];

		$sale_channel = $this->input->post('sale_channel');
		$channel_type = $this->input->post('channel_type');
		$this->form_validation->set_rules('sale_channel', 'Sale Channel', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
		if ($this->form_validation->run() == FALSE) {
			// Return validation errors as JSON (No page reload)
			$response = [
				'status' => 'error',
				'sale_channel_error' => form_error('sale_channel'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_sale_channel', array('sale_channel' => $sale_channel, 'is_delete' => 1));
			if ($count == 1) {
				$response = ["status" => "error", 'sale_channel_error' => "Sale Channel Already Exist"];
			} else {
				$data = array(
					'channel_type' => $channel_type,
					'sale_channel' => $sale_channel,
				);

				$this->model->insertData('tbl_sale_channel', $data);
				$this->model->addUserLog($login_id, 'Inserted Sales Channel', 'tbl_sale_channel', $data);

				$response = ["status" => "success", "message" => "Sale Channel added successfully"];
			}
		}
		echo json_encode($response); // Return response as JSON
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
	public function update_sale_channel()
	{
		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];
		$sale_channel_id = $this->input->post('edit_sale_channel_id');
		$sale_channel = $this->input->post('edit_sale_channel');
		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];
		$this->form_validation->set_rules('edit_sale_channel', 'Sale Channel', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
		if ($this->form_validation->run() == FALSE) {
			$response = [
				'status' => 'error',
				'edit_sale_channel_error' => form_error('edit_sale_channel'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_sale_channel', array('sale_channel' => $sale_channel, 'id !=' => $sale_channel_id));
			if ($count == 1) {
				$response = ["status" => "error", 'sale_channel_error' => "Bottle Type Already Exist"];
			} else {
				$update_data = ['sale_channel' => $sale_channel];

				$this->model->updateData('tbl_sale_channel', $update_data, ['id' => $sale_channel_id]);
				$this->model->addUserLog($login_id, 'Update Sales Channel', 'tbl_sale_channel', $update_data);

				$response = ["status" => "success", "message" => "Sale Channel updated successfully"];
			}
		}
		echo json_encode($response);
	}
	public function delete_sale_channel()
	{
		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];
		$id = $this->input->post('id'); // Get the flavour ID from AJAX
		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];

		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid flavour ID']);
			return;
		}
		$delete_data = ['is_delete' => '0'];
		$result = $this->model->updateData('tbl_sale_channel',$delete_data , ['id' => $id]); // Soft delete
		$this->model->addUserLog($login_id, 'Delete Sales Channel', 'tbl_sale_channel', $delete_data);		

		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'Sale Channel deleted successfully']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to delete Sale Channel']);
		}
	}
	public function add_role_permission()
	{
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		} else {
			$this->load->view('add_role_permission');
		}
	}
	public function add_product()
	{
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		} else {
			$response['product_types'] = $this->model->selectWhereData('tbl_product_types', array('is_delete' => 1), "*", false, array('id', "DESC"));
			$response['stock_availability'] = $this->model->selectWhereData('tbl_stock_availability', array('is_delete' => 1), "*", false, array('id', "DESC"));
			$response['product_sku_code'] = $this->model->selectWhereData('tbl_sku_code_master', array('is_delete' => 1), "*", false, array('id', "DESC"));
			$response['sourcing_partner'] = $this->model->selectWhereData('tbl_sourcing_partner', array('is_delete' => 1), "*", false, array('id', "DESC"));
			$response['permissions'] = $this->permissions; // Pass full permissions array
			$response['current_sidebar_id'] = 7; // Set the sidebar ID for the current view
			$this->load->view('product', $response);
		}
	}
	public function get_attribute_on_product_types_id()
	{
		$fk_product_types_id = $this->input->post('fk_product_types_id'); // Get the product type ID from POST request
		$response['data'] = $this->model->selectWhereData('tbl_attribute_master', array("fk_product_type_id" => $fk_product_types_id, 'is_delete' => 1), "*", false, array('id', "DESC"));
		echo json_encode($response);
	}
	public function get_attribute_values_on_product_attributes_id()
	{
		$fk_product_attributes_id = $this->input->post('attribute_id'); // Get the product attribute ID from POST request
		$response['data'] = $this->model->selectWhereData('tbl_attribute_values', array("fk_attribute_id" => $fk_product_attributes_id, 'is_delete' => 1), "*", false, array('id', "DESC"));
		echo json_encode($response);
	}
	public function get_sales_channel_on_channel_type()
	{
		$channel_type = $this->input->post('channel_type'); // Get the product attribute ID from POST request
		$response['data'] = $this->model->selectWhereData('tbl_sale_channel', array("channel_type" => $channel_type, 'is_delete' => 1), "*", false, array('id', "DESC"));
		echo json_encode($response);
	}
	public function save_product()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$response = ['status' => 'error', 'errors' => []];

			$admin_session = $this->session->userdata('admin_session');
			$login_id = $admin_session['user_id'];
			// Get input values
			$product_name = $this->input->post('product_name');
			$product_sku_code = $this->input->post('product_sku_code');
			$batch_no = $this->input->post('batch_no');

			$barcode = $this->input->post('barcode');
			$description = $this->input->post('description');
			$purchase_price = $this->input->post('purchase_price');
			$mrp = $this->input->post('mrp');
			$selling_price = $this->input->post('selling_price');
			$add_quantity = $this->input->post('add_quantity');
			$stock_availability = $this->input->post('stock_availability');
			// $sale_channel = $this->input->post('sale_channel');

			$fk_product_attribute_id = $this->input->post('fk_product_attribute_id'); // Example: [3, 2, 1]
			$attributes_value = $this->input->post('attributes_value'); // Example: [19, 16, 1]
			$fk_product_types_id = $this->input->post('fk_product_types_id');
			$expiry_date = $this->input->post('expiry_date');
			$manufacture_date = $this->input->post('manufacture_date');
			$reason = $this->input->post('reason');
			$fk_sourcing_partner_id = $this->input->post('fk_sourcing_partner_id');

			// Validation Rules
			$this->form_validation->set_rules('product_name', 'Product Name', 'required|trim');
			$this->form_validation->set_rules('product_sku_code', 'Product SKU Code', 'required|trim');
			$this->form_validation->set_rules('fk_product_types_id', 'Product Type', 'required|trim');
			// $this->form_validation->set_rules('fk_bottle_size_id', 'Bottle Size', 'required|trim');
			// $this->form_validation->set_rules('fk_bottle_type_id', 'Bottle Type', 'required|trim');
			$this->form_validation->set_rules('description', 'Description', 'required|trim');
			$this->form_validation->set_rules('purchase_price', 'Purchase Price', 'required|trim');
			$this->form_validation->set_rules('mrp', 'MRP', 'required|trim');
			$this->form_validation->set_rules('selling_price', 'Selling Price', 'required|trim');
			$this->form_validation->set_rules('add_quantity', 'Stock Quantity', 'required|trim');
			$this->form_validation->set_rules('stock_availability', 'Stock Availability', 'required|trim');
			// $this->form_validation->set_rules('sale_channel', 'Sale Channel', 'required|trim');
			// $this->form_validation->set_rules('channel_type', 'Sale Channel', 'required|trim');
			$this->form_validation->set_rules('expiry_date', 'Expiry date', 'required|trim');
			$this->form_validation->set_rules('manufacture_date', 'Manufacture Date', 'required|trim');
			$this->form_validation->set_rules('reason', 'Reason', 'required|trim');
			$this->form_validation->set_rules('fk_sourcing_partner_id', 'Sourcing Partner', 'required|trim');

			// Check validation
			if ($this->form_validation->run() == FALSE) {
				foreach ($this->input->post() as $key => $value) {
					if (form_error($key)) {
						$response['errors'][$key] = form_error($key);
					}
				}
				echo json_encode($response);
				return;
			}

			// Handle multiple image upload
			$product_images = [];
			if (!empty($_FILES['product_image']['name'][0])) {
				$files = $_FILES;
				$this->load->library('upload');

				$config['upload_path'] = './uploads/products/';
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['max_size'] = 2048;

				foreach ($files['product_image']['name'] as $key => $image) {
					$_FILES['file']['name'] = $files['product_image']['name'][$key];
					$_FILES['file']['type'] = $files['product_image']['type'][$key];
					$_FILES['file']['tmp_name'] = $files['product_image']['tmp_name'][$key];
					$_FILES['file']['error'] = $files['product_image']['error'][$key];
					$_FILES['file']['size'] = $files['product_image']['size'][$key];

					$this->upload->initialize($config);

					if ($this->upload->do_upload('file')) {
						$uploadData = $this->upload->data();
						$product_images[] = $uploadData['file_name'];
					}
				}
			}
			$count = $this->model->CountWhereRecord('tbl_product_master', array('product_name' => $product_name, 'product_sku_code' => $product_sku_code, 'is_delete' => 1));
			if ($count == 1) {
				$response = ["status" => "error", 'product_name_error' => "Already Exist"];
			} else {

				$product_data = [
					'product_name' => $product_name,
					'product_sku_code' => $product_sku_code,
					'fk_stock_availability_id' => $stock_availability,
					'barcode' => $barcode,
					'images' => implode(",", $product_images), // Store multiple images as JSON
					'description' => $description,
					'fk_product_types_id' => $fk_product_types_id,
				];
				//  print_r($product_data);
				$product_insert_id = $this->model->insertData('tbl_product_master', $product_data);

				$product_batch_data = [
					'fk_product_id' => $product_insert_id,
					'batch_no' => $batch_no,
					'expiry_date' => $expiry_date,
					'manufactured_date' => $manufacture_date,
					'quantity' => $add_quantity,
				];
				$product_batch_id = $this->model->insertData('tbl_product_batches', $product_batch_data); // Insert batch data

				foreach ($fk_product_attribute_id as $key => $attribute_id) {
					$product_attribute = [
						'fk_product_id' => $product_insert_id,
						'fk_product_types_id' => $fk_product_types_id,
						'fk_attribute_id' => $attribute_id,
						'fk_attribute_value_id' => $attributes_value[$key],
					];
					$this->model->insertData('tbl_product_attributes', $product_attribute);
				}
				// Insert product price and inventory data				
				$product_price = [
					'fk_product_id' => $product_insert_id,
					'fk_batch_id' => $product_batch_id,
					'purchase_price' => $purchase_price,
					'MRP' => $mrp,
					'selling_price' => $selling_price,
				];
				$this->model->insertData('tbl_product_price', $product_price);
				// print_r($product_price);
				$product_inventory = [
					'fk_product_id' => $product_insert_id,
					'fk_login_id' => $login_id,
					'fk_batch_id' => $product_batch_id,
					'add_quantity' => $add_quantity,
					'total_quantity' => $add_quantity,
					'used_status' => 1,
					// 'channel_type' => $_POST['channel_type'],
					// 'fk_sale_channel_id' => $sale_channel,
					'reason' => $reason,
					'fk_sourcing_partner_id' => $fk_sourcing_partner_id,
				];
				$product_inventory_insert_id = $this->model->insertData('tbl_product_inventory', $product_inventory);

				$CI = &get_instance();

				// Create the dynamic body
				$sku_code = $this->model->selectWhereData('tbl_sku_code_master', array('id' => $product_sku_code), 'sku_code', true);
				$dynamic_body = '
						<h2>Inventory Details!</h2>
						<p>Product: <strong>' . $product_name . '(' . $sku_code['sku_code'] . ')' . '</strong></p>
						<p>Quantity Added: <strong>' . $add_quantity . '</strong></p>
						<p>Batch No: <strong>' . $batch_no . '</strong></p>
					';

				// Load the email template
				$email_message = $this->load->view('email_template', [
					'dynamic_body_content' => $dynamic_body,
					'subject' => 'New Stock Added - ' . $product_name . '(' . $product_sku_code . ')',
				], true);  // true = return as string

				// Now send the email using your helper
				$to_email = "shirin@sda-zone.com"; // Replace with actual receiver
				$subject = 'New Stock Added - ' . $product_name . '(' . $product_sku_code . ')';

				// $send = send_inventory_email($to_email, $subject, $email_message);
			}
			if ($product_inventory_insert_id) {
				echo json_encode(['status' => 'success', 'message' => 'Product added successfully!']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Failed to insert product!']);
			}
		}
	}
	function email_templete()
	{
		$this->load->view('email_template');
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
				
				'total_quantity' => $product['total_quantity'],
				'product_types' => array_unique($types),
				'attributes' => []
			];
// 'purchase_price' => $product['purchase_price'],
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
		$channel_type = explode(",", $data['product']['channel_type']);

		$sale_channel = $this->model->selectWhereData('tbl_sale_channel', array('channel_type' => $channel_type[0], 'is_delete' => 1), "*", false, array('id', "DESC"));
		$data['sale_channel'] = $sale_channel;
		$fk_product_types_id = $data['product']['fk_product_types_id'];
		$product_type_id = explode(',', $fk_product_types_id);
		$data['attribute_master'] = $this->model->selectWhereData('tbl_attribute_master', array("fk_product_type_id" => $product_type_id[0], 'is_delete' => 1), "*", false, array('id', "DESC"));
		$data['sourcing_partner'] = $this->model->selectWhereData('tbl_sourcing_partner', array('is_delete' => 1), "*", false, array('id', "DESC"));
		echo json_encode($data);
	}

	public function update_product()
	{
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		// exit;
		$this->load->library('form_validation');
		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];

		$product_id = $this->input->post('update_product_id');
		$product_name = $this->input->post('update_product_name');
		$description = $this->input->post('update_description');
		$availability_status = $this->input->post('update_availability_status');
		$barcode = $this->input->post('update_barcode');
		$edit_fk_product_attribute_id = $this->input->post('edit_fk_product_attribute_id'); // Example: [3, 2, 1]
		$edit_attributes_value = $this->input->post('edit_attributes_value'); // Example: [19, 16, 1]
		$add_new_fk_product_attribute_id = $this->input->post('add_new_fk_product_attribute_id'); // Example: [3, 2, 1]
		$add_new_attributes_value = $this->input->post('add_new_attributes_value'); // Example: [19, 16, 1]
		$update_fk_product_types_id = $this->input->post('update_fk_product_types_id');
		$product_attribute_id = $this->input->post('attribute_id');
		$inventory_id = $this->input->post('update_inventory_id');
		// $inventory_id = explode(',', $inventory_id1);
		$batch_no = $this->input->post('batch_no');
		$purchase_price =  $this->input->post('update_purchase_price');
		$MRP = $this->input->post('update_mrp');
		$selling_price = $this->input->post('update_selling_price');
		$update_manufacture_date = $this->input->post('update_manufacture_date');
		$update_expiry_date = $this->input->post('update_expiry_date');
		$total_quantity = $this->input->post('update_total_quantity');
		$channel_type = $this->input->post('update_channel_type');
		$sale_channel = $this->input->post('update_sale_channel');
		
		$product_price_id = $this->input->post('product_price_id');
		// $product_price_id = explode(',', $product_price_id1);

		$update_batch_id = $this->input->post('update_batch_id');
		// Handling image upload
		$existing_images = $this->input->post('update_product_image');
		$images = explode(',', $existing_images);
		$update_reason = $this->input->post('update_reason');
		//New Batch POST
		$add_new_batch_no = $this->input->post('add_new_batch_no');
		$add_new_manufacture_date = $this->input->post('add_new_manufacture_date');
		$add_new_expiry_date = $this->input->post('add_new_expiry_date');
		$add_new_purchase_price = $this->input->post('add_new_purchase_price');
		$add_new_mrp = $this->input->post('add_new_mrp');
		$add_new_selling_price = $this->input->post('add_new_selling_price');
		$add_new_quantity = $this->input->post('add_new_quantity');
		$add_new_reason = $this->input->post('add_new_reason');
		$add_new_fk_sourcing_partner_id = $this->input->post('add_new_fk_sourcing_partner_id');
		$update_fk_sourcing_partner_id = $this->input->post('update_fk_sourcing_partner_id');
		

		// Set validation rules
		$this->form_validation->set_rules('update_product_name', 'Product Name', 'required');
		$this->form_validation->set_rules('update_description', 'Description', 'required');
		$this->form_validation->set_rules('update_availability_status', 'Availability Status', 'required');
		$this->form_validation->set_rules('update_reason', 'Reason', 'required');
		$this->form_validation->set_rules('update_fk_product_types_id', 'Product Type', 'required');

		if (!empty($add_new_batch_no)) {
			$this->form_validation->set_rules('add_new_batch_no', 'New Batch No', 'required');
			$this->form_validation->set_rules('add_new_purchase_price', 'Purchase Price', 'required|numeric');
			$this->form_validation->set_rules('add_new_mrp', 'MRP', 'required|numeric');
			$this->form_validation->set_rules('add_new_selling_price', 'Selling Price', 'required|numeric');
			$this->form_validation->set_rules('add_new_quantity', 'Stock Quantity', 'required|numeric');
			$this->form_validation->set_rules('add_new_manufacture_date', 'Manufacture Date', 'required');
			$this->form_validation->set_rules('add_new_expiry_date', 'Expiry Date', 'required');
			$this->form_validation->set_rules('add_new_reason', 'Reason', 'required');
			$this->form_validation->set_rules('add_new_fk_sourcing_partner_id', 'Sourcing Partner', 'required');
		}

		if ($this->form_validation->run() == FALSE) {
			$response = ['status' => 'error', 'errors' => []];
			foreach ($this->input->post() as $key => $value) {
				if (form_error($key)) {
					$response['errors'][$key] = form_error($key);
				}
			}
			echo json_encode($response);
			return;
		}
		if (!empty($_FILES['update_product_images']['name'][0])) {
			$config['upload_path'] = './uploads/products/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = 2048;

			$this->load->library('upload', $config);

			foreach ($_FILES['update_product_images']['name'] as $key => $image) {
				$_FILES['file']['name'] = $_FILES['update_product_images']['name'][$key];
				$_FILES['file']['type'] = $_FILES['update_product_images']['type'][$key];
				$_FILES['file']['tmp_name'] = $_FILES['update_product_images']['tmp_name'][$key];
				$_FILES['file']['error'] = $_FILES['update_product_images']['error'][$key];
				$_FILES['file']['size'] = $_FILES['update_product_images']['size'][$key];

				$this->upload->initialize($config);
				if ($this->upload->do_upload('file')) {
					$images[] = $this->upload->data('file_name');
				}
			}
		}

		if (!empty($images)) {
			$imagess = implode(',', $images);
		}

		$update_product = array(
			'product_name' => $product_name,
			'description' => $description,
			'fk_product_types_id' => $update_fk_product_types_id,
			'fk_stock_availability_id' => $availability_status,
			'barcode' => $barcode,
			'images' => $imagess,
		);
		$this->model->updateData('tbl_product_master', $update_product, ['id' => $product_id]);
		$this->model->addUserLog($login_id, 'Update Product Master', 'tbl_product_master', $update_product);

		if(!empty($update_batch_id)){
			foreach ($update_batch_id as $update_batch_id_key => $update_batch_id_row) {
				$update_product_batch = array(
					'expiry_date' => $update_expiry_date[$update_batch_id_key],
					'manufactured_date' => $update_manufacture_date[$update_batch_id_key],					
				);
				$this->model->updateData('tbl_product_batches', $update_product_batch, ['id' => $update_batch_id_row, 'fk_product_id' => $product_id]);
			}

			foreach ($purchase_price as $purchase_price_key => $purchase_price_row) {

				$update_product_price = array(
					'purchase_price' => $purchase_price_row,
					'MRP' => $MRP[$purchase_price_key],
					'selling_price' => $selling_price[$purchase_price_key],
				);
				$this->model->updateData('tbl_product_price', $update_product_price, ['fk_product_id' => $product_id, 'fk_batch_id' => $update_batch_id[$purchase_price_key]]);
			}
		}	
		if (!empty($add_new_fk_product_attribute_id)) {
			foreach ($add_new_fk_product_attribute_id as $key => $add_attribute_id_row) {
				$product_attribute = [
					'fk_product_id' => $product_id,
					'fk_product_types_id' => $update_fk_product_types_id,
					'fk_attribute_id' => $add_attribute_id_row,
					'fk_attribute_value_id' => $add_new_attributes_value[$key],
				];
				$this->model->insertData('tbl_product_attributes', $product_attribute);
			}
		}
		if (!empty($edit_fk_product_attribute_id[0])) {
			foreach ($edit_fk_product_attribute_id as $edit_fk_product_attribute_id_key => $edit_fk_product_attribute_id_row) {
				$update_product_attribute = [
					'fk_attribute_id' => $edit_fk_product_attribute_id_row,
					'fk_attribute_value_id' => $edit_attributes_value[$edit_fk_product_attribute_id_key],
				];
				$this->model->updateData('tbl_product_attributes', $update_product_attribute, ['id' => $product_attribute_id[$edit_fk_product_attribute_id_key], 'fk_product_id' => $product_id, 'fk_product_types_id' => $update_fk_product_types_id]);
			}
		}		
		if (!empty($add_new_quantity)) {
			// $update_product_inventory_status = array(
			// 	'used_status' => 0,
			// 	'is_delete' => '0'
			// );
			// $this->model->updateData('tbl_product_inventory', $update_product_inventory_status, ['fk_product_id' => $product_id]);

			// $new_total_quantity = $total_quantity + $add_new_quantity;
			$add_new_batch_wise_quantity = array(
				'fk_product_id' => $product_id,
				'batch_no' => $add_new_batch_no,
				'quantity' => $add_new_quantity,
				'manufactured_date' => $add_new_manufacture_date,
				'expiry_date' => $add_new_expiry_date
			);
			$new_batch_inserted_id = $this->model->insertData('tbl_product_batches', $add_new_batch_wise_quantity);
			$this->model->addUserLog($login_id, 'Inserted New Batch', 'tbl_product_batches', $add_new_batch_wise_quantity);

			$new_batch_wise_product_price = array(
				'fk_product_id' => $product_id,
				'fk_batch_id' => $new_batch_inserted_id,
				'purchase_price' => $add_new_purchase_price,
				'MRP' => $add_new_mrp,
				'selling_price' => $add_new_selling_price
			);
			$this->model->insertData('tbl_product_price', $new_batch_wise_product_price);
			$this->model->addUserLog($login_id, 'Inserted New Batch Product Price', 'tbl_product_price', $new_batch_wise_product_price);

			$add_new_product_inventory = array(
				'fk_product_id' => $product_id,
				'fk_login_id' => $login_id,
				'fk_batch_id' => $new_batch_inserted_id,
				'add_quantity' => $add_new_quantity,
				'total_quantity' => $add_new_quantity,
				// 'channel_type' => $channel_type,
				// 'fk_sale_channel_id' => $sale_channel,
				'reason' => $add_new_reason,
				'used_status' => 1,
				'fk_sourcing_partner_id' => $add_new_fk_sourcing_partner_id,
			);
			$this->model->insertData('tbl_product_inventory', $add_new_product_inventory);
			$this->model->addUserLog($login_id, 'Inserted New Batch Inventory Details', 'tbl_product_inventory', $add_new_product_inventory);

		} else {
			$get_last_quantity = $this->model->selectWhereData('tbl_product_inventory', ['fk_product_id' => $product_id, 'used_status' => 1], array('add_quantity', 'total_quantity'), true);
			$last_quantity = $get_last_quantity['total_quantity'];
			foreach ($inventory_id as $inventory_id_key => $inventory_id_row) {
				if ($last_quantity == $total_quantity[$inventory_id_key]) {
					$update_product_inventory = array(
						'fk_login_id' => $login_id,
						'add_quantity' => $get_last_quantity['add_quantity'],
						'total_quantity' => $total_quantity[$inventory_id_key],
						// 'channel_type' => $channel_type[$inventory_id_key],
						// 'fk_sale_channel_id' => $sale_channel[$inventory_id_key],
						'fk_sourcing_partner_id' => $update_fk_sourcing_partner_id[$inventory_id_key],	
						'reason' => $update_reason
					);
				} else {
					$update_product_inventory = array(
						'fk_login_id' => $login_id,
						'add_quantity' => $total_quantity[$inventory_id_key],
						'total_quantity' => $total_quantity[$inventory_id_key],
						// 'channel_type' => $channel_type[$inventory_id_key],
						// 'fk_sale_channel_id' => $sale_channel[$inventory_id_key],
						'fk_sourcing_partner_id' => $update_fk_sourcing_partner_id[$inventory_id_key],
						'reason' => $update_reason
					);
				}
				$this->model->updateData('tbl_product_inventory', $update_product_inventory, ['id' => $inventory_id_row, 'fk_product_id' => $product_id, 'fk_batch_id' => $update_batch_id[$inventory_id_key] ,'used_status' => 1]);
				$this->model->addUserLog($login_id, 'Update Product Inventory', 'tbl_product_inventory', $update_product_inventory);
			}
		}
		echo json_encode(['status' => 'success', 'message' => 'Product updated successfully']);
	}

	public function delete_product()
	{
		$this->load->model('Product_model'); // Load the model

		$product_id = $this->input->post('product_id'); // Get product ID from AJAX request

		if (!empty($product_id)) {
			$admin_session = $this->session->userdata('admin_session');
			$login_id = $admin_session['user_id'];

			$delete_data = ['is_delete' => '0'];
			$update_product_status = $this->model->updateData('tbl_product_master', $delete_data, ['id' => $product_id]); // Soft delete
			$this->model->updateData('tbl_product_price', $delete_data, ['fk_product_id' => $product_id]); // Soft delete
			$this->model->updateData('tbl_product_inventory', $delete_data, ['fk_product_id' => $product_id]); // Soft delete
			$this->model->updateData('tbl_product_batches', $delete_data, ['fk_product_id' => $product_id]); // Soft delete
			$this->model->updateData('tbl_product_attributes', $delete_data, ['fk_product_id' => $product_id]); // Soft delete

			$this->model->addUserLog($login_id, 'Delete Product', 'tbl_product_master', $delete_data);
			$this->model->addUserLog($login_id, 'Delete Product Price', 'tbl_product_price', $delete_data);
			$this->model->addUserLog($login_id, 'Delete Product Inventory', 'tbl_product_inventory', $delete_data);
			$this->model->addUserLog($login_id, 'Delete Product Batch', 'tbl_product_batches', $delete_data);
			$this->model->addUserLog($login_id, 'Delete Product Attributes', 'tbl_product_attributes', $delete_data);

			if ($update_product_status) {
				echo json_encode(["success" => true, "message" => "Product deleted successfully."]);
			} else {
				echo json_encode(["success" => false, "message" => "Failed to delete product."]);
			}
		} else {
			echo json_encode(["success" => false, "message" => "Invalid product ID."]);
		}
	}
	public function add_product_type()
	{
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		} else {
			$response['permissions'] = $this->permissions; // Pass full permissions array
			$response['current_sidebar_id'] = 3; // Set the sidebar ID for the current view
			$this->load->view('add_product_type', $response);
		}
	}
	public function fetch_product_type()
	{
		$response = $this->model->selectWhereData('tbl_product_types', array('is_delete' => 1), "*", false, array('id', "DESC"));
		$data['permissions'] = $this->permissions; // Pass full permissions array
		$data['current_sidebar_id'] = 3; // Set the sidebar ID for the current view
		echo json_encode(['response' => $response, 'data' => $data]);
	}
	public function save_product_types()
	{
		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];
		$product_type_name = $this->input->post('product_type_name');
		$this->form_validation->set_rules('product_type_name', 'Product Type Name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
		if ($this->form_validation->run() == FALSE) {
			// Return validation errors as JSON (No page reload)
			$response = [
				'status' => 'error',
				'product_type_name_error' => form_error('product_type_name'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_product_types', array('product_type_name' => $product_type_name, 'is_delete' => 1));
			if ($count == 1) {
				$response = ["status" => "error", 'product_type_name_error' => "Product Type Already Exist"];
			} else {
				$data = array(
					'product_type_name' => $product_type_name,
				);
				$this->model->insertData('tbl_product_types', $data);
				$this->model->addUserLog($login_id, 'Inserted Product Type', 'tbl_product_types', $data);
				$response = ["status" => "success", "message" => "Product Type added successfully"];
			}
		}
		echo json_encode($response); // Return response as JSON
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
	public function update_product_types()
	{
		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];
		$flavour_id = $this->input->post('edit_id');
		$product_type_name = $this->input->post('edit_product_type_name');
		$this->form_validation->set_rules('edit_product_type_name', 'Product Type Name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
		if ($this->form_validation->run() == FALSE) {
			$response = [
				'status' => 'error',
				'edit_product_type_name_error' => form_error('edit_product_type_name'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_product_types', array('product_type_name' => $product_type_name, 'id !=' => $flavour_id));
			if ($count == 1) {
				$response = ["status" => "error", 'product_type_name_error' => "Product Type Already Exist"];
			} else {
				$update_data = ['product_type_name' => $product_type_name];

				$this->model->updateData('tbl_product_types', $update_data, ['id' => $flavour_id]);
				$this->model->addUserLog($login_id, 'Update Product Type', 'tbl_product_types', $update_data);
				$response = ["status" => "success", "message" => "Product Type updated successfully"];
			}
		}
		echo json_encode($response);
	}
	public function delete_product_type()
	{
		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];
		$id = $this->input->post('id');
		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid product type ID']);
			return;
		}
		$result = $this->model->updateData('tbl_product_types', ['is_delete' => '0'], ['id' => $id]); // Soft delete	
		$this->model->addUserLog($login_id, 'Update Product Type', 'tbl_product_types', ['is_delete' => '0']);
		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'Product Type deleted successfully']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to delete Product Type']);
		}
	}

	public function add_product_attributes()
	{
		$admin_session = $this->session->userdata('admin_session'); // Check if admin session exists
		if (!$admin_session) {
			redirect(base_url('common/index')); // Redirect to login page if session is not active
		} else {
			$response['product_types'] = $this->model->selectWhereData('tbl_product_types', array('is_delete' => 1), "*", false, array('id', "DESC"));
			$response['permissions'] = $this->permissions; // Pass full permissions array
			$response['current_sidebar_id'] = 4; // Set the sidebar ID for the current view
			$this->load->view('add_product_attributes', $response);
		}
	}
	public function get_product_attribute_detail()
	{
		$response['data'] = $this->Product_attribute_model->get_product_attribute_detail(); // Correctly access the model
		$response['permissions'] = $this->permissions; // Pass full permissions array
		$response['current_sidebar_id'] = 4; // Set the sidebar ID for the current view
		echo json_encode($response);
	}
	public function save_product_attributes()
	{
		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];
		$fk_product_type_id = $this->input->post('fk_product_type_id');
		$attribute_name = $this->input->post('attribute_name');
		$attribute_type = $this->input->post('attribute_type');

		$this->form_validation->set_rules('attribute_type', 'Product Attribute Type', 'required|trim');
		$this->form_validation->set_rules('fk_product_type_id', 'Product Type', 'required|trim');
		$this->form_validation->set_rules('attribute_name', 'Product Attribute Name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
		if ($this->form_validation->run() == FALSE) {
			// Return validation errors as JSON (No page reload)
			$response = [
				'status' => 'error',
				'fk_product_type_id_error' => form_error('fk_product_type_id'),
				'attribute_name_error' => form_error('attribute_name'),
				'attribute_type_error' => form_error('attribute_type'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_attribute_master', array('attribute_name' => $attribute_name, 'attribute_type' => $attribute_type, 'is_delete' => 1));
			if ($count == 1) {
				$response = ["status" => "error", 'attribute_type_error' => "Product Attribute Already Exist"];
			} else {
				$data = array(
					'fk_product_type_id' => $fk_product_type_id,
					'attribute_name' => $attribute_name,
					'attribute_type' => $attribute_type,
				);
				$this->model->insertData('tbl_attribute_master', $data);
				$this->model->addUserLog($login_id, 'Inserted Attribute', 'tbl_attribute_master', $data);

				$response = ["status" => "success", "message" => "Product Attribute added successfully"];
			}
		}
		echo json_encode($response); // Return response as JSON
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
	public function update_product_attribute()
	{
		// Set validation rules
		$this->form_validation->set_rules('edit_attribute_name', 'Attribute Name', 'required|trim|min_length[2]|max_length[100]');
		$this->form_validation->set_rules('edit_attribute_type', 'Attribute Type', 'required|in_list[text,dropdown]');

		// Run validation
		if ($this->form_validation->run() == FALSE) {
			$response = [
				"status" => "error",
				"errors" => [
					"edit_attribute_name" => form_error('edit_attribute_name'),
					"edit_attribute_type" => form_error('edit_attribute_type'),
				]
			];
			echo json_encode($response);
			return;
		}
		// Get input data
		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];
		$id = $this->input->post('edit_attribute_id');
		$attribute_name = $this->input->post('edit_attribute_name');
		$attribute_type = $this->input->post('edit_attribute_type');

		$count = $this->model->CountWhereRecord('tbl_attribute_master', array('attribute_name' => $attribute_name, 'id !=' => $id, 'is_delete' => 1));
		if ($count == 1) {
			$response = ["status" => "error", 'attribute_type_error' => "Product Attribute Already Exist"];
			echo json_encode($response);
			return;
		} else {
			$updateData = [
				'attribute_name' => $attribute_name,
				'attribute_type' => $attribute_type
			];
			$updated = $this->model->updateData('tbl_attribute_master', $updateData, ['id' => $id]);
			// Check if update was successful
			$this->model->addUserLog($login_id, 'Update Attribute Master', 'tbl_attribute_master', $updateData);
			if ($updated) {
				echo json_encode(["status" => "success", "message" => "Attribute updated successfully."]);
			} else {
				echo json_encode(["status" => "error", "message" => "Failed to update attribute."]);
			}
		}
	}
	public function delete_product_attribute()
	{
		$id = $this->input->post('id'); // Get the flavour ID from AJAX
		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid product Attribute  ID']);
			return;
		}
		$result = $this->model->updateData('tbl_attribute_master', ['is_delete' => '0'], ['id' => $id]); // Soft delete
		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'Product Attribute deleted successfully']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to delete Product Attribute']);
		}
	}

	public function add_product_attributes_value()
	{
		$admin_session = $this->session->userdata('admin_session'); // Check if admin session exists
		if (!$admin_session) {
			redirect(base_url('common/index')); // Redirect to login page if session is not active
		} else {
			$response['product_attributes'] = $this->model->selectWhereData('tbl_attribute_master', array('is_delete' => 1), "*", false, array('id', "DESC"));
			$response['permissions'] = $this->permissions; // Pass full permissions array
			$response['current_sidebar_id'] = 5; // Set the sidebar ID for the current view
			$this->load->view('add_product_attributes_value', $response);
		}
	}
	public function get_product_attributes_value_detail()
	{
		$response['data'] = $this->Product_attribute_model->get_product_attributes_value_detail(); // Correctly access the model
		$response['permissions'] = $this->permissions; // Pass full permissions array
		$response['current_sidebar_id'] = 5; // Set the sidebar ID for the current view
		echo json_encode($response);
	}
	public function save_product_attributes_value()
	{
		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];
		$fk_attribute_id = $this->input->post('fk_attribute_id');
		$attribute_value = $this->input->post('attribute_value');
		$this->form_validation->set_rules('fk_attribute_id', 'Product Attribute', 'required|trim');
		$this->form_validation->set_rules('attribute_value', 'Product Attribute Value', 'required|trim');
		if ($this->form_validation->run() == FALSE) {
			// Return validation errors as JSON (No page reload)
			$response = [
				'status' => 'error',
				'fk_attribute_id_error' => form_error('fk_attribute_id'),
				'attribute_value_error' => form_error('attribute_value'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_attribute_values', array('attribute_value' => $attribute_value, 'is_delete' => 1));
			if ($count == 1) {
				$response = ["status" => "error", 'attribute_value_error' => "Product Attribute Value Already Exist"];
			} else {
				$data = array(
					'fk_attribute_id' => $fk_attribute_id,
					'attribute_value' => $attribute_value,
				);
				$this->model->insertData('tbl_attribute_values', $data);
				$this->model->addUserLog($login_id, 'Inserted Attribute Value', 'tbl_attribute_values', $data);
				$response = ["status" => "success", "message" => "Product Attribute Value added successfully"];
			}
		}
		echo json_encode($response); // Return response as JSON
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
	public function update_product_attributes_value()
	{
		// Set validation rules
		$this->form_validation->set_rules('edit_attribute_value', 'Attribute Value', 'required|trim|min_length[2]|max_length[100]');
		// Run validation
		if ($this->form_validation->run() == FALSE) {
			$response = [
				"status" => "error",
				"errors" => [
					"edit_attribute_value" => form_error('edit_attribute_value'),
				]
			];
			echo json_encode($response);
			return;
		}
		// Get input data
		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];
		$id = $this->input->post('edit_attribute_value_id');
		$attribute_value = $this->input->post('edit_attribute_value');

		$count = $this->model->CountWhereRecord('tbl_attribute_values', array('attribute_value' => $attribute_value, 'id !=' => $id, 'is_delete' => 1));
		if ($count == 1) {
			$response = ["status" => "error", 'attribute_type_error' => "Product Attribute Value Already Exist"];
			echo json_encode($response);
			return;
		} else {
			$updateData = [
				'attribute_value' => $attribute_value,
			];

			$updated = $this->model->updateData('tbl_attribute_values', $updateData, ['id' => $id]);
			$this->model->addUserLog($login_id, 'Update Attribute Value', 'tbl_attribute_values', $data);

			if ($updated) {
				echo json_encode(["status" => "success", "message" => "Attribute Value updated successfully."]);
			} else {
				echo json_encode(["status" => "error", "message" => "Failed to update attribute value."]);
			}
		}
	}
	public function delete_product_attributes_value()
	{
		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];
		$id = $this->input->post('id'); // Get the flavour ID from AJAX
		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid product Attribute Value ID']);
			return;
		}

		$result = $this->model->updateData('tbl_attribute_values', ['is_delete' => '0'], ['id' => $id]); // Soft delete
		$this->model->addUserLog($login_id, 'Delete Attribute Value', 'tbl_attribute_values', ['is_delete' => '0']);

		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'Product Attribute Value deleted successfully']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to delete Product Attribute Value']);
		}
	}
	public function role_and_access()
	{
		$admin_session = $this->session->userdata('admin_session'); // Check if admin session exists
		if (!$admin_session) {
			redirect(base_url('common/index'));
		} else {
			$response['roles'] = $this->model->selectWhereData('tbl_role', array('is_delete' => 1), "*", false, array('id', "DESC"));
			$response['modules'] = $this->model->selectWhereData('tbl_sidebar', array(), "*", false, array('id', "ASC"));
			$this->load->view('role_access', $response);
		}
	}
	public function save_permissions()
	{
		$this->form_validation->set_rules('role_id', 'Role', 'required');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode([
				'status' => false,
				'errors' => [
					'role_id_error' => form_error('role_id'),
				]
			]);
			return;
		}
		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];
		$role_id = $this->input->post('role_id');
		$permissions = $this->input->post('permissions');

		if (empty($permissions)) {
			echo json_encode([
				'status' => false,
				'message' => "No permissions selected"
			]);
			return;
		}

		foreach ($permissions as $module_id => $perm) {
			$data = [
				'can_view' => !empty($perm['view']) ? 1 : 0,
				'can_add' => !empty($perm['add']) ? 1 : 0,
				'can_edit' => !empty($perm['edit']) ? 1 : 0,
				'can_delete' => !empty($perm['delete']) ? 1 : 0,
				'has_access' => !empty($perm['access']) ? 1 : 0 // For dashboard only
			];

			// Check if permission exists for this role and module
			$existing = $this->model->CountWhereRecord('tbl_permissions', [
				'fk_role_id' => $role_id,
				'fk_sidebar_id' => $module_id
			]);

			if ($existing) {
				// Update existing permission
				$this->model->updateData('tbl_permissions', $data, [
					'fk_role_id' => $role_id,
					'fk_sidebar_id' => $module_id
				]);
				$this->model->addUserLog($login_id, 'Update Role Permission', 'tbl_permissions', $data);

			} else {
				// Insert new permission
				$data['fk_role_id'] = $role_id;
				$data['fk_sidebar_id'] = $module_id;
				$this->model->insertData('tbl_permissions', $data);
				$this->model->addUserLog($login_id, 'Inserted Role Permission', 'tbl_permissions', $data);
			}
		}

		echo json_encode(['status' => true, 'message' => 'Permissions saved successfully']);
	}

	public function get_role_permissions()
	{
		$role_id = $this->input->post('role_id');
		if (!$role_id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid role ID']);
			return;
		}
		$permissions = $this->Role_model->get_permissions_by_role($role_id);
		if ($permissions) {
			echo json_encode(['status' => 'success', 'permissions' => $permissions]);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'No permissions found for this role']);
		}
	}

	public function sku_code()
	{
		$admin_session = $this->session->userdata('admin_session'); // Check if admin session exists
		if (!$admin_session) {
			redirect(base_url('common/index')); // Redirect to login page if session is not active
		} else {
			$response['permissions'] = $this->permissions; // Pass full permissions array
			$response['current_sidebar_id'] = 10; // Set the sidebar ID for the current view
			$this->load->view('sku_code', $response);
		}
	}
	public function get_sku_code_detail()
	{
		$response['data'] = $this->model->selectWhereData('tbl_sku_code_master', array('is_delete' => '1'), '*', false, array('id', 'DESC')); // Correctly access the model
		// $response['permissions'] = $this->permissions; // Pass full permissions array
		// $response['current_sidebar_id'] = 10; // Set the sidebar ID for the current view
		echo json_encode($response);
	}
	public function save_sku_code()
	{
		$sku_code = $this->input->post('sku_code');
		$this->form_validation->set_rules(
			'sku_code',
			'SKU Code',
			'required|regex_match[/^[A-Z]{2}-[A-Z]{2,}-[0-9]{2,4}$/]',
			array(
				'required'     => 'The %s field is required.',
				'regex_match'  => 'The %s must be in the format: NN-KA-250.'
			)
		);
		if ($this->form_validation->run() == FALSE) {
			// Return validation errors as JSON (No page reload)
			$response = [
				'status' => 'error',
				'sku_code_error' => form_error('sku_code'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_sku_code_master', array('sku_code' => $sku_code, 'is_delete' => 1));
			if ($count == 1) {
				$response = ["status" => "error", 'sku_code_error' => "SKU Code Already Exist"];
			} else {
				$data = array(
					'sku_code' => $sku_code,
				);
				$this->model->insertData('tbl_sku_code_master', $data);
				$response = ["status" => "success", "message" => "SKU Code added successfully"];
			}
		}
		echo json_encode($response); // Return response as JSON
	}
	public function get_sku_code_details_on_id()
	{
		$id = $this->input->post('id'); // Retrieve flavour ID from POST request		
		if (!$id) {
			echo json_encode(["status" => "error", "message" => "Invalid request"]);
			return;
		}
		$sku_code = $this->model->selectWhereData('tbl_sku_code_master', array('id' => $id, 'is_delete' => 1));
		if ($sku_code) {
			echo json_encode(["status" => "success", "sku_code" => $sku_code]);
		} else {
			echo json_encode(["status" => "error", "message" => "SKU Code not found"]);
		}
	}
	public function update_sku_code()
	{
		// Set validation rules
		$this->form_validation->set_rules(
			'edit_sku_code',
			'SKU Code',
			'required|regex_match[/^[A-Z]{2}-[A-Z]{2,}-[0-9]{2,4}$/]',
			array(
				'required'     => 'The %s field is required.',
				'regex_match'  => 'The %s must be in the format: NN-KA-250.'
			)
		);

		if ($this->form_validation->run() == FALSE) {
			$response = [
				"status" => "error",
				"errors" => [
					"edit_sku_code" => form_error('edit_sku_code'),
				]
			];
			echo json_encode($response);
			return;
		}

		// Get input data
		$id = $this->input->post('edit_sku_code_id');
		$sku_code = $this->input->post('edit_sku_code');

		$count = $this->model->CountWhereRecord('tbl_sku_code_master', array('sku_code' => $sku_code, 'id !=' => $id, 'is_delete' => 1));
		if ($count == 1) {
			$response = ["status" => "error", 'edit_sku_code' => "SKU Code Already Exist"];
			echo json_encode($response);
			return;
		} else {
			$updateData = [
				'sku_code' => $sku_code,
			];

			$updated = $this->model->updateData('tbl_sku_code_master', $updateData, ['id' => $id]);
			if ($updated) {
				echo json_encode(["status" => "success", "message" => "SKU Code updated successfully."]);
			} else {
				echo json_encode(["status" => "error", "message" => "Failed to update SKU Code."]);
			}
		}
	}
	public function delete_sku_code()
	{
		$id = $this->input->post('id'); // Get the flavour ID from AJAX
		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid SKU Code ID']);
			return;
		}

		$result = $this->model->updateData('tbl_sku_code_master', ['is_delete' => '0'], ['id' => $id]); // Soft delete

		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'SKU Code deleted successfully']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to delete SKU Code']);
		}
	}
	public function downloadProductSampleExcel()
	{
		ini_set('display_errors', 1);
		error_reporting(E_ALL);

		// Start output buffering to prevent unwanted output before the file is sent
		ob_start();

		// Load PhpSpreadsheet
		require_once FCPATH . 'vendor/autoload.php';

		$fk_product_types_id = $this->input->get('fk_product_types_ids');

		// Base headers for product master/inventory/batch/price
		$headers = [
			'Product Name',
			'SKU Code',
			'Stock Availability',
			'Barcode',
			'Batch Number',
			'Quantity',
			'Manufactured Date',
			'Expiry Date',
			'Description',
			'Purchase Price',
			'MRP',
			'Selling Price',
			'Product Type',
			'Channel Type',
			'Sales Channel'
		];

		$sampleRow = [
			'Sample Product',
			'SKU123',
			'In Stock',
			'987654321',
			'BATCH001',
			50,
			'2025-01-01',
			'2025-12-31',
			'Sample description',
			60,
			120,
			100,
			'Honey',
			'Online',
			'Amazon'
		];

		// Fetch attribute names and types for the product type
		$attributes = $this->model->selectWhereData(
			'tbl_attribute_master',
			['fk_product_type_id' => $fk_product_types_id, 'is_delete' => 1],
			'*',
			false, // multiple rows
			['id', 'ASC']
		);
		// Append each attribute as a column
		if (!empty($attributes)) {
			foreach ($attributes as $attr) {
				if (isset($attr['attribute_name'])) {
					$headers[] = $attr['attribute_name']; // Add attribute name to headers

					// Fetch the attribute value based on the attribute type
					switch ($attr['attribute_type']) {  // Assuming 'attribute_type' is a column in tbl_attribute_master
						case 'dropdown':  // If it's a dropdown, fetch possible values
							$attrValue = $this->model->selectWhereData(
								'tbl_attribute_values',
								['fk_attribute_id' => $attr['id'], 'is_delete' => 1],
								'*',
								false,  // multiple values
								['id', 'ASC']
							);
							// Append the dropdown values to sampleRow, use the first option if multiple values exist
							$sampleRow[] = isset($attrValue[0]['attribute_value']) ? $attrValue[0]['attribute_value'] : '';
							break;

						case 'text':  // If it's a text-based attribute
							// Here you might fetch a default or sample text value for a text-based attribute
							$sampleRow[] = "Sample Text Value"; // Change to actual logic if needed
							break;

						case 'checkbox':  // If it's a checkbox (boolean type)
							// Provide a sample boolean value (true/false)
							$sampleRow[] = 'Yes'; // Change to "No" if you want to simulate unchecked checkbox
							break;

						case 'radio':  // If it's a radio button (single option)
							// You may want to provide a sample value, if available
							$sampleRow[] = 'Option1'; // Replace with actual logic or a default option
							break;

						default:
							$sampleRow[] = '';  // Default case, leave it empty
							break;
					}
				}
			}
		}
		// Create spreadsheet

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->fromArray($headers, null, 'A1');
		$sheet->fromArray($sampleRow, null, 'A2');

		// Output file
		$filename = 'Product_Sample_with_Attributes.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header('Cache-Control: max-age=0');

		ob_end_clean();

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');  // Direct output to the browser

		exit;
	}

	public function importProductExcel()
	{
		$this->load->library('upload');
		require_once FCPATH . 'vendor/autoload.php';
		$this->load->library('email'); // Load Email Library
		$admin_session = $this->session->userdata('admin_session');
			$login_id = $admin_session['user_id'];

		if (!empty($_FILES['product_excel']['name'])) {
			$tmpPath = $_FILES['product_excel']['tmp_name'];
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($tmpPath);
			$sheet = $spreadsheet->getActiveSheet();
			$rows = $sheet->toArray();

			$rejected = [];
			$headers = $rows[1]; // Assuming headers are in 2nd row
			$headers[] = 'Error Message'; // For rejected export

			for ($i = 2; $i < count($rows); $i++) {
				$row = $rows[$i];
				$errorMsg = '';

				$sku = trim($row[1]);
				$batch_no = trim($row[4]);

				$sku_code = $this->model->countWhereRecord('tbl_sku_code_master', ['sku_code' => $sku, 'is_delete' => 1]);
				if ($sku_code > 0) {
					$fk_sku_code_id = $this->model->selectWhereData('tbl_sku_code_master', ['sku_code' => $sku, 'is_delete' => 1], 'id', true);
				} else {
					$this->model->insertData('tbl_sku_code_master', ['sku_code' => $sku]);
					$fk_sku_code_id = $this->model->selectWhereData('tbl_sku_code_master', ['sku_code' => $sku, 'is_delete' => 1], 'id', true);
				}

				$existing_product = $this->model->selectWhereData('tbl_product_master', ['product_sku_code' => $fk_sku_code_id['id']], '*', true);

				if ($existing_product) {
					$existing_batch = $this->model->selectWhereData('tbl_product_batches', [
						'fk_product_id' => $existing_product['id'],
						'batch_no' => $batch_no
					], 'id', true);

					if ($existing_batch) {
						$row[] = 'Duplicate product & batch. Skipped.';
						$rejected[] = $row;
						continue;
					}
				}

				$fk_stock_availability_id = $this->model->selectWhereData('tbl_stock_availability', ['stock_availability' => $row[2]], 'id', true);
				$fk_product_types_id = $this->model->selectWhereData('tbl_product_types', ['product_type_name' => $row[12]], 'id', true);
				$fk_sale_channel_id = $this->model->selectWhereData('tbl_sale_channel', ['sale_channel' => $row[14]], 'id', true);
				$quantity = $row[5];

				// Handle the images (comma-separated list of image paths)
				// $images = trim($row[8]); // Assuming images are in column 8

				// $image_urls = $this->handle_image_upload($images);

				if (!$existing_product) {
				    if(!empty($row[0])){
    					$product_data = [
    						'product_name' => $row[0],
    						'product_sku_code' => $fk_sku_code_id['id'],
    						'fk_stock_availability_id' => $fk_stock_availability_id['id'] ?? null,
    						'barcode' => $row[3],
    				// 		'images' => $image_urls,
    						'description' => $row[8],
    						'fk_product_types_id' => $fk_product_types_id['id'] ?? null,
    					];
    					$product_id = $this->model->insertData('tbl_product_master', $product_data);
    					$this->model->addUserLog($login_id, 'Insert Product', 'tbl_product_master', $product_data);
				    }
				} else {
					$product_id = $existing_product['id'];
				}
                if(!empty($batch_no)){
    				$product_batch = [
    					'fk_product_id' => $product_id,
    					'batch_no' => $batch_no,
    					'quantity' => $quantity,
    					'manufactured_date' => $row[6],
    					'expiry_date' => $row[7],
    				];
    				$batch_id = $this->model->insertData('tbl_product_batches', $product_batch);
    				$this->model->addUserLog($login_id, 'Insert Product Batch', 'tbl_product_batches', $product_batch);
                }
                if(!empty($row[9])){
    				$product_price = [
    					'fk_product_id' => $product_id,
    					'fk_batch_id' => $batch_id,
    					'purchase_price' => $row[9],
    					'MRP' => $row[10],
    					'selling_price' => $row[11],
    				];
    				$this->model->insertData('tbl_product_price', $product_price);
    				$this->model->addUserLog($login_id, 'Insert Product Price', 'tbl_product_price', $product_price);
                }
                if(!empty($row[13])){
    				$product_inventory = [
    					'fk_product_id' => $product_id,
    					'fk_batch_id' => $batch_id,
    					'channel_type' => $row[13],
    					'fk_sale_channel_id' => $fk_sale_channel_id['id'] ?? null,
    					'add_quantity' => $quantity,
    					'total_quantity' => $quantity,
    					'used_status' => 1,
    					'fk_login_id' =>$login_id,
    				];
    				$this->model->insertData('tbl_product_inventory', $product_inventory);
    				$this->model->addUserLog($login_id, 'Insert Product Inventory', 'tbl_product_inventory', $product_inventory);
                }
				$headers = $rows[0];
				$dynamicHeaders = array_slice($headers, 15);

				foreach ($dynamicHeaders as $index => $attrName) {
					$attrName = trim($attrName);
					$attrValue = trim($row[15 + $index] ?? '');
					if ($attrName === '' || $attrValue === '') continue;

					$attribute = $this->model->selectWhereData('tbl_attribute_master', [
						'attribute_name' => $attrName,
						'is_delete' => 1
					], 'id', true);

					$attribute_id = $attribute['id'] ?? null;

					if ($attribute_id) {
						$attributeValue = $this->model->selectWhereData('tbl_attribute_values', [
							'attribute_value' => $attrValue,
							'fk_attribute_id' => $attribute_id
						], 'id', true);

						if (!empty($attributeValue['id'])) {
							$exists = $this->model->selectWhereData('tbl_product_attributes', [
								'fk_product_id' => $product_id,
								'fk_product_types_id' => $fk_product_types_id['id'] ?? null,
								'fk_attribute_id' => $attribute_id,
								'fk_attribute_value_id' => $attributeValue['id'],
							], 'id', true);

							if (!$exists) {
								$this->model->insertData('tbl_product_attributes', [
									'fk_product_id' => $product_id,
									'fk_product_types_id' => $fk_product_types_id['id'] ?? null,
									'fk_attribute_id' => $attribute_id,
									'fk_attribute_value_id' => $attributeValue['id'],
								]);
							}
						}
					}
				}
				// Add to imported_products array
				$imported_products[] = [
					'Product Name' => $row[0],
					'SKU' => $sku,
					'Batch No' => $batch_no,
					'Quantity' => $quantity,
					'purchase_price' => $row[9],
					'MRP' => $row[10],
					'Expiry Date' => $row[7],
					'Manufactured Date' => $row[6]
				];
			}

			if (!empty($rejected)) {
				$this->load->helper('download');
				$rejectedFile = FCPATH . 'uploads/rejected_products_' . time() . '.xlsx';
				$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				array_unshift($rejected, $headers);
				$sheet->fromArray($rejected, null, 'A1');
				$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
				$writer->save($rejectedFile);

				$download_url = base_url('uploads/' . basename($rejectedFile));
				// $this->sendImportEmail($download_url, "Some rows were rejected. Please download the rejected file.", $imported_products);

				$this->output
					->set_content_type('application/json')
					->set_output(json_encode([
						'status' => "error",
						'message' => "Some rows were rejected. Please download the rejected file.",
						'download_url' => $download_url
					]));
				return;
			} else {
				// $this->sendImportEmail($download_url, "All rows imported successfully!", $imported_products, 'New Stock Added');

				$this->output
					->set_content_type('application/json')
					->set_output(json_encode([
						'status' => "success",
						'message' => "All rows imported successfully!"
					]));
				return;
			}
		} else {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode([
					'status' => "error",
					'message' => "No file selected!"
				]));
			return;
		}
	}
	// Helper function to handle image uploads
	private function handle_image_upload($images)
	{
		$upload_dir = './uploads/products/';
		$image_urls = [];

		// Ensure the directory exists with proper permissions
		if (!is_dir($upload_dir)) {
			mkdir($upload_dir, 0777, true);
		}
		chmod($upload_dir, 0777);

		// Skip if images is empty
		if (empty($images)) {
			return '';
		}

		// Split the comma-separated image URLs
		$image_paths = explode(',', $images);

		foreach ($image_paths as $image_path) {
			$image_path = trim($image_path);

			// Skip empty URLs
			if (empty($image_path)) {
				continue;
			}

			// Generate filename
			$extension = 'jpg'; // default

			// Try to extract extension from URL
			$path_parts = pathinfo(parse_url($image_path, PHP_URL_PATH));
			if (isset($path_parts['extension'])) {
				$extension = strtolower($path_parts['extension']);
				// Validate extension
				if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
					$extension = 'jpg'; // fallback to jpg
				}
			}

			$filename = uniqid('img_') . '.' . $extension;
			$destination = $upload_dir . $filename;

			try {
				// Use simple file_get_contents() instead of cURL
				$context = stream_context_create([
					'http' => [
						'timeout' => 30,
						'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
					],
					'ssl' => [
						'verify_peer' => false,
						'verify_peer_name' => false
					]
				]);

				$image_content = @file_get_contents($image_path, false, $context);

				if ($image_content === false) {
					continue;
				}

				// Save the image directly
				if (file_put_contents($destination, $image_content) !== false) {
					chmod($destination, 0666); // Make the file readable
					// $saved_url = base_url('uploads/products/' . $filename);
					$saved_url = $filename;
					$image_urls[] = $saved_url;
				}
			} catch (Exception $e) {
				// Just continue with the next image if there's an error
				continue;
			}
		}

		// Return comma-separated list of URLs
		return implode(',', $image_urls);
	}

	/**
	 * Debug test function for image upload
	 */
	public function testImageUpload()
	{
		// Test with some real image URLs
		$test_urls = "C:\Users\user\Downloads\Neem5.jpg,C:\Users\user\Downloads\Neem4.jpg,C:\Users\user\Downloads\Neem3.jpg,C:\Users\user\Downloads\Neem2.jpg,C:\Users\user\Downloads\Neem.jpg
";

		echo "<h2>Image Upload Test</h2>";
		echo "<p>Testing with URLs: " . htmlspecialchars($test_urls) . "</p>";

		$result = $this->handle_image_upload($test_urls);

		echo "<p>Result: " . htmlspecialchars($result) . "</p>";

		if (!empty($result)) {
			echo "<h3>Uploaded Images:</h3>";
			$urls = explode(',', $result);
			foreach ($urls as $url) {
				echo "<img src='" . htmlspecialchars($url) . "' style='max-width:300px; margin:10px;'><br>";
			}
		} else {
			echo "<p>No images were uploaded.</p>";
		}
	}
	public function order_details()
	{
		$admin_session = $this->session->userdata('admin_session'); // Check if admin session exists
		if (!$admin_session) {
			redirect(base_url('common/index'));
		} else {
			$data['sku_code'] = $this->model->selectWhereData('tbl_sku_code_master', array('is_delete' => 1), "id,sku_code", false, array('id', "DESC"));
			$data['permissions'] = $this->permissions; // Pass full permissions array
			$data['current_sidebar_id'] = 8; // Set the sidebar ID for the current view
			$this->load->view('order_details', $data);
		}
	}
	public function get_product_id_on_sku_code()
	{
		$sku_code = $this->input->post('sku_code'); // Get the SKU code from AJAX
		if (!$sku_code) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid SKU code']);
			return;
		}
		$result = $this->model->selectWhereData('tbl_product_master', ['product_sku_code' => $sku_code, 'is_delete' => 1], 'id'); // Soft delete
		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'Product ID fetched successfully', 'product_id' => $result['id']]);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to fetch Product ID']);
		}
	}
	public function get_batch_no_on_product_id()
	{
		$product_id = $this->input->post('product_id'); // Get the SKU code from AJAX

		if (!$product_id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid Product ID']);
			return;
		}
		$result = $this->model->selectWhereData('tbl_product_batches', ['fk_product_id' => $product_id, 'is_delete' => 1], 'id,batch_no'); // Soft delete
		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'Batch No fetched successfully', 'data' => $result]);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to fetch Batch No']);
		}
	}
	public function submit_order_form()
	{
		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];
		$this->form_validation->set_rules('sku_code', 'Sku Code', 'required|trim');
		$this->form_validation->set_rules('fk_batch_id', 'Batch No', 'required|trim');
		$this->form_validation->set_rules('order_quantity', 'Quantity', 'required|trim|numeric');
		$this->form_validation->set_rules('channel_type', 'Channel Type', 'required|trim');
		$this->form_validation->set_rules('sale_channel', 'Sale Channel', 'required|trim');
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'status' => 'error',
				'errors' => [
					'sku_code' => form_error('sku_code'),
					'fk_batch_id' => form_error('fk_batch_id'),
					'order_quantity' => form_error('order_quantity'),
					'channel_type' => form_error('channel_type'),
					'sale_channel' => form_error('sale_channel'),
					'reason' => form_error('reason'),
				]
			];
			echo json_encode($response);
			return;
		}
		$product_id = $this->input->post('product_id');
		$fk_batch_id = $this->input->post('fk_batch_id');
		$quantity = $this->input->post('order_quantity');
		$channel_type = $this->input->post('channel_type');
		$sale_channel = $this->input->post('sale_channel');
		$reason = $this->input->post('reason');

		$last_quantity = $this->model->selectWhereData('tbl_product_inventory', [
			'fk_product_id' => $product_id,
			'fk_batch_id' => $fk_batch_id,
			'used_status' => 1
		], 'total_quantity,id', true);

		if (!$last_quantity) {
			$response = ["status" => "error", "message" => "Inventory not found."];
			echo json_encode($response);
			return;
		}

		$previous_quantity = $last_quantity['total_quantity'];
		$inventory_id = $last_quantity['id'];

		// Check if ordered quantity is greater than available quantity
		if ($quantity > $previous_quantity) {
			$response = ["status" => "error", "message" => "Order quantity exceeds available stock."];
			echo json_encode($response);
			return;
		}

		$total_quantity = $previous_quantity - $quantity;

		if ($total_quantity == 0) {
			// If after deduction quantity is zero, update existing inventory
			$update_data = [
				'used_status' => 0,
				'is_delete' => '0',
				'total_quantity' => 0
			];
			$this->model->updateData('tbl_product_inventory', $update_data, ['id' => $inventory_id]);
			$this->model->addUserLog($login_id, 'Update Product Inventory', 'tbl_product_inventory', $update_data);

			$update_price_status = ['is_delete' => '0', 'status' => 0];
			$this->model->updateData('tbl_product_price', $update_price_status, ['fk_product_id' => $product_id, 'fk_batch_id' => $fk_batch_id]);
			$this->model->addUserLog($login_id, 'Update Product Price', 'tbl_product_price', $update_price_status);

			$update_batch_status = ['is_delete' => '0', 'status' => 0];
			$this->model->updateData('tbl_product_batches', $update_batch_status, ['fk_product_id' => $product_id, 'id' => $fk_batch_id]);
			$this->model->addUserLog($login_id, 'Update Product Batch', 'tbl_product_batches', $update_batch_status);	
			$response = ["status" => "success", "message" => "Order submitted successfully. Stock finished."];
		} else {
			// Otherwise, update existing record and insert new one with deducted quantity
			$update_data = [
				'used_status' => 0,
				'is_delete' => '0'
			];
			$this->model->updateData('tbl_product_inventory', $update_data, ['id' => $inventory_id]);
			$this->model->addUserLog($login_id, 'Update Product Inventory', 'tbl_product_inventory', $update_data);
			$order_data = [
				'fk_product_id' => $product_id,
				'fk_batch_id' => $fk_batch_id,
				'channel_type' => $channel_type,
				'fk_sale_channel_id' => $sale_channel,
				'deduct_quantity' => $quantity,
				'total_quantity' => $total_quantity,
				'used_status' => 1,
				'fk_login_id' => $login_id,
				'reason' =>$reason
			];
			$inserted = $this->model->insertData('tbl_product_inventory', $order_data);
			$this->model->addUserLog($login_id, 'Insert Product Inventory For Deduct Quantity', 'tbl_product_inventory', $update_data);
			if ($inserted) {
				$response = ["status" => "success", "message" => "Order submitted successfully"];
			} else {
				$response = ["status" => "error", "message" => "Failed to submit order"];
			}
		}

		echo json_encode($response);
	}

	public function inventory_details()
	{
		$admin_session = $this->session->userdata('admin_session'); // Check if admin session exists
		if (!$admin_session) {
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

	public function get_all_orders()
	{
		$start = $this->input->post('start');
		$length = $this->input->post('length');

		$orders = $this->Product_model->get_orders($start, $length);
		$totalRecords = $this->Product_model->get_total_orders();

		echo json_encode([
			"draw" => intval($this->input->post('draw')),
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $totalRecords,
			"data" => $orders
		]);
	}

	public function upload_order_excel()
	{

		$this->load->library('upload');
		require_once FCPATH . 'vendor/autoload.php';
		$this->load->library('email'); // Load Email Library

		$admin_session = $this->session->userdata('admin_session');
		$login_id = $admin_session['user_id'];

		require_once FCPATH . 'vendor/autoload.php';

		$uploadPath = FCPATH . 'uploads/rejected_excels/';

		if (!is_dir($uploadPath)) {
			mkdir($uploadPath, 0777, true);
		}

		if (isset($_FILES['excel_file']['name']) && $_FILES['excel_file']['name'] != '') {
			$fileTmpPath = $_FILES['excel_file']['tmp_name'];

			try {
				$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileTmpPath);
				$sheet = $spreadsheet->getActiveSheet();
				$data = $sheet->toArray();

				// $insertData = []; 
				$rejectedData = [];

				// Add headers + rejection reason header
				$headers = $data[0];
				$headers[] = 'Rejection Reason';

				for ($i = 2; $i < count($data); $i++) {
					$row = $data[$i];
					$sku_code     = trim($row[0]);
					$batch_no     = trim($row[1]);
					$channel_type = trim($row[2]);
					$sale_channel = trim($row[3]);
					$quantity     = trim($row[4]);
					$reason     = trim($row[5]);

					// Validate SKU
					$skuValid = $this->model->selectWhereData('tbl_sku_code_master', [
						'sku_code' => $sku_code,
						'is_delete' => 1
					], 'id', true);

					if (!$skuValid) {
						$row[] = 'Invalid SKU Code';
						$rejectedData[] = $row;
						continue;
					}

					// Validate product
					$product = $this->model->selectWhereData('tbl_product_master', [
						'product_sku_code' => $skuValid['id'],
						'is_delete' => 1
					], 'id', true);

					if (!$product) {
						$row[] = 'Product not found for SKU';
						$rejectedData[] = $row;
						continue;
					}

					$product_id = $product['id'];

					// Validate batch
					$batchValid = $this->model->selectWhereData('tbl_product_batches', [
						'batch_no' => $batch_no,
						'fk_product_id' => $product_id
					], 'id', true);

					if (!$batchValid) {
						$row[] = 'Invalid batch for product';
						$rejectedData[] = $row;
						continue;
					}

					// Validate sale channel
					$sale_channel_id = $this->model->selectWhereData('tbl_sale_channel', [
						'sale_channel' => $sale_channel,
						'is_delete' => 1
					], 'id', true);

					if (!$product_id || !$batchValid['id'] || !$sale_channel_id || !is_numeric($quantity)) {
						$row[] = 'Invalid data or quantity not numeric';
						$rejectedData[] = $row;
						continue;
					}

					// Get last inventory quantity
					$last_quantity = $this->model->selectWhereData('tbl_product_inventory', [
						'fk_product_id' => $product_id,
						'fk_batch_id' => $batchValid['id'],
						'used_status' => 1
					], 'total_quantity,id', true, ['id' => 'DESC']);

					if (!empty($last_quantity)) {
						$previous_quantity = $last_quantity['total_quantity'];
						$inventory_id = $last_quantity['id'];
						$total_quantity = $previous_quantity - $quantity;

						if ($total_quantity < 0) {
							$row[] = 'Resulting quantity would be zero or negative';
							$rejectedData[] = $row;
							continue;

							$this->model->updateData('tbl_product_inventory', [
								'used_status' => 0,
								'is_delete' => '0'
							], ['fk_product_id' => $product_id, 'fk_batch_id' => $batchValid['id'],]);
						}

						$this->model->updateData('tbl_product_inventory', [
							'used_status' => 0,
							'is_delete' => '0'
						], ['fk_product_id' => $product_id, 'fk_batch_id' => $batchValid['id'],]);

						// Prepare insert data

						$insertData = [
							'fk_product_id'       => $product_id,
							'fk_batch_id'         => $batchValid['id'],
							'channel_type'        => $channel_type,
							'fk_sale_channel_id'  => $sale_channel_id['id'],
							'deduct_quantity'     => $quantity,
							'total_quantity'      => $total_quantity,
							'used_status'         => 1,
							'reason'			  => $reason,
							'fk_login_id'		  => $login_id
						];
						$this->model->insertData('tbl_product_inventory', $insertData);
						$this->model->addUserLog($login_id, 'Insert Product Inventory', 'tbl_product_inventory', $insertData);
					} else {
						$row[] = 'No previous inventory found';
						$rejectedData[] = $row;
						continue;
					}

					// Add to imported_products array
					$imported_order[] = [
						'SKU' => $row[0],
						'Batch No' => $row[1],
						'Channel Type' => $row[2],
						'Sales Channel' => $row[3],
						'Quantity' => $row[4],
						'Reason' => $row[5],					
					];
				}
				// Generate rejection Excel
				if (!empty($rejectedData)) {
					$rejectedSheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
					$sheet = $rejectedSheet->getActiveSheet();

					$sheet->fromArray($headers, NULL, 'A1');
					$sheet->fromArray($rejectedData, NULL, 'A2');

					$fileName = 'rejected_orders_' . time() . '.xlsx';
					$filePath = $uploadPath . $fileName;

					$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($rejectedSheet, 'Xlsx');
					$writer->save($filePath);

					$downloadUrl = base_url('uploads/rejected_excels/' . $fileName);

					$this->output
					->set_content_type('application/json')
					->set_output(json_encode([
						'status'       => 'partial',
						'message'      => 'Some rows were rejected.',
						'rejected_url' => $downloadUrl
					]));
					return;
				}else {
				// 	$this->sendImportEmail('', "All order data uploaded successfully!.", $imported_products, 'Quantity Deducted');
	
					$this->output
						->set_content_type('application/json')
						->set_output(json_encode([
							'status'  => 'success',
							'message' => 'All order data uploaded successfully.'
						]));
					return;
				}			
			} catch (Exception $e) {
				$this->output
						->set_content_type('application/json')
						->set_output(json_encode([
							'status'  => 'error',
							'message' => 'Invalid Excel file or error: ' . $e->getMessage()
						]));
					return;
			}
		} else {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode([
					'status' => "error",
					'message' => "No file selected!"
				]));
			return;
		}
	}
	private function sendImportEmail($file_link = '', $message = '', $imported_products = [],$subject1 = "")
	{
		// $this->email->from('your_email@example.com', 'Your Company');
		// $this->email->to('receiver@example.com'); // Change this
		// $this->email->subject('Product Import Status');

		$to_email = "shirin@sda-zone.com"; // Replace with actual receiver
		$subject = $subject1;

		$body = "<p>$message</p>";

		if (!empty($imported_products)) {
			$body .= "<h3>Imported Products:</h3>";
			$body .= "<table border='1' cellpadding='5' cellspacing='0'>";
			$body .= "<thead><tr>";

			foreach (array_keys($imported_products[0]) as $header) {
				$body .= "<th>$header</th>";
			}

			$body .= "</tr></thead><tbody>";

			foreach ($imported_products as $product) {
				$body .= "<tr>";
				foreach ($product as $value) {
					$body .= "<td>$value</td>";
				}
				$body .= "</tr>";
			}

			$body .= "</tbody></table><br>";
		}

		if (!empty($file_link)) {
			$body .= "<p><a href='$file_link' target='_blank'>Download Rejected File</a></p>";
		}
		$email_message = $body;
		send_inventory_email($to_email, $subject, $email_message);
		// $this->email->message($body);
		// $this->email->set_mailtype('html');
		// $this->email->send();
	}
	
    public function generate_inventory_report() {
    		$CI = &get_instance();
    		$this->load->model("Inventory_model");
    		$this->load->library('email');
    	
    		$date = date('Y-m-d');
    	
    		// Fetch Start of Day Inventory
    		$start_of_day_inventory = $this->Inventory_model->get_start_of_day_inventory($date);
    		$quantity_on_hand_inventory = $this->Inventory_model->get_quantity_on_hand_inventory($date);
    		// echo "<pre>"; print_r($quantity_on_hand_inventory); die;
    	
    		$report_data = [];
    	
    		$total_qty_on_hand = 0;
    		$total_received = 0;
    		$total_sold = 0;
    	
    		foreach ($quantity_on_hand_inventory as $quantity_on_hand_inventory_key => $row) {
    			$product_id = $row['fk_product_id'];
    	
    			// Add Qty on Hand only once per product
    			$total_qty_on_hand += $row['qty_on_hand'];
    	
    			// Get sold and received quantities for the product
    			$sold_quantities = $this->Inventory_model->get_sold_quantity($product_id, $date);
    			$received_quantities = $this->Inventory_model->get_received_quantity($product_id, $date);
    			$product_name = $this->Inventory_model->get_product_name($product_id);
    	
    			$channel_data = [];
    	
    			// Ensure sold quantities are included (even if none for today)
    			foreach ($sold_quantities as $sold_row) {
    				$channel = $sold_row['sale_channel'];
    				$channel_data[$channel]['sold'] = $sold_row['sold_quantity'];
    			}
    	
    			// Ensure received quantities are included (even if none for today)
    			foreach ($received_quantities as $received_row) {
    				$channel = $received_row['sale_channel'];
    				$channel_data[$channel]['received'] = $received_row['received_quantity'];
    			}
    	
    			// If no sold or received quantities, still include the product with 0 sold and 0 received
    			if (empty($channel_data)) {
    				$channel_data['No_Channel'] = ['sold' => 0, 'received' => 0];
    			}
    	
    			foreach ($channel_data as $channel => $data) {
    				$received = $data['received'] ?? 0;
    				$sold = $data['sold'] ?? 0;
    
    				$attribute_value = explode(",",$product_name['attribute_value']);
    
    				$product_name = $product_name['product_type_name'] . ' ' . $attribute_value[0] . ' ' . $attribute_value[1] . ' ' . $attribute_value[2];
    								
    				$report_data[] = [
    					'product_name' => $product_name,
    					'sku_code' => $row['sku_code'],
    					'qty_on_hand' => $row['qty_on_hand'],
    					'received' => $received,
    					'sold' => $sold,
    					'sale_channel' => $channel,
    					'note' => $row['reason'] ?? ''
    				];
    	
    				$total_received += $received;
    				$total_sold += $sold;
    			}
    		}
    	
    		// Calculate End of Day Inventory
    		$calculated_end_of_day_inventory = $start_of_day_inventory + $total_received - $total_sold;
    	
    		// Build HTML table
    		$now_date = date('jS M Y');  // outputs: 30th Apr 2025
    		$html = "<h3>Inventory Report for {$now_date}</h3>";
    		$html .= "<p><strong>Start of Day Inventory:</strong> {$start_of_day_inventory}</p>";
    		$html .= "<p><strong>End of Day Inventory:</strong> {$calculated_end_of_day_inventory}</p>";
    		$html .= "<table border='1' cellpadding='5' cellspacing='0'>
    					<thead>
    						<tr>
    							<th>Product Name</th>
    							<th>SKU</th>
    							<th>Qty in Stock</th>
    							<th>Received Today</th>
    							<th>Sold Today</th>
    							<th>Sales Channel</th>
    							<th>Note</th>
    						</tr>
    					</thead>
    					<tbody>";
    	
        		foreach ($report_data as $row) {
                    $html .= "<tr>
                                <td>" . (!empty($row['product_name']) ? $row['product_name'] : 'NA') . "</td>
                                <td>" . (!empty($row['sku_code']) ? $row['sku_code'] : 'NA') . "</td>
                                <td>" . (isset($row['qty_on_hand']) ? $row['qty_on_hand'] : 'NA') . "</td>
                                <td>" . (isset($row['received']) ? $row['received'] : 'NA') . "</td>
                                <td>" . (isset($row['sold']) ? $row['sold'] : 'NA') . "</td>
                                <td>" . (($row['sold'] == 0 || empty($row['sale_channel'])) ? 'NA' : $row['sale_channel']) . "</td>
                                <td>" . ( $row['note']) . "</td>
                            </tr>";
                }
    	
    		// Add total row
    		$html .= "<tr style='font-weight:bold; background-color:#f0f0f0;'>
    					<td colspan='2'>Total</td>
    					<td>{$total_qty_on_hand}</td>
    					<td>{$total_received}</td>
    					<td>{$total_sold}</td>
    					<td colspan='2'></td>
    				  </tr>";
    	
    		$html .= "</tbody></table>";
    		    		// echo"<pre>";print_r($html);die;
    		// Email config
        // 	$to_email = 'shirin@sda-zone.com, sanju@sda-zone.com';
    		$to_email = 'shirin@sda-zone.com, shiraz@sda-zone.com, sanju@sda-zone.com, rekha@sda-zone.com, moiz@sda-zone.com';
    		$subject = "Nia Natura Inventory Daily Report";
    // 		$subject = "Nia Natura Inventory Daily Report - {$date}";
    		$send = send_inventory_email($to_email, $subject, $html);
    	
    		if ($send) {
    			echo "Email sent successfully!";
    		} else {
    			echo "Email failed to send.";
    		}
    	}

	//Sourcing Partner
	public function sourcing_partner()
	{
		$admin_session = $this->session->userdata('admin_session'); // Check if admin session exists
		if (!$admin_session) {
			redirect(base_url('common/index')); // Redirect to login page if session is not active
		} else {
			$data['permissions'] = $this->permissions; // Pass full permissions array
			$data['current_sidebar_id'] = 11; // Set the sidebar ID for the current view
			$this->load->view('sourcing_partner', $data);
		}
	}
	public function save_sourcing_partner()
	{
		$admin_session = $this->session->userdata('admin_session'); // Check if admin session exists
		$login_id = $admin_session['user_id'];
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim');
		$this->form_validation->set_rules('contact_no', 'Contact No', 'required|trim|max_length[10]|min_length[10]');
		$this->form_validation->set_rules('address', 'Address', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'status' => 'error',
				'errors' => [
					'name' => form_error('name'),	
					'email' => form_error('email'),
					'address'=> form_error('address'),
					'contact_no'=> form_error('contact_no'),
				]
			];
			echo json_encode($response);
			return;
		}
		
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$contact_no = $this->input->post('contact_no');
		$address = $this->input->post('address');
		// Check if email already exists
		$existing_email = $this->model->selectWhereData('tbl_sourcing_partner', ['email' => $email], 'id', true);
		if ($existing_email) {
			$response = [
				"status" => "error",
				"errors" => [
					"email" => "Email already exists"
				]
			];
			echo json_encode($response);
			return;
		}
		// Check if contact number already exists
		$existing_contact = $this->model->selectWhereData('tbl_sourcing_partner', ['contact_no' => $contact_no], 'id', true);
		if ($existing_contact) {
			$response = [
				"status" => "error",
				"errors" => [
					"contact_no" => "Contact number already exists"
				]
			];
			echo json_encode($response);
			return;
		}
		// Insert new sourcing partner
		$data = [
			'name' => $name,
			'email' => $email,
			'contact_no' => $contact_no,
			'address' => $address
		];
		$inserted = $this->model->insertData('tbl_sourcing_partner', $data);
		$this->model->addUserLog($login_id, 'Insert Sourcing Partner', 'tbl_sourcing_partner', $data);
		if ($inserted) {
			$response = ["status" => "success", "message" => "Sourcing Partner added successfully"];
		} else {
			$response = ["status" => "error", "message" => "Failed to add Sourcing Partner"];
		}		
		echo json_encode($response);
	}
	public function get_sourcing_partner_list()
	{
		$response = [
			'status' => 'success',
			'data' => $this->model->selectWhereData('tbl_sourcing_partner', ['is_delete' => 1], '*', false, ['id' => 'DESC'])	
		];
		$response['permissions'] = $this->permissions; // Pass full permissions array
		$response['current_sidebar_id'] = 11; // Set the sidebar ID for the current view
		echo json_encode($response);
	}	
	public function view_sourcing_partner() {
		$id = $this->input->post('id');
		
		if (empty($id)) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid sourcing partner ID']);
			return;
		}
		
		// Fetch sourcing partner details from the database
		$sourcing_partner = $this->model->selectWhereData('tbl_sourcing_partner', ['id' => $id], '*', true);
		
		if ($sourcing_partner) {
			$data['status'] = 'success';
			$data['sourcing_partner'] = $sourcing_partner;
		} else {
			$data['status'] = 'error';
			$data['message'] = 'Sourcing partner not found';
		}
		
		echo json_encode($data);
	}
	public function update_sourcing_partner()
	{
		$admin_session = $this->session->userdata('admin_session'); // Check if admin session exists
		$login_id = $admin_session['user_id'];
		$this->form_validation->set_rules('edit_name', 'Name', 'required|trim');
		$this->form_validation->set_rules('edit_email', 'Email', 'required|trim');
		$this->form_validation->set_rules(
			'edit_contact_no',
			'Contact No',
			'required|trim|exact_length[10]|regex_match[/^[0-9]{10}$/]',
			[
				'regex_match' => 'The %s must be a valid 10-digit number.'
			]
		);
		$this->form_validation->set_rules('edit_address', 'Address', 'required|trim');
		$this->form_validation->set_rules('id', 'ID', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'status' => 'error',
				'errors' => [
					'edit_name' => form_error('edit_name'),	
					'edit_email' => form_error('edit_email'),
					'edit_address'=> form_error('edit_address'),
					'edit_contact_no'=> form_error('edit_contact_no'),
				]
			];
			echo json_encode($response);
			return;
		}
		
		$id = $this->input->post('id');
		
		if (empty($id)) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid sourcing partner ID']);
			return;
		}
		
		$name = $this->input->post('edit_name');
		$email = $this->input->post('edit_email');
		$contact_no = $this->input->post('edit_contact_no');
		$address = $this->input->post('edit_address');
		// Check if email already exists
		$existing_email = $this->model->selectWhereData('tbl_sourcing_partner', ['email' => $email, 'id !=' => $id], 'id', true);
		if ($existing_email) {
			$response = [
				"status" => "error",
				"errors" => [
					"edit_email" => "Email already exists"
				]
			];
			echo json_encode($response);
			return;
		}
		// Check if contact number already exists	
		$existing_contact = $this->model->selectWhereData('tbl_sourcing_partner', ['contact_no' => $contact_no, 'id !=' => $id], 'id', true);
		if ($existing_contact) {
			$response = [
				"status" => "error",
				"errors" => [
					"edit_contact_no" => "Contact number already exists"
				]
			];
			echo json_encode($response);
			return;
		}
		// Update sourcing partner
		$data = [
			'name' => $name,
			'email' => $email,
			'contact_no' => $contact_no,
			'address' => $address
		];
		$updated = $this->model->updateData('tbl_sourcing_partner', $data, ['id' => $id]);
		$this->model->addUserLog($login_id, 'Update Sourcing Partner', 'tbl_sourcing_partner', $data);
		if ($updated) {
			$response = ["status" => "success", "message" => "Sourcing Partner updated successfully"];
		} else {
			$response = ["status" => "error", "message" => "Failed to update Sourcing Partner"];
		}
		echo json_encode($response);
	}
	public function delete_sourcing_partner()
	{
		$admin_session = $this->session->userdata('admin_session'); // Check if admin session exists
		$login_id = $admin_session['user_id'];
		$id = $this->input->post('id');
		if (empty($id)) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid sourcing partner ID']);
			return;
		}		
		// Soft delete sourcing partner
		$data = ['is_delete' => '0'];
		$deleted = $this->model->updateData('tbl_sourcing_partner', $data, ['id' => $id]);
		if ($deleted) {
			$this->model->addUserLog($login_id, 'Delete Sourcing Partner', 'tbl_sourcing_partner', $data);
			echo json_encode(['status' => 'success', 'message' => 'Sourcing Partner deleted successfully']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to delete Sourcing Partner']);
		}
	}
}
