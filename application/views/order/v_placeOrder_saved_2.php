<style type="text/css">
	.btn-full{
		width: 100% !important;
	}
	.searchHide{
		display: none;
	}
	.placeOrderBox{
		display: none;
	}
</style>
<div id="addPro" class="modal fade" tabindex="-1"  aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Add Product</h4>
										</div>
										<div class="modal-body">
										<form id="addProduct">
											<div class="row">
													<div class="col-md-12">
															<label>Search Product</label>
															<input type="text" class="col-md-12 form-control txt-auto" id="productSearch" name="productSearch">
															<input type="hidden" id="searchProductId" name="searchProductId">
															<input type="hidden" class="user_id" name="userId">
													</div>
											</div>
											<div class="row searchHide">
													<div class="col-md-12">
															<label>Quantity</label>
															<input type="text" class="col-md-12 form-control txt-auto" id="proQuantity" name="proQuantity">
													</div>
											</div>
											<!--div class="row searchHide">
													<div class="col-md-12">
															<label>Price</label>
															<input type="text" class="col-md-12 form-control txt-auto" id="proPrice" name="proPrice">
													</div>
											</div-->
											
										</form>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" onclick="addProduct();" class="btn green">Add Product</button>
										</div>
									</div>
								</div>
</div>

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
                            <a href="<?php echo site_url(); ?>order/placeOrder">
                                <?php echo $pageHeading;?>
                            </a>
                        </li>
                        
                    </ul>
                    
                </div>
        </div>

		<div class="form-group" id="message" style="dispaly:none;"></div>
		<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal form-row-seperated" id="addOrderForm" method='post' enctype="multipart/form-data" action="javascript:placeOrder();">
					
						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-cart-plus"></i> <?php echo $pageHeading;?>
								</div>
								<div class="actions btn-set">
									<button class="btn default" type="button"><i class="fa fa-reply"></i> Cancel</button>
									<button class="btn green btn-place-order"><i class="fa fa-check"></i> Place Order</button>
									<input type="hidden" class="user_id" name="userId">
									<input type="hidden" class="tax_type_id" name="tax_type_id">
								</div>
							</div>

							<div class="portlet-body">
							<div class="form-body">
									<div class="form-group">
											<label class="col-md-2 control-label">Select User: <span class="required">*</span>
											</label>
											<div class="col-md-10">
											<input type="text" class="form-control" id="user" name="user" placeholder="">
											<input type="hidden" class="form-control user_id" id="user_id" name="user_id" placeholder="">
											</div>
									</div>
									
									
							</div>


						<div class="portlet box grey placeOrderBox">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cart-plus"></i>
								Place Order
							</div>

							<div class="actions">
								<a  href="#addPro" onclick="hideSearchInput();" data-toggle="modal" class="btn green">
									+ Add Product
								</a>
								
							</div>
							
						</div>
						<div class="portlet-body">
						<div style="float:right; margin-bottom:2%;">
										
										<div class="input-group date  margin-bottom-5">
											<input type="text" style="width:100% !important;" value="" class="form-control form-filter input-sm date-picker" name="created_date"placeholder="Date" >
											<span class="input-group-btn">
												<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
											</span>
										</div>

						</div>
							<table class="table table-striped table-bordered table-hover" id="sample_2">
							<thead>
							
							<tr>				 				  
							<th>Product Name</th>
							<th>Sku</th>
							<th>Unit Price</th>
							<th>Quantity</th>
							<th>Tax</th>
							<th>Total</th>
							<th width="10%">Actions</th>
				  			</tr>
							</thead>
							<tbody id="addDisBox">
							
							<tr id="noDisProduct">
								<td colspan="7">
									No data found.
								</td>
							</tr>
				
							</tbody>
							<tfoot>
							<tr>
								<th colspan="5">Total Amount</th>
								<th ><input class="totalAmount form-control" name="total_amount" readonly="" value="0"></th>
								<th></th>
							</tr>
							<tr>
								<th colspan="5">Shipping Charges</th>
								<th ><input class="shippingCharges form-control" name="shipping_charges" onkeyup="updateShipping();" value="0"></th>
								<th></th>
							</tr>
							<tr>
								<th colspan="5">Net Amount</th>
								<th ><input class="netAmount form-control" name="net_amount" readonly="" value="0"></th>
								<th></th>
							</tr>
							</tfoot>
							</table>
						</div>
					</div>


					<div class="row placeOrderBox">
											
											<div class="col-md-12 col-sm-12">
												<div class="portlet red box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Shipping Address
														</div>
														
													</div>

													<div class="portlet-body">
														<div class="form-group">
											<label class="col-md-2 control-label">State:
											</label>
											<div class="col-md-4">
											<select name="state_id" id="state_id" class="form-control state_id" required onchange="getCities(this.value);" >
												<option value="">--Select State--</option>
											<?php foreach($states as $state){ ?>
												<option value="<?php echo $state['id'];?>"><?php echo $state['name'];?></option>
											<?php } ?>
											</select>
											</div>

											<label class="col-md-2 control-label">City:
											</label>
											<div class="col-md-4">
											<select name="city_id" id="city_id" required class="form-control" >
												<option value="">--Select State First--</option>
											</select>
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-2 control-label">Address Line 1:
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control" id="address_line_1" required name="address_line_1" placeholder="">
											</div>

											<label class="col-md-2 control-label">Address Line 2:
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control" id="address_line_2"  name="address_line_2" placeholder="">
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-2 control-label">Pincode:
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control" id="pincode"  name="pincode" placeholder="">
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


<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script> 

<script>
 $('.date-picker').datepicker({dateFormat: 'yy-mm-dd'}).datepicker("setDate", "0");;

	$('#user').autocomplete({
		      	source: function( request, response ) {

		      		var dataToSend = 'searchText='+$('#user').val();
		      		$.ajax({
		      			url : URL +"user/autoUserSuggestionList",
		      			dataType: "json",
						data: 
							dataToSend
						  // name_startsWith: request.term,
						   //type: 'country'
						,
				success: function( data ) {
							 response( $.map( data, function( item ) {
							 	//console.log(item.name);
								return {
									label: item.fname+' '+item.lname+' (Mobile:'+item.mobile+', Company:'+item.company+')',
									data: item
								}
							}));
						}
		      		});
		      	},
		      	select: function (event, ui) {
		      		$('.user_id').val(ui.item.data.id);
		      		$('.tax_type_id').val(ui.item.data.tax_type_id);
		      		$('.placeOrderBox').show();

		      		$('.state_id option[value='+ui.item.data.state_id+']').attr('selected','selected');
		      		
		      		$('#address_line_1').val(ui.item.data.address_line_1);
		      		$('#address_line_2').val(ui.item.data.address_line_2);
		      		$('#pincode').val(ui.item.data.pincode);

		      		var htmlStr = '';
					htmlStr ='<option value="">Choose City</option>';
				    $.each(ui.item.data.cities, function(k, v){
				        htmlStr += '<option value='+v.id + '> ' + v.name + '</option>';
				   	});
					$('#city_id').html(htmlStr);
					$('#city_id option[value='+ui.item.data.city_id+']').attr('selected','selected');
		      		
            	},
		      	autoFocus: true,
		      	minLength: 3      	
		      });

	$('#productSearch').autocomplete({
		      	source: function( request, response ) {
		      		var dataToSend = 'searchText='+$('#productSearch').val();
		      		$.ajax({
		      			url : URL +"user/autoSuggestionList",
		      			dataType: "json",
						data: 
							dataToSend
						  // name_startsWith: request.term,
						   //type: 'country'
						,
				success: function( data ) {
							 response( $.map( data, function( item ) {
							 	//console.log(item.name);
								return {
									label: item.name,
									data: item
								}
							}));
						}
		      		});
		      	},
		      	select: function (event, ui) {
		      		$('#searchProductId').val(ui.item.data.id);
		      		//$('#searchProductPrice').val(ui.item.data.sp);
		      		$('.searchHide').show();
            	},
		      	autoFocus: true,
		      	minLength: 3      	
		      });
	

function placeOrder()
{
	var user = $('#user').val();
	$('.btn-place-order').attr('disabled','disabled');

	$('.form-control').removeClass('box-error');
	
	if(user==""){
		$('#user').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please Select user.</div>');
		error = 1;
	}else{

	var form_data = new FormData($("#addOrderForm")[0]);
	console.log(form_data);
	$.ajax({
		url: URL +"order/placeOrder", 
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
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> order could not be placed.</div>');

				$('html').animate({scrollTop:0}, 'slow');//IE, FF
			    $('body').animate({scrollTop:0}, 'slow');//chrome, don't know if Safari works
			}
			else
			{
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> order placed successfully.</div>');
				$('html').animate({scrollTop:0}, 'slow');//IE, FF
			    $('body').animate({scrollTop:0}, 'slow');//chrome, don't know if Safari works

				window.setTimeout(function(){
        					window.location.href='<?php echo base_url().'order'; ?>';
    						}, 1500);

			}
			$('#addOrderForm').trigger('reset');
		}
	});	
	}
}



function addProduct()
{

		var form_data = new FormData($("#addProduct")[0]);
		$.ajax({
		url: URL +"order/getProductDetails", 
		type: "post", 
		data: form_data,     
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function (htmlStr)
			{
				console.log(htmlStr.insert_id);
				var qty = $('#proQuantity').val();
				$('#noDisProduct').hide();
				$('#addProduct').trigger('reset');
				$('#addPro').modal('toggle');

				var count = $('.rowPro').length+1;
				var str = '<tr class="rowPro" id="rowDisId_'+count+'"><td>'+htmlStr.name+'</td><td>'+htmlStr.sku+'</td><td><input type="text" class="form-control unitPrice_'+count+'" name="per_unit_price[]" readonly value="'+htmlStr.price+'" ></td><td><input type="text" name="quantity[]" value="'+qty+'" class="form-control qty_'+count+'" onkeyup="updateQuantity('+count+');"><input type="hidden" class="id _'+count+'" name="id[]" value="'+htmlStr.id+'"><input type="hidden" class="mrp _'+count+'" name="mrp[]" value="'+htmlStr.mrp+'"></td><td><input name="tax[]" type="text" readonly class="form-control tax_'+count+'" value="'+(qty*htmlStr.price_tax)+'"><input name="tax_rate[]" type="hidden" class="taxRate_'+count+'" value="'+htmlStr.price_tax_rate+'"></td><td><input name="proTotal[]" type="text"  class="form-control total_'+count+' proTotal" onkeyup="updateTotal('+count+');" value="'+((qty*htmlStr.price)+(qty*htmlStr.price_tax))+'"></td><td><button type="button" class="btn btn-danger" onclick="deleteProduct('+count+')">Remove</button></td></tr>';

				var tempTotalAmt = parseInt($('.totalAmount').val());
				var proTotal = ((qty*htmlStr.price)+(qty*htmlStr.price_tax));
				var totalAmount = tempTotalAmt+proTotal;
				var shippingCharges = parseInt($('.shippingCharges').val());
				
				$('.totalAmount').val(totalAmount);
				$('.netAmount').val(totalAmount+shippingCharges);

				$('#addDisBox').append(str);
			}
		});
}


function updateQuantity(val){

	var qty = $('.qty_'+val).val();
	var tax = $('.taxRate_'+val).val();
	var unitPrice = $('.unitPrice_'+val).val();
	var proTotal = 0;

	var tempTotal = (((unitPrice*qty)*tax)/100);
	$('.tax_'+val).val(tempTotal);
	$('.total_'+val).val(((unitPrice*qty)+tempTotal));

	$( ".proTotal" ).each(function( index ) {
  			proTotal = proTotal+ parseInt($(this).val());
	});

	var shippingCharges = parseInt($('.shippingCharges').val());
	$('.totalAmount').val(proTotal);
	$('.netAmount').val(proTotal+shippingCharges);

}

function updateTotal(val){

	var qty = parseInt($('.qty_'+val).val());
	var tax = parseFloat($('.taxRate_'+val).val());
	var unitPrice = parseFloat($('.unitPrice_'+val).val());
	var total = parseFloat($('.total_'+val).val());
	var proTotal = 0;

	var tempTotal = ((total*100)/(tax+100));
	//alert(tempTotal);
	var taxValue = total - tempTotal;
	$('.tax_'+val).val(taxValue);
	$('.unitPrice_'+val).val((total-taxValue)/qty);

	$( ".proTotal" ).each(function( index ) {
  			proTotal = proTotal+ parseFloat($(this).val());
	});

	var shippingCharges = parseInt($('.shippingCharges').val());
	$('.totalAmount').val(proTotal);
	$('.netAmount').val(proTotal+shippingCharges);

}

function updateShipping(){
	var shippingCharges = parseInt($('.shippingCharges').val());
	var totalAmount = parseFloat($('.totalAmount').val());

	$('.netAmount').val(totalAmount+shippingCharges);
}



function hideSearchInput(){
		
		$('#addProduct').trigger('reset');
		$('.searchHide').hide();
}


function deleteProduct(val){

		if (confirm("Are you sure, you want to delete?") == true) {
					  	$('#rowDisId_'+val).remove();
					  	var proTotal = 0;
						$( ".proTotal" ).each(function( index ) {
	  						proTotal = proTotal+ parseFloat($(this).html());
						});

						var shippingCharges = parseFloat($('.shippingCharges').val());
						$('.totalAmount').val(proTotal);
						$('.netAmount').val(proTotal+shippingCharges);
		} else {
			return false;
		}	
}


function getCities(sId)
{
	var form_data = "sId="+sId;
	console.log(form_data);
	$.ajax({
		url: URL +"user/getCities", 
		type: "post", 
		data: form_data,
		dataType: 'json',
		success: function (results)
		{
			var htmlStr = '';
			htmlStr ='<option value="">Choose City</option>';
    $.each(results, function(k, v){
        htmlStr += '<option value='+v.id + '> ' + v.name + '</option>';
   });
			$('#city_id').html(htmlStr);
			
		}
	});
}

</script>