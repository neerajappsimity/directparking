<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ride extends CI_Controller 
{

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
	
	function __construct() 
	{
	  	//@session_start();
	  	parent::__construct();
		$this->load->database();
		//if($this->user->logged() == FALSE) {
       	//redirect("/login");
    	//}

    	$this->load->model('M_user');
    	$this->load->model('M_android');
    	$this->load->model('M_product');
    	$this->load->model('M_student');
    	$this->load->model('M_ride');

		$this->load->library('session');
    	$this->load->helper('url');
		if(($this->session->userdata('user_name')==""))
  		{ 
			redirect('Welcome/login');
		}
    }
	


	//public function forgotPassword()
	//{
		/*if (!empty($_POST)) {
            $data = $_POST;
            
            
           	unset($data['tempShip']);

       
        }*/
	
		//$id = base64_decode($_GET['tocken']);
		//$catResult['userData'] = $this->M_user->getUserDetails($id);
		//$catResult['locationsData'] = $this->M_user->getLocationsDetails($id);
		//print_r($catResult['locationsData']);die();
		//print_r($catResult['userData']);die();
		//$this->M_user->updateUserNotification($id);
		//$catResult['pageHeading'] = 'View University';

		//$this->load->view('v_header');
		//$this->load->view('user/v_forgotPassword');
		//$this->load->view('v_footer');	
	//}

	public function changePassword(){
		$data = $_POST['id'];
		$changePassword=$this->M_user->changePassword($id);
		if(!empty($changePassword)){
			$msg="Your Password has been change successFully.";

		}

	}

	public function index($keyword = 'null')
	{
		$keyword = urldecode($keyword);
		$filter = array();
		$keywordDuplicate = $keyword;
	    if($keyword == 'null') {
            $keyword = '';
        }
       

		$this->load->model('M_ride');
		//$this->load->model('M_ride');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'ride/index/' . $keywordDuplicate . '/';
		
		$count = $this->M_ride->countRide($keyword,$filter=null);
		$config['total_rows'] = $count;
		$config["uri_segment"] = 4;
		$limit = 20;
		$start = $this->uri->segment(4, 0);
		$config['per_page'] = $limit;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = '>';
		$config['prev_link'] = '<';
		$config['last_link'] = '>>';
		$config['first_link'] = '<<';
		$this->pagination->initialize($config);
		$result['pagination'] =  $this->pagination->create_links();
		
		$result["users"] = $this->M_ride->getRides($start,$limit,$keyword,$filter=null);	
		/*echo "<pre>";
		print_r($result["users"]);	
		echo "</pre>";*/
		$result['pageHeading'] = 'Manage Ride';
		$result['startPage'] = $start;
		$result['pageFunction'] = 'index';
				
		$this->load->view('v_header');
		$this->load->view('ride/v_rideList',$result);
		$this->load->view('v_footer');
	}


	public function exportData()
		{
			$rides = $this->M_ride->getRides($start=null,$limit=null,$keyword=null,$filter=null);
			
			foreach ($rides as $key => $value) {
				
				$tempRideData['Student Name']=$value['fname'].' '.$value['lname'];
				$tempRideData['University Name']=$value['university_name'];
				$tempRideData['Email']=$value['email'];
				$tempRideData['Mobile']=$value['mobile'];
				$tempRideData['Schedule Date']=$value['schedule_date'];
				$tempRideData['Pick Address']=$value['pick_address'];
				$tempRideData['Drop Address']=$value['drop_address'];
				$tempRideData['Ride Status']=$value['status'];
				$rideData[]=$tempRideData;
			}

			 $this->load->helper('exportData');
			 $fileName = "Ride_export_data" . date('Ymd') . ".xls";
    
    		// headers for download
		    header("Content-Disposition: attachment; filename=\"$fileName\"");
		    header("Content-Type: application/vnd.ms-excel");
		    
		    $flag = false;
		    foreach($rideData as $row=>$value) {
		        if(!$flag) {
		            // display column names as first row
		            echo implode("\t", array_keys($value)) . "\n";
		            $flag = true;
		        }
		        // filter data
		        array_walk($value, 'filterData');
		        echo implode("\t", array_values($value)) . "\n";

		    }

			exit();
			redirect('ride/index');
			

			die;
		}


	public function changeStatus()
	{
		$data = $_POST;

		$result = $this->M_student->changeStatus($data);
		echo $result;
	}

	public function changeVerified()
	{
		$data = $_POST;
		//print_r($data);
		$check = $this->M_user->checkVerified($data);

		if(($check['is_verified'] == 'N' || $check['is_verified'] == 'P') &&  $data['is_verified']=='Y'){
			$msg = "Thank you for signing up. Your account has been verified. Let’s get you started!";
			$this->M_android->commonSMS($check['mobile'],$msg);
			$header  = 'MIME-Version: 1.0' . "\r\n";
		    $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		    $header .= 'From: PUMPKART<noreply@pumpkart.com>' . "\r\n";
			$body = "Dear Customer,

			Congratulations! Thank you for signing up. Your account has been verified. Now, You can login the app with your username and password. Let’s get you started!
			";
			$subject = "Account Varification: Pumpkart";

			mail($check['email'], $subject, $body, $header);
		}
		
		if(!$data['is_verified']=='N'){
			$data['reason'] = "";
		}

		$result = $this->M_user->changeVerified($data);
		echo $result;
	}
	
	public function deleted()
	{
		$data = $_POST;
		$data['archive'] = 'Y';

		$result = $this->M_student->deleted($data);
		echo $result;
	}
	
	public function add()
	{
		
		if (!empty($_POST)) {
			//$data['is_pass_changed']='N';
			$data['created'] = date('Y-m-d H:i:s');
            $data = $_POST;
           // $password = $this->getRandomDigit(6);
           	//$data['password'] = md5($password);
           	
           //	$msg  = "Greetings of the day! Pumpkart welcomes you to shop online using the Username: ".$data['mobile']."' and Password: '".$password."' details\r\n ";
           	//$this->M_android->commonSMS($data['mobile'],$msg);

           	//$data['password'] = md5('123456');
           	$locationData['lat']=$data['lat'];
           	$locationData['log']=$data['log'];
           	$locationData['location_name']=$data['location_name'];
           	unset($data['lat']);
           	unset($data['log']);
           	unset($data['location_name']);

            $result = $this->M_user->add($data);
            $locationData['university_id'] = $result['insert_id'];

            if(!empty($locationData['location_name'][0])){
	        	foreach($locationData['location_name'] as $rpKey=>$rpVal){
	        		$locationData['location_name'] = $rpVal;
	        		$dataPrice['lat'] = $locationData['lat'][$rpKey];
	        		$dataPrice['log'] = $locationData['log'][$rpKey];
	        		
	    
	        		if(!empty($locationData['lat']) && !empty($locationData['log'])){
	        			
	        			$resultLocation = $this->M_user->addLocation($locationData);
	        		}
	        	}
	        }


            

            if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }
		
		//$result["firms"] = $this->M_user->getFirm();
		//$result["states"] = $this->M_user->getState();

		$result['pageHeading'] = 'Add University';
		$this->load->view('v_header');
		$this->load->view('user/v_userAdd',$result);
		$this->load->view('v_footer');	
	}



	public function view()
	{
		if (!empty($_POST)) {
            $data = $_POST;
            
            
           	unset($data['tempShip']);

       
        }
	
		$id = base64_decode($_GET['id']);
		$catResult['userData'] = $this->M_student->getUserDetails($id);
		$catResult['locationsData'] = $this->M_user->getLocationsDetails($id);
		//print_r($catResult['locationsData']);die();
		//print_r($catResult['userData']);die();
		$this->M_user->updateUserNotification($id);
		$catResult['pageHeading'] = 'View Students';

		$this->load->view('v_header');
		$this->load->view('student/v_studentView',$catResult);
		$this->load->view('v_footer');	
	}
































	public function retailer($keyword = 'null')
	{
		$keyword = urldecode($keyword);
		$filter = array();
		$keywordDuplicate = $keyword;
	    if($keyword == 'null') {
            $keyword = '';
        }
       $filter['user_type_id'] = '2'; 

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'user/retailer/' . $keywordDuplicate . '/';
		
		$count = $this->M_user->countUsers($keyword,$filter);
		$config['total_rows'] = $count;
		$config["uri_segment"] = 4;
		$limit = 20;
		$start = $this->uri->segment(4, 0);
		$config['per_page'] = $limit;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = '>';
		$config['prev_link'] = '<';
		$config['last_link'] = '>>';
		$config['first_link'] = '<<';
		$this->pagination->initialize($config);
		$result['pagination'] =  $this->pagination->create_links();
		
		$result["users"] = $this->M_user->getUsers($start,$limit,$keyword,$filter);		
		
		$result['pageHeading'] = 'Manage Retailers';
		$result['startPage'] = $start;
		$result['pageFunction'] = 'retailer';
				
		$this->load->view('v_header');
		$this->load->view('user/v_userlist',$result);
		$this->load->view('v_footer');
	}

	public function industry($keyword = 'null')
	{
		$keyword = urldecode($keyword);
		$filter = array();
		$keywordDuplicate = $keyword;
	    if($keyword == 'null') {
            $keyword = '';
        }
       $filter['user_type_id'] = '3'; 

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'user/industry/' . $keywordDuplicate . '/';
		
		$count = $this->M_user->countUsers($keyword,$filter);
		$config['total_rows'] = $count;
		$config["uri_segment"] = 4;
		$limit = 20;
		$start = $this->uri->segment(4, 0);
		$config['per_page'] = $limit;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = '>';
		$config['prev_link'] = '<';
		$config['last_link'] = '>>';
		$config['first_link'] = '<<';
		$this->pagination->initialize($config);
		$result['pagination'] =  $this->pagination->create_links();
		
		$result["users"] = $this->M_user->getUsers($start,$limit,$keyword,$filter);		
		
		$result['pageHeading'] = 'Manage Industry/OEM';
		$result['startPage'] = $start;
		$result['pageFunction'] = 'industry';
				
		$this->load->view('v_header');
		$this->load->view('user/v_userlist',$result);
		$this->load->view('v_footer');
	}



	public function customer($keyword = 'null')
	{
		$keyword = urldecode($keyword);
		$filter = array();
		$keywordDuplicate = $keyword;
	    if($keyword == 'null') {
            $keyword = '';
        }
       $filter['user_type_id'] = '8'; 

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'user/customer/' . $keywordDuplicate . '/';
		
		$count = $this->M_user->countUsers($keyword,$filter);
		$config['total_rows'] = $count;
		$config["uri_segment"] = 4;
		$limit = 20;
		$start = $this->uri->segment(4, 0);
		$config['per_page'] = $limit;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = '>';
		$config['prev_link'] = '<';
		$config['last_link'] = '>>';
		$config['first_link'] = '<<';
		$this->pagination->initialize($config);
		$result['pagination'] =  $this->pagination->create_links();
		
		$result["users"] = $this->M_user->getUsers($start,$limit,$keyword,$filter);		
		
		$result['pageHeading'] = 'Manage Customers';
		$result['startPage'] = $start;
		$result['pageFunction'] = 'customer';
				
		$this->load->view('v_header');
		$this->load->view('user/v_userlist',$result);
		$this->load->view('v_footer');
	}

	
	public function pending($keyword = 'null')
	{
		$keyword = urldecode($keyword);
		$filter = array();
		$keywordDuplicate = $keyword;
	    if($keyword == 'null') {
            $keyword = '';
        }
       	$filter['is_verified'] = 'P'; 

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'user/pending/' . $keywordDuplicate . '/';
		
		$count = $this->M_user->countUsers($keyword,$filter);
		$config['total_rows'] = $count;
		$config["uri_segment"] = 4;
		$limit = 20;
		$start = $this->uri->segment(4, 0);
		$config['per_page'] = $limit;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = '>';
		$config['prev_link'] = '<';
		$config['last_link'] = '>>';
		$config['first_link'] = '<<';
		$this->pagination->initialize($config);
		$result['pagination'] =  $this->pagination->create_links();
		
		$result["users"] = $this->M_user->getUsers($start,$limit,$keyword,$filter);		
		
		$result['pageHeading'] = 'Manage Pending Users';
		$result['startPage'] = $start;
		$result['pageFunction'] = 'pending';

		$this->load->view('v_header');
		$this->load->view('user/v_userlist',$result);
		$this->load->view('v_footer');
	}

	public function verified($keyword = 'null')
	{
		$keyword = urldecode($keyword);
		$filter = array();
		$keywordDuplicate = $keyword;
	    if($keyword == 'null') {
            $keyword = '';
        }
       	$filter['is_verified'] = 'Y'; 

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'user/verified/' . $keywordDuplicate . '/';
		
		$count = $this->M_user->countUsers($keyword,$filter);
		$config['total_rows'] = $count;
		$config["uri_segment"] = 4;
		$limit = 20;
		$start = $this->uri->segment(4, 0);
		$config['per_page'] = $limit;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = '>';
		$config['prev_link'] = '<';
		$config['last_link'] = '>>';
		$config['first_link'] = '<<';
		$this->pagination->initialize($config);
		$result['pagination'] =  $this->pagination->create_links();
		
		$result["users"] = $this->M_user->getUsers($start,$limit,$keyword,$filter);		
		
		$result['pageHeading'] = 'Manage Verified Users';
		$result['startPage'] = $start;
		$result['pageFunction'] = 'verified';

		$this->load->view('v_header');
		$this->load->view('user/v_userlist',$result);
		$this->load->view('v_footer');
	}

	public function nonVerified($keyword = 'null')
	{
		$keyword = urldecode($keyword);
		$filter = array();
		$keywordDuplicate = $keyword;
	    if($keyword == 'null') {
            $keyword = '';
        }
       	$filter['is_verified'] = 'N'; 

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'user/nonVerified/' . $keywordDuplicate . '/';
		
		$count = $this->M_user->countUsers($keyword,$filter);
		$config['total_rows'] = $count;
		$config["uri_segment"] = 4;
		$limit = 20;
		$start = $this->uri->segment(4, 0);
		$config['per_page'] = $limit;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = '>';
		$config['prev_link'] = '<';
		$config['last_link'] = '>>';
		$config['first_link'] = '<<';
		$this->pagination->initialize($config);
		$result['pagination'] =  $this->pagination->create_links();
		
		$result["users"] = $this->M_user->getUsers($start,$limit,$keyword,$filter);		
		
		$result['pageHeading'] = 'Manage Non-Verified Users';
		$result['startPage'] = $start;
		$result['pageFunction'] = 'nonVerified';
				
		$this->load->view('v_header');
		$this->load->view('user/v_userlist',$result);
		$this->load->view('v_footer');
	}

	public function product($keyword = 'null')
	{
		$keyword = urldecode($keyword);
		$filter = array();
		$keywordDuplicate = $keyword;
	    if($keyword == 'null') {
            $keyword = '';
        }

        $filter['user_id'] = base64_decode($_REQUEST['uid']);

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'user/product/' . $keywordDuplicate . '/';
		
		$count = $this->M_user->countUserProducts($keyword,$filter);
		$config['total_rows'] = $count;
		$config["uri_segment"] = 4;
		$limit = 20;
		$start = $this->uri->segment(4, 0);
		$config['per_page'] = $limit;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = '>';
		$config['prev_link'] = '<';
		$config['last_link'] = '>>';
		$config['first_link'] = '<<';
		$this->pagination->initialize($config);
		$result['pagination'] =  $this->pagination->create_links();
		
		$result["products"] = $this->M_user->getUserProducts($start,$limit,$keyword,$filter);
		$userDetails = $this->M_user->getUserDetails($filter['user_id']);		
		$result['pageHeading'] = 'User Favorite Products: <b>'.ucfirst($userDetails['fname'])." ".ucfirst($userDetails['lname'])."</b>";

		$result['startPage'] = $start;
		$result['pageFunction'] = 'product';


		/*********************** discounted products *******************/

		
		//$result["discountProducts"] = $this->M_user->discountProducts($filter);
		
		/*echo "<pre>";
		print_r($result);die;*/

		$this->load->view('v_header');
		$this->load->view('user/v_userProduct',$result);
		$this->load->view('v_footer');
	}


	public function discount($keyword = 'null')
	{
		$keyword = urldecode($keyword);
		$filter = array();
		$keywordDuplicate = $keyword;
	    if($keyword == 'null') {
            $keyword = '';
        }

        $filter['user_id'] = base64_decode($_REQUEST['uid']);

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'user/discount/' . $keywordDuplicate . '/';
		
		$count = $this->M_user->countUserDiscounts($keyword,$filter);
		$config['total_rows'] = $count;
		$config["uri_segment"] = 4;
		$limit = 20;
		$start = $this->uri->segment(4, 0);
		$config['per_page'] = $limit;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = '>';
		$config['prev_link'] = '<';
		$config['last_link'] = '>>';
		$config['first_link'] = '<<';
		$this->pagination->initialize($config);
		$result['pagination'] =  $this->pagination->create_links();
		
		$result["discountProducts"] = $this->M_user->getUserDiscounts($start,$limit,$keyword,$filter);
		$userDetails = $this->M_user->getUserDetails($filter['user_id']);		
		
		$result['pageHeading'] = 'Manage Product Discount: <b>'.ucfirst($userDetails['fname'])." ".ucfirst($userDetails['lname'])."</b>";
		$result['startPage'] = $start;
		$result['pageFunction'] = 'discount';


		/*********************** discounted products *******************/

		
		//$result["discountProducts"] = $this->M_user->discountProducts($filter);
		
		/*echo "<pre>";
		print_r($result);die;*/

		$this->load->view('v_header');
		$this->load->view('user/v_userDiscounts',$result);
		$this->load->view('v_footer');
	}


	
	public function addUserDiscount()
	{
            $data['product_id'] = $_POST['searchProductId'];
            $data['user_id'] = $_POST['productUserId'];
            $data['price'] = $_POST['productPrice'];
            $data['moq'] = $_POST['productMoq'];

            $product = array();
	            $result = $this->M_user->addUserDiscount($data);
	            if ($result == false) {
	               	$product['status'] = 'false';
	            } else {
	            	$product = $this->M_product->getProductDetails($data['product_id']);
	            	$product['insert_id'] = $result['insert_id'];
	            	$product['price'] = $data['price'];
	            	$product['moq'] = $data['moq'];
	                $product['status'] = 'true';
	            }
		echo json_encode($product);
	}

	
	public function deleteUserDiscount()
	{
		$data = $_POST;

		$result = $this->M_user->deleteUserDiscount($data);
		$result['id'] = $data['id'];
		echo json_encode($result);
	}


	public function autoUserSuggestionList()
	{
		$searchText = $_REQUEST['searchText'];
		$data = array('searchText'=>$searchText);
		$final = array();
		$autoSuggestionListData = $this->M_user->autoSuggestionList($data);
		if(!empty($autoSuggestionListData)){

			foreach($autoSuggestionListData as $key=>$val){
				
				$isGST = $this->M_android->isGST();
		//print_r($isGST);die;
		if(!$isGST){
				if($val['state_id'] == 32){
					$taxTypeId=1;
				}else if($val['state_id'] == 6){
					$taxTypeId=1;
				}else if(!empty($val['tin_number'])){
					$taxTypeId=3;
				}else{
					$taxTypeId=2;
				}
		}else{
			$taxTypeId=4;
		}


				$autoSuggestionListData[$key]['tax_type_id'] = $taxTypeId;

				$autoSuggestionListData[$key]['cities'] = $this->M_android->getCity($val['state_id']);
			}


			$final = $autoSuggestionListData;
		}

		echo json_encode($final);	
	}


	public function autoSuggestionList()
	{
		$searchText = $_REQUEST['searchText'];
		$data = array('searchText'=>$searchText);
		$final = array();
		$autoSuggestionListData = $this->M_android->autoSuggestionList($data);
		if(!empty($autoSuggestionListData)){
			/*foreach($autoSuggestionListData as $key=>$val){
				$dataSuggestions[] = $val['name'];
			}*/
			$final = $autoSuggestionListData;
		}

		echo json_encode($final);	
	}
	
	public function getRetailType()
	{
		$id = $_REQUEST['id'];
		$result = $this->M_user->getBusinessType($id);
		echo json_encode($result);
	}


	public function getCities()
	{
		$stateId = $_REQUEST['sId'];
		$resultState = $this->M_user->getCity($stateId);
		echo json_encode($resultState);
	}

	public function checkMobile()
	{
		$data = $_REQUEST['mobile'];
		$result1 = $this->M_android->checkMobile($data);
		if($result1){
			$result['status'] = 'true';
		}else{
			$result['status'] = 'false';
		}
		echo json_encode($result);
	}
	
	public function edit()
	{
	   
		if (!empty($_POST)) {
            $data = $_POST;
            //print_r($data['id']);die;
            $result = $this->M_user->edit($data);

            $locationData['lat']=$data['lat'];
            $locationData['id']=$data['id'];
           	$locationData['log']=$data['log'];
           	$locationData['location_name']=$data['location_name'];
           	$locationData['university_id']=$data['id'];

            if(!empty($locationData['location_name'][0])){
	        	foreach($locationData['location_name'] as $rpKey=>$rpVal){
	        		$locationData['location_name'] = $rpVal;
	        		$dataPrice['lat'] = $locationData['lat'][$rpKey];
	        		$dataPrice['log'] = $locationData['log'][$rpKey];
	        		
	    
	        		if(!empty($locationData['lat']) && !empty($locationData['log'])){
	        			
	        			$resultLocation = $this->M_user->updateLocation($locationData);
	        		}
	        	}
	        }


            if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }
		$id = base64_decode($_GET['id']);

		$catResult['userData'] = $this->M_user->getUserDetails($id);
		//print_r($catResult['userData']);die();
		$catResult['locationsData'] = $this->M_user->getLocationsDetails($id);
		
		$catResult['pageHeading'] = 'Edit University';
		$catResult["firms"] = $this->M_user->getFirm();
		$catResult["states"] = $this->M_user->getState();

		//$catResult["retail_types"] = $this->M_user->getBusinessType($catResult['userData']['retailer_id']);
		//$catResult["cities"] = $this->M_user->getCity($catResult['userData']['state_id']);
		//$catResult["shipCities"] = $this->M_user->getCity($catResult['shipData']['state_id']);

		$this->load->view('v_header');
		$this->load->view('user/v_userEdit',$catResult);
		$this->load->view('v_footer');	
	}



	
	public function resetPassword()
	{
		
		if (!empty($_POST)) {
			
            $data = $_POST;
            $password = $this->getRandomDigit(6);
           	$data['password'] = md5($password);

           	//$data['password'] = md5('123456');
            $result = $this->M_user->edit($data);
            if ($result == false) {
                echo 'false';
            } else {
            	$userData = $this->M_user->getUserDetails($data['id']);
           		$msg  = "Greetings of the day! Pumpkart welcomes you to shop online using the Username: ".$userData['mobile']."' and Password: '".$password."' details\r\n ";
           		$this->M_android->commonSMS($userData['mobile'],$msg);
                echo 'true';
            }
            
        }
		
	}


	public function getRandomDigit($length)
	{
    /*$token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }*/
    $Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789abcdefghijklmnopqrstuvwxyz';
	$QuantidadeCaracteres = strlen($Caracteres);
	$QuantidadeCaracteres--;

	$Hash=NULL;
	    for($x=1;$x<=$length;$x++){
	        $Posicao = rand(0,$QuantidadeCaracteres);
	        $Hash .= substr($Caracteres,$Posicao,1);
	    }

    return $Hash;
	}


	
}
?>