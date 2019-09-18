<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_report extends CI_Model {

	function __construct() 
	{
        parent::__construct();	 
    }
	
	public function countOrders($keyword,$filter)
	{
		$this->db->select('O.*');
		$this->db->from('tbl_orders as O');
		
		//$this->db->or_like('O.name',$keyword);
		
		if(isset($filter['order_date_from']) && isset($filter['order_date_to'])){
			$this->db->where('O.created_date >=',$filter['order_date_from']);
			$this->db->where('O.created_date <=',$filter['order_date_to']);
		}
        if(!empty($filter['order_status'])){
        	$this->db->where('O.status_id ',$filter['order_status']);
        }
        if(!empty($keyword)){
        	$this->db->where('O.id ',$keyword);
        }
        
		$this->db->where('O.archive','N');		
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->num_rows();
		 }
		   else{
			 return false;
		  }
	}
	
	public function getOrders($start,$limit,$keyword,$filter)
	{
		$this->db->select('O.*, U.fname, U.lname, U.company, OS.order_status as order_status, PM.name as payment_method');
		$this->db->from('tbl_orders as O');
		$this->db->join('tbl_users as U','O.user_id = U.id','left');
		$this->db->join('tbl_order_statuses as OS','O.status_id = OS.id','left');
		$this->db->join('tbl_payment_methods as PM','O.payment_method_id = PM.id','left');

		if(isset($filter['order_date_from']) && isset($filter['order_date_to'])){
			$this->db->where('O.created_date >=',$filter['order_date_from']);
			$this->db->where('O.created_date <=',$filter['order_date_to']);
		}
        if(!empty($filter['order_status'])){
        	$this->db->where('O.status_id ',$filter['order_status']);
        }
        if(!empty($keyword)){
        	$this->db->where('O.id ',$keyword);
        }

		$this->db->order_by('O.id','desc');
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


	public function getOrderStatus()
	{
		$this->db->select('*');
		$this->db->from('tbl_order_statuses');
		$this->db->order_by('id','asc');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }	
	}

	public function getPaymentMethods()
	{
		$this->db->select('*');
		$this->db->from('tbl_payment_methods');
		$this->db->where('archive','N');
		$this->db->order_by('id','asc');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }	
	}

	
	
	public function getOrderDetails($id)
	{
		$this->db->select('O.*, U.fname, U.lname, U.company,U.address_line_1, U.address_line_2, U.pincode, U.email, U.company, UT.user_type as user_type, U.mobile, S.name as state, C.name as city, DS.name as delivery_state, DC.name as delivery_city, PM.name as payment_method, TT.tax_name as tax_type');
		$this->db->from('tbl_orders as O');
		$this->db->join('tbl_users as U','O.user_id = U.id','left');
		$this->db->join('tbl_user_types as UT','U.user_type_id = UT.id','left');
		$this->db->join('tbl_states as S','U.state_id = S.id');
		$this->db->join('tbl_cities as C','U.city_id = C.id');
		$this->db->join('tbl_states as DS','O.delivery_state = DS.id','left');
		$this->db->join('tbl_cities as DC','O.delivery_city = DC.id','left');
		$this->db->join('tbl_tax_types as TT','O.tax_type_id = TT.id','left');
		$this->db->join('tbl_payment_methods as PM','O.payment_method_id = PM.id','left');

		$this->db->where('O.id',$id);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		   else{
			 return false;
		  }	
	}


	public function getOrderItemDetails($id)
	{
		$this->db->select('OI.*, P.name as product_name');
		$this->db->from('tbl_order_items as OI');
		$this->db->join('tbl_products as P','OI.product_id = P.id','left');
		$this->db->where('OI.order_id',$id);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			 return false;
		}	
	}


	public function getProductImages($pid)
	{

		$this->db->select('*');
		$this->db->from('tbl_images');
		$this->db->where('product_id',$pid);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$final = $result->result_array();
			return $final;
		}else{
			 return false;
		}	
	}


	public function changeStatus($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		$this->db->update('tbl_orders', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'falseeee';
        }
	}
	
	public function deleted($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		$this->db->update('tbl_orders', $data);		
        if ($this->db->affected_rows() > 0) 
		{
			//$this->db->where('`id` IN (SELECT product_id from tbl_product_categories where category_id IN (SELECT `id` FROM `tbl_categories` WHERE parent_id = '.$id.'))', NULL, FALSE);
			//$this->db->update('tbl_products', $data);
			return 'true';	
        } else {
            return 'false';
        }
	}
	

	
	public function add($data)
	{
		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('tbl_orders', $data); 
		//echo $this->db->last_query();
		$return['insert_id'] = $this->db->insert_id();
		$return['data'] = 'Successfully saved.';
		return $return;
		
	}

	public function addProductCategory($data)
	{

		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('tbl_product_categories', $data); 
		$return['insert_id'] = $this->db->insert_id();
		$return['data'] = 'Successfully saved.';
		return $return;
		
	}
	


	public function deleteProductPrice($pid)
	{
		$this->db->where('product_id', $pid);
   		$this->db->delete('tbl_prices');
		$return = array();
		$return['status'] = 'true';
		return $return;
	}
	
	
	public function edit($data)
	{

		$id = $data['id'];
		unset($data['id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		$this->db->update('tbl_orders', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}

	
	

}
?>