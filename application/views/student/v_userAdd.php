<style type="text/css">
	.hideBox{
		display: none;
	}
</style>
	<div class="form-group hideBox" id="row_location">
											<label class="col-md-2 control-label">Location Name:
											</label>
											<div class="col-md-2">
											<input type="text" class="form-control" id="location_name"  name="location_name[]" placeholder="">
											</div>

											<label class="col-md-2 control-label">Latitude:
											</label>
											<div class="col-md-2">
											<input type="text" class="form-control" id="lat"  name="lat[]" placeholder="">
											</div>
											<label class="col-md-2 control-label">Longitude:
											</label>
											<div class="col-md-2">
											<input type="text" class="form-control" id="log"  name="log[]" placeholder="">
											</div>
											
											<!-- <div class="form-group">
												<label class="col-md-10 control-label"></label>
													<input type="button" class="btn btn-success" value="Add Location" onclick="addLocation();">
												</div> -->
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
					<form class="form-horizontal form-row-seperated" id="addUserForm" method='post' enctype="multipart/form-data" action="javascript:addUser();">
					
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
											<input type="text" class="form-control" id="name"  name="name" placeholder="">
											
											</div>
											<label class="col-md-2 control-label">Email:
											</label>
											<div class="col-md-4">
											<input type="email" class="form-control" id="email" name="email" placeholder="" required>
											</div>
									</div>
									<div class="form-group">
											<label class="col-md-2 control-label">Contact Person:
											</label>
											<div class="col-md-4">
											
											<input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="">
											</div>
											<label class="col-md-2 control-label">Mobile:
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control" id="mobile" name="mobile" placeholder="">
											</div>

											
									</div>

									

									

									<!-- <h4><b>Proof Details</b></h4>

									<div class="form-group">
											<label class="col-md-2 control-label">PAN Number:
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control" id="pan_number" name="pan_number" placeholder="">
											</div>

											<label class="col-md-2 control-label">Aadhaar Number:
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control" id="aadhaar_number" name="aadhaar_number" placeholder="">
											
											</div>
									</div> -->
<!-- 
									<div class="form-group">
											<label class="col-md-2 control-label">TIN Number:
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control" id="tin_number" name="tin_number" placeholder="">
											</div>	


											<label class="col-md-2 control-label">GST#:
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control" id="gst" name="gst" placeholder="">
											</div>								
									</div>

									<div class="form-group">
											<label class="col-md-2 control-label">Firm Type:
											</label>
											<div class="col-md-4">
											<select name="firm_id" class="form-control" >
											<?php foreach($firms as $firm){ ?>
												<option value="<?php echo $firm['id'];?>"><?php echo $firm['name'];?></option>
											<?php } ?>
											</select>
											</div>

											<label class="col-md-2 control-label">Retailer Type:
											</label>
											<div class="col-md-4">

											<select name="retailer_id" id="retailer_id" class="form-control" >
												<option value="">--Select User Type First--</option>
											</select>
											
											</div>
									</div> -->

									<h4><b>Address Details</b></h4>

									<div class="form-group">
											<!-- <label class="col-md-2 control-label">State:
											</label>
											<div class="col-md-4">
											<select name="state_id" id="state_id" class="form-control" onchange="getCities(this.value);" >
												<option value="">--Select State--</option>
											<?php foreach($states as $state){ ?>
												<option value="<?php echo $state['id'];?>"><?php echo $state['name'];?></option>
											<?php } ?>
											</select>
											</div>

											<label class="col-md-2 control-label">City:
											</label>
											<div class="col-md-4">
											<select name="city_id" id="city_id"  class="form-control" >
												<option value="">--Select State First--</option>
											</select>
											</div> -->
									</div>

									<div class="form-group">
											<label class="col-md-2 control-label">Address Line 1:
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control" id="address_line_1"  name="address_line_1" placeholder="">
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


									<h4><b>Locations Details</b></h4>

									

									<div class="form-group" id="row_location">
											<label class="col-md-2 control-label">Location Name:
											</label>
											<div class="col-md-2">
											<input type="text" class="form-control" id="location_name"  name="location_name[]" placeholder="">
											</div>

											<label class="col-md-2 control-label">Latitude:
											</label>
											<div class="col-md-2">
											<input type="text" class="form-control" id="lat"  name="lat[]" placeholder="">
											</div>
											<label class="col-md-2 control-label">Longitude:
											</label>
											<div class="col-md-2">
											<input type="text" class="form-control" id="log"  name="log[]" placeholder="">
											</div>
											
									</div>
									<div id="allLocation">

												</div><br>
											<div class="form-group">
												<label class="col-md-10 control-label"></label>
													<input type="button" class="btn btn-success" value="Add Location" onclick="addLocation();">
												</div>
									
 									
									
									<h4><b>Other Details</b></h4>

									<!--div class="form-group">
											<label class="col-md-2 control-label">User Discount:
											</label>
											<div class="col-md-4">
											<input type="text" name="discount" >
											</div>
									</div-->
									<div class="form-group">
										<label class="col-md-2 control-label">User Status: </label>
										<input type="radio" name="enabled" checked="checked"  value="Y" > Enabled 
										<input type="radio" name="enabled" value="N" > Disabled
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label">User Verification Status: </label>
										<select  name="is_verified" class="form-control-2 input-medium <?php if($userData['is_verified'] == 'P'){echo "btn-primary";}else if($userData['is_verified'] == 'N'){echo "btn-danger";}else{echo 'btn-success';} ?>">
										<option class="btn-primary" value="P">Pending</option>
										<option class="btn-success" value="Y">Verified</option>
										<option class="btn-danger" value="N">Not Verified</option>
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
	
function addUser()
{
	var user_type = $('#user_type_id').val();
	var name = $('#name').val();
	var email = $('#email').val();
	var mobile = $('#mobile').val();
	
	/*var retailer_id = $('#retailer_id').val();
	var state_id = $('#state_id').val();
	var city_id = $('#city_id').val();*/

	$('.form-control').removeClass('box-error');
	var mobileError = 0;

	if(mobile != ""){

		var form_data = "mobile="+mobile;
		$.ajax({
		url: URL +"user/checkMobile", 
		type: "post", 
		data: form_data,
		dataType: 'json',     
		//cache: false,
		//contentType: false,
		//processData: false,
		async: false,
		success: function (htmlStr)
		{
			$('#message').html('');
			console.log(htmlStr.status);
			if(htmlStr.status == 'true')
			{
				
				mobileError = 1;
			}
		}
		});

	}

	if(name == ""){

		$('#name').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Oops!</strong> Please enter university name.</div>');

	}else if(email == ""){

		$('#email').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Oops!</strong> Please enter email.</div>');

	}
	else if(mobile == ""){

		$('#mobile').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Oops!</strong> Please enter mobile number.</div>');

	}else if(mobileError == 1){

		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Oops!</strong> Mobile number already exists.</div>');

	}/*else if(state_id == ""){

		$('#state_id').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please select state.</div>');

	}else if(city_id == ""){

		$('#city_id').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please select city.</div>');

	}*/else{

		var form_data = new FormData($("#addUserForm")[0]);
		$.ajax({
		url: URL +"user/add", 
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
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> user could not be added.</div>');
			}
			else
			{
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> user added successfully.</div>');
				//window.setTimeout(function(){window.history.back();}, 1500);

			}
				//$('#addCategoryForm').trigger('reset');
		}
		});

		$('#addUserForm').trigger('reset');
	}		
}

function goBack(){
    window.setTimeout(function(){window.history.back();}, 1500);
}



function addLocation(){
	//alert('dasdsa');
	var cloneData = $('.hideBox').clone();
	cloneData.removeClass('hideBox');
	$('#allLocation').append(cloneData);
}
</script>