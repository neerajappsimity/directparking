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
					<form class="form-horizontal form-row-seperated" id="editCouponForm" method='post' enctype="multipart/form-data" action="javascript:editCoupon();">
					
						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-ticket"></i> <?php echo $pageHeading;?>
								</div>
								<div class="actions btn-set">
									<button class="btn default"><i class="fa fa-reply"></i> Cancel</button>
									<button class="btn green"><i class="fa fa-check"></i> Save</button>
									
								</div>
							</div>

							<div class="portlet-body">
							<div class="form-body">
									<div class="form-group">
											<label class="col-md-2 control-label">Name: <span class="required">*</span>
											</label>
											<div class="col-md-10">
											<input type="text" id="name" class="form-control" value="<?php echo $couponData['name']; ?>" name="name" placeholder="">
											<input type="hidden" name="id" value="<?php echo $couponData['id']; ?>">
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-2 control-label">Code: <span class="required">*</span>
											</label>
											<div class="col-md-10">
											<input type="text" class="form-control" value="<?php echo $couponData['code']; ?>" id="code" name="code" placeholder="">
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-2 control-label">Value: <span class="required">*</span>
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control"  value="<?php echo $couponData['coupon_value']; ?>" id="coupon_value" name="coupon_value" placeholder="">
											</div>

											<label class="col-md-2 control-label">Value Type:
											</label>
											<div class="col-md-4">
											<input type="radio" <?php if($couponData['value_type'] =='P'){echo 'checked="checked"';}?> name="value_type" value="P"> Percent
											<input type="radio" <?php if($couponData['value_type'] =='F'){echo 'checked="checked"';}?> name="value_type" value="F"> Flat
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-2 control-label" >Start Date: <span class="required">*</span>
											</label>
											<div class="col-md-4">
											<input type="text"  value="<?php echo $couponData['date_from']; ?>" class="form-control date date-picker" data-date-format="yyyy-mm-dd" id="date_from" name="date_from" placeholder="">
											</div>


											<label class="col-md-2 control-label">Expiry Date: <span class="required">*</span>
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control date date-picker" value="<?php echo $couponData['date_to']; ?>" data-date-format="yyyy-mm-dd" id="date_to" name="date_to" placeholder="">
											</div>
									</div>


									<!--div class="form-group">
											<label class="col-md-2 control-label">Applicable To: <span class="required">*</span>
											</label>
											<div class="col-md-10">
											<select name="all_user" id="all_user" class="form-control">
												<option value="">Select ...</option>
												<option <?php if($couponData['all_user'] =='Y'){echo 'selected="selected"';}?> value="Y">All Users</option>
												<option <?php if($couponData['all_user'] =='N'){echo 'selected="selected"';}?> value="N">Particular Users</option>
											</select>
											</div>
									</div-->

									<div class="form-group">
											<label class="col-md-2 control-label">Usability: <span class="required">*</span>
											</label>
											<div class="col-md-10">
											<!--select name="is_multiple" id="is_multiple" class="form-control">
												<option value="">Select ...</option>
												<option <?php if($couponData['is_multiple'] =='Y'){echo 'selected="selected"';}?> value="Y">Single Time</option>
												<option <?php if($couponData['is_multiple'] =='N'){echo 'selected="selected"';}?> value="N">Multiple Times</option>
											</select-->
											<input type="radio" <?php if($couponData['is_multiple'] =='N'){echo 'checked="checked"';}?> name="is_multiple" value="N"> Single Time
											<input type="radio" <?php if($couponData['is_multiple'] =='Y'){echo 'checked="checked"';}?> name="is_multiple" value="Y"> Multiple Times
											</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-2 control-label">Coupon Status: </label>
										<input type="radio" <?php if($couponData['enabled'] == 'Y'){echo "checked";}?> name="enabled" value="Y" > Enabled 
										<input type="radio" <?php if($couponData['enabled'] == 'N'){echo "checked";}?> name="enabled" value="N"> Disabled
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
	
function editCoupon()
{
	var name = $('#name').val();
	var code = $('#code').val();
	var coupon_value = $('#coupon_value').val();
	var date_to = $('#date_to').val();
	var date_from = $('#date_from').val();
	//var all_user = $('#all_user').val();
	//var is_multiple = $('#is_multiple').val();

	$('.form-control').removeClass('box-error');
	
	if(name==""){
		$('#name').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please enter coupon name.</div>');
		error = 1;
	}else if(code==""){
		$('#code').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please enter code.</div>');
		error = 1;
	}else if(coupon_value==""){
		$('#coupon_value').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please enter coupon value.</div>');
		error = 1;
	}else if(date_from==""){
		$('#date_from').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please select start date.</div>');
		error = 1;
	}else if(date_to==""){
		$('#date_to').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please select expiry date.</div>');
		error = 1;
	}/*else if(all_user==""){
		$('#all_user').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please select applicable users.</div>');
		error = 1;
	}else if(is_multiple==""){
		$('#is_multiple').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please select Usability.</div>');
		error = 1;
	}*/else{

	var form_data = new FormData($("#editCouponForm")[0]);
	console.log(form_data);
	$.ajax({
		url: URL +"coupon/edit", 
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
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> coupon not updated.</div>');
			}
			else
			{
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> coupon updated.</div>');
				//window.setTimeout(function(){window.history.back();}, 1500);

			}
			//$('#addCategoryForm').trigger('reset');
		}
	});	

	}	
}

function goBack(){
    window.setTimeout(function(){window.history.back();});
}


</script>