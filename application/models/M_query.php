<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_query extends CI_Model {

	function __construct() 
	{
        parent::__construct();	 
    }
	
	public function countQueries($keyword,$filter)
	{
		$this->db->select('UPD.*, U.fname, U.lname, U.company');
		$this->db->from('tbl_user_pump_details as UPD');
		$this->db->join('tbl_users as U','UPD.user_id = U.id','left');
		
		$this->db->where('UPD.archive','N');
		$this->db->group_by('UPD.id');		
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->num_rows();
		}else{
			 return false;
		}
	}
	

	public function getQueries($start,$limit,$keyword,$filter)
	{
		$this->db->select('UPD.*, U.fname, U.lname, U.company');
		$this->db->from('tbl_user_pump_details as UPD');
		$this->db->join('tbl_users as U','UPD.user_id = U.id','left');
		
		$this->db->where('UPD.archive','N');
		$this->db->group_by('UPD.id');
		$this->db->order_by('UPD.id','desc');
		$this->db->limit($limit,$start);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			 return false;
		}	
	}

	
	
	
	public function getQueryDetails($id)
	{
		$this->db->select('UPD.*, U.fname, U.lname, U.company, U.email, U.mobile, UT.user_type');
		$this->db->from('tbl_user_pump_details as UPD');
		$this->db->join('tbl_users as U','UPD.user_id = U.id','left');
		$this->db->join('tbl_user_types as UT','UT.id = U.user_type_id','left');
		$this->db->where('UPD.id',$id);
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
		$this->db->update('tbl_user_pump_details', $data);    
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
		$this->db->update('tbl_user_pump_details', $data);		
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
		$this->db->update('tbl_user_pump_details', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}

	

}
?>