<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_tax extends CI_Model {

	function __construct() 
	{
        parent::__construct();	 
    }
	
	public function countTaxList($keyword)
	{
		$this->db->select('TT.*');
		$this->db->from('tbl_tax_types as TT');
		$this->db->or_like('TT.tax_name',$keyword);
		//$this->db->where('archive','N');		
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->num_rows();
		 }
		   else{
			 return false;
		  }
	}
	
	public function getTaxList($start,$limit,$keyword)
	{
		$this->db->select('TT.*');
		$this->db->from('tbl_tax_types as TT');
		$this->db->or_like('TT.tax_name',$keyword);
		//$this->db->where('archive','N');
		$this->db->order_by('TT.id','asc');
		$this->db->limit($limit,$start);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }	
	}
	
	
	
	public function getTaxDetails($tid,$stateId)
	{
		$this->db->select('T.*, S.name as state, CT.commodity, TT.tax_name');
		$this->db->from('tbl_taxes as T');
		$this->db->join('tbl_commodity_types as CT','T.commodity_id = CT.id','left');
		$this->db->join('tbl_tax_types as TT','T.tax_type_id = TT.id','left');
		$this->db->join('tbl_states as S','T.state_id = S.id','left');
		$this->db->where('state_id',$stateId);
		$this->db->where('tax_type_id',$tid);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }	
	}


	public function getTaxName($tid)
	{
		$this->db->select('T.*, CT.commodity, TT.tax_name');
		$this->db->from('tbl_taxes as T');
		$this->db->join('tbl_commodity_types as CT','T.commodity_id = CT.id','left');
		$this->db->join('tbl_tax_types as TT','T.tax_type_id = TT.id','left');
		$this->db->where('tax_type_id',$tid);
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
		$this->db->update('tbl_states', $data);    
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
		$this->db->update('tbl_states', $data);		
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
		$query = $this->db->insert('tbl_states', $data); 
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
		$this->db->update('tbl_states', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}

	public function addTemp($data)
	{
		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('tbl_taxes', $data); 
		return $return;
		
	}
	


	public function editTaxDetails($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		$this->db->update('tbl_taxes', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}
}
?>