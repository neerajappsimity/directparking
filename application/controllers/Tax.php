<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax extends CI_Controller 
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

    	$this->load->model('M_tax');
    	$this->load->model('M_state');

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
		$config['base_url'] = base_url().'tax/index/' . $keywordDuplicate . '/';
		
		$count = $this->M_tax->countTaxList($keyword);
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
		
		$result["taxes"] = $this->M_tax->getTaxList($start,$limit,$keyword);		
		
		$result['pageHeading'] = 'Manage Taxation';
		$result['startPage'] = $start;
				
		$this->load->view('v_header');
		$this->load->view('tax/v_taxlist',$result);
		$this->load->view('v_footer');
	}


	public function viewTax($keyword = 'null')
	{
		
		$keyword = urldecode($keyword);
		$filter = array();
		$keywordDuplicate = $keyword;
	    if($keyword == 'null') {
            $keyword = '';
        }

       	$uri = http_build_query($_GET);
		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'tax/viewTax/' . $keywordDuplicate . '/';
		$count = $this->M_state->countStates($keyword);
		$config['total_rows'] = $count;
		$config["uri_segment"] = 4;
		$limit = 10;
		$start = $this->uri->segment(4, 0);
		$config['per_page'] = $limit;
		$config['first_url'] = base_url().'tax/viewTax/' . $keywordDuplicate . '/?'.$uri;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = '>';
		$config['prev_link'] = '<';
		$config['last_link'] = '>>';
		$config['first_link'] = '<<';
		$config['suffix'] = '?'.$uri;

		$this->pagination->initialize($config);
		$result['pagination'] =  $this->pagination->create_links();

		
		
		$result["states"] = $this->M_state->getStates($start,$limit,$keyword);
		$tid = base64_decode($_GET['tid']);

		$taxName = $this->M_tax->getTaxName($tid);

		foreach($result["states"] as $keyS=>$valS){
			$result["states"][$keyS]['taxData'] = $this->M_tax->getTaxDetails($tid,$valS['id']);
		}	
		
		//echo "<pre>";
		//print_r($result["states"]);die;	
		
		$result['pageHeading'] = 'Manage '.$taxName['tax_name'];
		$result['startPage'] = $start;
				
		$this->load->view('v_header');
		$this->load->view('tax/v_taxView',$result);
		$this->load->view('v_footer');
	}

	
	public function changeStatus()
	{
		$data = $_POST;

		$result = $this->M_tax->changeStatus($data);
		echo $result;
	}
	
	public function deleted()
	{
		$data = $_POST;
		$data['archive'] = 'Y';

		$result = $this->M_tax->deleted($data);
		echo $result;
	}
	
	public function add()
	{
	
		if (!empty($_POST)) {
            $data = $_POST;
           
            $result = $this->M_tax->add($data);
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
            $result = $this->M_tax->edit($data);
            if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }
		$cid = base64_decode($_GET['cid']);
		$catResult['stateData'] = $this->M_tax->getTaxDetails($cid);
		
		$catResult['pageHeading'] = 'Edit Taxation';

		$this->load->view('v_header');
		$this->load->view('tax/v_taxEdit',$catResult);
		$this->load->view('v_footer');	
	}


	public function editTaxDetails()
	{
	
		if (!empty($_POST)) {
            $data = $_POST;
            foreach($data['tax_id'] as $k=>$v){
            $dataTax['id'] = $data['tax_id'][$k];
            $dataTax['rate'] = $data['rate'][$k];

            $result = $this->M_tax->editTaxDetails($dataTax);
	            if ($result == false) {
	                echo 'false';
	            } else {
	                echo 'true';
	            }
        	}
            die;
            /* please don't delete above die */
        }
		$sid = base64_decode($_GET['sid']);
		$tid = base64_decode($_GET['tid']);
		$catResult['taxData'] = $this->M_tax->getTaxDetails($tid,$sid);
		$taxName = $this->M_tax->getTaxName($tid);
		//print_r($catResult['stateData']);die;
		$catResult['pageHeading'] = 'Edit Taxation '.$taxName['tax_name'].': '.$catResult['taxData'][0]['state'];

		$this->load->view('v_header');
		$this->load->view('tax/v_editTaxDetails',$catResult);
		$this->load->view('v_footer');	
	}

	/*public function addTemp()
	{
	
		//if (!empty($_POST)) 
		{
        
            $result["states"] = $this->M_state->getAllStates();

           	foreach($result["states"] as $key=>$val){
           		$data['state_id'] = $val['id'];
           		$data['commodity_id'] = 2;
           		$data['tax_type_id'] = 1;
           		$data['rate'] = 0;
            	$result = $this->M_tax->addTemp($data);
            }

            if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            
        }
		
		
		$result['pageHeading'] = 'Add Brand';
		$this->load->view('v_header');
		$this->load->view('brand/v_brandAdd',$result);
		$this->load->view('v_footer');	
	}*/
	
}
?>