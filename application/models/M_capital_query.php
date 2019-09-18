<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_capital_query extends CI_Model {

	function __construct() 
	{
        parent::__construct();	 
    }
	
	public function countQueries($keyword,$filter)
	{
		$this->db->select('CQ.*, U.fname, U.lname, U.company');
		$this->db->from('tbl_capital_queries as CQ');
		$this->db->join('tbl_users as U','CQ.user_id = U.id','left');

		$this->db->group_by('CQ.id');		
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->num_rows();
		}else{
			 return false;
		}
	}
	

	public function getQueries($start,$limit,$keyword,$filter)
	{
		$this->db->select('CQ.*, U.fname, U.lname, U.company, U.mobile, UT.user_type');
		$this->db->from('tbl_capital_queries as CQ');
		$this->db->join('tbl_users as U','CQ.user_id = U.id','left');
		$this->db->join('tbl_user_types as UT','UT.id = U.user_type_id','left');
		
		$this->db->group_by('CQ.id');
		$this->db->order_by('CQ.id','desc');
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
		$this->db->select('CQ.*, U.fname, U.lname, U.company, U.email, U.mobile, UT.user_type');
		$this->db->from('tbl_capital_queries as CQ');
		$this->db->join('tbl_users as U','CQ.user_id = U.id','left');
		$this->db->join('tbl_user_types as UT','UT.id = U.user_type_id','left');
		$this->db->where('CQ.id',$id);
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
		$this->db->update('tbl_capital_queries', $data);    
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
		$this->db->delete('tbl_capital_queries', $data);		
        if ($this->db->affected_rows() > 0) 
		{
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
		$this->db->update('tbl_capital_queries', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}

	

}
?>