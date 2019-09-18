<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_quote extends CI_Model {

	function __construct() 
	{
        parent::__construct();	 
    }
	
	public function countQuotes($keyword,$filter)
	{
		$this->db->select('UQ.*, U.fname, U.lname, U.company, P.name as product_name');
		$this->db->from('tbl_user_quotes as UQ');
		$this->db->join('tbl_products as P','UQ.product_id = P.id','left');
		$this->db->join('tbl_users as U','UQ.user_id = U.id','left');
		if(isset($filter['product']) && !empty($filter['product'])){
        	$this->db->where('UQ.product_id',$filter['product']);
        }
        if(isset($keyword) && !empty($keyword)){
        	$this->db->where("(U.fname like '%$keyword%' or U.lname like '%$keyword%' or U.company like '%$keyword%' )");
        }
        /*
		$this->db->or_like('U.fname',$keyword);
		$this->db->or_like('U.lname',$keyword);
		$this->db->or_like('U.company',$keyword);*/

		$this->db->where('UQ.archive','N');
		$this->db->group_by('UQ.id');		
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->num_rows();
		 }
		   else{
			 return false;
		  }
	}
	

	public function getQuotes($start,$limit,$keyword,$filter)
	{
		$this->db->select('UQ.*, U.fname, U.lname, U.company,  P.name as product_name');
		$this->db->from('tbl_user_quotes as UQ');
		$this->db->join('tbl_products as P','UQ.product_id = P.id','left');
		$this->db->join('tbl_users as U','UQ.user_id = U.id','left');
		//$this->db->or_like('P.name',$keyword);
		if(isset($filter['product']) && !empty($filter['product'])){
        	$this->db->where('UQ.product_id',$filter['product']);
        }
        if(isset($keyword) && !empty($keyword)){
        	$this->db->where("(U.fname like '%$keyword%' or U.lname like '%$keyword%' or U.company like '%$keyword%' )");
        }
		$this->db->where('UQ.archive','N');
		$this->db->group_by('UQ.id');	
		$this->db->order_by('UQ.id','desc');
		$this->db->limit($limit,$start);
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
		$this->db->update('tbl_user_quotes', $data);    
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
		$this->db->update('tbl_user_quotes', $data);		
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
		$query = $this->db->insert('tbl_products', $data); 
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
		$this->db->update('tbl_products', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}

}
?>