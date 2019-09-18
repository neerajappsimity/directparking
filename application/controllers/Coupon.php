<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends CI_Controller 
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

	  	parent::__construct();
		$this->load->database();
		
    	$this->load->model('M_coupon');
    	$this->load->model('M_category');
    	
		$this->load->library('session');
		$this->load->model('M_brand');
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
		$config['base_url'] = base_url().'coupon/index/' . $keywordDuplicate . '/';
		
		$count = $this->M_coupon->countCoupons($keyword);
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
		
		$result["coupons"] = $this->M_coupon->getCoupons($start,$limit,$keyword);	
		
		$result['pageHeading'] = 'Manage Coupons';
		$result['startPage'] = $start;
				
		$this->load->view('v_header');
		$this->load->view('coupon/v_couponlist',$result);
		$this->load->view('v_footer');
	}

	
	public function changeStatus()
	{
		$data = $_POST;

		$result = $this->M_coupon->changeStatus($data);
		echo $result;
	}

	
	public function changeOrder()
	{
		$data = $_POST;

		$result = $this->M_coupon->changeOrder($data);
		echo $result;
	}
	
	public function deleted()
	{
		$data = $_POST;
		$data['archive'] = 'Y';

		$result = $this->M_coupon->deleted($data);
		echo $result;
	}
	
	public function add()
	{
	
		if (!empty($_POST)) {
            $data = $_POST;
 			$data['code'] = strtoupper($data['code']);

 			if(!empty($data['product_id'])){
 				$data['type_id'] = $data['product_id'];
 				$data['type'] = 'P';
 			}else if(!empty($data['sub_id'])){
 				$data['type_id'] = $data['sub_id'];
 				$data['type'] = 'C';
 			}else if(!empty($data['category_id'])){
 				$data['type_id'] = $data['category_id'];
 				$data['type'] = 'C';
 			}else if(!empty($data['brand'])){
 				$data['type_id'] = $data['brand_id'];
 				$data['type'] = 'B';
 			}

 			unset($data['brand_id']);
 			unset($data['category_id']);
 			unset($data['sub_id']);
 			unset($data['product_id']);

            $result = $this->M_coupon->add($data);
            if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }
		
		$result['brands'] = $this->M_brand->getAllBrands();
		$result['mainCategories'] = $this->M_category->getMainCategories();
		foreach($result['mainCategories'] as $k=>$v){
			$result['mainCategories'][$k]['subCategories'] = $this->M_category->getSubCategories($v['id']);
		}

		$result['pageHeading'] = 'Add Coupon';
		$this->load->view('v_header');
		$this->load->view('coupon/v_couponAdd',$result);
		$this->load->view('v_footer');	
	}
	
	public function edit()
	{
	
		if (!empty($_POST)) {
            $data = $_POST;

            $result = $this->M_coupon->edit($data);
            if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }
		$cid = base64_decode($_GET['cid']);
		$catResult['couponData'] = $this->M_coupon->getCouponDetails($cid);
		
		$catResult['pageHeading'] = 'Edit Coupon';

		$this->load->view('v_header');
		$this->load->view('coupon/v_couponEdit',$catResult);
		$this->load->view('v_footer');	
	}

	
}
?>