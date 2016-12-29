<?php
// if (isset($id)) {
	// $data = $this->client_model->get_user($id);
	// $settings = $this->setting_model->get_setting('title');
	// print_r($settings);
	// $songs = $this->user_song_model->get_all_song();
	// if (!$data) {
		// redirect(base_url() ."user_management");
	// }
	// echo json_encode($user_songs);
// }

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
					<h3>General Setting</h3>
				  </div>
			</div>
            <div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">
                      <form enctype="multipart/form-data" action="<?php echo base_url();?>setting" class="form-horizontal style-form" method="post" data-toggle="validator">

                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Titte</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                  <input name="title" value="<?php echo $this->setting_model->get_setting('title');?>" type="text" data-minlength="8" class="form-control" placeholder="Koong Meadia" required />
                              </div>
                          </div>
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Logo</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                <div class="row">
											<div class = "col-sm-9">
												<input id="uploadFilename_Logo" placeholder="Filename Logo" disabled="disabled" class = "form-control"/>
											</div>
											<div class = "col-sm-3">
												<div class="fileUpload btn btn-theme">
													<span>Browe</span>
													<input accept="image/*" name="logo" id="uploadBtn_Filename_Logo" type="file" class="upload" />
												</div>
											</div>
								</div>
                              </div>
                          </div>
						  
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Email</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                <input name="email" value="<?php echo $this->setting_model->get_setting('email');?>" type="email" class="form-control">
                              </div>
                          </div>
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Address</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                <input name="address" value="<?php echo $this->setting_model->get_setting('address');?>" type="text" class="form-control"> 
                              </div>
                          </div>
							
						  <div class="form-group">
                              <div class="col-sm-4 col-sm-offset-3">
                                <div class="row">
									<div class = "col-sm-6">
										<div class="btn-group btn-group-justified">
											<div class="btn-group">
												<a href="<?php echo base_url();?>setting" class="btn btn-theme">Cancel</a>
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

      <!--main content end-->


<?php $this->view('footer'); ?>