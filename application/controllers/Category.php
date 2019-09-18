<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller 
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
        
        if(isset($_GET['id'])){
        	$filter['parentId'] = base64_decode($_GET['id']);
        }

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'category/index/' . $keywordDuplicate . '/';
		
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
		$result['pageHeading'] = 'Manage Location';
		$result['startPage'] = $start;
		
		$this->load->view('v_header');
		$this->load->view('category/v_categorylist',$result);
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
		
		$result["categories"] = $this->M_category->getMainCategories();
		$result['pageHeading'] = 'Add Category';
		$this->load->view('v_header');
		$this->load->view('category/v_categoryAdd',$result);
		$this->load->view('v_footer');	
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
	
	/*public function addCategory()
	{
		 $this->load->model('M_category');
		$data = $_POST;
		print_r($data);
		echo $_FILES['category_image']['name'];
	}*/
}
?>