<div class="page-content-wrapper">
        <div class="page-content">

        <div class="row">
                <div class="col-md-12">
                    <h3 class="page-title">
                    <?php echo $pageHeading;?>
                    </h3>
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="<?php echo site_url(); ?>">
                                Home
                            </a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a href="<?php echo site_url(); ?>order/view?oid=<?php echo $_GET['oid']; ?>">
                                <?php echo $pageHeading;?>
                            </a>
                        </li>
                        
                    </ul>
                    
                </div>
            </div>

		<div class="form-group" id="message" style="dispaly:none;"></div>
		<div class="row">
				<div class="col-md-12">
					<!-- Begin: life time stats -->
					<form class="form-horizontal form-row-seperated" id="editOrderForm" enctype="multipart/form-data" action="javascript:editOrder();">
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-shopping-cart"></i>Order #<?php echo 'PMK8-'.str_pad($order['id'], 5, '0', STR_PAD_LEFT);?>
								<span class="hidden-480">
									 | <?php echo $order['created_date'];?>
								</span>
							</div>
							<div class="actions">
								<a onclick="goBack();" href="javascript:;" class="btn default"><i class="fa fa-angle-left"></i> Back</a>
									<!--button class="btn default"><i class="fa fa-reply"></i> Reset</button-->
									<button class="btn green"><i class="fa fa-check"></i> Save</button>
									<a target="_blank" href="<?php echo site_url()."/order/invoice?id=".$_GET['oid'];?>" class="btn red" onclick="return checkWarehouseSelected();"><i class="fa fa-file-pdf-o"></i> Invoice</a>
								
							</div>
						</div>
						<div class="portlet-body">
							<div class="tabbable">
								<ul class="nav nav-tabs nav-tabs-lg">
									<li class="active">
										<a href="#tab_1" data-toggle="tab">
											 Details
										</a>
									</li>
									
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_1">
										<div class="row">
											<div class="col-md-6 col-sm-12">
												<div class="portlet yellow box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Order Details
														</div>
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-5 name">
																 Order #:
															</div>
															<div class="col-md-7 value">
															<input type="hidden" name="id" value="<?php echo $_GET['oid'];?>">
																 <?php echo 'PMK8-'.str_pad($order['id'], 5, '0', STR_PAD_LEFT);?>
																<!--span class="label label-info label-sm">
																	 Email confirmation was sent
																</span-->
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Order Date & Time:
															</div>
															<div class="col-md-7 value">
																<?php echo $order['created_date'];?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Order Status:
															</div>
															<div class="col-md-7 value">
																<select name="status" id="status">
																	<?php foreach($orderStatus as $os){?>
																	<option <?php if($os['id'] == $order['status_id']){echo "selected='selected'";} ?> value="<?php echo $os['id'];?>"><?php echo $os['order_status'];?></option>
																	<?php } ?>
																	</select>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Warehouse:
															</div>
															<div class="col-md-7 value">

															<?php if($order['status_id'] != '3'){?>
																<select name="warehouse_id" id="warehouse_id">
																	<option value="0">Select Warehouse</option>
																	<?php foreach($warehouses as $warehouse){?>
																	<option <?php if($warehouse['id'] == $order['warehouse_id']){echo "selected='selected'";} ?> value="<?php echo $warehouse['id'];?>"><?php echo $warehouse['name'];?></option>
																	<?php } ?>
																	</select>
															<?php }else{ 

																echo $order['ware_name'];
															}

															?>
															</div>
															<input type="hidden" value="<?php echo $order['warehouse_id'];?>" id="wareTemp">
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Grand Total:
															</div>
															<div class="col-md-7 value">
																 Rs. <?php echo $order['net_amount'];?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Payment Method:
															</div>
															<div class="col-md-7 value">
																<?php echo $order['payment_method'];?>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="portlet blue box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Customer Information
														</div>
														
													</div>
													<div class="portlet-body">

													<div class="row static-info">
															<div class="col-md-5 name">
																 Company Name:
															</div>
															<div class="col-md-7 value">
																 <?php echo $order['company']; ?>
															</div>
													</div>

														<div class="row static-info">
															<div class="col-md-5 name">
																 Customer Name:
															</div>
															<div class="col-md-7 value">
																 <?php echo $order['fname'].' '.$order['lname']; ?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Email:
															</div>
															<div class="col-md-7 value">
																<?php echo $order['email'];?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 User Type:
															</div>
															<div class="col-md-7 value">
																<?php echo $order['user_type'];?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																Mobile:
															</div>
															<div class="col-md-7 value">
																<?php echo $order['mobile'];?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										
										<div class="row">
											<div class="col-md-6 col-sm-12">
												<div class="portlet green box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Billing Address
														</div>
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-12 value">
																 <?php echo $order['bill_address_1'];?><br>
																 <?php echo $order['bill_address_2'];?><br>
																 <?php echo $order['bill_city'];?><br>
																 <?php echo $order['bill_state'];?><br>
																 <?php echo $order['bill_pincode'];?><br>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="portlet red box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Shipping Address
														</div>
														
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-12 value">
																<?php echo $order['delivery_address_1'];?><br>
																 <?php echo $order['delivery_address_2'];?><br>
																 <?php echo $order['delivery_city'];?><br>
																 <?php echo $order['delivery_state'];?><br>
																 <?php echo $order['delivery_pincode'];?><br>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>


										<div class="row">
											<div class="col-md-12 col-sm-12">
												<div class="portlet purple box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Shopping Cart
														</div>
													</div>
													<div class="portlet-body">
														<div class="table-responsive">
															<table class="table table-hover table-bordered table-striped">
															<thead>
															<tr>
																<th>
																	 Product
																</th>
																<th>
																	 MRP
																</th>
																<th>
																	 Price
																</th>
																<th>
																	 Quantity
																</th>
																<!--th>
																	 Tax Amount
																</th>
																<th>
																	 Tax Percent
																</th-->
																<th>
																	 Discount Amount
																</th>
																<th>
																	 Total
																</th>
															</tr>
															</thead>
															<tbody>
															<?php 
															$tempCommodityId = '';
															$tempTaxAmount = 0;
															if(!empty($orderItems)){
															foreach($orderItems as $keyItem=>$valItem){
																if($tempCommodityId == ''){
																	$tempCommodityId = $valItem['commodity_id'];
																}
																?>
															<tr>
																	<td width="30%">
																		<?php echo $valItem['product_name'];?>
																	</td>
																	<td align="right">
																		Rs. <?php echo $valItem['mrp_price_per_unit'];?>
																	</td>
																	<td align="right">
																		Rs. <?php echo $valItem['price_per_unit'];?>
																	</td>
																	<td align="right">
																		 <?php echo $valItem['quantity'];?>
																	</td>
																	<td align="right">
																		Rs.<?php echo $valItem['discount_amount'];?>
																	</td>
																	<td align="right">
																		Rs. <?php echo $valItem['total_amount'];?>
																	</td>
															</tr>
																<?php 
																$nextKeyItem = $keyItem+1;
																$tempTaxAmount = $tempTaxAmount+$valItem['tax_amount']; 
																if($tempCommodityId != $valItem['commodity_id'] || !isset($orderItems[$nextKeyItem])){
																	
																	?>
																	<tr>
																		<td colspan="5" align="right"><?php echo $order['tax_type'];?> (<?php echo $valItem['tax_rate'];?>%)</td>
																		<td align="right"><?php echo $tempTaxAmount;?></td>
																	</tr>
																<?php $tempTaxAmount = 0; }
																	$tempCommodityId = $valItem['commodity_id']; ?>
																<?php } }?>
																
																	
																			</tbody>
																			</table>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="row">
															<!--div class="col-md-6">
															</div-->
															<div class="col-md-12">
																<div class="well">

																	<div class="row static-info align-reverse">
																		<div class="col-md-8 name">
																			 Discount:
																		</div>
																		<div class="col-md-3 value">
																			 Rs. <?php echo $order['discount_amount']+$order['coupon_discount'];?>
																		</div>
																	</div>
																	<div class="row static-info align-reverse">
																		<div class="col-md-8 name">
																			 Shipping Charges:
																		</div>
																		<div class="col-md-3 value">
																			 Rs. <?php echo $order['shipping_charges'];?>
																		</div>
																	</div>
																	<div class="row static-info align-reverse">
																		<div class="col-md-8 name">
																			  <?php echo $order['tax_type'];?>:
																		</div>
																		<div class="col-md-3 value">
																			 Rs. <?php echo $order['tax_amount'];?>
																		</div>
																	</div>
																	<div class="row static-info align-reverse">
																		<div class="col-md-8 name">
																			 Grand Total:
																		</div>
																		<div class="col-md-3 value">
																			 Rs. <?php echo $order['net_amount'];?>
																		</div>
																	</div>
																	<!--div class="row static-info align-reverse">
																		<div class="col-md-8 name">
																			 Total Paid:
																		</div>
																		<div class="col-md-3 value">
																			 $1,260.00
																		</div>
																	</div>
																	<div class="row static-info align-reverse">
																		<div class="col-md-8 name">
																			 Total Refunded:
																		</div>
																		<div class="col-md-3 value">
																			 $0.00
																		</div>
																	</div>
																	<div class="row static-info align-reverse">
																		<div class="col-md-8 name">
																			 Total Due:
																		</div>
																		<div class="col-md-3 value">
																			 $1,124.50
																		</div>
																	</div-->
																</div>
															</div>
														</div>
													</div>

										<div class="row">
											<div class="col-md-12 col-sm-12">
												<div class="portlet green box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-comment"></i>Comment
														</div>
													</div>
													
													<div class="portlet-body comment-row">
													
													<?php 
													if(!empty($comments)){
													foreach($comments as $comment){?>
														<div class="row static-info">
															<div class="col-md-12 value">
															<?php echo ucfirst($comment['fname'])." ".ucfirst($comment['lname']);?> on	<?php echo $comment['created'];?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-12">
															<?php echo $comment['comment'];?>
															</div>
														</div>
														<hr>
													<?php }}?>
													<div class="row">
															<div class="col-md-2">
																<input type="button" onclick="javascript:addOrderComment();" class="btn btn-success" value="Add Comment">
															</div>
															<div class="col-md-10">

																<textarea rows="2" id="comment" name="comment" class="form-control" ></textarea>
															</div>
													</div>
													
													</div>
												</div>
											</div>
										</div>


										<div class="row">
											<div class="col-md-12 col-sm-12">
												<div class="portlet green box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-dollar"></i>Refund
														</div>
													</div>
													
													<div class="portlet-body comment-row">

													<?php 
													if(!empty($refunds)){
													foreach($refunds as $refund){?>
														<div class="row static-info">
															<div class="col-md-12 value">
															<?php echo "<b>Amount</b>: Rs. ".($refund['amount'])." <br><b>Refund Id </b>: ".$refund['refund_id']." <br> <b>Date</b>: ".($refund['txn_date']);?> 
															</div>
														</div>
														
														<hr>
													<?php }}?>
													
													<div class="row">
															<div class="col-md-2">
																<input type="button" onclick="javascript:addRefund();" class="btn btn-success" value="Add Refund">
															</div>
															<div class="col-md-10">

																<input type="number" id="refund_amount" name="refund_amount">

															</div>
													</div>
													
													</div>
												</div>
											</div>
										</div>
													
													
													
													
												</div>
											</div>
										</div>
									</div>
									</form>
									</div>
									</div>





		
	</div><!--wrapper_inner close -->
</div>	


<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assets/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">

<script>
	
function editOrder()
{
	var form_data = new FormData($("#editOrderForm")[0]);

	$.ajax({
		url: URL +"order/view", 
		type: "post", 
		data: form_data,     
		cache: false,
		contentType: false,
		processData: false,
		success: function (htmlStr)
		{
			$('#message').html('');
			if(htmlStr == 'false')
			{
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> order not updated.</div>');
				
			}
			else
			{
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> order updated.</div>');
				var wareTemp = $('#warehouse_id').val();
				$('#wareTemp').val(wareTemp);
				//window.setTimeout(function(){window.history.back();}, 1500);

			}
			//$('#addCategoryForm').trigger('reset');
		}
	});		
}


function addOrderComment()
{
	var comment = $("#comment").val();
	if(comment!=""){
	$.ajax({
		url: URL +"order/addOrderComment", 
		type: "post", 
		data: "comment="+comment+"&order_id=<?php echo base64_decode($_GET['oid']);?>",   
		dataType: 'json',
		success: function (htmlStr)
		{
			$('#message').html('');
			if(htmlStr.status == 'true')
			{
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Comment added.</div>');	

				var htmlAdd = '<div class="row static-info"><div class="col-md-12 value">'+htmlStr.name+' on Now</div></div><div class="row static-info"><div class="col-md-12">'+comment+'</div></div><hr>';

				$('.comment-row').prepend(htmlAdd);
				$("#comment").val('');
			}
			else
			{
				
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Try again!</strong> Commnet could not be added.</div>');
				$("#comment").val('');

			}
			
		}
	});	
	}else{
		alert('Comment cannot be empty.');
	}	
}


function addRefund()
{
	var refund_amount = $("#refund_amount").val();
	
	$.ajax({
		url: URL +"order/refundAmt", 
		type: "post", 
		data: "refund_amount="+refund_amount+"&order_id=<?php echo base64_decode($_GET['oid']);?>",   
		dataType: 'json',
		success: function (htmlStr)
		{
			
			if(htmlStr.status =="TXN_SUCCESS"){
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> refund added.</div>');
			}else{
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> refund failed.</div>');
			}
		}
	});	

}


function checkWarehouseSelected(){
	var wareTemp = $('#wareTemp').val();
	if(wareTemp == 0){
		alert('You have to select and save the warehouse first.');
		return false;
	}else{
		return true;
	}
}

function goBack(){
    window.setTimeout(function(){window.history.back();});
}

</script>