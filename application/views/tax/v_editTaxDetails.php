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
                            <a href="<?php echo site_url(); ?>tax">
                                Manage Taxation
                            </a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a href="<?php echo site_url(); ?>">
                                <?php echo $pageHeading;?>
                            </a>
                        </li>
                        
                    </ul>
                    
                </div>
            </div>

		<div class="form-group" id="message" style="dispaly:none;"></div>
		<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal form-row-seperated" id="editTaxForm" method='post' enctype="multipart/form-data" action="javascript:editTax();">
					
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
									<!--div class="form-group">
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
									</div-->
									<table  class="table table-striped table-bordered table-hover">
									<thead>
									<tr>
										<th>
										Commodity
										</th>
										<th>
										Tax Rate
										</th>
									</tr>
									</thead>
									<tbody>
									<?php foreach($taxData as $keyT=>$valT){?>
										<tr>
											<td><?php echo $valT['commodity']; ?></td>
											<td><input type="text" class="form-control" value="<?php echo $valT['rate']; ?>" name="rate[]" placeholder="">
											<input type="hidden" class="form-control" name="tax_id[]" value="<?php echo $valT['id']; ?>" placeholder="">
											</td>
										</tr>
									<?php }?>
									</tbody>
									</table>


									
							</div>		
							</div>

							</div>
					</form>
				</div>
				</div>





		
	</div><!--wrapper_inner close -->
</div>	

<script>
	
function editTax()
{
	var form_data = new FormData($("#editTaxForm")[0]);
	console.log(form_data);
	$.ajax({
		url: URL +"tax/editTaxDetails", 
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
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> tax not updated.</div>');
			}
			else
			{
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> tax updated.</div>');
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