<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataSheet extends CI_Controller 
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
       

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'DataSheet/index/' . $keywordDuplicate . '/';
		
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
		
		$result['pageHeading'] = 'Manage Data Sheets';
		$result['startPage'] = $start;
				
		$this->load->view('v_header');
		$this->load->view('data_sheet/v_brandlist',$result);
		$this->load->view('v_footer');
	}

	public function category($keyword = 'null')
	{
		$keyword = urldecode($keyword);
		$filter = array();
		$keywordDuplicate = $keyword;
	    if($keyword == 'null') {
            $keyword = '';
        }
        
        if(isset($_GET['id'])){
        	$filter['parentId'] = base64_decode($_GET['id']);
        	$catId = base64_decode($_GET['id']);
        	
        }

        if(isset($_GET['bid'])){
        	$filter['brandId'] = base64_decode($_GET['bid']);
        	$brandId = base64_decode($_GET['bid']);
        }

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'DataSheet/category/' . $keywordDuplicate . '/';
		
		$count = $this->M_category->countCategories($keyword,$filter);
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
		
		$result["categories"] = $this->M_category->getCategories($start,$limit,$keyword,$filter);

			
		$brandData = $this->M_brand->getBrandDetails($brandId);

		$result['pageHeading'] = $brandData['name'].' Categories';
		if(isset($_GET['id'])){
			$catData = $this->M_category->getMainCatId($catId);
			$result['pageHeading1'] = $brandData['name'].' Categories';
        	$result['pageHeading'] = $catData['name'].' Category';
        }

		$result['startPage'] = $start;
		
		$this->load->view('v_header');
		$this->load->view('data_sheet/v_categorylist',$result);
		$this->load->view('v_footer');
	}


	
	public function changeStatus()
	{
		$data = $_POST;
		$this->load->model('M_category');
		$result = $this->M_category->changeStatus($data);
		echo $result;
	}
	
	public function deleted()
	{
		$data = $_POST;
		$data['archive'] = 'Y';
		$this->load->model('M_category');
		$result = $this->M_category->deleted($data);
		echo $result;
	}
	
	public function add()
	{
		$this->load->model('M_category');
		if (!empty($_POST)) {
            $data = $_POST;
            if (!empty($_FILES['image']['name'])) {
				$imageName = rand() . date('Ymdhis').'-'.$_FILES['image']['name'];
				$target_file = APPPATH . '../assets/image/categories/' . $imageName;
				$upload = move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
				$data['image'] = $imageName;
				unset($_FILES);
			}
           
            $result = $this->M_category->add($data);
            if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }
		
		$data['category_id'] = base64_decode($_REQUEST['id']);
        $data['brand_id'] = base64_decode($_REQUEST['bid']);

        $result['dataSheetImages'] = $this->M_brand->getDataSheetImages($data);


        $catId = base64_decode($_GET['id']);
        $brandId = base64_decode($_GET['bid']);

		$brandData = $this->M_brand->getBrandDetails($brandId);
		$result['pageHeading'] = $brandData['name'].' Categories';
		if(isset($_GET['id'])){
			$catData = $this->M_category->getMainCatId($catId);
			$result['pageHeading1'] = $brandData['name'].' Categories';
        	$result['pageHeading'] = $catData['name'].' Data Sheets';
        }

		$this->load->view('v_header');
		$this->load->view('data_sheet/v_datasheetAdd',$result);
		$this->load->view('v_footer');	
	}


	public function addImages()
	{
		$categoryId = base64_decode($_REQUEST['id']);
		$brandId = base64_decode($_REQUEST['bid']);

		$length = count($_FILES['image']['name']);
        $files = $_FILES;
            if (!empty($_FILES['image']['name'][0])) {
            for($i=0;$i<$length;$i++){
				$imgNameWithoutSpaces = str_replace(" ", "_", $_FILES['image']['name'][$i]);
				$imageName = date('Ymdhis').'-'.$imgNameWithoutSpaces;
				$target_file = APPPATH . '../assets/image/data_sheet/' . $imageName;
				$upload = move_uploaded_file($_FILES["image"]["tmp_name"][$i], $target_file);
				
				$dataImg[] = $imageName;
				if($upload)
					{
						$config['image_library'] = 'gd2';
						$config['source_image'] = APPPATH . '../assets/image/data_sheet/'.$imageName;
						$config['new_image'] = APPPATH . '../assets/image/data_sheet/'.$imageName;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width'] = 150;
						$config['height'] = 100;
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						$dataImage['image'] = $imageName;
						$dataImage['category_id'] = $categoryId;
						$dataImage['brand_id'] = $brandId;
						$resultImage = $this->M_brand->addDataSheetImage($dataImage);
					}
				}
			}

			if (!$upload) {
                echo 'false';
            } else {
            	$data['category_id'] = $categoryId;
            	$data['brand_id'] = $brandId;

                $productImages = $this->M_brand->getDataSheetImages($data);
                echo json_encode($productImages);
            }
	}
	
	public function edit()
	{
		$this->load->model('M_category');
		
		if (!empty($_POST)) {
            $data = $_POST;
			
			$catImageResult['category'] = $this->M_category->getCategory($data['id']);
            if (!empty($_FILES['image']['name'])) {
				$imageName = rand() . date('Ymdhis').'-'.$_FILES['image']['name'];
				//$image[] = $imageName;
				$target_file = APPPATH . '../assets/image/categories/' . $imageName;
				$upload = move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
				$data['image'] = $imageName;
				unlink(APPPATH . '../assets/image/categories/' . $catImageResult['category']['image']);
				unset($_FILES);
			}
			
			
            $result = $this->M_category->edit($data);
            if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }
		$cid = base64_decode($_GET['cid']);
		$catResult['categoryData'] = $this->M_category->getCategory($cid);
		$catResult["categories"] = $this->M_category->getMainCategories();
		$catResult['pageHeading'] = 'Edit Category';

		$this->load->view('v_header');
		$this->load->view('category/v_categoryEdit',$catResult);
		$this->load->view('v_footer');	
	}


	public function getSubCategories()
	{
		$this->load->model('M_category');
		$data = $_POST;
		$catResult['category'] = $this->M_category->getSubCategories($data['parent_id']);
		echo json_encode($catResult['category']);
	}

	public function getProductsOnSub()
	{
		$this->load->model('M_category');
		$data = $_POST;
		$catResult['products'] = $this->M_category->getProductsOnSub($data['catId']);
		echo json_encode($catResult['products']);
	}

	public function removeImage()
	{
		$data = $_POST;

		$result = $this->M_brand->removeDataSheetImage($data);
		echo $result;
	}
}
?>