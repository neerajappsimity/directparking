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
										<li id="addLi">
											<a href="#tab_additional" data-toggle="tab">
												 Additional Specifications
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
														<input type="text" class="form-control" value="<?php echo htmlspecialchars($productData['name']); ?>" id="name" name="name" placeholder="">
														<input type="hidden" value="<?php echo $_GET['pid']; ?>" name="pid" placeholder="">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Description:
													
													</label>
													<div class="col-md-10">
														<textarea class="form-control" id="description" name="description"><?php echo $productData['description']; ?></textarea>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Short Description:
													
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
													<div class="col-md-4">
														<select class="table-group-action-input form-control input-medium" name="commodity_id">
															<option value="">Select...</option>
															<?php foreach($commodities as $commodity){?>
															<option <?php if($productData['commodity_id'] == $commodity['id']){echo "selected='selected'";} ?> value="<?php echo $commodity['id'];?>"><?php echo $commodity['commodity'];?></option>
															<?php }?>
														</select>
													</div>

													<label class="col-md-2 control-label pumpType">Pump Type:
													</label>
													<div class="col-md-4">
														<select class="table-group-action-input form-control input-medium" name="pump_type_id">
															<option value="">--Select Pump Type--</option>
															<?php foreach($pumpTypes as $pumpType){?>
															<option <?php if($productData['pump_type_id'] == $pumpType['id']){echo "selected='selected'";} ?> value="<?php echo $pumpType['id'];?>"><?php echo $pumpType['name'];?></option>
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
													<label class="col-md-2 control-label">Best Product:
													</label>
													<div class="col-md-10">
														<input type="radio" name="is_best" value="Y" <?php if($productData['is_best'] == 'Y'){echo 'checked="checked"';} ?> > Yes
														<input type="radio" name="is_best" value="N" <?php if($productData['is_best'] == 'N'){echo 'checked="checked"';} ?> > No
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
													<label class="col-md-2 control-label">HSN/SAC:
													
													</label>
													<div class="col-md-10">
														<input type="text" class="form-control" value="<?php echo $productData['hsn_sac']; ?>" name="hsn_sac" placeholder="">
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-2 control-label">Warranty:
													</label>
													<div class="col-md-4">
														<input type="text" class="form-control" value="<?php echo $productData['warranty']; ?>" name="warranty" placeholder="">
													</div>

													<label class="col-md-2 control-label">Warranty Service Type:
													</label>
													<div class="col-md-4">
														<input type="text" class="form-control" value="<?php echo $productData['warranty_service_type']; ?>" name="warranty_service_type" placeholder="">
													</div>

												</div>


												<div class="form-group">
													<label class="col-md-2 control-label">Content:
													</label>
													<div class="col-md-8 contentBox">
													<?php if(!empty($contents)){
														$i = 0;
														foreach ($contents as $keyCon => $valCon) {
															$i++;
														?>
														<div class="contentInput rowCon_<?php echo $i;?>">
														<div class="col-md-10">
														<input type="text" class="form-control" value="<?php echo $valCon['content'];?>" name="content[]" placeholder="">
														</div>
														<div class="col-md-2"><button type="button" class="btn btn-danger removeContent" onclick="removeContent(<?php echo $i;?>)">Remove</button></div>
														</div>
													<?php } }else {?>
														<div class="col-md-10">
														<input type="text" class="form-control" value="" name="content[]" placeholder="">
														</div>
													<?php } ?>	
													</div>

													<div class="col-md-2">
														<input type="button" class="btn btn-success" value="Add More" onclick="addContent();">
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
												<!--div class="form-group">
													<label class="col-md-2 control-label">Flow Rate(LPM):
													</label>
													<div class="col-md-10">
														<input type="text" value="<?php echo $productData['flow_rate_lpm']; ?>" class="form-control" name="flow_rate_lpm" placeholder="">
													</div>
												</div-->
												<div class="form-group">
													<label class="col-md-2 control-label">Flow Rate(LPM):
													</label>
													<div class="col-md-3">
														<input type="text" value="<?php echo $productData['flow_min']; ?>" class="form-control" name="flow_min" placeholder="Min">
													</div> 
													
													<div class="col-md-3">
														<input type="text" value="<?php echo $productData['flow_max']; ?>" class="form-control" name="flow_max" placeholder="Max">
													</div>

													<div class="col-md-3">
														<select name="flow_unit">
															<option <?php if($productData['flow_unit'] == 'lps'){echo "selected='selected'";} ?> value="lps">LPS</option>
															<option <?php if($productData['flow_unit'] == 'lpm'){echo "selected='selected'";} ?> value="lpm">LPM</option>
															<option <?php if($productData['flow_unit'] == 'lph'){echo "selected='selected'";} ?> value="lph">LPH</option>
															<option <?php if($productData['flow_unit'] == 'flow_unit'){echo "selected='selected'";} ?> value="gpm">GPM</option>
															<option <?php if($productData['flow_unit'] == 'm3h'){echo "selected='selected'";} ?> value="m3h">m<sup>3</sup>/h</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Pressure(BAR):
													</label>
													<div class="col-md-10">
														<input type="text" value="<?php echo $productData['pressure']; ?>" class="form-control" name="pressure" placeholder="">
													</div>
												</div>
												<!--div class="form-group">
													<label class="col-md-2 control-label">Head in feet:
													</label>
													<div class="col-md-10">
														<input type="text" value="<?php echo $productData['head_feet']; ?>" class="form-control" name="head_feet" placeholder="">
													</div>
												</div-->
												<div class="form-group">
													<label class="col-md-2 control-label">Head Range:
													</label>
													<div class="col-md-4">
														<input type="text" value="<?php echo $productData['head_min']; ?>" class="form-control" name="head_min" placeholder="Min">
													</div> 
													
													<div class="col-md-4">
														<input type="text" value="<?php echo $productData['head_max']; ?>" class="form-control" name="head_max" placeholder="Max">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Outlet Size(MM) :
													</label>
													<div class="col-md-4">
													<input type="text" class="form-control" value="<?php echo $productData['outlet_size']; ?>" name="outlet_size" placeholder="">
													</div>

													<label class="col-md-2 control-label">Inlet Size(MM):
													</label>
													<div class="col-md-4">
													<input type="text" class="form-control" value="<?php echo $productData['inlet_size']; ?>" name="inlet_size" placeholder="">
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-2 control-label">RPM:
													</label>
													<div class="col-md-4">
														<input type="text" class="form-control" value="<?php echo $productData['rpm']; ?>" name="rpm" placeholder="">
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-2 control-label">Stages:
													</label>
													<div class="col-md-10">
														<input type="text" class="form-control" value="<?php echo $productData['stages']; ?>" name="stages" placeholder="">
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
															<option id="optBore_<?php echo $vboreDiameter['id'];?>" <?php if($productData['bore_diameter_id'] == $vboreDiameter['id']){echo "selected='selected'";} ?> value="<?php echo $vboreDiameter['id'];?>"><?php echo $vboreDiameter['name'];?></option>
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
															<option id="optSolid_<?php echo $vSolid['id'];?>" <?php if($productData['solid_handling_id'] == $vSolid['id']){echo "selected='selected'";} ?> value="<?php echo $vSolid['id'];?>"><?php echo $vSolid['name'];?></option>
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
															<option id="optBath_<?php echo $vbathroom['id'];?>" <?php if($productData['bathroom_id'] == $vbathroom['id']){echo "selected='selected'";} ?> value="<?php echo $vbathroom['id'];?>"><?php echo $vbathroom['name'];?></option>
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
													<label class="col-md-2 control-label">Tank Type:
													</label>
													<div class="col-md-3">
														<select class="table-group-action-input form-control input-medium" name="tank_type_id" id="tank_type">
															<option value="">Select...</option>
															<?php foreach($tankTypes as $tankType){?>
															<option <?php if($productData['tank_type_id'] == $tankType['id']){echo "selected='selected'";} ?> id="optTank_<?php echo $tankType['id'];?>" value="<?php echo $tankType['id'];?>"><?php echo $tankType['name'];?></option>
															<?php }?>
														</select>
													</div>
													<div class="col-md-7">
													<a class="btn btn-success" data-toggle="modal" href="#tankBox">
														+
														</a>
													</div>
												</div>


												<div class="form-group">
													<label class="col-md-2 control-label">Tank Capacity:
													</label>
													<div class="col-md-4">
														<input type="text" class="form-control" value="<?php echo $productData['tank_capacity'];?>" name="tank_capacity" placeholder="">
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

										<div class="tab-pane" id="tab_additional">
											<div class="form-body">
												<div class="form-group">
													<label class="col-md-2 control-label">Fluid Type:</label>

													<div class="col-md-4">
													<?php $fluid_type = explode(',',$productData['fluid_type']); ?>

														<select class="table-group-action-input form-control input-medium" name="fluid_type[]" multiple="">
															
															<option <?php 

															if(in_array("water", $fluid_type)){echo "selected='selected'";} ?> value="water">Water</option>
															<option <?php if(in_array("chemical", $fluid_type)){echo "selected='selected'";} ?> value="chemical">Chemical</option>
															<option <?php if(in_array("sewage", $fluid_type)){echo "selected='selected'";} ?> value="sewage">Sewage</option>
															</select>
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-2 control-label">Application:
													</label>
													<div class="col-md-4">

													<?php $applications = explode(',',$productData['applications']); ?>
														<select class="table-group-action-input form-control input-medium" name="applications[]" multiple="">
															
															<option <?php 

															if(in_array("air conditioning", $applications)){echo "selected='selected'";} ?> value="air conditioning">Air Conditioning</option>
															<option <?php if(in_array("cooling towers", $applications)){echo "selected='selected'";} ?> value="cooling towers">Cooling Towers</option>
															<option <?php if(in_array("washing and cleaning systems", $applications)){echo "selected='selected'";} ?> value="washing and cleaning systems">Washing and Cleaning systems</option>
															<option <?php if(in_array("pressure boosting", $applications)){echo "selected='selected'";} ?> value="pressure boosting">Pressure Boosting</option>
															<option <?php if(in_array("refrigeration systems", $applications)){echo "selected='selected'";} ?> value="refrigeration systems">Refrigeration systems</option>
															<option <?php if(in_array("water transfer", $applications)){echo "selected='selected'";} ?> value="water transfer">Water transfer</option>
															<option <?php if(in_array("fluid transfer", $applications)){echo "selected='selected'";} ?> value="fluid transfer">Fluid Transfer</option>
															<option <?php if(in_array("sewage handling", $applications)){echo "selected='selected'";} ?> value="sewage handling">Sewage Handling</option>
															<option <?php if(in_array("dewatering", $applications)){echo "selected='selected'";} ?> value="dewatering">Dewatering</option>
															<option <?php if(in_array("irrigation", $applications)){echo "selected='selected'";} ?> value="irrigation">Irrigation</option>
															<option <?php if(in_array("lawn sprinklers", $applications)){echo "selected='selected'";} ?> value="lawn sprinklers">Lawn Sprinklers</option>
															<option <?php if(in_array("fire fighting", $applications)){echo "selected='selected'";} ?> value="fire fighting">Fire Fighting</option>
														</select>
													</div>
												</div>

												<!--div class="form-group">
													<label class="col-md-2 control-label">Material of Construction:</label>

													<div class="col-md-4">
														<select class="table-group-action-input form-control input-medium" name="material_construction" multiple="">
														<option  value="">--Select Material of Construction--</option>
															<option <?php if($productData['material_construction'] == 'impeller'){echo "selected='selected'";} ?> value="impeller">Impeller</option>
															<option <?php if($productData['material_construction'] == 'delivery casing'){echo "selected='selected'";} ?> value="delivery casing">Delivery casing</option>
															<option <?php if($productData['material_construction'] == 'motor body'){echo "selected='selected'";} ?> value="motor body">Motor Body</option>
															<option <?php if($productData['material_construction'] == 'shaft'){echo "selected='selected'";} ?> value="shaft">Shaft</option>
															<option <?php if($productData['material_construction'] == 'mechanical seal'){echo "selected='selected'";} ?> value="mechanical seal">Mechanical Seal</option>
															</select>
													</div>
												</div-->


												<div class="form-group">
													<label class="col-md-2 control-label">Source of Water:</label>

													<?php $source_water = explode(',',$productData['source_water']); ?>

													<div class="col-md-4">
														<select multiple="" class="table-group-action-input form-control input-medium" name="source_water[]">
														
															<option <?php if(in_array("main line", $source_water)){echo "selected='selected'";} ?> value="main line">Main Line</option>
															<option <?php if(in_array("openwell", $source_water)){echo "selected='selected'";} ?> value="openwell">Openwell</option>
															<option <?php if(in_array("borewell", $source_water)){echo "selected='selected'";} ?> value="borewell">Borewell</option>
															<option <?php if(in_array("overhead tank", $source_water)){echo "selected='selected'";} ?> value="overhead tank">Overhead Tank</option>
														</select>
													</div>
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

											<div class="row" style="margin-top:15px;">
													<div class="col-md-12">
														<table class="table table-striped table-bordered table-hover">
															<thead>
																<tr><th>Name</th><th>Action</th></tr>
															</thead>
															<tbody id="boreTab">
															<?php foreach($boreDiameters as $vboreDiameter){?>
																<tr id="rowBore_<?php echo $vboreDiameter['id'];?>"><td><?php echo $vboreDiameter['name'];?></td><td><button type="button" class="btn btn-danger" onclick="removeBore(<?php echo $vboreDiameter['id'];?>)">Remove</button></td></tr>
															<?php }?>
															</tbody>
														</table>
													</div>
											</div>

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

											<div class="row" style="margin-top:15px;">
											<div class="col-md-12">

											<table class="table table-striped table-bordered table-hover">
															<thead>
																<tr><th>Name</th><th>Action</th></tr>
															</thead>
															<tbody id="solidTab">
															<?php foreach($solids as $vSolid){?>
																<tr id="rowSolid_<?php echo $vSolid['id'];?>"><td><?php echo $vSolid['name'];?></td><td><button type="button" class="btn btn-danger" onclick="removeSolid(<?php echo $vSolid['id'];?>)">Remove</button></td></tr>
															<?php }?>
															</tbody>
														</table>
														</div>
														</div>
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

											<div class="row" style="margin-top:15px;">
											<div class="col-md-12">
											<table class="table table-striped table-bordered table-hover">
															<thead>
																<tr><th>Name</th><th>Action</th></tr>
															</thead>
															<tbody id="bathTab">
															<?php foreach($bathrooms as $vbathroom){?>
																<tr id="rowBath_<?php echo $vbathroom['id'];?>"><td><?php echo $vbathroom['name'];?></td><td><button type="button" class="btn btn-danger" onclick="removeBath(<?php echo $vbathroom['id'];?>)">Remove</button></td></tr>
															<?php }?>
															</tbody>
														</table>
														</div>
														</div>
										</div>
									</div>
								</div>
							</div>


							<div id="tankBox" class="modal fade" tabindex="-1"  aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Add Tank Type</h4>
										</div>
										<div class="modal-body">
										<form id="addTank">
											<div class="row">
													<div class="col-md-12">
															<label>Name</label>
															<input type="text" class="col-md-12 form-control" id="nameTank" name="nameTank">
													</div>
											</div>
											
										</form>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" onclick="addTank();" class="btn green">Save changes</button>

											<div class="row" style="margin-top:15px;">
													<div class="col-md-12">
														<table class="table table-striped table-bordered table-hover">
															<thead>
																<tr><th>Name</th><th>Action</th></tr>
															</thead>
															<tbody id="boreTab">
															<?php 
															if(!empty($tankTypes)){
															foreach($tankTypes as $tankType){?>
																<tr id="rowBore_<?php echo $tankType['id'];?>"><td><?php echo $tankType['name'];?></td><td><button type="button" class="btn btn-danger" onclick="removeTank(<?php echo $tankType['id'];?>)">Remove</button></td></tr>
															<?php }}?>
															</tbody>
														</table>
													</div>
											</div>

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

function removeBore(id)
{
	if(confirm("Are you sure, you want to delete this?")){
		var form_data = "id="+id;
		$.ajax({
		url: URL +"product/removeBore", 
		type: "post", 
		data: form_data,     
		dataType: 'json',
		success: function (htmlStr)
			{
				$('#rowBore_'+id).remove();
				$('#optBore_'+id).remove();
			}
		});
	}

}

function removeBath(id)
{
		if(confirm("Are you sure, you want to delete this?")){
		var form_data = "id="+id;
		$.ajax({
		url: URL +"product/removeBath", 
		type: "post", 
		data: form_data,     
		dataType: 'json',
		success: function (htmlStr)
			{
				$('#rowBath_'+id).remove();
				$('#optBath_'+id).remove();
			}
		});
		}

}

function removeSolid(id)
{
		if(confirm("Are you sure, you want to delete this?")){
		var form_data = "id="+id;
		$.ajax({
		url: URL +"product/removeSolid", 
		type: "post", 
		data: form_data,     
		dataType: 'json',
		success: function (htmlStr)
			{
				$('#rowSolid_'+id).remove();
				$('#optSolid_'+id).remove();
			}
		});
		}

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
	}/*else if(description==""){
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
	}*/else if(!jQuery(".categories").is(":checked")){
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
		url: URL +"product/copy", 
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
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> product not added.</div>');
			}
			else
			{
				$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> product added.</div>');
				//window.setTimeout(function(){window.location.href = "<?php echo site_url(); ?>product/";}, 1500);

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

				var str = '<tr id="rowBore_'+htmlStr.insert_id+'"><td>'+htmlStr.name+'</td><td><button type="button" class="btn btn-danger" onclick="removeBore('+htmlStr.insert_id+')">Remove</button></td></tr>';
				$('#boreTab').append(str);
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

				var str = '<tr id="rowSolid_'+htmlStr.insert_id+'"><td>'+htmlStr.name+'</td><td><button type="button" class="btn btn-danger" onclick="removeSolid('+htmlStr.insert_id+')">Remove</button></td></tr>';
				$('#solidTab').append(str);
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

				var str = '<tr id="rowBath_'+htmlStr.insert_id+'"><td>'+htmlStr.name+'</td><td><button type="button" class="btn btn-danger" onclick="removeBath('+htmlStr.insert_id+')">Remove</button></td></tr>';
				$('#bathTab').append(str);
			}
		});
	}
}


function addTank()
{
		var val = $('#nameTank').val();

		if(val==""){
			$('#tankBox').modal('toggle');
		}else{
		var form_data = new FormData($("#addTank")[0]);
		$.ajax({
		url: URL +"product/addTank", 
		type: "post", 
		data: form_data,     
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function (htmlStr)
			{
				console.log(htmlStr);
				$('#tank_type').append('<option value="'+htmlStr.insert_id+'">'+htmlStr.name+'</option>');
				$('#addTank').trigger('reset');
				$('#tankBox').modal('toggle');

				var str = '<tr id="rowTank_'+htmlStr.insert_id+'"><td>'+htmlStr.name+'</td><td><button type="button" class="btn btn-danger" onclick="removeTank('+htmlStr.insert_id+')">Remove</button></td></tr>';
				$('#tankTab').append(str);
			}
		});
	}
}


function removeTank(id)
{
	if(confirm("Are you sure, you want to delete this?")){
		var form_data = "id="+id;
		$.ajax({
		url: URL +"product/removeTank", 
		type: "post", 
		data: form_data,     
		dataType: 'json',
		success: function (htmlStr)
			{
				$('#rowTank_'+id).remove();
				$('#optTank_'+id).remove();
			}
		});
	}

}


function addContent(){

	var contentTemp = $('.contentInput').length +1;
	var cloneData = '<div class="contentInput rowCon_'+contentTemp+'"><div class="col-md-10"><input type="text" class="form-control" value="" name="content[]" placeholder=""></div><div class="col-md-2"><button type="button" class="btn btn-danger removeContent" onclick="removeContent('+contentTemp+')">Remove</button></div></div>';
	$('.contentBox').append(cloneData);

}

function removeContent(str){
    $('.rowCon_'+str).remove();
}

</script>