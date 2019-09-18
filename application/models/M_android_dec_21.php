<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_android extends CI_Model {

	function __construct() 
	{
        parent::__construct();
        //$this->db->query("SET time_zone='+5:30'");
    }


    public function checkUser($data)
	{
		$return = array();
		$return['status'] = 'true';
		$result = $this->checkMobile($data['mobile']);

			if(!$result){
				
			}else{
				$return['status'] = 'false';
				$return['message'] = 'Mobile no. already exist.';
			}

		return $return;
		
	}


	public function saveMobile($data)
	{
		$return = array();
		$return['status'] = 'true';
		$result = $this->checkMobile($data['mobile']);
		//if($data['other'] == '0')
		{

			if(!$result){
				$return['otp']= rand(1000, 9999);
				//$return['otp']= 1234;
				$this->sendSMS($data['mobile'],$return['otp']);
			}else{
				$return['status'] = 'false';
				$return['message'] = 'Mobile no. already exist.';
			}
		}/*else{
			if(!$result){
				$return['status'] = 'false';
				$return['message'] = 'Mobile no. does not exist.';
			}else if($result['enabled']=='Y'){

				$return['otp']= rand(1000, 9999);
				//$this->resendSendSMS($data['mobile'],$return['otp']);
			}else if($result['enabled']=='N'){
				$return['status'] = 'false';
				$return['message'] = 'Account has been disabled.';
			}
		}*/
		
		return $return;
	}


	public function checkMobile($data)
	{
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('mobile',$data);
		$this->db->where('archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		   else{
			 return false;
		  }
	}

	public function checkUsedCoupon($code, $userId){
		$this->db->select('O.*');
		$this->db->from('tbl_orders as O');
		$this->db->join('tbl_coupons as C','O.coupon_id = C.id');
		$this->db->where('C.code',$code);
		$this->db->where('O.user_id',$userId);
		$this->db->where('C.archive','N');
		$this->db->group_by('O.user_id');
		$result = $this->db->get();
		
		return $result->num_rows();
	}

	public function signUpCustomer($data)
	{
		$return = array();
		$return['status'] = 'true';
		$data['password'] = md5($data['password']); 
		//$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->insert('tbl_users', $data);
		$return['user_id'] = $this->db->insert_id();
		
		return $return;
	}

	
	public function addShippingAddress($data)
	{
		$return = array();
		$return['status'] = 'true';
		$this->db->insert('tbl_shipping_address', $data);
		return $return;
	}


	public function addCapitalQuery($data)
	{
		$this->db->select('*');
		$this->db->from('tbl_capital_queries');
		$this->db->where('user_id',$data['user_id']);
		$result = $this->db->get();
		if($result->num_rows() > 0){
				$return['exists'] = true;
				return $result->row_array();
		}else{
			 	$return = array();
			 	$return['exists'] = false;
				$return['status'] = 'true';
				$data['created'] = date('Y-m-d H:i:s');
				$this->db->insert('tbl_capital_queries', $data);
				$return['id'] = $this->db->insert_id();
				return $return;
		}

		
	}


	public function addAskForQuote($data)
	{
		$return = array();
		$return['status'] = 'true';
		$this->db->insert('tbl_user_quotes', $data);
		return $return;
	}

	
	public function postBid($data)
	{
		$return = array();
		$return['status'] = 'true';
		$this->db->insert('tbl_bids', $data);
		return $return;
	}
	
	
	public function userLogin($data)
	{
	    $mobile = $data['mobile'];
	    $password = md5($data['password']);
		$this->db->select('u.*');		
		$this->db->from('tbl_users as u');
		$this->db->where('u.mobile',$mobile);
	    $this->db->where('u.password',$password);
	    $this->db->where('u.user_type_id !="1" ');
		$this->db->where('u.archive','N');
		//$this->db->where('u.is_verified','Y');
        $result = $this->db->get();
		// echo $this->db->last_query(); die();
	   	if($result->num_rows() > 0){
			
			$updatedData['device_id'] = $data['device_id'];
			$updatedData['last_login'] = date("Y-m-d H:i:s");;
			$return = $result->row_array();

			$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
			$this->db->where('id', $return['id']);
			$this->db->update('tbl_users', $updatedData);    
			if ($this->db->affected_rows() > 0) {
				$return1 = 'true';
			} else {
				$return1 = 'false';
			}    
	 	}
	    else{
	     $return = false;
	  }
		
		return $return;

	}


	public function getBusinessType($userType)
	{
		$this->db->select('id, name');
		$this->db->from('tbl_retailer_types');
		$this->db->where('user_type_id',$userType);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }
	}

	public function getFirm()
	{
		$this->db->select('id, name');
		$this->db->from('tbl_firm_types');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }
	}
	

	public function getState()
	{
		$this->db->select('id, name');
		$this->db->from('tbl_states');
		$this->db->where('country_id','101');
		$this->db->where('enabled','Y');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }
	}

	
	public function getBrands()
	{
		$this->db->select('*');
		$this->db->from('tbl_brands');
		$this->db->where('enabled','Y');
		$this->db->where('archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }
	}


	public function getCity($stateId)
	{
		$this->db->select('id, name,petrol_price');
		$this->db->from('tbl_cities');
		$this->db->where('state_id',$stateId);
		$this->db->where('enabled','Y');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }
	}


	public function getCouponDetails($code)
	{
		$this->db->select('*');
		$this->db->from('tbl_coupons');
		$this->db->where('code',$code);
		$this->db->where("date_from <= '".date('Y-m-d')."' ");
		$this->db->where("date_to >= '".date('Y-m-d')."' ");
		$this->db->where('enabled','Y');
		$this->db->where('archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		 else
		 {
			return false;
		 }
	}


	public function getMainCategories()
	{
		$this->db->select('id, name');
		$this->db->from('tbl_categories');
		$this->db->where('parent_id',0);
		$this->db->where('enabled','Y');
		$this->db->where('archive','N');
		$this->db->order_by('id','desc');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }else{
			return false;
		  }	
	}

	public function subCategories($id)
	{
		$this->db->select('id, name');
		$this->db->from('tbl_categories');
		$this->db->where('parent_id',$id);
		$this->db->where('enabled','Y');
		$this->db->where('archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			 return false;
		}	
	}

	
	public function getProducts($id,$filter)
	{
		$this->db->select('P.*,B.name as brand_name, B.support as brand_support, PRICE.price as price, I.image as featured_image');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','P.id = PC.product_id');
		$this->db->join('tbl_brands as B','B.id = P.brand_id');
		$this->db->join('tbl_prices as PRICE','PRICE.product_id = P.id');
		$this->db->join('tbl_images as I','I.product_id = P.id','left');
		$this->db->where('PC.category_id',$id);
		if(isset($filter['boreDiameter'])){
			$sqlBore = "(1=2 ";
			foreach($filter['boreDiameter'] as $bore){
				$sqlBore .=" or P.bore_diameter_id = '$bore'";
			}
			$this->db->where($sqlBore.")");
		}

		if(isset($filter['brand'])){
			$sqlBrand = "(1=2 ";
			foreach($filter['brand'] as $brand){
				$sqlBrand .=" or P.brand_id = '$brand'";
			}
			$this->db->where($sqlBrand.")");
		}

		/*if(isset($filter['headInFeet'])){
			$sqlheadInFeet = "(1=2 ";
			foreach($filter['headInFeet'] as $headInFeet){
				$sqlheadInFeet .=" or P.head_feet = '$headInFeet'";
			}
			$this->db->where($sqlheadInFeet.")");
		}*/

		if(isset($filter['bathroom'])){
			$sqlbathroom = "(1=2 ";
			foreach($filter['bathroom'] as $bathroom){
				$sqlbathroom .=" or P.bathroom_id = '$bathroom'";
			}
			$this->db->where($sqlbathroom.")");
		}

		if(isset($filter['outletSize'])){
			$sqloutletSize = "(1=2 ";
			foreach($filter['outletSize'] as $outletSize){
				$sqloutletSize .=" or P.outlet_size = '$outletSize'";
			}
			$this->db->where($sqloutletSize.")");
		}

		if(isset($filter['phase'])){
			$sqlphase = "(1=2 ";
			foreach($filter['phase'] as $phase){
				$sqlphase .=" or P.phase_id = '$phase'";
			}
			$this->db->where($sqlphase.")");
		}

		if(isset($filter['solidHandling'])){
			$sqlsolidHandling = "(1=2 ";
			foreach($filter['solidHandling'] as $solidHandling){
				$sqlsolidHandling .=" or P.solid_handling_id = '$solidHandling'";
			}
			$this->db->where($sqlsolidHandling.")");
		}


		if(isset($filter['headMin'])){
			$this->db->where("P.head_max <= ".$filter['headMax']." ");
			$this->db->where("P.head_min >= ".$filter['headMin']." ");
		}
		if(isset($filter['flowRateLpmMax'])){
			$this->db->where("P.flow_max <= ".$filter['flowRateLpmMax']." ");
			$this->db->where("P.flow_min >= ".$filter['flowRateLpmMin']." ");
		}
		/*if(isset($filter['flowRateLpmMax'])){
			$this->db->where("P.flow_rate_lpm <= ".$filter['flowRateLpmMax']." ");
			$this->db->where("P.flow_rate_lpm >= ".$filter['flowRateLpmMin']." ");
		}*/
		if(isset($filter['powerRatingKwMax'])){
			$this->db->where("P.power_rating_kw <= ".$filter['powerRatingKwMax']." ");
			$this->db->where("P.power_rating_kw >= ".$filter['powerRatingKwMin']." ");
		}
		if(isset($filter['powerRatingHpMax'])){	
			$this->db->where("P.power_rating_hp <= ".$filter['powerRatingHpMax']." ");
			$this->db->where("P.power_rating_hp >= ".$filter['powerRatingHpMin']." ");
		}
		if(isset($filter['pressureMax'])){
			$this->db->where("P.pressure <= ".$filter['pressureMax']." ");
			$this->db->where("P.pressure >= ".$filter['pressureMin']." ");
		}

		if(isset($filter['priceRangeMax'])){
			$this->db->where("PRICE.price <= ".$filter['priceRangeMax']." ");
			$this->db->where("PRICE.price >= ".$filter['priceRangeMin']." ");
		}
		
		
		$this->db->where('PRICE.range_from',0);
		$this->db->where('I.is_featured','Y');
		$this->db->where('P.enabled','Y');
		$this->db->where('P.archive','N');
		$this->db->where('PRICE.range_from',0);
		$this->db->group_by('P.id');
		$result = $this->db->get();
		//echo $this->db->last_query();
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			 return $result->result_array();
		}	
	}

	public function getProductFilters($data)
	{
		$this->db->select('P.*,B.name as brand_name, MAX(P.power_rating_hp) as max_power_rating_hp, MIN(P.power_rating_hp) as min_power_rating_hp, MAX(P.power_rating_kw) as max_power_rating_kw, MIN(P.power_rating_kw) as min_power_rating_kw, MIN(P.flow_min) as min_flow_rate_lpm,MAX(P.flow_max) as max_flow_rate_lpm, MAX(P.pressure) as max_pressure, MIN(P.pressure) as min_pressure, MAX(PRICE.price) as max_price, MIN(PRICE.price) as min_price, MIN(P.head_min) as head_min, MAX(P.head_max) as head_max, PC.category_id');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','P.id = PC.product_id');
		$this->db->join('tbl_categories as C','C.id = PC.category_id');
		$this->db->join('tbl_brands as B','B.id = P.brand_id');
		$this->db->join('tbl_prices as PRICE','PRICE.product_id = P.id');
		if(!empty($data['cat_id'])){
			$this->db->where('C.parent_id',$data['cat_id']);
		}
		if(!empty($data['brand_id'])){
			$this->db->where('P.brand_id',$data['brand_id']);
		}
		$this->db->where('PRICE.range_from',0);
		$this->db->where('P.enabled','Y');
		$this->db->where('P.archive','N');
		$this->db->where('PRICE.range_from',0);
		if(!empty($data['cat_id'])){
			$this->db->group_by('C.parent_id');
		}
		if(!empty($data['brand_id'])){
			$this->db->group_by('P.brand_id');
		}
		$result = $this->db->get();
		//echo $this->db->last_query();die;
		if($result->num_rows() > 0){
			return $result->row_array();
		}else{
			 return false;
		}	
	}


	public function getSolidHandling($data)
	{
		$this->db->select('P.solid_handling_id as id, SH.name');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','P.id = PC.product_id');
		$this->db->join('tbl_categories as C','C.id = PC.category_id');
		$this->db->join('tbl_solid_handlings as SH','P.solid_handling_id = SH.id');
		if(!empty($data['cat_id'])){
			$this->db->where('C.parent_id',$data['cat_id']);
		}
		if(!empty($data['brand_id'])){
			$this->db->where('P.brand_id',$data['brand_id']);
		}
		$this->db->where('P.enabled','Y');
		$this->db->where('P.archive','N');
		$this->db->group_by('P.solid_handling_id');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			 return false;
		}	
	}

	
	public function getBoreDiameter($data)
	{
		$this->db->select('P.bore_diameter_id as id, BD.name');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','P.id = PC.product_id');
		$this->db->join('tbl_categories as C','C.id = PC.category_id');
		$this->db->join('tbl_bore_diameter as BD','P.bore_diameter_id = BD.id');
		if(!empty($data['cat_id'])){
			$this->db->where('C.parent_id',$data['cat_id']);
		}
		if(!empty($data['brand_id'])){
			$this->db->where('P.brand_id',$data['brand_id']);
		}
		$this->db->where('P.enabled','Y');
		$this->db->where('P.archive','N');
		$this->db->group_by('P.bore_diameter_id');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			 return false;
		}	
	}


	/*public function getBoreDiameter($data)
	{
		$this->db->select('P.bore_diameter as name');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','P.id = PC.product_id');
		$this->db->join('tbl_categories as C','C.id = PC.category_id');
		if(!empty($data['cat_id'])){
			$this->db->where('C.parent_id',$data['cat_id']);
		}
		if(!empty($data['brand_id'])){
			$this->db->where('P.brand_id',$data['brand_id']);
		}
		$this->db->where('P.enabled','Y');
		$this->db->where('P.bore_diameter != ""');
		$this->db->where('P.archive','N');
		$this->db->group_by('P.bore_diameter');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			 return false;
		}	
	}*/

	public function getHeadFeet($data)
	{
		$this->db->select('P.head_feet as name');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','P.id = PC.product_id');
		$this->db->join('tbl_categories as C','C.id = PC.category_id');
		if(!empty($data['cat_id'])){
			$this->db->where('C.parent_id',$data['cat_id']);
		}
		if(!empty($data['brand_id'])){
			$this->db->where('P.brand_id',$data['brand_id']);
		}
		$this->db->where('P.enabled','Y');
		$this->db->where('P.head_feet != ""');
		$this->db->where('P.archive','N');
		$this->db->group_by('P.head_feet');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			 return false;
		}	
	}

	public function getOutletSize($data)
	{
		$this->db->select('P.outlet_size as name');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','P.id = PC.product_id');
		$this->db->join('tbl_categories as C','C.id = PC.category_id');
		if(!empty($data['cat_id'])){
			$this->db->where('C.parent_id',$data['cat_id']);
		}
		if(!empty($data['brand_id'])){
			$this->db->where('P.brand_id',$data['brand_id']);
		}
		$this->db->where('P.enabled','Y');
		$this->db->where('P.outlet_size != ""');
		$this->db->where('P.archive','N');
		$this->db->group_by('P.outlet_size');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			 return false;
		}	
	}

	
	public function getBathroom($data)
	{
		$this->db->select('P.bathroom_id as id, B.name');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','P.id = PC.product_id');
		$this->db->join('tbl_categories as C','C.id = PC.category_id');
		$this->db->join('tbl_bathrooms as B','P.bathroom_id = B.id');
		if(!empty($data['cat_id'])){
			$this->db->where('C.parent_id',$data['cat_id']);
		}
		if(!empty($data['brand_id'])){
			$this->db->where('P.brand_id',$data['brand_id']);
		}
		$this->db->where('P.enabled','Y');
		$this->db->where('P.archive','N');
		$this->db->group_by('P.bathroom_id');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			 return false;
		}	
	}
	
	public function getBrandFilter($id)
	{
		$this->db->select('P.brand_id as id, B.name');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','P.id = PC.product_id');
		$this->db->join('tbl_categories as C','C.id = PC.category_id');
		$this->db->join('tbl_brands as B','P.brand_id = B.id');
		$this->db->where('C.parent_id',$id);
		$this->db->where('P.enabled','Y');
		$this->db->where('P.archive','N');
		$this->db->group_by('P.brand_id');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			 return false;
		}	
	}

	
	public function getPhase($data)
	{
		$this->db->select('P.phase_id as id, PH.name');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','P.id = PC.product_id');
		$this->db->join('tbl_categories as C','C.id = PC.category_id');
		$this->db->join('tbl_phases as PH','P.phase_id = PH.id');
		if(!empty($data['cat_id'])){
			$this->db->where('C.parent_id',$data['cat_id']);
		}
		if(!empty($data['brand_id'])){
			$this->db->where('P.brand_id',$data['brand_id']);
		}
		$this->db->where('P.enabled','Y');
		$this->db->where('P.archive','N');
		$this->db->group_by('P.phase_id');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			 return false;
		}	
	}


	public function getBrandProducts($id,$brandId,$filter)
	{
		$this->db->select('P.*,B.name as brand_name, PRICE.price as price, I.image as featured_image');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','P.id = PC.product_id');
		$this->db->join('tbl_brands as B','B.id = P.brand_id');
		$this->db->join('tbl_prices as PRICE','PRICE.product_id = P.id');
		$this->db->join('tbl_images as I','I.product_id = P.id','left');
		$this->db->where('P.brand_id',$brandId);
		$this->db->where('PC.category_id',$id);


		if(isset($filter['boreDiameter'])){
			$sqlBore = "(1=2 ";
			foreach($filter['boreDiameter'] as $bore){
				$sqlBore .=" or P.bore_diameter_id = '$bore'";
			}
			$this->db->where($sqlBore.")");
		}

		if(isset($filter['headInFeet'])){
			$sqlheadInFeet = "(1=2 ";
			foreach($filter['headInFeet'] as $headInFeet){
				$sqlheadInFeet .=" or P.head_feet = '$headInFeet'";
			}
			$this->db->where($sqlheadInFeet.")");
		}

		if(isset($filter['bathroom'])){
			$sqlbathroom = "(1=2 ";
			foreach($filter['bathroom'] as $bathroom){
				$sqlbathroom .=" or P.bathroom_id = '$bathroom'";
			}
			$this->db->where($sqlbathroom.")");
		}

		if(isset($filter['outletSize'])){
			$sqloutletSize = "(1=2 ";
			foreach($filter['outletSize'] as $outletSize){
				$sqloutletSize .=" or P.outlet_size = '$outletSize'";
			}
			$this->db->where($sqloutletSize.")");
		}

		if(isset($filter['phase'])){
			$sqlphase = "(1=2 ";
			foreach($filter['phase'] as $phase){
				$sqlphase .=" or P.phase_id = '$phase'";
			}
			$this->db->where($sqlphase.")");
		}

		if(isset($filter['solidHandling'])){
			$sqlsolidHandling = "(1=2 ";
			foreach($filter['solidHandling'] as $solidHandling){
				$sqlsolidHandling .=" or P.solid_handling_id = '$solidHandling'";
			}
			$this->db->where($sqlsolidHandling.")");
		}


		if(isset($filter['flowRateLpmMax'])){
			$this->db->where("P.flow_rate_lpm <= ".$filter['flowRateLpmMax']." ");
			$this->db->where("P.flow_rate_lpm >= ".$filter['flowRateLpmMin']." ");
		}
		if(isset($filter['powerRatingKwMax'])){
			$this->db->where("P.power_rating_kw <= ".$filter['powerRatingKwMax']." ");
			$this->db->where("P.power_rating_kw >= ".$filter['powerRatingKwMin']." ");
		}
		if(isset($filter['powerRatingHpMax'])){	
			$this->db->where("P.power_rating_hp <= ".$filter['powerRatingHpMax']." ");
			$this->db->where("P.power_rating_hp >= ".$filter['powerRatingHpMin']." ");
		}
		if(isset($filter['pressureMax'])){
			$this->db->where("P.pressure <= ".$filter['pressureMax']." ");
			$this->db->where("P.pressure >= ".$filter['pressureMin']." ");
		}

		if(isset($filter['priceRangeMax'])){
			$this->db->where("PRICE.price <= ".$filter['priceRangeMax']." ");
			$this->db->where("PRICE.price >= ".$filter['priceRangeMin']." ");
		}



		$this->db->where('PRICE.range_from',0);
		$this->db->where('I.is_featured','Y');
		$this->db->where('P.enabled','Y');
		$this->db->where('P.archive','N');
		$this->db->where('PRICE.range_from',0);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			 return $result->result_array();;
		}	
	}


	public function getSingleProduct($id)
	{
		$this->db->select('P.*,B.name as brand_name, PRICE.price as price,  I.image as featured_image ');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','P.id = PC.product_id');
		$this->db->join('tbl_brands as B','B.id = P.brand_id');
		$this->db->join('tbl_prices as PRICE','PRICE.product_id = P.id');
		$this->db->join('tbl_images as I','I.product_id = P.id','left');
		$this->db->where('PC.category_id',$id);
		$this->db->where('I.is_featured','Y');
		$this->db->where('PRICE.range_from',0);
		$this->db->where('P.enabled','Y');
		$this->db->where('P.archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		}else{
			 return false;
		}	
	}


	public function getTempProduct($id)
	{
		$this->db->select('P.*,B.name as brand_name, PRICE.price as price,  I.image as featured_image ');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','P.id = PC.product_id');
		$this->db->join('tbl_brands as B','B.id = P.brand_id');
		$this->db->join('tbl_prices as PRICE','PRICE.product_id = P.id');
		$this->db->join('tbl_images as I','I.product_id = P.id','left');
		$this->db->where('PC.category_id',$id);
		$this->db->where('P.is_best','Y');
		$this->db->where('I.is_featured','Y');
		$this->db->where('PRICE.range_from',0);
		$this->db->where('P.enabled','Y');
		$this->db->where('P.archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			 return false;
		}	
	}


	public function getBestProducts($id,$limit)
	{
		$this->db->select('P.*,B.name as brand_name, PRICE.price as price,  I.image as featured_image, MAX(OI.product_id) as productCount ');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','P.id = PC.product_id');
		$this->db->join('tbl_brands as B','B.id = P.brand_id');
		$this->db->join('tbl_prices as PRICE','PRICE.product_id = P.id');
		$this->db->join('tbl_images as I','I.product_id = P.id','left');
		$this->db->join('tbl_order_items as OI','OI.product_id = P.id');
		$this->db->where('PC.category_id',$id);
		$this->db->where('P.is_best','Y');
		$this->db->where('I.is_featured','Y');
		$this->db->where('PRICE.range_from',0);
		$this->db->where('P.enabled','Y');
		$this->db->where('P.archive','N');
		$this->db->limit($limit);
		$this->db->order_by('productCount','desc');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			 return false;
		}	
	}


	public function getProductDetails($id)
	{
		$this->db->select('P.*,B.name as brand_name, B.support as brand_support,PH.name as phase_name,SH.name as solid, BR.name as bathrooms, PRICE.price as price,I.image as featured_image, BD.name as bore_diameter_name, TANK.name as tank_type');
		$this->db->from('tbl_products as P');
		$this->db->join('tbl_product_categories as PC','P.id = PC.product_id');
		$this->db->join('tbl_brands as B','B.id = P.brand_id','left');
		$this->db->join('tbl_solid_handlings as SH','SH.id = P.solid_handling_id','left');
		$this->db->join('tbl_bore_diameter as BD','BD.id = P.bore_diameter_id','left');
		$this->db->join('tbl_bathrooms as BR','BR.id = P.bathroom_id','left');
		$this->db->join('tbl_phases as PH','PH.id = P.phase_id','left');
		$this->db->join('tbl_prices as PRICE','PRICE.product_id = P.id');
		$this->db->join('tbl_images as I','I.product_id = P.id','left');
		$this->db->join('tbl_tank_types as TANK','TANK.id = P.tank_type_id','left');
		$this->db->where('P.id',$id);
		$this->db->where('PRICE.range_from',0);
		$this->db->where('I.is_featured','Y');
		$this->db->where('P.enabled','Y');
		$this->db->where('P.archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		}else{
			 return false;
		}	
	}


	public function getProductPriceRange($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_prices');
		$this->db->where('product_id',$id);
		$this->db->order_by('range_from','asc');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }	
	}

	public function getProductPrice($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_prices');
		$this->db->where('product_id',$id);
		$this->db->order_by('range_from','asc');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		   else{
			 return false;
		  }	
	}

	public function getUserProductPriceRange($data)
	{
		$this->db->select('*');
		$this->db->from('tbl_user_prices');
		$this->db->where('product_id',$data['product_id']);
		$this->db->where('user_id',$data['user_id']);
		$this->db->order_by('moq','asc');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }	
	}


	public function getFeaturedImage($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_images');
		$this->db->where('product_id',$id);
		$this->db->where('is_featured','Y');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }else{
			$this->db->select('*');
			$this->db->from('tbl_images');
			$this->db->where('product_id',$id);
			$result2 = $this->db->get();
			if($result2->num_rows() > 0){
				return $result2->row_array();
			}else{
				return false;
			}
		}	
	}


	public function getImages($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_images');
		$this->db->where('product_id',$id);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }else{
			return false;
		}	
	}


	public function getUserDetails($id)
	{
		$this->db->select('U.*,FT.name as firm_name, RT.name as business_name, S.name as state_name, C.name as city_name ');
		$this->db->from('tbl_users as U');
		$this->db->join('tbl_cities as C','C.id = U.city_id');
		$this->db->join('tbl_states as S','S.id = U.state_id');
		$this->db->join('tbl_retailer_types as RT','RT.id = U.retailer_id');
		$this->db->join('tbl_firm_types as FT','FT.id = U.firm_id');
		$this->db->where('U.id',$id);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		 else
		 {
			return false;
		 }
	}


	public function autoSuggestionList($data)
	{
		$this->db->select('P.id,P.name');
		$this->db->from('tbl_products as P');
		$this->db->where("P.name Like '%".$data['searchText']."%' ");
		$this->db->where('P.enabled','Y');
		$this->db->where('P.archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }

	}


	public function getShippingAddress($userId)
	{
		$this->db->select('SA.*, S.name as state_name, C.name as city_name');
		$this->db->from('tbl_shipping_address as SA');
		$this->db->join('tbl_states as S','S.id = SA.state_id');
		$this->db->join('tbl_cities as C','C.id = SA.state_id');
		$this->db->where('SA.user_id',$userId);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		 else
		 {
			return false;
		 }
	}

	
	public function getShippingCharges($stateId,$amount)
	{
		$this->db->select('SP.price');
		$this->db->from('tbl_shipping_prices as SP');
		$this->db->where('SP.state_id',$stateId);
		$this->db->where("SP.range_from <= '$amount'");
		$this->db->where("SP.range_to >= '$amount'");
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		 else
		 {
			return false;
		 }
	}


	public function placeOrder($data)
	{
	
		$inputJSON = json_decode($data);

		$orderData['user_id'] = $inputJSON->user_id;
		$orderData['net_amount'] = $inputJSON->order_total;
		$orderData['payment_method_id'] = $inputJSON->payment_method_id;
		$orderData['delivery_address_1'] = $inputJSON->delivery_address_1;
		$orderData['delivery_address_2'] = $inputJSON->delivery_address_2;
		$orderData['delivery_city'] = $inputJSON->delivery_city;
		$orderData['delivery_state'] = $inputJSON->delivery_state;
		$orderData['delivery_pincode'] = $inputJSON->delivery_pincode;
		$orderData['shipping_charges'] = $inputJSON->shipping_charges;
		$orderData['tax_type_id'] = $inputJSON->tax_type_id;
		$orderData['tax_rate'] = $inputJSON->tax_rate;
		$orderData['tax_amount'] = $inputJSON->tax_amount;
		$orderData['discount_amount'] = $inputJSON->discount_amount;
		$orderData['coupon_discount'] = $inputJSON->coupon_discount;
		$orderData['coupon_id'] = $inputJSON->coupon_id;
		$orderData['status_id'] = 1;
		$orderData['created_date'] = date('Y-m-d H:i:s');
		
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->insert('tbl_orders', $orderData); 
		
		$order_id = $this->db->insert_id();

		$orderItemData['order_id'] = $order_id;
		
		
		foreach($inputJSON->product_details as $data)
		{
			$orderItemData['order_id'] = $order_id;

			$orderItemData['product_id'] = $data->id;

			$resultVp = $this->getProductDetails($orderItemData['product_id']);

			$taxData = $this->getUserTaxModel($orderData['user_id'],$resultVp['commodity_id']);

			$orderItemData['quantity'] = $data->units;
			$orderItemData['price_per_unit'] = $data->price;
			if(isset($data->vatTax)){
				$orderItemData['tax_amount'] = $data->vatTax*$orderItemData['quantity'];
				$orderItemData['tax_rate'] = $taxData['rate'];
			}
			
			$orderItemData['mrp_price_per_unit'] = $resultVp['mrp'];
			$orderItemData['total_amount'] = $data->totalPrice;
			$orderItemData['created_date'] = date('Y-m-d H:i:s');

			$query = $this->db->insert('tbl_order_items', $orderItemData); 

			$order_item_id = $this->db->insert_id();

			if ($this->db->affected_rows() > 0) {
            	$return = $order_id;
			} else {
				$return = 'false';
			}
			
			
			$this->db->select('P.quantity');
			$this->db->from('tbl_products AS P');
			$this->db->where('P.id =',$data->id);
			$result = $this->db->get();

			if($result->num_rows() > 0){
				$result = $result->row_array();
			}

			$productStockData['quantity'] = $result['quantity'] - $data->units;
			$productStockId=$data->id;
			$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
			$this->db->where('id', $productStockId);
			$this->db->update('tbl_products', $productStockData);

			$checkData['product_id'] = $orderItemData['product_id'];
			$checkData['user_id'] = $orderData['user_id'];
			
			/*$checkUserPrice = $this->checkUserPrice($checkData);
			if($checkUserPrice){

			}else{

			}*/
		}

		return $return;
	}



	public function addUserPump($data,$userId)
	{
		
		$inputJSON = json_decode($data);
		$pumpData['user_id'] = $userId;
		$pumpData['application'] = $inputJSON->application;
		$pumpData['chemical_liquid'] = $inputJSON->chemical_liquid;
		$pumpData['class_premium'] = $inputJSON->class_premium;
		$pumpData['flow_rate'] = $inputJSON->flow_rate;
		$pumpData['flow_rate_measurement'] = $inputJSON->flow_rate_measurement;
		$pumpData['fluid'] = $inputJSON->fluid;
		$pumpData['fluid_water'] = $inputJSON->fluid_water;
		$pumpData['fluid_water_type'] = $inputJSON->fluid_water_type;
		$pumpData['liquid_gravity'] = $inputJSON->liquid_gravity;
		$pumpData['motor_class'] = $inputJSON->motor_class;
		$pumpData['motor_power'] = $inputJSON->motor_power;
		$pumpData['motor_speed'] = $inputJSON->motor_speed;
		$pumpData['phase'] = $inputJSON->phase;
		$pumpData['power_rating'] = $inputJSON->power_rating;
		$pumpData['power_rating_measurement'] = $inputJSON->power_rating_measurement;
		$pumpData['head'] = $inputJSON->head;
		$pumpData['liquid_temprature'] = $inputJSON->liquid_temprature;
		$pumpData['motor_type'] = $inputJSON->motor_type;
		$pumpData['liquid_handle'] = $inputJSON->liquid_handle;
		$pumpData['fluid_other'] = $inputJSON->fluid_other;
		$pumpData['water_source_other'] = $inputJSON->water_source_other;
		$pumpData['poles'] = $inputJSON->poles;
		$pumpData['required_head_measurement'] = $inputJSON->required_head_measurement;
		

		$pumpData['created'] = date('Y-m-d H:i:s');
		
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$result = $this->db->insert('tbl_user_pump_details', $pumpData);

		return $result;
	}



	public function myOrders($userId)	
	{        

	
		$this->db->select('odr.id as order_id,odr.net_amount ,odr.user_id,odr.created_date as order_created_date,net_amount, pm.name as payment_method, odr.shipping_charges, odr.tax_amount, os.order_status as order_status ');

		$this->db->from('tbl_orders as odr');
		$this->db->join('tbl_payment_methods as pm','pm.id = odr.payment_method_id');
		$this->db->join('tbl_order_statuses as os','os.id = odr.status_id');      
		$this->db->where('odr.user_id= ',$userId);
		$this->db->order_by('order_id','desc');

		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }
	}

	public function myOrderItems($orderId)	
	{        
		
		$this->db->select('OI.id,OI.order_id,OI.product_id,OI.order_id,OI.price_per_unit,OI.mrp_price_per_unit,OI.discount_amount,OI.sales_tax,OI.sales_tax_amount, OI.total_amount, OI.created_date ,OI.quantity as units,P.name as product_name, P.quantity, I.image, B.name as brand_name,P.commodity_id,P.stock_available');
        $this->db->from('tbl_order_items AS OI');		
		$this->db->join('tbl_products AS P','P.id=OI.product_id');
		$this->db->join('tbl_images as I','I.product_id = P.id','left');
		$this->db->join('tbl_brands as B','B.id = P.brand_id','left');
		$this->db->where('I.is_featured','Y');
		$this->db->where('OI.order_id= ',$orderId);
		//$this->db->where('prod_img.is_featured=','y');
		$result = $this->db->get();
		
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return $result->result_array();
		  }

	}


	public function updateProfile($data)
	{
		$id = $data['user_id'];
		unset($data['user_id']);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		if($this->db->update('tbl_users', $data)){
			return true;
		 }else{
			 return false;
		}
	}
	
	
	public function getUserTax($data)
	{
		$this->db->select('T.commodity_id, T.rate, TT.tax_name');
		$this->db->from('tbl_taxes as T');
		$this->db->join('tbl_tax_types as TT','TT.id = T.tax_type_id');
		$this->db->where('T.state_id',$data['state_id']);
		$this->db->where('T.tax_type_id',$data['tax_type_id']);
		$this->db->where('T.commodity_id',$data['commodity_id']);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		 else
		 {
			return false;
		 }
	}

	public function checkUserPrice($data)
	{
		$this->db->select('*');
		$this->db->from('tbl_user_prices ');
		$this->db->where('user_id',$data['user_id']);
		$this->db->where('product_id',$data['product_id']);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		 else
		 {
			return false;
		 }
	}
	
	public function getMyQueries($userId)
	{
		$this->db->select('UPD.*');
		$this->db->from('tbl_user_pump_details as UPD');
		$this->db->where('UPD.user_id',$userId);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }
	}

	
	public function getBackendUsers()
	{
		$this->db->select('id, email');
		$this->db->from('tbl_users');
		$this->db->where('user_type_id','1');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }else{
			return false;
		}	
	}

	
	public function addNotifications($data)
	{
		$return = array();
		$this->db->insert('tbl_notifications', $data);
		return $return;
	}


	public function getBanners()
	{
		$this->db->select('*');
		$this->db->from('tbl_banner');
		$this->db->where('enabled','Y');
		$this->db->where('archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){

			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }
	}



	/*********************************************************************************************************/

	public function commonSMS($sender,$msg){

		$postUrl = sms_postUrl;
		$username = sms_username;
		$password = sms_password;
		$mask = sms_mask;

        $postUrl.= "UserName=".$username."&Password=".$password."&Type=Bulk&To=".$sender."&Mask=".$mask."&Message=".urlencode($msg);

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_POST, 1);
          //curl_setopt($ch, CURLOPT_POSTFIELDS, $toSend);
          curl_setopt($ch, CURLOPT_URL, $postUrl);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          $out = curl_exec($ch);
          return $out;

	}


	public function sendSMS($sender,$otp){

		$postUrl = sms_postUrl;
		$username = sms_username;
		$password = sms_password;
		$mask = sms_mask;

		$msg = "Greetings from PUMPKART, please use ".$otp." as one time password (OTP) to register on PUMPKART.Do not share this for security reasons.\r\n "	;
        $postUrl.= "UserName=".$username."&Password=".$password."&Type=Bulk&To=".$sender."&Mask=".$mask."&Message=".urlencode($msg);

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_POST, 1);
          //curl_setopt($ch, CURLOPT_POSTFIELDS, $toSend);
          curl_setopt($ch, CURLOPT_URL, $postUrl);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          $out = curl_exec($ch);
          return $out;

	}

	public function resendSendSMS($sender,$otp){

		$result=$this->getUserByMobile($sender);
		//echo print_r($result);die;

		$postUrl = sms_postUrl;
		$username = sms_username;
		$password = sms_password;
		$mask = sms_mask;

		//$msg = "Password Reset OTP :".$otp;
		 $msg = "Dear " .$result[0]['fname'].",\r\n Use " .$otp." as one time password (OTP) to reset password on PUMPKART. Do not share this for security reasons. \r\n";

        $postUrl.= "UserName=".$username."&Password=".$password."&Type=Bulk&To=".$sender."&Mask=".$mask."&Message=".urlencode($msg);

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_POST, 1);
          //curl_setopt($ch, CURLOPT_POSTFIELDS, $toSend);
          curl_setopt($ch, CURLOPT_URL, $postUrl);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          $out = curl_exec($ch);
          return $out;

	}


	
	public function updatePassword($id, $password)
	{
		$data['password'] = $password;

		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('id', $id);
		//$this->db->update('tbl_users', $data);
		if($this->db->update('tbl_users', $data)){
			return true;
		 }else{
			 return false;
		}
	}
	


	public function signupUser($data)
	{
		$result= $this->CheckEmail($data['email']);
		if($result != 1)
		{
			$query = $this->db->insert('tbl_users', $data); 
			// echo $this->db->last_query(); 
			return $this->db->insert_id();
		}
		else 
		{
			return 'username';
		}
	}


	public function getAllProducts($locationId,$catId)
	{
	
		$this->db->select('vp.*,loc.id as loc_id, pc.category_id as cat_id,nv.in_time,nv.out_time, nv.working_days');
		//$this->db->select_min('vp.sp');
		$this->db->from('tbl_vendor_products as vp, tbl_locations as loc');

		$this->db->join("(Select id,MIN(sp) minsp From tbl_vendor_products where stock > 0 Group By product_id, quantity_mu_id) tmptbl",'1=1','INNER');

		$this->db->join('tbl_users as u','loc.cluster_id = u.cluster_id ');
		$this->db->join('tbl_products as p','vp.product_id = p.id');
		$this->db->join('tbl_product_categories as pc','pc.product_id = p.id');
		$this->db->join('tbl_manufacturer as m','p.manufacturer_id = m.id');
		$this->db->join('tbl_nodal_vendors as nv','vp.vendor_id = nv.user_id'); 
		$this->db->join('tbl_measuring_units as mu','mu.id = vp.quantity_mu_id');
		$this->db->group_by(array("vp.product_id","vp.quantity_mu_id"));
		
		$this->db->where('vp.sp = tmptbl.minsp');

		$this->db->where('u.archive','N');

		$this->db->where('vp.archive','N');
		$this->db->where('p.archive','N');
		$this->db->where('p.enabled','Y');
		$this->db->where('cat_id',$catId);
		$this->db->where('loc.id',$locationId);
		$this->db->where("nv.in_time <= CURTIME()");
		$this->db->where("nv.out_time  >= CURTIME() ");
		$this->db->where("vp.stock  > 0");
		$this->db->where("FIND_IN_SET(WEEKDAY(CURDATE()+1), nv.working_days )");

		$result = $this->db->get();
		//echo $this->db->last_query();die();
		if($result->num_rows() > 0){
			//return  $result->result_array();
			$data = $result->result_array();
			//print_r($data);die;
			foreach($data as $datas) {
				//$mainId = $this->getParentId1($datas['cat_id']);
				$mainId[] = $datas['cat_id'];
			}
			return array_unique($mainId);
		 }
		 else
		 {
			return false;
		 }	
	}



	public function getParentId1($id) {

			$data =  $this->getCatId($id);

		    if ( $data['parent_id'] == 0 ) { 
		        return $data; 
		    } else {

		        return $this->getParentId1($data['parent_id']); 
		    } 
		}
	

	public function getCatId($parent_id)
	{
		$this->db->select('id, name, image, parent_id');
		$this->db->from('tbl_categories');
		$this->db->where('id',$parent_id);
		$this->db->where('enabled','Y');
		$this->db->where('archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		 else
		 {
			return false;
		 }	
	}

	public function getSubCategories($parent_id)
	{
		$this->db->select('id, name, image, parent_id');
		$this->db->from('tbl_categories');
		$this->db->where('parent_id',$parent_id);
		$this->db->where('enabled','Y');
		$this->db->where('archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }	
	}

	public function getChildCategories($parent_id)
	{
		$this->db->select('id, name, image, parent_id');
		$this->db->from('tbl_categories');
		$this->db->where('parent_id',$parent_id);
		$this->db->where('enabled','Y');
		$this->db->where('archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }	
	}

	public function getSubCategoriesNew($parent_id)
	{
		$this->db->select('id, name, image, parent_id');
		$this->db->from('tbl_categories');
		$this->db->where('parent_id',$parent_id);
		$this->db->where('enabled','Y');
		$this->db->where('archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }	
	}

	 public function getCityDeliveryCharges($cityId)
      {
      
      $this->db->select('id,delivery_charges,delivery_charges_enabled');
      $this->db->from('tbl_cities');
      $this->db->where('id',$cityId);
      $result=$this->db->get();
      if($result->num_rows()>0){

      	return $result->row_array();
      }
      else
      {
      	return false;
      }

      }
	
	public function getDeliveryMethod()
	{
		$this->db->select('id, delivery_method, charges');
		$this->db->from('tbl_delivery_methods');		
		$result = $this->db->get();
		if($result->num_rows() > 0){

			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }
	}
	
	
	public function getDeliveryCharges($cityId)
	{
		$this->db->select('delivery_charges');
		$this->db->from('tbl_cities');
		$this->db->where('id',$cityId);
		$result = $this->db->get();
		if($result->num_rows() > 0){

			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }
	}

	
	public function getDeliveryPrice($clusterId)
	{
		$this->db->select('p.price as charges,m.id, m.delivery_method');
		$this->db->from('tbl_delivery_pricelist as p');
		$this->db->join('tbl_delivery_methods as m','p.delivery_methods = m.id');
		$this->db->where('p.clusters_id',$clusterId);
		$this->db->where('p.price != ""');

		$result = $this->db->get();
		//echo $this->db->last_query(); die();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }
	}

	
	public function getPaymentMethod()
	{
		$this->db->select('id,name');
		$this->db->from('tbl_payment_methods');
		$this->db->where('archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }
	}



	/******** Location End **********/

	public function checkEmail($email)
	{
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('email =',$email);
		$this->db->where('archive ','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return true;
		 }
		 else
		 {
			return false;
		 }
	}
	
	public function checkMobile1($mobile)
	{
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('mobile =',$mobile);
		$this->db->where('archive ','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return true;
		 }
		 else
		 {
			return false;
		 }
	}
	
	
	public function getUserAddresses($userId)
	{
		/*$this->db->select('CITY.name AS city_name, L.name AS location_name, U.address, U.location_id,U_add.id as address_id,U_add.is_active,STATE.name AS state_name');
		$this->db->from('tbl_users AS U');
		$this->db->join('tbl_locations as L','L.id = U.location_id');
		$this->db->join('tbl_clusters as CLUST','L.cluster_id = CLUST.id');
		$this->db->join('tbl_cities as CITY','CLUST.city_id = CITY.id');
		$this->db->join('tbl_user_addresses as U_add','U_add.user_id = U.id');
		$this->db->join('tbl_states as STATE','STATE.id = CITY.state_id');
		$this->db->where('U.id =',$userId);*/
		$this->db->select('CITY.id AS city_id, CITY.name AS city_name, L.name AS location_name, U_add.address, U_add.location_id,U_add.id as address_id,U_add.is_active, STATE.id AS state_id, STATE.name AS state_name, CLUST.id as cluster_id');
		$this->db->from('tbl_user_addresses AS U_add');
		$this->db->join('tbl_users as U','U_add.user_id = U.id');
		$this->db->join('tbl_locations as L','L.id = U_add.location_id');
		$this->db->join('tbl_clusters as CLUST','L.cluster_id = CLUST.id');
		$this->db->join('tbl_cities as CITY','CLUST.city_id = CITY.id');
		$this->db->join('tbl_states as STATE','STATE.id = CITY.state_id');
		$this->db->where('U_add.user_id =',$userId);
		//$this->db->where('is_active=','Y');
		$result = $this->db->get();
		//echo $this->db->last_query();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }
	}

	
	public function getUserDefaultAddresses($userId)
	{
		$this->db->select('U_add.id as address_id,CITY.id AS city_id, CITY.name AS city_name, L.name AS location_name, U_add.address, U_add.location_id,U_add.id as address_id, STATE.id AS state_id, STATE.name AS state_name,CLUST.id as cluster_id,U.name,U.email,U.mobile');
		$this->db->from('tbl_user_addresses AS U_add');
		$this->db->join('tbl_users as U','U_add.user_id = U.id');
		$this->db->join('tbl_locations as L','L.id = U_add.location_id');
		$this->db->join('tbl_clusters as CLUST','L.cluster_id = CLUST.id');
		$this->db->join('tbl_cities as CITY','CLUST.city_id = CITY.id');
		$this->db->join('tbl_states as STATE','STATE.id = CITY.state_id');
		$this->db->where('U_add.user_id =',$userId);
		$this->db->where('U_add.is_active','Y');
		$result = $this->db->get();
		//echo $this->db->last_query();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		 else
		 {
			return false;
		 }
	}


		public function getAddress($addressId)
	{
		$this->db->select('U_add.id as address_id,CITY.id AS city_id, CITY.name AS city_name, L.name AS location_name, U_add.address, U_add.location_id,U_add.id as address_id, STATE.id AS state_id, STATE.name AS state_name,CLUST.id as cluster_id');
		$this->db->from('tbl_user_addresses AS U_add');
		$this->db->join('tbl_users as U','U_add.user_id = U.id');
		$this->db->join('tbl_locations as L','L.id = U_add.location_id');
		$this->db->join('tbl_clusters as CLUST','L.cluster_id = CLUST.id');
		$this->db->join('tbl_cities as CITY','CLUST.city_id = CITY.id');
		$this->db->join('tbl_states as STATE','STATE.id = CITY.state_id');
		$this->db->where('U_add.id =',$addressId);
		$result = $this->db->get();
		//echo $this->db->last_query();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		 else
		 {
			return false;
		 }
	}


	
	
	public function getProductsByIds($data)
	{
		$inputJSON = json_decode($data);
		$productData['ProductIds'] = $inputJSON->ProductIds;
		
		$this->db->select('*');
		$this->db->from('tbl_vendor_products');
		$this->db->where_in('id', $productData['ProductIds']);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result_array();
		 }
		   else{
			 return false;
		  }
	}

	


	public function getProductSearch($productId,$locationId)
	{
		//print_r($data);
		$this->db->select('VP.id,VP.product_id,VP.discount_type,VP.mrp,loc.cluster_id as l_clust,U.cluster_id as u_clust,loc.id as loc_id, P.name,P.grade,P.hinglish_name,P.description,manu.name as manufacturer_name, VP.stock,(VP.sp),VP.quantity_mu_id, mu.measuring_unit as quantity_mu_name, ROUND(VP.discount) discount, NV.in_time,NV.out_time, NV.working_days');
		$this->db->from('tbl_vendor_products AS VP ');

		$this->db->join("(Select id,MIN(sp) minsp From tbl_vendor_products where stock > 0 and product_id = '$productId' Group By quantity_mu_id) tmptbl",'1=1','INNER');

		$this->db->join('tbl_product_manufacturers AS M','VP.product_id=M.id'); 
		//$this->db->join('tbl_product_images AS I','M.p_id =I.product_id');
		$this->db->join('tbl_manufacturer AS manu','M.m_id=manu.id');
		$this->db->join('tbl_products AS P','M.p_id=P.id');

		$this->db->join('tbl_users AS U','VP.vendor_id = U.id');
		$this->db->join('tbl_locations as loc','loc.cluster_id = U.cluster_id '); 


		$this->db->join('tbl_nodal_vendors AS NV','VP.vendor_id = NV.user_id');
		$this->db->join('tbl_measuring_units as mu','mu.id = VP.quantity_mu_id');

		$this->db->where('VP.stock >',0);
		$this->db->where('U.archive','N');
		$this->db->where('VP.archive','N');
		$this->db->where('M.archive','N');
		$this->db->where('P.archive','N');
		$this->db->where('P.enabled','Y');
		$this->db->where('VP.sp = tmptbl.minsp');
		$this->db->where('loc.id',$locationId);
		$this->db->where('M.id',$productId);
		$this->db->where('NV.in_time <= CURTIME()');
		$this->db->where('NV.out_time  >= CURTIME()');
		$this->db->where('FIND_IN_SET(WEEKDAY(CURDATE())+1, NV.working_days)');
		$this->db->group_by('VP.product_id');
		//$this->db->having('min(VP.sp)');
		$result = $this->db->get();
		//echo $this->db->last_query();
		//die();
		if($result->num_rows() > 0){
			return $result->row_array();
		 }
		 else
		 {
			return false;
		 }
	}


	
	public function getProductId($id)
	{
		$this->db->select('product_id');
		$this->db->from('tbl_vendor_products');
		$this->db->where('id',$id);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$data = $result->row_array();
			return $data['product_id'];
		 }
		   else{
			 return false;
		  }		
	}

	


	public function insertaddresses($data)
	{
        $clusterId=$data['clusterId'];
        $data['cluster_id']=$clusterId;
        unset($data['clusterId']);        
        $data['cluster_id']=$clusterId;
		$sql = $this->db->insert('tbl_user_addresses', $data);

		if($sql){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	public function updateaddresses($data)
	{ 
    $id=$data['address_id'];
    $userId=$data['userId'];
    unset($data['address_id']);
    unset($data['userId']);

    $this->db->where('id', $id);
    $this->db->update('tbl_user_addresses', $data); 

     $this->db->where('id', $userId);
    $this->db->update('tbl_users', $data); 
    

	}

	public function setDefaultAddress($data)
	{
	$userId=$data['userId'];
	$locationId=$data['locationId'];
	$addressId=$data['addressId'];
	$clusterId=$data['clusterId'];
	$data3	['cluster_id']=$clusterId;

	unset($data['userId']);
	unset($data['locationId']);
	unset($data['addressId']);
	unset($data['clusterId']);

	$data3['address']=$data['address'];
	$data3['location_id']=$locationId;
	$this->db->where('id',$userId);
	$this->db->update('tbl_users',$data3);
	
	unset($data['address']);
	$data2['is_active']='Y';
	$data['is_active']='N';
    $this->db->where('user_id',$userId);     
    $this->db->update('tbl_user_addresses',$data);
    

	$this->db->where('user_id',$userId); 
	$this->db->where('id',$addressId);
	$this->db->update('tbl_user_addresses',$data2);

	

	}

	public function updateFullAddresses($data)
	{ 
    $addressId=$data['addressId'];    
    $locationId=$data['locationId'];
    $isActive=$data['isActive'];
    $clusterId=$data['clusterId'];
    $userId=$data['userId'];
    $data['cluster_id']=$clusterId;
    $data['location_id']=$locationId;
    $data['is_active']=$isActive;
    $data['cluster_id']=$clusterId;

    unset($data['addressId']);	    
    unset($data['locationId']);
    unset($data['isActive']);
    unset($data['clusterId']);
    unset($data['userId']);

    $this->db->where('id', $addressId);
    $this->db->update('tbl_user_addresses', $data); 

     unset($data['is_active']);
     $this->db->where('id', $userId);
     $this->db->where('enabled', $isActive);
    $this->db->update('tbl_users', $data);    

	}

	

	public function getBannerMiddle()
	{
		$this->db->select('image');
		$this->db->from('tbl_banner');
		$this->db->where('position','2');
		$this->db->where('enabled','Y');
		$this->db->where('archive','N');
		$result = $this->db->get();
		if($result->num_rows() > 0){

			return $result->result_array();
		 }
		 else
		 {
			return false;
		 }
	}


	public function getUserByMobile($mobile)
	{
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('mobile',$mobile);
		$this->db->where('enabled','Y');
		$this->db->where('archive','N');
		$result=$this->db->get();
		if($result->num_rows()>0){
			return $result->result_array();
		}
		else{
			return false;
		}
	}

	public function salesTax()
	{
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('mobile',$mobile);
		$this->db->where('enabled','Y');
		$this->db->where('archive','N');
		$result=$this->db->get();
		if($result->num_rows()>0){
			return $result->result_array();
		}
		else{
			return false;
		}
	}

	
	public function insertCustomerProfile($data)
	{

		$sql = $this->db->insert('tbl_customer_profiles', $data);

		if($sql){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	public function addEditFamilyMember($data)
	{
		if(!isset($data['id']))
		{
			$sql = $this->db->insert('tbl_customer_profiles', $data);
		}
		else if(isset($data['id']))
		{
			$id = $data['id'];
			unset($data['id']);
			$this->db->where('id', $id);
		    $this->db->update('tbl_customer_profiles', $data);   
		}
		return true;
		/*if($sql){
			return $this->db->insert_id();
			
		}else{
			return false;
		}*/
	}


	public function getCustomerProfileUser($data)
	{

		$id=$data['userId'];
		$this->db->select('*');
		$this->db->from('tbl_users');
        $this->db->where('id',$id);
        $result=$this->db->get();
        if($result->num_rows()>0){
			return $result->row_array();
		}
		else{
			return false;
		}

	}

	public function getCustomerProfileUserDetail($data)
    {	
      $id=$data['userId']; 
      $this->db->select('*');
      $this->db->from('tbl_customer_profiles');
      $this->db->where('userId',$id);
      $result=$this->db->get();
      return $result->num_rows();
    
	}

	public function getCustomerProfile($userId)
    {	
      //$id=$userId['userId'];
    	$blankArray = array();
      $this->db->select('id,userId,dob,gender');
      $this->db->from('tbl_customer_profiles');
      $this->db->where('userId',$userId);
      $result=$this->db->get();
      if($result->num_rows()>0){
			return $result->result_array();
		}
		else{
			return $blankArray;
		}
    
	}


	public function getUserTaxModel($id,$commodityId){
		
		$userData = $this->getUserDetails($id);
		if($userData['state_id'] == 32){
			$taxTypeId=1;
		}else if($userData['state_id'] == 6){
			$taxTypeId=1;
		}else if(!empty($userData['tin_number'])){
			$taxTypeId=3;
		}else{
			$taxTypeId=2;
		}
		$data['state_id'] = $userData['state_id'];
		$data['tax_type_id'] = $taxTypeId;
		$data['commodity_id'] = $commodityId;
		
		$taxData = $this->getUserTax($data);
		$taxData['user_discount'] = $userData['discount'];
		
		return $taxData;

	}

	
}