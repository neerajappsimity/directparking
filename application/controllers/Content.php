<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends CI_Controller 
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
    	$this->load->model('M_content');
		$this->load->library('session');
    	$this->load->helper('url');
		if(($this->session->userdata('user_name')==""))
  		{ 
			redirect('Welcome/login');
		}
    }
	
	public function banners($keyword = 'null')
	{
		$keyword = urldecode($keyword);
		$filter = array();
		$keywordDuplicate = $keyword;
	    if($keyword == 'null') {
            $keyword = '';
        }
       

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'content/banner/' . $keywordDuplicate . '/';
		
		$count = $this->M_content->countBanners($keyword);
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
		
		$result["banners"] = $this->M_content->getBanners($start,$limit,$keyword);	
		
		$result['pageHeading'] = 'Manage Banners';
		$result['startPage'] = $start;
				
		$this->load->view('v_header');
		$this->load->view('content/v_bannerlist',$result);
		$this->load->view('v_footer');
	}

	
	public function changeBannerStatus()
	{
		$data = $_POST;

		$result = $this->M_content->changeBannerStatus($data);
		echo $result;
	}

	
	public function changeBannerOrder()
	{
		$data = $_POST;

		$result = $this->M_content->changeOrder($data);
		echo $result;
	}
	

	public function deletedBanner()
	{
		$data = $_POST;
		$data['archive'] = 'Y';

		$result = $this->M_content->deletedBanner($data);
		echo $result;
	}

	public function deleted()
	{
		$data = $_POST;
		$data['archive'] = 'Y';

		$result = $this->M_content->deleted($data);
		echo $result;
	}
	
	public function add()
	{
	
		if (!empty($_POST)) {
            $data = $_POST;
 			$data['code'] = strtoupper($data['code']);
            $result = $this->M_coupon->add($data);
            if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
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


	public function addBanners()
	{
		$length = count($_FILES['image']['name']);
        $files = $_FILES;
            if (!empty($_FILES['image']['name'][0])) {
            for($i=0;$i<$length;$i++){
				$imgNameWithoutSpaces = str_replace(" ", "_", $_FILES['image']['name'][$i]);
				$imageName = date('Ymdhis').'-'.$imgNameWithoutSpaces;
				$target_file = APPPATH . '../assets/image/banners/' . $imageName;
				$upload = move_uploaded_file($_FILES["image"]["tmp_name"][$i], $target_file);
				
				$dataImg[] = $imageName;
				if($upload)
					{
						/*$config['image_library'] = 'gd2';
						$config['source_image'] = APPPATH . '../assets/image/banners/'.$imageName;
						$config['new_image'] = APPPATH . '../assets/image/banners/'.$imageName;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width'] = 150;
						$config['height'] = 100;
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();*/

						$dataImage['image'] = $imageName;
						$resultImage = $this->M_content->addBannerImage($dataImage);
					}
				}
			}

			if (!$upload) {
                echo 'false';
            } else {
            	$limit = 20;
				$start = 0;
				$keyword = '';
                $productImages = $this->M_content->getBanners($start,$limit,$keyword);
                $productImages['start'] = $start;
                echo json_encode($productImages);
            }
	}

	
}
?>