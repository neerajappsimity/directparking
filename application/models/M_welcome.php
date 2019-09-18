<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_welcome extends CI_Model {

    function __construct() {

        parent::__construct();
		$this->load->library('session');
    	$this->load->helper('url');
    } 
	
		
		public function changePassword($data)
	{
		//print_r($data);die();
		$id = $data['id'];
		$data['password']=md5($data['password']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $data['id']);
		$this->db->update('tbl_users', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}


	public function checkEmail($data)
	{
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('email =',$data['email']);
		$this->db->where('id =','1');
		$this->db->where('archive ','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		 else
		 {
			return false;
		 }
	}

	public function forgetPasswordSendEmail($data)
	{
	    $mobile = $data['mobile'];
	    //$password = md5($data['password']);
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('mobile',$mobile);
	    $this->db->where('enabled','Y');
		$this->db->where('archive','N');
        $result = $this->db->get();
		// echo $this->db->last_query(); die();
	   	if($result->num_rows() > 0){
			
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < 15; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			$ch_key = $randomString;
			
			//$ch_key = generateRandomString(15);
			$forgetData = array('ch_key'=>md5($ch_key), 'ch_key_created_date'=>date('Y-m-d H:i:s'));
			$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
			$this->db->where('mobile', $mobile);
			$this->db->update('tbl_users', $forgetData);    
			if ($this->db->affected_rows() > 0) {
				//return 'true';
				//$return['ch_key'] = $ch_key;
				$this->db->select('*');
				$this->db->from('tbl_users');
				$this->db->where('mobile',$mobile);
				$this->db->where('enabled','Y');
				$this->db->where('archive','N');
				$result1 = $this->db->get();
				
				$return = $result1->row_array();

			} else {
				$return = 'false';
			}				
	 	}
	    else{
	     $return = false;
	  }
		return $return;
	}
	
	
	public function setPassword($data)
	{
		$mobile = $data['mobile'];
		$ch_key = $data['ch_key'];
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('mobile',$mobile);
	    $this->db->where('enabled','Y');
		$this->db->where('archive','N');
        $result = $this->db->get();
		// echo $this->db->last_query(); die();
	   	if($result->num_rows() > 0){
			//$return = $result->row_array();
			$this->db->select('*');
			$this->db->from('tbl_users');
			$this->db->where('mobile',$mobile);
			$this->db->where('ch_key',$ch_key);
			$this->db->where('CURDATE() < DATE_ADD(ch_key_created_date, INTERVAL 1 DAY)' );
			$result1 = $this->db->get();
			if($result1->num_rows() > 0){
			//$return = $result1->row_array();
				$return = 'true';
			}
			else
			{
				$return = 'false';
			}
		}else
			{
				$return = 'false';
			}
		return $return;
	}
	
	public function resetPassword($data)
	{
		$mobile = $data['mobile'];
		unset($data['mobile']);
		$data['password'] = md5($data['password']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('mobile', $mobile);
		$this->db->update('tbl_users', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}
	
	public function userLogin($data)
	{
	    $username = $data['username'];
	    $password = md5($data['password']);
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('username',$username);
	    $this->db->where('password',$password);
	    $this->db->where('enabled','Y');
		$this->db->where('archive','N');
		$this->db->where('user_type_id = 1');
        $result = $this->db->get();
		// echo $this->db->last_query(); die();
	   	if($result->num_rows() > 0){
                return $result->row_array();
	 	}
	    else{
	     return false;
	  }
	}
	
	public function totalUniversities($filter)
	{
		
		$this->db->select('*');
		$this->db->from('universities');
		

		if(isset($filter['startDate']) && isset($filter['endDate'])){
			$this->db->where('created >',$filter['startDate']);
			$this->db->where('created <',$filter['endDate']);
		}

		$this->db->where('is_verified','Y');
		$this->db->where('enabled','Y');
		$this->db->where('archive','N');
		$result = $this->db->get();
		//echo $this->db->last_query();
		if($result->num_rows() > 0){
			return $result->num_rows();
		 }
		   else{
			 return 0;
		  }
	}


	public function totalStudents($filter)
	{
		$user_type_ids = array('1');
		$this->db->select('*');
		$this->db->from('tbl_users');

		if(isset($filter['startDate']) && isset($filter['endDate'])){
			$this->db->where('created_date >',$filter['startDate']);
			$this->db->where('created_date <',$filter['endDate']);
		}

		$this->db->where('archive','N');
		$this->db->where('user_type_id','2');
		$result = $this->db->get();
		//echo $this->db->last_query();
		if($result->num_rows() > 0){
			return $result->num_rows();
		 }
		   else{
			 return 0;
		  }
	}

	
	public function totalOrders($filter)
	{
		$user_type_ids = array('1');
		$this->db->select('*');
		$this->db->from('tbl_users');

		if(isset($filter['startDate']) && isset($filter['endDate'])){
			$this->db->where('created_date >',$filter['startDate']);
			$this->db->where('created_date <',$filter['endDate']);
		}

		$this->db->where('archive','N');
		$result = $this->db->get();
		//echo $this->db->last_query();
		if($result->num_rows() > 0){
			return $result->num_rows();
		 }
		   else{
			 return 0;
		  }
	}

	
	public function totalProfit($filter)
	{
		$user_type_ids = array('1');
		$this->db->select('SUM(net_amount) as net_amount');
		$this->db->from('tbl_orders');

		if(isset($filter['startDate']) && isset($filter['endDate'])){
			$this->db->where('created_date >',$filter['startDate']);
			$this->db->where('created_date <',$filter['endDate']);
		}

		$this->db->where('archive','N');
		$result = $this->db->get();
		//echo $this->db->last_query();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		   else{
			 return 0;
		  }
	}

	

	public function bestUniversities($filter)
	{
		$this->db->select('*');
		$this->db->from('universities');
		
		$this->db->where('is_verified','Y');
		$this->db->where('enabled','Y');
		$this->db->where('archive','N');
		$this->db->group_by('id','desc');
		
		$this->db->limit('10');
        $result = $this->db->get();
		// echo $this->db->last_query(); die();
	   	if($result->num_rows() > 0){
                return $result->result_array();
	 	}
	    else{
	     return false;
	  }
	}


	public function getNotifications()
	{
		$this->db->select('*');
		$this->db->from('tbl_notifications');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->where('is_read', 'N');
		$this->db->order_by("id", "desc"); 
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return 0;
		  }
	}
	
	
	
	public function getProfileDetails($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('id',$id);
        $result = $this->db->get();
		// echo $this->db->last_query(); die();
	   	if($result->num_rows() > 0){
                return $result->row_array();
	 	}
	    else{
	     return false;
	  }
	}
	
	public function editProfile($data)
	{
   
		$id = $_SESSION['user_id'];
		//print_r($data);die;
		if(!empty($data['password'])){
			$data['password'] = md5($data['password']);
		}else{
			unset($data['password']);
		}
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		$this->db->update('tbl_users', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}

	public function notifications()
	{
		$this->db->select('*');
		$this->db->from('tbl_notifications');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->where('is_read', 'N');
		$result = $this->db->get();
		//echo $this->db->last_query();
		if($result->num_rows() > 0){
			return $result->num_rows();
		 }
		   else{
			 return 0;
		  }
	}
	
	public function notificationsList()
	{
		$data = array('is_read'=>'Y');
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->update('tbl_notifications', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
			
        } else {
            return 'false';
        }

	}
	
	
	
	public function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}





	
	
}