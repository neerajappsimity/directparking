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
                            <a href="<?php echo site_url(); ?>report/users">
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
								<i class="fa fa-user"></i>
								<?php echo $pageHeading;?>
							</div>

							<a class="pull-right btn blue" href="<?php site_url(); ?>reports/exportData"   onclick="exportData()" id="exportuserData"> Export</a>

							
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
										  Created&nbsp;From
									</th>
									<th width="20%">
										  Created&nbsp;To
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
											<input type="text" class="form-control form-filter input-sm" readonly name="date_from"  id="date_from" placeholder="From">
											<span class="input-group-btn">
												<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
											</span>
										</div>
									</td>
									<td>
										
										<div class="input-group date date-picker" data-date-format="dd/mm/yyyy">
											<input type="text" class="form-control form-filter input-sm" readonly name="date_to" id="date_to" placeholder="To">
											<span class="input-group-btn">
												<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
											</span>
										</div>
									</td>
									<!--td>
										<input type="text" class="form-control form-filter input-sm" id="ship_to" name="order_ship_to">
									</td-->
									
									<td>
										<select class="form-control-2 input-medium" id="status" name="status">
										<option value="">Select ...</option>
										<option value="P">Pending</option>
										<option value="Y">Verified</option>
										<option value="N">Not Verified</option>
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
						  	<th>Student Name</th>
							<th>University Name</th>
							
							<th>Email</th>
							
							<th>Mobile</th>
							<th>Verify Status</th>
				  			</tr>
							</thead>
							<tbody>
							<?php

							if(!empty($users))
							{
								
									foreach($users as $row)
									{

							?>
							<tr class="odd gradeX"  id="rowId_<?php echo $row['id']; ?>">
								<td><?php echo ++$startPage; ?></td>
								<td><?php echo $row['fname']; ?></td>								
								<td><?php echo $row['university_name']; ?></td>

								<td><?php echo $row['email']; ?></td>
								
								<td><?php echo $row['mobile']; ?></td>
								<td>
									<?php if($row['is_verified'] == 'P'){ ?>
											<div class="btn-danger">&nbsp;&nbsp; Pending</div>

									<?php } elseif($row['is_verified'] == 'Y'){ ?>
										<div class="btn-success">&nbsp;&nbsp; Verified</div>
									<?php } ?>
									
								</td>
								
							</tr>
			<?php } }else{?>
			<tr>
				<td colspan="7">
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
				url: URL +"user/deleted", 
				type: "post", 
				data: dataToSend,     
				cache: false,
				success: function(data) {
				console.log(data);
				  if(data == 'true')
				  {
					  $('#rowId_'+id).hide();

					  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> User deleted.</div>');
				  }
				  else
				  { 
					  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong> User not deleted.</div>');

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
	
	function changeStatus(id, enabled)
	{
		var dataToSend = "id="+id+"&enabled="+enabled;
		$.ajax({
			url: URL +"user/changeStatus", 
		  	type: "post", 
		  	data: dataToSend,     
		  	cache: false,
		    success: function(data) {
			console.log(data);
			  if(data == 'true')
			  {
				  if(enabled == 'Y')
				  { 
					  /*$('#rowId_'+gId +'td:nth-child(3) a:nth-child(3)').html('Disable');*/ 
					   $('#rowIdStatus_'+id).html('<button type="button" class="btn btn-warning">Disable</button>');
				  	   $('#rowIdStatus_'+id).attr("onclick", "changeStatus("+id+", 'N')");
				  }
				  else
				  {
					  /*$('#rowId_'+gId +'td:nth-child(3) a:nth-child(3)').html('Enable');*/
					  $('#rowIdStatus_'+id).html('<button type="button" class="btn btn-info">Enable</button>');
					  $('#rowIdStatus_'+id).attr("onclick", "changeStatus("+id+", 'Y')");
				  }
				  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> user status changed.</div>');
			  }
			  else
			  { 
				  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> user status not changed.</div>');
				  
			  }
		  },
		  error: function(e) {
			//called when there is an error
			//console.log(e.message);
		  }
		});
		
	}


	function changeVerified(id, enabled)
	{

		var dataToSend = "id="+id+"&is_verified="+enabled;
		$.ajax({
			url: URL +"user/changeVerified", 
		  	type: "post", 
		  	data: dataToSend,     
		  	cache: false,
		    success: function(data) {
			console.log(data);
			  if(data == 'true')
			  {
				  if(enabled == 'Y')
				  { 
					  /*$('#rowId_'+gId +'td:nth-child(3) a:nth-child(3)').html('Disable');*/ 
					   $('#rowIdStatus_'+id).html('<button type="button" class="btn btn-warning">Disable</button>');
				  	   $('#rowIdStatus_'+id).attr("onclick", "changeStatus("+id+", 'N')");
				  }
				  else
				  {
					  /*$('#rowId_'+gId +'td:nth-child(3) a:nth-child(3)').html('Enable');*/
					  $('#rowIdStatus_'+id).html('<button type="button" class="btn btn-info">Enable</button>');
					  $('#rowIdStatus_'+id).attr("onclick", "changeStatus("+id+", 'Y')");
				  }
				  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> user status changed.</div>');
			  }
			  else
			  { 
				  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> user status not changed.</div>');
				  
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
	var date_from = $('#date_from').val();
	var date_to = $('#date_to').val();
	var status = $('#status').val();

if(/^[a-zA-Z0-9- ]*$/.test(search_btn) == false) {
alert('Your search string contains illegal characters.');
}
else{

window.location.href = window.location.href='<?php echo base_url().'report/users/'; ?>' + $('#searchFORMHEAD_input').val()+'?date_from='+date_from+'&date_to='+date_to+'&status='+status;

}
}

 			function exportData() {
                //alert('hello');
                var action = 'exportData';
                var date_from = '<?php if(isset($_GET)&& !empty($_GET['date_from'])) {echo $_GET['date_from'];} else { echo ''; } ?>';
                var date_to = '<?php if(isset($_GET)&& !empty($_GET['date_to'])) { echo $_GET['date_to'];} else { echo ''; } ?>';
                var status = '<?php if(isset($_GET)&& !empty($_GET['status'])) { echo $_GET['status']; } else { echo ''; } ?>';

                $("#exportuserData").prop("href", URL+'reports/exportData?date_from='+date_from+'&date_to='+date_to+'&status='+status);

              }
</script>

