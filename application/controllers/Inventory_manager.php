<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *"); // or use a specific domain instead of '*'
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
class Inventory_manager extends CI_Controller {

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
		$this->load->model('model');
		$this->load->library('form_validation'); 

		$inventory_session = $this->session->userdata('inventory_session'); // Check if admin session exists
		$role_id = $inventory_session['role_id'] ?? null;
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
		$inventory_session = $this->session->userdata('inventory_session'); // Check if admin session exists
		if (!$inventory_session) {
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
			$response['stock_product_names'] = array_column($stock_data, 'product_name');
			$response['stock_quantities'] = array_column($stock_data, 'total_quantity');
		// echo "<pre>";print_r($response);die;
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
			$this->load->view('inventory_manager/dashboard',$response);
		}
	}
	public function add_product_type()
	{
		$inventory_session = $this->session->userdata('inventory_session'); // Check if admin session exists
		if (!$inventory_session) {
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
		$inventory_session = $this->session->userdata('inventory_session'); // Check if admin session exists
		if (!$inventory_session) {
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
		$inventory_session = $this->session->userdata('inventory_session'); // Check if admin session exists
		if (!$inventory_session) {
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
	public function add_sale_channel()
	{
		$inventory_session = $this->session->userdata('inventory_session'); // Check if admin session exists
		if (!$inventory_session) {
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
	
	public function add_product()
	{
		$inventory_session = $this->session->userdata('inventory_session'); // Check if admin session exists
		if (!$inventory_session) {
			redirect(base_url('common/index'));
		} else {
			$response['product_types'] = $this->model->selectWhereData('tbl_product_types', array('is_delete' => 1), "*", false, array('id', "DESC"));
			$response['stock_availability'] = $this->model->selectWhereData('tbl_stock_availability', array('is_delete' => 1), "*", false, array('id', "DESC"));
			$response['permissions'] = $this->permissions; // Pass full permissions array
			$response['current_sidebar_id'] = 7; // Set the sidebar ID for the current view
			$this->load->view('product', $response);
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
				$product_data = [
					'product_name' => $product_name,
					'product_sku_code' => $product_sku_code,					
					'fk_stock_availability_id' => $stock_availability,
					'barcode' => $barcode,
					'batch_no' => $batch_no,
					'images' => implode(",", $product_images), // Store multiple images as JSON
					'description' => $description,
					'purchase_price' => $purchase_price,
					'MRP' => $mrp,
					'selling_price' => $selling_price,
				];
				$product_insert_id = $this->model->insertData('tbl_product_master', $product_data);

				foreach ($fk_product_attribute_id as $key => $attribute_id) {
					$product_attribute = [
						'fk_product_id' => $product_insert_id,
						'fk_product_types_id' => $fk_product_types_id,
						'fk_attribute_id' => $attribute_id,
						'fk_attribute_value_id' => $attributes_value[$key],
					];
					// Insert product attributes into the database
					$this->model->insertData('tbl_product_attributes', $product_attribute);
				}
				// Insert product price into the database			
				$product_price = [
					'fk_product_id' => $product_insert_id,
					'purchase_price' => $purchase_price,
					'MRP' => $mrp,
					'selling_price' => $selling_price,
				];
				$this->model->insertData('tbl_product_price', $product_price);
				$product_inventory = [
					'fk_product_id' => $product_insert_id,
					'add_quantity' => $add_quantity,
					'total_quantity' => $add_quantity,
					'used_status' => 1
				];
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

	public function update_product()
	{	
		
		$this->load->library('form_validation');

		// Set validation rules
		$this->form_validation->set_rules('update_product_name', 'Product Name', 'required');
		$this->form_validation->set_rules('update_product_sku_code', 'Product SKU Code', 'required');
		$this->form_validation->set_rules('update_description', 'Description', 'required');
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
		$fk_product_price_id = $this->input->post('fk_product_price_id');
		$product_name = $this->input->post('update_product_name');
		$description = $this->input->post('update_description');
		$product_sku_code = $this->input->post('update_product_sku_code');
		$channel_type = $this->input->post('update_channel_type');
		$sale_channel = $this->input->post('update_sale_channel');
		$availability_status = $this->input->post('update_availability_status');
		$barcode = $this->input->post('update_barcode');
		$batch_no = $this->input->post('update_batch_no');
		$purchase_price =  $this->input->post('update_purchase_price');
		$MRP = $this->input->post('update_mrp');
		$selling_price = $this->input->post('update_selling_price');
		$inventory_id = $this->input->post('update_inventory_id');


		$edit_fk_product_attribute_id = $this->input->post('edit_fk_product_attribute_id'); // Example: [3, 2, 1]
		$edit_attributes_value = $this->input->post('edit_attributes_value'); // Example: [19, 16, 1]
		$add_new_fk_product_attribute_id = $this->input->post('add_new_fk_product_attribute_id'); // Example: [3, 2, 1]
		$add_new_attributes_value = $this->input->post('add_new_attributes_value'); // Example: [19, 16, 1]
		$update_fk_product_types_id = $this->input->post('update_fk_product_types_id');
		$product_attribute_id = $this->input->post('attribute_id');

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
			'product_name' => $product_name,
			'description' => $description,
			'product_sku_code' => $product_sku_code,			
			'fk_stock_availability_id' =>$availability_status,
			'barcode' => $barcode,
			'batch_no' => $batch_no,
			'images' => $imagess,
			'purchase_price' => $purchase_price,
			'MRP' => $MRP,
			'selling_price' => $selling_price
		);
		$this->model->updateData('tbl_product_master', $update_product, ['id' => $product_id]);
		
		if(!empty($add_new_fk_product_attribute_id)){
			foreach ($add_new_fk_product_attribute_id as $key => $add_attribute_id_row) {
				$product_attribute = [
					'fk_product_id' => $product_id,
					'fk_product_types_id' => $update_fk_product_types_id,
					'fk_attribute_id' => $add_attribute_id_row,
					'fk_attribute_value_id' => $edit_attributes_value[$key],
				];
				$this->model->insertData('tbl_product_attributes', $product_attribute);
			}
		}
		if(!empty($edit_fk_product_attribute_id)){
			foreach ($edit_fk_product_attribute_id as $edit_fk_product_attribute_id_key => $edit_fk_product_attribute_id_row) {
				$update_product_attribute = [	
					'fk_attribute_id' => $edit_fk_product_attribute_id_row,
					'fk_attribute_value_id' => $edit_attributes_value[$edit_fk_product_attribute_id_key],
				];		
				 $this->model->updateData('tbl_product_attributes', $update_product_attribute, ['id'=>$product_attribute_id[$edit_fk_product_attribute_id_key],'fk_product_id' => $product_id,'fk_product_types_id' => $update_fk_product_types_id]);
			}
		}		
		$update_product_price = array(
			'purchase_price' => $purchase_price,
			'MRP' => $MRP,
			'selling_price' => $selling_price,
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
				'add_quantity' => $add_new_quantity,
				'total_quantity' => $new_total_quantity,
				'channel_type' => $channel_type,
				'fk_sale_channel_id' => $sale_channel,
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
					'channel_type' => $channel_type,
					'fk_sale_channel_id' => $sale_channel,
				);
			} else {
				$update_product_inventory = array(
					'add_quantity' => $total_quantity,
					'total_quantity' => $total_quantity,
					'channel_type' => $channel_type,
					'fk_sale_channel_id' => $sale_channel,
				);
			}
			$this->model->updateData('tbl_product_inventory', $update_product_inventory, ['id'=> $inventory_id,'fk_product_id' => $product_id, 'used_status' => 1]);
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
	public function sku_code(){
		$admin_session = $this->session->userdata('admin_session'); // Check if admin session exists
		if (!$admin_session) {
			redirect(base_url('common/index')); // Redirect to login page if session is not active
		} else {
			$response['permissions'] = $this->permissions; // Pass full permissions array
			$response['current_sidebar_id'] = 10; // Set the sidebar ID for the current view
			$this->load->view('sku_code',$response);
		}
	}
	public function get_sku_code_detail()
	{
		$response['data'] = $this->model->selectWhereData('tbl_sku_code_master',array('is_delete'=>'1'),'*',false,array('id','DESC')); // Correctly access the model
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
		}else{
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
			'Product Name', 'SKU Code', 'Stock Availability', 'Barcode', 'Batch Number',
			'Quantity', 'Expiry Date', 'Manufactured Date', 'Images', 'Description',
			'Purchase Price', 'MRP', 'Selling Price', 'Product Type',
			 'Channel Type', 'Sales Channel'
		];

        $sampleRow = [
            'Sample Product', 'SKU123', 'In Stock', '987654321', 'BATCH001', 50, '2025-12-31', '2025-01-01',
            'C:\Users\user\Downloads\Neem5.jpg,C:\Users\user\Downloads\Neem4.jpg', 'Sample description', 60, 120, 100, 'Honey', 'Online', 'Amazon'
        ];

        // Fetch attribute names and types for the product type
        $attributes = $this->model->selectWhereData(
            'tbl_attribute_master',
            ['fk_product_type_id' => $fk_product_types_id, 'is_delete' => 1],
            '*',
            false, // multiple rows
            ['id', 'ASC']
        );

        // Debugging: Check if attributes are fetched correctly
        // var_dump($attributes); die();

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

        // Clean output buffer before sending the file to prevent corrupt output
        ob_end_clean();

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');  // Direct output to the browser

        exit;
    }

	public function importProductExcel()
	{
		$this->load->library('upload');
		require_once FCPATH . 'vendor/autoload.php';

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
				$fk_product_types_id = $this->model->selectWhereData('tbl_product_types', ['product_type_name' => $row[13]], 'id', true);
				$fk_sale_channel_id = $this->model->selectWhereData('tbl_sale_channel', ['sale_channel' => $row[15]], 'id', true);
				$quantity = $row[5];

				 // Handle the images (comma-separated list of image paths)
				 $images = trim($row[8]); // Assuming images are in column 8

				 $image_urls = $this->handle_image_upload($images);
				
				if (!$existing_product) {
					$product_data = [
						'product_name' => $row[0],
						'product_sku_code' => $fk_sku_code_id['id'],
						'fk_stock_availability_id' => $fk_stock_availability_id['id'] ?? null,
						'barcode' => $row[3],
						'images' => $image_urls,
						'description' => $row[9],
						'fk_product_types_id' => $fk_product_types_id['id'] ?? null,
					];
					$product_id = $this->model->insertData('tbl_product_master', $product_data);
				} else {
					$product_id = $existing_product['id'];
				}

				$product_batch = [
					'fk_product_id' => $product_id,
					'batch_no' => $batch_no,
					'quantity' => $quantity,
					'expiry_date' => $row[6],
					'manufactured_date' => $row[7],
				];
				$batch_id = $this->model->insertData('tbl_product_batches', $product_batch);

				$product_price = [
					'fk_product_id' => $product_id,
					'fk_batch_id' => $batch_id,
					'purchase_price' => $row[10],
					'MRP' => $row[11],
					'selling_price' => $row[12],
				];
				$this->model->insertData('tbl_product_price', $product_price);

				$product_inventory = [
					'fk_product_id' => $product_id,
					'fk_batch_id' => $batch_id,
					'channel_type' => $row[14],
					'fk_sale_channel_id' => $fk_sale_channel_id['id'] ?? null,
					'add_quantity' => $quantity,
					'total_quantity' => $quantity,
					'used_status' => 1
				];
				$this->model->insertData('tbl_product_inventory', $product_inventory);

				// Handle dynamic attributes
				$headers = $rows[0];
				$dynamicHeaders = array_slice($headers, 16);

				foreach ($dynamicHeaders as $index => $attrName) {
					$attrName = trim($attrName);
					$attrValue = trim($row[16 + $index] ?? '');
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

				$this->output
					->set_content_type('application/json')
					->set_output(json_encode([
						'status' => "error",
						'message' => "Some rows were rejected. Please download the rejected file.",
						'download_url' => base_url('uploads/' . basename($rejectedFile))
					]));
				return;
			} else {
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
	private function handle_image_upload($images) {
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
	
}