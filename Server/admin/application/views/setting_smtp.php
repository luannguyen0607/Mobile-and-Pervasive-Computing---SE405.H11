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
					<h3>SMTP Setting</h3>
				  </div>
			</div>
            <div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">
                      <form action = "<?php echo base_url();?>setting/smtp" class="form-horizontal style-form" method="post" data-toggle="validator">
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Smtp Host</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                  <input name="host" value="<?php echo $this->setting_model->get_setting('smtp_host');?>" type="text" class="form-control" placeholder="Smtp.gmail.com"/>
                              </div>
                          </div>
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Smtp Type</label>
							 <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-5">
								<div class = "row">									
									<div class = "col-sm-4">
									  <label>
										<input <?php
										if ($this->setting_model->get_setting('smtp_type') == 1) {
											echo "checked";
										}
										?> type="radio" name="type" id="SmtpType" value="1" >
										SSL
									  </label>
									</div>
									
									<div class = "col-sm-4">
									  <label>
										<input <?php
										if ($this->setting_model->get_setting('smtp_type') == 2) {
											echo "checked";
										}
										?> type="radio" name="type" id="SmtpType" value="2">
										TLS
									  </label>
									</div>
								</div>
                              </div>
                          </div>
						  
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Smtp port</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                <input name="port" value="<?php echo $this->setting_model->get_setting('smtp_port');?>" type="number" class="form-control" placeholder="456">
                              </div>
                          </div>
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Smtp User</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                <input name="user" value="<?php echo $this->setting_model->get_setting('smtp_user');?>" type="text" class="form-control" placeholder="hoa219@gmial.com"> 
                              </div>
                          </div>
						  
						   <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Smtp Pass</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                <input name="pass" type="password" class="form-control" placeholder="password"> 
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