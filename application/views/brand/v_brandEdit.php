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
					<form class="form-horizontal form-row-seperated" id="editCategoryForm" method='post' enctype="multipart/form-data" action="javascript:editBrand();">
					
						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-bold"></i> <?php echo $pageHeading;?>
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
											<input type="text" id="name" class="form-control" value="<?php echo $brandData['name']; ?>" name="name" placeholder="">
											<input type="hidden" name="id" value="<?php echo $brandData['id']; ?>">
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-2 control-label">Brand Logo:
											</label>
											<div class="col-md-10">
											<?php if(!empty($brandData['image'])){?>
											
											<img class="imageBox" width="150px" src="<?php echo site_url().'assets/image/brand/'.$brandData['image']; ?>">
											<input type="button" class="btn btn-danger imageBox" onclick="removeImage(<?php echo $brandData['id'];?>)" value="Remove">
											
											<?php }?>
											
											<input type="file" name="image">
											</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-2 control-label">Brand Status: </label>
										<input type="radio" <?php if($brandData['enabled'] == 'Y'){echo "checked";}?> name="enabled" value="Y" > Enabled 
										<input type="radio" <?php if($brandData['enabled'] == 'N'){echo "checked";}?> name="enabled" value="N"> Disabled
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
	
function editBrand()
{
	var name = $('#name').val();

	$('.form-control').removeClass('box-error');
	
	if(name==""){
		$('#name').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please enter brand name.</div>');
		error = 1;
	}else{

	var form_data = new FormData($("#editCategoryForm")[0]);
	console.log(form_data);
	$.ajax({
		url: URL +"brand/edit", 
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
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> brand not updated.</div>');
			}
			else
			{
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> brand updated.</div>');
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

function removeImage(id)
	{
		var dataToSend = "id="+id;
		if (confirm("Are you sure, you want to delete?") == true) {
			
			$.ajax({
				url: URL +"brand/removeImage", 
				type: "post", 
				data: dataToSend,     
				cache: false,
				success: function(data) {
				console.log(data);
				  if(data == 'true')
				  {
					  /*$('#rowId_'+id).hide();*/

					  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Image removed.</div>');
					   $('.imageBox').remove();
				  }
				  else
				  { 
					  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong> image not removed.</div>');

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
</script>