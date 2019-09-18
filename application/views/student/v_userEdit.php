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
                            <a href="<?php echo site_url(); ?>brand">
                                <?php echo $pageHeading;?>
                            </a>
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
								<div class="actions btn-set">
									<button class="btn default"><i class="fa fa-reply"></i> Cancel</button>
									<button class="btn green"><i class="fa fa-check"></i> Save</button>
									
								</div>
							</div>

							<div class="portlet-body">
							<div class="form-body">
									

									<div class="form-group">
											<label class="col-md-2 control-label">University Name:
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control" id="university" value="<?php echo ucfirst($userData['university']); ?>" name="university" placeholder="">
											
											</div>

											<label class="col-md-2 control-label">Contact Person:
											</label>
											<div class="col-md-4">
											
											<input type="text" class="form-control" id="contact_person" value="<?php echo ucfirst($userData['contact_person']); ?>" name="contact_person" placeholder="">
											<?php $id= base64_decode($_REQUEST['id']);?>
											<input type="hidden" name="id" value="<?php echo $id; ?>">
											</div>
									</div>
									

									

									<div class="form-group">
											<label class="col-md-2 control-label">Mobile:
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control" id="mobile" value="<?php echo ($userData['mobile']); ?>" name="mobile" placeholder="" >
											</div>

											<label class="col-md-2 control-label">Email:
											</label>
											<div class="col-md-4">
											<input type="email" class="form-control" id="email" value="<?php echo ($userData['email']); ?>" name="email" placeholder="" required>
											</div>
									</div>

									

									


									<h4><b>Address Details</b></h4>

								

									<div class="form-group">
											<label class="col-md-2 control-label">Address Line 1:
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control" id="address_line_1" value="<?php echo ($userData['address_line_1']); ?>" name="address_line_1" placeholder="">
											</div>

											<label class="col-md-2 control-label">Address Line 2:
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control" id="address_line_2" value="<?php echo ($userData['address_line_2']); ?>" name="address_line_2" placeholder="">
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-2 control-label">Pincode:
											</label>
											<div class="col-md-10">
											<input type="text" class="form-control" id="pincode" value="<?php echo ($userData['pincode']); ?>" name="pincode" placeholder="">
											</div>
									</div>

											<h4><b>Locations Detail</b></h4>
									<?php if($locationsData){?>
										<?php foreach($locationsData as $locations){?>
										<div class="form-group">
												<label class="col-md-2 control-label">Location Name:
												</label>
												<div class="col-md-2">
												<input type="text" class="form-control" id="location_name" value="<?php echo ($locations['location_name']); ?>" name="location_name[]" placeholder="location Name">
												<?php //echo ($locations['location_name']); ?>
												</div>

												<label class="col-md-1 control-label">Latitude:
												</label>
												<div class="col-md-2">
												<input type="text" class="form-control" id="lat" value="<?php echo ($locations['lat']); ?>" name="lat[]" placeholder="lat">
												<?php //echo ($locations['lat']); ?>
												</div>

												<label class="col-md-2 control-label">Longitude:
												</label>
												<div class="col-md-2">
												<input type="text" class="form-control" id="log" value="<?php echo ($locations['log']); ?>" name="log[]" placeholder="log">
												<?php //echo ($locations['log']); ?>
												</div>
										</div>

									<?php } }else{ ?>
                                               <div class="form-group">
                                               	No Location Found!
                                               </div>
												<?php } ?>
									

									
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
										<select  name="is_verified" class="form-control-2 input-medium <?php if($userData['is_verified'] == 'P'){echo "btn-primary";}else if($userData['is_verified'] == 'N'){echo "btn-danger";}else{echo 'btn-success';} ?>">
										<option <?php if($userData['is_verified'] == 'P'){echo "selected='selected'";}?> class="btn-primary" value="P">Pending</option>
										<option <?php if($userData['is_verified'] == 'Y'){echo "selected='selected'";}?> class="btn-success" value="Y">Verified</option>
										<option <?php if($userData['is_verified'] == 'N'){echo "selected='selected'";}?> class="btn-danger" value="N">Not Verified</option>
										</select>
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


function getShipCities(sId)
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
			$('#ship_city_id').html(htmlStr);
			
		}
	});
}


function getRetailType(id)
{
	var form_data = "id="+id;
	$.ajax({
		url: URL +"user/getRetailType", 
		type: "post", 
		data: form_data,
		dataType: 'json',
		success: function (results)
		{
			var htmlStr = '';
			htmlStr ='<option value="">Choose Retail Type</option>';
    $.each(results, function(k, v){
        htmlStr += '<option value='+v.id + '> ' + v.name + '</option>';
   });
			$('#retailer_id').html(htmlStr);
			
		}
	});
}
	

	
function viewUser()
{
	var form_data = new FormData($("#editUserForm")[0]);
	console.log(form_data);
	$.ajax({
		url: URL +"user/edit", 
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
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> university not updated.</div>');
			}
			else
			{
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> university updated.</div>');
				//window.setTimeout(function(){window.history.back();}, 1500);

			}
			//$('#addCategoryForm').trigger('reset');
		}
	});		
}

function goBack(){
    window.setTimeout(function(){window.history.back();}, 1500);
}
</script>