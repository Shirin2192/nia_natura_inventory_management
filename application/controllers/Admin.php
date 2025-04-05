<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Product_model'); // Load the Product_model
		$this->load->model('user_model'); // Load the Product_model
		$this->load->model('Product_attribute_model'); // Ensure the model is loaded
		$this->load->model('model'); // Load the generic model for database operations
		$this->load->library('form_validation'); // Load form validation library
		
	}
	// Default method for the Admin controller
	public function index()
	{
		$admin_session = $this->session->userdata('admin_session'); // Check if admin session exists
		if (!$admin_session) {
			redirect(base_url('common/index')); // Redirect to login page if session is not active
		} else {
			$this->load->view('admin/dashboard'); // Load the admin dashboard view
		}
	}
	public function add_staff()
	{
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		} else {
			$response['role'] = $this->model->selectWhereData('tbl_role', array('is_delete' => 1), "*", false, array('id', "DESC"));

			$this->load->view('admin/add_staff', $response);
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
		foreach ($users as $user) {
			$data[] = [
				"id" => $user['id'],
				"name" => $user['name'],
				"email" => $user['email'],
				"role_name" => $user['role_name']
			];
		}
		echo json_encode([
			"draw" => intval($draw),
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $totalRecords,
			"data" => $data
		]);
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
			$data = [
				'name' => $first_name . " " . $last_name,
				'fk_role_id' => $this->input->post('edit_role'),
			];
			$update_status = $this->model->updateData('tbl_user', $data, ['id' => $staff_id]);
			if ($update_status) {
				echo json_encode(["status" => "success", "message" => "Staff updated successfully."]);
			} else {
				echo json_encode(["status" => false, "message" => "Failed to update staff."]);
			}
		}
	}
	public function add_flavour()
	{
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		} else {
			$this->load->view('inventory_manager/add_flavour');
		}
	}
	public function fetch_flavours()
	{
		$response = $this->model->selectWhereData('tbl_flavour', array('is_delete' => 1), "*", false, array('id', "DESC"));
		echo json_encode($response);
	}
	public function save_flavour()
	{
		$flavour_name = $this->input->post('flavour_name');
		$this->form_validation->set_rules('flavour_name', 'Flavour Name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
		if ($this->form_validation->run() == FALSE) {
			// Return validation errors as JSON (No page reload)
			$response = [
				'status' => 'error',
				'flavour_name_error' => form_error('flavour_name'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_flavour', array('flavour_name' => $flavour_name, 'is_delete' => 1));
			if ($count == 1) {
				$response = ["status" => "error", 'flavour_name_error' => "Flavour Already Exist"];
			} else {
				$data = array(
					'flavour_name' => $flavour_name,
				);
				$this->model->insertData('tbl_flavour', $data);
				$response = ["status" => "success", "message" => "Flavour added successfully"];
			}
		}
		echo json_encode($response); // Return response as JSON
	}
	public function get_flavour_details()
	{
		$id = $this->input->post('id'); // Retrieve flavour ID from POST request		
		if (!$id) {
			echo json_encode(["status" => "error", "message" => "Invalid request"]);
			return;
		}
		$flavour = $this->model->selectWhereData('tbl_flavour', array('id' => $id, 'is_delete' => 1));
		if ($flavour) {
			echo json_encode(["status" => "success", "flavour" => $flavour]);
		} else {
			echo json_encode(["status" => "error", "message" => "Flavour not found"]);
		}
	}
	public function update_flavour()
	{
		$flavour_id = $this->input->post('edit_flavour_id');
		$flavour_name = $this->input->post('edit_flavour_name');
		$this->form_validation->set_rules('edit_flavour_name', 'Flavour Name', 'required|trim|regex_match[/^[a-zA-Z ]+$/]');
		if ($this->form_validation->run() == FALSE) {
			$response = [
				'status' => 'error',
				'edit_flavour_name_error' => form_error('edit_flavour_name'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_flavour', array('flavour_name' => $flavour_name, 'id !=' => $flavour_id));
			if ($count == 1) {
				$response = ["status" => "error", 'flavour_name_error' => "Flavour Already Exist"];
			} else {
				$update_data = ['flavour_name' => $flavour_name];

				$this->model->updateData('tbl_flavour', $update_data, ['id' => $flavour_id]);

				$response = ["status" => "success", "message" => "Flavour updated successfully"];
			}
		}
		echo json_encode($response);
	}
	public function delete_flavour()
	{
		$id = $this->input->post('id'); // Get the flavour ID from AJAX	
		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid flavour ID']);
			return;
		}
		$result = $this->model->updateData('tbl_flavour', ['is_delete' => '0'], ['id' => $id]); // Soft delete	
		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'Flavour deleted successfully']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to delete flavour']);
		}
	}
	public function add_bottle_size()
	{
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		} else {
			$this->load->view('inventory_manager/add_bottle_size');
		}
	}
	public function fetch_bottle_size()
	{
		$response = $this->model->selectWhereData('tbl_bottle_size', array('is_delete' => 1), "*", false, array('id', "DESC"));
		echo json_encode($response);
	}

	public function save_bottle_size()
	{
		$bottle_size = $this->input->post('bottle_size');
		$this->form_validation->set_rules('bottle_size', 'Bottle Size', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			// Return validation errors as JSON (No page reload)
			$response = [
				'status' => 'error',
				'bottle_size_error' => form_error('bottle_size'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_bottle_size', array('bottle_size' => $bottle_size, 'is_delete' => 1));
			if ($count == 1) {
				$response = ["status" => "error", 'bottle_size_error' => "Bottle Size Already Exist"];
			} else {
				$data = array(
					'bottle_size' => $bottle_size,
				);

				$this->model->insertData('tbl_bottle_size', $data);
				$response = ["status" => "success", "message" => "Bottle Size added successfully"];
			}
		}

		echo json_encode($response); // Return response as JSON
	}
	public function get_bottle_size_details()
	{
		$id = $this->input->post('id'); // Retrieve Bottle SIze ID from POST request

		if (!$id) {
			echo json_encode(["status" => "error", "message" => "Invalid request"]);
			return;
		}

		$bottle_size = $this->model->selectWhereData('tbl_bottle_size', array('id' => $id, 'is_delete' => 1));

		if ($bottle_size) {
			echo json_encode(["status" => "success", "bottle_size" => $bottle_size]);
		} else {
			echo json_encode(["status" => "error", "message" => "Bottle Size not found"]);
		}
	}

	public function update_bottle_size()
	{
		$bottle_size_id = $this->input->post('edit_bottle_size_id');
		$bottle_size = $this->input->post('edit_bottle_size');

		$this->form_validation->set_rules('edit_bottle_size', 'Bottle Size', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'status' => 'error',
				'edit_bottle_size_error' => form_error('edit_bottle_size'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_bottle_size', array('bottle_size' => $bottle_size, 'id !=' => $bottle_size_id));
			if ($count == 1) {
				$response = ["status" => "error", 'bottle_size_error' => "Bottle Size Already Exist"];
			} else {
				$update_data = ['bottle_size' => $bottle_size];

				$this->model->updateData('tbl_bottle_size', $update_data, ['id' => $bottle_size_id]);

				$response = ["status" => "success", "message" => "Bottle Size updated successfully"];
			}
		}

		echo json_encode($response);
	}
	public function delete_bottle_size()
	{
		$id = $this->input->post('id'); // Get the flavour ID from AJAX

		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid flavour ID']);
			return;
		}

		$result = $this->model->updateData('tbl_bottle_size', ['is_delete' => '0'], ['id' => $id]); // Soft delete

		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'Bottle Size deleted successfully']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to delete Bottle Size']);
		}
	}
	public function add_bottle_type()
	{
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		} else {
			$this->load->view('inventory_manager/add_bottle_type');
		}
	}
	public function fetch_bottle_type()
	{
		$response = $this->model->selectWhereData('tbl_bottle_type', array('is_delete' => 1), "*", false, array('id', "DESC"));
		echo json_encode($response);
	}

	public function save_bottle_type()
	{
		$bottle_type = $this->input->post('bottle_type');
		$this->form_validation->set_rules('bottle_type', 'Bottle Type', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			// Return validation errors as JSON (No page reload)
			$response = [
				'status' => 'error',
				'bottle_type_error' => form_error('bottle_type'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_bottle_type', array('bottle_type' => $bottle_type, 'is_delete' => 1));
			if ($count == 1) {
				$response = ["status" => "error", 'bottle_type_error' => "Bottle Type Already Exist"];
			} else {
				$data = array(
					'bottle_type' => $bottle_type,
				);

				$this->model->insertData('tbl_bottle_type', $data);
				$response = ["status" => "success", "message" => "Bottle Type added successfully"];
			}
		}

		echo json_encode($response); // Return response as JSON
	}
	public function get_bottle_type_details()
	{
		$id = $this->input->post('id'); // Retrieve Bottle SIze ID from POST request

		if (!$id) {
			echo json_encode(["status" => "error", "message" => "Invalid request"]);
			return;
		}

		$bottle_type = $this->model->selectWhereData('tbl_bottle_type', array('id' => $id, 'is_delete' => 1));

		if ($bottle_type) {
			echo json_encode(["status" => "success", "bottle_type" => $bottle_type]);
		} else {
			echo json_encode(["status" => "error", "message" => "Bottle Type not found"]);
		}
	}

	public function update_bottle_type()
	{
		$bottle_type_id = $this->input->post('edit_bottle_type_id');
		$bottle_type = $this->input->post('edit_bottle_type');

		$this->form_validation->set_rules('edit_bottle_type', 'Bottle Size', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'status' => 'error',
				'edit_bottle_type_error' => form_error('edit_bottle_type'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_bottle_type', array('bottle_type' => $bottle_type, 'id !=' => $bottle_type_id));
			if ($count == 1) {
				$response = ["status" => "error", 'bottle_type_error' => "Bottle Type Already Exist"];
			} else {
				$update_data = ['bottle_type' => $bottle_type];

				$this->model->updateData('tbl_bottle_type', $update_data, ['id' => $bottle_type_id]);

				$response = ["status" => "success", "message" => "Bottle Type updated successfully"];
			}
		}

		echo json_encode($response);
	}
	public function delete_bottle_type()
	{
		$id = $this->input->post('id'); // Get the flavour ID from AJAX

		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid flavour ID']);
			return;
		}

		$result = $this->model->updateData('tbl_bottle_type', ['is_delete' => '0'], ['id' => $id]); // Soft delete

		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'Bottle Type deleted successfully']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to delete Bottle Type']);
		}
	}
	public function add_sale_channel()
	{
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		} else {
			$this->load->view('inventory_manager/add_sales_channel');
		}
	}
	public function fetch_sale_channel()
	{
		$response = $this->model->selectWhereData('tbl_sale_channel', array('is_delete' => 1), "*", false, array('id', "DESC"));

		echo json_encode($response);
	}

	public function save_sale_channel()
	{
		$sale_channel = $this->input->post('sale_channel');
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
					'sale_channel' => $sale_channel,
				);

				$this->model->insertData('tbl_sale_channel', $data);
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
		$sale_channel_id = $this->input->post('edit_sale_channel_id');
		$sale_channel = $this->input->post('edit_sale_channel');

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

				$response = ["status" => "success", "message" => "Sale Channel updated successfully"];
			}
		}

		echo json_encode($response);
	}
	public function delete_sale_channel()
	{
		$id = $this->input->post('id'); // Get the flavour ID from AJAX

		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid flavour ID']);
			return;
		}

		$result = $this->model->updateData('tbl_sale_channel', ['is_delete' => '0'], ['id' => $id]); // Soft delete

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
			$this->load->view('admin/add_role_permission');
		}
	}
	public function add_product()
	{
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		} else {
			$response['product_types'] = $this->model->selectWhereData('tbl_product_types', array('is_delete' => 1), "*", false, array('id', "DESC"));
			// $response['attributes'] = $this->model->selectWhereData('tbl_attribute_master', array('is_delete' => 1), "*", false, array('id', "DESC"));
			// $response['attribute_values'] = $this->model->selectWhereData('tbl_attribute_values', array('is_delete' => 1), "*", false, array('id', "DESC"));
			$response['sale_channel'] = $this->model->selectWhereData('tbl_sale_channel', array('is_delete' => 1), "*", false, array('id', "DESC"));
			$response['stock_availability'] = $this->model->selectWhereData('tbl_stock_availability', array('is_delete' => 1), "*", false, array('id', "DESC"));

			$this->load->view('inventory_manager/product', $response);
		}
	}

	public function get_attribute_on_product_types_id()
	{
		$fk_product_types_id = $this->input->post('fk_product_types_id'); // Get the product type ID from POST request
		$response['data'] = $this->model->selectWhereData('tbl_attribute_master', array("fk_product_type_id" => $fk_product_types_id,'is_delete' => 1), "*", false, array('id', "DESC"));
		echo json_encode($response);
	}

	public function get_attribute_values_on_product_attributes_id()
	{
		$fk_product_attributes_id = $this->input->post('attribute_id'); // Get the product attribute ID from POST request
		$response['data'] = $this->model->selectWhereData('tbl_attribute_values', array("fk_attribute_id" => $fk_product_attributes_id,'is_delete' => 1), "*", false, array('id', "DESC"));
		echo json_encode($response);
	}

	public function get_sales_channel_on_channel_type()
	{
		$channel_type = $this->input->post('channel_type'); // Get the product attribute ID from POST request
		$response['data'] = $this->model->selectWhereData('tbl_sale_channel', array("channel_type" => $channel_type,'is_delete' => 1), "*", false, array('id', "DESC"));
		echo json_encode($response);
	}

	public function save_product()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$response = ['status' => 'error', 'errors' => []];
			
			// Get input values
			$product_name = $this->input->post('product_name');
			$product_sku_code = $this->input->post('product_sku_code');
			$batch_no = $this->input->post('batch_no');
			// $fk_flavour_id = $this->input->post('fk_flavour_id');
			// $fk_bottle_size_id = $this->input->post('fk_bottle_size_id');
			// $fk_bottle_type_id = $this->input->post('fk_bottle_type_id');
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

			// Validation Rules
			$this->form_validation->set_rules('product_name', 'Product Name', 'required|trim');
			$this->form_validation->set_rules('product_sku_code', 'Product SKU Code', 'required|trim|is_unique[tbl_product_type.product_sku_code]');
			// $this->form_validation->set_rules('fk_flavour_id', 'Flavor', 'required|trim');
			// $this->form_validation->set_rules('fk_bottle_size_id', 'Bottle Size', 'required|trim');
			// $this->form_validation->set_rules('fk_bottle_type_id', 'Bottle Type', 'required|trim');
			$this->form_validation->set_rules('description', 'Description', 'required|trim');
			$this->form_validation->set_rules('purchase_price', 'Purchase Price', 'required|trim');
			$this->form_validation->set_rules('mrp', 'MRP', 'required|trim');
			$this->form_validation->set_rules('selling_price', 'Selling Price', 'required|trim');
			$this->form_validation->set_rules('add_quantity', 'Stock Quantity', 'required|trim');
			$this->form_validation->set_rules('stock_availability', 'Stock Availability', 'required|trim');
			// $this->form_validation->set_rules('sale_channel', 'Sale Channel', 'required|trim');

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
			$count = $this->model->CountWhereRecord('tbl_product_master', array('product_name' => $product_name, 'is_delete' => 1));
			if ($count == 1) {
				$response = ["status" => "error", 'product_name_error' => "Already Exist"];
			} else {
				// Insert product data
				
				
				// $product_category = [
				// 	'fk_product_id' => $product_insert_id,
				// 	'fk_flavour_id' => $fk_flavour_id,
					
				// ];
				// $product_category_insert_id = $this->model->insertData('tbl_product_category', $product_category);

				$product_data = [
					'product_name' => $product_name,				
					// 'fk_product_category_id' => $product_category_insert_id,
					'product_sku_code' => $product_sku_code,
					// 'fk_bottle_size_id' => $fk_bottle_size_id,
					// 'fk_bottle_type_id' => $fk_bottle_type_id,
					// 'fk_sale_channel_id' => $sale_channel,
					'fk_stock_availability_id' => $stock_availability,
					'barcode' => $barcode,
					'batch_no' => $batch_no,
					'images' => implode(",", $product_images), // Store multiple images as JSON
					'description' => $description,
					'purchase_price' => $purchase_price,
					'MRP' => $mrp,
					'selling_price' => $selling_price,
				];
				//  print_r($product_data);
				$product_insert_id = $this->model->insertData('tbl_product_master', $product_data);

				

				foreach ($fk_product_attribute_id as $key => $attribute_id) {
					$product_attribute = [
						'fk_product_id' => $product_insert_id,
						'fk_product_types_id' => $fk_product_types_id,
						'fk_attribute_id' => $attribute_id,
						'fk_attribute_value_id' => $attributes_value[$key],
					];
					$this->model->insertData('tbl_product_attributes', $product_attribute);
				}
				// print_r($product_attributes);
				// Insert product attributes into the database
				
				$product_price = [
					'fk_product_id' => $product_insert_id,
					// 'fk_product_category_id' => $product_category_insert_id,
					// 'fk_product_type_id' => $product_type_insert_id,
					'purchase_price' => $purchase_price,
					'MRP' => $mrp,
					'selling_price' => $selling_price,
				];
				$this->model->insertData('tbl_product_price', $product_price);
				// print_r($product_price);
				$product_inventory = [
					'fk_product_id' => $product_insert_id,
					// 'fk_product_category_id' => $product_category_insert_id,
					// 'fk_product_type_id' => $product_type_insert_id,
					// 'fk_product_price_id' => $product_price_insert_id,
					'add_quantity' => $add_quantity,
					'total_quantity' => $add_quantity,
					'used_status' => 1
				];
				// print_r($product_inventory);
				$product_inventory_insert_id = $this->model->insertData('tbl_product_inventory', $product_inventory);
			}
			if ($product_inventory_insert_id) {
				echo json_encode(['status' => 'success', 'message' => 'Product added successfully!']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Failed to insert product!']);
			}
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

		echo json_encode(['data' => $structuredData]); // Send JSON response
	}
	public function view_product()
	{
		$id = $this->input->post('product_id');
		$data['product'] = $this->Product_model->get_product_by_id($id);
		echo json_encode($data);
	}

	public function update_product()
	{
		$this->load->library('form_validation');

		// Set validation rules
		$this->form_validation->set_rules('update_product_name', 'Product Name', 'required');
		$this->form_validation->set_rules('update_product_sku_code', 'Product SKU Code', 'required');
		$this->form_validation->set_rules('update_flavour_name', 'Flavor', 'required');
		$this->form_validation->set_rules('update_description', 'Description', 'required');
		$this->form_validation->set_rules('update_bottle_size', 'Bottle Size', 'required');
		$this->form_validation->set_rules('update_bottle_type', 'Bottle Type', 'required');
		$this->form_validation->set_rules('update_availability_status', 'Availability Status', 'required');
		$this->form_validation->set_rules('update_sale_channel', 'Sales Channel', 'required');
		$this->form_validation->set_rules('update_purchase_price', 'Purchase Price', 'required|numeric');
		$this->form_validation->set_rules('update_mrp', 'MRP', 'required|numeric');
		$this->form_validation->set_rules('update_selling_price', 'Selling Price', 'required|numeric');
		$this->form_validation->set_rules('update_total_quantity', 'Stock Quantity', 'required|numeric');

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

		$product_id = $this->input->post('update_product_id');
		$fk_product_category_id = $this->input->post('fk_product_category_id');
		$fk_product_type_id = $this->input->post('fk_product_type_id');
		$fk_product_price_id = $this->input->post('fk_product_price_id');

		// Handling image upload
		$existing_images = $this->input->post('update_product_image');
		$images = explode(',', $existing_images);

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
			'product_name' => $this->input->post('update_product_name'),
		);
		$this->model->updateData('tbl_product', $update_product, ['id' => $product_id]);

		$update_product_category = array(
			'fk_flavour_id' => $this->input->post('update_flavour_name'),
			'description' => $this->input->post('update_description'),
		);
		$this->model->updateData('tbl_product_category', $update_product_category, ['fk_product_id' => $product_id]);

		$update_product_type = array(
			'product_sku_code' => $this->input->post('update_product_sku_code'),
			'fk_bottle_size_id' => $this->input->post('update_bottle_size'),
			'fk_bottle_type_id' => $this->input->post('update_bottle_type'),
			'fk_sale_channel_id' => $this->input->post('update_sale_channel'),
			'fk_stock_availability_id' => $this->input->post('update_availability_status'),
			'barcode' => $this->input->post('update_barcode'),
			'batch_no' => $this->input->post('update_batch_no'),
			'images' => $imagess,
		);
		$this->model->updateData('tbl_product_type', $update_product_type, ['fk_product_id' => $product_id]);

		$update_product_price = array(
			'purchase_price' => $this->input->post('update_purchase_price'),
			'MRP' => $this->input->post('update_mrp'),
			'selling_price' => $this->input->post('update_selling_price'),
		);
		$this->model->updateData('tbl_product_price', $update_product_price, ['fk_product_id' => $product_id]);

		$total_quantity = $this->input->post('update_total_quantity');
		$add_new_quantity = $this->input->post('add_new_quantity');

		if (!empty($add_new_quantity)) {
			$update_product_inventory_status = array(
				'used_status' => 0,
				'is_delete' => '0'
			);
			$this->model->updateData('tbl_product_inventory', $update_product_inventory_status, ['fk_product_id' => $product_id]);

			$new_total_quantity = $total_quantity + $add_new_quantity;

			$update_product_inventory = array(
				'fk_product_id' => $product_id,
				'fk_product_category_id' => $fk_product_category_id,
				'fk_product_type_id' => $fk_product_type_id,
				'fk_product_price_id' => $fk_product_price_id,
				'add_quantity' => $add_new_quantity,
				'total_quantity' => $new_total_quantity,
				'used_status' => 1
			);

			$this->model->insertData('tbl_product_inventory', $update_product_inventory);
		} else {
			$get_last_quantity = $this->model->selectWhereData('tbl_product_inventory', ['fk_product_id' => $product_id, 'used_status' => 1], array('add_quantity', 'total_quantity'), true);
			$last_quantity = $get_last_quantity['total_quantity'];
			if ($last_quantity == $total_quantity) {
				$update_product_inventory = array(
					'add_quantity' => $get_last_quantity['add_quantity'],
					'total_quantity' => $total_quantity,
				);
			} else {
				$update_product_inventory = array(
					'add_quantity' => $total_quantity,
					'total_quantity' => $total_quantity,
				);
			}
			$this->model->updateData('tbl_product_inventory', $update_product_inventory, ['fk_product_id' => $product_id, 'used_status' => 1]);
		}
		echo json_encode(['status' => 'success', 'message' => 'Product updated successfully']);
	}

	public function delete_product()
	{
		$this->load->model('Product_model'); // Load the model

		$product_id = $this->input->post('product_id'); // Get product ID from AJAX request

		if (!empty($product_id)) {
			$update_product_status = $this->model->updateData('tbl_product', ['is_delete' => '0'], ['id' => $product_id]); // Soft delete
			$update_product_category_status = $this->model->updateData('tbl_product_category', ['is_delete' => '0'], ['fk_product_id' => $product_id]); // Soft delete
			$update_product_type_status = $this->model->updateData('tbl_product_type', ['is_delete' => '0'], ['fk_product_id' => $product_id]); // Soft delete
			$update_product_price_status = $this->model->updateData('tbl_product_price', ['is_delete' => '0'], ['fk_product_id' => $product_id]); // Soft delete
			$update_product_inventory_status = $this->model->updateData('tbl_product_inventory', ['is_delete' => '0'], ['fk_product_id' => $product_id]); // Soft delete

			if ($update_product_status) {
				echo json_encode(["success" => true, "message" => "Product deleted successfully."]);
			} else {
				echo json_encode(["success" => false, "message" => "Failed to delete product."]);
			}
		} else {
			echo json_encode(["success" => false, "message" => "Invalid product ID."]);
		}
	}

	public function order_details(){
		$data['products'] = $this->model->selectWhereData('tbl_product', array('is_delete' => 1), "*", false, array('id', "DESC"));
		$this->load->view('inventory_manager/order_details');
	}

	public function add_product_type()
	{
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		} else {
			$this->load->view('inventory_manager/add_product_type');
		}
	}
	public function fetch_product_type()
	{
		$response = $this->model->selectWhereData('tbl_product_types', array('is_delete' => 1), "*", false, array('id', "DESC"));
		echo json_encode($response);
	}
	public function save_product_types()
	{
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

				$response = ["status" => "success", "message" => "Product Type updated successfully"];
			}
		}
		echo json_encode($response);
	}
	public function delete_product_type()
	{
		$id = $this->input->post('id'); 
		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid product type ID']);
			return;
		}
		$result = $this->model->updateData('tbl_product_types', ['is_delete' => '0'], ['id' => $id]); // Soft delete	
		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'Product Type deleted successfully']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to delete Product Type']);
		}
	}

	public function add_product_attributes(){
		$response['product_types'] = $this->model->selectWhereData('tbl_product_types', array('is_delete' => 1), "*", false, array('id', "DESC"));
		$this->load->view('inventory_manager/add_product_attributes',$response);
	}
	public function get_product_attribute_detail()
	{
		
		$response['data'] = $this->Product_attribute_model->get_product_attribute_detail(); // Correctly access the model
		echo json_encode($response);
	}
	public function save_product_attributes()
	{
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
		$id = $this->input->post('edit_attribute_id');
		$attribute_name = $this->input->post('edit_attribute_name');
		$attribute_type = $this->input->post('edit_attribute_type');
		
		$count = $this->model->CountWhereRecord('tbl_attribute_master', array('attribute_name' => $attribute_name, 'id !=' => $id, 'is_delete' => 1));	
		if ($count == 1) {
			$response = ["status" => "error", 'attribute_type_error' => "Product Attribute Already Exist"];
			echo json_encode($response);
			return;
		}else{
			$updateData = [
				'attribute_name' => $attribute_name,
				'attribute_type' => $attribute_type
			];
				
			$updated = $this->model->updateData('tbl_attribute_master', $updateData, ['id' => $id]);
			// Check if update was successful
	
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

	public function add_product_attributes_value(){
		$response['product_attributes'] = $this->model->selectWhereData('tbl_attribute_master', array('is_delete' => 1), "*", false, array('id', "DESC"));
		// print_r($response['product_attributes']);die;
		$this->load->view('inventory_manager/add_product_attributes_value',$response);
	}
	public function get_product_attributes_value_detail()
	{
		$response['data'] = $this->Product_attribute_model->get_product_attributes_value_detail(); // Correctly access the model
		echo json_encode($response);
	}
	public function save_product_attributes_value()
	{
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
		$id = $this->input->post('edit_attribute_value_id');
		$attribute_value = $this->input->post('edit_attribute_value');
		
		$count = $this->model->CountWhereRecord('tbl_attribute_values', array('attribute_value' => $attribute_value, 'id !=' => $id, 'is_delete' => 1));	
		if ($count == 1) {
			$response = ["status" => "error", 'attribute_type_error' => "Product Attribute Value Already Exist"];
			echo json_encode($response);
			return;
		}else{
			$updateData = [
				'attribute_value' => $attribute_value,
			];
				
			$updated = $this->model->updateData('tbl_attribute_values', $updateData, ['id' => $id]);
			if ($updated) {
				echo json_encode(["status" => "success", "message" => "Attribute Value updated successfully."]);
			} else {
				echo json_encode(["status" => "error", "message" => "Failed to update attribute value."]);
			}
			
		}
	}
	public function delete_product_attributes_value()
	{
		$id = $this->input->post('id'); // Get the flavour ID from AJAX
		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid product Attribute Value ID']);
			return;
		}

		$result = $this->model->updateData('tbl_attribute_values', ['is_delete' => '0'], ['id' => $id]); // Soft delete

		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'Product Attribute Value deleted successfully']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to delete Product Attribute Value']);
		}
	}


	
}
