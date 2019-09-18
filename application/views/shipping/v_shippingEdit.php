<style type="text/css">
	.hideBox{
		display: none;
	}
</style>
<div class="form-group rangeBox hideBox">
		<label class="col-md-2 control-label">Price Range:<span class="required">*</span></label>
		<div class="col-md-10">
	    <div class="col-md-3">
			<input type="number" class="form-control" min="0" name="rangeFrom[]" value="" placeholder="Enter Price Range From">
		</div>
		<div class="col-md-3">
			<input type="number" class="form-control" min="0" name="rangeTo[]" value="" placeholder="Enter Price Range To">
		</div>
		<div class="col-md-4">
			<input type="text" class="form-control" min="0" name="rangePrice[]" value="" placeholder="Enter Shipping Charges">
		</div>
		<!--div class="col-md-2">
			<button type="button" class="btn btn-danger removeRange">Remove</button>
		</div-->
		</div>
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
                            <a href="<?php echo site_url(); ?>shipping/edit?sid=<?php echo $_GET['sid']; ?>">
                                <?php echo $pageHeading;?>
                            </a>
                        </li>
                        
                    </ul>
                    
                </div>
            </div>

		<div class="form-group" id="message" style="dispaly:none;"></div>
		<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal form-row-seperated" id="editShippingForm" method='post' enctype="multipart/form-data" action="javascript:editShipping();">
					<input type="hidden" name="sid" value="<?php echo $_GET['sid'];?>">
					
						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<?php echo $pageHeading;?>
								</div>
								<div class="actions btn-set">
									<button class="btn default" type="button" onclick="goBack();"><i class="fa fa-reply"></i> Back</button>
									<button class="btn green"><i class="fa fa-check"></i> Save</button>
									
								</div>
							</div>

							<div class="portlet-body">
							<div class="form-body">
									
									<?php 
									if(!empty($shippingData)){
									foreach($shippingData as $k=>$v){?>
									<div class="form-group" id="rowRange_<?php echo $v['id'];?>">
												<label class="col-md-2 control-label">Shipping Price Range:<span class="required">*</span></label>
												<div class="col-md-10">
												<div class="col-md-3">
													<input type="number" min="0" class="form-control " name="rangeFrom[]" value="<?php echo $v['range_from'];?>" placeholder="Enter Price Range From">
												</div>
												<div class="col-md-3">
													<input type="number" min="0" class="form-control " name="rangeTo[]" value="<?php echo $v['range_to'];?>" placeholder="Enter Price Range To">
												</div>
												<div class="col-md-4">
													<input type="text" min="0"  class="form-control" name="rangePrice[]" value="<?php echo $v['price'];?>" placeholder="Enter Shipping Charges">
												</div>
												<div class="col-md-2">
														<button type="button" min="0" class="btn btn-danger" onclick="removeRange(<?php echo $v['id'];?>)">Remove</button>
												</div>
												</div>
									</div>
									<?php }}?>

									<div id="allRanges">

												</div>

												

												<div class="form-group">
												<label class="col-md-10 control-label"></label>
													<input type="button" class="btn btn-success" value="Add Range" onclick="addRange();">
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
	
function editShipping()
{
	var form_data = new FormData($("#editShippingForm")[0]);
	console.log(form_data);
	$.ajax({
		url: URL +"shipping/edit", 
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
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> shipping not updated.</div>');
			}
			else
			{
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> shipping updated.</div>');
				//window.setTimeout(function(){window.history.back();}, 1500);

			}
			//$('#addCategoryForm').trigger('reset');
		}
	});		
}

function goBack(){
    window.setTimeout(function(){window.history.back();});
}

function removeRange(id){

	var dataToSend = "id="+id;
		if (confirm("Are you sure, you want to delete?") == true) {
			
			$.ajax({
				url: URL +"shipping/removeRange", 
				type: "post", 
				data: dataToSend,     
				cache: false,
				success: function(data) {
				console.log(data);
				  if(data == 'true')
				  {
					  /*$('#rowId_'+id).hide();*/

					  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> deleted.</div>');
					   $('#rowRange_'+id).remove();
				  }
				  else
				  { 
					  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong> not deleted.</div>');

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

function addRange(){
	var cloneData = $('.hideBox').clone();
	cloneData.removeClass('hideBox');
	$('#allRanges').append(cloneData);
}
</script>