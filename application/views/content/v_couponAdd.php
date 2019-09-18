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
                            <a href="<?php echo site_url(); ?>coupon">
                                <?php echo $pageHeading;?>
                            </a>
                        </li>
                        
                    </ul>
                    
                </div>
            </div>

		<div class="form-group" id="message" style="dispaly:none;"></div>
		<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal form-row-seperated" id="addCouponForm" method='post' enctype="multipart/form-data" action="javascript:addCoupon();">
					
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
											<input type="text" class="form-control" id="name" name="name" placeholder="">
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-2 control-label">Code: <span class="required">*</span>
											</label>
											<div class="col-md-10">
											<input type="text" class="form-control" id="code" name="code" placeholder="">
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-2 control-label">Value: <span class="required">*</span>
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control" id="coupon_value" name="coupon_value" placeholder="">
											</div>

											<label class="col-md-2 control-label">Value Type:
											</label>
											<div class="col-md-4">
											<input type="radio" checked="checked" name="value_type" value="P"> Percent
											<input type="radio" name="value_type" value="F"> Flat
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-2 control-label" >Start Date: <span class="required">*</span>
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control date date-picker" data-date-format="yyyy-mm-dd" id="date_from" name="date_from" placeholder="">
											</div>


											<label class="col-md-2 control-label">Expiry Date: <span class="required">*</span>
											</label>
											<div class="col-md-4">
											<input type="text" class="form-control date date-picker" data-date-format="yyyy-mm-dd" id="date_to" name="date_to" placeholder="">
											</div>
									</div>


									<!--div class="form-group">
											<label class="col-md-2 control-label">Applicable To: <span class="required">*</span>
											</label>
											<div class="col-md-10">
											<select name="all_user" id="all_user" class="form-control">
												<option value="">Select ...</option>
												<option value="Y">All Users</option>
												<option value="N">Particular Users</option>
											</select>
											</div>
									</div-->

									<div class="form-group">
											<label class="col-md-2 control-label">Usability:
											</label>
											<div class="col-md-10">
											<!--select name="is_multiple" id="is_multiple" class="form-control">
												<option value="">Select ...</option>
												<option value="Y">Single Time</option>
												<option value="N">Multiple Times</option>
											</select-->
											<input type="radio" checked="checked" name="is_multiple" value="N"> Single Time
											<input type="radio"  name="is_multiple" value="Y"> Multiple Times
											</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-2 control-label">Coupon Status: </label>
										<input type="radio" name="enabled" value="Y" checked> Enabled 
										<input type="radio" name="enabled" value="N"> Disabled
									</div>
									
							</div>		
							</div>

							</div>
					</form>
				</div>
				</div>





		
	</div><!--wrapper_inner close -->
</div>	

<script src="<?php echo site_url(); ?>assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script>
 $('.date-picker').datepicker();
	
function addCoupon()
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

	var form_data = new FormData($("#addCouponForm")[0]);
	console.log(form_data);
	$.ajax({
		url: URL +"coupon/add", 
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
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> coupon not added.</div>');
			
				$('html').animate({scrollTop:0}, 'slow');//IE, FF
			    $('body').animate({scrollTop:0}, 'slow');//chrome, don't know if Safari works
			}
			else
			{
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> coupon added.</div>');
				$('html').animate({scrollTop:0}, 'slow');//IE, FF
			    $('body').animate({scrollTop:0}, 'slow');//chrome, don't know if Safari works

				window.setTimeout(function(){
        					window.location.href='<?php echo base_url().'coupon'; ?>';
    						}, 1500);

			}
			$('#addCouponForm').trigger('reset');
		}
	});	

	}	
}
</script>