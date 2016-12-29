<?php 
$count_client =  $this->login_database->count_client();
$count_song = $this->login_database->count_song();
$user_song = $this->login_database->get_new_download();

$this->view('header'); ?>
	  
<?php $this->view('menu'); ?>
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">

              <div class="row">
                  <div class="col-lg-12 main-chart">
                  
                  	<div class="row mtbox">
 
                  		<div class="col-md-6 col-sm-6 box0">
							<a href="<?php echo base_url('user_management');?>">
								<div class="box1">
									<span class="li_user"></span>
									<h3><?php echo $count_client;?></h3>
								</div>
								<p>Have <?php echo $count_client;?> user.</p>
							</a>
                  		</div>
                  		<div class="col-md-6 col-sm-6 box0">
							<a href="<?php echo base_url('song_management');?>">
								<div class="box1">
									<span class="li_music"></span>
									<h3><?php echo $count_song;?></h3>
								</div>
								<p>Have <?php echo $count_song;?> song.</p>
							</a>
                  		</div>
                  	
                  	</div><!-- /row mt -->	
                  
                <div class="row mt">
                  <div class="col-md-12">
                      <div class="content-panel">
                          <table id="usersong" class="table table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> Newdowload</h4>
	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th><i class="fa fa-user"></i> Custom Name</th>
                                  <th class="hidden-phone"><i class="fa fa-music"></i> Song Name</th>
								  <th><i class="fa fa-calendar-o"></i> Date</th>
                                  <th><i class="fa fa-bookmark"></i> Status</th>
                                 
                                 
                              </tr>
                              </thead>
                              <tbody>
								<?php
								foreach ($user_song as $us) { ?>
									<tr>
									  <td><a href="<?php echo base_url('user_management') ."/edit_user/". $us['user_id']?>"><?php echo $us['username'];?></a></td>
									  <td class="hidden-phone"><a href="<?php echo base_url('song_management') ."/edit_song/". $us['song_id']?>"><?php echo $us['song_name'];?></td>
									  <td><?php echo $us['modify_date'];?></td>
									  <td><span class="label label-mini">
										<?php if ($us['status'] == '1') {
											echo "Dowloaded";
										} else {
											echo "New";
										}?>
										</span></td>

									</tr>
								<?php } ?>
                              </tbody>
                          </table>
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->  
					  
					  

                    
                    				
	
					
                  </div><!-- /col-lg-12 END SECTION MIDDLE -->
                  
                  
      <!-- **********************************************************************************************************************************************************
      RIGHT SIDEBAR CONTENT
      *********************************************************************************************************************************************************** -->                  

				  
				  
				  
				  
              </div><! --/row -->
          </section>
      </section>

      <!--main content end-->
<?php $this->view('footer'); ?>
<script>
$(function() {
	$('#usersong').DataTable({
		"aaSorting": [[2,'desc']]
  } );	
});
</script>