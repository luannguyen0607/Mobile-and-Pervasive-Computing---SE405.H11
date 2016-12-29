<?php
if (!isset($user_id) || isset($this->session->userdata['logged_in'])) {
	redirect('user_authentication/user_login_process');
}
$CI =& get_instance();
$CI->load->model('setting_model');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title><?php echo $CI->setting_model->get_setting('title');?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">
			  <img width="100" src = "<?php echo base_url();?>assets\img\logo.png"/>
		      <form id="reset_pass_form" class="form-login" action="<?php echo base_url();?>user_authentication/reset_pass_action" method="post" accept-charset="utf-8">
				
		        <h2 class="form-login-heading">Reset password</h2>
		        <div class="login-wrap">
					<input name="user_id" type="hidden" value="<?php echo $user_id?>">
					<input name="token" type="hidden" value="<?php echo $token?>">
		            <input id="new_pass" name="new_pass" type="password" class="form-control" placeholder="New password" autofocus>
		            <br>
		            <input type="password" name="re_pass" class="form-control" placeholder="Confirm password">
					<br>
					<button class="btn btn-theme btn-block" type="submit">Reset password</button>
					<div style ="clear:both;"></div>
		        </div>
		      </form>	  	
	  	
	  	</div>
	  </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("<?php echo base_url();?>assets/img/login-bg.jpg", {speed: 500});
		$("#reset_pass_form").validate({
			 
			rules: {
				new_pass :{
					required: true,
					minlength: 8 
				},
				re_pass :{
					required: true,
					minlength: 8,
					equalTo : "#new_pass",
				},
			},
			messages: {
				new_pass: {
					required: "Please enter password",
					minlength: "Min pass is 8 char"
				},
				re_pass: {
					required: "Please enter confirm password",
					minlength: "Min pass is 8 char",
					equalTo: "Please enter the same password again.",
				},
			}
			 
		});
    </script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
  </body>
</html>