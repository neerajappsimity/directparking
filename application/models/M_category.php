<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_category extends CI_Model {

	function __construct() 
	{
        parent::__construct();	 
    }
	
	public function countCategories($keyword,$filter)
	{
		$this->db->select('*');
		$this->db->from('tbl_categories');
		$this->db->or_like('name',$keyword);
		if(isset($filter['parentId'])){
			$this->db->where('parent_id',$filter['parentId']);
		}else{
			$this->db->where('parent_id',0);
		}		
		$this->db->where('archive','N');		
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->num_rows();
		 }
		   else{
			 return false;
		  }
	}
	
	public function getCategories($start,$limit,$keyword,$filter)
	{
		$this->db->select('*');
		$this->db->from('tbl_categories');
		$this->db->or_like('name',$keyword);
		if(isset($filter['parentId'])){
			$this->db->where('parent_id',$filter['parentId']);
		}else{
			$this->db->where('parent_id',0);
		}
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
	
	public function getMainCategories()
	{
		$this->db->select('*');
		$this->db->from('tbl_categories');
		$this->db->where('parent_id',0);
		$this->db->where('archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }	
	}

	
	public function getMainCatId($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_categories');
		$this->db->where('id',$id);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		   else{
			 return false;
		  }	
	}


	public function getSubCategories($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_categories');
		$this->db->where('parent_id',$id);
		$this->db->where('archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }	
	}

	
	public function getProductsOnSub($id)
	{
		$this->db->select('P.name,P.id ');
		$this->db->from('tbl_product_categories as PC');
		$this->db->join('tbl_products as P','PC.product_id = P.id');
		$this->db->where('PC.category_id',$id);
		$this->db->where('P.archive','N');
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
		$this->db->update('tbl_categories', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}
	
	public function deleted($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		$this->db->or_where('parent_id', $id);
		$this->db->update('tbl_categories', $data);		
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
		$query = $this->db->insert('tbl_categories', $data); 
		//echo $this->db->last_query();
		$return['insert_id'] = $this->db->insert_id();
		$return['data'] = 'Successfully saved.';
		return $return;
		
	}
	
	public function getCategory($cid)
	{
		$this->db->select('*');
		$this->db->from('tbl_categories');

		$this->db->where('id',$cid);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		   else{
			 return false;
		  }	
	}
	
	public function edit($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		$this->db->update('tbl_categories', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}
}
?>