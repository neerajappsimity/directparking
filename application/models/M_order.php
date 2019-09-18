<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_order extends CI_Model {

	function __construct() 
	{
        parent::__construct();	 
    }
	
	public function countOrders($keyword,$filter)
	{
		$this->db->select('O.*');
		$this->db->from('tbl_orders as O');
		
		//$this->db->or_like('O.name',$keyword);
		
		/*if(isset($filter['price_to']) && !empty($filter['price_from'])){
        	$this->db->where('O.net_amount BETWEEN '.$filter['price_from'].' and '.$filter['price_to']);
        }*/
        $this->db->join('tbl_users as U','O.user_id = U.id','left');
        if(isset($filter['order_date_from']) && isset($filter['order_date_to'])){
			$this->db->where('O.created_date >=',$filter['order_date_from']);
			$this->db->where('O.created_date <=',$filter['order_date_to']);
		}
        if(!empty($filter['order_status'])){
        	$this->db->where('O.status_id ',$filter['order_status']);
        }
        if(!empty($filter['order_id'])){
        	$this->db->where('O.id ',$filter['order_id']);
        }
        if(!empty($filter['warehouse_id'])){
        	$this->db->where('O.warehouse_id ',$filter['warehouse_id']);
        }
        if(!empty($filter['invoice_no'])){
        	$this->db->where('O.invoice_no ',$filter['invoice_no']);
        }
        if(!empty($keyword)){
        	$this->db->where("(U.fname LIKE '%$keyword%' OR U.lname LIKE '%$keyword%' OR U.company LIKE '%$keyword%' )");
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
		$this->db->select('O.*, U.fname, U.lname, U.company, OS.order_status as order_status, PM.name as payment_method, W.name as ware_name');
		$this->db->from('tbl_orders as O');
		$this->db->join('tbl_users as U','O.user_id = U.id','left');
		$this->db->join('tbl_warehouses as W','W.id = O.warehouse_id','left');
		$this->db->join('tbl_order_statuses as OS','O.status_id = OS.id','left');
		$this->db->join('tbl_payment_methods as PM','O.payment_method_id = PM.id','left');
		//$this->db->or_like('O.name',$keyword);
		/*if(isset($filter['price_to']) && !empty($filter['price_from'])){
        	$this->db->where('O.net_amount BETWEEN '.$filter['price_from'].' and '.$filter['price_to']);
        }*/
        if(isset($filter['order_date_from']) && isset($filter['order_date_to'])){
			$this->db->where('O.created_date >=',$filter['order_date_from']);
			$this->db->where('O.created_date <=',$filter['order_date_to']);
		}
        if(!empty($filter['order_status'])){
        	$this->db->where('O.status_id ',$filter['order_status']);
        }
        if(!empty($filter['order_id'])){
        	$this->db->where('O.id ',$filter['order_id']);
        }
        if(!empty($filter['warehouse_id'])){
        	$this->db->where('O.warehouse_id ',$filter['warehouse_id']);
        }
        if(!empty($filter['invoice_no'])){
        	$this->db->where('O.invoice_no ',$filter['invoice_no']);
        }
        if(!empty($keyword)){
        	$this->db->where("(U.fname LIKE '%$keyword%' OR U.lname LIKE '%$keyword%' OR U.company LIKE '%$keyword%') ");
        }

        $this->db->where('O.archive','N');
		$this->db->order_by('O.id','desc');
		$this->db->limit($limit,$start);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
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

	
	public function getWarehouses()
	{
		$this->db->select('*');
		$this->db->from('tbl_warehouses');
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
		$this->db->select('O.*,U.id as customer_id, U.fname, U.lname, U.company,U.address_line_1, U.address_line_2, U.pincode, U.email, U.company, UT.user_type as user_type, U.mobile, S.name as state, C.name as city, DS.name as delivery_state, DS.id as delivery_state_id, DC.id as delivery_city_id, DC.name as delivery_city, BS.name as bill_state, BS.state_code, BS.id as bill_state_id, BC.name as bill_city, PM.name as payment_method, PM.id as payment_method_id, TT.tax_name as tax_type, W.name as ware_name, W.address_line_1 as ware_address_line_1, W.address_line_2 as ware_address_line_2, WC.name as ware_city, WS.name as ware_state,W.vat_tin as ware_vat, W.cst_no as ware_cst, WS.id as ware_state_id, ');
		$this->db->from('tbl_orders as O');
		$this->db->join('tbl_users as U','O.user_id = U.id','left');
		$this->db->join('tbl_user_types as UT','U.user_type_id = UT.id','left');
		$this->db->join('tbl_states as S','U.state_id = S.id');
		$this->db->join('tbl_cities as C','U.city_id = C.id');
		$this->db->join('tbl_states as DS','O.delivery_state = DS.id','left');
		$this->db->join('tbl_cities as DC','O.delivery_city = DC.id','left');
		$this->db->join('tbl_states as BS','O.bill_state = BS.id','left');
		$this->db->join('tbl_cities as BC','O.bill_city = BC.id','left');
		$this->db->join('tbl_warehouses as W','O.warehouse_id = W.id','left');
		$this->db->join('tbl_states as WS','W.state_id = WS.id','left');
		$this->db->join('tbl_cities as WC','W.city_id = WC.id','left');
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


	public function updateOrderNotification($id)
	{
			$data['is_read'] = 'Y';
			$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
			$this->db->where('related_id', $id);
			$this->db->where('noti_type', '1');
			$this->db->where('user_id', $this->session->userdata('user_id'));
			$this->db->update('tbl_notifications', $data); 
	}

	
	public function getOrderComments($oid)
	{

		$this->db->select('OC.*, U.fname, U.lname');
		$this->db->from('tbl_order_comments as OC');
		$this->db->join('tbl_users as U','U.id = OC.user_id');
		$this->db->where('OC.order_id',$oid);
		$this->db->where('OC.archive','N');
		$this->db->order_by('OC.id','desc');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$final = $result->result_array();
			return $final;
		}else{
			 return false;
		}	
	}


	public function getRefunds($oid)
	{

		$this->db->select('*');
		$this->db->from('tbl_refund');
		$this->db->where('order_id',$oid);
		$this->db->order_by('id','desc');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$final = $result->result_array();
			return $final;
		}else{
			 return false;
		}	
	}

	public function getOrderItemDetails($id)
	{
		$this->db->select('OI.*, P.name as product_name, B.name as brand_name, P.commodity_id, P.id as product_id, P.hsn_sac as pro_hsn_sac');
		$this->db->from('tbl_order_items as OI');
		$this->db->join('tbl_products as P','OI.product_id = P.id','left');
		$this->db->join('tbl_brands as B','P.brand_id = B.id','left');
		$this->db->where('OI.order_id',$id);
		$this->db->order_by('P.commodity_id',$id);
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

	
	public function getCustomer($id)
	{

		$this->db->select('U.*, S.name as state_name, C.name as city_name');
		$this->db->from('tbl_users as U');
		$this->db->join('tbl_states as S','U.state_id = S.id','left');
		$this->db->join('tbl_cities as C','U.city_id = C.id','left');
		$this->db->where('U.id',$id);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$final = $result->row_array();
			return $final;
		}else{
			 return false;
		}	
	}


	public function getWarehouseDetails($id)
	{

		$this->db->select('*');
		$this->db->from('tbl_warehouses as W');
		$this->db->where('W.id',$id);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$final = $result->row_array();
			return $final;
		}else{
			 return false;
		}	
	}

	
	public function getStateCount($id,$year)
	{

		$this->db->select('count(O.id) as state_count, W.state_id');
		$this->db->from('tbl_orders as O');
		$this->db->join('tbl_warehouses as W','W.id = O.warehouse_id','left');
		$this->db->where('W.state_id',$id);
		$this->db->where('O.financial_year',$year);
		$this->db->where('O.status_id != 4');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$final = $result->row_array();
			return $final;
		}else{
			 return false;
		}	
	}

	public function getGSTCount($year)
	{

		$this->db->select('count(O.id) as gst_count');
		$this->db->from('tbl_orders as O');
		
		$this->db->where('O.financial_year',$year);
		//$this->db->where('O.status_id != 4');
		$this->db->where('O.invoice_no != ""');
		$this->db->where('O.tax_type_id = 4');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$final = $result->row_array();
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

	
	public function addOrderComment($data)
	{
		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('tbl_order_comments', $data);
		$return['insert_id'] = $this->db->insert_id();
		$return['data'] = 'Successfully saved.';
		return $return;
		
	}


	public function addOrderItem($data)
	{
		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('tbl_order_items', $data); 
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


	public function addRefund($data)
	{

		$return = array();
		$return['status'] = 'true';
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$query = $this->db->insert('tbl_refund', $data); 
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


	public function deleteOrderItems($oid)
	{
		$this->db->where('order_id', $oid);
   		$this->db->delete('tbl_order_items');
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