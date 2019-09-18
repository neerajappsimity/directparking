<style type="text/css">
	.btn-full{
		width: 100% !important;
	}
</style>
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
                            <!-- <a href="<?php echo site_url(); ?>user"> -->
                                <?php echo $pageHeading;?>
                            <!-- </a> -->
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
							<!--div class="actions">
								<a href="<?php echo site_url(); ?>brand/add" class="btn green">
									+ Add Brand
								</a>
								
							</div-->
						</div>
						<div class="portlet-body">
						<div style="float:right; margin-bottom:2%;">
							<form name="searchFORMHEAD" action="javascript:search()" method="post" id="searchFORMHEAD" class="form-inline" role="form">
								<div class="input-group input-large">
									<input type="text" placeholder="Search" class="form-control" id="searchFORMHEAD_input" name="searchFORMHEAD_input">
									<span class="input-group-btn">
									<button type="submit" class="btn blue" type="button">Search
									<i class="m-icon-swapright m-icon-white"></i></button>
									</span>
								</div>
							</form>
						</div>


							<table class="table table-striped table-bordered table-hover" id="sample_2">
							<thead>
							
							<tr>				 				  
						  	<th>SNo.</th>							
							<th>Name</th>							
							<th>Email</th>
							<th>University Name</th>
							<th>Mobile</th>
							<th>Status</th>
							<!-- <th width="10%">Actions</th> -->
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

								<td><?php echo $row['email']; ?></td>
								<td><?php echo $row['university_name']; ?></td>
								<td><?php echo $row['mobile']; ?></td>
								<td><a href="<?php echo site_url(); ?>rating/view?id=<?php echo base64_encode($row['id']); ?>" class="btn default green btn-full"><i class="fa fa-eye"></i> View</a> </td>
								<!--td><?php  if($row['is_verified'] == 'Y'){?>
						<a id="rowIdStatus_<?php echo $row['id']; ?>" href="javascript:void(0)" onclick="changeVerified(<?php echo $row['id']; ?>, 'N')"><button type="button" class="btn btn-success">Verified</button></a>
					<?php }else if($row['is_verified'] == 'N'){?>
						<a id="rowIdStatus_<?php echo $row['id']; ?>" href="javascript:void(0)" onclick="changeVerified(<?php echo $row['id']; ?>, 'Y')"><button type="button" class="btn btn-danger">Not Verified</button></a>
					<?php }else{?>
						<a id="rowIdStatus_<?php echo $row['id']; ?>" href="javascript:void(0)" onclick="changeVerified(<?php echo $row['id']; ?>, 'P')"><button type="button" class="btn btn-primary">Pending</button></a>
					<?php }?>
					</td-->
								<!-- <td>
									<select class="form-control-2 input-small <?php if($row['is_verified'] == 'P'){echo "btn-primary";}else if($row['is_verified'] == 'N'){echo "btn-danger";}else{echo 'btn-success';} ?>" onchange="changeVerified(<?php echo $row['id']; ?>, this.value)">
										<option <?php if($row['is_verified'] == 'P'){echo "selected='selected'";}?> class="btn-primary" value="P">Pending</option>
										<option <?php if($row['is_verified'] == 'Y'){echo "selected='selected'";}?> class="btn-success" value="Y">Verified</option>
										<option <?php if($row['is_verified'] == 'N'){echo "selected='selected'";}?> class="btn-danger" value="N">Not Verified</option>
									</select>
								</td> -->
								
						<!-- 		<td>
						
						<a href="<?php echo site_url(); ?>user/view?id=<?php echo base64_encode($row['id']); ?>" class="btn default green btn-full"><i class="fa fa-eye"></i> View</a>
						<a href="<?php echo site_url(); ?>user/edit?id=<?php echo base64_encode($row['id']); ?>" class="btn default btn-full" style="background:#E8720B;color:#FFF;"><i class="fa fa-pencil"></i> Edit</a>
					
					<?php if($row['enabled'] == 'Y'){?>
						<a id="rowIdStatus_<?php echo $row['id']; ?>" href="javascript:void(0)" onclick="changeStatus(<?php echo $row['id']; ?>, 'N')"><button type="button" class="btn btn-warning btn-full"><i class="fa fa-pencil"></i> Disable</button></a>
					<?php }else{?>
						<a id="rowIdStatus_<?php echo $row['id']; ?>" href="javascript:void(0)" onclick="changeStatus(<?php echo $row['id']; ?>, 'Y')"><button type="button" class="btn btn-primary btn-full"><i class="fa fa-pencil"></i> Enable</button></a>
					<?php }?>

					
						<a href="javascript:void(0)" onclick="deleted(<?php echo $row['id']; ?>)" class="btn default red btn-full"><i class="fa fa-trash-o"></i> Delete</a>
								
								</td> -->
								
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




<script>
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

					  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> University deleted.</div>');
				  }
				  else
				  { 
					  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong> University not deleted.</div>');

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
					   $('#rowIdStatus_'+id).html('<button type="button" class="btn btn-warning"><i class="fa fa-pencil"></i> Disable</button>');
				  	   $('#rowIdStatus_'+id).attr("onclick", "changeStatus("+id+", 'N')");
				  }
				  else
				  {
					  /*$('#rowId_'+gId +'td:nth-child(3) a:nth-child(3)').html('Enable');*/
					  $('#rowIdStatus_'+id).html('<button type="button" class="btn btn-info"><i class="fa fa-pencil"></i> Enable &nbsp;</button>');
					  $('#rowIdStatus_'+id).attr("onclick", "changeStatus("+id+", 'Y')");
				  }
				  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> University status changed.</div>');
			  }
			  else
			  { 
				  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Oops!</strong> University status not changed.</div>');
				  
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
			url: URL +"rating/changeVerified", 
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
				  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Rating status changed.</div>');
			  }
			  else
			  { 
				  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Oops!</strong> Rating status not changed.</div>');
				  
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
if(/^[a-zA-Z0-9- ]*$/.test(search_btn) == false) {
alert('Your search string contains illegal characters.');
}
else{
 window.location.href = window.location.href='<?php echo base_url().'user/'.$pageFunction.'/'; ?>' + $('#searchFORMHEAD_input').val()+ '<?php echo '?'.$_SERVER['QUERY_STRING'];?>';

}
}
</script>

