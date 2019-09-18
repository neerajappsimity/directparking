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
                            <a href="<?php echo site_url(); ?>report/orders">
                                <?php echo $pageHeading;?>
                            </a>
                        </li>
                        
                    </ul>
                    
                </div>
            </div>

		
	
		
		
		<div class="row">
		<div class="col-lg-12 margin-upper">
<div class="all_panels">
<div class="table_data" aria-labelledby="headingOne" role="tabpanel" id="chat">
	
	<div class="form-group" id="message" style="dispaly:none;"></div>

	<div class="portlet box grey">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-shopping-cart"></i>
								<?php echo $pageHeading;?>
							</div>
							
						</div>
						<div class="portlet-body">
						<div>
							<form name="searchFORMHEAD" action="javascript:search()" method="post" id="searchFORMHEAD" class="form-inline" role="form">
								<!--div class="input-group input-large">
									<input type="text" placeholder="Search" class="form-control" id="searchFORMHEAD_input" name="searchFORMHEAD_input">
									<span class="input-group-btn">
									<button type="submit" class="btn blue" type="button">Search
									<i class="m-icon-swapright m-icon-white"></i></button>
									</span>
								</div-->
								<div class="table-container">
								
								<table class="table table-striped table-bordered table-hover" id="datatable_orders">
								<thead>
								<tr role="row" class="heading">
									
									
									<th width="20%">
										 Purchased&nbsp;On
									</th>
									
									<!--th width="15%">
										 Ship&nbsp;To
									</th-->
									
									<th width="15%">
										 Status
									</th>
									<th width="10%">
										 Actions
									</th>
								</tr>
								<tr role="row" class="filter">
									
										<input type="hidden" class="form-control form-filter input-sm" id="searchFORMHEAD_input" name="order_id">
									
									<td>
										<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
											<input type="text" class="form-control form-filter input-sm" readonly name="order_date_from"  id="order_date_from" placeholder="From">
											<span class="input-group-btn">
												<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
											</span>
										</div>
										<div class="input-group date date-picker" data-date-format="dd/mm/yyyy">
											<input type="text" class="form-control form-filter input-sm" readonly name="order_date_to" id="order_date_to" placeholder="To">
											<span class="input-group-btn">
												<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
											</span>
										</div>
									</td>
									<!--td>
										<input type="text" class="form-control form-filter input-sm" id="ship_to" name="order_ship_to">
									</td-->
									
									<td>
										<select name="order_status" class="form-control input-lg" id="order_status">
										<option value="">Select</option>
										<?php foreach($orderStatus as $os){?>
										<option value="<?php echo $os['id'];?>"><?php echo $os['order_status'];?></option>
										<?php } ?>
										</select>
									</td>
									<td>
										<div class="margin-bottom-5">
											<button class="btn btn-sm yellow filter-submit margin-bottom"><i class="fa fa-search"></i> Search</button>
										</div>
										 <a href="<?php echo site_url(); ?>report/orders" class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i> Reset</a>
									</td>
								</tr>
								</thead>
								<tbody>
								</tbody>
								</table>
							</div>
							</form>
						</div>


							<table class="table table-striped table-bordered table-hover" id="sample_2">
							<thead>
							
							<tr>				 				  
						  	<th>SNo.</th>
							<th>Order ID</th>
							<th>Customer</th>
							<th>Company</th>
							<th>Delivery Address</th>
							<th>Payment Method</th>
							<th>Net Amount</th>
							<th>Status</th>
							<th>Created</th>
							
				  			</tr>
							</thead>
							<tbody>
							<?php

							if(!empty($orders))
							{

									foreach($orders as $row)
									{

							?>
							<tr class="odd gradeX"  id="rowId_<?php echo $row['id']; ?>">
								<td><?php echo ++$startPage; ?></td>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['fname'].' '.$row['lname']; ?></td>
								<td><?php echo $row['company']; ?></td>
								<td><?php echo $row['delivery_address_1'].', '.$row['delivery_address_2']; ?></td>
								<td>Rs. <?php echo $row['payment_method']; ?></td>
								<td><?php echo $row['net_amount']; ?></td>
								<td><?php echo $row['order_status']; ?>
								<!--select>
								<?php foreach($orderStatus as $os){?>
								<option <?php if($os['id'] == $row['status_id']){echo "selected='selected'";} ?> value="<?php echo $os['id'];?>"><?php echo $os['order_status'];?></option>
								<?php } ?>
								</select-->

								</td>
								<td><?php echo $row['created_date']; ?></td>
								
								
							</tr>
			<?php } }else{?>
			<tr>
				<td colspan="2">
					No data found.
				</td>
			</tr>
			<?php }?>				
							</tbody>
							</table>
						</div>
					</div>



</div>
</div>
</div>

		<?php if(!empty($pagination)){
echo '<div class="col-md-12 col-sm-12 col-xs-12  blog_pagination">';
	echo '<nav><ul class="pagination"><li>';
		echo $pagination;
	echo '</li></ul></nav>';
echo '</div>';
}  ?>	
		</div>	
			
		
		
</div>
</div>



<script src="<?php echo site_url(); ?>assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script>
 $('.date-picker').datepicker();
	
	function deleted(id)
	{
		var dataToSend = "id="+id;
		if (confirm("Are you sure, you want to delete?") == true) {
			
			$.ajax({
				url: URL +"order/deleted", 
				type: "post", 
				data: dataToSend,     
				cache: false,
				success: function(data) {
				console.log(data);
				  if(data == 'true')
				  {
					  $('#rowId_'+id).hide();

					  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Order deleted.</div>');
				  }
				  else
				  { 
					  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong> Order not deleted.</div>');

				  }
			  },
			  error: function(e) {
				//called when there is an error
				//console.log(e.message);
			  }
			});
		} else {
			return false;
		}
		
		
	}
	
	function changeStatus(id, status)
	{
		var dataToSend = "id="+id+"&status="+status;
		$.ajax({
			url: URL +"order/changeStatus", 
		  	type: "post", 
		  	data: dataToSend,     
		  	cache: false,
		    success: function(data) {
			console.log(data);
			  if(data == 'true')
			  {
				  if(status == '1')
				  { 
					  /*$('#rowId_'+gId +'td:nth-child(3) a:nth-child(3)').html('Disable');*/ 
					   $('#rowIdStatus_'+id).html('<button type="button" class="btn btn-primary">Pending</button>');
				  	   $('#rowIdStatus_'+id).attr("onclick", "changeStatus("+id+", '2')");
				  	    $('#message').html('<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Pending!</strong> order status changed.</div>');
				  }else if(status == '2')
				  { 
					  /*$('#rowId_'+gId +'td:nth-child(3) a:nth-child(3)').html('Disable');*/ 
					   $('#rowIdStatus_'+id).html('<button type="button" class="btn btn-warning">Ready</button>');
				  	   $('#rowIdStatus_'+id).attr("onclick", "changeStatus("+id+", '3')");
				  	    $('#message').html('<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Ready!</strong> order status changed.</div>');
				  }
				  else if(status == '3')
				  {
					  /*$('#rowId_'+gId +'td:nth-child(3) a:nth-child(3)').html('Enable');*/
					  $('#rowIdStatus_'+id).html('<button type="button" class="btn btn-success">Delivered</button>');
					  $('#rowIdStatus_'+id).attr("onclick", "changeStatus("+id+", '1')");
					   $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> order status changed.</div>');
				  }
				 
			  }
			  else
			  { 
				  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> order status not changed.</div>');
				  
			  }
		  },
		  error: function(e) {
			//called when there is an error
			//console.log(e.message);
		  }
		});
		
	}
	
</script>	
<script>
function search() {
	var search_btn = $('#searchFORMHEAD_input').val();
	var order_date_from = $('#order_date_from').val();
	var order_date_to = $('#order_date_to').val();
	var order_status = $('#order_status').val();
	//var ship_to = $('#ship_to').val();
if(/^[a-zA-Z0-9- ]*$/.test(search_btn) == false) {
alert('Your search string contains illegal characters.');
}
else{
	
window.location.href = window.location.href='<?php echo base_url().'report/orders/'; ?>' + $('#searchFORMHEAD_input').val()+'?order_date_from='+order_date_from+'&order_date_to='+order_date_to+'&order_status='+order_status;
 	
}
}

</script>

