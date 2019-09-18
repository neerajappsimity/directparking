<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller 
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

    	$this->load->model('M_product');
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

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'product/index/' . $keywordDuplicate . '/';

		$uri = http_build_query($_GET);
		
		$count = $this->M_product->countProducts($keyword,$filter);
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
		$config['first_url'] = base_url().'product/index/' . $keywordDuplicate . '/?'.$uri;
		//$config['page_query_string'] = TRUE;
		//$config['enable_query_strings'] = TRUE;

		$config['suffix'] = '?'.$uri;

		$this->pagination->initialize($config);
		$result['pagination'] =  $this->pagination->create_links();
		
		$result["products"] = $this->M_product->getProducts($start,$limit,$keyword,$filter);
		if(!empty($result["products"])){
			foreach($result["products"] as $k=>$v){
				$result["products"][$k]['image'] = $this->M_product->getProductFeaturedImage($v['id']);
			}
		}
		
		$result["mainCategories"] = $this->M_category->getMainCategories();	
		$result['pageHeading'] = 'Manage Products';
		$result['startPage'] = $start;
				
		$this->load->view('v_header');
		$this->load->view('product/v_productlist',$result);
		$this->load->view('v_footer');
	}

	
	public function changeStatus()
	{
		$data = $_POST;

		$result = $this->M_product->changeStatus($data);
		echo $result;
	}
	
	public function deleted()
	{
		$data = $_POST;
		$data['archive'] = 'Y';
		$result = $this->M_product->deleted($data);
		echo $result;
	}


	public function addBore()
	{
		$data['name'] = $_POST['nameBore'];
		$result = $this->M_product->addBore($data);
		echo json_encode($result);
	}

	public function addSolid()
	{
		$data['name'] = $_POST['nameSolid'];
		$result = $this->M_product->addSolid($data);
		echo json_encode($result);
	}

	public function addBath()
	{
		$data['name'] = $_POST['nameBath'];
		$result = $this->M_product->addBath($data);
		echo json_encode($result);
	}

	public function addTank()
	{
		$data['name'] = $_POST['nameTank'];
		$result = $this->M_product->addTank($data);
		echo json_encode($result);
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
            $dataProduct['hsn_sac'] = $data['hsn_sac'];
            $dataProduct['power_rating_hp'] = $data['power_rating_hp'];
            $dataProduct['power_rating_kw'] = $data['power_rating_kw'];
            //$dataProduct['flow_rate_lpm'] = $data['flow_rate_lpm'];
            $dataProduct['pressure'] = $data['pressure'];
            //$dataProduct['head_feet'] = $data['head_feet'];
            $dataProduct['outlet_size'] = $data['outlet_size'];
            $dataProduct['solid_handling_id'] = $data['solid_handling_id'];
            $dataProduct['bathroom_id'] = $data['bathroom_id'];
            $dataProduct['phase_id'] = $data['phase_id'];
            //$dataProduct['bore_diameter'] = $data['bore_diameter'];
            $dataProduct['bore_diameter_id'] = $data['bore_diameter_id'];
            $dataProduct['quantity'] = $data['quantity'];
            $dataProduct['stock_available'] = $data['stock_available'];
            $dataProduct['mrp'] = $data['mrp'];
            $dataProduct['weight'] = $data['weight'];
            $dataProduct['warranty'] = $data['warranty'];
            $dataProduct['commodity_id'] = $data['commodity_id'];
            $dataProduct['is_best'] = $data['is_best'];

            $dataProduct['inlet_size'] = $data['inlet_size'];
            $dataProduct['stages'] = $data['stages'];
            $dataProduct['pump_type_id'] = $data['pump_type_id'];
            $dataProduct['tank_type_id'] = $data['tank_type_id'];
            $dataProduct['warranty_service_type'] = $data['warranty_service_type'];

            if(!empty($data['fluid_type'])){
            	$dataProduct['fluid_type'] = implode(',',$data['fluid_type']);
        	}
        	if(!empty($data['applications'])){
            	$dataProduct['applications'] = implode(',',$data['applications']);
            }
            //$dataProduct['material_construction'] = $data['material_construction'];
            if(!empty($data['source_water'])){
            	$dataProduct['source_water'] = implode(',',$data['source_water']);
            }

            $dataProduct['flow_max'] = $data['flow_max'];
            $dataProduct['flow_min'] = $data['flow_min'];
            $dataProduct['flow_unit'] = $data['flow_unit'];
            $dataProduct['head_max'] = $data['head_max'];
            $dataProduct['head_min'] = $data['head_min'];
            $dataProduct['tank_capacity'] = $data['tank_capacity'];
            $dataProduct['rpm'] = $data['rpm'];
            

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

			$lengthGr = count($_FILES['graph']['name']);
            $files = $_FILES;
            unset($dataImage['is_featured']);
			if (!empty($_FILES['graph']['name'][0])) {
            for($i=0;$i<$lengthGr;$i++){
				$imgNameWithoutSpaces = str_replace(" ", "_", $_FILES['graph']['name'][$i]);
				$imageName = date('Ymdhis').'-'.$imgNameWithoutSpaces;
				$target_file = APPPATH . '../assets/image/graphs/original/' . $imageName;
				$upload = move_uploaded_file($_FILES["graph"]["tmp_name"][$i], $target_file);
				
				$dataImg[] = $imageName;
				if($upload)
					{
						$config['image_library'] = 'gd2';
						$config['source_image'] = APPPATH . '../assets/image/graphs/original/'.$imageName;
						$config['new_image'] = APPPATH . '../assets/image/graphs/thumbnail/'.$imageName;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width'] = 150;
						$config['height'] = 100;
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						$dataImage['image'] = $imageName;
						$dataImage['product_id'] = $result['insert_id'];
						
						$resultImage = $this->M_product->addGraphImage($dataImage);
					}
				}
			}





			
			if(isset($data['featured'])){
        	$imageFeatured = $this->M_product->updateFeaturedImage($resultImage['insert_id'],$result['insert_id']);
        	}


        	if (!empty($_POST['content'])) {
        		foreach($_POST['content'] as $v){
        			$dataContent['content'] = $v;
					$dataContent['product_id'] = $result['insert_id'];
        			$this->M_product->addProductContent($dataContent);
        		}
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
		$result['commodities'] = $this->M_product->getCommodities();
		$result['boreDiameters'] = $this->M_product->getBoreDiameters();
		$result['pumpTypes'] = $this->M_product->getPumpTypes();
		$result['tankTypes'] = $this->M_product->getTankTypes();

		/*echo "<pre>";
		print_r($result);die;*/
		$this->load->view('v_header');
		$this->load->view('product/v_productAdd',$result);
		$this->load->view('v_footer');	
	}
	
	public function edit()
	{
	
		if (!empty($_POST)) {
            $data = $_POST;

            $dataProduct['id'] = base64_decode($data['pid']);
            $dataProduct['name'] = $data['name'];
            $dataProduct['description'] = $data['description'];
            $dataProduct['short_description'] = $data['short_description'];
            $dataProduct['brand_id'] = $data['brand_id'];
            $dataProduct['care_instructions'] = $data['care_instructions'];
            $dataProduct['sku'] = $data['sku'];
            $dataProduct['power_rating_hp'] = $data['power_rating_hp'];
            $dataProduct['power_rating_kw'] = $data['power_rating_kw'];
            //$dataProduct['flow_rate_lpm'] = $data['flow_rate_lpm'];
            $dataProduct['pressure'] = $data['pressure'];
            //$dataProduct['head_feet'] = $data['head_feet'];
            $dataProduct['outlet_size'] = $data['outlet_size'];
            $dataProduct['solid_handling_id'] = $data['solid_handling_id'];
            $dataProduct['bathroom_id'] = $data['bathroom_id'];
            $dataProduct['phase_id'] = $data['phase_id'];
            //$dataProduct['bore_diameter'] = $data['bore_diameter'];
            $dataProduct['bore_diameter_id'] = $data['bore_diameter_id'];
            $dataProduct['quantity'] = $data['quantity'];
            $dataProduct['stock_available'] = $data['stock_available'];
            $dataProduct['mrp'] = $data['mrp'];
            $dataProduct['weight'] = $data['weight'];
            $dataProduct['warranty'] = $data['warranty'];
            $dataProduct['commodity_id'] = $data['commodity_id'];
            $dataProduct['is_best'] = $data['is_best'];

            $dataProduct['inlet_size'] = $data['inlet_size'];
            $dataProduct['stages'] = $data['stages'];
            $dataProduct['pump_type_id'] = $data['pump_type_id'];
            $dataProduct['tank_type_id'] = $data['tank_type_id'];
            $dataProduct['warranty_service_type'] = $data['warranty_service_type'];

            if(!empty($data['fluid_type'])){
            	$dataProduct['fluid_type'] = implode(',',$data['fluid_type']);
        	}
        	if(!empty($data['applications'])){
            	$dataProduct['applications'] = implode(',',$data['applications']);
            }
            //$dataProduct['material_construction'] = $data['material_construction'];
            if(!empty($data['source_water'])){
            	$dataProduct['source_water'] = implode(',',$data['source_water']);
            }
            

            $dataProduct['flow_max'] = $data['flow_max'];
            $dataProduct['flow_min'] = $data['flow_min'];
            $dataProduct['flow_unit'] = $data['flow_unit'];
            $dataProduct['head_max'] = $data['head_max'];
            $dataProduct['head_min'] = $data['head_min'];
            $dataProduct['tank_capacity'] = $data['tank_capacity'];
            $dataProduct['rpm'] = $data['rpm'];


            $result = $this->M_product->edit($dataProduct);
            $resultDel = $this->M_product->deleteProductCategory($dataProduct['id']);
            $resultDel = $this->M_product->deleteProductPrice($dataProduct['id']);

            foreach($data['categories'] as $v){
            	$dataCategory['category_id'] = $v;
            	$dataCategory['product_id'] = $dataProduct['id'];
            	$resultCat = $this->M_product->addProductCategory($dataCategory);
        	}

        	$dataPrice['price'] = $data['price'];
        	$dataPrice['product_id'] = $dataProduct['id'];
        	$resultPrice = $this->M_product->addProductPrice($dataPrice);

        	if(!empty($data['rangePrice'][0])){
	        	foreach($data['rangePrice'] as $rpKey=>$rpVal){
	        		$dataPrice['price'] = $rpVal;
	        		$dataPrice['range_from'] = $data['rangeFrom'][$rpKey];
	        		if(!empty($dataPrice['range_from']) && !empty($dataPrice['price'])){
	        			$resultPrice = $this->M_product->addProductPrice($dataPrice);
	        		}
	        	}
	        }

        	
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
						$dataImage['product_id'] = $dataProduct['id'];
						$resultImage = $this->M_product->addProductImage($dataImage);
					}
				}
			}

			if(isset($data['featured'])){
        	$imageFeatured = $this->M_product->updateFeaturedImage($data['featured'],$dataProduct['id']);
        	}



        	$lengthGr = count($_FILES['graph']['name']);
            $files = $_FILES;

			if (!empty($_FILES['graph']['name'][0])) {
            for($i=0;$i<$lengthGr;$i++){
				$imgNameWithoutSpaces = str_replace(" ", "_", $_FILES['graph']['name'][$i]);
				$imageName = date('Ymdhis').'-'.$imgNameWithoutSpaces;
				$target_file = APPPATH . '../assets/image/graphs/original/' . $imageName;
				$upload = move_uploaded_file($_FILES["graph"]["tmp_name"][$i], $target_file);
				
				$dataImg[] = $imageName;
				if($upload)
					{
						$config['image_library'] = 'gd2';
						$config['source_image'] = APPPATH . '../assets/image/graphs/original/'.$imageName;
						$config['new_image'] = APPPATH . '../assets/image/graphs/thumbnail/'.$imageName;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width'] = 150;
						$config['height'] = 100;
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						$dataImage['image'] = $imageName;
						$dataImage['product_id'] = $result['insert_id'];
						
						$resultImage = $this->M_product->addGraphImage($dataImage);
					}
				}
			}


        	$this->M_product->deleteProductContent($dataProduct['id']);
        	if (!empty($_POST['content'])) {
        		foreach($_POST['content'] as $v){
        			$dataContent['content'] = $v;
					$dataContent['product_id'] = $dataProduct['id'];
        			$this->M_product->addProductContent($dataContent);
        		}
        	}

            if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }
		$pid = base64_decode($_GET['pid']);
		$result['pageHeading'] = 'Edit Product';

		$result['productData'] = $this->M_product->getProductDetails($pid);
		$result['productPrice'] = $this->M_product->getProductPrice($pid);
		$result['productImages'] = $this->M_product->getProductImages($pid);
		$result['graphImages'] = $this->M_product->getGraphImages($pid);

		$result['mainCategories'] = $this->M_category->getMainCategories();
		foreach($result['mainCategories'] as $k=>$v){
			$result['mainCategories'][$k]['subCategories'] = $this->M_category->getSubCategories($v['id']);
		}
		$result['productCategories'] = $this->M_product->getProductCategories($pid);
		foreach($result['productCategories'] as $vPC){
			$result['productCategory'][] = $vPC['category_id'];
		}
		$result['brands'] = $this->M_brand->getAllBrands();
		$result['contents'] = $this->M_product->getContents($pid);
		$result['phases'] = $this->M_product->getPhases();
		$result['bathrooms'] = $this->M_product->getBathrooms();
		$result['solids'] = $this->M_product->getSolids();
		$result['commodities'] = $this->M_product->getCommodities();
		$result['boreDiameters'] = $this->M_product->getBoreDiameters();
		$result['pumpTypes'] = $this->M_product->getPumpTypes();
		$result['tankTypes'] = $this->M_product->getTankTypes();

		$this->load->view('v_header');
		$this->load->view('product/v_productEdit',$result);
		$this->load->view('v_footer');	
	}


	public function copy()
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
            //$dataProduct['flow_rate_lpm'] = $data['flow_rate_lpm'];
            $dataProduct['pressure'] = $data['pressure'];
            //$dataProduct['head_feet'] = $data['head_feet'];
            $dataProduct['outlet_size'] = $data['outlet_size'];
            $dataProduct['solid_handling_id'] = $data['solid_handling_id'];
            $dataProduct['bathroom_id'] = $data['bathroom_id'];
            $dataProduct['phase_id'] = $data['phase_id'];
            //$dataProduct['bore_diameter'] = $data['bore_diameter'];
            $dataProduct['bore_diameter_id'] = $data['bore_diameter_id'];
            $dataProduct['quantity'] = $data['quantity'];
            $dataProduct['stock_available'] = $data['stock_available'];
            $dataProduct['mrp'] = $data['mrp'];
            $dataProduct['weight'] = $data['weight'];
            $dataProduct['warranty'] = $data['warranty'];
            $dataProduct['commodity_id'] = $data['commodity_id'];
            $dataProduct['is_best'] = $data['is_best'];

            $dataProduct['inlet_size'] = $data['inlet_size'];
            $dataProduct['stages'] = $data['stages'];
            $dataProduct['pump_type_id'] = $data['pump_type_id'];
            $dataProduct['tank_type_id'] = $data['tank_type_id'];
            $dataProduct['warranty_service_type'] = $data['warranty_service_type'];

            if(!empty($data['fluid_type'])){
            	$dataProduct['fluid_type'] = implode(',',$data['fluid_type']);
        	}
        	if(!empty($data['applications'])){
            	$dataProduct['applications'] = implode(',',$data['applications']);
            }
            //$dataProduct['material_construction'] = $data['material_construction'];
            if(!empty($data['source_water'])){
            	$dataProduct['source_water'] = implode(',',$data['source_water']);
            }

            $dataProduct['flow_max'] = $data['flow_max'];
            $dataProduct['flow_min'] = $data['flow_min'];
            $dataProduct['flow_unit'] = $data['flow_unit'];
            $dataProduct['head_max'] = $data['head_max'];
            $dataProduct['head_min'] = $data['head_min'];
            $dataProduct['tank_capacity'] = $data['tank_capacity'];
            $dataProduct['rpm'] = $data['rpm'];
            

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
			}else{
				$productImages = $this->M_product->getProductImages(base64_decode($data['pid']));
				
				foreach($productImages as $vImg){
					$dataImage['is_featured'] = $vImg['is_featured'];
					$dataImage['image'] = $vImg['image'];
					$dataImage['product_id'] = $result['insert_id'];
					$resultImage = $this->M_product->addProductImage($dataImage);
				}
			}
			
			if(isset($data['featured'])){
        	$imageFeatured = $this->M_product->updateFeaturedImage($resultImage['insert_id'],$result['insert_id']);
        	}


        	if (!empty($_POST['content'])) {
        		foreach($_POST['content'] as $v){
        			$dataContent['content'] = $v;
					$dataContent['product_id'] = $result['insert_id'];
        			$this->M_product->addProductContent($dataContent);
        		}
        	}


            if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }
		
		
		$pid = base64_decode($_GET['pid']);
		$result['pageHeading'] = 'Copy Product';

		$result['productData'] = $this->M_product->getProductDetails($pid);
		$result['productPrice'] = $this->M_product->getProductPrice($pid);
		$result['productImages'] = $this->M_product->getProductImages($pid);

		$result['mainCategories'] = $this->M_category->getMainCategories();
		foreach($result['mainCategories'] as $k=>$v){
			$result['mainCategories'][$k]['subCategories'] = $this->M_category->getSubCategories($v['id']);
		}
		$result['productCategories'] = $this->M_product->getProductCategories($pid);
		foreach($result['productCategories'] as $vPC){
			$result['productCategory'][] = $vPC['category_id'];
		}
		$result['brands'] = $this->M_brand->getAllBrands();
		$result['contents'] = $this->M_product->getContents($pid);
		$result['phases'] = $this->M_product->getPhases();
		$result['bathrooms'] = $this->M_product->getBathrooms();
		$result['solids'] = $this->M_product->getSolids();
		$result['commodities'] = $this->M_product->getCommodities();
		$result['boreDiameters'] = $this->M_product->getBoreDiameters();
		$result['pumpTypes'] = $this->M_product->getPumpTypes();
		$result['tankTypes'] = $this->M_product->getTankTypes();

		$this->load->view('v_header');
		$this->load->view('product/v_productCopy',$result);
		$this->load->view('v_footer');		
	}

	

	public function addImages()
	{
		$productId = base64_decode($_REQUEST['pid']);
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
						$dataImage['product_id'] = $productId;
						$resultImage = $this->M_product->addProductImage($dataImage);
					}
				}
			}

			if (!$upload) {
                echo 'false';
            } else {
            	
                $productImages = $this->M_product->getProductImages($productId);
                echo json_encode($productImages);
            }
	}



	public function addGraphs()
	{
		$productId = base64_decode($_REQUEST['pid']);
		$length = count($_FILES['graph']['name']);
        $files = $_FILES;
            if (!empty($_FILES['graph']['name'][0])) {
            for($i=0;$i<$length;$i++){
				$imgNameWithoutSpaces = str_replace(" ", "_", $_FILES['graph']['name'][$i]);
				$imageName = date('Ymdhis').'-'.$imgNameWithoutSpaces;
				$target_file = APPPATH . '../assets/image/graphs/original/' . $imageName;
				$upload = move_uploaded_file($_FILES["graph"]["tmp_name"][$i], $target_file);
				
				$dataImg[] = $imageName;
				if($upload)
					{
						$config['image_library'] = 'gd2';
						$config['source_image'] = APPPATH . '../assets/image/graphs/original/'.$imageName;
						$config['new_image'] = APPPATH . '../assets/image/graphs/thumbnail/'.$imageName;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width'] = 150;
						$config['height'] = 100;
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						$dataImage['image'] = $imageName;
						$dataImage['product_id'] = $productId;
						$resultImage = $this->M_product->addGraphImage($dataImage);
					}
				}
			}

			if (!$upload) {
                echo 'false';
            } else {
            	
                $graphImages = $this->M_product->getGraphImages($productId);
                echo json_encode($graphImages);
            }
	}



	public function removeImage()
	{
		$data = $_POST;

		$result = $this->M_product->removeImage($data);
		echo $result;
	}


	public function removeGraph()
	{
		$data = $_POST;

		$result = $this->M_product->removeGraph($data);
		echo $result;
	}

	
	public function removeBore()
	{
		$data = $_POST;
		$result = $this->M_product->removeBore($data);
		echo $result;
	}

	public function removeSolid()
	{
		$data = $_POST;

		$result = $this->M_product->removeSolid($data);
		echo $result;
	}

	public function removeBath()
	{
		$data = $_POST;
		$result = $this->M_product->removeBath($data);
		echo $result;
	}

	public function removeRange()
	{
		$data = $_POST;

		$result = $this->M_product->removeRange($data);
		echo $result;
	}

	public function removeTank()
	{
		$data = $_POST;
		$result = $this->M_product->removeTank($data);
		echo $result;
	}

	public function getProductsOnSub()
	{
		$this->load->model('M_category');
		$data = $_POST;
		$catResult['product'] = $this->M_product->getProductsOnSub($data['id']);
		echo json_encode($catResult['product']);
	}

}
?>