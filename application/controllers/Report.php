<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller 
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
    	$this->load->model('M_report');
		$this->load->model('M_order');
		$this->load->model('M_user');
    	$this->load->model('M_product');
    	$this->load->model('M_category');
    	$this->load->model('M_brand');
    	$this->load->model('M_student');
		$this->load->library('session');
    	$this->load->helper('url');
		if(($this->session->userdata('user_name')==""))
  		{ 
			redirect('Welcome/login');
		}
    }
	
	public function orders($keyword = 'null')
	{
		$keyword = urldecode($keyword);
		$filter = array();
		$keywordDuplicate = $keyword;
	    if($keyword == 'null') {
        	$keyword = '';
        }
       
        if(isset($_GET['order_date_to'])){
        	$dateTo =  explode('/',$_GET['order_date_to']);
        	@$filter['order_date_to'] = date('Y-m-d',mktime(0, 0, 0, $dateTo[1], $dateTo[0], $dateTo[2]));
        }
        if(isset($_GET['order_date_from'])){
        	$dateFrom =  explode('/',$_GET['order_date_from']);
        	@$filter['order_date_from'] = date('Y-m-d',mktime(0, 0, 0, $dateFrom[1], $dateFrom[0], $dateFrom[2]));
        }
        if(isset($_GET['order_status'])){
        	$filter['order_status'] = $_GET['order_status'];
        }
       

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'order/index/' . $keywordDuplicate . '/';

		$uri = http_build_query($_GET);
		
		$count = $this->M_order->countOrders($keyword,$filter);
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
		//$config['page_query_string'] = TRUE;
		//$config['enable_query_strings'] = TRUE;

		$config['suffix'] = '?'.$uri;

		$this->pagination->initialize($config);
		$result['pagination'] =  $this->pagination->create_links();
		
		$result["orders"] = $this->M_order->getOrders($start,$limit,$keyword,$filter);
		$result["orderStatus"] = $this->M_order->getOrderStatus();
		
		$result['pageHeading'] = 'Reports: Orders';
		$result['startPage'] = $start;
				
		$this->load->view('v_header');
		$this->load->view('report/v_order',$result);
		$this->load->view('v_footer');
	}



	public function exportData()
		{
			$students = $this->M_student->getStudents($start,$limit,$keyword,$filter=$_GET);
			
			echo "<pre>";
			print_r($students);
			echo "</pre>";
			foreach ($students as $key => $value) {
				
				$tempUserData['Student Name']=$value['fname'].' '.$value['lname'];
				$tempUserData['University Name']=$value['university_name'];
				$tempUserData['Email']=$value['email'];
				$tempUserData['Mobile']=$value['mobile'];
				$tempUserData['Verify Status']=($value['is_verified']=='Y' ? 'Verified' : 'Pending');
				$userData[]=$tempUserData;
			}

			 $this->load->helper('exportData');
			 $fileName = "Student_export_data" . date('Ymd') . ".xls";
    
    		// headers for download
		    header("Content-Disposition: attachment; filename=\"$fileName\"");
		    header("Content-Type: application/vnd.ms-excel");
		    
		    $flag = false;
		    foreach($userData as $row=>$value) {
		        if(!$flag) {
		            // display column names as first row
		            echo implode("\t", array_keys($value)) . "\n";
		            $flag = true;
		        }
		        // filter data
		        array_walk($value, 'filterData');
		        echo implode("\t", array_values($value)) . "\n";

		    }

			exit();
			redirect('student/index');
			

			die;
		}

	public function users($keyword = 'null')
	{
		$keyword = urldecode($keyword);
		$filter = array();
		$keywordDuplicate = $keyword;
	    if($keyword == 'null') {
            $keyword = '';
        }
       

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'report/users/' . $keywordDuplicate . '/';

		$uri = http_build_query($_GET);

		if(isset($_GET['date_to']) && !empty($_GET['date_to'])){
        	$dateTo =  explode('/',$_GET['date_to']);
        	$filter['date_to'] = date('Y-m-d',mktime(0, 0, 0, $dateTo[1], $dateTo[0], $dateTo[2]));
        }
        if(isset($_GET['date_from']) && !empty($_GET['date_from'])){
        	$dateFrom =  explode('/',$_GET['date_from']);
        	$filter['date_from'] = date('Y-m-d',mktime(0, 0, 0, $dateFrom[1], $dateFrom[0], $dateFrom[2]));
        }
        if(isset($_GET['status'])){
        	$filter['status'] = $_GET['status'];
        }
		

		$count = $this->M_user->countUsers($keyword,$filter);
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
		$config['suffix'] = '?'.$uri;


		$this->pagination->initialize($config);
		$result['pagination'] =  $this->pagination->create_links();
		
		$result["users"] = $this->M_student->getStudents($start,$limit,$keyword,$filter);		
		
		$result['pageHeading'] = 'Student Reports';
		$result['startPage'] = $start;
		$result['pageFunction'] = 'index';
				
		$this->load->view('v_header');
		$this->load->view('report/v_user',$result);
		$this->load->view('v_footer');
	}

	
	public function changeStatus()
	{
		$data = $_POST;

		$result = $this->M_order->changeStatus($data);
		echo $result;
	}
	
	public function deleted()
	{
		$data = $_POST;
		$data['archive'] = 'Y';

		$result = $this->M_order->deleted($data);
		echo $result;
	}
	
	public function add()
	{
	
		if (!empty($_POST)) {
            $data = $_POST;

            $dataProduct['name'] = $data['name'];
            $dataProduct['description'] = $data['description'];
            $dataProduct['short_description'] = $data['short_description'];
            $dataProduct['brand_id'] = $data['brand_id'];
            $dataProduct['care_instructions'] = $data['care_instructions'];
            $dataProduct['sku'] = $data['sku'];
            $dataProduct['power_rating_hp'] = $data['power_rating_hp'];
            $dataProduct['power_rating_kw'] = $data['power_rating_kw'];
            $dataProduct['flow_rate_lpm'] = $data['flow_rate_lpm'];
            $dataProduct['pressure'] = $data['pressure'];
            $dataProduct['head_feet'] = $data['head_feet'];
            $dataProduct['outlet_size'] = $data['outlet_size'];
            $dataProduct['solid_handling_id'] = $data['solid_handling_id'];
            $dataProduct['bathroom_id'] = $data['bathroom_id'];
            $dataProduct['phase_id'] = $data['phase_id'];
            $dataProduct['bore_diameter'] = $data['bore_diameter'];
            $dataProduct['quantity'] = $data['quantity'];
            $dataProduct['stock_available'] = $data['stock_available'];
            $dataProduct['mrp'] = $data['mrp'];
            $dataProduct['weight'] = $data['weight'];
            $dataProduct['warranty'] = $data['warranty'];

            $result = $this->M_product->add($dataProduct);

            foreach($data['categories'] as $v){
            	$dataCategory['category_id'] = $v;
            	$dataCategory['product_id'] = $result['insert_id'];
            	$resultCat = $this->M_product->addProductCategory($dataCategory);
        	}

        	$dataPrice['price'] = $data['price'];
        	$dataPrice['product_id'] = $result['insert_id'];
        	$resultCat = $this->M_product->addProductPrice($dataPrice);

        	$length = count($_FILES['image']['name']);
            $files = $_FILES;
            if (!empty($_FILES['image']['name'][0])) {
            for($i=0;$i<$length;$i++){
				$imgNameWithoutSpaces = str_replace(" ", "_", $_FILES['image']['name'][$i]);
				$imageName = date('Ymdhis').'-'.$imgNameWithoutSpaces;
				$target_file = APPPATH . '../assets/image/products/original/' . $imageName;
				$upload = move_uploaded_file($_FILES["image"]["tmp_name"][$i], $target_file);
				
				$dataImg[] = $imageName;
				if($upload)
					{
						$config['image_library'] = 'gd2';
						$config['source_image'] = APPPATH . '../assets/image/products/original/'.$imageName;
						$config['new_image'] = APPPATH . '../assets/image/products/thumbnail/'.$imageName;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width'] = 150;
						$config['height'] = 100;
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						$dataImage['image'] = $imageName;
						$dataImage['product_id'] = $result['insert_id'];
						if($i == 0){
							$dataImage['is_featured'] = 'Y';
						}
						$resultImage = $this->M_product->addProductImage($dataImage);
					}
				}
			}
			
			if(isset($data['featured'])){
        	$imageFeatured = $this->M_product->updateFeaturedImage($resultImage['insert_id'],$result['insert_id']);
        	}


            if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }
		
		
		$result['pageHeading'] = 'Add Product';


		$result['mainCategories'] = $this->M_category->getMainCategories();
		foreach($result['mainCategories'] as $k=>$v){
			$result['mainCategories'][$k]['subCategories'] = $this->M_category->getSubCategories($v['id']);
		}
		$result['brands'] = $this->M_brand->getAllBrands();
		$result['phases'] = $this->M_product->getPhases();
		$result['bathrooms'] = $this->M_product->getBathrooms();
		$result['solids'] = $this->M_product->getSolids();

		/*echo "<pre>";
		print_r($result);die;*/
		$this->load->view('v_header');
		$this->load->view('product/v_productAdd',$result);
		$this->load->view('v_footer');	
	}
	
	/*public function addCategory()
	{
		 $this->load->model('M_category');
		$data = $_POST;
		print_r($data);
		echo $_FILES['category_image']['name'];
	}*/

	public function view()
	{
		if (!empty($_POST)) {
            $data = $_POST;
            $dataItem['id'] = base64_decode($data['id']);
            $dataItem['status_id'] = $data['status'];
            $dataItem['updated_date'] = date('Y-m-d g:i:s');

            if($data['status'] == 3){
            	$dataItem['completed_date'] = date('Y-m-d g:i:s');
            }

            $result = $this->M_order->edit($dataItem);
            die;
        }
	
		$oid = base64_decode($_GET['oid']);
		$result['pageHeading'] = 'View Order';

		$result['order'] = $this->M_order->getOrderDetails($oid);
		$result['orderItems'] = $this->M_order->getOrderItemDetails($oid);
		$result["orderStatus"] = $this->M_order->getOrderStatus();
		/*$result["paymentMethods"] = $this->M_order->getPaymentMethods();*/

		$this->load->view('v_header');
		$this->load->view('order/v_orderView',$result);
		$this->load->view('v_footer');	
	}

	public function removeImage()
	{
		$data = $_POST;

		$result = $this->M_order->removeImage($data);
		echo $result;
	}

	public function removeRange()
	{
		$data = $_POST;

		$result = $this->M_order->removeRange($data);
		echo $result;
	}

}
?>