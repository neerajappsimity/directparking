<style type="text/css">
	.hideBox{
		display: none;
	}
</style>
<div class="form-group rangeBox hideBox">
		<label class="col-md-2 control-label">Price Range:<span class="required">*</span></label>
		<div class="col-md-10">
	    <div class="col-md-5">
			<input type="number" class="form-control " name="rangeFrom[]" value="" placeholder="Enter Unit">
		</div>
		<div class="col-md-5">
			<input type="text" class="form-control" name="rangePrice[]" value="" placeholder="Enter Price">
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
                            <a href="<?php echo site_url(); ?>product">
                                Manage Products
                            </a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a href="<?php echo site_url(); ?>product">
                                <?php echo $pageHeading;?>
                            </a>
                        </li>
                    </ul>
                </div>
        </div>

		<div class="form-group" id="message" style="dispaly:none;"></div>
		<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal form-row-seperated" id="editProductForm" enctype="multipart/form-data" action="javascript:editProduct();">
						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-sitemap"></i><?php echo $pageHeading;?>
								</div>
								<div class="actions btn-set">
									<a onclick="goBack();" href="javascript:;" class="btn default"><i class="fa fa-angle-left"></i> Back</a>
									<!--button class="btn default"><i class="fa fa-reply"></i> Reset</button-->
									<button class="btn green"><i class="fa fa-check"></i> Save</button>
									<!--button class="btn green"><i class="fa fa-check-circle"></i> Save & Continue Edit</button-->
									<div class="btn-group">
										<a class="btn yellow" href="#" data-toggle="dropdown">
											<i class="fa fa-share"></i> More <i class="fa fa-angle-down"></i>
										</a>
										<ul class="dropdown-menu pull-right">
											<!--li>
												<a href="#">
													 Duplicate
												</a>
											</li-->
											<li >
												<a onclick="deleted(<?php echo $productData['id'];?>);" href="javascript:;">
													Delete
												</a>
											</li>
											<!--li class="divider">
											</li>
											<li>
												<a href="#">
													 Print
												</a>
											</li-->
										</ul>
									</div>
								</div>
							</div>
							<div class="portlet-body">
								<div class="tabbable">
									<ul class="nav nav-tabs">
										<li class="active" id="genLi">
											<a href="#tab_general" data-toggle="tab">
												 General
											</a>
										</li>
										<li id="priceLi">
											<a href="#tab_price" data-toggle="tab">
												 Price
											</a>
										</li>
										<li id="invLi">
											<a href="#tab_inventory" data-toggle="tab">
												 Inventory
											</a>
										</li>
										<li id="imgLi">
											<a href="#tab_images" data-toggle="tab">
												 Images
											</a>
										</li>
										
									</ul>
									<div class="tab-content no-space">
										<div class="tab-pane active" id="tab_general">
											<div class="form-body">
												<div class="form-group">
													<label class="col-md-2 control-label">Name:
													<span class="required">
														 *
													</span>
													</label>
													<div class="col-md-10">
														<input type="text" class="form-control" value="<?php echo $productData['name']; ?>" id="name" name="name" placeholder="">
														<input type="hidden" value="<?php echo $_GET['pid']; ?>" name="pid" placeholder="">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Description:
													<span class="required">
														 *
													</span>
													</label>
													<div class="col-md-10">
														<textarea class="form-control" id="description" name="description"><?php echo $productData['description']; ?></textarea>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Short Description:
													<span class="required">
														 *
													</span>
													</label>
													<div class="col-md-10">
														<textarea class="form-control" id="short_description" name="short_description"><?php echo $productData['short_description']; ?></textarea>
														<span class="help-block">
															 shown in product listing
														</span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Commodity Type:
													</label>
													<div class="col-md-10">
														<select class="table-group-action-input form-control input-medium" name="commodity_id">
															<option value="">Select...</option>
															<?php foreach($commodities as $commodity){?>
															<option <?php if($productData['commodity_id'] == $commodity['id']){echo "selected='selected'";} ?> value="<?php echo $commodity['id'];?>"><?php echo $commodity['commodity'];?></option>
															<?php }?>
														</select>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-2 control-label">Categories:
													<span class="required">*</span>
													</label>
													<div class="col-md-10">
														<div class="form-control height-auto" id="categoryBox">
															<div class="scroller" style="height:275px;" data-always-visible="1">
																<ul class="list-unstyled">
																<?php foreach($mainCategories as $kMain=>$vMain){?>
																	<li>
																		<label><!--input type="checkbox" name="product[categories][]" value="<?php echo $vMain['id'];?>"--><?php echo $vMain['name'];?></label>
																		<?php if(!empty($vMain['subCategories'])){?>
																		<ul class="list-unstyled">
																		<?php foreach($vMain['subCategories'] as $vSub){ ?>
																			<li>
																				<label><input type="checkbox" name="categories[]" class="categories" id="categories" <?php if (in_array($vSub['id'], $productCategory)){echo "checked='checked'";} ?> value="<?php echo $vSub['id']; ?>"><?php echo $vSub['name']; ?></label>
																			</li>
																		<?php } ?>
																			
																		</ul>
																		<?php }?>
																	</li>
																	<?php } ?>
																	
																</ul>
															</div>
														</div>
														<span class="help-block">
															 select one or more categories
														</span>
													</div>
												</div>
												<!--div class="form-group">
													<label class="col-md-2 control-label">Available Date:
													<span class="required">
														 *
													</span>
													</label>
													<div class="col-md-10">
														<div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
															<input type="text" class="form-control" name="product[available_from]">
															<span class="input-group-addon">
																 to
															</span>
															<input type="text" class="form-control" name="product[available_to]">
														</div>
														<span class="help-block">
															 availability daterange.
														</span>
													</div>
												</div-->
												<div class="form-group">
													<label class="col-md-2 control-label">Brand:
													<span class="required">
														 *
													</span>
													</label>
													<div class="col-md-10">
														<select class="table-group-action-input form-control input-medium" name="brand_id" id="brand_id">
															<option value="">Select...</option>
															<?php foreach($brands as $vBrand){?>
															<option <?php if($productData['brand_id'] == $vBrand['id']){echo "selected='selected'";} ?> value="<?php echo $vBrand['id'];?>"><?php echo $vBrand['name'];?></option>
															<?php }?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Care Instructions:
													</label>
													<div class="col-md-10">
														<textarea class="form-control" name="care_instructions"><?php echo $productData['care_instructions']; ?></textarea>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">SKU:
													<span class="required">
														 *
													</span>
													</label>
													<div class="col-md-10">
														<input type="text" class="form-control" value="<?php echo $productData['sku']; ?>" name="sku" placeholder="">
													</div>
												</div>


												<div class="form-group">
													<label class="col-md-2 control-label">Warranty:
													
													</label>
													<div class="col-md-10">
														<input type="text" class="form-control" value="<?php echo $productData['warranty']; ?>" name="warranty" placeholder="">
													</div>
												</div>

												<div class="form-group">
												<h3><b>Technical Specifications</b></h3>
												</div>

												<div class="form-group">
													<label class="col-md-2 control-label">Weight:
													
													</label>
													<div class="col-md-10">
														<input type="text" value="<?php echo $productData['weight']; ?>" class="form-control" name="weight" placeholder="">
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-2 control-label">Power Rating(HP):
													
													</label>
													<div class="col-md-10">
														<input type="text" value="<?php echo $productData['power_rating_hp']; ?>" class="form-control" name="power_rating_hp" placeholder="">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Power Rating(KW):
													</label>
													<div class="col-md-10">
														<input type="text" value="<?php echo $productData['power_rating_kw']; ?>" class="form-control" name="power_rating_kw" placeholder="">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Flow Rate(LPM):
													</label>
													<div class="col-md-10">
														<input type="text" value="<?php echo $productData['flow_rate_lpm']; ?>" class="form-control" name="flow_rate_lpm" placeholder="">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Pressure(BAR):
													</label>
													<div class="col-md-10">
														<input type="text" value="<?php echo $productData['pressure']; ?>" class="form-control" name="pressure" placeholder="">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Head in feet:
													</label>
													<div class="col-md-10">
														<input type="text" value="<?php echo $productData['head_feet']; ?>" class="form-control" name="head_feet" placeholder="">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Outlet Size:
													</label>
													<div class="col-md-10">
													<input type="text" class="form-control" value="<?php echo $productData['outlet_size']; ?>" name="outlet_size" placeholder="">
													</div>
												</div>
												<!--div class="form-group">
													<label class="col-md-2 control-label">Bore Diameter:
													</label>
													<div class="col-md-10">
													<input type="text" class="form-control" value="<?php echo $productData['bore_diameter']; ?>" name="bore_diameter" placeholder="">
													</div>
												</div-->
												<div class="form-group">
													<label class="col-md-2 control-label">Bore Diameter:
													</label>
													<div class="col-md-3">
														<select class="table-group-action-input form-control input-medium" name="bore_diameter_id" id="bore_diameter">
															<option value="">Select...</option>
															<?php foreach($boreDiameters as $vboreDiameter){?>
															<option <?php if($productData['bore_diameter_id'] == $vboreDiameter['id']){echo "selected='selected'";} ?> value="<?php echo $vboreDiameter['id'];?>"><?php echo $vboreDiameter['name'];?></option>
															<?php }?>
														</select>
													</div>
													<div class="col-md-7">
													<a class="btn btn-success" data-toggle="modal" href="#boreBox">
														+
														</a>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Solid Handling:
													</label>
													<div class="col-md-3">
														<select class="table-group-action-input form-control input-medium" name="solid_handling_id" id="solid">
															<option value="">Select...</option>
															<?php foreach($solids as $vSolid){?>
															<option <?php if($productData['solid_handling_id'] == $vSolid['id']){echo "selected='selected'";} ?> value="<?php echo $vSolid['id'];?>"><?php echo $vSolid['name'];?></option>
															<?php }?>
														</select>
													</div>
													<div class="col-md-7">
													<a class="btn btn-success" data-toggle="modal" href="#solidBox">
														+
														</a>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">No of Bathrooms:
													</label>
													<div class="col-md-3">
														<select class="table-group-action-input form-control input-medium" name="bathroom_id" id="bath">
															<option value="">Select...</option>
															<?php foreach($bathrooms as $vbathroom){?>
															<option <?php if($productData['bathroom_id'] == $vbathroom['id']){echo "selected='selected'";} ?> value="<?php echo $vbathroom['id'];?>"><?php echo $vbathroom['name'];?></option>
															<?php }?>
														</select>
													</div>
													<div class="col-md-7">
													<a class="btn btn-success" data-toggle="modal" href="#bathBox">
														+
														</a>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-2 control-label">Phase:
													</label>
													<div class="col-md-10">
														<select class="table-group-action-input form-control input-medium" name="phase_id">
															<option value="">Select...</option>
															<?php foreach($phases as $vPhase){?>
															<option <?php if($productData['phase_id'] == $vPhase['id']){echo "selected='selected'";} ?> value="<?php echo $vPhase['id'];?>"><?php echo $vPhase['name'];?></option>
															<?php }?>
														</select>
													</div>
												</div>

											</div>
										</div>
										<div class="tab-pane" id="tab_price">
											<div class="form-body">
												<div class="form-group">
													<label class="col-md-2 control-label">MRP:<span class="required">*</span></label>

													<div class="col-md-10">
														<input type="text" value="<?php echo $productData['mrp']; ?>" class="form-control maxlength-handler" name="mrp" id="mrp" placeholder="">
													</div>
												</div>
												<?php foreach($productPrice as $vPrice){?>
												<?php if($vPrice['range_from'] == 0){?>
												<div class="form-group">
													<label class="col-md-2 control-label">Selling Price:<span class="required">*</span></label>

													<div class="col-md-10">
														<input type="text" class="form-control maxlength-handler" name="price" id="price" value="<?php echo $vPrice['price'];?>" placeholder="">
													</div>
												</div>
												<?php }else{ ?>

												<div class="form-group" id="rowRange_<?php echo $vPrice['id'];?>">
													<label class="col-md-2 control-label">Price Range:<span class="required">*</span></label>
													<div class="col-md-10">
												    <div class="col-md-5">
														<input type="number" class="form-control " name="rangeFrom[]" value="<?php echo $vPrice['range_from'];?>" placeholder="Enter Unit">
													</div>
													<div class="col-md-5">
														<input type="text" class="form-control" name="rangePrice[]" value="<?php echo $vPrice['price'];?>" placeholder="Enter Price">
													</div>
													<div class="col-md-2">
														<button type="button" class="btn btn-danger" onclick="removeRange(<?php echo $vPrice['id'];?>)">Remove</button>
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
										<div class="tab-pane" id="tab_inventory">
											<div class="form-body">
												<div class="form-group">
													<label class="col-md-2 control-label">Quantity:<span class="required">*</span></label>

													<div class="col-md-10">
														<input type="number" class="form-control maxlength-handler" name="quantity" id="quantity" value="<?php echo $productData['quantity']; ?>" placeholder="">
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-2 control-label">Stock Availability:
													</label>
													<div class="col-md-10">
														<select class="table-group-action-input form-control input-medium" name="stock_available">
															<option <?php if($productData['stock_available'] == '1'){echo "selected='selected'";} ?> value="1">In Stock</option>
															<option <?php if($productData['stock_available'] == '2'){echo "selected='selected'";} ?> value="2">Out of Stock</option>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane" id="tab_images">
											<!--div class="alert alert-success margin-bottom-10">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
												<i class="fa fa-warning fa-lg"></i> Image type and information need to be specified.
											</div-->
											<div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10">
											<input type="file" name="image[]" style="display:inline !important;" class="btn yellow" multiple>												<!--a id="tab_images_uploader_pickfiles" href="javascript:;" class="btn yellow">
													<i class="fa fa-plus"></i> Select Files
												</a-->
												<a href="javascript:uploadImage();" class="btn green">
													<i class="fa fa-share"></i> Upload Files
												</a>
											</div>
											<div class="row">
												<div id="tab_images_uploader_filelist" class="col-md-6 col-sm-12">
												</div>
											</div>
											<table class="table table-bordered table-hover">
											<thead>
											<tr role="row" class="heading">
												<th>
													 Image
												</th>
												
												<th width="10%">
													Featured
												</th>
												
												<th width="10%">
												</th>
											</tr>
											</thead>
											<tbody id="tblImageBody">

											<?php 
											if(!empty($productImages)){
											foreach($productImages as $images){?>
											<tr id="rowImage_<?php echo $images['id'];?>">
												<td>
													<a href="<?php echo site_url().'assets/image/products/original/'.$images['image']; ?>" class="fancybox-button" data-rel="fancybox-button">
														<img width="150" src="<?php echo site_url().'assets/image/products/original/'.$images['image']; ?>" alt="">
													</a>
												</td>
												<td>
													<label>
													<input type="radio" name="featured" value="<?php echo $images['id'];?>" <?php if($images['is_featured']=='Y'){echo "checked";}?>>
													</label>
												</td>
												<td>
													<a href="javascript:;" onclick="removeImage(<?php echo $images['id'];?>)" class="btn default btn-sm">
														<i class="fa fa-times"></i> Remove
													</a>
												</td>
											</tr>
											<?php } }?>
											
											</tbody>
											</table>
										</div>
										
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>


			<div id="boreBox" class="modal fade" tabindex="-1"  aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Add Bore Diameter</h4>
										</div>
										<div class="modal-body">
										<form id="addBore">
											<div class="row">
													<div class="col-md-12">
															<label>Bore Diameter Name</label>
															<input type="text" class="col-md-12 form-control" id="nameBore" name="nameBore">
													</div>
												
											</div>
										</form>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" onclick="addBore();" class="btn green">Save changes</button>
										</div>
									</div>
								</div>
							</div>



							<div id="solidBox" class="modal fade" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Add Solid Handling</h4>
										</div>
										<div class="modal-body">
											<form id="addSolid">
												<div class="row">
													<div class="col-md-12">
															<label>Solid Handling Name</label>
															<input type="text" class="col-md-12 form-control" id="nameSolid" name="nameSolid">
													</div>
												
											</div>
											</form>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" onclick="addSolid();" class="btn green">Save changes</button>
										</div>
									</div>
								</div>
							</div>


							<div id="bathBox" class="modal fade" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Add No of Bathrooms</h4>
										</div>
										<div class="modal-body">
											<form id="addBath">
												<div class="row">
													<div class="col-md-12">
															<label>No of Bathrooms</label>
															<input type="text" class="col-md-12 form-control" id="nameBath" name="nameBath">
													</div>
											
											</div>
											</form>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" onclick="addBath();" class="btn green" onclick="" >Save changes</button>
										</div>
									</div>
								</div>
							</div>





		
	</div><!--wrapper_inner close -->
</div>

<script src="<?php echo site_url(); ?>assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>

<script>

$(".removeRange").click(function(){
	alert("yes");
    //$(this).parent('.rangeBox').remove();
});

function addRange(){
	var cloneData = $('.hideBox').clone();
	cloneData.removeClass('hideBox');
	$('#allRanges').append(cloneData);
}

function uploadImage()
{
	var form_data = new FormData($("#editProductForm")[0]);
	console.log(form_data);
	$.ajax({
		url: URL +"product/addImages", 
		type: "post", 
		data: form_data,     
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function (results)
		{
			$('#message').html('');
			if(results == 'false')
			{
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> images not uploaded.</div>');
			}
			else
			{
				/*$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> images uploaded.</div>');*/
				//window.setTimeout(function(){window.history.back();}, 1500);
				var htmlStr='';
				
				$.each(results, function(k, v){
					var checked = '';
					if(v.is_featured == 'Y'){
						checked = 'checked';
					}
        			htmlStr += '<tr><td><a href="<?php echo site_url()?>assets/image/products/original/'+v.image+'" class="fancybox-button" data-rel="fancybox-button"><img width="150" src="<?php echo site_url()?>assets/image/products/original/'+v.image+'" alt=""></td><td><label><input type="radio" name="featured" '+checked+' value="'+v.id+'"></label></td><td><a href="javascript:;" onclick="removeImage('+v.id+')" class="btn default btn-sm"><i class="fa fa-times"></i> Remove</a></td></tr>';
   				});
   				$('#tblImageBody').html(htmlStr);

			}

		
		}
	});		
}


function editProduct()
{
	var name = $('#name').val();
	var description = $('#description').val();
	var short_description = $('#short_description').val();
	var brand = $('#brand_id').val();
	var sku = $('#sku').val();
	var mrp = $('#mrp').val();
	var price = $('#price').val();
	var quantity = $('#quantity').val();

	$('.form-control').removeClass('box-error');
	
	if(name==""){
		$('#name').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please enter product.</div>');
		$('.tab-pane').removeClass('active');
		$('.nav-tabs li').removeClass('active');
		$('#tab_general').addClass('active');
		$('#genLi').addClass('active');
		error = 1;
	}else if(description==""){
		$('#description').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please enter description.</div>');
		$('.tab-pane').removeClass('active');
		$('.nav-tabs li').removeClass('active');
		$('#tab_general').addClass('active');
		$('#genLi').addClass('active');
		error = 1;
	}else if(short_description==""){
		$('#short_description').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please enter short description.</div>');
		$('.tab-pane').removeClass('active');
		$('.nav-tabs li').removeClass('active');
		$('#tab_general').addClass('active');
		$('#genLi').addClass('active');
		error = 1;
	}else if(!jQuery(".categories").is(":checked")){
		$('#categoryBox').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please select at least one category.</div>');
		$('.tab-pane').removeClass('active');
		$('.nav-tabs li').removeClass('active');
		$('#tab_general').addClass('active');
		$('#genLi').addClass('active');
		error = 1;

	}else if(brand==""){
		$('#brand_id').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please select brand.</div>');
		$('.tab-pane').removeClass('active');
		$('.nav-tabs li').removeClass('active');
		$('#tab_general').addClass('active');
		$('#genLi').addClass('active');
		error = 1;
	}else if(sku==""){
		$('#sku').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please enter sku.</div>');
		$('.tab-pane').removeClass('active');
		$('.nav-tabs li').removeClass('active');
		$('#tab_general').addClass('active');
		$('#genLi').addClass('active');
		error = 1;
	}else if(mrp==""){
		$('#mrp').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please enter mrp.</div>');
		$('.tab-pane').removeClass('active');
		$('.nav-tabs li').removeClass('active');
		$('#tab_price').addClass('active');
		$('#priceLi').addClass('active');
		error = 1;
	}else if(price==""){
		$('#price').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please enter selling price.</div>');
		$('.tab-pane').removeClass('active');
		$('.nav-tabs li').removeClass('active');
		$('#tab_price').addClass('active');
		$('#priceLi').addClass('active');
		error = 1;
	}else if(quantity==""){
		$('#quantity').addClass('box-error');
		$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> Please enter quantity.</div>');
		$('.tab-pane').removeClass('active');
		$('.nav-tabs li').removeClass('active');
		$('#tab_inventory').addClass('active');
		$('#invLi').addClass('active');
		error = 1;
	}else{
	var form_data = new FormData($("#editProductForm")[0]);
	console.log(form_data);
	$.ajax({
		url: URL +"product/edit", 
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
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> product not updated.</div>');
			}
			else
			{
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> product updated.</div>');
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

function deleted(id)
	{
		var dataToSend = "id="+id;
		if (confirm("Are you sure, you want to delete?") == true) {
			
			$.ajax({
				url: URL +"product/deleted", 
				type: "post", 
				data: dataToSend,     
				cache: false,
				success: function(data) {
				console.log(data);
				  if(data == 'true')
				  {
					  /*$('#rowId_'+id).hide();*/

					  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Product deleted.</div>');
					   window.setTimeout(function(){window.history.back();}, 1500);
				  }
				  else
				  { 
					  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong> Product not deleted.</div>');

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


function removeImage(id)
	{
		var dataToSend = "id="+id;
		if (confirm("Are you sure, you want to delete?") == true) {
			
			$.ajax({
				url: URL +"product/removeImage", 
				type: "post", 
				data: dataToSend,     
				cache: false,
				success: function(data) {
				console.log(data);
				  if(data == 'true')
				  {
					  /*$('#rowId_'+id).hide();*/

					  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Image deleted.</div>');
					   $('#rowImage_'+id).remove();
				  }
				  else
				  { 
					  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong> image not deleted.</div>');

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


function removeRange(id){

	var dataToSend = "id="+id;
		if (confirm("Are you sure, you want to delete?") == true) {
			
			$.ajax({
				url: URL +"product/removeRange", 
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


function addBore()
{
		var val = $('#nameBore').val();

		if(val==""){
			$('#boreBox').modal('toggle');
		}else{
		var form_data = new FormData($("#addBore")[0]);
		$.ajax({
		url: URL +"product/addBore", 
		type: "post", 
		data: form_data,     
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function (htmlStr)
			{
				console.log(htmlStr);
				$('#bore_diameter').append('<option value="'+htmlStr.insert_id+'">'+htmlStr.name+'</option>');
				$('#addBore').trigger('reset');
				$('#boreBox').modal('toggle');
			}
		});
	}
}

function addSolid()
{
		var val = $('#nameSolid').val();

		if(val==""){
			$('#solidBox').modal('toggle');
		}else{
		var form_data = new FormData($("#addSolid")[0]);
		$.ajax({
		url: URL +"product/addSolid", 
		type: "post", 
		data: form_data,     
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function (htmlStr)
			{
				console.log(htmlStr);
				$('#solid').append('<option value="'+htmlStr.insert_id+'">'+htmlStr.name+'</option>');
				$('#addSolid').trigger('reset');
				$('#solidBox').modal('toggle');
			}
		});
	}
}


function addBath()
{
		var val = $('#nameBath').val();

		if(val==""){
			$('#bathBox').modal('toggle');
		}else{
		var form_data = new FormData($("#addBath")[0]);
		$.ajax({
		url: URL +"product/addBath", 
		type: "post", 
		data: form_data,     
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function (htmlStr)
			{
				console.log(htmlStr);
				$('#bath').append('<option value="'+htmlStr.insert_id+'">'+htmlStr.name+'</option>');
				$('#addBath').trigger('reset');
				$('#bathBox').modal('toggle');
			}
		});
	}
}


</script>