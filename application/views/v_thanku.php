<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.1.1
Version: 2.0.2
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Direct Parking - Admin Dashboard</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url(); ?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assets/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assets/plugins/select2/select2-metronic.css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo site_url(); ?>assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url(); ?>assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url(); ?>assets/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url(); ?>assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo site_url(); ?>assets/css/pages/login.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url(); ?>assets/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
	<a href="index.html">
		<img width="200px" src="<?php echo site_url(); ?>assets/img/logo.png" alt=""/>
	</a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
	<form onsubmit="return forgot()" action="javascript:void(0)">
		<h3 class="form-title">Thank You!</h3>
		<div class="alert alert-success ">
			<button class="close" data-close="alert"></button>
			<span>
				Your password has been changed successfully.
				<?php 
				 /*if($_REQUEST['type']=='admin'){
				 echo "Your password has been changed successfully.";
				 }else{
				 	echo"Your password has been changed successfully.";
				 }*/ ?>
			</span>
		</div>
		
		
		
		<?php //echo $msg;?>
		
		
		<div class="copyright">
	 		2018 &copy; Direct Parking Admin Dashboard.
		</div>
	</form>
	
</div>

<script src="<?php echo site_url(); ?>assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>assets/plugins/select2/select2.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo site_url(); ?>assets/scripts/core/app.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/scripts/custom/login.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
		jQuery(document).ready(function() {     
		  //App.init();
		 // Login.init();
		});
var URL = "<?php echo base_url(); ?>";

	function forgot()
	{
		var id = document.getElementById("id").value;
		var password = document.getElementById("password").value;
		var dataToSend = "id="+id+"&password="+password;
		//alert(dataToSend);
		$.ajax({
		url: URL +"welcome/changePassword", 
		type: "post", 
		data: dataToSend,     
		cache: false,
		  success: function(data) {
			console.log(data);
			  if(data == 'true')
			  {
					//alert(data);
				  window.location = URL +"welcome/thanku";
			  }
			  else
			  {
				  //$('#username').css('border', 'solid 2px red');
				  //$('#password').css('border', 'solid 2px red');
				  //$("#username").effect( "shake" );
				  //$("#password").effect( "shake" );
				  
			  }
		  },
		  error: function(e) {
		  }
		});
	}
	
	</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>