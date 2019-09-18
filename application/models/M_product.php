<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_product extends CI_Model {

	function __construct() 
	{
        parent::__construct();	 
    }
	
	public function countProducts($keyword,$filter)
	{
		$this->db->select('P.*');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','PC.product_id = P.id','left');
		$this->db->join('tbl_categories as C','PC.category_id = C.id','left');
		$this->db->where("(P.name like '%$keyword%' or P.sku like '%$keyword%')");
		
		if(isset($filter['subcategory']) && !empty($filter['subcategory'])){
        	$this->db->where('PC.category_id',$filter['subcategory']);
        }
        if(isset($filter['category']) && !empty($filter['category'])){
        	$this->db->where('C.parent_id',$filter['category']);
        }
		$this->db->where('P.archive','N');
		$this->db->group_by('P.id');		
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->num_rows();
		 }
		   else{
			 return false;
		  }
	}
	
	public function getProducts($start,$limit,$keyword,$filter)
	{
		$this->db->select('P.*');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','PC.product_id = P.id','left');
		$this->db->join('tbl_categories as C','PC.category_id = C.id','left');
		$this->db->where("(P.name like '%$keyword%' or P.sku like '%$keyword%')");
		
		if(isset($filter['subcategory']) && !empty($filter['subcategory'])){
        	$this->db->where('PC.category_id',$filter['subcategory']);
        }
        if(isset($filter['category']) && !empty($filter['category'])){
        	$this->db->where('C.parent_id',$filter['category']);
        }
		$this->db->where('P.archive','N');
		$this->db->group_by('P.id');
		$this->db->order_by('P.id','desc');
		$this->db->limit($limit,$start);
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
		$this->db->select('P.*');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','PC.product_id = P.id','left');
		$this->db->join('tbl_categories as C','PC.category_id = C.id','left');
		
        $this->db->where('PC.category_id',$id);
        
		$this->db->where('P.archive','N');
		$this->db->group_by('P.id');
		$this->db->order_by('P.id','desc');

		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }	
	}
	


	
	public function getContents($pid)
	{
		$this->db->select('*');
		$this->db->from('tbl_product_content');
		$this->db->where('product_id',$pid);
		$this->db->order_by('id','asc');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }	
	}

	public function getPhases()
	{
		$this->db->select('*');
		$this->db->from('tbl_phases');
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


	public function getBathrooms()
	{
		$this->db->select('*');
		$this->db->from('tbl_bathrooms');
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


	public function getSolids()
	{
		$this->db->select('*');
		$this->db->from('tbl_solid_handlings');
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

	public function getPumpTypes()
	{
		$this->db->select('*');
		$this->db->from('tbl_pump_types');
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


	public function getTankTypes()
	{
		$this->db->select('*');
		$this->db->from('tbl_tank_types');
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

	
	public function getBoreDiameters()
	{
		$this->db->select('*');
		$this->db->from('tbl_bore_diameter');
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

	
	public function getCommodities()
	{
		$this->db->select('*');
		$this->db->from('tbl_commodity_types');
		//$this->db->where('archive','N');
		$this->db->order_by('id','desc');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }	
	}
	
	
	
	public function getProductDetails($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_products');
		$this->db->where('id',$id);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		   else{
			 return false;
		  }	
	}


	public function getProductCategories($pid)
	{

		$this->db->select('*');
		$this->db->from('tbl_product_categories');
		$this->db->where('product_id',$pid);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$final = $result->result_array();
			return $final;
		}else{
			 return false;
		}	
	}

	
	public function getProductPrice($pid)
	{

		$this->db->select('*');
		$this->db->from('tbl_prices');
		$this->db->where('product_id',$pid);
		$this->db->order_by('range_from','asc');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$final = $result->result_array();
			return $final;
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

	

	public function getGraphImages($pid)
	{

		$this->db->select('*');
		$this->db->from('tbl_graphs');
		$this->db->where('product_id',$pid);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$final = $result->result_array();
			return $final;
		}else{
			 return false;
		}	
	}


	public function getProductFeaturedImage($pid)
	{
		$this->db->select('*');
		$this->db->from('tbl_images');
		$this->db->where('product_id',$pid);
		$this->db->where('is_featured','Y');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$final = $result->row_array();
			return $final['image'];
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
		$this->db->update('tbl_products', $data);    
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
		$this->db->update('tbl_products', $data);		
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


	public function addBore($data)
	{
		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('tbl_bore_diameter', $data);
		$return['name'] =  $data['name'];
		$return['insert_id'] = $this->db->insert_id();
		$return['data'] = 'Successfully saved.';
		return $return;
		
	}

	public function addSolid($data)
	{
		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('tbl_solid_handlings', $data);
		$return['name'] =  $data['name'];
		$return['insert_id'] = $this->db->insert_id();
		$return['data'] = 'Successfully saved.';
		return $return;
		
	}

	public function addBath($data)
	{
		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('tbl_bathrooms', $data);
		$return['name'] =  $data['name'];
		$return['insert_id'] = $this->db->insert_id();
		$return['data'] = 'Successfully saved.';
		return $return;
	}


	public function addTank($data)
	{
		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('tbl_tank_types', $data);
		$return['name'] =  $data['name'];
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
	
	public function addProductImage($data)
	{

		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('tbl_images', $data);
		$return['insert_id'] = $this->db->insert_id();
		return $return;
		
	}


	public function addGraphImage($data)
	{

		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('tbl_graphs', $data);
		$return['insert_id'] = $this->db->insert_id();
		return $return;
		
	}
	
	public function addProductContent($data)
	{

		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('tbl_product_content', $data);
		$return['insert_id'] = $this->db->insert_id();
		return $return;
		
	}


	public function deleteProductCategory($pid)
	{
		$this->db->where('product_id', $pid);
   		$this->db->delete('tbl_product_categories');
		$return = array();
		$return['status'] = 'true';
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
	

	public function deleteProductContent($pid)
	{
		$this->db->where('product_id', $pid);
   		$this->db->delete('tbl_product_content');
		$return = array();
		$return['status'] = 'true';
		return $return;
	}


	public function addProductPrice($data)
	{
		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('tbl_prices', $data); 
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

	
	public function updateFeaturedImage($id,$product_id)
	{
		$data['is_featured'] = 'N';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('product_id', $product_id);
		$this->db->update('tbl_images', $data);

		$data['is_featured'] = 'Y';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		$this->db->update('tbl_images', $data);    
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
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
   		$this->db->delete('tbl_images');
        if ($this->db->affected_rows() > 0) 
		{
			return 'true';	
        } else {
            return 'false';
        }
	}

	
	public function removeGraph($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
   		$this->db->delete('tbl_graphs');
        if ($this->db->affected_rows() > 0) 
		{
			return 'true';	
        } else {
            return 'false';
        }
	}


	public function removeBore($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$data['archive'] = 'Y';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
   		$this->db->update('tbl_bore_diameter', $data);
        if ($this->db->affected_rows() > 0) 
		{
			return 'true';	
        } else {
            return 'false';
        }
	}
	public function removeSolid($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$data['archive'] = 'Y';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
   		$this->db->update('tbl_solid_handlings', $data);
        if ($this->db->affected_rows() > 0) 
		{
			return 'true';	
        } else {
            return 'false';
        }
	}

	public function removeBath($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$data['archive'] = 'Y';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
   		$this->db->update('tbl_bathrooms', $data);
        if ($this->db->affected_rows() > 0) 
		{
			return 'true';	
        } else {
            return 'false';
        }
	}


	public function removeRange($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
   		$this->db->delete('tbl_prices');
        if ($this->db->affected_rows() > 0) 
		{
			return 'true';	
        }else{
            return 'false';
        }
	}


	public function removeTank($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$data['archive'] = 'Y';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
   		$this->db->update('tbl_tank_types', $data);
        if ($this->db->affected_rows() > 0) 
		{
			return 'true';	
        } else {
            return 'false';
        }
	}


}
?>