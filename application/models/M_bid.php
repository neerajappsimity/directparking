<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_bid extends CI_Model {

	function __construct() 
	{
        parent::__construct();	 
    }
	
	public function countBids($keyword,$filter)
	{
		$this->db->select('B.*, U.fname, U.lname, U.company');
		$this->db->from('tbl_bids as B');
		$this->db->join('tbl_users as U','B.user_id = U.id','left');
		
		$this->db->group_by('B.id');		
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->num_rows();
		}else{
			 return false;
		}
	}
	

	public function getBids($start,$limit,$keyword,$filter)
	{
		$this->db->select('B.*, U.fname, U.lname, U.company, P.name as product_name');
		$this->db->from('tbl_bids as B');
		$this->db->join('tbl_users as U','B.user_id = U.id','left');
		$this->db->join('tbl_products as P','B.product_id = P.id','left');
		$this->db->group_by('B.id');
		$this->db->order_by('B.id','desc');
		$this->db->limit($limit,$start);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			 return false;
		}	
	}

	
	
	
	public function getBidDetails($id)
	{
		$this->db->select('B.*, U.fname, U.lname, U.company, U.email, U.mobile, UT.user_type');
		$this->db->from('tbl_bids as B');
		$this->db->join('tbl_users as U','B.user_id = U.id','left');
		$this->db->join('tbl_user_types as UT','UT.id = U.user_type_id','left');
		$this->db->where('B.id',$id);
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
		$this->db->update('tbl_bids', $data);    
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
		$this->db->update('tbl_bids', $data);		
        if ($this->db->affected_rows() > 0) 
		{
			//$this->db->where('`id` IN (SELECT product_id from tbl_product_categories where category_id IN (SELECT `id` FROM `tbl_categories` WHERE parent_id = '.$id.'))', NULL, FALSE);
			//$this->db->update('tbl_products', $data);
			return 'true';	
        } else {
            return 'false';
        }
	}
	
	
	public function edit($data)
	{

		$id = $data['id'];
		unset($data['id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		$this->db->update('tbl_bids', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}


	public function updateNotification($id)
	{
			$data['is_read'] = 'Y';
			$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
			$this->db->where('related_id', $id);
			//$this->db->where('noti_type = "2" or noti_type = "3"');

			$this->db->where('user_id', $this->session->userdata('user_id'));
			$this->db->update('tbl_notifications', $data); 
	}

	

}
?>