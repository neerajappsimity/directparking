<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends CI_Controller 
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
       

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'brand/index/' . $keywordDuplicate . '/';
		
		$count = $this->M_brand->countBrands($keyword);
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
		
		$result["brands"] = $this->M_brand->getBrands($start,$limit,$keyword);	
		$result["allBrands"] = $this->M_brand->getAllBrands();	
		
		$result['pageHeading'] = 'Manage Brands';
		$result['startPage'] = $start;
				
		$this->load->view('v_header');
		$this->load->view('brand/v_brandlist',$result);
		$this->load->view('v_footer');
	}

	
	public function changeStatus()
	{
		$data = $_POST;

		$result = $this->M_brand->changeStatus($data);
		echo $result;
	}

	
	public function changeOrder()
	{
		$data = $_POST;

		$result = $this->M_brand->changeOrder($data);
		echo $result;
	}
	
	public function deleted()
	{
		$data = $_POST;
		$data['archive'] = 'Y';

		$result = $this->M_brand->deleted($data);
		echo $result;
	}
	
	public function add()
	{
	
		if (!empty($_POST)) {
            $data = $_POST;

            if(!empty($_FILES['image']['name'])){
            	$imgNameWithoutSpaces = str_replace(" ", "_", $_FILES['image']['name']);
				$imageName = date('Ymdhis').'-'.$imgNameWithoutSpaces;
				$target_file = APPPATH . '../assets/image/brand/' . $imageName;
				$upload = move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

				if($upload)
				{
						$config['image_library'] = 'gd2';
						$config['source_image'] = APPPATH . '../assets/image/brand/'.$imageName;
						$config['new_image'] = APPPATH . '../assets/image/brand/'.$imageName;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width'] = 150;
						$config['height'] = 100;
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						$data['image'] = $imageName;
				}
			}
           
            $result = $this->M_brand->add($data);
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

            if(!empty($_FILES['image']['name'])){
            	$imgNameWithoutSpaces = str_replace(" ", "_", $_FILES['image']['name']);
				$imageName = date('Ymdhis').'-'.$imgNameWithoutSpaces;
				$target_file = APPPATH . '../assets/image/brand/' . $imageName;
				$upload = move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

				if($upload)
				{
						$brandData = $this->M_brand->getBrandDetails($data['id']);
						$imageNameTemp = explode('.',$brandData['image']);
						$imageUploaded = $imageNameTemp['0'].'_thumb.'.$imageNameTemp['1'];
						unlink(APPPATH.'../assets/image/brand/'.$brandData['image']);
						unlink(APPPATH.'../assets/image/brand/'.$imageUploaded);

						$config['image_library'] = 'gd2';
						$config['source_image'] = APPPATH . '../assets/image/brand/'.$imageName;
						$config['new_image'] = APPPATH . '../assets/image/brand/'.$imageName;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width'] = 150;
						$config['height'] = 100;
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						$data['image'] = $imageName;
				}
			}


            $result = $this->M_brand->edit($data);
            if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }
		$cid = base64_decode($_GET['cid']);
		$catResult['brandData'] = $this->M_brand->getBrandDetails($cid);
		
		$catResult['pageHeading'] = 'Edit Brand';

		$this->load->view('v_header');
		$this->load->view('brand/v_brandEdit',$catResult);
		$this->load->view('v_footer');	
	}

	public function removeImage()
	{
		$data = $_POST;
		$brandData = $this->M_brand->getBrandDetails($data['id']);
		$imageNameTemp = explode('.',$brandData['image']);
		$imageName = $imageNameTemp['0'].'_thumb.'.$imageNameTemp['1'];
		unlink(APPPATH.'../assets/image/brand/'.$brandData['image']);
		unlink(APPPATH.'../assets/image/brand/'.$imageName);

		$result = $this->M_brand->removeImage($data);
		echo $result;
	}
	
	/*public function addCategory()
	{
		 $this->load->model('M_category');
		$data = $_POST;
		print_r($data);
		echo $_FILES['category_image']['name'];
	}*/
}
?>