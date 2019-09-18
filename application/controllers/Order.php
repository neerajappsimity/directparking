<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller 
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
		$this->load->model('M_order');
    	$this->load->model('M_product');
    	$this->load->model('M_category');
    	$this->load->model('M_brand');
    	$this->load->model('M_android');

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
		$tempKeyword = explode('PMK',$keyword);
		$keyword = end($tempKeyword);
		$keywordDuplicate = $keyword;
	    if($keyword == 'null') {
            $keyword = '';
        }
       
        /*if(isset($_GET['price_to']) ){
        	$filter['price_to'] = $_GET['price_to'];
        }
        if(isset($_GET['price_from']) ){
        	$filter['price_from'] = $_GET['price_from'];
        }*/
        if(isset($_GET['order_status']) ){
        	$filter['order_status'] = $_GET['order_status'];
        }
        if(isset($_GET['ship_to']) ){
        	$filter['ship_to'] = $_GET['ship_to'];
        }
        
        if(isset($_GET['warehouse_id']) ){
        	$filter['warehouse_id'] = $_GET['warehouse_id'];
        }

        if(isset($_GET['order_id']) ){

        	$filter['order_id'] = $_GET['order_id'];
        	if(!empty($filter['order_id'])){
        		$tempOrder = explode('-',$filter['order_id']);
        		$filter['order_id'] = end($tempOrder);
        	}
        }

        if(isset($_GET['invoice_no']) ){
        	$filter['invoice_no'] = $_GET['invoice_no'];
        }

        if(isset($_GET['order_date_to']) && !empty($_GET['order_date_to'])){
        	$dateTo =  explode('/',$_GET['order_date_to']);
        	@$filter['order_date_to'] = date('Y-m-d',mktime(0, 0, 0, $dateTo[1], $dateTo[0], $dateTo[2]));
        }
        if(isset($_GET['order_date_from']) && !empty($_GET['order_date_from'])){
        	$dateFrom =  explode('/',$_GET['order_date_from']);
        	@$filter['order_date_from'] = date('Y-m-d',mktime(0, 0, 0, $dateFrom[1], $dateFrom[0], $dateFrom[2]));
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
		$result["warehouses"] = $this->M_order->getWarehouses();
		
		$result['pageHeading'] = 'All Orders';
		$result['startPage'] = $start;
				
		$this->load->view('v_header');
		$this->load->view('order/v_orderlist',$result);
		$this->load->view('v_footer');
	}


	public function exportOrder($keyword = 'null')
	{
		$keyword = urldecode($keyword);
		$filter = array();
		$tempKeyword = explode('PMK',$keyword);
		$keyword = end($tempKeyword);
		$keywordDuplicate = $keyword;
	    if($keyword == 'null') {
            $keyword = '';
        }
      
        if(isset($_GET['order_status']) ){
        	$filter['order_status'] = $_GET['order_status'];
        }
        if(isset($_GET['ship_to']) ){
        	$filter['ship_to'] = $_GET['ship_to'];
        }
        if(isset($_GET['warehouse_id']) ){
        	$filter['warehouse_id'] = $_GET['warehouse_id'];
        }
   

        if(isset($_GET['order_id']) ){

        	$filter['order_id'] = $_GET['order_id'];
        	if(!empty($filter['order_id'])){
        		$tempOrder = explode('-',$filter['order_id']);
        		$filter['order_id'] = end($tempOrder);
        	}
        }

        if(isset($_GET['order_date_to']) && !empty($_GET['order_date_to'])){
        	$dateTo =  explode('/',$_GET['order_date_to']);
        	@$filter['order_date_to'] = date('Y-m-d',mktime(0, 0, 0, $dateTo[1], $dateTo[0], $dateTo[2]));
        }
        if(isset($_GET['order_date_from']) && !empty($_GET['order_date_from'])){
        	$dateFrom =  explode('/',$_GET['order_date_from']);
        	@$filter['order_date_from'] = date('Y-m-d',mktime(0, 0, 0, $dateFrom[1], $dateFrom[0], $dateFrom[2]));
        }

		$this->load->model('M_welcome');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'order/index/' . $keywordDuplicate . '/';

		$uri = http_build_query($_GET);
		
		$count = $this->M_order->countOrders($keyword,$filter);
		$config['total_rows'] = $count;
		$config["uri_segment"] = 4;
		$limit = "";
		$start = $this->uri->segment(4, 0);
	
		$result["orders"] = $this->M_order->getOrders($start,$limit,$keyword,$filter);

			$header = "Sno" . "\t";
			$header .= "Order ID" . "\t";
			$header .= "Invoice No" . "\t";
			$header .= "Customer" . "\t";
			$header .= "Company" . "\t";
			$header .= "Delivery Address" . "\t";
			$header .= "Payment Method" . "\t";
			$header .= "Net Amount" . "\t";
			$header .= "Status" . "\t";
			$header .= "Created" . "\t";

			$data1='';
			$count = 0;
			foreach ($result["orders"] as $key => $value) {
				$count++;
				unset($row1);
				$row1[]= $count;
				$row1[]= 'PMK8-'.str_pad($value['id'], 5, '0', STR_PAD_LEFT);
				$row1[]= $value['invoice_no'];
				$row1[]= $value['fname'].' '.$value['lname'];
				$row1[]= $value['company'];
				$row1[]= $value['delivery_address_1'].', '.$value['delivery_address_2'];
				$row1[]= $value['payment_method'];
				$row1[]= 'Rs. '.$value['net_amount'];
				$row1[]= $value['order_status'];
				$row1[]= $value['created_date'];
				$data1 .= join("\t", $row1)."\n";
			}

			
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=order_list_".date('d-m-Y').".xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			print "$header\n$data1";
			exit();

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


	public function cancelled()
	{
		$data = $_POST;
		$data['status_id'] = '4';

		$result = $this->M_order->changeStatus($data);
		echo $result;
	}

	public function addOrderComment()
	{
		
		$data = $_POST;
		$data['user_id'] = $this->session->userData('user_id');
		$data['created'] = date('Y-m-d H:i:s');
		$result = $this->M_order->addOrderComment($data);
		$result['name'] = $this->session->userData('name');
		echo json_encode($result);
	}


	
	public function postEditOrder($order_id)
	{
		
		if (!empty($_POST)) {
            $data = $_POST;

            $dataOrder['id'] = $order_id;
            
            $dataOrder['net_amount'] = $data['net_amount'];
            $dataOrder['shipping_charges'] = $data['shipping_charges'];
           
            $dataOrder['payment_method_id'] = '1';
            //$dataOrder['tax_type_id'] = $_POST['tax_type_id'];
            $dataOrder['created_date'] = date('Y-m-d H:i:s');
            $dataOrder['tax_amount'] = 0;
            $customer = $this->M_order->getCustomer($data['userId']);


            if(!empty($_POST['id'][0])){
	            foreach($_POST['id'] as $k=>$v){
	            	$dataOrder['tax_amount'] = $dataOrder['tax_amount'] + $_POST['tax'][$k];
	            }
	        }

            //$dataOrder['tax_rate'] = $data['shipping_charges'];
            //$dataOrder['tax_amount'] = $data['shipping_charges'];

            

            $result = $this->M_order->edit($dataOrder);
            $this->M_order->deleteOrderItems($order_id);

            if(!empty($_POST['id'][0])){
	            foreach($_POST['id'] as $k=>$v){
	            	$dataItem['product_id'] = $_POST['id'][$k];
	            	$dataItem['quantity'] = $_POST['quantity'][$k];
	            	$dataItem['price_per_unit'] = $_POST['per_unit_price'][$k];
	            	$dataItem['tax_rate'] = $_POST['tax_rate'][$k];
	            	$dataItem['tax_amount'] = $_POST['tax'][$k];
	            	$dataItem['total_amount'] = $_POST['proTotal'][$k];
	            	$dataItem['mrp_price_per_unit'] = $_POST['mrp'][$k];

	            	$dataItem['order_id'] = $order_id;
	            	$resultItem = $this->M_order->addOrderItem($dataItem);
	        	}
	        }
        	
            
            if ($resultItem == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }
	}

	
	public function placeOrder()
	{
		$this->load->model('M_user');
	
		if (!empty($_POST)) {


			
            $data = $_POST;
            $dataOrder['financial_year'] = '2017';
            
            $dataOrder['net_amount'] = $data['net_amount'];
            $dataOrder['discount_amount'] = $data['total_dis_amount'];
            $dataOrder['shipping_charges'] = $data['shipping_charges'];
            $dataOrder['user_id'] = $data['userId'];
            $dataOrder['delivery_address_1'] = $data['address_line_1'];
            $dataOrder['delivery_address_2'] = $data['address_line_2'];
            $dataOrder['delivery_city'] = $data['city_id'];
            $dataOrder['delivery_state'] = $data['state_id'];
            $dataOrder['delivery_pincode'] = $data['pincode'];
            $dataOrder['payment_method_id'] = '1';
            $dataOrder['tax_type_id'] = $_POST['tax_type_id'];
           
			

            $dataOrder['created_date'] = $data['created_date'];
            $dataOrder['tax_amount'] = 0;
            $customer = $this->M_order->getCustomer($data['userId']);
            if($dataOrder['tax_type_id'] == '4'){
				if($customer['state_id'] == "6"){
					$dataOrder['gst_type'] = "CGST/UGST";
				}else{
					$dataOrder['gst_type'] = "IGST";
				}
			}

            $dataOrder['bill_address_1'] = $customer['address_line_1'];
            $dataOrder['bill_address_2'] = $customer['address_line_2'];
            $dataOrder['bill_state'] = $customer['state_id'];
            $dataOrder['bill_city'] = $customer['city_id'];
            $dataOrder['bill_pincode'] = $customer['pincode'];

            if(!empty($_POST['id'][0])){
	            foreach($_POST['id'] as $k=>$v){
	            	$dataOrder['tax_amount'] = $dataOrder['tax_amount'] + $_POST['tax'][$k];
	            }
	        }

            //$dataOrder['tax_rate'] = $data['shipping_charges'];
            //$dataOrder['tax_amount'] = $data['shipping_charges'];

            

            $result = $this->M_order->add($dataOrder);

            if(!empty($_POST['id'][0])){
	            foreach($_POST['id'] as $k=>$v){
	            	$dataItem['product_id'] = $_POST['id'][$k];
	            	$dataItem['quantity'] = $_POST['quantity'][$k];
	            	$dataItem['price_per_unit'] = $_POST['per_unit_price'][$k];
	            	$dataItem['tax_rate'] = $_POST['tax_rate'][$k];
	            	$dataItem['tax_amount'] = $_POST['tax'][$k];
	            	$dataItem['total_amount'] = $_POST['proTotal'][$k];
	            	$dataItem['discount_rate'] = $_POST['proDiscount'][$k];
	            	$dataItem['discount_amount'] = $_POST['proDiscountAmount'][$k];
	            	$dataItem['mrp_price_per_unit'] = $_POST['mrp'][$k];

	            	$dataItem['order_id'] = $result['insert_id'];
	            	$resultItem = $this->M_order->addOrderItem($dataItem);
	        	}
	        }
        	
            
            if ($resultItem == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }
		
		
		$result['pageHeading'] = 'Place Order';

		$result["states"] = $this->M_user->getState();

		$this->load->view('v_header');
		$this->load->view('order/v_placeOrder',$result);
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

            $order = $this->M_order->getOrderDetails(base64_decode($data['id']));

            if($order['warehouse_id']=='0' || $data['warehouse_id']!= $order['warehouse_id']){

            	$warehouse = $this->M_order->getWarehouseDetails($data['warehouse_id']);
            	$financial_year = '2017';
            	$stateCount = $this->M_order->getStateCount($warehouse['state_id'],$financial_year);
            	
				/*if($warehouse['state_id'] == "6"){
				  $invoicePrefix = "PKCHD-";
				}else if($warehouse['state_id'] == "32"){
				  $invoicePrefix = "PKPUN-";
				}*/
				
				$invoicePrefix = 'PKGST-';

				$gstCount = $this->M_order->getGSTCount($financial_year);
				
				$stateCount['state_count'] = $stateCount['state_count']+1;
				$gstCount['gst_count'] = $gstCount['gst_count']+1;

				$dataItem['invoice_no'] = $invoicePrefix.str_pad($gstCount['gst_count'], 5, '0', STR_PAD_LEFT);
				//$dataItem['invoice_no']="dsad";         	
            }

            //$dataItem['comment'] = $data['comment'];
            $dataItem['warehouse_id'] = $data['warehouse_id'];
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
		$result["warehouses"] = $this->M_order->getWarehouses();
		$result["comments"] = $this->M_order->getOrderComments($oid);
		$result["refunds"] = $this->M_order->getRefunds($oid);

		$this->M_order->updateOrderNotification($oid);
		/*$result["paymentMethods"] = $this->M_order->getPaymentMethods();*/

		$this->load->view('v_header');
		$this->load->view('order/v_orderView',$result);
		$this->load->view('v_footer');	
	}



	public function editOrder()
	{
		
		if (!empty($_POST)) {
            $data = $_POST;

            $order = $this->M_order->getOrderDetails(base64_decode($data['id']));

            if($order['warehouse_id']=='0' || $data['warehouse_id']!= $order['warehouse_id']){

            	$warehouse = $this->M_order->getWarehouseDetails($data['warehouse_id']);
            	$financial_year = '2017';
            	$stateCount = $this->M_order->getStateCount($warehouse['state_id'],$financial_year);
            	
				/*if($warehouse['state_id'] == "6"){
				  $invoicePrefix = "PKCHD-";
				}else if($warehouse['state_id'] == "32"){
				  $invoicePrefix = "PKPUN-";
				}*/
				$invoicePrefix = 'PKGST-';

				$gstCount = $this->M_order->getGSTCount($financial_year);
				
				$stateCount['state_count'] = $stateCount['state_count']+1;
				$gstCount['gst_count'] = $gstCount['gst_count']+1;

				$dataItem['invoice_no'] = $invoicePrefix.str_pad($gstCount['gst_count'], 5, '0', STR_PAD_LEFT);   
				//$dataItem['invoice_no']="dsad";         	
            }

            //$dataItem['comment'] = $data['comment'];
            $dataItem['warehouse_id'] = $data['warehouse_id'];
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
		$result["warehouses"] = $this->M_order->getWarehouses();
		$result["comments"] = $this->M_order->getOrderComments($oid);

		$this->M_order->updateOrderNotification($oid);
		/*$result["paymentMethods"] = $this->M_order->getPaymentMethods();*/

		$this->load->view('v_header');
		$this->load->view('order/v_editOrder',$result);
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

	public function invoice()
	{
		$this->load->helper('pdf_helper');	
		if (!empty($_POST)) {
            $data = $_POST;
			
            $result = $this->M_anchororder->editOrderItem($data);
            $result = $this->M_anchororder->editOrderStatus($data);

            if ($result == false) {
                echo 'false';
            } else {
                echo 'true';
            }
            die;
            /* please don't delete above die */
        }
		$id = base64_decode($_GET['id']);
		$catResult['details'] = $this->M_order->getOrderDetails($id);
		$catResult['customer'] = $this->M_order->getCustomer($catResult['details']['user_id']);
		$catResult['itemList'] = $this->M_order->getOrderItemDetails($id);
		//echo "<pre>";
		//print_r($catResult['details']);die;
		$this->load->view('v_header');
		$this->load->view('pdf/v_invoice',$catResult);
		$this->load->view('v_footer');	
	}


	public function getProductDetails()
	{
		$data = $_REQUEST;
		$data['user_id'] = $data['userId'];
		$res = $this->M_android->getProductDetails($data['searchProductId']);
		$price = array();

		if($res['quantity'] <= 0){
			$res['stock_available'] = '0';
		}
		//site_url().'assets/image/products/original/'

		$result = array('id' => $res['id'], 'name' => $res['name'],'brand' => $res['brand_name'],'description'=>$res['description'], 'short_description'=>$res['short_description'], 'mrp'=>$res['mrp'], 'sku'=>$res['sku'],'price'=>$res['price'], 'is_featured'=>$res['is_featured'], 'weight'=>$res['weight'], 'care_instructions'=>$res['care_instructions'], 'featured_image' => $res['featured_image'],'stock_available'=>$res['stock_available'], 'warranty'=>$res['warranty'], 'quantity'=>$res['quantity'] );
		$data['product_id'] = $data['searchProductId'];
		$priceRange = $this->M_android->getUserProductPriceRange($data);
		//$result['tax'] = $this->getUserTax($data['user_id'],$res['commodity_id']);
		$taxData= $this->getUserTax($data['userId'],$res['commodity_id']);
		@$result['tax'] = $taxData['tax_name'];

		$userDiscount = $taxData['user_discount'];

		if(!empty($priceRange)){
						$priceRange2 = $this->M_android->getProductPrice($data['searchProductId']);
						$priceSpBase = $priceRange2['price'];
						@$taxAmountBase = ($priceRange2['price']/100)*$taxData['rate'];
						$result['price_tax_rate'] = $taxData['rate'];
						$discountAmount = 0;
						$priceTo = $priceRange[0]['moq']-1;
						$price[] = array('from'=>"1",'to'=>$priceTo,'price'=>$priceSpBase,'tax_amount'=>$taxAmountBase,'discount_amount'=>$discountAmount);
						foreach($priceRange as $k=>$v){
							$priceFrom = $v['moq'];
							if(@$priceRange[$k+1]['moq']){
								$priceTo = $priceRange[$k+1]['moq']-1;
							}else{
								$priceTo = 'Above' ;
							}
							$priceSp = $v['price'];
							$taxAmount = ($v['price']/100)*$taxData['rate'];
							$discountAmount = ($v['price']/100)*$userDiscount;
							$price[] = array('from'=>$priceFrom,'to'=>$priceTo,'price'=>$priceSp,'tax_amount'=>$taxAmount,'discount_amount'=>$discountAmount);
						}
						$result['price'] = $priceSpBase;
						$result['price_tax'] = $taxAmountBase;
						$result['price_range'] = $price;

		}else{
		//$result['price_range'] = "";
						$priceRange2 = $this->M_android->getProductPrice($data['searchProductId']);
						$priceSp = $priceRange2['price'];
						@$taxAmount = ($priceRange2['price']/100)*$taxData['rate'];
						$discountAmount = 0;
						$result['price_range'] = array();
						$result['price'] = $priceSp;
						$result['price_tax'] = $taxAmount;
						$result['price_tax_rate'] = $taxData['rate'];	
		}


		$result['images'] = $this->M_android->getImages($data['searchProductId']);
		foreach($result['images'] as $kI=>$vI){
			$result['images'][$kI] = site_url().'assets/image/products/original/'.$vI['image'];
		}
		
		echo json_encode($result);
	}



	/*public function getUserTax($id,$commodityId){
		
		$userData = $this->M_android->getUserDetails($id);
		if($userData['state_id'] == 32){
			$taxTypeId=1;
		}else if($userData['state_id'] == 6){
			$taxTypeId=1;
		}else if(!empty($userData['tin_number'])){
			$taxTypeId=3;
		}else{
			$taxTypeId=2;
		}
		$data['state_id'] = $userData['state_id'];
		$data['tax_type_id'] = $taxTypeId;
		$data['commodity_id'] = $commodityId;
		
		$taxData = $this->M_android->getUserTax($data);
		$taxData['user_discount'] = $userData['discount'];
		
		return $taxData;
	}*/


	public function getUserTax($id,$commodityId){
		
		$isGST = $this->M_android->isGST();
		if(!$isGST){

			$userData = $this->M_android->getUserDetails($id);
			if($userData['state_id'] == 32){
				$taxTypeId=1;
			}else if($userData['state_id'] == 6){
				$taxTypeId=1;
			}else if(!empty($userData['tin_number'])){
				$taxTypeId=3;
			}else{
				$taxTypeId=2;
			}
			$data['state_id'] = $userData['state_id'];
			$data['tax_type_id'] = $taxTypeId;
			$data['commodity_id'] = $commodityId;
		
		}else{
			$userData = $this->M_android->getUserDetails($id);
			$taxTypeId=4;//GST tax type
			$data['state_id'] = $userData['state_id'];
			$data['tax_type_id'] = $taxTypeId;
			$data['commodity_id'] = $commodityId;
		}

		$taxData = $this->M_android->getUserTax($data);
		$taxData['user_discount'] = $userData['discount'];

		if($data['tax_type_id'] == "4"){
			if($userData['state_id'] == 6){
				$taxData['gst_type'] = "CGST/UGST";
			}else{
				$taxData['gst_type'] = "IGST";
			}
		}
		
		return $taxData;

	}


	public function refundAmt()
	{
		$this->load->helper('string');

		header("Pragma: no-cache");
		header("Cache-Control: no-cache");
		header("Expires: 0");
		// following files need to be included
		require_once(APPPATH.'libraries/paytm/encdec_paytm.php');
		require_once(APPPATH.'libraries/paytm/config_paytm.php');
		$checkSum = "";
		// below code snippet is mandatory, so that no one can use your checksumgeneration url for other purpose .
		$order_id = $_POST['order_id'];
		$refund_amount = $_POST['refund_amount'];

		unset($_POST['order_id']);
		unset($_POST['refund_amount']);

		$order = $this->M_order->getOrderDetails($order_id);

		$findme   = 'REFUND';
		$paramList1 = array();
		$paramList1["MID"] = 'pumpka56345434341027';
		$paramList1["ORDER_ID"] = $order['paytm_order_id'];
		//$paramList1["CUST_ID"] = '';
		$paramList1["INDUSTRY_TYPE_ID"] = 'Retail105';
		$paramList1["CHANNEL_ID"] = 'WEB';
		$paramList1["TXNTYPE"] = 'REFUND';
		$paramList1["REFID"] = random_string('alnum',20);
		$paramList1["TXN_AMOUNT"] = $refund_amount;
		$paramList1["WEBSITE"] = 'pumpkartweb';
		$paramList1["REFUNDAMOUNT"] = $refund_amount; 
		$paramList1["TXNID"] = $order['transaction_id']; 

		$temp = initiateTxnRefund($paramList1);
		print_r($temp);die;
		$return['status'] = $temp['STATUS'];

		if($temp['STATUS'] == "TXN_SUCCESS" || $temp['STATUS'] == "PENDING"){
				$refundData['order_id'] = $order_ids;
				$refundData['amount'] = $refund_amount;
				$refundData['respcode'] = $temp['RESPCODE'];
				$refundData['status'] = $temp['STATUS'];
				$refundData['txn_date'] = $temp['TXNDATE'];
				$refundData['refund_id'] = $temp['REFUNDID'];

				$order = $this->M_order->addRefund($refundData);
		}



		///print_r($temp);die;

		/*$checkSum = getChecksumFromArray($paramList1,PAYTM_MERCHANT_KEY);

		$paytmChecksum = "";
		//$paramList = array();
		$isValidChecksum = FALSE;
		//$paramList = $_POST;
		$return_array = $_POST;
		//$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : "";
		$paytmChecksum = isset($checkSum) ? $checkSum : ""; //Sent by Paytm pg
		//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
		$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
		// if ($isValidChecksum===TRUE)
		// 	$return_array["IS_CHECKSUM_VALID"] = "Y";
		// else
		// 	$return_array["IS_CHECKSUM_VALID"] = "N";
		$return_array["IS_CHECKSUM_VALID"] = $isValidChecksum ? "Y" : "N";
	

		//$return_array["TXNTYPE"] = "";
		//$return_array["REFUNDAMT"] = "";
		
		//unset($return_array["CHECKSUMHASH"]);
		
		$encoded_json = htmlentities(json_encode($return_array));

		

		//echo $encoded_json;

		$ch = curl_init();                    // initiate curl
		$url = "https://pguat.paytm.com/oltp/HANDLER_INTERNAL/REFUND?JsonData=".$encoded_json; // where you want to post data


		$ch = curl_init();  // initiate curl
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    
		//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$output = curl_exec ($ch); // execute
		
		$outputData = json_decode($output);
		$return['status'] = $outputData->STATUS;

		if($outputData->STATUS == "TXN_SUCCESS" || $outputData->STATUS == "PENDING"){
				$refundData['order_id'] = $order_ids;
				$refundData['amount'] = $refund_amount;
				$refundData['respcode'] = $outputData->RESPCODE;
				$refundData['status'] = $outputData->STATUS;
				$refundData['txn_date'] = $outputData->TXNDATE;

				$order = $this->M_order->addRefund($refundData);
		}*/

		echo json_encode($return);die;
		
	}

}
?>