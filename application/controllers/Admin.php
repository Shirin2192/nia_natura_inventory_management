<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model'); // Load the Product_model
    }
	public function index()
	{
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		}else{
			$this->load->view('admin/dashboard');
		}
	}
	public function add_staff()
	{
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		}else{
			$this->load->view('admin/add_staff');
		}
	}
	
	public function add_flavour(){
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		}else{
			$this->load->view('inventory_manager/add_flavour');
		}
	}
	public function fetch_flavours() {
		$response=$this->model->selectWhereData('tbl_flavour',array('is_delete'=>1),"*",false,array('id',"DESC")); 
		echo json_encode($response);
    }

	public function save_flavour() {
		$flavour_name = $this->input->post('flavour_name');
		$this->form_validation->set_rules('flavour_name', 'Flavour Name', 'required|trim');
	
		if ($this->form_validation->run() == FALSE) {
			// Return validation errors as JSON (No page reload)
			$response = [
				'status' => 'error',
				'flavour_name_error' => form_error('flavour_name'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_flavour',array('flavour_name'=>$flavour_name));
			if($count == 1){
				$response = ["status" => "error", 'flavour_name_error' => "Flavour Already Exist"];
			}else{
				$data = array(
					'flavour_name' => $flavour_name,
				);
		
				$this->model->insertData('tbl_flavour', $data);
				$response = ["status" => "success", "message" => "Flavour added successfully"];
			}
			
		}
	
		echo json_encode($response); // Return response as JSON
	}
	public function get_flavour_details() {
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

	public function update_flavour() {
		$flavour_id = $this->input->post('edit_flavour_id');
		$flavour_name = $this->input->post('edit_flavour_name');
	
		$this->form_validation->set_rules('edit_flavour_name', 'Flavour Name', 'required|trim');
	
		if ($this->form_validation->run() == FALSE) {
			$response = [
				'status' => 'error',
				'edit_flavour_name_error' => form_error('edit_flavour_name'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_flavour',array('flavour_name'=>$flavour_name,'id !=' =>$flavour_id));
			if($count == 1){
				$response = ["status" => "error", 'flavour_name_error' => "Flavour Already Exist"];
			}else{
				$update_data = ['flavour_name' => $flavour_name];
		
				$this->model->updateData('tbl_flavour', $update_data, ['id' => $flavour_id]);
		
				$response = ["status" => "success", "message" => "Flavour updated successfully"];
			}
		}
	
		echo json_encode($response);
	}
	public function delete_flavour() {
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
	
	public function add_bottle_size(){
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		}else{
			$this->load->view('inventory_manager/add_bottle_size');
		}
	}
	public function fetch_bottle_size() {
		$response=$this->model->selectWhereData('tbl_bottle_size',array('is_delete'=>1),"*",false,array('id',"DESC")); 
		echo json_encode($response);
    }

	public function save_bottle_size() {
		$bottle_size = $this->input->post('bottle_size');
		$this->form_validation->set_rules('bottle_size', 'Bottle Size', 'required|trim');
	
		if ($this->form_validation->run() == FALSE) {
			// Return validation errors as JSON (No page reload)
			$response = [
				'status' => 'error',
				'bottle_size_error' => form_error('bottle_size'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_bottle_size',array('bottle_size'=>$bottle_size));
			if($count == 1){
				$response = ["status" => "error", 'bottle_size_error' => "Bottle Size Already Exist"];
			}else{
				$data = array(
					'bottle_size' => $bottle_size,
				);
		
				$this->model->insertData('tbl_bottle_size', $data);
				$response = ["status" => "success", "message" => "Bottle Size added successfully"];
			}
			
		}
	
		echo json_encode($response); // Return response as JSON
	}
	public function get_bottle_size_details() {
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

	public function update_bottle_size() {
		$bottle_size_id = $this->input->post('edit_bottle_size_id');
		$bottle_size = $this->input->post('edit_bottle_size');
	
		$this->form_validation->set_rules('edit_bottle_size', 'Bottle Size', 'required|trim');
	
		if ($this->form_validation->run() == FALSE) {
			$response = [
				'status' => 'error',
				'edit_bottle_size_error' => form_error('edit_bottle_size'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_bottle_size',array('bottle_size'=>$bottle_size,'id !=' =>$bottle_size_id));
			if($count == 1){
				$response = ["status" => "error", 'bottle_size_error' => "Bottle Size Already Exist"];
			}else{
				$update_data = ['bottle_size' => $bottle_size];
		
				$this->model->updateData('tbl_bottle_size', $update_data, ['id' => $bottle_size_id]);
		
				$response = ["status" => "success", "message" => "Bottle Size updated successfully"];
			}
		}
	
		echo json_encode($response);
	}
	public function delete_bottle_size() {
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
	public function add_bottle_type(){
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		}else{	
			$this->load->view('inventory_manager/add_bottle_type');
		}
	}
	public function fetch_bottle_type() {
		$response=$this->model->selectWhereData('tbl_bottle_type',array('is_delete'=>1),"*",false,array('id',"DESC")); 
		echo json_encode($response);
    }

	public function save_bottle_type() {
		$bottle_type = $this->input->post('bottle_type');
		$this->form_validation->set_rules('bottle_type', 'Bottle Type', 'required|trim');
	
		if ($this->form_validation->run() == FALSE) {
			// Return validation errors as JSON (No page reload)
			$response = [
				'status' => 'error',
				'bottle_type_error' => form_error('bottle_type'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_bottle_type',array('bottle_type'=>$bottle_type));
			if($count == 1){
				$response = ["status" => "error", 'bottle_type_error' => "Bottle Type Already Exist"];
			}else{
				$data = array(
					'bottle_type' => $bottle_type,
				);
		
				$this->model->insertData('tbl_bottle_type', $data);
				$response = ["status" => "success", "message" => "Bottle Type added successfully"];
			}
			
		}
	
		echo json_encode($response); // Return response as JSON
	}
	public function get_bottle_type_details() {
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

	public function update_bottle_type() {
		$bottle_type_id = $this->input->post('edit_bottle_type_id');
		$bottle_type = $this->input->post('edit_bottle_type');
	
		$this->form_validation->set_rules('edit_bottle_type', 'Bottle Size', 'required|trim');
	
		if ($this->form_validation->run() == FALSE) {
			$response = [
				'status' => 'error',
				'edit_bottle_type_error' => form_error('edit_bottle_type'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_bottle_type',array('bottle_type'=>$bottle_type,'id !=' =>$bottle_type_id));
			if($count == 1){
				$response = ["status" => "error", 'bottle_type_error' => "Bottle Type Already Exist"];
			}else{
				$update_data = ['bottle_type' => $bottle_type];
		
				$this->model->updateData('tbl_bottle_type', $update_data, ['id' => $bottle_type_id]);
		
				$response = ["status" => "success", "message" => "Bottle Type updated successfully"];
			}
		}
	
		echo json_encode($response);
	}
	public function delete_bottle_type() {
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
	public function add_sale_channel(){
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		}else{
			$this->load->view('inventory_manager/add_sales_channel');
		}
	}
	public function fetch_sale_channel() {
		$response=$this->model->selectWhereData('tbl_sale_channel',array('is_delete'=>1),"*",false,array('id',"DESC")); 
		
		echo json_encode($response);
    }

	public function save_sale_channel() {
		$sale_channel = $this->input->post('sale_channel');
		$this->form_validation->set_rules('sale_channel', 'Sale Channel', 'required|trim');
	
		if ($this->form_validation->run() == FALSE) {
			// Return validation errors as JSON (No page reload)
			$response = [
				'status' => 'error',
				'sale_channel_error' => form_error('sale_channel'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_sale_channel',array('sale_channel'=>$sale_channel));
			if($count == 1){
				$response = ["status" => "error", 'sale_channel_error' => "Sale Channel Already Exist"];
			}else{
				$data = array(
					'sale_channel' => $sale_channel,
				);
		
				$this->model->insertData('tbl_sale_channel', $data);
				$response = ["status" => "success", "message" => "Sale Channel added successfully"];
			}
			
		}
	
		echo json_encode($response); // Return response as JSON
	}
	public function get_sale_channel_details() {
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

	public function update_sale_channel() {
		$sale_channel_id = $this->input->post('edit_sale_channel_id');
		$sale_channel = $this->input->post('edit_sale_channel');
	
		$this->form_validation->set_rules('edit_sale_channel', 'Sale Channel', 'required|trim');
	
		if ($this->form_validation->run() == FALSE) {
			$response = [
				'status' => 'error',
				'edit_sale_channel_error' => form_error('edit_sale_channel'),
			];
		} else {
			$count = $this->model->CountWhereRecord('tbl_sale_channel',array('sale_channel'=>$sale_channel,'id !=' =>$sale_channel_id));
			if($count == 1){
				$response = ["status" => "error", 'sale_channel_error' => "Bottle Type Already Exist"];
			}else{
				$update_data = ['sale_channel' => $sale_channel];
		
				$this->model->updateData('tbl_sale_channel', $update_data, ['id' => $sale_channel_id]);
		
				$response = ["status" => "success", "message" => "Sale Channel updated successfully"];
			}
		}
	
		echo json_encode($response);
	}
	public function delete_sale_channel() {
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
	public function add_role_permission(){
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		}else{
			$this->load->view('admin/add_role_permission');
		}
	}
	public function add_product()
	{
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		}else{
			$response['flavour']=$this->model->selectWhereData('tbl_flavour',array('is_delete'=>1),"*",false,array('id',"DESC")); 
			$response['bottle_size']=$this->model->selectWhereData('tbl_bottle_size',array('is_delete'=>1),"*",false,array('id',"DESC")); 
			$response['bottle_type']=$this->model->selectWhereData('tbl_bottle_type',array('is_delete'=>1),"*",false,array('id',"DESC")); 
			$response['sale_channel']=$this->model->selectWhereData('tbl_sale_channel',array('is_delete'=>1),"*",false,array('id',"DESC")); 
			$response['stock_availability']=$this->model->selectWhereData('tbl_stock_availability',array('is_delete'=>1),"*",false,array('id',"DESC")); 
			
			$this->load->view('inventory_manager/product',$response);
		}
	}

	public function save_product() {
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$response = ['status' => 'error', 'errors' => []];
	
			// Get input values
			$product_name = $this->input->post('product_name');
			$product_sku_code = $this->input->post('product_sku_code');
			$batch_no = $this->input->post('batch_no');
			$fk_flavour_id = $this->input->post('fk_flavour_id');
			$fk_bottle_size_id = $this->input->post('fk_bottle_size_id');
			$fk_bottle_type_id = $this->input->post('fk_bottle_type_id');
			$barcode = $this->input->post('barcode');
			$description = $this->input->post('description');
			$purchase_price = $this->input->post('purchase_price');
			$mrp = $this->input->post('mrp');
			$selling_price = $this->input->post('selling_price');
			$add_quantity = $this->input->post('add_quantity');
			$stock_availability = $this->input->post('stock_availability');
			$sale_channel = $this->input->post('sale_channel');
	
			// Validation Rules
			$this->form_validation->set_rules('product_name', 'Product Name', 'required|trim');
			$this->form_validation->set_rules('product_sku_code', 'Product SKU Code', 'required|trim|is_unique[tbl_product_type.product_sku_code]');
			$this->form_validation->set_rules('fk_flavour_id', 'Flavor', 'required|trim');
			$this->form_validation->set_rules('fk_bottle_size_id', 'Bottle Size', 'required|trim');
			$this->form_validation->set_rules('fk_bottle_type_id', 'Bottle Type', 'required|trim');
			$this->form_validation->set_rules('description', 'Description', 'required|trim');
			$this->form_validation->set_rules('purchase_price', 'Purchase Price', 'required|trim');
			$this->form_validation->set_rules('mrp', 'MRP', 'required|trim');
			$this->form_validation->set_rules('selling_price', 'Selling Price', 'required|trim');
			$this->form_validation->set_rules('add_quantity', 'Stock Quantity', 'required|trim');
			$this->form_validation->set_rules('stock_availability', 'Stock Availability', 'required|trim');
			$this->form_validation->set_rules('sale_channel', 'Sale Channel', 'required|trim');
	
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
			$count = $this->model->CountWhereRecord('tbl_product',array('product_name'=>$product_name));
			if($count == 1){
				$response = ["status" => "error", 'product_name_error' => "Sale Channel Already Exist"];
			}else{
					// Insert product data
					$product_data = ['product_name' => $product_name];
					$product_insert_id = $this->model->insertData('tbl_product', $product_data);
						
					$product_category = [
						'fk_product_id' => $product_insert_id,
						'fk_flavour_id' => $fk_flavour_id,
						'description' => $description,
					];
					$product_category_insert_id = $this->model->insertData('tbl_product_category', $product_category);
			
					$product_type = [
						'fk_product_id' => $product_insert_id,
						'fk_product_category_id' => $product_category_insert_id,
						'product_sku_code' => $product_sku_code,
						'fk_bottle_size_id' => $fk_bottle_size_id,
						'fk_bottle_type_id' => $fk_bottle_type_id,
						'fk_sale_channel_id' => $sale_channel,
						'fk_stock_availability_id' => $stock_availability,
						'barcode' => $barcode,
						'batch_no' => $batch_no,
						'images' => implode(",",$product_images), // Store multiple images as JSON
					];
					$product_type_insert_id = $this->model->insertData('tbl_product_type', $product_type);
			
					$product_price = [
						'fk_product_id' => $product_insert_id,
						'fk_product_category_id' => $product_category_insert_id,
						'fk_product_type_id' => $product_type_insert_id,
						'purchase_price' => $purchase_price,
						'MRP' => $mrp,
						'selling_price' => $selling_price,
					];
					$product_price_insert_id = $this->model->insertData('tbl_product_price', $product_price);
			
					$product_inventory = [
						'fk_product_id' => $product_insert_id,
						'fk_product_category_id' => $product_category_insert_id,
						'fk_product_type_id' => $product_type_insert_id,
						'fk_product_price_id' => $product_price_insert_id,
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
        $data['products'] = $this->Product_model->get_product_detail(); // Fetch product details
        echo json_encode($data); // Return data as JSON response
    }
	public function view_product() {
		$id = $this->input->post('product_id');
        $data['product'] = $this->Product_model->get_product_by_id($id);
		// print_r($data);die;
        echo json_encode($data);
    }

}