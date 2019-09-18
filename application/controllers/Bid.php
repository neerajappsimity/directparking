<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bid extends CI_Controller 
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

    	$this->load->model('M_bid');
    	$this->load->model('M_product');
    	$this->load->model('M_user');

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
		$config['base_url'] = base_url().'query/index/' . $keywordDuplicate . '/';

		$uri = http_build_query($_GET);
		
		$count = $this->M_bid->countBids($keyword,$filter);
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
		$config['first_url'] = base_url().'bid/index/' . $keywordDuplicate . '/?'.$uri;


		$config['suffix'] = '?'.$uri;

		$this->pagination->initialize($config);
		$result['pagination'] =  $this->pagination->create_links();
		
		$result["queries"] = $this->M_bid->getBids($start,$limit,$keyword,$filter);
		//$result["mainCategories"] = $this->M_category->getMainCategories();

		$result['pageHeading'] = 'Manage Bids';
		$result['startPage'] = $start;
		if(isset($_REQUEST['id'])){
			$this->M_bid->updateNotification(base64_decode($_REQUEST['id']));
		}
				
		$this->load->view('v_header');
		$this->load->view('bid/v_bidlist',$result);
		$this->load->view('v_footer');
	}
	
	public function deleted()
	{
		$data = $_POST;
		$data['archive'] = 'Y';
		$result = $this->M_query->deleted($data);
		echo $result;
	}


	public function view()
	{
	
		$id = base64_decode($_GET['id']);
		$catResult['queryData'] = $this->M_query->getQueryDetails($id);
		
		$catResult['pageHeading'] = 'View Query';

		$this->load->view('v_header');
		$this->load->view('query/v_queryView',$catResult);
		$this->load->view('v_footer');	
	}

}
?>