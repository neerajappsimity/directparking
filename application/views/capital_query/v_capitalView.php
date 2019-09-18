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
					<form class="form-horizontal form-row-seperated" id="editUserForm" method='post' enctype="multipart/form-data" action="javascript:viewUser();">
					
						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-user"></i> <?php echo $pageHeading;?>
								</div>
								<div class="actions btn-set">
									<button class="btn default" onclick="goBack();"><i class="fa fa-reply"></i> Back</button>
									
								</div>
							</div>

							<div class="portlet-body">

							<div class="col-md-12 col-sm-12">
												<div class="portlet blue box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Customer Information
														</div>
														
													</div>
													<div class="portlet-body">

													<div class="row static-info">
															<div class="col-md-5 name">
																 Company Name:
															</div>
															<div class="col-md-7 value">
																 <?php echo $queryData['company']; ?>
															</div>
													</div>

														<div class="row static-info">
															<div class="col-md-5 name">
																 Customer Name:
															</div>
															<div class="col-md-7 value">
																 <?php echo $queryData['fname'].' '.$queryData['lname']; ?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Email:
															</div>
															<div class="col-md-7 value">
																<?php echo $queryData['email'];?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 User Type:
															</div>
															<div class="col-md-7 value">
																<?php echo $queryData['user_type'];?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																Mobile:
															</div>
															<div class="col-md-7 value">
																<?php echo $queryData['mobile'];?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																
															</div>
															<div class="col-md-7 value">
																<a href="mailto:" class="btn btn-danger">Create Mail</a>
															</div>
														</div>
													</div>
												</div>
											</div>


							<div class="form-body">
									<div class="form-group">
											<label class="col-md-4 control-label">What is the Application?
											</label>
											<div class="col-md-8">
											<?php echo ucfirst($queryData['application']); ?>
											</div>
									</div>
									<div class="form-group">
											<label class="col-md-4 control-label">What fluid is to be handled?
											</label>
											<div class="col-md-8">
											<?php echo ucfirst($queryData['fluid']); 
											if(!empty($queryData['fluid_water'])){
												echo "->".$queryData['fluid_water'];
											}
											if(!empty($queryData['fluid_water_type'])){
												echo "->".$queryData['fluid_water_type'];
											}
											if(!empty($queryData['chemical_liquid'])){
												echo "->".$queryData['chemical_liquid'];
											}
											if(!empty($queryData['fluid_other'])){
												echo "->".$queryData['fluid_other'];
											}
											?>
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-4 control-label">Source of Water?
											</label>
											<div class="col-md-8">
											<?php echo ($queryData['liquid_temprature']); ?>
											</div>
									</div>


									<div class="form-group">
											<label class="col-md-4 control-label">Phase?
											</label>
											<div class="col-md-8">
											<?php echo ($queryData['phase']); ?>
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-4 control-label">Power Rating?
											</label>
											<div class="col-md-8">
											<?php echo $queryData['power_rating']." ".$queryData['power_rating_measurement']; ?>
											</div>									
									</div>

									<div class="form-group">
											<label class="col-md-4 control-label">Required Head?
											</label>
											<div class="col-md-8">
											<?php echo $queryData['head']." ".$queryData['required_head_measurement']; ?>
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-4 control-label">Required Flow Rate?
											</label>
											<div class="col-md-8">
											<?php echo $queryData['flow_rate']." ".$queryData['flow_rate_measurement']; ?>
											</div>

									</div>



									<div class="form-group">
											<label class="col-md-4 control-label">Temperature of the liquid??
											</label>
											<div class="col-md-8">
											<?php echo ($queryData['liquid_temprature']); ?>
											</div>

									</div>

									<div class="form-group">
											<label class="col-md-4 control-label">Specific Gravity of the liquid?
											</label>
											<div class="col-md-8">
											<?php echo ($queryData['liquid_gravity']); ?>
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-4 control-label">Type of Motor?
											</label>
											<div class="col-md-8">
											<?php echo ($queryData['motor_type']); ?>
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-4 control-label">Power of the motor?
											</label>
											<div class="col-md-8">
											<?php echo ($queryData['motor_power']); ?>
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-4 control-label">Speed of motor (RPM)?
											</label>
											<div class="col-md-8">
											<?php echo ($queryData['motor_speed']); ?>
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-4 control-label">Poles?
											</label>
											<div class="col-md-8">
											<?php echo ($queryData['poles']); ?>
											</div>
									</div>

									<div class="form-group">
											<label class="col-md-4 control-label">Class of motor?
											</label>
											<div class="col-md-8">
											<?php echo $queryData['motor_class'];

											
											if(!empty($queryData['class_premium'])){
												echo "->".$queryData['class_premium'];
											}
											 ?>
											</div>
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

function goBack(){
    window.setTimeout(function(){window.history.back();});
}
</script>