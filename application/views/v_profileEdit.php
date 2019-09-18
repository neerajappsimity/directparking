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
                            <a href="<?php echo site_url(); ?>category">
                                <?php echo $pageHeading;?>
                            </a>
                        </li>
                        
                    </ul>
                    
                </div>
            </div>

		<div class="form-group" id="message" style="dispaly:none;"></div>
		<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal form-row-seperated" id="editProfileForm" method='post' enctype="multipart/form-data" action="javascript:editProfile();">
					
						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-user"></i> <?php echo $pageHeading;?>
								</div>
								<div class="actions btn-set">
									<!-- <a href="<?php site_url();?>/user"><button class="btn default"><i class="fa fa-reply"></i> Cancel</button></a> -->
									<button class="btn green"><i class="fa fa-check"></i> Save</button>
									
								</div>
							</div>

							<div class="portlet-body">
							<div class="form-body">
									<div class="form-group">
											<label class="col-md-2 control-label">Name: <span class="required">*</span>
											</label>
											<div class="col-md-10">
											<input type="text" class="form-control" value="<?php echo $userData['fname']; ?>" name="fname" placeholder="" required>
											
											</div>
									</div>


									<div class="form-group">
											<label class="col-md-2 control-label">User Name: <span class="required">*</span>
											</label>
											<div class="col-md-10">
											<input type="text" class="form-control" value="<?php echo $userData['username']; ?>" name="username" placeholder="" required>
											
											</div>
									</div>


									<div class="form-group">
											<label class="col-md-2 control-label">Email: <span class="required">*</span>
											</label>
											<div class="col-md-10">
											<input type="text" class="form-control" value="<?php echo $userData['email']; ?>" name="email" placeholder="" required>
											
											</div>
									</div>


									<div class="form-group">
											<label class="col-md-2 control-label">Password:
											</label>
											<div class="col-md-10">
											<input type="password" class="form-control" value="" name="password" placeholder="">
											
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

<script>
	
function editProfile()
{
	var form_data = new FormData($("#editProfileForm")[0]);
	console.log(form_data);
	$.ajax({
		url: URL +"welcome/editProfile", 
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
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> profile not updated.</div>');
			}
			else
			{
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> profile updated.</div>');

			}
			//$('#addCategoryForm').trigger('reset');
		}
	});		
}

function goBack(){
    window.setTimeout(function(){window.history.back();}, 1500);
}
</script>