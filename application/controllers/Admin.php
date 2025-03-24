<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
				$response = ["status" => "error", 'bottle_size_error' => "Flavour Already Exist"];
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
	public function add_sale_channel(){
		$admin_session = $this->session->userdata('admin_session');
		if (!$admin_session) {
			redirect(base_url('common/index'));
		}else{
			$this->load->view('inventory_manager/add_sales_channel');
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
			$this->load->view('inventory_manager/product');
		}
	}
}
