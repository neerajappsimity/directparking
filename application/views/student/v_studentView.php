
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
								<!-- <div class="actions btn-set">
									<button class="btn default"><i class="fa fa-reply"></i> Cancel</button>
									<button class="btn green"><i class="fa fa-check"></i> Save</button>
								</div> -->
							</div>

							<div class="portlet-body">
							<div class="form-body">
									<div class="form-group">
											<label class="col-md-2 control-label">Student Name:
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
											<?php echo ($userData['university_name']); ?>
											</div>

											
									</div>
									

									
									
						

								<!-- 	<h4><b>Address Details</b></h4>

									

									<div class="form-group">
											<label class="col-md-2 control-label">Address Line 1:
											</label>
											<div class="col-md-4">
											<?php echo ($userData['address_line_1']); ?>
											</div>

											<label class="col-md-2 control-label">Address Line 2:
											</label>
											<div class="col-md-4">
											<?php echo ($userData['address_line_2']); ?>
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-2 control-label">Pincode:
											</label>
											<div class="col-md-10">
											<?php echo ($userData['pincode']); ?>
											</div>
									</div> -->


									<!-- <h4><b>Locations Detail</b></h4>
									<?php if($locationsData){?>
										<?php foreach($locationsData as $locations){?>
										<div class="form-group">
												<label class="col-md-2 control-label">Location Name:
												</label>
												<div class="col-md-2">
												<?php echo ($locations['location_name']); ?>
												</div>

												<label class="col-md-1 control-label">Latitude:
												</label>
												<div class="col-md-2">
												<?php echo ($locations['lat']); ?>
												</div>

												<label class="col-md-2 control-label">Longitude:
												</label>
												<div class="col-md-2">
												<?php echo ($locations['log']); ?>
												</div>
										</div>

									<?php } }else{ ?>
                                               <div class="form-group">
                                               	No Location Found!
                                               </div>
												<?php } ?> -->



									<h4><b>Other Details</b></h4>

									<!--div class="form-group">
											<label class="col-md-2 control-label">User Discount:
											</label>
											<div class="col-md-4">
											<input type="text" name="discount" value="<?php echo $userData['discount']; ?>">
											</div>
									</div-->
									<div class="form-group">
										<label class="col-md-2 control-label">User Status: </label>
										<input type="radio" name="enabled" value="Y" <?php if($userData['enabled'] == 'Y'){echo "checked";} ?> > Enabled 
										<input type="radio" name="enabled" value="N" <?php if($userData['enabled'] == 'N'){echo "checked";} ?>> Disabled
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label">User Verification Status: </label>
										<div class="col-md-4">
										<select  name="is_verified" onchange="reasonChange(this.value);" class="form-control input-medium <?php if($userData['is_verified'] == 'P'){echo "btn-primary";}else if($userData['is_verified'] == 'N'){echo "btn-danger";}else{echo 'btn-success';} ?>">
										<option <?php if($userData['is_verified'] == 'P'){echo "selected='selected'";}?> class="btn-primary" value="P">Pending</option>
										<option <?php if($userData['is_verified'] == 'Y'){echo "selected='selected'";}?> class="btn-success" value="Y">Verified</option>
										<option <?php if($userData['is_verified'] == 'N'){echo "selected='selected'";}?> class="btn-danger" value="N">Not Verified</option>
										</select>
										</div>

										<div class="reasonBox" <?php if($userData['is_verified'] != 'N'){?> style="display:none;" <?php } ?> >
										<label class="col-md-2 control-label">Reason: </label>
										<div class="col-md-4">
										<input name="reason" class="form-control input-medium " value="<?php echo $userData['reason'];?>" >
										</div>
										</div>

									</div>
									<!-- <div class="form-group">
										<label class="col-md-2 control-label"><button type="button" class="btn btn-danger" onclick="resetPassword();">Reset Password</button></label>
									</div> -->
									
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