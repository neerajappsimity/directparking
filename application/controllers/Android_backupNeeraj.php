<?php
defined('BASEPATH') OR exit('No direct script access allowed');



//header('Content-Type: application/json');
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

            ini_set('memory_limit', '-1');
    }  
	
	public function index()
	{
		$this->load->view('welcome_message');
	}

	/*http://profile.appsimity.com/directParking/Android/universityList
	{
	“userId:”user01”
	}

	*/
    public function universityList(){

    	$resultUniversities = $this->M_android->getUniversities();
  			if(!empty($resultUniversities)){
				$return = array('status'=>'true','msg'=>'Success','data'=>$resultUniversities);
			}else{
				$return = array('status'=>'false','msg'=>'No Data');
			}
		echo json_encode($return);

    }
	
	/*http://profile.appsimity.com/directParking/Android/signup
		
		{
		    "fcmToken": "fcktoken",
		    "userDetails": {
		    	"universityId": "1",
		        "firstName": "Cde",
		        "lastName": "cdeXyz",
		        "phone": "9876543211",
		        "email": "cde@xyz.com",
		        "password": "abc",
		        "phoneCode": 91
		    },
		    "carDetails": {
		        "color": "red",
		        "model": "Hundai Xcent",
		        "plateNumber": "PB 41 XY 1234",
		        "licenceNumber": "1234567890"
		    }
	    }
	*/
	public function signup()
	{
		$inputJSON=json_decode(file_get_contents('php://input'));
		
		//print_r($inputJSON);die;
		//print_r($inputJSON->userDetails->firstName);die; 
		$data['university_id']=$inputJSON->userDetails->universityId;
		$data['fname']=$inputJSON->userDetails->firstName;
		$data['lname']=$inputJSON->userDetails->lastName;
		$data['mobile']=$inputJSON->userDetails->phone;  
		$data['email']=$inputJSON->userDetails->email;		
		$data['password']=$inputJSON->userDetails->password;
		$data['phoneCode']=$inputJSON->userDetails->phoneCode;
		$data['dob']=$inputJSON->userDetails->dob;
		$data['created'] = date('Y-m-d g:i:s');
		//$data['last_login'] = date("d-m-Y g:i:s");      

		$dataEmail['university_id'] = $inputJSON->userDetails->universityId;		
		$dataEmail['email']=explode(".",$inputJSON->userDetails->email);
		$return['status'] = 'true';

		$result = $this->M_android->checkVerifiedEmail($dataEmail); 
		
		
		
		
			$domain=end($dataEmail['email']);
			
		//if(!empty($result) && $domain=='edu'){
			
			$result = $this->M_android->checkUser($data['email']);
			if($result['status'] == 'true'){
			

			$result = $this->M_android->signUpCustomer($data);
			//print_r($result['user_id']);die;
			$dataCar['color']=$inputJSON->carDetails->color;
			$dataCar['model']=$inputJSON->carDetails->model;
			$dataCar['license_plate']=$inputJSON->carDetails->plateNumber;
			$dataCar['driving_license']=$inputJSON->carDetails->licenceNumber;
			$dataCar['created'] = date('Y-m-d g:i:s');
			$dataCar['user_id'] = $result['user_id'];
			$dataCar['carMake'] = $inputJSON->carDetails->carMake;

			$resultShip = $this->M_android->addCarDetail($dataCar);

			$dataNoti['related_id'] = $result['user_id'];
			$dataNoti['noti_type'] = '2';
			$resultBack = $this->M_android->getBackendUsers();
        	foreach($resultBack as $k=>$v){
        		$dataNoti['user_id'] = $v['id'];
				$resultNoti = $this->M_android->addNotifications($dataNoti);
			}

			/*$to = $data['email'];
			$subject = "Mr Bachat is here to serve you ".$data['name']." Ji";			
			$body ="";
			$header = "From: Mr Bachat <noreply@mrbachat.com>";
			mail($to, $subject, $body, $header);*/

			
			//$to = 'sachin.minhas@appsimity.com';
			$to = $data['email'];

			$subject = "Verify You Email";			
			$body ="Click here  to verify your email ".site_url().'Android/verifiedEmail/?id='.$result['user_id'];
			$header = "From: DirectParking <noreply@appsimity.com>";
			mail($to, $subject, $body, $header);
			//$msg= array('status'=>'true','msg'=>'Forgot password link has been sent to your registered email address.');



			$return = array('status'=>'true','msg'=>'Thank you for Registering! A verification link has been sent to your email.');
			}else{
				$return = array('status'=>'false','success'=>'0','msg'=>'User already exists');
			}

		/*}else{
				$return = array('status'=>'false','success'=>'0','msg'=>'Please enter vaild email.');
		}*/
		
		echo json_encode($return);
		
	}

		public function verifiedEmail()
	{
		/*$inputJSON=json_decode(file_get_contents('php://input'));
		$userId = $inputJSON->userId;*/
		$data = $_REQUEST['id'];
		//print_r($data['id']);die;
		$resultLogout = $this->M_android->verifiedEmail($data);
		//print_r($resultLogout);die();
		if($resultLogout)
		{
			$resultLogin= array('Thank You!'=>'verified successfully!');
		}else{
			$resultLogin= array('status'=>'false','msg'=>'Some Error.');
		}
		echo json_encode($resultLogin);
	}

    
	public function login()
	{  
		$inputJSON=json_decode(file_get_contents('php://input'));
		$data['email'] = $inputJSON->username;
		$data['password'] = $inputJSON->password;
		$data['device_id'] = $inputJSON->fcmToken;
		
		$result = $this->M_android->userLogin($data);

		
		$userData['userId']=$result['id'];

		/*****Get Rating*****/
		$userRating=$this->M_android->getUserRating($userData['userId']);


		//print_r(round($userRating[0]['average_rating']));die();
		$rating=round($userRating[0]['average_rating']);	

		$userData['firstName']=$result['fname'];
		$userData['lastName']=$result['lname'];
		$userData['email']=$result['email'];
		$userData['email']=$result['email'];
		$userData['profile']=$result['profile'];
		$userData['phone']=$result['mobile'];
		$userData['phoneCode']=$result['phoneCode'];
		$userData['dob']=$result['dob'];
		$userData['rating']=$rating;
		$university['id']=$result['university_id'];
		$university['name']=$result['university_name'];
		$userData['university']=$university;
    


		$carData=$this->M_android->getCarDetail($result['id']);

		$carDetails['color']=$carData['color'];
		$carDetails['model']=$carData['model'];
		$carDetails['plateNumber']=$carData['license_plate'];
		$carDetails['licenceNumber']=$carData['driving_license'];
		$carDetails['carMake']=$carData['carMake'];

		$loacationData['frequency']=7000;
        $loacationData['interval']=5000;

		if($result['is_verified'] == 'P')
		{
			$resultLogin= array('success'=>'0','status'=>'false','msg'=>'Account is pending for verification.');
		}else if($result['is_verified'] == 'N')
		{
			$resultLogin= array('success'=>'0','status'=>'false','msg'=>'Account is not verified. Please contact the support.');
		}else if($result['enabled'] == 'Y')
		{
			//print_r($result['email']);die();
			if(!empty($result['email'])){
				$resultLogin= array('status'=>'true','success'=>'1','msg'=>'You have successfully login','userDetails'=>$userData,'carDetails'=>$carDetails,'locationConfig'=>$loacationData);
				//$resultLogin= array('success'=>'1');
			}else{
				$resultLogin= array('status'=>'false','success'=>'0','msg'=>'Incorrect Credentials..');

			}
		}else if($result['enabled'] == 'N')
		{
			$resultLogin= array('status'=>'false','success'=>'0','msg'=>'Account has been disabled.');
		}else{
			$resultLogin= array('status'=>'false','success'=>'0','msg'=>'Incorrect Credentials.');
		}
		echo json_encode($resultLogin);
	}

	//http://profile.appsimity.com/directParking/Android/forgotPassword
	/*
		{
		"username":"sachin@oxford.com"
		}

	*/
	public function logout()
	{
		$inputJSON=json_decode(file_get_contents('php://input'));
		$userId = $inputJSON->userId;
		
		$resultLogout = $this->M_android->logout($userId);
		//print_r($resultLogout);die();
		if($resultLogout)
		{
			$resultLogin= array('status'=>'true','msg'=>'Logout successfully!');
		}else{
			$resultLogin= array('status'=>'false','msg'=>'Some Error.');
		}
		echo json_encode($resultLogin);
	}



	public function updateLocation(){

		$data = json_decode(file_get_contents('php://input'));

		$userId=$data->userId;
		$locationData=$data->locationData;

		$result = $this->M_android->updateLocation($userId,$locationData);

		if($result)
		{
			$msg= array('status'=>'true','msg'=>'updated successfully!');
		}else{
			$msg= array('status'=>'false','msg'=>'Some Error.');
		}
		echo json_encode($msg);
	}



	public function trackUserRide(){

		$data = json_decode(file_get_contents('php://input'));




		$userId=$data->userId;
		$rideId=$data->rideId;

		$result = $this->M_android->trackRide($userId,$rideId);

		

		if(!empty($result))
		{

		foreach ($result as $value) {
		$tempresultData['pickupAddress']['lat']=$value['pick_lat'];
		$tempresultData['pickupAddress']['lng']=$value['pick_log'];
		$tempresultData['pickupAddress']['address']=$value['pick_address'];

		$tempresultData['deliveryAddress']['lat']=$value['drop_lat'];
		$tempresultData['deliveryAddress']['lng']=$value['drop_log'];
		$tempresultData['deliveryAddress']['address']=$value['drop_address'];

		$tempresultData['driverLocation']['lat']=$value['lat'];
		$tempresultData['driverLocation']['lng']=$value['lng'];
		$tempresultData['driverLocation']['bearing']=$value['bearing'];
		$resultData[]=$tempresultData;
			}

		
	
			$msg= array('status'=>'true','msg'=>'trackRide','data'=>$resultData);
		}else{
			$msg= array('status'=>'false','msg'=>'No data.');
			
		}


		
		echo json_encode($msg,JSON_UNESCAPED_UNICODE);
	}







	/*http://profile.appsimity.com/directParking/Android/forgotPassword
	{
	"username":"sachin.minhas@appsimity.com"
	}

	*/
	public function forgotPassword()
	{
		$inputJSON=json_decode(file_get_contents('php://input'));
		$email = $inputJSON->username;
		//$data = $_REQUEST;
		$result = $this->M_android->checkEmail($email);

		//print_r($result['id']);die;
      
		if(!$result){

			//$result['status'] = 'false';
			
			$result['msg'] = 'Email does not exist.';
			$msg= array('status'=>'false','msg'=>$result['msg']);

		}else{
             
			//$to = $email;
			$id=base64_encode($result['id']);
			//$to = 'sachin.minhas@appsimity.com';
			$to = $email;
			$subject = "Password Reset Request";			
			$body ="Click here ".site_url().'Welcome/forgetPassword/?token='.$id." to change your password";
			$header = "From: DirectParking <noreply@appsimity.com>";
			mail($to, $subject, $body, $header);
			$msg= array('status'=>'true','msg'=>'Forgot password link has been sent to your registered email address.');

		}

		echo json_encode($msg);

	}

    public function getProfile(){

    	$inputJSON=json_decode(file_get_contents('php://input'));
		$data['id'] = $inputJSON->userId;
		$result = $this->M_android->getProfile($data);
		
		$userData['userId']=$result['id'];

		/*****Get Rating*****/
		$userRating=$this->M_android->getUserRating($userData['userId']);		
		$rating=round($userRating[0]['average_rating']);

		$userData['firstName']=$result['fname'];
		$userData['lastName']=$result['lname'];
		$userData['email']=$result['email'];
		$userData['email']=$result['email'];
		$userData['profile']=$result['profile'];
		$userData['phone']=$result['mobile'];
		$userData['phoneCode']=$result['phoneCode'];
		$userData['dob']=$result['dob'];
		$userData['rating']=$rating;

		$university['id']=$result['university_id'];
		$university['name']=$result['university_name'];
		$userData['university']=$university;

		$carData=$this->M_android->getCarDetail($result['id']);

		$carDetails['color']=$carData['color'];
		$carDetails['model']=$carData['model'];
		$carDetails['plateNumber']=$carData['license_plate'];
		$carDetails['licenceNumber']=$carData['driving_license'];
		$carDetails['carMake']=$carData['carMake'];

		$loacationData['frequency']=7000;
        $loacationData['interval']=5000;
        //print_r($carDetails);die;
		$resultGetProfile= array('status'=>'true','success'=>'1','msg'=>'Check Detail','userDetails'=>$userData,'carDetails'=>$carDetails,'locationConfig'=>$loacationData);
		echo json_encode($resultGetProfile);
    }


	/*
	 http://profile.appsimity.com/directParking/Android/updateProfile
	 	{
		    "fcmToken": "fcktoken",
		    "userDetails": {
		    	"userId":"44",
		        "firstName": "Rites",
		        "lastName": "Kumar",
		        "dob": "20/02/1991"
		     
		        
		    },
		    "carDetails": {
		        "color": "red",
		        "model": "Hundai Xcent",
		        "plateNumber": "PB 41 XY 5",
		        "licenceNumber": "1234567890"
		    }
	    }
	*/

		public function updateProfile()
	{
		$inputJSON=json_decode(file_get_contents('php://input'));
		$data['id']=$inputJSON->userDetails->userId;
		//$data['university_id']=$inputJSON->userDetails->universityId;
		$data['fname']=$inputJSON->userDetails->firstName;
		$data['lname']=$inputJSON->userDetails->lastName;
		//$data['mobile']=$inputJSON->userDetails->phone;
		//$data['email']=$inputJSON->userDetails->email;
		//$data['password']=md5($inputJSON->userDetails->password);
		//$data['phoneCode']=$inputJSON->userDetails->phoneCode;

		   if(isset($inputJSON->userDetails->profile) && ($inputJSON->userDetails->profile != ''))
                {
                $image = str_replace(" ","+",$inputJSON->userDetails->profile); 

                $image=$inputJSON->userDetails->profile;
               // print_r($image);die;
                $rand = rand(1,999);
                $image_user = time()."_$rand.jpeg";
                if($img = imagecreatefromstring(base64_decode($image))){
                  $image_loc ='./assets/img/profile/'.$image_user;
                 // print_r($image_loc);die;
                  //$result['images'][$kI] = site_url().'assets/image/products/original/'.$vI['image'];
                if($img != false)
                {
                       imagejpeg($img,$image_loc);
                       $data['profile'] =site_url().'assets/img/profile/'. $image_user;
                }
                }
            
            }
		$data['dob']=$inputJSON->userDetails->dob;
		$data['updated'] = date('Y-m-d g:i:s');

		$carData['user_id']=$inputJSON->userDetails->userId;
		$carData['color']=$inputJSON->carDetails->color;
		$carData['model']=$inputJSON->carDetails->model;
		$carData['license_plate']=$inputJSON->carDetails->plateNumber;
		$carData['driving_license']=$inputJSON->carDetails->licenceNumber;
		$carData['carMake']=$inputJSON->carDetails->carMake;


		
		$updateProfile = $this->M_android->updateProfile($data);
		$updateProfile = $this->M_android->updateCarDetail($carData);
		//print_r($resultLogout);die();
		if($updateProfile)
		{
			$result= array('status'=>'true','msg'=>'Profile updated successfully!');
		}else{
			$result= array('status'=>'false','msg'=>'Some Error.');
		}
		echo json_encode($result);
	}


	/*
	   http://profile.appsimity.com/directParking/Android/requestRide
	   {
			"userId": "52",
			"schedule": "2018-07-29 2:40",
			"pickupPoint": {
				"address": "abc",
				"latitude": "76.189899",
				"longitude": "30.404656"
			},
			"dropPoint": {
				"address": "abc",
				"latitude": "76.185598",
				"longitude": "30.4077894"
			}
		}

	*/
		public function requestRide()
	{
		header('Content-Type: application/json');
		$inputJSON=json_decode(file_get_contents('php://input'));
		
		//print_r($inputJSON);die;
		//print_r($inputJSON->userDetails->firstName);die;

		
		$data['user_id']=$inputJSON->userId;
		
		$data['schedule_date']=date('Y-m-d');

        $checkDupRequest = $this->M_android->checkDupRequest($data);
       // print_r($checkDupRequest['ride_id']);die;
        $LastRideData['ride_id']=$checkDupRequest['ride_id'];
        $LastRideData['user_id']=$checkDupRequest['user_id'];

    if(empty($checkDupRequest)){
    	$data['parking_no']=$inputJSON->parking_no;
		$data['schedule_time']=$inputJSON->schedule;

		$data['pick_address']=$inputJSON->pickupPoint->address;
		$data['pick_lat']=$inputJSON->pickupPoint->latitude;
		$data['pick_log']=$inputJSON->pickupPoint->longitude;

		$data['drop_address']=$inputJSON->dropPoint->address;
		$data['drop_lat']=$inputJSON->dropPoint->latitude;
		$data['drop_log']=$inputJSON->dropPoint->longitude;

		
		$data['created'] = date('Y-m-d g:i:s');
        $result = $this->M_android->AddRequestRide($data);
        //print_r($result['user_id']);die;
/*************** Start Send Notification ****************************/
        $universityData=$this->M_android->getUniversityData($data['user_id']);
        //print_r($universityData);die;
		$dataNoti['related_id'] = $data['user_id'];
		$dataNoti['ride_id'] = $result['user_id'];
			$dataNoti['noti_type'] = '3';
			$resultBack = $this->M_android->getDriver($universityData['university_id'],$data['user_id']);
			//print_r($resultBack);die;
        	foreach($resultBack as $k=>$v){
        		$dataNoti['user_id'] = $v['id'];
				$resultNoti = $this->M_android->addNotifications($dataNoti);
			}

		
/*************** End Send Notification ****************************/        
             
/*************** Start FCM Code************************/			
			$msgData['title'] = 'Ride Request';
			$msgData['msg'] = 'A new ride request has been made';
			//$msgData['msg'] = 'New ride request  - '.$_POST['code'];
			foreach($resultBack as $k=>$v){
				$devData=array();
        		$devData['device_id'] = $v['device_id'];
        		//$devData['device_id'] = 'c_sRNIscJnw:APA91bGqSy_SaSxu_FwSn69DwUEudej2OheBajGMMKEtmOlUxX8enJGdfXRZJCZL418ElyteL3grI8StJ7Bk2kgOJlgZz7covrBXqYzyFWrLpmmIqatQOtIUYyRyPlYESD_5x-cdy02n_FKmlHxfgHOlEc1zskxTvw';
        		 
	       		$timestamp=date('d/m/Y h:i:s');
	                      $data = array
	                      (
	                       'body'  => $msgData['msg'],
	                       'title' => $msgData['title'],
	                       'timestamp'=>$timestamp,
	                       'sound'=>'default',
	                       "click_action"=>"OPEN_ACTIVITY_1",
	                       "type"=>"NEW_REQUEST"
	                       );
	                      $priority='high';
	                      
	                       $noti=$this->M_android->fcmCustNotification($devData['device_id'],$data,$priority);
	                       //$noti=$this->M_coupon->fcmCustNotification('eY-SZtiYSLM:APA91bHs5cbiUuHRsUrvUbfbwjsnKClzQcQ_fgteHwHY3l8CIqiymiYFYt-DbQelPmvGbZoyXtCoSWynNqH9drcH10UUUnMtfhS3CIfptTdW2_Q6lIIO7H3xJDp8l6fu5EJNXl_wrJGi',$data,$priority);
	                      // print_r($noti);
	                      
				
				}
			
/************** End FCM Code***************************/


		if(!empty($result)){
			
			//$result = $this->M_android->checkUser($data['email']);
			if($result['status'] == 'true'){
			


			$return = array('status'=>'true','success'=>'1','msg'=>'Please wait... ');
			}else{
				$return = array('status'=>'false','success'=>'0','msg'=>'Some Problem');
			}

		}else{
				$return = array('status'=>'false','success'=>'0','msg'=>'Enter vaild email.');
		}

	}else{
		$return = array('status'=>'true','success'=>'2','data'=>$LastRideData,'msg'=>'You have already book a ride.');
	}
		
		echo json_encode($return);
		
	}




	//http://profile.appsimity.com/pumpkart/admin/Android/getNotificationList/
		public function getNotificationList()
	{             
		$inputJSON=json_decode(file_get_contents('php://input'));     
		$data['user_id']=$inputJSON->userId;                                 
		//$data=$_GET;
        //print_r($data['user_id']);die;
		$resultNotificationList = $this->M_android->getNotificationList($data);
		//print_r($resultNotificationList);die;
		/*$data['id']= $resultNotificationList['id'];
		$data['rideId']= $resultNotificationList['ride_id'];
		$data['userId']= $resultNotificationList['user_id'];
		$data['title']= $resultNotificationList['title'];
		$data['description']= $resultNotificationList['description'];
		$data['created']= $resultNotificationList['created'];*/
		

		if(!empty($resultNotificationList)){
			$return = array('status'=>'true','data'=>$resultNotificationList);
		}else{
			$return = array('status'=>'false');
		}
		
		echo json_encode($return);
	}


	   public function rideDetail(){
	   	header('Content-Type: application/json');
	   	$inputJSON=json_decode(file_get_contents('php://input'));
		
		
		$rideId = $inputJSON->rideId;
		$userId = $inputJSON->userId;
		$isRider = $inputJSON->isRider;
        
        /*if($isRider=='0'){

        }elseif($isRider=='1'){

        }*/
    	$userDetail = $this->M_android->getUserDetailData($rideId,$userId,$isRider);

        $userData['userId']=$userDetail['user_id'];
		$userData['firstName']=$userDetail['fname'];
		$userData['lastName']=$userDetail['lname'];
		$userData['profile']=$userDetail['profile'];
		

		/*****Get Rating*****/
		$userRating=$this->M_android->getUserRating($userData['userId']);		
		$rating=round($userRating[0]['average_rating']);
		$userData['rating']=$rating;

    	//print_r($rideDetail);die;
    	$rideDetail = $this->M_android->getRideDetail($rideId);
  			if(!empty($rideDetail)){
				$return = array('status'=>'true','msg'=>'Success','rideDetail'=>$rideDetail,'userDetails'=>$userData);
			}else{
				$return = array('status'=>'false','msg'=>'No Data');
			}
		echo json_encode($return);

    }

     public function rideList(){

	   	$inputJSON=json_decode(file_get_contents('php://input'));
		 
		$userId=$inputJSON->userId;
		$checkUnvId = $this->M_android->checkUnvId($userId);
		$unvId=$checkUnvId['university_id'];
		//print_r($unvId['university_id']);die;
    	$rideDetail = $this->M_android->getRideList($unvId,$userId);

    	//print_r($rideDetail);

    	//print_r($rideDetail);die;
    /*	$data['user_id']=$rideDetail[0]['user_id'];
    	$data['mobile']=$rideDetail[0]['mobile'];
    	$data['profile']=$rideDetail[0]['profile'];
    	$data['fname']=$rideDetail[0]['fname'];
    	$data['lname']=$rideDetail[0]['lname'];
    	$data['email']=$rideDetail[0]['email'];
    	$data['id']=$rideDetail[0]['id'];
    	$data['schedule_date']=$rideDetail[0]['schedule_date'];
    	$schedule_time = $rideDetail[0]['schedule_time'];

    	$data['schedule_time'] = date("H:i", strtotime($schedule_time));

    	$data['pick_address']=$rideDetail[0]['pick_address'];
    	$data['pick_lat']=$rideDetail[0]['pick_lat'];
    	$data['pick_log']=$rideDetail[0]['pick_log'];
    	$data['drop_address']=$rideDetail[0]['drop_address'];
    	$data['drop_lat']=$rideDetail[0]['drop_lat'];
    	$data['drop_log']=$rideDetail[0]['drop_log'];
    	$data['status']=$rideDetail[0]['status'];*/

  			if(!empty($rideDetail)){
				$return = array('status'=>'true','success'=>'1','msg'=>'Success','data'=>$rideDetail);
			}else{
				$return = array('status'=>'false','success'=>'0','msg'=>'Sorry, no ride requests are available at this time');
			}
		echo json_encode($return);

    }



    	public function rideStatus()
	{
		//header('Content-Type: application/json');
		$inputJSON=json_decode(file_get_contents('php://input'));
		
		//print_r($inputJSON->status);die;
		//print_r($inputJSON->userDetails->firstName);die;

		if($inputJSON->status=='accept'){
			$driverId=$inputJSON->driverId;
			$rideId=$inputJSON->rideId;

			$driverData['user_id']=$driverId;
			$driverData['ride_id']=$rideId;
			$driverData['schedule_date']=date('Y-m-d');

			$checkDupRequest = $this->M_android->checkDupRequest($driverData);


			//print_r($checkDupRequest);
			$checkAlreadtAccept= $this->M_android->checkAlreadtAccept($driverData);

			
			 $checkDupAcceptRide = $this->M_android->checkDupAcceptRide($driverId);

			
			}else{
				$checkDupRequest='';
				$checkDupAcceptRide="";
				$checkAlreadtAccept='';
			}
			//print_r($checkDupRequest);

			//print_r($checkDupAcceptRide);

			if(empty($checkDupRequest)){

			if(empty($checkAlreadtAccept)) {

			if(empty($checkDupAcceptRide)){

		$data['user_id']=$inputJSON->userId;		
		$data['ride_id']=$inputJSON->rideId;
		$data['accept_user_id']=$inputJSON->driverId;
		$data['status']=$inputJSON->status;	
		//print_r($data);die;	
		$data['created'] = date('Y-m-d g:i:s');
        $result = $this->M_android->AddRideStatus($data);
        //print_r($result['user_id']);die;
/*************** Start Send Notification ****************************/
       // $universityData=$this->M_android->getUniversityData($data['user_id']);
        //print_r($universityData);die;
		$dataNoti['related_id'] = $data['accept_user_id'];
		$dataNoti['ride_id'] = $data['ride_id'];
		if($data['status']=='accept'){
			$dataNoti['noti_type'] = '4';
	    }elseif($data['status']=='cancel'){
	    	$dataNoti['noti_type'] = '5';
	    }
	    $dataNoti['user_id'] = $data['user_id'];
	    $resultNoti = $this->M_android->addNotifications($dataNoti);

	    $bookingStatus['ride_id']=$data['ride_id'];
	    $bookingStatus['status']=$inputJSON->status;	
	    $resultNoti = $this->M_android->addRideBookingStatus($bookingStatus);

			//$resultBack = $this->M_android->getDriver($universityData['university_id'],$data['user_id']);
			//print_r($resultBack);die;
        	/*foreach($resultBack as $k=>$v){
        		$dataNoti['user_id'] = $v['id'];
				$resultNoti = $this->M_android->addNotifications($dataNoti);
			}*/

		
/*************** End Send Notification ****************************/
			$deviceId = $this->M_android->getDeviceId($data['user_id']); 
			//print_r($deviceId);

/*************** Start FCM Code************************/			
			$msgData['title'] = 'Ride Confirmation ';
			$msgData['msg'] = 'Your Ride Request has been '.$data['status'].'ed'; 
			//$msgData['msg'] = 'Your request has been'.$data['status'];
			//$msgData['msg'] = 'New ride request  - '.$_POST['code'];
			//foreach($resultBack as $k=>$v){
				//$devData=array();
        		//$devData['device_id'] = $deviceId;
        		
        		//$devData['device_id'] = 'c_sRNIscJnw:APA91bGqSy_SaSxu_FwSn69DwUEudej2OheBajGMMKEtmOlUxX8enJGdfXRZJCZL418ElyteL3grI8StJ7Bk2kgOJlgZz7covrBXqYzyFWrLpmmIqatQOtIUYyRyPlYESD_5x-cdy02n_FKmlHxfgHOlEc1zskxTvw';
        		// unset($data);
	       		$timestamp=date('d/m/Y h:i:s');
	                      $datafcm = array
	                      (
	                       'body'  => $msgData['msg'],
	                       'title' => $msgData['title'],
	                       'timestamp'=>$timestamp,
	                       'sound'=>'default'
	                       );
	                      $priority='high';
	                      
	                       $noti=$this->M_android->fcmCustNotification($deviceId['device_id'],$datafcm,$priority);
	                       //$noti=$this->M_coupon->fcmCustNotification('eY-SZtiYSLM:APA91bHs5cbiUuHRsUrvUbfbwjsnKClzQcQ_fgteHwHY3l8CIqiymiYFYt-DbQelPmvGbZoyXtCoSWynNqH9drcH10UUUnMtfhS3CIfptTdW2_Q6lIIO7H3xJDp8l6fu5EJNXl_wrJGi',$data,$priority);
	                      //print_r($noti);
	                      
				
				//}
			
/************** End FCM Code***************************/


		if(!empty($result)){
			//print_r($data);die;
			//$result = $this->M_android->checkUser($data['email']);
			$data['status']=$inputJSON->status;	
			//print_r($data);
			if($result['status'] == 'true'){
			
				if($data['status']=='accept'){

					$return = array('status'=>'true','msg'=>'You have successfully accepted the request!');
			    }elseif($data['status']=='cancel'){
			    	$return = array('status'=>'true','msg'=>'Your request has been successfully canceled.');
			    }elseif($data['status']=='complete'){
			    	$return = array('status'=>'true','msg'=>'Your Request complete successfully ');
			    }elseif($data['status']=='start'){
			    	$return = array('status'=>'true','msg'=>'Your Ride start ');
			    }
			}else{
				$return = array('status'=>'false','success'=>'0','msg'=>'Please Try Again!');
			}

		}else{
				$return = array('status'=>'false','success'=>'0','msg'=>'Internal Error.');
		}
		
	}else{
		$return = array('status'=>'false','success'=>'0','msg'=>'Please complete or cancel the current accepted ride.');
	}

	}

	else{
		

		$return = array('status'=>'false','success'=>'0','msg'=>'Sorry, This ride already accepted by another driver')
		;
	}

	}else {
		$return = array('status'=>'false','success'=>'0','msg'=>'Sorry,You cannot accept this request .Please cancel your requested ride first.')
		;
		
		}
		echo json_encode($return);
		
	}


	/*
	   http://profile.appsimity.com/directParking/Android/addRating
	   {
			"userId": "52",
			"relatedId": "56",
			"rating": "5",
			"comment": "abc...."
			
		}

	*/

		public function addRating()
	{
		$inputJSON=json_decode(file_get_contents('php://input'));
		
		//print_r($inputJSON);die;
		//print_r($inputJSON->userDetails->firstName);die;

		
		$data['user_id']=$inputJSON->userId;
		$data['related_id']=$inputJSON->relatedId;
		$data['ride_id']=$inputJSON->rideId;
			

		$data['rating']=$inputJSON->rating;
		$data['comment']=$inputJSON->comment;
		$data['enabled']='Y';
	
		$data['created'] = date('Y-m-d g:i:s');

		$checkRatingExist = $this->M_android->checkRatingExist($data);

		if(empty($checkRatingExist))
		{
			$result = $this->M_android->AddRating($data);
		}else{
			$result = $this->M_android->UpdateRating($data);
		}

		

		if(!empty($result)){
			
			//$result = $this->M_android->checkUser($data['email']);
			if($result['status'] == 'true'){
			


			$return = array('status'=>'true','msg'=>'Thank you! Your rating was submitted successfully! ');
			}else{
				$return = array('status'=>'false','success'=>'0','msg'=>'Some Problem');
			}

		}else{
				$return = array('status'=>'false','success'=>'0','msg'=>'Some issue.');
		}
		
		echo json_encode($return);
		
	}

    public function userInfo(){

    	$inputJSON=json_decode(file_get_contents('php://input'));	


				
		$data['user_id']=$inputJSON->userId;

		//$data['current_date'] = date('Y-m-d', time()-(24*60*60));
		$data['current_date'] = date('Y-m-d');

		$pendingRideData = $this->M_android->getPendingRide($data);

		

		

    	

		if(empty($pendingRideData))
		{


		

    	$riderData = $this->M_android->getRider($data);
    	
    	//print_r($riderData);
    	if($riderData['user_id']==$data['user_id']){
    		
    		$userId= $riderData['accept_user_id'];
    		$rideId= $riderData['ride_id'];    		
    		$is_rider=0;

    		//print_r($userId);die;


    	}elseif($riderData['accept_user_id']==$data['user_id']){
    		//$data = $this->M_android->getDriverdata($data);
    		//print_r($data);die;
    		
    		$userId= $riderData['user_id'];
    		$rideId= $riderData['ride_id'];
    		$is_rider=1;

    		//print_r($userId);die;

    	}

    	if(!empty($userId)){
    		$userData = $this->M_android->getUserData($userId);
    	}
    	
    	

        if(!empty($userData)){
	    	$userDetail['userId']=$userData['id'];
	    	$userDetail['firstName']=$userData['fname'];
	    	$userDetail['lastName']=$userData['lname'];
	    	$userDetail['email']=$userData['email'];
	    	$userDetail['phoneCode']=$userData['phoneCode'];
	    	$userDetail['phone']=$userData['mobile'];
	    	$userDetail['profile']=$userData['profile'];
	    	$userDetail['dob']=$userData['dob'];
	    	
	    	/*****Get Rating*****/
			$userRating=$this->M_android->getUserRating($userDetail['userId']);		
			$rating=round($userRating[0]['average_rating']);
			$userDetail['rating']=$rating;

	    	$carData=$this->M_android->getCarDetail($userDetail['userId']);

			$carDetails['color']=$carData['color'];
			$carDetails['model']=$carData['model'];
			$carDetails['plateNumber']=$carData['license_plate'];
			$carDetails['licenceNumber']=$carData['driving_license'];
			$carDetails['carMake']=$carData['carMake'];


			$rideList = $this->M_android->getRideData($rideId);

			//print_r($rideList).'ere'; 
			
			if(!empty($rideList)){
			//$rideData =$rideList;
			$rideData['id']=$rideList['id'];
	    	$rideData['user_id']=$rideList['user_id'];
	    	$rideData['schedule_date']=$rideList['schedule_date'];
	    	//$rideData['schedule_time']=$rideList['schedule_time'];
	    	$schedule_time = $rideList['schedule_time'];
	    	$rideData['schedule_time'] = $schedule_time;
	    	 //print_r($time);die;
	    	$rideData['pick_address']=$rideList['pick_address'];
	    	$rideData['pick_lat']=$rideList['pick_lat'];
	    	$rideData['pick_log']=$rideList['pick_log'];
	    	$rideData['drop_address']=$rideList['drop_address'];
	    	$rideData['drop_lat']=$rideList['drop_lat'];
	    	$rideData['drop_log']=$rideList['drop_log'];
	    	$rideData['distance']=round($rideList['distance'],2); 
	    	$rideData['parking_no']=$rideList['parking_no']; 
	    	$rideData['status']=$rideList['status'];
	    	$rideData['created']=$rideList['created'];
	    	
			}else{
				$rideData= "null";
			}


	    }else{
	    	$userDetail="null";
	    	$carDetails="null";
	    	$rideData="null";
	    }

	    //print_r($rideData);


    	

  			if(!empty($userData)){
				$return = array('status'=>'true','msg'=>'Success','userDetails'=>$userDetail,'carDetails'=>$carDetails,'rideInfo'=>$rideData,'isRider'=>$is_rider);
			}else{
				$return = array('status'=>'false','msg'=>'No Data');
			}

		}else{
			$requestedRideData['id']=$pendingRideData['id'];
			$requestedRideData['pick_address']=$pendingRideData['pick_address'];
	    	$requestedRideData['drop_address']=$pendingRideData['drop_address'];
			$requestedRideData['pick_lat']=$pendingRideData['pick_lat'];
	    	$requestedRideData['pick_log']=$pendingRideData['pick_log'];
			$requestedRideData['drop_lat']=$pendingRideData['drop_lat'];
	    	$requestedRideData['drop_log']=$pendingRideData['drop_log'];
	    	$schedule_time = $pendingRideData['schedule_time'];
	    	$requestedRideData['schedule_time'] = $schedule_time;
	    	$requestedRideData['parking_no'] = $pendingRideData['parking_no'];

			

	    	$return = array('status'=>'true','msg'=>'Success','requestedRide'=>$requestedRideData);

		}
		echo json_encode($return);

    }



		public function afterAcceptStatus()
	{
		$inputJSON=json_decode(file_get_contents('php://input'));
		
		
		$isRider=$inputJSON->isRider;
		$data['user_id']=$inputJSON->userId;
		$data['rideId']=$inputJSON->rideId;
		
		$reason='';
		if(isset($inputJSON->reason) && !empty($inputJSON->reason)){
			$data['reason']=$inputJSON->reason;	

			$reason=$inputJSON->reason;	
		}
			
		$data['status']=$inputJSON->status;	
		$data['updated'] = date('Y-m-d g:i:s');

		$notiUserData['userId']=$inputJSON->userId;
		$notiUserData['rideId']=$inputJSON->rideId;
		$notiUserData['isRider']=$inputJSON->isRider;

		$type='NOTIFICATION';


		//if($isRider=='0' && $data['status']=='cancel' || $data['status']=='do not show'){
		if($isRider=='0'){
			$result = $this->M_android->afterAcceptRiderStatus($data);
			$RidData = $this->M_android->checkRiderUserId($data['rideId']);
			$userId = $RidData['driver_id'];
			//print_r($userId);die;
		}elseif($isRider=='1'){
			//$result2 = $this->M_android->afterAcceptRiderStatus($data);
			$DrvData = $this->M_android->checkDriverUserId($data['rideId']);
			//print_r($DrvData['driver_id']);die;
			$userId=$DrvData['user_id'];
			$result = $this->M_android->afterAcceptDriverStatus($data);
		}
        
        //print_r($userId);die;

        		$deviceId = $this->M_android->getDeviceId($userId); 
			//print_r($deviceId);
        		/*if($data['status']=='cancel'){
        			$checkTotalRideTime = 0; 
        		}else{*/
        			$checkTotalRideTime = $this->M_android->getTotalRideTime($data['rideId']); 
        			$TotalRideTime = $checkTotalRideTime['totalTime'];
        		/*}*/
        	//print_r($checkTotalRideTime);die;
/*************** Start FCM Code************************/	  		
			$msgData['title'] = 'Ride Information ';
			if($data['status']=='complete'){
				$msgData['msg'] = 'Your Ride has been '.$data['status'].'d successfully'; 
				$totalRideTime['totalTime'] = $checkTotalRideTime;
				$totalRideTime['totalRideTime'] = $checkTotalRideTime;
			}elseif($data['status']=='cancel'){

				if($isRider=='1'){
					$msgData['msg'] = 'Sorry, the driver has cancelled on your ride request. Would you like to resend a new ride request?'; 
				}else{
					$msgData['msg'] = 'Sorry, the rider has cancelled their ride request. Would you like to search for a new ride request?'; 
				}

				$reason=$data['reason'];
				$type='CANCEL_REQUEST';
				
			}

			else{
			$msgData['msg'] = 'Your Ride has been '.$data['status'].'ed successfully'; 
	     	}
			//$msgData['msg'] = 'Your request has been'.$data['status'];
			//$msgData['msg'] = 'New ride request  - '.$_POST['code']; 
			//foreach($resultBack as $k=>$v){
				//$devData=array();
        		//$devData['device_id'] = $deviceId;
        		
        		//$devData['device_id'] = 'c_sRNIscJnw:APA91bGqSy_SaSxu_FwSn69DwUEudej2OheBajGMMKEtmOlUxX8enJGdfXRZJCZL418ElyteL3grI8StJ7Bk2kgOJlgZz7covrBXqYzyFWrLpmmIqatQOtIUYyRyPlYESD_5x-cdy02n_FKmlHxfgHOlEc1zskxTvw';
        		// unset($data);
	     	if($data['status']=='complete'){
	     		$totalRideTime = $checkTotalRideTime['totalTime'];
	     		
	     	}else{
	     		$totalRideTime = 0;
	     	}

	       		$timestamp=date('d/m/Y h:i:s');
	                      $datafcm = array
	                      (
	                       'body'  => $msgData['msg'],
	                       'title' => $msgData['title'],
	                       'timestamp'=>$timestamp,
	                       'totalTime'=>$totalRideTime,
	                       'totalRideTime'=>$totalRideTime,
	                       'rideId'=>$inputJSON->rideId,
	                       'userId'=>$inputJSON->userId,
	                       'isRider'=>0,
	                       'sound'=>'default',
	                       "click_action"=>"OPEN_ACTIVITY_1",
	                       "type"=>$type,
	                       "reason"=>$reason
	                       
	                       );
	                      $priority='high';
	                     // $data = $notiUserData;

	                      
	                      
	                       $noti=$this->M_android->fcmCustNotification($deviceId['device_id'],$datafcm,$priority);

	                       //print_r($noti);
	                       //$noti=$this->M_coupon->fcmCustNotification('eY-SZtiYSLM:APA91bHs5cbiUuHRsUrvUbfbwjsnKClzQcQ_fgteHwHY3l8CIqiymiYFYt-DbQelPmvGbZoyXtCoSWynNqH9drcH10UUUnMtfhS3CIfptTdW2_Q6lIIO7H3xJDp8l6fu5EJNXl_wrJGi',$data,$priority);
	                      //print_r($noti);
	                      
				
				//}
			
/************** End FCM Code***************************/


		if(!empty($result)){
			
			

			if($data['status']=='cancel'){
				$return = array('status'=>'true','msg'=>'Thank You! You have successfully canceled your ride.');
			}elseif($data['status']=='start'){
				$return = array('status'=>'true','msg'=>'Thank You! You have successfully started your ride.');
			}elseif($data['status']=='complete'){
				$return = array('status'=>'true','totalRideTime'=>$TotalRideTime,'totalTime'=>$TotalRideTime,'isRider'=>$inputJSON->isRider,'rideId'=>$inputJSON->rideId,'msg'=>'Thank You! Your ride has been successfully completed.');
			}else{
				$return = array('status'=>'true','msg'=>'Thank You!');
			}
			
			

		}else{
				$return = array('status'=>'false','success'=>'0','msg'=>'Some issue.');
		}
		
		echo json_encode($return);
		
	}

		public function reviewList()
	{             
		$inputJSON=json_decode(file_get_contents('php://input'));     
		$data['user_id']=$inputJSON->userId;                                 
		
		$resultreviewList = $this->M_android->reviewList($data);
	

		if(!empty($resultreviewList)){
			$return = array('status'=>'true','data'=>$resultreviewList);
		}else{
			$return = array('status'=>'false');
		}
		
		echo json_encode($return);
	}


		public function riderRequestCancel()
	{             
		//header('Content-Type: application/json');
		$inputJSON=json_decode(file_get_contents('php://input'));     
		$data['user_id']=$inputJSON->userId;                                 
		$data['ride_id']=$inputJSON->rideId;                                 
		$data['status']='cancel';                                 
		
		$resultreviewList = $this->M_android->riderRequestCancel($data);
	
		$userData = $this->M_android->getUserId($data['ride_id']); 
		$userId=$userData['accept_user_id'];
		//print_r($userId);
        $deviceId = $this->M_android->getDeviceId($userId); 
			//print_r($deviceId);die;

/*************** Start FCM Code************************/	  		
			$msgData['title'] = 'Ride Information ';
			$msgData['msg'] = 'Your Ride has been '.$data['status'].'ed successfully'; 
			//$msgData['msg'] = 'Your request has been'.$data['status'];
			//$msgData['msg'] = 'New ride request  - '.$_POST['code']; 
			//foreach($resultBack as $k=>$v){
				//$devData=array();
        		//$devData['device_id'] = $deviceId;
        		
        		//$devData['device_id'] = 'c_sRNIscJnw:APA91bGqSy_SaSxu_FwSn69DwUEudej2OheBajGMMKEtmOlUxX8enJGdfXRZJCZL418ElyteL3grI8StJ7Bk2kgOJlgZz7covrBXqYzyFWrLpmmIqatQOtIUYyRyPlYESD_5x-cdy02n_FKmlHxfgHOlEc1zskxTvw';
        		// unset($data);
	       		$timestamp=date('d/m/Y h:i:s');
	                      $datafcm = array
	                      (
	                       'body'  => $msgData['msg'],
	                       'title' => $msgData['title'],
	                       'timestamp'=>$timestamp,
	                       'sound'=>'default'
	                       );
	                      $priority='high';
	                      
	                       $noti=$this->M_android->fcmCustNotification($deviceId['device_id'],$datafcm,$priority);

	                       //print_r( $noti);
	                       //$noti=$this->M_coupon->fcmCustNotification('eY-SZtiYSLM:APA91bHs5cbiUuHRsUrvUbfbwjsnKClzQcQ_fgteHwHY3l8CIqiymiYFYt-DbQelPmvGbZoyXtCoSWynNqH9drcH10UUUnMtfhS3CIfptTdW2_Q6lIIO7H3xJDp8l6fu5EJNXl_wrJGi',$data,$priority);
	                      //print_r($noti);
	                      
				
				//}
			
/************** End FCM Code***************************/



		if(!empty($resultreviewList)){
			$return = array('success'=>'1','status'=>'true','msg'=>'Your ride has been canceled successfully.');
		}else{
			$return = array('success'=>'0','status'=>'false');
		}
		
		echo json_encode($return);
	}


    public function rideHistory(){
    	header('Content-Type: application/json');
	   	$inputJSON=json_decode(file_get_contents('php://input'));
		
		
		$userId=$inputJSON->userId;
		$checkUnvId = $this->M_android->checkUnvId($userId);
		$unvId=$checkUnvId['university_id'];
		//print_r($unvId['university_id']);die;
    	$myTripDetail = $this->M_android->getMyTripRideHistory($unvId,$userId);
    	$myRideDetail = $this->M_android->getMyRideHistory($unvId,$userId);

    	/*$tripRatingData = $this->M_android->getTripRating($unvId,$userId);
    	$rideRatingData = $this->M_android->getRideRating($unvId,$userId);*/
    	//print_r($myTripDetail);die;
    /*	$data['user_id']=$rideDetail[0]['user_id'];
    	$data['mobile']=$rideDetail[0]['mobile'];
    	$data['profile']=$rideDetail[0]['profile'];
    	$data['fname']=$rideDetail[0]['fname'];
    	$data['lname']=$rideDetail[0]['lname'];
    	$data['email']=$rideDetail[0]['email'];
    	$data['id']=$rideDetail[0]['id'];
    	$data['schedule_date']=$rideDetail[0]['schedule_date'];
    	$schedule_time = $rideDetail[0]['schedule_time'];

    	$data['schedule_time'] = date("H:i", strtotime($schedule_time));

    	$data['pick_address']=$rideDetail[0]['pick_address'];
    	$data['pick_lat']=$rideDetail[0]['pick_lat'];
    	$data['pick_log']=$rideDetail[0]['pick_log'];
    	$data['drop_address']=$rideDetail[0]['drop_address'];
    	$data['drop_lat']=$rideDetail[0]['drop_lat'];
    	$data['drop_log']=$rideDetail[0]['drop_log'];
    	$data['status']=$rideDetail[0]['status'];*/

  			if(!empty($myRideDetail)){
				$return = array('status'=>'true','success'=>'1','msg'=>'Success','tripData'=>$myTripDetail,'rideData'=>$myRideDetail);
			}else{
				$return = array('status'=>'false','success'=>'0','msg'=>'No Data');
			}
		echo json_encode($return);

    }

	
	public function changePassword()
	{
		
		$inputJSON=json_decode(file_get_contents('php://input'));
		$userId=$inputJSON->userId;
		$oldPassword=md5($inputJSON->oldPassword);
		
		$NewPassword=$inputJSON->NewPassword;
		$result = $this->M_android->checkOldPassword($userId);
		

		if($result['password']==$oldPassword){
			
			$finalResult = $this->M_android->updatePassword($userId,md5($NewPassword));

			if($finalResult){
				$msg= array('status'=>'true','success'=>'1','msg'=>'Password successfully reset.');
			}else{
				$msg= array('status'=>'false','success'=>'0','msg'=>'Password could not be reset. Try again.');
			}
		}else{
			$msg= array('status'=>'false','success'=>'0','msg'=>'Old Password not matched.');
		}

		echo json_encode($msg);

	}



	public function sendMsg()
	{
		
		$inputJSON=json_decode(file_get_contents('php://input'));
		$data['from_user_id']=$inputJSON->fromUserId;
		$data['to_user_id']=$inputJSON->toUserId;
		$data['ride_id']=$inputJSON->rideId;
		$data['message']=$inputJSON->message;
		$data['created']=$inputJSON->created;

			$deviceId = $this->M_android->getDeviceId($data['to_user_id']); 
			$userData = $this->M_android->getUserData($data['from_user_id']);
			//print_r($userData['fname']);

/*************** Start FCM Code************************/			
			$msgData['title'] = 'New Message ';
			$msgData['msg'] = $data['message']; 
			
	       		$timestamp=date('d/m/Y h:i:s');
	                      $datafcm = array
	                      (
	                       'body'  => $msgData['msg'],
	                       'title' => $msgData['title'],
	                       'fname'=>$userData['fname'],
	                       'lname'=>$userData['lname'],
	                       'fromUserId'=>$inputJSON->fromUserId,
	                       'toUserId'=>$inputJSON->toUserId,
	                       'message'=>$inputJSON->message,
	                       'rideId'=>$inputJSON->rideId,
	                       'created'=>$inputJSON->created,
	                       'type'=>'CHAT',
	                       'sound'=>'default'
	                       );
	                      $priority='high';
	                      
	                       $noti=$this->M_android->fcmCustNotification($deviceId['device_id'],$datafcm,$priority);
	                       //$noti=$this->M_coupon->fcmCustNotification('eY-SZtiYSLM:APA91bHs5cbiUuHRsUrvUbfbwjsnKClzQcQ_fgteHwHY3l8CIqiymiYFYt-DbQelPmvGbZoyXtCoSWynNqH9drcH10UUUnMtfhS3CIfptTdW2_Q6lIIO7H3xJDp8l6fu5EJNXl_wrJGi',$data,$priority);
	                      //print_r($noti);
	                      
				
				//}
			
/************** End FCM Code***************************/
			
			$finalResult = $this->M_android->sendMsg($data);

			if($finalResult){
				$msg= array('status'=>'true','success'=>'1','msg'=>'Message sent successfully..');
			}else{
				$msg= array('status'=>'false','success'=>'0','msg'=>'Message sent successfully.. Try again.');
			}
		

		echo json_encode($msg);

	}

	/*public function getMsg(){
	
	$inputJSON = json_decode(file_get_contents('php//input'));
	$toUserId = $inputJSON->fromUserId;
	/*$toUserId = $inputJSON->toUserId;
	$fromUserId = $inputJSON->fromUserId;*/
	//print_r($toUserId);die;

	//}*/

	public function chatHistory()
	{
		
		$inputJSON=json_decode(file_get_contents('php://input'));
		/*$data['to_user_id']=$inputJSON->toUserId;
		$data['from_user_id']=$inputJSON->fromUserId;*/
		//print_r($toUserId);die;
		$ride_id=$inputJSON->rideId;
		$finalResult = $this->M_android->getchatHistory($ride_id);	
		/*print_r($finalResult);die;	
       		$data['fromUserId']=$finalResult['from_user_id'];
       		$data['toUserId']=$finalResult['to_user_id'];
       		$data['rideId']=$finalResult['ride_id'];
       		$data['isRead']=$finalResult['is_read'];
       		$data['message']=$finalResult['message'];
       		$data['profile']=$finalResult['profile'];
       		$data['created']=$finalResult['created'];*/

			if(!empty($finalResult)){
				$msg= array('status'=>'true','success'=>'1','data'=>$finalResult);
			}else{
				$msg= array('status'=>'false','success'=>'0','msg'=>'Message sent successfully.. Try again.');
			}

			echo json_encode($msg);
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
			$final = array('success' =>'0' ,'msg'=>'No data found');
		}

		echo json_encode($final);
	}


	//http://192.168.1.4/pumpkart/Android/getProducts/?cat_id=&sub_id=&brand_id=&user_id=&recommended=
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
						$priceRange = $this->M_android->getProductPriceRange($valP['id']);
						$data['product_id'] = $valP['id'];
						
						if(empty($priceRange)){
							$priceRange = $this->M_android->getUserProductPriceRange($data);
						}
						
						$taxData= $this->getUserTax($data['user_id'],$valP['commodity_id']);

						if($valP['quantity'] == 0 || $valP['stock_available'] == 2){
							$result[$kS]['products'][$keyP]['stock_available'] = 0;
						}

						if(!empty($priceRange)){
						
						$result[$kS]['products'][$keyP]['tax'] = $taxData['tax_name'];

						$userDiscount = $taxData['user_discount'];

						

						$priceRange2 = $this->M_android->getProductPrice($valP['id']);
						$priceSpBase = $priceRange2['price'];
						@$taxAmountBase = ($priceRange2['price']/100)*$taxData['rate'];
						$discountAmount = 0;

						if(isset($priceRange[0]['moq'])){
							$priceTo = $priceRange[0]['moq']-1;
							$price[] = array('from'=>"1",'to'=>"$priceTo",'price'=>$priceSpBase,'tax_amount'=>$taxAmountBase,'discount_amount'=>$discountAmount);
					    }
						
						foreach($priceRange as $kR=>$vR){
							
							if(isset($vR['moq'])){
								$priceFrom = $vR['moq'];
								if(@$priceRange[$kR+1]['moq']){
									$priceTo = $priceRange[$kR+1]['moq']-1;
								}else{
									$priceTo = 'Above' ;
								}
							}else{
								$priceFrom = $vR['range_from'];
								if(@$priceRange[$kR+1]['range_from']){
									$priceTo = $priceRange[$kR+1]['range_from']-1;
								}else{
									$priceTo = 'Above' ;
								}

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
				
				$data['product_id'] = $vP['id'];	
				if(empty($priceRange)){
						$priceRange = $this->M_android->getUserProductPriceRange($data);
				}

				$result[$kS]['products'][$kP]['tax'] = $this->getUserTax($data['user_id'],$vP['commodity_id']);
				$userDiscount = $result[$kS]['products'][$keyP]['tax']['user_discount'];

				if($vP['quantity'] == 0 || $vP['stock_available'] == 2){
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
				$productTemp = array();
				foreach($resultMain as $keyMain=>$valMain){
					$result = $this->M_android->subCategories($valMain['id']);
					//$result[$keyMain]['filters'] = $filters;
					$finalData['id'] = $valMain['id'];
					$finalData['name'] = $valMain['name'];
					unset($productTemp);

					foreach($result as $kS=>$vS){
					
					$resultMain[$keyMain]['products'] = $this->M_android->getBrandProducts($vS['id'],$data['brand_id'],$filter);
					$resultMain[$keyMain]['filters'] = $filters;

					if(!empty($resultMain[$keyMain]['products'])){

						foreach($resultMain[$keyMain]['products'] as $keyP=>$valP){
							unset($price);

							$priceRange = $this->M_android->getProductPriceRange($valP['id']);
					
							$data['product_id'] = $valP['id'];
							if(empty($priceRange)){
									$priceRange = $this->M_android->getUserProductPriceRange($data);
							}

							$taxData= $this->getUserTax($data['user_id'],$valP['commodity_id']);
							if($valP['quantity'] == 0 || $valP['stock_available'] == 2){
								$resultMain[$keyMain]['products'][$keyP]['stock_available'] = 0;
							}

							if(!empty($priceRange)){
							//$resultMain[$keyMain]['products'][$keyP]['tax'] = $this->getUserTax($data['user_id'],$valP['commodity_id']);

								$resultMain[$keyMain]['products'][$keyP]['tax'] = $taxData['tax_name'];

								$priceRange2 = $this->M_android->getProductPrice($valP['id']);
								$priceSpBase = $priceRange2['price'];
								@$taxAmountBase = ($priceRange2['price']/100)*$taxData['rate'];
								$discountAmount = 0;
								//old : $priceTo = $priceRange[0]['moq']-1;
								/******* change new **********/
								if(isset($priceRange[0]['moq'])){
									$priceTo = $priceRange[0]['moq']-1;
									$price[] = array('from'=>"1",'to'=>"$priceTo",'price'=>$priceSpBase,'tax_amount'=>$taxAmountBase,'discount_amount'=>$discountAmount);
						    	}
								/******* change new end**********/

								//old  : $price[] = array('from'=>"1",'to'=>$priceTo,'price'=>$priceSpBase,'tax_amount'=>$taxAmountBase,'discount_amount'=>$discountAmount);

							$taxData= $this->getUserTax($data['user_id'],$valP['commodity_id']);
							$resultMain[$keyMain]['products'][$keyP]['tax'] = $taxData['tax_name'];
							$userDiscount = $taxData['user_discount'];
							

							foreach($priceRange as $kR=>$vR){
								

								/*$priceFrom = $vR['moq'];
								if(@$priceRange[$kR+1]['moq']){
									$priceTo = $priceRange[$kR+1]['moq']-1;
								}else{
									$priceTo = 'Above' ;
								}*/

								/******* change new **********/
								if(isset($vR['moq'])){
								$priceFrom = $vR['moq'];
								if(@$priceRange[$kR+1]['moq']){
									$priceTo = $priceRange[$kR+1]['moq']-1;
								}else{
									$priceTo = 'Above' ;
								}
								}else{
									$priceFrom = $vR['range_from'];
									if(@$priceRange[$kR+1]['range_from']){
										$priceTo = $priceRange[$kR+1]['range_from']-1;
									}else{
										$priceTo = 'Above' ;
									}

								}
								/******* change new end**********/




								$priceSp = $vR['price'];
								$taxAmount = ($vR['price']/100)*$taxData['rate'];
								
								//$discountAmount = ($vR['price']/100)*$userDiscount;
								$discountAmount = 0;
								$price[] = array('from'=>$priceFrom,'to'=>$priceTo,'price'=>$priceSp,'tax_amount'=>$taxAmount,'discount_amount'=>$discountAmount);
							}

							
							$resultMain[$keyMain]['products'][$keyP]['price_tax'] = $price[0]['tax_amount'];
							

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
						foreach ($resultMain[$keyMain]['products'] as $keytt => $valuett) {
							
						$productTemp[] = $valuett;

						}
					}else{
						//unset($resultMain[$keyMain]);
					}

				}
				if(!empty($productTemp)){
					$finalData['products'] = $productTemp;
					$resultData[] =$finalData;
				}else{
					unset($resultMain[$keyMain]);
				}

					 

			}
			//$resultMain = array_values($resultMain);
			echo json_encode($resultData);die;

		}else if(!empty($data['recommended'])){
			$inputTempJSON =  stripslashes(urldecode($_REQUEST['recommended']));

		$inputJSON = json_decode($inputTempJSON);

		$userId = $_REQUEST['user_id'];
		$result = $this->M_android->addUserPump($inputTempJSON,$userId);

		$filter['recom_application'] = $inputJSON->application;
		//$filter['recom_flow_rate'] = $inputJSON->flow_rate;
		//$filter['recom_flow_rate_measurement'] = $inputJSON->flow_rate_measurement;
		$filter['recom_fluid'] = $inputJSON->fluid;
		$filter['recom_phase'] = $inputJSON->phase;
		//$filter['recom_power_rating'] = $inputJSON->power_rating;
		//$filter['recom_power_rating_measurement'] = $inputJSON->power_rating_measurement;
		//$filter['recom_head'] = $inputJSON->head;
		//$filter['recom_required_head_measurement'] = $inputJSON->required_head_measurement;
		$filter['recom_liquid_handle'] = $inputJSON->liquid_handle;


			$result = $this->M_android->allSubCategories();

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
			if(!empty($result)){
			foreach($result as $kS=>$vS){
				$result[$kS]['products'] = $this->M_android->getProducts($vS['id'],$filter);
				$result[$kS]['filters'] = $filters;


				if(!empty($result[$kS]['products'])){

					foreach($result[$kS]['products'] as $keyP=>$valP){

						unset($price);
						$priceRange = $this->M_android->getProductPriceRange($valP['id']);
						$data['product_id'] = $valP['id'];
						if(empty($priceRange)){
								$priceRange = $this->M_android->getUserProductPriceRange($data);
						}

						$priceRange = $this->M_android->getUserProductPriceRange($data);
						
						$taxData= $this->getUserTax($data['user_id'],$valP['commodity_id']);

						if($valP['quantity'] == 0 || $valP['stock_available'] == 2){
							$result[$kS]['products'][$keyP]['stock_available'] = 0;
						}

						if(!empty($priceRange)){
						
						$result[$kS]['products'][$keyP]['tax'] = $taxData['tax_name'];

						$userDiscount = $taxData['user_discount'];

						

						$priceRange2 = $this->M_android->getProductPrice($valP['id']);
						$priceSpBase = $priceRange2['price'];
						@$taxAmountBase = ($priceRange2['price']/100)*$taxData['rate'];
						$discountAmount = 0;

						if(isset($priceRange[0]['moq'])){
							$priceTo = $priceRange[0]['moq']-1;
							$price[] = array('from'=>"1",'to'=>"$priceTo",'price'=>$priceSpBase,'tax_amount'=>$taxAmountBase,'discount_amount'=>$discountAmount);
						}

						foreach($priceRange as $kR=>$vR){
							
							if(isset($vR['moq'])){
								$priceFrom = $vR['moq'];
								if(@$priceRange[$kR+1]['moq']){
									$priceTo = $priceRange[$kR+1]['moq']-1;
								}else{
									$priceTo = 'Above' ;
								}
						    }else{
						    	$priceFrom = $vR['range_from'];
								if(@$priceRange[$kR+1]['range_from']){
									$priceTo = $priceRange[$kR+1]['range_from']-1;
								}else{
									$priceTo = 'Above' ;
								}
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

		}

		//$final = array($result);

		$result = array_values($result);
	
		echo json_encode($result);
	}

	
	/*public function getUserTax($id,$commodityId){
		
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

	}*/


	public function getUserTax($id,$commodityId){
		
		$isGST = $this->M_android->isGST();
		if(!$isGST){
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
		}else{
			$userData = $this->M_android->getUserDetails($id);
			$taxTypeId=4;//GST tax type
			$data['state_id'] = $userData['state_id'];
			$data['tax_type_id'] = $taxTypeId;
			$data['commodity_id'] = $commodityId;
		}


		$taxData = $this->M_android->getUserTax($data);
		$taxData['user_discount'] = $userData['discount'];

		if($data['tax_type_id'] == "4"){
			if($userData['state_id'] == 6){
				$taxData['gst_type'] = "CGST/UGST";
			}else{
				$taxData['gst_type'] = "IGST";
			}
		}
		
		return $taxData;

	}



	
	//http://192.168.1.4/pumpkart/Android/getProductDetails/?id=&user_id=
	public function getProductDetails()
	{
		$data = $_GET;
		$res = $this->M_android->getProductDetails($data['id']);
		$price = array();

		if($res['quantity'] <= 0 || $res['stock_available'] == 2){
			$res['stock_available'] = '0';
		}
		//site_url().'assets/image/products/original/'

		$result = array('id' => $res['id'], 'name' => $res['name'],'brand' => $res['brand_name'], 'brand_support' => $res['brand_support'],'description'=>$res['description'], 'short_description'=>$res['short_description'], 'mrp'=>$res['mrp'], 'sku'=>$res['sku'],'price'=>$res['price'], 'is_featured'=>$res['is_featured'], 'weight'=>$res['weight'], 'care_instructions'=>$res['care_instructions'], 'featured_image' => $res['featured_image'],'stock_available'=>$res['stock_available'], 'warranty'=>$res['warranty'], 'quantity'=>$res['quantity']);
		
		
		
		$priceRange = $this->M_android->getProductPriceRange($data['id']);
		
		if(empty($priceRange))
		{
			$data['product_id'] = $data['id'];
			$priceRange = $this->M_android->getUserProductPriceRange($data);
		}
		//$result['tax'] = $this->getUserTax($data['user_id'],$res['commodity_id']);
		$taxData= $this->getUserTax($data['user_id'],$res['commodity_id']);
		$result['tax'] = $taxData['tax_name'];

		$userDiscount = $taxData['user_discount'];


		if(!empty($priceRange)){
						$priceRange2 = $this->M_android->getProductPrice($data['id']);
						$priceSpBase = $priceRange2['price'];
						@$taxAmountBase = ($priceRange2['price']/100)*$taxData['rate'];
						$discountAmount = 0;
						if(isset($priceRange[0]['moq'])){
							$priceTo = $priceRange[0]['moq']-1;
							$price[] = array('from'=>"1",'to'=>$priceTo,'price'=>$priceSpBase,'tax_amount'=>$taxAmountBase,'discount_amount'=>$discountAmount);

						}else{
							$priceTo = $priceRange[0]['range_from'];
						}

						
		foreach($priceRange as $k=>$v){

			if(!isset($v['moq'])){

				$priceFrom = $v['range_from'];
				if(@$priceRange[$k+1]['range_from']){
					$priceTo = $priceRange[$k+1]['range_from']-1;
				}else{
					$priceTo = 'Above' ;
				}
			}else{

				$priceFrom = $v['moq'];
				if(@$priceRange[$k+1]['moq']){
					$priceTo = $priceRange[$k+1]['moq']-1;
				}else{
					$priceTo = 'Above' ;
				}

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
			$result['specifications'][] = array('heading' => 'TANK CAPACITY','value' => $res['tank_capacity'],'min'=>0,'max'=>0);
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
			$final = array('success' =>'0' ,'msg'=>'No data found');
		}
		
		echo json_encode($final);
	}

	public function getComparison()
	{
		$inputJSON = file_get_contents('php://input');
		$inputData = json_decode($inputJSON);
		$userId = $inputData->user_id;
		//$inputData = array('1');
		$outlet['label_name'] = 'Outlet';
		$inlet['label_name'] = 'Inlet';
		$flow_rate['label_name'] = 'Flow Rate';
		$pr_hp['label_name'] = 'Power Rating (HP)';
		$pr_kw['label_name'] = 'Power Rating (KW)';
		$bore['label_name'] = 'Bore Diameter';
		$head['label_name'] = 'Head Range';
		$price = array();
		$image = array();
		
		foreach($inputData->data as $v){

			$result = $this->M_android->getProductDetails($v);
			$data['product_id'] = $v;
			$data['user_id'] = $userId;
			$priceRange = $this->M_android->getUserProductPriceRange($data);
			$taxData= $this->getUserTax($userId,$result['commodity_id']);
			$result['tax'] = $taxData['tax_name'];

			if(!empty($priceRange)){
						$priceRange2 = $this->M_android->getProductPrice($v);
						$priceSpBase = $priceRange2['price'];
						$result['price'] = $priceSpBase;
			}else{
						$priceRange2 = $this->M_android->getProductPrice($v);
						$priceSp = $priceRange2['price'];
						$result['price'] = $priceSp;	
			}

			$price['name'] = $result['name'];
			$price['price'] = $result['price'];

			$outletData['heading'] = $result['name'];
			$outletData['value'] = $result['outlet_size'];
			$outlet['data'][] = $outletData;

			$inletData['heading'] = $result['name'];
			$inletData['value'] = $result['inlet_size'];
			$inlet['data'][] = $inletData;

			$frData['heading'] = $result['name'];
			$frData['value'] = $result['flow_min'] ." - ".$result['flow_max']." ".strtoupper($result['flow_unit']);
			$flow_rate['data'][] = $frData;

			$prhpData['heading'] = $result['name'];
			$prhpData['value'] = $result['power_rating_hp'];
			$pr_hp['data'][] = $prhpData;

			$prkwData['heading'] = $result['name'];
			$prkwData['value'] = $result['power_rating_kw'];
			$pr_kw['data'][] = $prkwData;

			if(empty($result['bore_diameter_name'])){
				$result['bore_diameter_name'] = "-";
			}
			$boreData['heading'] = $result['name'];
			$boreData['value'] = $result['bore_diameter_name'];
			$bore['data'][] = $boreData;

			$headData['heading'] = $result['name'];
			$headData['value'] = $result['head_min'] ." - ".$result['head_max'] ." Meter";
			$head['data'][] = $headData;

			$finalPrice[] = $price;


			$product_id = $v;
			$data = $this->M_android->getProductDetails($product_id);
			
			
			$cat = $this->M_android->getProductCategories($product_id);

			foreach ($cat as $Ckey => $Cvalue) {
				$data['category_id'] = $Cvalue['category_id'];

				$result = $this->M_android->getDataSheet($data);
				if(!empty($result)){
					foreach($result as $key => $value) {

					$tempImage = 'http://pumpkart.in/admin/assets/image/graphs/original/'.$value['image'];
					if(!in_array($tempImage, $image)){
						$image[] = $tempImage;
					}

					}
				}
			}


		}

		$specifications[]=$outlet;
		$specifications[]=$inlet;
		$specifications[]=$flow_rate;
		$specifications[]=$pr_hp;
		$specifications[]=$pr_kw;
		$specifications[]=$bore;
		$specifications[]=$head;


		$final = (object) array('specifications'=>$specifications,'price'=>$finalPrice,'data_sheets'=>$image);
		echo json_encode($final);
		
	}


	//http://192.168.1.4/pumpkart/Android/getHomeDataNew/
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
			$final = array('success' =>'0' ,'msg'=>'No data found');
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
			foreach($autoSuggestionListData as $key=>$val){
				$image = $this->M_android->getFeaturedImage($val['id']);
				$autoSuggestionListData[$key]['image'] = $image['image'];
			}
			$final = $autoSuggestionListData;
		}else{
				//$dataSuggestions = array('success'=>'false','msg'=>'No suggestion found.');
			$final = array('success' =>'0' ,'msg'=>'No data found');
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
		
		$userData = $this->M_android->getUserDetails($userId);
		$result = $this->M_android->getShippingAddress($userId);
		$result['fname'] = $userData['fname'];
		$result['lname'] = $userData['lname'];
		$result['phone'] = $userData['mobile'];
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
    <th colspan="3">PMK'.$resultOrderId.'</th>
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
$custSubject = "Your order no. PMK".$resultOrderId." has been Placed";
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
          //$data['order_id'] = $resultOrderId;
          $data['related_id'] = $resultOrderId;
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
		$resultorder= array('success'=>'true','msg'=>'Order placed successfully.','order_id'=>$resultOrderId,'pkart'=>$pkart, 'order_date'=>date('l d M, Y'));
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
		 $customerOrder = array();
		 $userOrder = array();

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
		
		if($val['delivery_user_type'] == 'C'){			
			$customerOrder[] = $resultOrders[$key];
		}else{
			$userOrder[] = $resultOrders[$key];
		}


		}	
		}/*else{
			$resultOrders=array();
		}*/
		$final=array('customer_order'=>$customerOrder,'user_order'=>$userOrder);
		echo json_encode($final);
	}


	//http://192.168.1.4/pumpkart/Android/getProfile?user_id=
	/*public function getProfile()
	{
		$userId = $_REQUEST['user_id'];
		$result = $this->M_android->getUserDetails($userId);	
		echo json_encode($result);
	}*/

	
	//http://192.168.1.4/pumpkart/Android/verifyCoupon?user_id=&code=&amount=
	public function verifyCouponOld()
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
				$response = array('success'=>'1','msg'=>'Valid coupon code.','coupon_value'=>$result['coupon_value'],'coupon_value_type'=>$result['value_type'],'coupon_discount'=>$discount, 'coupon_id'=>$result['id']);
			}else{
				$response = array('success'=>'0','msg'=>'Invalid coupon code.');
			}
		}else{
			$check = $this->M_android->checkUsedCoupon($code,$userId);
			if($check == 0){
				if($result['value_type'] == 'P'){
						$discount = ($amount*$result['coupon_value'])/100;
					}else if($result['value_type'] == 'F'){
						$discount = $result['coupon_value'];
					}
					$response = array('success'=>'1','msg'=>'Valid coupon code.','coupon_value'=>$result['coupon_value'],'coupon_value_type'=>$result['value_type'],'coupon_discount'=>$discount, 'coupon_id'=>$result['id']);

			}else{
					$response = array('success'=>'0','msg'=>'You have already used this coupon.');
			}

		}
	}else{
		$response = array('success'=>'0','msg'=>'Invalid coupon code.');
	}

		echo json_encode($response);
	}


	//http://192.168.1.4/pumpkart/Android/verifyCoupon?user_id=&code=&amount=
	public function verifyCoupon()
	{
		$inputJSON = json_decode(file_get_contents('php://input'));

		$userId = $inputJSON->user_id;
		$code = $inputJSON->code;
		$amount = $inputJSON->order_total;
		$couponApplied = 0;

		$result = $this->M_android->getCouponDetails($code);

		if(!empty($result)){

		if($result['is_multiple'] == 'Y'){
			if($result){

		foreach($inputJSON->product_details as $k=>$data)
		{
			$tempData['id'] = $data->id;


			$resultVp = $this->M_android->getProductDetails($tempData['id']);
			$tempData['brand_name'] = $resultVp['brand_name'];
			$tempData['name'] = $resultVp['name'];
			$tempData['featured_image'] = $resultVp['featured_image'];
			//$tempData['tax_amount'] = 120;
			$taxData = $this->M_android->getUserTaxModel($userId,$resultVp['commodity_id']);
			if($result['type']=='B'){

				if($resultVp['brand_id']== $result['type_id']){
					$couponApplied = 1;
					if($result['value_type']='P'){
						$tempData['discount'] = (($result['coupon_value']*$data->price)/100)*$data->units;
					}else{
						$tempData['discount'] = $result['coupon_value']*$data->units;
					}
				}else{
					$tempData['discount'] = 0;
				}
				

			}else if($result['type']=='P'){
				$couponApplied = 1;
				if($resultVp['id']==$result['type_id']){
					if($result['value_type']='P'){
						$tempData['discount'] = (($result['coupon_value']*$data->price)/100)*$data->units;
					}else{
						$tempData['discount'] = $result['coupon_value']*$data->units;
					}
				}else{
					$tempData['discount'] = 0;
				}
				

			}else if($result['type']=='C'){

				$category = $this->M_android->getCategory($result['type_id']);
				if($category['parent_id']==0){
						if($resultVp['parent_id']==$result['type_id']){
							$couponApplied = 1;
							if($result['value_type']='P'){
								$tempData['discount'] = (($result['coupon_value']*$data->price)/100)*$data->units;
							}else{
								$tempData['discount'] = $result['coupon_value']*$data->units;
							}
						}else{
								$tempData['discount'] = 0;
						}
						
					
				}else{
					if($resultVp['category_id']==$result['type_id']){
							$couponApplied = 1;
							if($result['value_type']='P'){
								$tempData['discount'] = (($result['coupon_value']*$data->price)/100)*$data->units;
							}else{
								$tempData['discount'] = $result['coupon_value']*$data->units;
							}
						}else{
								$tempData['discount'] = 0;
						}
						
				}
			}

			$tempData['units'] = $data->units;
			$tempData['price'] = $data->price;
			$tempData['totalPrice'] = $data->totalPrice;
			$tempData['tax_amount'] = ((($data->price * $data->units) - $tempData['discount'])*$taxData['rate'])/100;

			$finalData[] = $tempData;
			
		}
			if($result['type']=='D'){
				$couponApplied = 1;
				if($result['value_type'] == 'P'){
					$discount = ($amount*$result['coupon_value'])/100;
				}else if($result['value_type'] == 'F'){
					$discount = $result['coupon_value'];
				}
			}else{
				$discount = 0;
			}


			if($couponApplied==1){
				$response = array('success'=>'1','msg'=>'Valid coupon code.','coupon_value'=>$result['coupon_value'],'coupon_value_type'=>$result['value_type'],'coupon_discount'=>$discount, 'coupon_id'=>$result['id'], 'data'=>$finalData);
			}else{
				$response = array('success'=>'0','msg'=>'Coupon cannot be applied.');
			}



			}else{
				$response = array('success'=>'0','msg'=>'Invalid coupon code.');
			}
		}else{
			$check = $this->M_android->checkUsedCoupon($code,$userId);
			if($check == 0){
				foreach($inputJSON->product_details as $k=>$data)
		{
			$tempData['id'] = $data->id;


			$resultVp = $this->M_android->getProductDetails($tempData['id']);
			$tempData['brand_name'] = $resultVp['brand_name'];
			$tempData['name'] = $resultVp['name'];
			$tempData['featured_image'] = $resultVp['featured_image'];
			//$tempData['tax_amount'] = 120;
			$taxData = $this->M_android->getUserTaxModel($userId,$resultVp['commodity_id']);
			if($result['type']=='B'){

				if($resultVp['brand_id']== $result['type_id']){
					$couponApplied = 1;
					if($result['value_type']='P'){
						$tempData['discount'] = (($result['coupon_value']*$data->price)/100)*$data->units;
					}else{
						$tempData['discount'] = $result['coupon_value']*$data->units;
					}
				}else{
					$tempData['discount'] = 0;
				}
				

			}else if($result['type']=='P'){
				$couponApplied = 1;
				if($resultVp['id']==$result['type_id']){
					if($result['value_type']='P'){
						$tempData['discount'] = (($result['coupon_value']*$data->price)/100)*$data->units;
					}else{
						$tempData['discount'] = $result['coupon_value']*$data->units;
					}
				}else{
					$tempData['discount'] = 0;
				}
				
			}else if($result['type']=='C'){

				$category = $this->M_android->getCategory($result['type_id']);
				if($category['parent_id']==0){
						if($resultVp['parent_id']==$result['type_id']){
							$couponApplied = 1;
							if($result['value_type']='P'){
								$tempData['discount'] = (($result['coupon_value']*$data->price)/100)*$data->units;
							}else{
								$tempData['discount'] = $result['coupon_value']*$data->units;
							}
						}else{
								$tempData['discount'] = 0;
						}
						
					
				}else{
					if($resultVp['category_id']==$result['type_id']){
							$couponApplied = 1;
							if($result['value_type']='P'){
								$tempData['discount'] = (($result['coupon_value']*$data->price)/100)*$data->units;
							}else{
								$tempData['discount'] = $result['coupon_value']*$data->units;
							}
						}else{
								$tempData['discount'] = 0;
						}
						
				}
			}
			
			$tempData['units'] = $data->units;
			$tempData['price'] = $data->price;
			$tempData['totalPrice'] = $data->totalPrice;
			$tempData['tax_amount'] = ((($data->price * $data->units) - $tempData['discount'])*$taxData['rate'])/100;

			$finalData[] = $tempData;
			
		}
			if($result['type']=='D'){
				$couponApplied = 1;
				if($result['value_type'] == 'P'){
					$discount = ($amount*$result['coupon_value'])/100;
				}else if($result['value_type'] == 'F'){
					$discount = $result['coupon_value'];
				}
			}else{
				$discount = 0;
			}


			if($couponApplied==1){
				$response = array('success'=>'1','msg'=>'Valid coupon code.','coupon_value'=>$result['coupon_value'],'coupon_value_type'=>$result['value_type'],'coupon_discount'=>$discount, 'coupon_id'=>$result['id'], 'data'=>$finalData);
			}else{
				$response = array('success'=>'0','msg'=>'Coupon cannot be applied.');
			}



			$response = array('success'=>'1','msg'=>'Valid coupon code.','coupon_value'=>$result['coupon_value'],'coupon_value_type'=>$result['value_type'],'coupon_discount'=>$discount, 'coupon_id'=>$result['id'],'data'=>$finalData);

			}else{
					$response = array('success'=>'0','msg'=>'You have already used this coupon.');
			}

		}
	}else{
		$response = array('success'=>'0','msg'=>'Invalid coupon code.');
	}

		echo json_encode($response);
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

        $result = array('paymentHash'=>$hash,'txnid'=>$txnid);
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
		/*if(!isset($_REQUEST['ver'])){
			$result = $this->M_android->getBanners();
			foreach($result as $val){
				$images[]=$val['image'];
			}
		}else{*/
			$result = $this->M_android->getBanners();
			foreach($result as $val){
				$tempImg[]=$val['image'];
			}

			if($_REQUEST['ver'] == 'v3'){
				$images['success'] = 1;
				$images['msg'] = "";
			}else{
				$images['success'] = 0;
				$images['msg'] = "Please update your application.";
			}

			$images['data'] = $tempImg; 
			$images['contact'] = '1800 3000 0917';
		//}

		echo json_encode($images);
	}




	//http://192.168.1.4/pumpkart/Android/testSMS/
	public function testSMS()
	{
		$data = $_REQUEST;
		$result = $this->M_android->testSMS();
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
				$msg= array('success'=>'1','msg'=>'Password successfully reset.');
			}else{
				$msg= array('success'=>'0','msg'=>'Password could not be reset. Try again.');
			}
		}else if(isset($data['old_password'])){
			if($userData['password'] == md5($data['old_password'])){
				unset($data['old_password']);
				$finalResult = $this->M_android->updatePassword($result['id'],md5($data['password']));

				if($finalResult){
					$msg= array('success'=>'1','msg'=>'Password successfully reset.');
				}else{
					$msg= array('success'=>'0','msg'=>'Password could not be reset. Try again.');
				}
			}else{
				$return = array('status'=>'false','success'=>'0','msg'=>'Password do not match.');
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

			$dataNoti['related_id'] = $result['id'];
			$dataNoti['noti_type'] = '5';
			$resultBack = $this->M_android->getBackendUsers();
	        foreach($resultBack as $k=>$v){
	        		$dataNoti['user_id'] = $v['id'];
					$resultNoti = $this->M_android->addNotifications($dataNoti);
			}
			
			if($result){
				$return = array('status'=>'true','success'=>'1','msg'=>'Thanks for submitting.');
			}else{
				$return = array('status'=>'false','success'=>'0','msg'=>'Try again.');
			}

		echo json_encode($return);
		
	}


	//http://192.168.1.4/pumpkart/Android/postBid/?user_id=&product_id=&bid_price=
	public function postBid()
	{

		$data = $_GET;
		$data['created'] = date("Y-m-d H:i:s");

		$dataNoti['related_id'] = $_REQUEST['user_id'];
		
		$dataNoti['noti_type'] = '4';
		$resultBack = $this->M_android->getBackendUsers();
        foreach($resultBack as $k=>$v){
        		$dataNoti['user_id'] = $v['id'];
				$resultNoti = $this->M_android->addNotifications($dataNoti);
		}

			$result = $this->M_android->postBid($data);
			
			if($result){
				$return = array('status'=>'true','success'=>'1','msg'=>'Thanks for submitting.');
			}else{
				$return = array('status'=>'false','success'=>'0','msg'=>'Try again.');
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
			$return = array('success'=>'1','msg'=>'Thank you for submitting.');
		}else{
			$return = array('success'=>'0','msg'=>'Try again.');
		}

		echo json_encode($return);
	}


	//http://192.168.1.4/pumpkart/Android/addCapitalQuery/?user_id=
	public function addCapitalQuery()
	{
		
		$data['user_id'] = $_REQUEST['user_id'];
		$result = $this->M_android->addCapitalQuery($data);
		
		if($result){

			if(isset($result['exists'])){
				$dataNoti['related_id'] = $result['id'];
				$dataNoti['noti_type'] = '3';
				$resultBack = $this->M_android->getBackendUsers();
	        	foreach($resultBack as $k=>$v){
	        		$dataNoti['user_id'] = $v['id'];
					$resultNoti = $this->M_android->addNotifications($dataNoti);
				}
			}

			$return = array('success'=>'1','msg'=>'Thank you for submitting.');
		}else{
			$return = array('success'=>'0','msg'=>'Try again.');
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


	//http://192.168.1.4/pumpkart/Android/getDataSheet/?product_id=
	public function getDataSheet()
	{
		
		$product_id = $_REQUEST['product_id'];
		$data = $this->M_android->getProductDetails($product_id);
		$image = array();
		
		$cat = $this->M_android->getProductCategories($product_id);

		/*foreach ($cat as $Ckey => $Cvalue) {
			$data['category_id'] = $Cvalue['category_id'];

			$result = $this->M_android->getDataSheet($data);
			if(!empty($result)){
				foreach($result as $key => $value) {
				$image[] = 'http://pumpkart.in/admin/assets/image/graphs/original/'.$value['image'];
				}
			}
		}*/


			
			$result = $this->M_android->getDataSheet($data);
			if(!empty($result)){
				foreach($result as $key => $value) {
				$image[] = 'http://pumpkart.in/admin/assets/image/graphs/original/'.$value['image'];
				}
			}


		if(!empty($image)){
			$return = array('success'=>'1','data'=>$image);
		}else{
			$return = array('success'=>'0','data'=>$image);
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
			$productData= array('success'=>'0','msg'=>'No products founds.');
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
	public function paytmPaymentWallet()
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


	/*//http://192.168.1.4/pumpkart/Android/paytmPayment/?user_id=
	public function getChecksum()
	{
		
		header("Pragma: no-cache");
		header("Cache-Control: no-cache");
		header("Expires: 0");
		// following files need to be included
		require_once(APPPATH.'libraries/paytm/encdec_paytm.php');
		require_once(APPPATH.'libraries/paytm/config_paytm.php');

		
		$checkSum = "";
		$paramList = array();
		$ORDER_ID = $_POST["ORDER_ID"];
		$CUST_ID = $_POST["CUST_ID"];
		$INDUSTRY_TYPE_ID = $_POST["INDUSTRY_TYPE_ID"];
		$CHANNEL_ID = $_POST["CHANNEL_ID"];
		$TXN_AMOUNT = $_POST["TXN_AMOUNT"];
		// Create an array having all required parameters for creating checksum.
		$paramList["MID"] = PAYTM_MERCHANT_MID;
		$paramList["ORDER_ID"] = $ORDER_ID;
		$paramList["CUST_ID"] = $CUST_ID;
		$paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
		$paramList["CHANNEL_ID"] = $CHANNEL_ID;
		$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
		$paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
		
		$checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
		$data = $_POST;
		$data['CHECKSUMHASH'] = $checkSum;
		$data['payt_STATUS'] = '1';

		echo json_encode($data);
		
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
		$isValidChecksum = "FALSE";
		$paramList = $_POST;
		$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
		//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
		$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.

		echo $isValidChecksum;

	}*/


	//http://192.168.1.4/pumpkart/Android/paytmPayment/?user_id=
	public function getChecksum()
	{
		
		// header("Pragma: no-cache");
		// header("Cache-Control: no-cache");
		// header("Expires: 0");
		// // following files need to be included
		// require_once(APPPATH.'libraries/paytm/encdec_paytm.php');
		// require_once(APPPATH.'libraries/paytm/config_paytm.php');

		// //require_once("./lib/config_paytm.php");
		// //require_once("./lib/encdec_paytm.php");
		// $checkSum = "";
		// $paramList = array();
		// $ORDER_ID = $_POST["ORDER_ID"];
		// $CUST_ID = $_POST["CUST_ID"];
		// $INDUSTRY_TYPE_ID = $_POST["INDUSTRY_TYPE_ID"];
		// $CHANNEL_ID = $_POST["CHANNEL_ID"];
		// $TXN_AMOUNT = $_POST["TXN_AMOUNT"];
		// // Create an array having all required parameters for creating checksum.
		// $paramList["MID"] = PAYTM_MERCHANT_MID;
		// $paramList["ORDER_ID"] = $ORDER_ID;
		// $paramList["CUST_ID"] = $CUST_ID;
		// $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
		// $paramList["CHANNEL_ID"] = $CHANNEL_ID;
		// $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
		// $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
		// /*
		// $paramList["MSISDN"] = $MSISDN; //Mobile number of customer
		// $paramList["EMAIL"] = $EMAIL; //Email ID of customer
		// $paramList["VERIFIED_BY"] = "EMAIL"; //
		// $paramList["IS_USER_VERIFIED"] = "YES"; //
		// */
		// //Here checksum string will return by getChecksumFromArray() function.
		// $checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
		// $data = $_POST;
		// $data['CHECKSUMHASH'] = $checkSum;
		// $data['payt_STATUS'] = '1';

		// echo json_encode($data);

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


	public function verifyCheckSum()
	{
		// header("Pragma: no-cache");
		// header("Cache-Control: no-cache");
		// header("Expires: 0");
		// // following files need to be included
		// require_once(APPPATH.'libraries/paytm/encdec_paytm.php');
		// require_once(APPPATH.'libraries/paytm/config_paytm.php');
		// $paytmChecksum = "";
		// $paramList = array();
		// $isValidChecksum = "FALSE";
		// $paramList = $_POST;
		// $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
		// //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
		// $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.

		// echo $isValidChecksum;

		header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
// following files need to be included
// require_once("./lib/config_paytm.php");
// require_once("./lib/encdec_paytm.php");
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
$encoded_json = htmlentities(json_encode($return_array));
	}
}



     