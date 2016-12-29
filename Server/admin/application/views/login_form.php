<?php
if (isset($this->session->userdata['logged_in'])) {
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
		      <form id="login_form" class="form-login" action="<?php echo base_url();?>user_authentication/user_login_process" method="post" accept-charset="utf-8">
				
		        <h2 class="form-login-heading">sign in now</h2>
		        <div class="login-wrap">
		            <input name = "username" type="text" class="form-control" placeholder="User name" autofocus>
		            <br>
		            <input type="password" name="password" class="form-control" placeholder="Password">
					<div style='color: red; margin-top: 10px' class='error_msg'><?php
						if (isset($error_message)) {
							echo $error_message;
						}
						?>
					</div>
		            <div class = "content-checkbox-btn">
						<label class="checkbox">
							<span class="pull-right">
								<a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>
			
							</span>
						</label>
						<button class="btn btn-theme btn-block" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
						<div style ="clear:both;"></div>
					</div>
		            <hr>
		            
<!-- 		            <div class="login-social-link centered">
		            <p>or you can sign in via your social network</p>
		                <button class="btn btn-facebook" type="submit"><i class="fa fa-facebook"></i> Facebook</button>
		                <button class="btn btn-twitter" type="submit"><i class="fa fa-twitter"></i> Twitter</button>
		            </div>
		            <div class="registration">
		                Don't have an account yet?<br/>
		                <a class="" href="#">
		                    Create an account
		                </a>
		            </div>
		 -->
		        </div>
				  
				<!-- check is mail flase-->
				  	<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="pop-mail-flase" class="modal fade">
		              <div class="modal-dialog">
		                  <div class="modal-content">
		                      <div class="modal-header">
		                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                          <h4 class="modal-title">Please enter your mail !</h4>
		                      </div>
		                  </div>
		              </div>
					</div>

				<!-- end check is mail flase-->  
				  
				  
				  
				  
		      </form>	  	
			  
					  <!-- Modal -->
		  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
			  <div class="modal-dialog">
				<form id="email_form" action="<?php echo base_url();?>user_authentication/forgot_password" method="post">
				  <div class="modal-content">
					  <div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						  <h4 class="modal-title">Forgot Password ?</h4>
					  </div>
					  <div class="modal-body">
						  <p>Enter your e-mail address below to reset your password.</p>
						  <input id  = "email" type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

					  </div>
					  <div class="modal-footer">
						  <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
						  <button class="btn btn-theme" id = "submit-email" type="submit">Submit</button>
					  </div>
				  </div>
				</form>
			  </div>
		  </div>
		  <!-- modal -->
	  	<div id="note" style="display:none;" title="Note"></div>
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
		function isEmail(email) {
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}
						
		// $("#submit-email").click(function(){
			// if( !isEmail($("#email").val())){
				// console.log("dsa");
				// $("#pop-mail-flase").modal('show');
			// }else{
				// alert("Please check your email and verify link to change pass Thank !!!");
			// }
		// });
		$( function() {
			<?php if (isset($message_display)){?>
			
				var getnote = '<?php echo $message_display;?>';
				console.log(getnote);
				$('#note').html(getnote);
				$('#note').dialog({
					autoOpen: true,
					show: "blind",
					hide: "explode",
					modal: true,
					open: function(event, ui) {
						setTimeout(function(){
							$('#note').dialog('close');                
						}, 1000);
					}
				});
			<?php }?>
			
			$("#login_form").validate({
				rules: {
					password :{
						required: true,
						minlength: 8
					},
					username: 	"required",
					name:		"required",
				 },
				messages: {
					password: {
						 required: "Please enter password",
						 minlength: "Min pass is 8 char"
					},
					username: "Please Enter User Name",
					name:	   "Please Enter Name",
				 }
			});
			
			$("#email_form").validate({
				rules: {
					 email: {
						  required: true,
						  email: true
					 }
				 },
				messages: {
					 email:	   {
						required:  "Please Enter Email",
						email:	   "Email invalid"
					}
				 }
			});
		});			
    </script>


  </body>
</html>