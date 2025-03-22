<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('admin/dashboard');
	}
	public function add_staff()
	{
		$this->load->view('admin/add_staff');
	}
	public function add_product()
	{
		$this->load->view('inventory_manager/product');
	}
	public function add_flavour(){
		$this->load->view('inventory_manager/add_flavour');
	}
	public function add_bottle_size(){
		$this->load->view('inventory_manager/add_bottle_size');
	}
	public function add_bottle_type(){
		$this->load->view('inventory_manager/add_bottle_type');
	}
	public function add_sale_channel(){
		$this->load->view('inventory_manager/add_sales_channel');
	}
}
