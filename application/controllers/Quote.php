<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quote extends CI_Controller 
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

    	$this->load->model('M_quote');
    	$this->load->model('M_category');
    	$this->load->model('M_brand');

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
       
        if(isset($_GET['category'])){
        	$filter['category'] = $_GET['category'];
        }
        if(isset($_GET['subcategory'])){
        	$filter['subcategory'] = $_GET['subcategory'];
        }
        if(isset($_GET['product'])){
        	$filter['product'] = $_GET['product'];
        }

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'quote/index/' . $keywordDuplicate . '/';

		$uri = http_build_query($_GET);
		
		$count = $this->M_quote->countQuotes($keyword,$filter);
		$config['total_rows'] = $count;
		$config["uri_segment"] = 4;
		$limit = 10;
		$start = $this->uri->segment(4, 0);
		$config['per_page'] = $limit;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = '>';
		$config['prev_link'] = '<';
		$config['last_link'] = '>>';
		$config['first_link'] = '<<';
		$config['first_url'] = base_url().'quote/index/' . $keywordDuplicate . '/?'.$uri;
		//$config['page_query_string'] = TRUE;
		//$config['enable_query_strings'] = TRUE;

		$config['suffix'] = '?'.$uri;

		$this->pagination->initialize($config);
		$result['pagination'] =  $this->pagination->create_links();
		
		$result["quotes"] = $this->M_quote->getQuotes($start,$limit,$keyword,$filter);
		$result["mainCategories"] = $this->M_category->getMainCategories();

		$result['pageHeading'] = 'Manage Quotes';
		$result['startPage'] = $start;
				
		$this->load->view('v_header');
		$this->load->view('quote/v_quotelist',$result);
		$this->load->view('v_footer');
	}

	
	public function changeStatus()
	{
		$data = $_POST;

		$result = $this->M_quote->changeStatus($data);
		echo $result;
	}
	
	public function deleted()
	{
		$data = $_POST;
		$data['archive'] = 'Y';
		$result = $this->M_quote->deleted($data);
		echo $result;
	}


}
?>