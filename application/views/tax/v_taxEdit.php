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
                            <a href="<?php echo site_url(); ?>state">
                                Manage Taxation
                            </a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a href="<?php echo site_url(); ?>state/edit?cid=<?php echo $_GET['cid']; ?>">
                                <?php echo $pageHeading;?>
                            </a>
                        </li>
                        
                    </ul>
                    
                </div>
            </div>

		<div class="form-group" id="message" style="dispaly:none;"></div>
		<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal form-row-seperated" id="editStateForm" method='post' enctype="multipart/form-data" action="javascript:editState();">
					
						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<?php echo $pageHeading;?> : <?php echo $stateData['name']; ?>
								</div>
								<div class="actions btn-set">
									<button class="btn default" type="button" onclick="goBack();"><i class="fa fa-reply"></i> Back</button>
									<button class="btn green"><i class="fa fa-check"></i> Save</button>
									
								</div>
							</div>

							<div class="portlet-body">
							<div class="form-body">
									<div class="form-group">
											<label class="col-md-2 control-label">Name:
											</label>
											<div class="col-md-10">
											<?php echo $stateData['name']; ?>
											<input type="hidden" name="id" value="<?php echo $stateData['id']; ?>">
											</div>
									</div>
									<div class="form-group">
											<label class="col-md-2 control-label">VAT: <span class="required">*</span>
											</label>
											<div class="col-md-10">
											<input type="text" class="form-control" value="<?php echo $stateData['vat']; ?>" name="vat" placeholder="">
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-2 control-label">CST: <span class="required">*</span>
											</label>
											<div class="col-md-10">
											<input type="text" class="form-control" value="<?php echo $stateData['cst']; ?>" name="cst" placeholder="">
											</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-2 control-label">State Status: </label>
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

<script>
	
function editState()
{
	var form_data = new FormData($("#editStateForm")[0]);
	console.log(form_data);
	$.ajax({
		url: URL +"state/edit", 
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
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> state not updated.</div>');
			}
			else
			{
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> state updated.</div>');
				//window.setTimeout(function(){window.history.back();}, 1500);

			}
			//$('#addCategoryForm').trigger('reset');
		}
	});		
}

function goBack(){
    window.setTimeout(function(){window.history.back();});
}
</script>