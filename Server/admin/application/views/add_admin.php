<?php
if (isset($id)) {
	$data = $this->admin_model->get_user($id);
	if (!$data) {
		redirect(base_url() ."admin_management");
	}
	// echo json_encode($user_songs);
}

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
					<h3><?php
					if (isset($id)) {
						echo "Edit admin";
					} else {
						echo "Add admin";
					}
					?></h3>
				  </div>
			</div>
            <div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">
                      <form id  = "add_new_user_form" class="form-horizontal style-form" action="<?php
						if (isset($id)) {
							echo base_url() ."admin_management/edit_user/". $id;
						} else {
							echo base_url() ."admin_management/add_new_user";
						}	  
					  
					  ?>" method="post" enctype="multipart/form-data" data-toggle="validator">
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">User Name *</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                  <input <?php if (isset($id)){echo 'readonly="readonly"';}?> <?php echo isset($data) && $data? 'value ="' .$data["username"]. '"' : ""; ?>  name="adminname" type="text"  class="form-control" placeholder="User Name" />
                              </div>
                          </div>
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Password *</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                <input name="password" type="password" class="form-control" id="inputPassword" placeholder="Password" <?php if (!isset($id)){echo "required";}?>/>
                              </div>
                          </div>						  
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Name *</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                <input type="text" class="form-control" <?php echo isset($data) && $data? 'value ="' .$data["name"]. '"' : ""; ?> name = "name" id = "name" placeholder="Name" > 
                              </div>
                          </div>
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Email *</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                <input type="email" <?php echo isset($data) && $data? 'value ="' .$data["email"]. '"' : ""; ?> class="form-control" id="email"  name = "email" placeholder="Email">
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
			 password :{
				 minlength: 8 
			 },
			 adminname: 	"required",
			 name:		"required",
			 email: {
				  required: true,
				  email: true
			 }
		 },
		 messages: {
			password: {
				 required: "Please enter password",
				 minlength: "Min pass is 8 char"
			},
			 adminname: "Please Enter User Name",
			 name:	   "Please Enter Name",
			 email:	   {
				required:  "Please Enter Email",
				email:	   "Email invalid"
			}
		 }
		 
	});
});
</script>