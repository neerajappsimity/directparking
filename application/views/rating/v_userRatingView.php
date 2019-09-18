
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
                            <!-- <a href="<?php echo site_url(); ?>brand"> -->
                                <?php echo $pageHeading;?>
                            <!-- </a> -->
                        </li>
                        
                    </ul>
                    
                </div>
            </div>

		<div class="form-group" id="message" style="dispaly:none;"></div>
		<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal form-row-seperated" id="editUserForm" method='post' enctype="multipart/form-data" action="javascript:viewUser();">
					
						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-user"></i> <?php echo $pageHeading;?>
								</div>
								<div class="actions btn-set" style="font-family: bold;font-size: 23px;">
									<?php if(!empty($rating['rating'])){
											echo ($rating['rating'])." *" ;
									}else{
										echo "0" ;
									}


									?>
									
								</div>
							</div>

							<div class="portlet-body">
							<div class="form-body">
									<div class="form-group">
											<label class="col-md-2 control-label">Name:
											</label>
											<div class="col-md-4">
											<?php echo ucfirst($userData['fname']); ?>
											</div>

											<label class="col-md-2 control-label">Email:
											</label>
											<div class="col-md-4">
											<?php echo ($userData['email']); ?>
											</div>
									</div>
									<div class="form-group">
											<label class="col-md-2 control-label">Mobile:
											</label>
											<div class="col-md-4">
											<?php echo ($userData['mobile']); ?>
											</div>

											<label class="col-md-2 control-label">University Name:
											</label>
											<div class="col-md-4">
											<?php echo ($userData['university']); ?>
											</div>

											
									</div>
									

									
									
						

									<h4><b>Rating Details</b></h4>

									

							<table class="table table-striped table-bordered table-hover" id="sample_2">
							<thead>
							
							<tr>				 				  
						  	<th>SNo.</th>							
							<th>Name</th>							
							<th>Email</th>							
							<th>Mobile</th>
							<th>Rating</th>
							<th>Comment</th>
							<th>Status</th>
							<!-- <th width="10%">Actions</th> -->
				  			</tr>
							</thead>
							<tbody>
							<?php

							if(!empty($userRating))
							{
									$startPage=0;
									foreach($userRating as $row)
									{

							?>
							<tr class="odd gradeX"  id="rowId_<?php echo $row['id']; ?>">
								<td><?php echo ++$startPage; ?></td>								
								<td><?php echo $row['user_name']; ?></td>

								<td><?php echo $row['email']; ?></td>
								<td><?php echo $row['mobile']; ?></td>
								<td><?php echo $row['rating']; ?></td>
								<td><?php echo $row['comment']; ?></td>
								<!-- <td><a href="<?php echo site_url(); ?>rating/view?id=<?php echo base64_encode($row['id']); ?>" class="btn default green btn-full"><i class="fa fa-eye"></i> View</a> </td> -->
								<!--td><?php  if($row['is_verified'] == 'Y'){?>
						<a id="rowIdStatus_<?php echo $row['id']; ?>" href="javascript:void(0)" onclick="changeVerified(<?php echo $row['id']; ?>, 'N')"><button type="button" class="btn btn-success">Verified</button></a>
					<?php }else if($row['is_verified'] == 'N'){?>
						<a id="rowIdStatus_<?php echo $row['id']; ?>" href="javascript:void(0)" onclick="changeVerified(<?php echo $row['id']; ?>, 'Y')"><button type="button" class="btn btn-danger">Not Verified</button></a>
					<?php }else{?>
						<a id="rowIdStatus_<?php echo $row['id']; ?>" href="javascript:void(0)" onclick="changeVerified(<?php echo $row['id']; ?>, 'P')"><button type="button" class="btn btn-primary">Pending</button></a>
					<?php }?>
					</td-->
								<td>
									<select class="form-control-2 input-small <?php if($row['is_verified'] == 'P'){echo "btn-primary";}else if($row['is_verified'] == 'N'){echo "btn-danger";}else{echo 'btn-success';} ?>" onchange="changeVerified(<?php echo $row['id']; ?>, this.value)">
										<option <?php if($row['is_verified'] == 'P'){echo "selected='selected'";}?> class="btn-primary" value="P">Pending</option>
										<option <?php if($row['is_verified'] == 'Y'){echo "selected='selected'";}?> class="btn-success" value="Y">Verified</option>
										<option <?php if($row['is_verified'] == 'N'){echo "selected='selected'";}?> class="btn-danger" value="N">Not Verified</option>
									</select>
								</td>
								
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
					</form>
				</div>
				</div>





		
	</div><!--wrapper_inner close -->
</div>	
<script src="<?php echo site_url(); ?>assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>

<script>
/*jQuery(document).ready(function() { 
if (jQuery(".fancybox-button").size() > 0) {
            jQuery(".fancybox-button").fancybox({
                groupAttr: 'data-rel',
                prevEffect: 'none',
                nextEffect: 'none',
                closeBtn: true,
                helpers: {
                    title: {
                        type: 'inside'
                    }
                }
            });
}
});*/

function reasonChange(val){

	if(val=='N'){
		$('.reasonBox').show();
	}else{
		$('.reasonBox').hide();
	}

}


function viewUser()
{
	
	var form_data = new FormData($("#editUserForm")[0]);
	console.log(form_data);
	$.ajax({
		url: URL +"user/view", 
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
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> user not updated.</div>');
			}
			else
			{
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> user updated.</div>');
				//window.setTimeout(function(){window.history.back();}, 1500);

			}
			//$('#addCategoryForm').trigger('reset');
		}
	});		

}


function resetPassword()
{
	if (confirm("Are you sure, you want to reset the user password?") == true) {
	var form_data = new FormData($("#editUserForm")[0]);
	console.log(form_data);
	$.ajax({
		url: URL +"user/resetPassword", 
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
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> user could not be reset.</div>');
			}
			else
			{
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> user password reseted successfully.</div>');
				//window.setTimeout(function(){window.history.back();}, 1500);

			}
			//$('#addCategoryForm').trigger('reset');
		}
	});	
	}	
}

function goBack(){
    window.setTimeout(function(){window.history.back();}, 1500);
}
</script>
<script>
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
				// window.setTimeout(function(){window.history.back();}, 1500); 
				setInterval('window.location.reload()', 1000);
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