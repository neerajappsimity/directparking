<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_brand extends CI_Model {

	function __construct() 
	{
        parent::__construct();	 
    }
	
	public function countBrands($keyword)
	{
		$this->db->select('*');
		$this->db->from('tbl_brands');
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
	
	public function getBrands($start,$limit,$keyword)
	{
		$this->db->select('*');
		$this->db->from('tbl_brands');
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

	public function getAllBrands()
	{
		$this->db->select('*');
		$this->db->from('tbl_brands');
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
	
	
	
	public function getBrandDetails($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_brands');
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
		$this->db->update('tbl_brands', $data);    
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
		$this->db->update('tbl_brands', $data);    
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
		$this->db->update('tbl_brands', $data);		
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
		$query = $this->db->insert('tbl_brands', $data); 
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
		$this->db->update('tbl_brands', $data);    
		if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
	}

	public function removeImage($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$data['image'] = "";
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
   		$this->db->update('tbl_brands', $data);  
        if ($this->db->affected_rows() > 0) 
		{
			return 'true';	
        } else {
            return 'false';
        }
	}

	public function addDataSheetImage($data)
	{

		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('tbl_data_sheets', $data);
		$return['insert_id'] = $this->db->insert_id();
		return $return;
		
	}

	public function getDataSheetImages($data)
	{

		$this->db->select('*');
		$this->db->from('tbl_data_sheets');
		$this->db->where('category_id',$data['category_id']);
		$this->db->where('brand_id',$data['brand_id']);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$final = $result->result_array();
			return $final;
		}else{
			 return false;
		}	
	}


	public function removeDataSheetImage($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
   		$this->db->delete('tbl_data_sheets');
        if ($this->db->affected_rows() > 0) 
		{
			return 'true';	
        } else {
            return 'false';
        }
	}

}
?>