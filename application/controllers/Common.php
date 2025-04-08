<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *"); // or use a specific domain instead of '*'
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

class Common extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('login');
	}
	public function registration(){
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$role_id = $this->input->post('fk_role_id');
	
		// Form Validation Rules
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[tbl_user.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		$this->form_validation->set_rules('fk_role_id', 'Role', 'required');
	
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('common/login');
		} else {
			$data = [
				'name' => $name,
				'email' => $email,
				'password' => decy_ency('encrypt',$password), 
				'fk_role_id' => $role_id
			];
	
			$response = $this->model->insertData('tbl_user', $data);
	
			if ($response) {
				echo json_encode(["status" => "success", "message" => "Registration successful!"]);
			} else {
				echo json_encode(["status" => "error", "message" => "Registration failed. Try again."]);
			}
		}
	}

	public function login_process() {
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
	
		if ($this->form_validation->run() == FALSE) {
			// Return validation errors as JSON
			$response = [
				'status' => 'error',
				'email_error' => form_error('email'),
				'password_error' => form_error('password')
			];
		} else {
			$email = $this->input->post('email');
			$password = $this->input->post('password');
	
			// Fetch user data
			$user = $this->model->selectWhereData("tbl_user", array("email" => $email));
	
			if ($user) {
				// Decrypt stored password for verification
				$stored_password = $user['password'];
				if ($stored_password == decy_ency('encrypt', $password)) { 
					
					// Assign session variable name based on role
					$session_name = '';
					switch ($user['fk_role_id']) {
						case 1:
							$session_name = 'admin_session';
							$redirect_url = base_url('admin');
							break;
						case 2:
							$session_name = 'inventory_session';
							$redirect_url = base_url('inventory_manager');
							break;
						case 3:
							$session_name = 'staff_session';
							$redirect_url = base_url('staff');
							break;
						default:
							$session_name = 'admin_session';
							$redirect_url = base_url('admin');
							break;
					}	
					// Set session data with role-based session name
					$session_data = [
						'user_id'   => $user['id'],
						'name'      => $user['name'],
						'email'     => $user['email'],
						'role_id'   => $user['fk_role_id'],
						'session_type' => $session_name // Store session type
					];
					
					$this->session->set_userdata($session_name, $session_data);

					// Save this session under multi_user_sessions
					// $multi_sessions = $this->session->userdata('multi_user_sessions') ?? [];
					// $multi_sessions[$session_name] = $session_data;
					// $this->session->set_userdata('multi_user_sessions', $multi_sessions);
	
					$response = ['status' => 'success', 'redirect' => $redirect_url];
				} else {
					$response = ['status' => 'error', 'login_error' => 'Invalid Email or Password'];
				}
			} else {
				$response = ['status' => 'error', 'login_error' => 'Invalid Email or Password'];
			}
		}
	
		echo json_encode($response);
	}
	
	
	public function logout() {
		// Destroy session data
		$this->session->sess_destroy(); // Completely destroy session
	
		// Redirect to login page
		redirect(base_url('common/index'));
	}
}