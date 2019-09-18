<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller 
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

		$this->load->model('M_welcome');
		$this->load->model('M_android');
		$this->load->model('M_user');
		$this->load->model('M_capital_query');
		
		$this->load->library('session');
    	$this->load->helper('url');
		
    }
	
	public function index()
	{
		$this->load->model('M_welcome');
		
		if(($this->session->userdata('user_name')==""))
  		{ 
			redirect('Welcome/login');
		}

		$filter = array();


		$result['totalUniversities'] = $this->M_welcome->totalUniversities($filter);
		//$result['orders'] = $this->M_welcome->totalOrders($filter);
		$result['students'] = $this->M_welcome->totalStudents($filter);
		$result['bestUniversities'] = $this->M_welcome->bestUniversities($filter);
		//print_r($result['bestUniversities']);die();
		//$result['totalProfit'] = $this->M_welcome->totalProfit($filter);

/*		if(!empty($result['bestUniversities'])){
			foreach($result['bestUniversities'] as $k=>$v){
				$resultImage = $this->M_android->getFeaturedImage($v['id']);
				$result['bestUniversities'][$k]['image'] = site_url().'assets/image/products/original/'.$resultImage['image'];
			}
		}
*/
		$this->load->view('v_header');
		$this->load->view('v_dashboard',$result);
		$this->load->view('v_footer');
	}

	public function filterDashboard()
	{
		$this->load->model('M_welcome');
		
		if(($this->session->userdata('user_name')==""))
  		{ 
			redirect('Welcome/login');
		}

		$filter = array();

        	$dateTo =  explode('/',$_POST['endDate']);
        	$filter['endDate'] = date('Y-m-d',mktime(0, 0, 0, $dateTo[1], $dateTo[0], $dateTo[2]));
        
        	$dateFrom =  explode('/',$_POST['startDate']);
        	$filter['startDate'] = date('Y-m-d',mktime(0, 0, 0, $dateFrom[1], $dateFrom[0], $dateFrom[2]));
        
		/*$filter['startDate'] = date('Y-m-d',strtotime($_POST['startDate']));
		$filter['endDate']= date('Y-m-d',strtotime($_POST['endDate']));*/
		
		$result['newUsers'] = $this->M_welcome->totalUniversities($filter);
		$result['orders'] = $this->M_welcome->totalOrders($filter);
		$result['bestUniversities'] = $this->M_welcome->bestUniversities($filter);
		//$result['bestProducts'] = $this->M_welcome->bestProducts($filter);
		$result['totalProfit'] = $this->M_welcome->totalProfit($filter);

		if(!empty($result['bestProducts'])){
			foreach($result['bestProducts'] as $k=>$v){
				$resultImage = $this->M_android->getFeaturedImage($v['id']);
				$result['bestProducts'][$k]['image'] = site_url().'assets/image/products/original/'.$resultImage['image'];
			}
		}
		
		echo json_encode($result);
	}
	
	public function login()
	{
		//echo "in";die;
		$this->load->view('v_login');
	}
	
	public function forgetPassword()
	{
		$this->load->view('v_forgetPassword');	
	}

	public function adminForgetPassword()
	{
		$this->load->view('v_adminForgetPassword');	
	}

	public function changePassword(){
		$data = $_POST;
		//print_r($data);die;
		$this->load->model('M_welcome');
		//$result = $this->M_welcome->userLogin($data);
		$result=$this->M_welcome->changePassword($data);
		//print_r($result);die();
		if($result != ''){
		// if ($result == false) {
                echo 'true';
            } else {
                echo 'false';
            }

	}

	public function thanku()
	{
		$this->load->view('v_thanku');	
	}

		public function forgotPassword()
	{
		//$inputJSON=json_decode(file_get_contents('php://input'));
		//$email = $inputJSON->username;
		$data1 = $_REQUEST;
		$data['id']=$data1['id'];
		$data['email']=$data1['email'];
		
		$result = $this->M_welcome->checkEmail($data);

		//print_r($result['id']);die;
      
		if(!$result){

			//$result['status'] = 'false';
			
			$result['msg'] = 'Email does not exist.';
			$msg= array('status'=>'false','msg'=>$result['msg']);
			$result='false';

		}else{
             
			//$to = $email;
			$id=base64_encode($result['id']);
			//$to = 'sachin.minhas@appsimity.com';
			$to = $data['email'];
			$subject = "Password Reset Request";			
			$body ="Click here ".site_url().'Welcome/forgetPassword/?token='.$id." to change your password";
			$header = "From: DirectParking <noreply@appsimity.com>";
			mail($to, $subject, $body, $header);
			$msg= array('status'=>'true','msg'=>'Forgot password link has been sent to your registered email address.');
			$result='true';
		}

		  if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }

		//$this->load->view('v_adminForgetPassword',$result);
		echo $result;
		//echo json_encode($msg);
	}
	
	/*public function forgetPasswordSendEmail()
	{
		$data = $_POST;
		$mobile = $data['mobile'];
		$this->load->model('M_welcome');
		$result = $this->M_welcome->forgetPasswordSendEmail($data);
		if($result != '')
		{
			//print_r($result);
			//die();
			$message = 'Hello,<br>Follow is the link to Set the new password. Follow link is valid for 24 hours only.<br>';
			$message .= site_url().'Welcome/setPassword/'.$mobile.'/'.$result['ch_key'].'/'.str_replace(' ','_',$result['ch_key_created_date']);
			
			$this->load->library('email');
			 $this->email->set_mailtype("html");
			$this->email->from('noreply@mrbachat.com');
			$this->email->to($result['email']);

			$this->email->subject('mr. bachat - Set your new password');
			$this->email->message($message);

			$this->email->send();

			
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}*/
	
	public function setPassword($mobile, $ch_key, $ch_key_created_date)
	{
		$data['mobile'] = $mobile;
		$data['ch_key'] = $ch_key;
		
		$this->load->model('M_welcome');
		
		$result['url_result'] = $this->M_welcome->setPassword($data);
		$this->load->view('v_setPassword',$result);			
	}
	
	public function resetPassword()
	{
		$this->load->model('M_welcome');
		
		if (!empty($_POST)) {
            $data = $_POST;	
            $result = $this->M_welcome->resetPassword($data);
            if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }
		
		//$result['url_result'] = $this->M_welcome->setPassword($data);
		//$this->load->view('v_setPassword',$result);	
	}
	
	public function userLogin()
	{
		$data = $_POST;
		$this->load->model('M_welcome');
		$result = $this->M_welcome->userLogin($data);
		if($result != '')
		{

			$this->session->set_userdata(array(
                            'user_name'     => $result['username'],
                            'name'     => $result['fname'],
                            'user_type'     => $result['user_type_id'],
                            'user_id'     => $result['id'],
							
                    ));
			//print_r($_SESSION);die;
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}
	public function userLogout()
	{
		/*$data = $_POST;
		$this->load->model('M_user');
		$result = $this->M_user->userLogin($data);*/
		$result = $this->session->unset_userdata('user_name');
		echo 'true';
		
	}
	
	public function notifications()
	{
		$this->load->model('M_welcome');
		$result['totalNotifications'] = $this->M_welcome->notifications();
		if(count($result['totalNotifications']) > 0)
		{
			//print_r($result);
			echo $result['totalNotifications'];
		}
		else
		{
			echo 'false';	
		}
	}
	
	public function notificationsList()
	{
		$this->load->model('M_welcome');
		$result['notificationsList'] = $this->M_welcome->notificationsList();
	}
	
	
	public function editProfile()
	{
	
		if (!empty($_POST)) {
            $data = $_POST;
            //print_r($data);die;
            $result = $this->M_welcome->editProfile($data);
            if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }

		$id = ($_SESSION['user_id']);
		$catResult['userData'] = $this->M_welcome->getProfileDetails($id);
		$catResult['pageHeading'] = 'Edit Profile';

		$this->load->view('v_header');
		$this->load->view('v_profileEdit',$catResult);
		$this->load->view('v_footer');	
	}

	public function getNotifications()
	{
		$this->load->model('M_welcome');
		$result['totalNotifications'] = $this->M_welcome->getNotifications();
		if(count($result['totalNotifications']) > 0)
		{

			$i = 0;
			foreach($result['totalNotifications'] as $totalNotifications)
			{

				$result['totalNotifications'][$i]['base64'] = base64_encode($totalNotifications['ride_id']);
				if($totalNotifications['noti_type'] == '1'){
					$result['totalNotifications'][$i]['order_id'] = $totalNotifications['related_id'];
				}

				if($totalNotifications['noti_type'] == '2'){
					$result['totalNotifications'][$i]['data'] = $this->M_user->getStudentDetails($totalNotifications['related_id']);
				//print_r($result['totalNotifications'][$i]['data']);die;
				}

				/*if($totalNotifications['noti_type'] == '3'){
					$result['totalNotifications'][$i]['data'] = $this->M_capital_query->getQueryDetails($totalNotifications['related_id']);
					$result['totalNotifications'][$i]['user_base64'] = base64_encode($result['totalNotifications'][$i]['data']['user_id']);
				}*/

				if($totalNotifications['noti_type'] == '3'){
					$result['totalNotifications'][$i]['data'] = $this->M_user->getStudentDetails($totalNotifications['related_id']);
					//print_r($result);die();
				}

				if($totalNotifications['noti_type'] == '4'){
					$result['totalNotifications'][$i]['data'] = $this->M_user->getStudentDetails($totalNotifications['related_id']);
				}

				if($totalNotifications['noti_type'] == '5'){
					$result['totalNotifications'][$i]['data'] = $this->M_user->getStudentDetails($totalNotifications['related_id']);
				}

				$result['totalNotifications'][$i]['related_base64'] = base64_encode($totalNotifications['related_id']);
				$i++;
			}
			/*echo "<pre>";
			print_r($result);die;*/
			echo json_encode($result['totalNotifications']);
		}
		else
		{
			echo 'false';	
		}
	}
	
	
}
