<?php
$this->view('header'); ?>

<?php $this->view('menu'); ?>
	  
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
			<div class="row mt">
                  <div class="col-md-12">
					<h3>Change password</h3>
				  </div>
			</div>
            <div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">
                      <form id  = "add_new_user_form" class="form-horizontal style-form" action="<?php echo base_url() ?>user_authentication/change_password" method="post" data-toggle="validator">
                          <input value="<?php echo $this->session->userdata['logged_in']['username']; ?>"  name="username" type="hidden"/>
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Current password *</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                <input name="old_pass" type="password" class="form-control" placeholder="Current password" <?php if (!isset($id)){echo "required";}?>/>
                              </div>
                          </div>						  
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">New password *</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                <input type="password" class="form-control" name="new_pass" id="new_pass" placeholder="New password" > 
                              </div>
                          </div>
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Confirm password *</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                <input type="password" class="form-control" id="re_pass" name="re_pass" placeholder="Confirm password" >
                              </div>
                          </div>
							
						  <div class="form-group">
                             
						
                              <div class="col-sm-4 col-sm-offset-3">
                                <div class="row">
									
									<div class = "col-sm-6">
										<div class="btn-group btn-group-justified">
											<div class="btn-group">
												<a href="<?php echo base_url();?>admin_management" type="button" class="btn btn-theme">Cancel</a>
											</div>		
										</div>
									</div>
									<div class = "col-sm-6">
										<div class="btn-group btn-group-justified">
											<div class="btn-group">
												<button type="submit" class="btn btn-theme">Save</button>
											</div>		
										</div>
									</div>
								</div>
                              </div>
                          </div>
                        
                      </form>
                  </div>
          		</div><!-- col-lg-12-->      	
          	</div><!-- /row -->
			
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

<?php $this->view('footer'); ?>

 <script>
$(function() {
	$("#add_new_user_form").validate({
		 
		 rules: {
			old_pass :{
				required: true,
				minlength: 8 
			},
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
			old_pass: {
				 required: "Please enter password",
				 minlength: "Min pass is 8 char"
			},
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
});
</script>