<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shipping extends CI_Controller 
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

    	$this->load->model('M_state');
    	$this->load->model('M_shipping');

		$this->load->library('session');
    	$this->load->helper('url');
		if(($this->session->userdata('user_name')==""))
  		{ 
			redirect('Welcome/login');
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

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'shipping/index/' . $keywordDuplicate . '/';
		
		$count = $this->M_state->countStates($keyword);
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
		
		$result["states"] = $this->M_state->getStates($start,$limit,$keyword);		
		
		$result['pageHeading'] = 'Manage Shipping';
		$result['startPage'] = $start;
				
		$this->load->view('v_header');
		$this->load->view('shipping/v_shippinglist',$result);
		$this->load->view('v_footer');
	}

	
	public function changeStatus()
	{
		$data = $_POST;

		$result = $this->M_state->changeStatus($data);
		echo $result;
	}
	
	public function deleted()
	{
		$data = $_POST;
		$data['archive'] = 'Y';

		$result = $this->M_state->deleted($data);
		echo $result;
	}
	
	public function add()
	{
	
		if (!empty($_POST)) {
            $data = $_POST;
           
            $result = $this->M_state->add($data);
            if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }
		
		
		$result['pageHeading'] = 'Add Brand';
		$this->load->view('v_header');
		$this->load->view('brand/v_brandAdd',$result);
		$this->load->view('v_footer');	
	}
	
	public function edit()
	{
	
		if (!empty($_POST)) {
            $data = $_POST;
            print_r($data);
            $data['state_id'] = base64_decode($data['sid']);
            $resultDel = $this->M_shipping->deleteShippingPrice($data['state_id']);
            if(!empty($data['rangePrice'][0])){
            	
	        	foreach($data['rangePrice'] as $rpKey=>$rpVal){
	        		$dataPrice['state_id'] = $data['state_id'];
	        		$dataPrice['price'] = $rpVal;
	        		$dataPrice['range_from'] = $data['rangeFrom'][$rpKey];
	        		$dataPrice['range_to'] = $data['rangeTo'][$rpKey];
	        		if(!empty($dataPrice['price'])){
	        			$resultPrice = $this->M_shipping->addShippingPrice($dataPrice);
	        		}
	        	}
	        }

            if ($resultPrice == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }
		$sid = base64_decode($_GET['sid']);
		$catResult['shippingData'] = $this->M_shipping->getShippingDetails($sid);
		
		$catResult['pageHeading'] = 'Edit Shipping';

		$this->load->view('v_header');
		$this->load->view('shipping/v_shippingEdit',$catResult);
		$this->load->view('v_footer');	
	}
	
	/*public function addCategory()
	{
		 $this->load->model('M_category');
		$data = $_POST;
		print_r($data);
		echo $_FILES['category_image']['name'];
	}*/

	public function removeRange()
	{
		$data = $_POST;

		$result = $this->M_shipping->removeRange($data);
		echo $result;
	}


}
?>