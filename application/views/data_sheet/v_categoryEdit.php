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
					<form class="form-horizontal form-row-seperated" id="editCategoryForm" method='post' enctype="multipart/form-data" action="javascript:editCategory();">
					
						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-th"></i> <?php echo $pageHeading;?>
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
											<input type="text" id="name" class="form-control" value="<?php echo $categoryData['name']; ?>" name="name" placeholder="">
											<input type="hidden" name="id" value="<?php echo $categoryData['id']; ?>">
											</div>
									</div>
									<div class="form-group">
											<label class="col-md-2 control-label">Main Category:
											</label>
											<div class="col-md-10">
													<select class="table-group-action-input form-control input-medium" name="parent_id">
															<option value="0">None</option>
															<?php foreach($categories as $category){?>
															<option <?php if($categoryData['parent_id'] == $category['id']){echo "selected='selected'";} ?> value="<?php echo $category['id'];?>"><?php echo $category['name'];?></option>
															<?php }?>
													</select>
											</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Category Status: </label>
										<input type="radio" name="enabled" <?php if($categoryData['enabled'] == 'Y'){ echo "checked";}?> value="Y" > Enabled 
										<input type="radio" name="enabled" <?php if($categoryData['enabled'] == 'N'){ echo "checked";}?> value="N"> Disabled
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
	
function editCategory()
{

	var name = $('#name').val();

	$('.form-control').removeClass('box-error');
	
	if(name==""){
		$('#name').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please category name.</div>');
		error = 1;
	}else{

	var form_data = new FormData($("#editCategoryForm")[0]);
	console.log(form_data);
	$.ajax({
		url: URL +"category/edit", 
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
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> root category not updated.</div>');
			}
			else
			{
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> root category updated.</div>');
				window.setTimeout(function(){window.history.back();}, 1500);

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