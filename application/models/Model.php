<?php
class Model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	function getData($tableName, $where_data=array(), $where_in = array(),$fields='*'){
        try{
			if (isset($tableName) && isset($where_data)) {
				
				$this->db->trans_start();
				$this->db->select($fields);
				if(!empty($where_data)){
					$this->db->where($where_data);
				}
				if(!empty($where_in)){
					$this->db->where_in($where_in['field'],$where_in['in_array']);
				}
				$query = $this->db->get($tableName);
                               
				$this->db->trans_complete();
				if ($query->num_rows() > 0){
					$rows = $query->result_array();
					return $rows;
				}else{
					return false;
				} 
			}else{
				return false;
			}
		} catch (Exception $e){
			return false;
		}
	}

	function getDataLimit($tableName, $where_data, $limit='', $start=''){
		//echo '<pre>'; print_r($where_data); 
		//echo $tableName.' - '.$limit .' - '. $start;
		try{
			if (isset($tableName) && isset($where_data)) {
				
				$this->db->trans_start();
				$query = $this->db->get_where($tableName, $where_data, $limit, $start);
				
				$this->db->trans_complete();
				if ($query->num_rows() > 0){
					$rows = $query->result_array();
					return $rows;
				}else{
					return false;
				} 
			}else{
				return false;
			}
		} catch (Exception $e){
			return false;
		}
	}

	function get_like_data($tbl,$clm,$keyword,$fields='*',$row = true)
	{
		$this->db->select($fields);
		$this->db->from($tbl);
		/*$this->db->where($wh_data);*/
		$this->db->like($clm, $keyword);
		$query = $this->db->get($tbl);
		if($row)
		$rows = $query->row_array();
		else				
		$rows = $query->result_array();
		return $rows;
	}

    function countrecord($tablename)
    {
    	$query = $this->db->get($tablename);
    	$count = $query->num_rows(); 
    	return $count;
    }

    function CountWhereInRecord($tableName,$where_data)
    {
    	$query = $this->db->get_where($tableName, $where_data);
    	$count = $query->num_rows(); 
    	return $count;
    }

    function CountWhereRecord($tableName, $where_data=array(), $where_in = array(),$fields='*')
	{
		$this->db->trans_start();
		$this->db->select($fields);
		if(!empty($where_data)){
		$this->db->where($where_data);
		}
		if(!empty($where_in)){
			$this->db->where_in($where_in['field'],$where_in['in_array']);
		}
		$query = $this->db->get($tableName);
    	$count = $query->num_rows();
    	$this->db->trans_complete();
    	return $count;
    }
   	
   	function count_by_query($sql){
   		$query = $this->db->query($sql);
      	$count = $query->num_rows(); 
    	return $count;
   	}

	function insertData($tableName, $array_data){
		try{
			if (isset($tableName) && isset($array_data)) {
				
				$this->db->trans_start();

				$this->db->insert($tableName, $array_data);
				$globals_id = $this->db->insert_id();

				$this->db->trans_complete();

				return $globals_id;

			}else{
				return false;
			}
		} catch (Exception $e){
			return false;
		}
	}

	function getAllData($tableName){
		if (isset($tableName)) {
			
			$this->db->trans_start();	
			$query = $this->db->get_where($tableName);
			//$query = $this->db->get($tableName);
			$this->db->trans_complete();
			
			if ($query->num_rows() > 0){
				$rows = $query->result_array();
				return $rows;
			}else{
				return false;
			} 
		}else{
			return false;
		}
	}

	
	function selectData($tableName,$fields='*',$row = true,$order_by=''){
		if (isset($tableName)) {
			
			$this->db->trans_start();	
			$this->db->select($fields);
			if (!empty($order_by)) {
				$this->db->order_by(@$order_by[0],@$order_by[1]);
			}
			$query = $this->db->get($tableName);
			$this->db->trans_complete();
			
			if ($query->num_rows() > 0){
				if($row)
				$rows = $query->row_array();
				else
				$rows = $query->result_array();
				return $rows;
			}else{
				return false;
			} 
			
		}else{
			return false;
		}
	}

	function selectWhereData($tableName,$whereData,$fields='*',$row = true,$order_by='',$group_by=''){
		if (isset($tableName)&&isset($whereData)) {
			$this->db->trans_start();	
			$this->db->select($fields);
			$this->db->where($whereData);
			if (!empty($order_by)) {
				$this->db->order_by(@$order_by[0],@$order_by[1]);
			}
			if (!empty($group_by)) {
				$this->db->group_by(@$group_by);
			}
			// $this->db->limit(2);
			$query = $this->db->get($tableName);
			$this->db->trans_complete();
			
			if ($query->num_rows() > 0){
				if($row)
				$rows = $query->row_array();
				else				
				$rows = $query->result_array();
				return $rows;
			}else{
				return false;
			} 
			
		}else{
			return false;
		}
	}
	function selectDataNotIn($tableName,$selectField,$notInClmName,$notInData)
	{		
		if (isset($tableName)) {
			
			$this->db->trans_start();	
			$this->db->select($selectField);
			$this->db->where_not_in($notInClmName, $notInData);
			$query = $this->db->get($tableName);
			$this->db->trans_complete();
			
			if ($query->num_rows() > 0){
				$rows = $query->result_array();
				return $rows;
			}else{
				return false;
			} 
			
		}else{
			return false;
		}
	}

	function getReportData($tableName, $whereData ){
		//echo $tableName;print_r($whereData);
		if (isset($tableName) && isset($whereData)) {
			$this->db->trans_start();
			$query = $this->db->get_where($tableName, $whereData);
			$this->db->trans_complete();
			
			if ($query->num_rows() > 0){
				$rows = $query->result_array();
				return $rows;
			}else{
				return false;
			} 
			
		}else{
			return false;
		}
	}
	
	function getRowData($tableName, $whereData ){
		//echo $tableName;print_r($whereData);
		if (isset($tableName) && isset($whereData)) {
			$this->db->trans_start();
			$query = $this->db->get_where($tableName, $whereData);
			$this->db->trans_complete();
			
			if ($query->num_rows() > 0){
				$row = $query->row_array();
				return $row;
			}else{
				return false;
			} 
			
		}else{
			return false;
		}
	}

	function getDataOrderBy($tableName, $whereData, $order_by, $ASC_DESC='ASC'){
		if (isset($tableName) && isset($whereData)) {
			
			$this->db->trans_start();	
			//$query = $this->db->get_where($tableName, $whereData)->order_by($order_by, $ASC_DESC);

			$this->db->from($tableName);
			$this->db->where($whereData);
			$this->db->order_by($order_by, $ASC_DESC);
			$query = $this->db->get(); 
			
			$this->db->trans_complete();
			
			if ($query->num_rows() > 0){
				$rows = $query->result_array();
				return $rows;
			}else{
				return false;
			} 
			
		}else{
			return false;
		}
	}

	function getReportDataWhereNotIn($tableName, $whereData, $whereColumn, $WhereInValues){
		$del_clm = array('is_deleted' => '-1' ); //-1 : Record not deleted
		$whereData = array_merge($del_clm, $whereData);
		
		$this->db->trans_start();	
		
		$this->db->from($tableName);
		$this->db->where($whereData);
		$this->db->where_not_in($whereColumn, $WhereInValues);
		
		$query = $this->db->get(); 
		
		$this->db->trans_complete();
		
		if ($query->num_rows() > 0){
			$rows = $query->result_array();
			return $rows;
		}else{
			return false;
		} 	
	}

	function getDataWhereIn($tableName, $whereData, $whereColumn, $WhereInValues){
		$this->db->trans_start();	
		
		$this->db->from($tableName);
		$this->db->where($whereData);
		$this->db->where_in($whereColumn, $WhereInValues);
		
		$query = $this->db->get(); 
		
		$this->db->trans_complete();
		
		if ($query->num_rows() > 0){
			$rows = $query->result_array();
			return $rows;
		}else{
			return false;
		} 	
	}
	/*
	function updateReportData($tableName, $report_data, $where){}
		$tableName   => Tablename
		$report_data => array format data which has to set
		$where => array format data for the column on which basis it will be updated.
			$where can be like "id = 4" for single condition
			$where can be like array('id' => 1005, 'sr_no'=> '10') for multiple condition
	*/

	function updateData($tableName, $updateData, $where){		
		$this->db->trans_start();	
		$query = $this->db->update($tableName, $updateData, $where);
		$this->db->trans_complete();
		$result = $query ? 1 : 0;
		return $result;
	}

	function deleteData($tableName,$updateData,$whereData){
		if(isset($tableName) && isset($updateData) &&isset($whereData)){
			$this->db->trans_start();	
			$query = $this->db->update($tableName, $updateData, $whereData);
			$this->db->trans_complete();
			if($this->db->affected_rows() > 0){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}		
	}

	function getSqlData($sql){
		
       	$query = $this->db->query($sql);
      	$result=$query->result_array();
      	return $result;
	}        
	
	function tableInsert($tablename,$val)
    {
    	
        $this->db->insert($tablename, $val);
        if($this->db->affected_rows() == 1){
        	$global_id=$this->db->insert_id();
         	return $global_id;
        } else {
         	return False;
        }
    }

    function truncate_table($sql){
    	$this->db->from($sql); 
		$this->db->truncate(); 
    }

    function wallet_balance($user_id=''){
        //calculate user's wallet amount and update it
        $str_debit = "SELECT SUM(wallet_amount) as debit_total FROM wallet_txn WHERE status='1' AND txn_type='2' AND user_id='".$user_id."'";
        $debit_data = $this->model->getSqlData($str_debit);
        $debit_total = (isset($debit_data) && !empty($debit_data)) ? $debit_data[0]['debit_total'] : '0';

        $str_credit = "SELECT SUM(wallet_amount) as credit_total FROM wallet_txn WHERE status='1' AND txn_type='1' AND user_id='".$user_id."'";
        $credit_data = $this->model->getSqlData($str_credit);
        $credit_total = (isset($credit_data) && !empty($credit_data)) ? $credit_data[0]['credit_total'] : '0';

        $total_wallet_balance = $credit_total-$debit_total;
        return $total_wallet_balance;
    }

    function generate_next_id($tablename,$field,$series='req'){
    	$query = $this->db->select($field)
    	->from($tablename)
    	->order_by($field,'DESC')
    	->like($field,$series)
    	->limit(1)
    	->get();
    	$data = $query->first_row();

    	if(empty($data)){
    		return $series.'000001';
    	}
    	else{
    		$last_id = $data->$field;
    		$number = substr($last_id,strlen($series));
    		$number = (int)$number + 1;
    		$next_id = $series.sprintf('%06s',$number);
    		return $next_id;
    	}
    }

    function generate_next_id2($last_id,$series= ''){
		$number = substr($last_id,strlen($series));
		$number = (int)$number + 1;
		$next_id = $series.sprintf('%06s',$number);
		return $next_id;
    }

    function isExist($tablename,$where,$fieldname='*'){
    	$query = $this->db->select($fieldname)
    	->from($tablename)
    	->where($where)
    	->get();
    	$num_rows = $query->num_rows();
    	if($num_rows > 0){
    		return true;
    	}
    	else{
    		return false;
    	}
    }

    function getValue($tablename,$fieldname,$where =array()){
    	$query = $this->db->select($fieldname)
    	->from($tablename)
    	->where($where)
    	->get();
    	$data = $query->first_row();
    	$data = (array)$data;
    	return isset($data[$fieldname])?$data[$fieldname]:'';
    }

    function getValue2($tablename,$fieldname,$where =array()){
    	$query = $this->db->select($fieldname)
    	->from($tablename)
    	->where($where)
    	->get();
    	$data = $query->result_array();
    	$multipleValue = [];
    	foreach ($data as $key => $value) {
    		$multipleValue[] = $value[$fieldname];
    	}
    	return $multipleValue;
    }

	public function changeStatus($tableName,$where)
	{
		$status=$this->getValue($tableName,'status',$where);
		if ($status==1) {
			$update_status=0;
		} else {
			$update_status=1;
		}
		$updateData=array('status'=>$update_status);
		$this->db->trans_start();	
		$query = $this->db->update($tableName, $updateData, $where);
		$this->db->trans_complete();

		$result = $query ? 1 : 0;
		return $result;
	}

	public function direct_delete($table_name,$where)
	{
		$this->db->delete($table_name,$where); 
        return TRUE;
	}
	
	public function changeCmsStatus($tableName,$where)
	{
		$status=$this->getValue($tableName,'cms_admin_status',$where);
		if ($status==1) {
			$update_status=0;
		} else {
			$update_status=1;
		}
		$updateData=array('cms_admin_status'=>$update_status);
		$this->db->trans_start();	
		$query = $this->db->update($tableName, $updateData, $where);
		$this->db->trans_complete();

		$result = $query ? 1 : 0;
		return $result;
	}

	public function get_org_count($where_in_condition='')
    {        
        if(!empty($where_in_condition)){   
            $this->db->select('count(id) as org_count');
            $this->db->from('tbl_users');           
            $this->db->where_in('tbl_users.fkuser_lic_id',$where_in_condition);           
            $this->db->where('tbl_users.fk_user_type',4);
            $this->db->where('tbl_users.del_status','Active');       
            $query = $this->db->get();
            return $query->result_array();
        } else {
            return false;
        }
	} 
	
	public function get_resp_count($where_in_condition='')
    {        
        if(!empty($where_in_condition)){   
            $this->db->select('count(tbl_orgclient.id) as resp_count');
			$this->db->from('tbl_orgclient'); 
			$this->db->join('tbl_users','tbl_users.fk_orgclient=tbl_orgclient.id');           
            $this->db->where_in('tbl_orgclient.fkuser_l1_id',$where_in_condition);     
			$this->db->where('tbl_orgclient.del_status','Active');    
			$this->db->where('tbl_users.del_status','Active'); 
            $query = $this->db->get();
            return $query->result_array();
        } else {
            return false;
        }
	}

	public function get_org_resp_count($where_in_condition='')
    {        
        if(!empty($where_in_condition)){   
            $this->db->select('count(tbl_orgclient.id) as resp_count');
			$this->db->from('tbl_orgclient'); 
			$this->db->join('tbl_users','tbl_users.fk_orgclient=tbl_orgclient.id');           
            $this->db->where_in('tbl_orgclient.fk_userid_org',$where_in_condition);     
			$this->db->where('tbl_orgclient.del_status','Active');    
			$this->db->where('tbl_users.del_status','Active'); 
            $query = $this->db->get();
            return $query->result_array();
        } else {
            return false;
        }
	}

	public function get_org_group_count($where_in_condition='')
    {        
		if(!empty($where_in_condition)){   
            $this->db->select('count(id) as group_count');
            $this->db->from('tbl_master_group');           
            $this->db->where('fk_tbl_user',$where_in_condition);        
            $this->db->where('status','Active');       
            $query = $this->db->get();
            return $query->result_array();
        } else {
            return false;
        }
	}
	
	public function get_orgresp_count($where_in_condition='')
    {        
        if(!empty($where_in_condition)){   
            $this->db->select('count(tbl_orgclient.id) as resp_count');
			$this->db->from('tbl_orgclient'); 
			$this->db->join('tbl_users','tbl_users.fk_orgclient=tbl_orgclient.id');           
            $this->db->where_in('tbl_orgclient.fk_userid_org',$where_in_condition);     
			$this->db->where('tbl_orgclient.del_status','Active');    
			$this->db->where('tbl_users.del_status','Active'); 
            $query = $this->db->get();
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_org($where_in_condition='')
    {        
        if(!empty($where_in_condition)){   
            $this->db->select('id,fname,lname,fk_user_type');
            $this->db->from('tbl_users');           
            $this->db->where_in('tbl_users.fkuser_lic_id',$where_in_condition);           
            $this->db->where('tbl_users.fk_user_type',4);
            $this->db->where('tbl_users.del_status','Active');       
            $query = $this->db->get();
            return $query->result_array();
        } else {
            return false;
        }
	}  

	public function get_l1_used_fuel($user_id='')
    {        
        if(!empty($user_id)){   
            $this->db->select('count(id) as used_fuel');
            $this->db->from(' tbl_fuel_purchase_info');           
            $this->db->where('l1_id',$user_id);     
            $this->db->where('used_status','Inactive');       
            $query = $this->db->get();
            return $query->result_array();
        } else {
            return false;
        }
	}



	// Code by Shirin Start
	public function get_superadmin_appointment_data()
	{
		    $this->db->select('tbl_appointment.*,tbl_users.first_name as nav_first_name,tbl_users.last_name as nav_last_name, user.first_name as user_first_name, user.last_name as user_last_name,tbl_kit_order_status.status,tbl_gender.gender,tbl_users.contact_number,tbl_appointment_type.appointment_type as appointment_types ');
	        $this->db->from('tbl_appointment');
	        $this->db->join('tbl_users','tbl_users.id=tbl_appointment.navigator_user_id','left');
	        $this->db->join('tbl_gender','tbl_gender.id=tbl_users.gender','left');
	        $this->db->join('tbl_users AS user','user.id=tbl_appointment.user_id','left');
	        $this->db->join('tbl_appointment_type','tbl_appointment_type.id=tbl_appointment.appointment_type','left');
	        $this->db->join('tbl_kit_order_status','tbl_kit_order_status.id=tbl_appointment.appo_status','left');
	        $query=$this->db->get();
	        return $query->result_array();
	}

	public function get_userlist($usertype = '') {
        $this->db->select("*");
        $this->db->from("tbl_users");
        $this->db->where("fk_user_type_id", $usertype);
        // $this->db->where("delete_status", 1);
        $query = $this->db->get();
        $query = $query->result_array();
        $result = array();
        foreach ($query as $query_key => $query_value) {
            $query_value['decpassword'] = decrypt($query_value['password']);
            array_push($result, $query_value);
        }
        return $result;
    }
    public function get_sponser_org_admin_user_list($usertype = '') {
        $this->db->select("tbl_users.*,tbl_organization.org_name");
        $this->db->from("tbl_users");
        $this->db->join('tbl_organization','tbl_users.fk_org_id=tbl_organization.id','left');
        $this->db->where("tbl_users.fk_user_type_id", $usertype);
        // $this->db->where("delete_status", 1);
        $query = $this->db->get();
        $query = $query->result_array();
        $result = array();
        foreach ($query as $query_key => $query_value) {
            $query_value['decpassword'] = decrypt($query_value['password']);
            array_push($result, $query_value);
        }
        return $result;
    }

    public function get_inventory_on_id($id)
    {
        $this->db->select('tbl_kit_order.*,tbl_organization.org_name,tbl_order_type.order_name, tbl_users.address_one as org_address1,tbl_users.address_two as org_address2,tbl_users.city as org_city,tbl_users.state as org_state,tbl_users.zipcode as org_zipcode,,tbl_users.user_profile_pic as org_profile_pic,tbl_users.email as org_email, tbl_users.contact_number as org_contact,tbl_states.name as org_state_name,tbl_states.name as org_state_name');
        $this->db->from('tbl_kit_order');
        $this->db->join('tbl_organization','tbl_organization.id=tbl_kit_order.fk_org_id','Left');
        $this->db->join('tbl_order_type','tbl_order_type.id=tbl_kit_order.order_type','Left');
        $this->db->join('tbl_users','tbl_users.id=tbl_kit_order.org_user_id','Left');
    	$this->db->join('tbl_states','tbl_states.id=tbl_users.state','Left');

        $this->db->where('tbl_kit_order.id',$id);
        $this->db->where('tbl_kit_order.del_status','Active'); 


        //  $this->db->select('tbl_inventory.*,tbl_organization.org_name,tbl_users.first_name,tbl_users.middle_name,tbl_users.last_name,tbl_branch.branch_name,Org.address_one as org_address1,Org.address_two as org_address2,Org.city as org_city,Org.state as org_state,Org.zipcode as org_zipcode,,Org.user_profile_pic as org_profile_pic,Org.email as org_email, Org.contact_number as org_contact,tbl_states.name as org_state_name');
        // $this->db->from('tbl_inventory');
        // $this->db->join('tbl_organization','tbl_organization.id=tbl_inventory.fk_org_id','Left');
        // $this->db->join('tbl_users','tbl_users.id=tbl_inventory.user_id','Left');
        // $this->db->join('tbl_users as Org','Org.id=tbl_inventory.org_user_id','Left');
        // $this->db->join('tbl_branch','tbl_branch.id=tbl_inventory.fk_branch_id','Left');
        // $this->db->join('tbl_states','tbl_states.id=tbl_users.state','Left');
        // $this->db->where('tbl_inventory.id',$id);
        // // $this->db->where('tbl_inventory.order_type',1);
        // $this->db->where('tbl_inventory.del_status','Active');
        $query=$this->db->get();
        return $query->row_array();
        // return $this->db->count_all_results();
    }

    public function get_superadmin_profile_data($id='')
    {
    	$this->db->select('tbl_users.*,tbl_states.name as state_name');
        $this->db->from('tbl_users');
    	$this->db->join('tbl_states','tbl_states.id=tbl_users.state','Left');
        $this->db->where('tbl_users.id',$id);
        $this->db->where('tbl_users.del_status','Active');
        $query=$this->db->get();
        return $query->row_array();
    }

    // public function get_mailing_report($from_date='',$to_date='')
    // {
    // 	$this->db->select('tbl_kit_order.*, tbl_kit_order.id as kit_id,tbl_users.first_name,tbl_users.middle_name,tbl_users.last_name,tbl_users.address_one,tbl_users.address_two,tbl_users.state,tbl_users.city,tbl_users.zipcode,tbl_users.email,tbl_users.contact_number,tbl_organization.org_name,tbl_states.name as state_name');
    // 	$this->db->from('tbl_kit_order');
    // 	$this->db->join('tbl_users','tbl_kit_order.user_id=tbl_users.id','left');
    // 	$this->db->join('tbl_organization','tbl_kit_order.fk_org_id=tbl_organization.id','left');
    // 	$this->db->join('tbl_states','tbl_users.state=tbl_states.id','left');
    // 	$this->db->where('tbl_kit_order.status',3);
    //     $from_date =date('Y-m-d', strtotime($from_date));
    //     $from_date = $from_date ." 00:00:00";
    //     $this->db->where('tbl_kit_order.date >=',$from_date); 
    //     $to_date =date('Y-m-d', strtotime($to_date));
    //     $to_date = $to_date ." 11:59:00";
    //     $this->db->where('tbl_kit_order.date <=',$to_date); 
    // 	$query=$this->db->get();
    //     return $query->result_array();
    // }
    // Code by Shirin End
}//class ends here	