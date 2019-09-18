<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_user extends CI_Model {

	function __construct() 
	{
        parent::__construct();	 
    }
	
	public function countUsers($keyword,$filter)
	{
		$this->db->select('*');
		$this->db->from('universities');

		$this->db->where("(name LIKE '%$keyword%' or email LIKE '%$keyword%' or mobile LIKE '%$keyword%') ");
		$this->db->where('archive','N');
		//$this->db->where('user_type_id != 1');
		if(isset($filter['is_verified'])){
			$this->db->where('is_verified',$filter['is_verified']);
		}
		/*if(isset($filter['user_type_id'])){
			$this->db->where('user_type_id',$filter['user_type_id']);
		}*/
		if(isset($filter['date_from']) && isset($filter['date_to'])){
			$this->db->where('created >=',$filter['date_from']);
			$this->db->where('created <=',$filter['date_to']);
		}
        if(!empty($filter['status'])){
        	$this->db->where('is_verified',$filter['status']);
        }	
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->num_rows();
		 }
		   else{
			 return false;
		  }
	}
	
	public function getUsers($start,$limit,$keyword,$filter)
	{

		$this->db->select('*');
		$this->db->from('universities ');
		
		
			$this->db->where("(name LIKE '%$keyword%' or email LIKE '%$keyword%' or mobile LIKE '%$keyword%') ");
		
		
		
		if(isset($filter['is_verified'])){
			$this->db->where('is_verified',$filter['is_verified']);
		}
		
		if(isset($filter['date_from']) && isset($filter['date_to'])){
			$this->db->where('created >=',$filter['date_from']);
			$this->db->where('created <=',$filter['date_to']);
		}
        if(!empty($filter['status'])){
        	$this->db->where('is_verified',$filter['status']);
        }
		$this->db->where('archive','N');
		$this->db->order_by('id','desc');

		
			$this->db->limit($limit,$start);
		
		
		$result = $this->db->get();
		//echo $this->db->last_query();die;
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }	
	}


	public function countUserProducts($keyword,$filter)
	{
		$this->db->select('P.*,COUNT(OT.product_id) as product_count');
		$this->db->from('tbl_order_items as OT');
		$this->db->join('tbl_orders as O','O.id = OT.order_id');
		$this->db->join('tbl_products as P','P.id = OT.product_id');
		$this->db->where("(P.name LIKE '%$keyword%')");
		$this->db->where('O.archive','N');
		$this->db->where('O.user_id',$filter['user_id']);
		$this->db->having('product_count != 0');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->num_rows();
		 }
		   else{
			 return false;
		  }
	}
	
	public function countUserDiscounts($keyword,$filter)
	{

		$this->db->select('UP.*, I.image,P.name, P.sku');
		$this->db->from('tbl_user_prices as UP');
		$this->db->join('tbl_products as P','P.id = UP.product_id');
		$this->db->join('tbl_images as I','I.product_id = UP.product_id','left');
		//$this->db->where('(I.is_featured = "Y" or I.is_featured=NULL)');
		$this->db->where('UP.user_id',$filter['user_id']);
		$this->db->where("(P.name LIKE '%$keyword%')");
		$this->db->order_by('I.is_featured','asc');
		$this->db->group_by('UP.id');
		$result = $this->db->get();
		//echo $this->db->last_query();die;
		if($result->num_rows() > 0){
			return $result->num_rows();
		 }
		   else{
			 return false;
		  }	
	}



	public function getUserDiscounts($start,$limit,$keyword,$filter)
	{

		$this->db->select('UP.*, I.image,P.name, P.sku');
		$this->db->from('tbl_user_prices as UP');
		$this->db->join('tbl_products as P','P.id = UP.product_id');
		$this->db->join('tbl_images as I','I.product_id = UP.product_id','left');
		//$this->db->where('(I.is_featured = "Y" or I.is_featured=NULL)');
		$this->db->where('UP.user_id',$filter['user_id']);
		$this->db->where("(P.name LIKE '%$keyword%')");
		$this->db->order_by('I.is_featured','asc');
		$this->db->group_by('UP.id');
		$this->db->limit($limit,$start);
		$result = $this->db->get();
		//echo $this->db->last_query();die;
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }	
	}
	
	public function getUserProducts($start,$limit,$keyword,$filter)
	{

		$this->db->select('P.*,COUNT(OT.product_id) as product_count, I.image');
		$this->db->from('tbl_order_items as OT');
		$this->db->join('tbl_orders as O','O.id = OT.order_id');
		$this->db->join('tbl_products as P','P.id = OT.product_id');
		$this->db->join('tbl_images as I','I.product_id = OT.product_id','left');
		$this->db->where("(P.name LIKE '%$keyword%')");
		$this->db->where('O.archive','N');
		$this->db->where('O.user_id',$filter['user_id']);
		$this->db->where('I.is_featured','Y');
		$this->db->having('product_count != 0');
		$this->db->order_by('product_count','desc');
		$this->db->limit($limit,$start);
		$result = $this->db->get();
		//echo $this->db->last_query();die;
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }	
	}


	public function getState()
	{
		$this->db->select('id, name');
		$this->db->from('tbl_states');
		$this->db->where('country_id','101');
		$this->db->where('enabled','Y');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }
	}

	public function getAllUsers()
	{
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('archive','N');
		$this->db->order_by('id','desc');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }	
	}


/*	public function getFirm()
	{
		$this->db->select('id, name');
		$this->db->from('tbl_firm_types');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }
	}*/

	public function getBusinessType($userType)
	{
		$this->db->select('id, name');
		$this->db->from('tbl_retailer_types');
		$this->db->where('user_type_id',$userType);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }
	}

	public function getCity($stateId)
	{
		$this->db->select('id, name,petrol_price');
		$this->db->from('tbl_cities');
		$this->db->where('state_id',$stateId);
		$this->db->where('enabled','Y');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }
	}
	
	
	public function getStudentDetails($id)
	{
		//print_r($id);die;
		$this->db->select('*');
		$this->db->from('tbl_users as U');
		$this->db->join('locations as L','L.university_id = U.id','left');
	

		$this->db->where('U.id',$id);
		$result = $this->db->get();
		//echo $this->db->last_query(); die();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		   else{
			 return false;
		  }	
	}

		public function getUserDetails($id)
	{
		//print_r($id);die;
		$this->db->select('U.name as university,U.domain,U.email,U.mobile,U.contact_person,U.address_line_1,U.address_line_2,U.pincode,U.enabled,U.is_verified,L.location_name as Location_name,L.lat,L.log');
		$this->db->from('universities as U');
		$this->db->join('locations as L','L.university_id = U.id','left');
	

		$this->db->where('U.id',$id);
		$result = $this->db->get();
		//echo $this->db->last_query(); die();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		   else{
			 return false;
		  }	
	}


	public function getLocationsDetails($id)
	{
		//print_r($id);die();
		$this->db->select('*');
		$this->db->from('locations  as L');
		$this->db->join('universities as U','L.university_id = U.id','left');
	

		$this->db->where('L.university_id',$id);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }	
	}


	

	public function changeStatus($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		$this->db->update('universities', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}
	
		public function changePassword($data)
	{
		//print_r($data);die();
		$id = $data['id'];
		$password=$data['id'];
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		$this->db->update('universities', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}
	
	public function changeVerified($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		$this->db->update('universities', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}

	public function checkVerified($data)
	{
		$id = $data['id'];
		unset($data['id']);

		$this->db->select('*');
		$this->db->from('universities');
		$this->db->where('id',$id);
		//$this->db->where('is_verified','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }else{
			 return false;
		 }
	}
	
	public function deleted($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		$this->db->update('universities', $data);		
        if ($this->db->affected_rows() > 0) 
		{
			
			//$this->db->where('`id` IN (SELECT product_id from tbl_product_categories where category_id IN (SELECT `id` FROM `tbl_categories` WHERE parent_id = '.$id.'))', NULL, FALSE);
			//$this->db->update('tbl_products', $data);
			
			return 'true';
				
        } else {
            return 'false';
        }
	}
	

	

	public function deleteUserDiscount($data)
	{
		$this->db->where('id', $data['id']);
   		$this->db->delete('tbl_user_prices');
		$return = array();
		$return['status'] = 'true';
		return $return;
	}

	
	public function add($data)
	{
		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('universities', $data); 
		//echo $this->db->last_query();
		$return['insert_id'] = $this->db->insert_id();
		$return['data'] = 'Successfully saved.';
		return $return;
		
	}

		public function addLocation($locationData)
	{
		print_r($locationData);
		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('locations', $locationData); 
		//echo $this->db->last_query();
		$return['insert_id'] = $this->db->insert_id();
		$return['data'] = 'Successfully saved.';
		return $return;
		
	}


		public function updateLocation($locationData)
	{
		$id=$locationData['university_id'];
		$Data['university_id']=$locationData['university_id'];
		//print_r($id);die;
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('university_id', $id);
		$this->db->update('locations', $locationData);   
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
		
	}


	public function addShippingAddress($data)
	{
		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('tbl_shipping_address', $data); 
		//echo $this->db->last_query();
		$return['insert_id'] = $this->db->insert_id();
		$return['data'] = 'Successfully saved.';
		return $return;
		
	}

	
	public function getShippingDetails($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_shipping_address');
		$this->db->where('user_id',$id);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		 else
		 {
			return false;
		 }
	}

	
	public function addUserDiscount($data)
	{
		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('tbl_user_prices', $data); 
		//echo $this->db->last_query();
		$return['insert_id'] = $this->db->insert_id();
		$return['data'] = 'Successfully saved.';
		return $return;
		
	}
	
	
	public function edit($data)
	{

		$id= $data['id'];
		//print_r($data['id']);die;
		$dataUniversity['name'] = $data['university'];
		/*$dataUniversity['contact_person'] = $data['contact_person'];
		$dataUniversity['mobile'] = $data['mobile'];
		$dataUniversity['email'] = $data['email'];*/
		$dataUniversity['domain'] = $data['domain'];
		/*$dataUniversity['address_line_1'] = $data['address_line_1'];
		$dataUniversity['address_line_2'] = $data['address_line_2'];
		$dataUniversity['pincode'] = $data['pincode'];*/

		/*$locationData['location_name'] = $data['location_name'];
		$locationData['lat'] = $data['lat'];
		$locationData['log'] = $data['log'];*/

		unset($data['id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		$this->db->update('universities', $dataUniversity);   

		/*$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('university_id', $id);
		$this->db->update('locations', $locationData); */  
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}


	public function editShippingAddress($data)
	{

		$id = $data['id'];
		unset($data['id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		$this->db->update('tbl_shipping_address', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}

	public function updateUserNotification($id)
	{
			$data['is_read'] = 'Y';
			$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
			$this->db->where('related_id', $id);
			$this->db->where('noti_type = "2" or noti_type = "3"');

			$this->db->where('user_id', $this->session->userdata('user_id'));
			$this->db->update('tbl_notifications', $data); 
	}
	

	public function autoSuggestionList($data)
	{
		$this->db->select('U.id,U.fname,U.lname, U.mobile,SA.state_id, SA.address_line_1, SA.address_line_2, SA.pincode, SA.city_id, U.company');
		$this->db->from('tbl_users as U');
		$this->db->join('tbl_shipping_address as SA','SA.user_id = U.id','left');
		$this->db->where("(U.lname Like '%".$data['searchText']."%' OR U.fname Like '%".$data['searchText']."%' OR U.company Like '%".$data['searchText']."%')");
		$this->db->where('U.enabled','Y');
		$this->db->where('U.archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }

	}

}
?>