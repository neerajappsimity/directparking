<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class android extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() {
	  	//@session_start();
	  	parent::__construct();
		
            $this->load->database();            
           
            $this->load->model('M_android');
            $this->load->model('M_welcome');
            $this->load->model('M_order');
            $this->load->helper('url');
    }  
	
	public function index()
	{
		$this->load->view('welcome_message');
	}

	
	//http://192.168.1.4/pumpkart/Android/userLogin/?mobile=123456789&password=123&device_id=akdxsaklas
	public function userLogin()
	{
		$data = $_REQUEST;
		$result = $this->M_android->userLogin($data);
		
		if($result['is_verified'] == 'P')
		{
			$resultLogin= array('success'=>'0','message'=>'Account is pending for verification.');
		}else if($result['is_verified'] == 'N')
		{
			$resultLogin= array('success'=>'0','message'=>'Account is not verified. Please contact the support.');
		}else if($result['enabled'] == 'Y')
		{
			if($result['is_pass_changed'] == 'D' || $result['is_pass_changed'] == 'N'){
				$result['is_pass_changed'] = false;
			}else{
				$result['is_pass_changed'] = true;
			}

				$resultLogin= array('success'=>'1','user_id'=>$result['id'],'user_type'=>$result['user_type_id'], 'first_name'=>$result['fname'],'last_name'=>$result['lname'],'email'=>$result['email'],'mobile'=>$result['mobile'],'tax_type_id'=>'1','tax_name'=>'VAT','tax_rate'=>'14.5','is_pass_changed'=>$result['is_pass_changed']);
		}else if($result['enabled'] == 'N')
		{
			$resultLogin= array('success'=>'0','message'=>'Account has been disabled.');
		}else{
			$resultLogin= array('success'=>'0','message'=>'Incorrect Credentials.');
		}
		echo json_encode($resultLogin);
	}


	//http://192.168.1.4/pumpkart/Android/getState
	public function getState()
	{
	
		$resultState = $this->M_android->getState();
		
		echo json_encode($resultState);
	}

	//http://192.168.1.4/pumpkart/Android/getBusinessType?&user_type=
	public function getBusinessType()
	{
		$userType = $_REQUEST['user_type'];
		$resultRetailer = $this->M_android->getBusinessType($userType);
		
		echo json_encode($resultRetailer);
	}

	//http://192.168.1.4/pumpkart/Android/getFirm
	public function getFirm()
	{
		$resultFirm = $this->M_android->getFirm();	
		echo json_encode($resultFirm);
	}


	//http://192.168.1.4/pumpkart/Android/getCity/?state_id=
	public function getCity()
	{                                                   
		$stateId = $_REQUEST['state_id'];
		$resultState = $this->M_android->getCity($stateId);
		
		echo json_encode($resultState);
	}


	//http://192.168.1.4/pumpkart/Android/saveMobile/?mobile=123456789&other=1(forgot password),0
	public function saveMobile()
	{
		$data = $_REQUEST;
		$result = $this->M_android->saveMobile($data);
		echo json_encode($result);
	}


	//http://192.168.1.4/pumpkart/Android/signUpCustomer/?mobile=9874563210&company=&fname=&lname&password=&address_line_1=&address_line_2=&email=&device_id=&state_id=&city_id=&pincode=&dob=&gender=(M,F)&pan_number=&aadhaar_number=&tin_number=&retailer_id=&firm_id=&device_id=&ship_address_line_1=&ship_address_line_2=&ship_state_id=&ship_city_id=&ship_pincode=&user_type=
	public function signUpCustomer()
	{

		$data = $_POST;
		
		$data['last_login'] = date("d-m-Y g:i:s");
		$return['status'] = 'true';

		if(empty($data['company'])){
			$return['status'] = 'false';
			$return['message'] = 'Company name missing';
		}else if(empty($data['fname'])){
			$return['status'] = 'false';
			$return['message'] = 'First name missing';
		}else if(empty($data['lname'])){
			$return['status'] = 'false';
			$return['message'] = 'Last name missing';
		}else if(empty($data['gender'])){
			$return['status'] = 'false';
			$return['message'] = 'gender missing';
		}else if(empty($data['mobile'])){
			$return['status'] = 'false';
			$return['message'] = 'first name missing';
		}else if(empty($data['password'])){
			$return['status'] = 'false';
			$return['message'] = 'password missing';
		}else if(empty($data['pan_number'])){
			$return['status'] = 'false';
			$return['message'] = 'pan number missing';
		}else if(empty($data['tin_number'])){
			$return['status'] = 'false';
			$return['message'] = 'Tin number missing';
		}else if(empty($data['email'])){
			$return['status'] = 'false';
			$return['message'] = 'email missing';
		}else if(empty($data['retailer_id'])){
			$return['status'] = 'false';
			$return['message'] = 'Retailer type missing';
		}else if(empty($data['firm_id'])){
			$return['status'] = 'false';
			$return['message'] = 'Firm type missing';
		}else if(empty($data['address_line_1'])){
			$return['status'] = 'false';
			$return['message'] = 'Address missing';
		}else if(empty($data['state_id'])){
			$return['status'] = 'false';
			$return['message'] = 'state missing';
		}else if(empty($data['city_id'])){
			$return['status'] = 'false';
			$return['message'] = 'city missing';
		}else if(empty($data['pincode'])){
			$return['status'] = 'false';
			$return['message'] = 'pincode missing';
		}else{
			
			$result = $this->M_android->checkUser($data);
			if($result['status'] == 'true'){
			
			$data['created'] = date('Y-m-d g:i:s');
			
			$dataShip['address_line_1'] = $data['ship_address_line_1'];
			$dataShip['address_line_2'] = $data['ship_address_line_2'];
			$dataShip['city_id'] = $data['ship_city_id'];
			$dataShip['state_id'] = $data['ship_state_id'];
			$dataShip['pincode'] = $data['ship_pincode'];

			
			if(isset($_REQUEST['image']) && ($_REQUEST['image'] != ''))
			{
				$_REQUEST['image'] = str_replace(" ","+",$_REQUEST['image']);
				$rand = rand(1,999);
				$image_user = time()."_$rand.jpeg";
				$img = imagecreatefromstring(base64_decode($_REQUEST['image']));
				$image_loc = APPPATH . '../assets/image/vat/'.$image_user;
				if($img != false)
				{
					   imagejpeg($img,$image_loc);
					   $data['vat_image'] = $image_user;
				} 

			}
			

			unset($data['ship_address_line_1']);
			unset($data['ship_address_line_2']);
			unset($data['ship_city_id']);
			unset($data['ship_state_id']);
			unset($data['ship_pincode']);
			unset($data['user_id']);
			unset($data['image']);

			$result = $this->M_android->signUpCustomer($data);

			$dataShip['user_id'] = $result['user_id'];
			$resultShip = $this->M_android->addShippingAddress($dataShip);

			/*$to = $data['email'];
			$subject = "Mr Bachat is here to serve you ".$data['name']." Ji";			
			$body ="";
			$header = "From: Mr Bachat <noreply@mrbachat.com>";
			mail($to, $subject, $body, $header);*/
			$dataNoti['related_id'] = $result['user_id'];
			$dataNoti['noti_type'] = '2';
			$resultBack = $this->M_android->getBackendUsers();
        	foreach($resultBack as $k=>$v){
        		$dataNoti['user_id'] = $v['id'];
				$resultNoti = $this->M_android->addNotifications($dataNoti);
			}

			$return = array('status'=>'true','success'=>'1','user_id'=>$result['user_id'], 'first_name'=>$data['fname'], 'last_name'=>$data['lname']);
			}else{
				$return = array('status'=>'false','success'=>'0','message'=>'User already exists');
			}

		}
		
		echo json_encode($return);
		
	}


	//http://192.168.1.4/pumpkart/Android/getCategories/
	public function getCategories()
	{
		
		$result = $this->M_android->getMainCategories();
		if(!empty($result)){
			foreach($result as $k=>$v){
				$result[$k]['subcategories'] = $this->M_android->subCategories($v['id']);
			}
			$final = array('success' =>'1' ,'data'=>$result);
		}else{
			$final = array('success' =>'0' ,'message'=>'No data found');
		}

		echo json_encode($final);
	}


	//http://192.168.1.4/pumpkart/Android/getProducts/?cat_id=&sub_id=&brand_id=&user_id=
	public function getProducts()
	{
		$data = $_GET;
		$price = array();
		$filter = array();
		$result = array();

		$userDetails = $this->M_android->getUserDetails($data['user_id']);

		if(isset($_REQUEST['filter']) && !empty($_REQUEST['filter']) ){
			
			$inputJSON = json_decode(stripslashes(urldecode($_REQUEST['filter'])));
			//echo "<pre>";
			//print_r($inputJSON);die;

			if(isset($inputJSON->boreDiameter)){
			foreach($inputJSON->boreDiameter as $boreVal){
				if($boreVal->isChecked == '1'){
					$filter['boreDiameter'][] = $boreVal->id; 
				}
			}
			}

			if(isset($inputJSON->brand)){
			foreach($inputJSON->brand as $brandVal){
				if($brandVal->isChecked == true || $brandVal->isChecked == 'true' || $brandVal->isChecked == 1){

					$filter['brand'][] = $brandVal->id; 
				}
			}
			}

			if(isset($inputJSON->headInFeet)){
			foreach($inputJSON->headInFeet as $headInFeetVal){
				if($headInFeetVal->isChecked == '1'){
					$filter['headInFeet'][] = $headInFeetVal->name; 
				}
			}
			}

			if(isset($inputJSON->bathroom)){
			foreach($inputJSON->bathroom as $bathroomVal){
				if($bathroomVal->isChecked == '1'){
					$filter['bathroom'][] = $bathroomVal->id; 
				}
			}
			}

			if(isset($inputJSON->outletSize)){
			foreach($inputJSON->outletSize as $outletSizeVal){
				if($outletSizeVal->isChecked == '1'){
					$filter['outletSize'][] = $outletSizeVal->name; 
				}
			}
			}

			if(isset($inputJSON->phase)){
			foreach($inputJSON->phase as $phaseVal){
				if($phaseVal->isChecked == '1'){
					$filter['phase'][] = $phaseVal->id; 
				}
			}
			}
			
			if(isset($inputJSON->solidHandling)){
			foreach($inputJSON->solidHandling as $solidHandlingVal){
				if($solidHandlingVal->isChecked == '1'){
					$filter['solidHandling'][] = $solidHandlingVal->id; 
				}
			}
			}

					if(isset($inputJSON->flowRateLpm->max)){
					$filter['flowRateLpmMax'] = $inputJSON->flowRateLpm->max;
					}
					if(isset($inputJSON->flowRateLpm->min)){
					$filter['flowRateLpmMin'] = $inputJSON->flowRateLpm->min;
					}
					if(isset($inputJSON->powerRatingKw->max)){
					$filter['powerRatingKwMax'] = $inputJSON->powerRatingKw->max;
					}
					if(isset($inputJSON->powerRatingKw->min)){
					$filter['powerRatingKwMin'] = $inputJSON->powerRatingKw->min;
					}
					if(isset($inputJSON->powerRatingHp->max)){
					$filter['powerRatingHpMax'] = $inputJSON->powerRatingHp->max;
					}
					if(isset($inputJSON->powerRatingHp->min)){
					$filter['powerRatingHpMin'] = $inputJSON->powerRatingHp->min;
					}
					if(isset($inputJSON->pressure->max)){
					$filter['pressureMax'] = $inputJSON->pressure->max;
					}
					if(isset($inputJSON->pressure->min)){
					$filter['pressureMin'] = $inputJSON->pressure->min;
					}
					if(isset($inputJSON->priceRange->max)){
					$filter['priceRangeMax'] = $inputJSON->priceRange->max;
					}
					if(isset($inputJSON->priceRange->min)){
					$filter['priceRangeMin'] = $inputJSON->priceRange->min;
					}
					if(isset($inputJSON->head_in_feet->min)){
					$filter['headMin'] = $inputJSON->head_in_feet->min;
					}
					if(isset($inputJSON->head_in_feet->max)){
					$filter['headMax'] = $inputJSON->head_in_feet->max;
					}
		}

		
		if(!empty($data['cat_id'])){
			$result = $this->M_android->subCategories($data['cat_id']);

					$rangefilters =  $this->M_android->getProductFilters($data);
					$brandFilter =  $this->M_android->getBrandFilter($data['cat_id']);
					if(!$brandFilter){
						$brandFilter = array();
					}

					$boreDiameter =  $this->M_android->getBoreDiameter($data);
					if(!$boreDiameter){
						$boreDiameter = array();
					}

					$solidHandling =  $this->M_android->getSolidHandling($data);
					if(!$solidHandling){
						$solidHandling = array();
					}

					$bathroom =  $this->M_android->getBathroom($data);
					if(!$bathroom){
						$bathroom = array();
					}

					$headFeet =  $this->M_android->getHeadFeet($data);
					if(!$headFeet){
						$headFeet = array();
					}else{
						foreach($headFeet as $headKey=>$headVal){
							$headFeet[$headKey]['id']="";
						}
					}

					$phase =  $this->M_android->getPhase($data);
					if(!$phase){
						$phase = array();
					}

					$outletSize =  $this->M_android->getOutletSize($data);
					if(!$outletSize){
						$outletSize = array();
					}else{
						foreach($outletSize as $outKey=>$outVal){
							$outletSize[$outKey]['id']="";
						}
					}

					/*if(isset($rangefilters['head_min']) && $rangefilters['head_min'] == ""){
						$rangefilters['head_min'] = '0';
					}
					if(isset($rangefilters['min_flow_rate_lpm']) && $rangefilters['min_flow_rate_lpm'] == ""){
						$rangefilters['min_flow_rate_lpm'] = '0';
					}*/


					$filters = array('priceRange' =>
															array('max' => $rangefilters['max_price'],
																'min' => $rangefilters['min_price']

					) , 'powerRatingHp' => 
															array('max' => $rangefilters['max_power_rating_hp'],
																'min' => $rangefilters['min_power_rating_hp']

					), 'powerRatingKw' => 
															array('max' => $rangefilters['max_power_rating_kw'],
																'min' => $rangefilters['min_power_rating_kw']

					), 'flowRateLpm' =>  
															array('max' => $rangefilters['max_flow_rate_lpm'],
																'min' => $rangefilters['min_flow_rate_lpm']

					), 'pressure' =>  
															array('max' => $rangefilters['max_pressure'],
																'min' => $rangefilters['min_pressure']
					), 'head_in_feet' =>  
															array('max' => $rangefilters['head_max'],
																'min' => $rangefilters['head_min']

					),  'boreDiameter' =>
															$boreDiameter
					,   'solidHandling' =>
															$solidHandling
					,   'bathroom' =>
															$bathroom
					,   'headInFeet' =>
															array()
															//$headFeet
					,   'phase' =>
															$phase
					,   'outletSize' =>
															$outletSize
					,   'brand' =>
															$brandFilter
															 
															 );

			/*$inputJSON = json_decode('{"boreDiameter":[{"id":"","isChecked":true,"name":"10"}],"brand":[{"id":"4","isChecked":true,"name":"BELCO"},{"id":"7","isChecked":false,"name":"BOSCH"},{"id":"8","isChecked":true,"name":"KSB"}],"flowRateLpm":{"max":"160","min":"0"},"headInFeet":[{"id":"","isChecked":false,"name":"10"},{"id":"","isChecked":false,"name":"160"}],"bathroom":[{"id":"3","isChecked":false,"name":"1-3"},{"id":"4","isChecked":false,"name":"1-4"},{"id":"5","isChecked":false,"name":"1-5"}],"outletSize":[{"id":"","isChecked":false,"name":"10"}],"phase":[{"id":"2","isChecked":false,"name":"Two Phase"},{"id":"3","isChecked":false,"name":"Three Phase"}],"powerRatingHp":{"max":"10","min":"0"},"powerRatingKw":{"max":"10.6","min":"0"},"pressure":{"max":"12.6","min":"0"},"priceRange":{"max":"35000","min":"3500"},"solidHandling":[{"id":"1","isChecked":false,"name":"35 MM"},{"id":"3","isChecked":false,"name":"45MM"}]}');*/
			

			

			//echo "<pre>";
			//print_r($filter);die;
			if(!empty($result)){
			foreach($result as $kS=>$vS){
				$result[$kS]['products'] = $this->M_android->getProducts($vS['id'],$filter);
				$result[$kS]['filters'] = $filters;


				if(!empty($result[$kS]['products'])){

					foreach($result[$kS]['products'] as $keyP=>$valP){

						unset($price);
						//$priceRange = $this->M_android->getProductPriceRange($valP['id']);
						$data['product_id'] = $valP['id'];
						$priceRange = $this->M_android->getUserProductPriceRange($data);
						
						$taxData= $this->getUserTax($data['user_id'],$valP['commodity_id']);

						if(!empty($priceRange)){
						
						$result[$kS]['products'][$keyP]['tax'] = $taxData['tax_name'];

						$userDiscount = $taxData['user_discount'];

						if($valP['quantity'] == 0){
							$result[$kS]['products'][$keyP]['stock_available'] = 0;
						}

						$priceRange2 = $this->M_android->getProductPrice($valP['id']);
						$priceSpBase = $priceRange2['price'];
						@$taxAmountBase = ($priceRange2['price']/100)*$taxData['rate'];
						$discountAmount = 0;
						$priceTo = $priceRange[0]['moq']-1;
						$price[] = array('from'=>"1",'to'=>"$priceTo",'price'=>$priceSpBase,'tax_amount'=>$taxAmountBase,'discount_amount'=>$discountAmount);
						
						foreach($priceRange as $kR=>$vR){
							$priceFrom = $vR['moq'];
							if(@$priceRange[$kR+1]['moq']){
								$priceTo = $priceRange[$kR+1]['moq']-1;
							}else{
								$priceTo = 'Above' ;
							}
							$priceSp = $vR['price'];
							@$taxAmount = ($vR['price']/100)*$taxData['rate'];
							//$discountAmount = ($vR['price']/100)*$userDiscount;
							$discountAmount = 0;

							$price[] = array('from'=>$priceFrom,'to'=>$priceTo,'price'=>$priceSp,'tax_amount'=>$taxAmount,'discount_amount'=>$discountAmount);
						}
						$result[$kS]['products'][$keyP]['price'] = $priceSpBase;
						$result[$kS]['products'][$keyP]['price_tax'] = $taxAmountBase;
						$result[$kS]['products'][$keyP]['price_range'] = $price;
						$result[$kS]['products'][$keyP]['has_discount'] = true;
					}else{
						//$result[$kS]['products'][$keyP]['price_range'] = "";
						$priceRange = $this->M_android->getProductPrice($valP['id']);
						$priceSp = $priceRange['price'];
						@$taxAmount = ($priceRange['price']/100)*$taxData['rate'];
						//$discountAmount = ($priceRange['price']/100)*$userDiscount;
						$discountAmount = 0;

						$result[$kS]['products'][$keyP]['price_range'] = array();
						$result[$kS]['products'][$keyP]['has_discount'] = false;
						$result[$kS]['products'][$keyP]['price'] = $priceSp;
						@$result[$kS]['products'][$keyP]['price_tax'] = $taxAmount;
					}
				}
				}else{
					//unset($result[$kS]);
					
					if(!empty($filter)){
						unset($result[$kS]);
					}else{
						$result[$kS]['products'] = array();
					}
				}
			}
		}else{
			$result = array();
		}
		}else if(!empty($data['sub_id'])){
			$result = $this->M_android->getProducts($data['sub_id']);
			if(!empty($result)){
			foreach($result as $kP=>$vP){
				unset($price);
				$priceRange = $this->M_android->getProductPriceRange($vP['id']);

				$result[$kS]['products'][$kP]['tax'] = $this->getUserTax($data['user_id'],$vP['commodity_id']);
				$userDiscount = $result[$kS]['products'][$keyP]['tax']['user_discount'];

				if($vP['quantity'] == 0){
					$result[$kP]['stock_available'] = 0;
				}

				foreach($priceRange as $k=>$v){
					$priceFrom = $v['range_from']+1;
					if(@$priceRange[$k+1]['range_from']){
						$priceTo = $priceRange[$k+1]['range_from']-1;
					}else{
						$priceTo = 'Above' ;
					}
					$priceSp = $v['price'];
					$taxAmount = ($v['price']/100)*$result[$kS]['products'][$kP]['tax']['rate'];
					$discountAmount = ($v['price']/100)*$userDiscount;
					$price[] = array('from'=>$priceFrom,'to'=>$priceTo,'price'=>$priceSp,'tax_amount'=>$taxAmount,'discount_amount'=>$discountAmount);
				}
				$result[$kP]['price_range'] = $price;
				
			}
			}
		}else if(!empty($data['brand_id'])){

			$final = array();

					$rangefilters =  $this->M_android->getProductFilters($data);
					
					$boreDiameter =  $this->M_android->getBoreDiameter($data);
					if(!$boreDiameter){
						$boreDiameter = array();
					}

					$solidHandling =  $this->M_android->getSolidHandling($data);
					if(!$solidHandling){
						$solidHandling = array();
					}

					$bathroom =  $this->M_android->getBathroom($data);
					if(!$bathroom){
						$bathroom = array();
					}

					$headFeet =  $this->M_android->getHeadFeet($data);
					if(!$headFeet){
						$headFeet = array();
					}else{
						foreach($headFeet as $headKey=>$headVal){
							$headFeet[$headKey]['id']="";
						}
					}

					$phase =  $this->M_android->getPhase($data);
					if(!$phase){
						$phase = array();
					}

					$outletSize =  $this->M_android->getOutletSize($data);
					if(!$outletSize){
						$outletSize = array();
					}else{
						foreach($outletSize as $outKey=>$outVal){
							$outletSize[$outKey]['id']="";
						}
					}

					/*if($rangefilters['head_min'] == ""){
						$rangefilters['head_min'] = '0';
					}

					if($rangefilters['min_flow_rate_lpm'] == ""){
						$rangefilters['min_flow_rate_lpm'] = '0';
					}*/

					$filters = array('priceRange' =>
															array('max' => $rangefilters['max_price'],
																'min' => $rangefilters['min_price']

					) , 'powerRatingHp' => 
															array('max' => $rangefilters['max_power_rating_hp'],
																'min' => $rangefilters['min_power_rating_hp']

					), 'powerRatingKw' => 
															array('max' => $rangefilters['max_power_rating_kw'],
																'min' => $rangefilters['min_power_rating_kw']

					), 'flowRateLpm' =>  
															array('max' => $rangefilters['max_flow_rate_lpm'],
																'min' => $rangefilters['min_flow_rate_lpm']

					), 'pressure' =>  
															array('max' => $rangefilters['max_pressure'],
																'min' => $rangefilters['min_pressure']

					), 'head_in_feet' =>  
															array('max' => $rangefilters['head_max'],
																'min' => $rangefilters['head_min']

					),  'boreDiameter' =>
															$boreDiameter
					,   'solidHandling' =>
															$solidHandling
					,   'bathroom' =>
															$bathroom
					,   'headInFeet' =>
															array()
															//$headFeet
					,   'phase' =>
															$phase
					,   'outletSize' =>
															$outletSize
					,   'brand' =>
															array() 
															 );
			
				$resultMain = $this->M_android->getMainCategories();
				foreach($resultMain as $keyMain=>$valMain){
					$result = $this->M_android->subCategories($valMain['id']);
					//$result[$keyMain]['filters'] = $filters;

					foreach($result as $kS=>$vS){
					
					$resultMain[$keyMain]['products'] = $this->M_android->getBrandProducts($vS['id'],$data['brand_id'],$filter);
					$resultMain[$keyMain]['filters'] = $filters;

					if(!empty($resultMain[$keyMain]['products'])){

						foreach($resultMain[$keyMain]['products'] as $keyP=>$valP){
							unset($price);
							$data['product_id'] = $valP['id'];
							$priceRange = $this->M_android->getUserProductPriceRange($data);
							$taxData= $this->getUserTax($data['user_id'],$valP['commodity_id']);

							if(!empty($priceRange)){
							//$resultMain[$keyMain]['products'][$keyP]['tax'] = $this->getUserTax($data['user_id'],$valP['commodity_id']);

								$resultMain[$keyMain]['products'][$keyP]['tax'] = $taxData['tax_name'];

								$priceRange2 = $this->M_android->getProductPrice($valP['id']);
								$priceSpBase = $priceRange2['price'];
								@$taxAmountBase = ($priceRange2['price']/100)*$taxData['rate'];
								$discountAmount = 0;
								$priceTo = $priceRange[0]['moq']-1;
								$price[] = array('from'=>"1",'to'=>$priceTo,'price'=>$priceSpBase,'tax_amount'=>$taxAmountBase,'discount_amount'=>$discountAmount);

							$taxData= $this->getUserTax($data['user_id'],$valP['commodity_id']);
							$resultMain[$keyMain]['products'][$keyP]['tax'] = $taxData['tax_name'];
							$userDiscount = $taxData['user_discount'];

							if($valP['quantity'] == 0){
								$resultMain[$keyMain]['products'][$keyP]['stock_available'] = 0;
							}

							foreach($priceRange as $kR=>$vR){
								$priceFrom = $vR['moq'];
								if(@$priceRange[$kR+1]['moq']){
									$priceTo = $priceRange[$kR+1]['moq']-1;
								}else{
									$priceTo = 'Above' ;
								}
								$priceSp = $vR['price'];
								$taxAmount = ($vR['price']/100)*$taxData['rate'];
								//$discountAmount = ($vR['price']/100)*$userDiscount;
								$discountAmount = 0;
								$price[] = array('from'=>$priceFrom,'to'=>$priceTo,'price'=>$priceSp,'tax_amount'=>$taxAmount,'discount_amount'=>$discountAmount);
							}
							$resultMain[$keyMain]['products'][$keyP]['price_range'] = $price;

						
						}else{
							$resultMain[$keyMain]['products'][$keyP]['price_range'] ="";

							$priceRange = $this->M_android->getProductPrice($valP['id']);
							$priceSp = $priceRange['price'];
							@$taxAmount = ($priceRange['price']/100)*$taxData['rate'];
							$discountAmount = 0;

							$resultMain[$keyMain]['products'][$keyP]['tax'] = $taxData['tax_name'];
							$resultMain[$keyMain]['products'][$keyP]['price_range'] = array();
							$resultMain[$keyMain]['products'][$keyP]['price'] = $priceSp;
							$resultMain[$keyMain]['products'][$keyP]['price_tax'] = $taxAmount;
						}
						}
						$final[] = $resultMain[$keyMain];
					}else{
						//unset($resultMain[$keyMain]);
					}
				}
			}
			//$resultMain = array_values($resultMain);
			echo json_encode($final);die;
		}

		//$final = array($result);

		$result = array_values($result);
	
		echo json_encode($result);
	}

	
	public function getUserTax($id,$commodityId){
		
		$userData = $this->M_android->getUserDetails($id);
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
		
		$taxData = $this->M_android->getUserTax($data);
		$taxData['user_discount'] = $userData['discount'];
		
		return $taxData;

	}

	
	//http://192.168.1.4/pumpkart/Android/getProductDetails/?id=&user_id=
	public function getProductDetails()
	{
		$data = $_GET;
		$res = $this->M_android->getProductDetails($data['id']);
		$price = array();

		if($res['quantity'] <= 0){
			$res['stock_available'] = '0';
		}
		//site_url().'assets/image/products/original/'

		$result = array('id' => $res['id'], 'name' => $res['name'],'brand' => $res['brand_name'],'description'=>$res['description'], 'short_description'=>$res['short_description'], 'mrp'=>$res['mrp'], 'sku'=>$res['sku'],'price'=>$res['price'], 'is_featured'=>$res['is_featured'], 'weight'=>$res['weight'], 'care_instructions'=>$res['care_instructions'], 'featured_image' => $res['featured_image'],'stock_available'=>$res['stock_available'], 'warranty'=>$res['warranty'], 'quantity'=>$res['quantity'] );
		$data['product_id'] = $data['id'];
		$priceRange = $this->M_android->getUserProductPriceRange($data);
		//$result['tax'] = $this->getUserTax($data['user_id'],$res['commodity_id']);
		$taxData= $this->getUserTax($data['user_id'],$res['commodity_id']);
		$result['tax'] = $taxData['tax_name'];

		$userDiscount = $taxData['user_discount'];



		if(!empty($priceRange)){
						$priceRange2 = $this->M_android->getProductPrice($data['id']);
						$priceSpBase = $priceRange2['price'];
						@$taxAmountBase = ($priceRange2['price']/100)*$taxData['rate'];
						$discountAmount = 0;
						$priceTo = $priceRange[0]['moq']-1;
						$price[] = array('from'=>"1",'to'=>$priceTo,'price'=>$priceSpBase,'tax_amount'=>$taxAmountBase,'discount_amount'=>$discountAmount);
		foreach($priceRange as $k=>$v){
			$priceFrom = $v['moq'];
			if(@$priceRange[$k+1]['moq']){
				$priceTo = $priceRange[$k+1]['moq']-1;
			}else{
				$priceTo = 'Above' ;
			}
			$priceSp = $v['price'];
			$taxAmount = ($v['price']/100)*$taxData['rate'];
			$discountAmount = ($v['price']/100)*$userDiscount;
			$price[] = array('from'=>$priceFrom,'to'=>$priceTo,'price'=>$priceSp,'tax_amount'=>$taxAmount,'discount_amount'=>$discountAmount);
		}
		$result['price'] = $priceSpBase;
		$result['price_tax'] = $taxAmountBase;
		$result['price_range'] = $price;
		}else{
		//$result['price_range'] = "";
						$priceRange2 = $this->M_android->getProductPrice($data['id']);
						$priceSp = $priceRange2['price'];
						@$taxAmount = ($priceRange2['price']/100)*$taxData['rate'];
						$discountAmount = 0;
						$result['price_range'] = array();
						$result['price'] = $priceSp;
						$result['price_tax'] = $taxAmount;	
		}


		$result['specifications'][] = array('heading' => 'BRAND','value' => $res['brand_name'],'min'=>0,'max'=>0);
		/*if($res['power_rating_hp'] == 0){
			$res['power_rating_hp'] = 'NO';
		}
		if($res['power_rating_kw'] == 0){
			$res['power_rating_kw'] = 'NO';
		}
		if($res['flow_rate_lpm'] == 0){
			$res['flow_rate_lpm'] = 'NO';
		}
		if($res['solid'] == 0 || $res['solid'] == 'null'){
			$res['solid'] = 'NO';
		}
		if($res['bore_diameter_name'] == 0 || $res['bore_diameter_name'] == 'null'){
			$res['bore_diameter_name'] = 'NO';
		}
		if($res['phase_name'] == 0 || $res['phase_name'] == 'null'){
			$res['phase_name'] = 'NO';
		}
		if($res['outlet_size'] == 0 || $res['outlet_size'] == 'null'){
			$res['outlet_size'] = 'NO';
		}*/
		if($res['power_rating_hp'] == 0){
			$res['power_rating_hp'] = 'NO';
		}
		if($res['power_rating_kw'] == 0){
			$res['power_rating_kw'] = 'NO';
		}
		if($res['flow_rate_lpm'] == 0){
			$res['flow_rate_lpm'] = 'NO';
		}

		if($res['stages'] == 0 || $res['stages'] == 'null' || empty($res['stages'])){
			$res['stages'] = 'NO';
		}else{
			$result['specifications'][] = array('heading' => 'STAGES','value' => $res['stages'],'min'=>0,'max'=>0);
		}

		if($res['solid'] == 0 || $res['solid'] == 'null'){
			$res['solid'] = 'NO';
		}else{
			$result['specifications'][] = array('heading' => 'SOLID HANDLING','value' => $res['solid'],'min'=>0,'max'=>0);
		}
		if($res['bore_diameter_name'] == 0 || $res['bore_diameter_name'] == 'null'){
			$res['bore_diameter_name'] = 'NO';
		}else{
			$result['specifications'][] = array('heading' => 'BORE DIAMETER','value' => $res['bore_diameter_name'],'min'=>0,'max'=>0);
		}
		if($res['phase_name'] == 0 || $res['phase_name'] == 'null'){
			$res['phase_name'] = 'NO';
		}else{
			$result['specifications'][] = array('heading' => 'PHASE','value' => $res['phase_name'],'min'=>0,'max'=>0);
		}
		if($res['outlet_size'] == 0 || $res['outlet_size'] == 'null'){
			$res['outlet_size'] = 'NO';
		}else{
			$result['specifications'][] = array('heading' => 'OUTLET SIZE','value' => $res['outlet_size'],'min'=>0,'max'=>0);
		}
		if($res['inlet_size'] == 0 || $res['inlet_size'] == 'null'){
			$res['inlet_size'] = 'NO';
		}else{
			$result['specifications'][] = array('heading' => 'INLET SIZE','value' => $res['inlet_size'],'min'=>0,'max'=>0);
		}

		if($res['tank_type'] == 0 || $res['tank_type'] == 'null' || empty($res['tank_type'])){
			$res['tank_type'] = 'NO';
		}else{
			$result['specifications'][] = array('heading' => 'Tank Type','value' => $res['tank_type'],'min'=>0,'max'=>0);
		}

		if($res['tank_capacity'] == 0 || $res['tank_capacity'] == 'null' || empty($res['tank_capacity'])){
			$res['tank_capacity'] = 'NO';
		}else{
			$result['specifications'][] = array('heading' => 'Tank Capacity','value' => $res['tank_capacity'],'min'=>0,'max'=>0);
		}

		if($res['rpm'] == 0 || $res['rpm'] == 'null' || empty($res['rpm'])){
			$res['rpm'] = 'NO';
		}else{
			$result['specifications'][] = array('heading' => 'RPM','value' => $res['rpm'],'min'=>0,'max'=>0);
		}

		if($res['flow_min'] == "0" && $res['flow_max'] == '0'){
			$res['flow_min'] = 'NO';
		}else{
			$flow_unit = $res['flow_unit'];
			
			if($flow_unit == 'lps'){
				$res['flow_min'] = $res['flow_min']*60;
				$res['flow_max'] = $res['flow_max']*60;
			}else if($flow_unit == 'lph'){
				$res['flow_min'] = $res['flow_min']/60;
				$res['flow_max'] = $res['flow_max']/60;
			}else if($flow_unit == 'gpm'){
				$res['flow_min'] = $res['flow_min']/0.264172;
				$res['flow_max'] = $res['flow_max']/0.264172;
			}else if($flow_unit == 'm3h'){
				$res['flow_min'] = $res['flow_min']/0.06;
				$res['flow_max'] = $res['flow_max']/0.06;
			}


			$result['specifications'][] = array('heading' => "FLOW RATE(LPM)",'value' => '','min'=>$res['flow_min'],'max'=>$res['flow_max']);
		}

		if($res['head_min'] == '0' && $res['head_max'] == '0'){
			$res['head_min'] = 'NO';
		}else{
			$result['specifications'][] = array('heading' => 'HEAD RANGE','value' => '','min'=>$res['head_min'],'max'=>$res['head_max']);
		}

		$result['specifications'][] = array('heading' => 'POWER RATING(HP)','value' => $res['power_rating_hp'],'min'=>0,'max'=>0);
		$result['specifications'][] = array('heading' => 'POWER RATING(KW)','value' => $res['power_rating_kw'],'min'=>0,'max'=>0);
		//$result['specifications'][] = array('heading' => 'FLOW RATE(LPM)','value' => $res['flow_rate_lpm']);
		
		if($res['pressure'] != 0 && $res['pressure'] != 'null' && !empty($res['pressure'])){
			$result['specifications'][] = array('heading' => 'PRESSURE','value' => $res['pressure'],'min'=>0,'max'=>0);
		}
		/*if($res['bore_diameter'] != 0 && $res['bore_diameter'] != 'null' && !empty($res['bore_diameter'])){
			$result['specifications'][] = array('heading' => 'BORE DIAMETER','value' => $res['bore_diameter']);
		}*/

		
		
		if(!empty($res['bathrooms'])){
		$result['specifications'][] = array('heading' => 'NO. OF BATHROOMS','value' => $res['bathrooms'],'min'=>0,'max'=>0);
		}
		//$result['specifications'][] = array('heading' => 'HEAD IN FEET','value' => $res['head_feet']);
		$result['specifications'][] = array('heading' => 'PRICE','value' => $res['price'],'min'=>0,'max'=>0);

		$result['images'] = $this->M_android->getImages($data['id']);
		foreach($result['images'] as $kI=>$vI){
			$result['images'][$kI] = site_url().'assets/image/products/original/'.$vI['image'];
		}
		
		//$final = array($result);
		echo json_encode($result);
	}


	//http://192.168.1.4/pumpkart/Android/getHomeData/
	public function getHomeData()
	{
		$data = $_GET;
		$result = $this->M_android->getMainCategories();
		$userData = $this->M_android->getUserDetails($data['user_id']);

		if(!empty($result)){
			foreach($result as $k=>$v){
				$haveBest = 0;
				$result[$k]['subcategories'] = $this->M_android->subCategories($v['id']);
				foreach($result[$k]['subcategories'] as $key=>$val){

					$result[$k]['subcategories'][$key]['name'] = ucwords(strtolower($result[$k]['subcategories'][$key]['name']));
					$bestProducts = $this->M_android->getTempProduct($val['id']);
					if(!empty($bestProducts)){
						foreach($bestProducts as $kBp=>$vBp){
						//site_url().'assets/image/products/original/'
					 	$vBp['featured_image'] = $vBp['featured_image']; 
					 	$result[$k]['bestProducts'][] = $vBp;
					 	$result[$k]['userDiscount'] = $userData['discount'];
					 	$haveBest = 1;
					 	}
					}else{
						if($haveBest == 0){
						$result[$k]['bestProducts']=array();;
						}
						$haveBest = 1;
					}
				}
			}
			
			$final = $result;
		}else{
			$final = array('success' =>'0' ,'message'=>'No data found');
		}
		
		echo json_encode($final);
	}


	//http://192.168.1.4/pumpkart/Android/getHomeData/
	public function getHomeDataNew()
	{
		$data = $_GET;
		$result = $this->M_android->getMainCategories();
		$userData = $this->M_android->getUserDetails($data['user_id']);

		if(!empty($result)){
			foreach($result as $k=>$v){
				$haveBest = 0;
				$result[$k]['subcategories'] = $this->M_android->subCategories($v['id']);
				foreach($result[$k]['subcategories'] as $key=>$val){

					$result[$k]['subcategories'][$key]['name'] = ucwords(strtolower($result[$k]['subcategories'][$key]['name']));
					$bestProducts = $this->M_android->getTempProduct($val['id']);
					
					$bestProductsByCount = $this->M_android->getBestProducts($val['id'],4);
					array_push($bestProducts, $bestProductsByCount);

					if(!empty($bestProducts)){
						foreach($bestProducts as $kBp=>$vBp){
						//site_url().'assets/image/products/original/'
					 	$vBp['featured_image'] = $vBp['featured_image']; 
					 	$result[$k]['bestProducts'][] = $vBp;
					 	$result[$k]['userDiscount'] = $userData['discount'];
					 	$haveBest = 1;
					 	}
					}else{
						if($haveBest == 0){
						$result[$k]['bestProducts']=array();;
						}
						$haveBest = 1;
					}
				}
			}
			
			$final = $result;
		}else{
			$final = array('success' =>'0' ,'message'=>'No data found');
		}
		
		echo json_encode($final);
	}


	//http://192.168.1.4/pumpkart/Android/autoSuggestionList/?searchText=
	
	public function autoSuggestionList()
	{
		$searchText = urldecode($_REQUEST['searchText']);
		$data = array('searchText'=>$searchText);
		
		$autoSuggestionListData = $this->M_android->autoSuggestionList($data);
		if(!empty($autoSuggestionListData)){
			/*foreach($autoSuggestionListData as $key=>$val){
				$dataSuggestions[] = $val['name'];
			}*/
			$final = $autoSuggestionListData;
		}else{
				//$dataSuggestions = array('success'=>'false','message'=>'No suggestion found.');
			$final = array('success' =>'0' ,'message'=>'No data found');
		}

		echo json_encode($final);
		
	}

	public function random_gen($qtd){

	$Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
	$QuantidadeCaracteres = strlen($Caracteres);
	$QuantidadeCaracteres--;

	$Hash=NULL;
	    for($x=1;$x<=$qtd;$x++){
	        $Posicao = rand(0,$QuantidadeCaracteres);
	        $Hash .= substr($Caracteres,$Posicao,1);
	    }
	}


	//http://192.168.1.4/pumpkart/Android/getBrands/
	public function getBrands()
	{                                                   
		$result = $this->M_android->getBrands();
		foreach($result as $k=>$v){
			if(empty($v['image'])){
				$result[$k]['image'] = site_url().'assets/image/brand/noimage.jpg';
			}else{
				$result[$k]['image'] = site_url().'assets/image/brand/'.$v['image'];
			}
		}
		echo json_encode($result);
	}


	//http://192.168.1.4/pumpkart/Android/getBrandProducts/?id=
	public function getBrandProducts()
	{
		$data = $_GET;
		$price = array();

				$result['products'] = $this->M_android->getBrandProducts($data['id']);
				if(!empty($result['products'])){
					foreach($result['products'] as $keyP=>$valP){
						$priceRange = $this->M_android->getProductPriceRange($valP['id']);


						foreach($priceRange as $kR=>$vR){
							$priceFrom = $vR['range_from'];
							if(@$priceRange[$kR+1]['range_from']){
								$priceTo = $priceRange[$kR+1]['range_from'];
							}else{
								$priceTo = 'Above' ;
							}
							$priceSp = $vR['price'];
							$price[] = array('from'=>$priceFrom,'to'=>$priceTo,'price'=>$priceSp);
						}
						$result['products'][$keyP]['price'] = $price;
					}
				
				}
		
		echo json_encode($result);
	}


	//http://192.168.1.4/pumpkart/Android/getShippingAddress/?user_id=
	public function getShippingAddress()
	{                                                   
		$userId = $_REQUEST['user_id'];
		$result = $this->M_android->getShippingAddress($userId);
		/*if($result){
			$final = array('success'=>'1', 'data'=>$result);

		}else{
			$final = array('success'=>'0', 'message'=>'No shipping address found.');
		}*/
		
		echo json_encode($result);
	}


	//http://192.168.1.4/pumpkart/Android/placeOrder/
	public function placeOrder()
	{
		
		$inputJSON = file_get_contents('php://input');
		$resultOrderId = $this->M_android->placeOrder($inputJSON);


	/************** Generate Invoice ********************/

	$header  = 'MIME-Version: 1.0' . "\r\n";
    $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $header .= 'From: PUMPKART<noreply@pumpkart.com>' . "\r\n";

		$catResult['details'] = $this->M_order->getOrderDetails($resultOrderId);
		$catResult['customer'] = $this->M_order->getCustomer($catResult['details']['user_id']);
		$catResult['itemList'] = $this->M_order->getOrderItemDetails($resultOrderId);
		$catResult['backendUsers'] = $this->M_android->getBackendUsers();

		$inBundles = array();
		
		$custBody = '<p>Dear '.$catResult['customer']['fname'].' '.$catResult['customer']['lname'].',</p>

		<p>Your order has been successfully placed with following cart.</p>';
		$adminBody = '<p>Hello!,</p>

		<p>New order has been placed with following cart.</p>';

		$body = '
		<div style="width:100%">

		
<div style="float:left;">
<p style="font-size:22px"><img src="'.logo.'" width="150px"></p>
<p>Contact: '.support_contact.'<br>
Email: '.support_email.'
</p>

</div>

<div style="clear:both;"></div>

<table border="0" width="100%" cellpadding="3px">
   <thead>
   <tr align="left" style="background-color: #262E3D; color:#fff;">
    <th>Order No</th>
    <th colspan="3">'.$resultOrderId.'</th>
     </tr>
     <tr align="left" style="background-color: #262E3D; color:#fff;">
       <th>Customer Name</th>
       <th>Company Name</th>
       <th>Mobile</th>
       <th>Email</th>
     </tr>
   </thead>
   <tbody>
     <tr align="left">
       <td>'.$catResult['customer']['fname'].' '.$catResult['customer']['lname'].'</td>
       <td>'.$catResult['customer']['company'].'</td>
       <td>'.$catResult['customer']['mobile'].'</td>
       <td>'.$catResult['customer']['email'].'</td>
     </tr>

     <tr align="left" style="background-color: #262E3D; color:#fff;">
       <th>State</th>
       <th>City</th>
       <th>Location</th>
       <th>Pincode</th>
     </tr>
   </thead>
   <tbody>
     <tr align="left">
     <td>'.$catResult['customer']['state_name'].'</td>
     <td>'.$catResult['customer']['city_name'].'</td>
     <td>'.$catResult['customer']['address_line_1'].'<br> '.$catResult['customer']['address_line_2'].'</td>
     <td>'.$catResult['customer']['pincode'].'</td>
     </tr>
   </tbody>
 </table>

 <h3>Item List</h3>
<hr>

<table border="0" width="100%" cellpadding="3px">
   <thead>
     <tr align="left" style="background-color: #262E3D; color:#fff;">
       <th>Sr.No.</th>
       <th>Item name</th>
       <th>Brand</th>
       <th>Price</th>
       <th>Quantity</th>
       <th>Total Amount</th>
       
     </tr>
   </thead>
   <tbody>';
   	$count = 0;
	$heading = '';
   foreach($catResult['itemList'] as $row){

    $body.= '<tr align="left">
     	<td>'.++$count.'</td>
       	<td>'.$row['product_name'].'</td>
       	<td>'.$row['brand_name'].'</td>
       	<td>'.$row['price_per_unit'].'</td>
       	<td>'.$row['quantity'].'</td>
       	<td>'.$row['total_amount'].'</td>
     	</tr>';

    }

    $body.= '
     <tr valign="center" align="left">
       <td colspan="5"><b>Payment Method</b></td>
      
       <td><b>'.$catResult['details']['payment_method'].'</b></td>
      
     </tr>

    <tr valign="center" align="left" >
       <td colspan="5" ><b>Shipping Charges</b>:</td>
      
       <td>'.$catResult['details']['shipping_charges'].'</td>
      
     </tr>

     <tr valign="center" align="left">
       <td colspan="5"><b>Total Amount</b></td>
      
       <td><b>'.$catResult['details']['net_amount'].'</b></td>
      
     </tr>
   </tbody>
 </table>

 <h3>Delivery Address</h3>
<hr>

<table border="0" width="100%" cellpadding="3px">
   <thead>
     <tr align="left" style="background-color: #262E3D; color:#fff;">
       <th>State</th>
       <th>City</th>
       <th>Location</th>
       <th>Address</th>
     </tr>
   </thead>
   <tbody>
     <tr align="left">
     <td>'.$catResult['details']['delivery_state'].'</td>
     <td>'.$catResult['details']['delivery_city'].'</td>
     <td>'.$catResult['details']['delivery_address_1'].'</td>
     <td>'.$catResult['details']['delivery_address_2'].'</td>     </tr>

   <tbody>

 </table>
 </div>';


//echo $body;
$custSubject = "Your order no. $resultOrderId has been Placed";
$adminSubject = "New order received";


mail($catResult['customer']['email'], $custSubject, $custBody.$body."<p>Happy Shopping,<br>
Pumpkart</p>", $header);// customer email
/*foreach($catResult['backendUsers'] as $rowback){
	mail($rowback['email'], $adminSubject, $adminBody.$body, $header);// anchor email
}*/
mail(orders_email, $adminSubject, $adminBody.$body, $header);// anchor email
			/*$postUrl = sms_postUrl;
			$username = sms_username;
			$password = sms_password;
			$mask = sms_mask;

			$sender = $catResult['customer']['mobile'];
			$result=$this->M_android->getUserByMobile($sender);

			$msg = "Dear " .$result[0]['name']." Ji,\r\n Thank you for placing order with MR BACHAT. You order number is ".$resultOrderId." You shall receive an order confirmation email shortly. For any feedback, please call us on 80599-07770 \r\n
			**Aapki bachat, Aapka Mr Bachat**";
			$postUrl.= "UserName=".$username."&Password=".$password."&Type=Bulk&To=".$sender."&Mask=".$mask."&Message=".urlencode($msg);

         $ch = curl_init();
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_URL, $postUrl);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          $out = curl_exec($ch);*/
          $data['order_id'] = $resultOrderId;
          $data['noti_type'] = '1';

          $resultBack = $this->M_android->getBackendUsers();

        foreach($resultBack as $k=>$v){
        	$data['user_id'] = $v['id'];
          	$resultNoti = $this->M_android->addNotifications($data);
      	}
      	if($catResult['details']['delivery_state_id'] == '32'||$catResult['details']['delivery_state_id'] == '6'){
      		$pkart = true;
      	}else{
      		$pkart = false;
      	}
		$resultorder= array('success'=>'true','message'=>'Order Placed','order_id'=>$resultOrderId,'pkart'=>$pkart, 'order_date'=>date('l d M, Y'));
		echo json_encode($resultorder);
		
	}


	//http://192.168.1.4/pumpkart/Android/getPaymentMethod
	public function getPaymentMethod()
	{
		$result = $this->M_android->getPaymentMethod();	
		echo json_encode($result);
	}

	
	public function getShippingCharges()
	{                                                   
		$stateId = $_REQUEST['state_id'];
		$cityId = $_REQUEST['city_id'];
		$amount = $_REQUEST['amount'];
		$result = $this->M_android->getShippingCharges($stateId,$amount);
		if($result){
			$final = array('success'=>'1', 'shipping_charges'=>$result['price']);

		}else{
			$final = array('success'=>'1', 'shipping_charges'=>'0');
		}
		
		echo json_encode($final);
	}


	//http://192.168.1.4/pumpkart/Android/myOrders/?userId=21
	public function myOrders()
	{
		 $userId = $_REQUEST['userId'];

		$resultOrders = $this->M_android->myOrders($userId);

		if(!empty($resultOrders)){
		foreach ($resultOrders as $key=>$val) {

			$resultOrders[$key]['order_created_date'] = date('d M, Y',strtotime($resultOrders[$key]['order_created_date']));
			$resultOrders[$key]['order_list'] = $this->M_android->myOrderItems($val['order_id']);
			//if(!empty($resultOrders[$key]['order_list']))
			//echo "<pre>";
			//print_r($resultOrders[$key]['order_list']);
			if(!empty($resultOrders[$key]['order_list']))
			{
			foreach($resultOrders[$key]['order_list'] as $k=>$v){

				unset($price);
				$data['product_id'] = $v['product_id'];
				$data['user_id'] = $userId;
				$priceRange = $this->M_android->getUserProductPriceRange($data);
				//$resultOrders[$key]['order_list'][$k]['tax'] = $this->getUserTax($userId,$v['commodity_id']);
				$taxData = $this->getUserTax($userId,$v['commodity_id']);
				$resultOrders[$key]['order_list'][$k]['tax'] = $taxData['tax_name'];
				$userDiscount = $taxData['user_discount'];
				
				if($resultOrders[$key]['order_list'][$k]['quantity']<=0){
					$resultOrders[$key]['order_list'][$k]['stock_available'] = '0';
				}
				if(!empty($priceRange)){
						$priceRange2 = $this->M_android->getProductPrice($v['product_id']);
						$priceSpBase = $priceRange2['price'];
						@$taxAmountBase = ($priceRange2['price']/100)*$taxData['rate'];
						$discountAmount = 0;
						$priceTo = $priceRange[0]['moq']-1;
						$price[] = array('from'=>"1",'to'=>$priceTo,'price'=>$priceSpBase,'tax_amount'=>$taxAmountBase,'discount_amount'=>$discountAmount);
						$resultOrders[$key]['order_list'][$k]['sp'] = "";
						$resultOrders[$key]['order_list'][$k]['price_tax'] = "0";
						foreach($priceRange as $kR=>$vR){
							$priceFrom = $vR['moq'];
							if(@$priceRange[$kR+1]['moq']){
								$priceTo = $priceRange[$kR+1]['moq']-1;
							}else{
								$priceTo = 'Above' ;
							}
							$priceSp = $vR['price'];
							$taxAmount = ($vR['price']/100)*$taxData['rate'];
							$discountAmount = ($vR['price']/100)*$userDiscount;
							$price[] = array('from'=>$priceFrom,'to'=>$priceTo,'price'=>$priceSp,'tax_amount'=>$taxAmount,'discount_amount'=>$discountAmount);
						}
					}else{
						$priceRange2 = $this->M_android->getProductPrice($v['product_id']);
						$priceSp = $priceRange2['price'];
						@$taxAmount = ($priceRange2['price']/100)*$taxData['rate'];
						$discountAmount = 0;
						$priceTo = $priceRange[0]['moq']-1;
						$price = array();
						//$price = $priceSp;
						$resultOrders[$key]['order_list'][$k]['sp'] = $priceSp;
						$resultOrders[$key]['order_list'][$k]['price_tax'] = $taxAmount;
					}

				$resultOrders[$key]['order_list'][$k]['price'] = $price;
				if(!empty($v['image'])){
					//$resultOrders[$key]['order_list'][$k]['image'] ="";
					//site_url().'assets/image/products/original/'.
					$resultOrders[$key]['order_list'][$k]['image'] = $v['image'];
				}

			}
		}
		}	
		}else{
			$resultOrders=array();
		}
		echo json_encode($resultOrders);
	}


	//http://192.168.1.4/pumpkart/Android/getProfile?user_id=
	public function getProfile()
	{
		$userId = $_REQUEST['user_id'];
		$result = $this->M_android->getUserDetails($userId);	
		echo json_encode($result);
	}

	
	//http://192.168.1.4/pumpkart/Android/verifyCoupon?user_id=&code=&amount=
	public function verifyCoupon()
	{
		$userId = $_REQUEST['user_id'];
		$code = $_REQUEST['code'];
		$amount = $_REQUEST['amount'];

		$result = $this->M_android->getCouponDetails($code);

		if(!empty($result)){
		if($result['is_multiple'] == 'Y'){
			if($result){
				if($result['value_type'] == 'P'){
					$discount = ($amount*$result['coupon_value'])/100;
				}else if($result['value_type'] == 'F'){
					$discount = $result['coupon_value'];
				}
				$response = array('success'=>'1','message'=>'Valid coupon code.','coupon_value'=>$result['coupon_value'],'coupon_value_type'=>$result['value_type'],'coupon_discount'=>$discount, 'coupon_id'=>$result['id']);
			}else{
				$response = array('success'=>'0','message'=>'Invalid coupon code.');
			}
		}else{
			$check = $this->M_android->checkUsedCoupon($code,$userId);
			if($check == 0){
				if($result['value_type'] == 'P'){
						$discount = ($amount*$result['coupon_value'])/100;
					}else if($result['value_type'] == 'F'){
						$discount = $result['coupon_value'];
					}
					$response = array('success'=>'1','message'=>'Valid coupon code.','coupon_value'=>$result['coupon_value'],'coupon_value_type'=>$result['value_type'],'coupon_discount'=>$discount, 'coupon_id'=>$result['id']);

			}else{
					$response = array('success'=>'0','message'=>'You have already used this coupon.');
			}

		}
	}else{
		$response = array('success'=>'0','message'=>'Invalid coupon code.');
	}

		echo json_encode($response);
	}


	//http://192.168.1.4/pumpkart/Android/updateProfile/?mobile=9874563210&company=&fname=&lname&password=&address_line_1=&address_line_2=&email=&device_id=&state_id=&city_id=&pincode=&dob=&gender=(M,F)&pan_number=&aadhaar_number=&tin_number=&retailer_id=&firm_id=&device_id=&user_type=&user_id=&old_password=
	public function updateProfile()
	{

		$data = $_GET;
		
		$data['last_login'] = date("d-m-Y g:i:s");
		$return['status'] = 'true';

		if(empty($data['company'])){
			$return['status'] = 'false';
			$return['message'] = 'Company name missing';
		}else{

			if(!isset($data['old_password'])){
				if(!empty($data['password'])){
					$data['password'] = md5($data['password']);
				}else{
					unset($data['password']);
				}
				unset($data['user_type']);
				$result = $this->M_android->updateProfile($data);

				if($result){
					$return = array('status'=>'true','success'=>'1','message'=>'successfully updated.');
				}else{
					$return = array('status'=>'false','success'=>'0','message'=>'Try again.');
				}
			}else if(isset($data['old_password'])){

				if(empty($data['old_password'])){
					if(!empty($data['password'])){
						$data['password'] = md5($data['password']);
					}else{
						unset($data['password']);
					}
					unset($data['user_type']);
					unset($data['old_password']);
					$result = $this->M_android->updateProfile($data);

					if($result){
						$return = array('status'=>'true','success'=>'1','message'=>'successfully updated.');
					}else{
						$return = array('status'=>'false','success'=>'0','message'=>'Try again.');
					}
				}else{

					$userData = $this->M_android->getUserDetails($data['user_id']);
					$data['is_pass_changed'] = 'Y';

					if($userData['password'] == md5($data['old_password'])){
						if(!empty($data['password'])){
						$data['password'] = md5($data['password']);
						}else{
							unset($data['password']);
						}
						unset($data['user_type']);
						unset($data['old_password']);
						$result = $this->M_android->updateProfile($data);

						if($result){
							$return = array('status'=>'true','success'=>'1','message'=>'successfully updated.');
						}else{
							$return = array('status'=>'false','success'=>'0','message'=>'Try again.');
						}
					}else{
						$return = array('status'=>'false','success'=>'0','message'=>'Password do not match.');
					}
				}

			}

		}
		
		echo json_encode($return);
		
	}


	//http://192.168.1.4/pumpkart/Android/generateHash?email=&amount=&productinfo=&firstname=&txnid
	public function generateHash()
	{
		//$key = 'gtKFFx';
		$key = 'O56aM6';
		//$txnid = $this->M_welcome->generateRandomString(20);
		$txnid = $_REQUEST['txnid'];
		
		$amount = $_REQUEST['amount'];
		$productinfo = $_REQUEST['productinfo'];
		$firstname = $_REQUEST['firstname'];
		$email = $_REQUEST['email'];
		//$salt = 'eCwWELxi';
		$salt = '21xdPaxX';
		$hash_string = $key."|".$txnid."|".$amount."|".$productinfo."|".$firstname."|".$email."|||||||||||".$salt;
        $hash = strtolower(hash('sha512', $hash_string));

        $result = array('hash'=>$hash,'txnid'=>$txnid);
		echo json_encode($result);
	}

	//http://192.168.1.4/pumpkart/Android/successPayu?
	public function successPayu()
	{
        
	}

	//http://192.168.1.4/pumpkart/Android/failurePayu?
	public function failurePayu()
	{
        
	}
	 
	//http://192.168.1.4/pumpkart/Android/getBanners
	public function getBanners()
	{
		$result = $this->M_android->getBanners();
		foreach($result as $val){
			$images[]=$val['image'];
		}

		echo json_encode($images);
	}

	//http://192.168.1.4/pumpkart/Android/forgotPassword/?mobile=123456789
	public function forgotPassword()
	{

		$data = $_REQUEST;
		$result = $this->M_android->checkMobile($data['mobile']);
      
		if(!$result){

			$result['status'] = 'false';
			$result['message'] = 'Mobile does not exist.';
			$msg= array('success'=>'0','message'=>$result['message']);

		}else{

			$return['otp']= rand(1000, 9999);
			$this->M_android->resendSendSMS($data['mobile'],$return['otp']);
			$result=$this->M_android->getUserByMobile($data['mobile']);
			$msg= array('success'=>'1','otp'=>$return['otp']);

		}

		echo json_encode($msg);

	}

	//http://192.168.1.4/pumpkart/Android/resetPassword/?mobile=123456789&password=123&old_password=
	public function resetPassword()
	{
		$data = $_REQUEST;

		$result = $this->M_android->checkMobile($data['mobile']);
		$userData = $this->M_android->getUserDetails($result['id']);

		if(!isset($data['old_password'])){
			$finalResult = $this->M_android->updatePassword($result['id'],md5($data['password']));

			if($finalResult){
				$msg= array('success'=>'1','message'=>'Password successfully reset.');
			}else{
				$msg= array('success'=>'0','message'=>'Password could not be reset. Try again.');
			}
		}else if(isset($data['old_password'])){
			if($userData['password'] == md5($data['old_password'])){
				unset($data['old_password']);
				$finalResult = $this->M_android->updatePassword($result['id'],md5($data['password']));

				if($finalResult){
					$msg= array('success'=>'1','message'=>'Password successfully reset.');
				}else{
					$msg= array('success'=>'0','message'=>'Password could not be reset. Try again.');
				}
			}else{
				$return = array('status'=>'false','success'=>'0','message'=>'Password do not match.');
			}


		}

		echo json_encode($msg);

	}


	//http://192.168.1.4/pumpkart/Android/addAskForQuote/?user_id=&product_id=
	public function addAskForQuote()
	{

		$data = $_GET;
		$data['created'] = date("Y-m-d H:i:s");
		$return['status'] = 'true';

			$result = $this->M_android->addAskForQuote($data);
			
			if($result){
				$return = array('status'=>'true','success'=>'1','message'=>'Thanks for submitting.');
			}else{
				$return = array('status'=>'false','success'=>'0','message'=>'Try again.');
			}

		echo json_encode($return);
		
	}


	//http://192.168.1.4/pumpkart/Android/addUserPump/?user_id=
	public function addUserPump()
	{
		//$inputJSON =  $_REQUEST['data'];
		$inputJSON =  stripslashes(urldecode($_REQUEST['data']));
		
		$userId = $_REQUEST['user_id'];
		$result = $this->M_android->addUserPump($inputJSON,$userId);
		
		if($result){
			$return = array('success'=>'1','message'=>'Thank you for submitting.');
		}else{
			$return = array('success'=>'0','message'=>'Try again.');
		}

		echo json_encode($return);
	}


	//http://192.168.1.4/pumpkart/Android/addCapitalQuery/?user_id=
	public function addCapitalQuery()
	{
		
		$data['user_id'] = $_REQUEST['user_id'];
		$result = $this->M_android->addCapitalQuery($data);
		
		if($result){
			$return = array('success'=>'1','message'=>'Thank you for submitting.');
		}else{
			$return = array('success'=>'0','message'=>'Try again.');
		}

		echo json_encode($return);
	}

	//http://192.168.1.4/pumpkart/Android/myQueries/?user_id=
	public function myQueries()
	{
		$userId = $_REQUEST['user_id'];
		$result = $this->M_android->getMyQueries($userId);
		$final = array();
		$return = array();
		if(!empty($result)){
		foreach($result as $k=>$v){
			$final['date'] = date('d M, Y ',strtotime($v['created'])) ."at ".date('h:i A',strtotime($v['created']));
			$final['text'] = $v['application'];
			$final['question'] = $v;
			$return[] = $final;
		}
		}
		
		echo json_encode($return);
	}




	/****************************************************************************************************/


	
	

	public function getProductSearch()
	{
		//http://192.168.1.4/mrbachat/Android/getProductSearch/?locationId=&searchText=dal

		$searchText = $_REQUEST['searchText'];
		$locationId = $_REQUEST['locationId'];
		
		$data = array('searchText'=>$searchText, 'locationId'=>$locationId);
		$autoSuggestionListData = $this->M_android->autoSuggestionList($data);

		foreach($autoSuggestionListData as $key=>$val){

			$productId = $val['product_id'];
			$locationId = $_REQUEST['locationId'];
			$resultProducts = $this->M_android->getProductSearch($productId,$locationId);
			$resultProducts['attributes'] = $this->M_android->getProductSearchAttributes($productId,$locationId);
			$mul_images =array();

			$temp_images =  $this->M_android->getProductsImages($resultProducts['product_id']);
						if(!empty($temp_images))
						{
							foreach($temp_images as $v1){
								foreach($v1 as $key1=>$val1){
								$mul_images[]=$val1;
								}
							}
							$resultProducts['images'] = $mul_images;
							}else{
							$resultProducts['images'] = "";
						}
			
			if(!empty($resultProducts)){
				$productData[] = $resultProducts;
			}
		}

		if(empty($productData)){
			$productData= array('success'=>'0','message'=>'No products founds.');
		}
		
		echo json_encode($productData);
	}



	public function updateCart()
	{
		$inputJSON = json_decode(file_get_contents('php://input'));
		//$inputJSON = json_decode('{"locationId":1,"data":[{"stock":2,"discount":0.0,"id":"4","is_outstock":0,"is_price_changed":0,"mrp":0.0,"quantity_mu_name":"1 kg","quantity_mu_id":7,"sp":100.0,"totalProductMrpPrice":0.0,"totalProductSellingPrice":200.0,"units":2},{"stock":29,"discount":0.0,"id":"1","is_outstock":0,"is_price_changed":0,"mrp":0.0,"quantity_mu_name":"6 pcs.","quantity_mu_id":2,"sp":50.0,"totalProductMrpPrice":0.0,"totalProductSellingPrice":250.0,"units":5}]}');
		$locationId = $inputJSON->locationId;
		$any_change = 0;

		foreach($inputJSON->data as $val){

			$data2['productId'] = $this->M_android->getProductId($val->id);
			$data2['measuringUnit'] = $val->quantity_mu_id;
			$data2['units'] = $val->units;

			$result = $this->M_android->checkAvailibility($data2,$locationId);

			if(!empty($result)){
				$result['is_outstock'] = 0;
				$result['is_price_changed'] = 0;
				$result['is_vendor_changed'] = 0;
				$result['units']=$val->units;

				if($result['id'] != $val->id){
					$result['is_vendor_changed'] = 1;
					$any_change = 1;
				}
				if($result['sp'] != $val->sp)
				{
					$result['is_price_changed'] = 1;
					$any_change = 1;
				}
			}else{

				$result = $this->M_android->getVendorProductDetails($val->id);
				$result['is_outstock'] = 1;
				$result['units']=0;
				$any_change = 1;
				$result['is_price_changed'] = 0;
				$result['is_vendor_changed'] = 0;

			}

			$data[] = $result;
		}

		$msg = array("has_changed"=>$any_change,"vendor_products"=>$data);
		
		echo json_encode($msg);
	
	}


    
	//http://192.168.1.4/pumpkart/Android/paytmPayment/?user_id=
	public function paytmPayment()
	{
		
		$payeeEmailId = $_REQUEST['payeeEmailId'];
		$payeePhoneNumber = $_REQUEST['payeePhoneNumber'];
		$amount = $_REQUEST['amount'];
		$orderID = $_REQUEST['orderID'];
		
		header("Pragma: no-cache");
		header("Cache-Control: no-cache");
		header("Expires: 0");
		header('Content-type: application/json');
		// following files need to be included

		require_once(APPPATH.'libraries/paytm/encdec_paytm.php');

		$checkSum = "";
		$paramList = array();
		$merchantGuid = "463b5218-97f2-40f0-b84e-3278850e07b8";
		$salesWallet = "8c1b83e3-84a4-4559-a53e-d0efba4038bc";
		//$orderID = rand();
		

		$paramList['request'] = array( 'requestType' =>'verify',
				'merchantGuid' => $merchantGuid,
				'merchantOrderId' => $orderID,
				'salesWalletGuid'=>$salesWallet,
				'payeeEmailId'=>$payeeEmailId,
				'payeePhoneNumber'=>$payeePhoneNumber,
				'payeeSsoId'=>'',
				'appliedToNewUsers'=>'Y',
				'amount'=>$amount,
				'currencyCode'=>'INR');

		$paramList['metadata'] = 'Pumpkart Product';
		$paramList['ipAddress'] = '192.168.40.11';
		$paramList['operationType'] = 'SALES_TO_USER_CREDIT';
		$paramList['platformName'] = 'PayTM';

		$data_string = json_encode($paramList); 

		//Here checksum string will return by getChecksumFromArray() function.
		$checkSum = getChecksumFromString($data_string,"E21VRY7ibUecSDxL");

		$ch = curl_init();                    // initiate curl
		$url = "https://trust.paytm.in/wallet-web/salesToUserCredit"; // where you want to post data

		$headers = array('Content-Type:application/json','mid:'.$merchantGuid,'checksumhash:'.$checkSum);


		$ch = curl_init();  // initiate curl
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);  // tell curl you want to post something
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string); // define what you want to post
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$output = curl_exec ($ch); // execute
		$info = curl_getinfo($ch);
		//print_r($info)."<br />";

		echo $output;
		
		
		
	}


		//http://192.168.1.4/pumpkart/Android/paytmPayment/?user_id=
	public function getChecksum()
	{
		
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
// following files need to be included
require_once(APPPATH.'libraries/paytm/encdec_paytm.php');
require_once(APPPATH.'libraries/paytm/config_paytm.php');
$checkSum = "";
// below code snippet is mandatory, so that no one can use your checksumgeneration url for other purpose .
$findme   = 'REFUND';
$paramList = array();
$paramList["MID"] = '';
$paramList["ORDER_ID"] = '';
$paramList["CUST_ID"] = '';
$paramList["INDUSTRY_TYPE_ID"] = '';
$paramList["CHANNEL_ID"] = '';
$paramList["TXN_AMOUNT"] = '';
$paramList["WEBSITE"] = '';

$inputJSON = file_get_contents('php://input');
$inputJSONArray = json_decode($inputJSON);

foreach($inputJSONArray as $key=>$value)
{  
  $pos = strpos($value, $findme);
  if ($pos === false) 
    {
        $paramList[$key] = $value;
    }
}
 //print_r($paramList);die;
//Here checksum string will return by getChecksumFromArray() function.
	$checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
//print_r($_POST);
 echo json_encode(array("CHECKSUMHASH" => $checkSum,"ORDER_ID" => $paramList["ORDER_ID"], "payt_STATUS" => "1"));
		
}


	public function verifyCheckSum_old()
	{
		

		header("Pragma: no-cache");
		header("Cache-Control: no-cache");
		header("Expires: 0");

		require_once(APPPATH.'libraries/paytm/encdec_paytm.php');
		require_once(APPPATH.'libraries/paytm/config_paytm.php');
		$paytmChecksum = "";
		$paramList = array();
		$isValidChecksum = FALSE;
		$paramList = $_POST;
		$return_array = $_POST;
		$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg


		$return_array["IS_CHECKSUM_VALID"] = $isValidChecksum ? "Y" : "N";

		unset($return_array["CHECKSUMHASH"]);
		$encoded_json = htmlentities(json_encode($return_array));
	}

	public function verifyCheckSum()
	{
		

		header("Pragma: no-cache");
		header("Cache-Control: no-cache");
		header("Expires: 0");
		// following files need to be included
		require_once(APPPATH.'libraries/paytm/encdec_paytm.php');
		require_once(APPPATH.'libraries/paytm/config_paytm.php');
		$paytmChecksum = "";
		$paramList = array();
		$isValidChecksum = FALSE;
		$paramList = $_POST;
		$return_array = $_POST;
		$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
		//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
		$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
		// if ($isValidChecksum===TRUE)
		// 	$return_array["IS_CHECKSUM_VALID"] = "Y";
		// else
		// 	$return_array["IS_CHECKSUM_VALID"] = "N";
		$return_array["IS_CHECKSUM_VALID"] = $isValidChecksum ? "Y" : "N";
		//$return_array["TXNTYPE"] = "";
		//$return_array["REFUNDAMT"] = "";
		unset($return_array["CHECKSUMHASH"]);
		$result['encoded_json'] = htmlentities(json_encode($return_array));

		$this->load->view('order/v_paytm_verify',$result);
	}
      

}



     