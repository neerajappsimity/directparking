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
		<h3 class="form-title">Forgot Password</h3>
		 <div class="form-group" id="message" style="dispaly:none;"></div>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
				 Enter new password.
			</span>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<?php 
             $id= base64_decode($_REQUEST['token']);?>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="hidden" autocomplete="off" id="id" placeholder="id" name="id" value="<?php echo $id; ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9"> Email....</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="email" autocomplete="off" placeholder="email" name="email" id="email" required />
			</div>
		</div>
		<div class="form-actions">
			<!--label class="checkbox">
			<input type="checkbox" name="remember" value="1"/> Remember me </label-->
			<button type="submit" class="btn pull-right" style="background-color:#232325;color:#fff;">
			Save  <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
		<?php //echo $msg;?>
		
		<!--div class="forget-password">
			<h4>Forgot your password ?</h4>
			<p>
				 no worries, click
				<a href="javascript:;" id="forget-password">
					 here
				</a>
				 to reset your password.
			</p>
		</div>
		<div class="create-account">
			<p>
				 Don't have an account yet ?&nbsp;
				<a href="javascript:;" id="register-btn">
					 Create an account
				</a>
			</p>
		</div-->
		<div class="copyright">
	 		2018 &copy; Direct Parking Admin Dashboard.
		</div>
	</form>
	<!-- END LOGIN FORM -->
	<!-- BEGIN FORGOT PASSWORD FORM -->
	<!--form class="forget-form" action="index.html" method="post">
		<h3>Forget Password ?</h3>
		<p>
			 Enter your e-mail address below to reset your password.
		</p>
		<div class="form-group">
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>
			</div>
		</div>
		<div class="form-actions">
			<button type="button" id="back-btn" class="btn">
			<i class="m-icon-swapleft"></i> Back </button>
			<button type="submit" class="btn green pull-right">
			Submit <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
	</form-->
	<!-- END FORGOT PASSWORD FORM -->
	<!-- BEGIN REGISTRATION FORM -->
	<!--form class="register-form" action="index.html" method="post">
		<h3>Sign Up</h3>
		<p>
			 Enter your personal details below:
		</p>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Full Name</label>
			<div class="input-icon">
				<i class="fa fa-font"></i>
				<input class="form-control placeholder-no-fix" type="text" placeholder="Full Name" name="fullname"/>
			</div>
		</div>
		<div class="form-group">
			
			<label class="control-label visible-ie8 visible-ie9">Email</label>
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				<input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="email"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Address</label>
			<div class="input-icon">
				<i class="fa fa-check"></i>
				<input class="form-control placeholder-no-fix" type="text" placeholder="Address" name="address"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">City/Town</label>
			<div class="input-icon">
				<i class="fa fa-location-arrow"></i>
				<input class="form-control placeholder-no-fix" type="text" placeholder="City/Town" name="city"/>
			</div>
		</div>
		
		<p>
			 Enter your account details below:
		</p>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Username</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" id="username" autocomplete="off" placeholder="Username" name="username"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Password</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="password" placeholder="Password" name="password"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
			<div class="controls">
				<div class="input-icon">
					<i class="fa fa-check"></i>
					<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="rpassword"/>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label>
			<input type="checkbox" name="tnc"/> I agree to the
			<a href="#">
				 Terms of Service
			</a>
			 and
			<a href="#">
				 Privacy Policy
			</a>
			</label>
			<div id="register_tnc_error">
			</div>
		</div>
		<div class="form-actions">
			<button id="register-back-btn" type="button" class="btn">
			<i class="m-icon-swapleft"></i> Back </button>
			<button type="submit" id="register-submit-btn" class="btn green pull-right">
			Sign Up <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>

		
	</form-->
	<!-- END REGISTRATION FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->

<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
	<script src="assets/plugins/respond.min.js"></script>
	<script src="assets/plugins/excanvas.min.js"></script> 
	<![endif]-->
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
		var email = document.getElementById("email").value;
		var dataToSend = "id="+id+"&email="+email;
		//alert(dataToSend);
		$.ajax({
		url: URL +"welcome/forgotPassword", 
		type: "post", 
		data: dataToSend,     
		cache: false,
		  success: function(data) {
			console.log(data);
			  if(data == 'truetrue')
			  {
					alert('Forgot password link has been sent to your registered email address. ');
				  window.location = URL +"Welcome/login";
				  //window.location = URL +"welcome/thanku/?type=admin";
			  }
			  else
			  {
			  	  alert('Email does not exist.');
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