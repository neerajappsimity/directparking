<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_coupon extends CI_Model {

	function __construct() 
	{
        parent::__construct();	 
    }
	
	public function countCoupons($keyword)
	{
		$this->db->select('*');
		$this->db->from('tbl_coupons');
		$this->db->or_like('name',$keyword);
				
		$this->db->where('archive','N');		
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->num_rows();
		 }
		   else{
			 return false;
		  }
	}
	
	public function getCoupons($start,$limit,$keyword)
	{
		$this->db->select('*');
		$this->db->from('tbl_coupons');
		$this->db->or_like('name',$keyword);
		
		$this->db->where('archive','N');
		$this->db->order_by('id','desc');
		$this->db->limit($limit,$start);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }	
	}

	
	public function getCouponDetails($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_coupons');
		$this->db->where('id',$id);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
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
		$this->db->update('tbl_coupons', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'falseeee';
        }
	}

	
	public function changeOrder($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		$this->db->update('tbl_coupons', $data);    
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
		$this->db->update('tbl_coupons', $data);		
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
		$query = $this->db->insert('tbl_coupons', $data); 
		//echo $this->db->last_query();
		$return['insert_id'] = $this->db->insert_id();
		$return['data'] = 'Successfully saved.';
		return $return;
		
	}
	
	
	public function edit($data)
	{

		$id = $data['id'];
		unset($data['id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		$this->db->update('tbl_coupons', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}

}
?>