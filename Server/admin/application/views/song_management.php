<?php
$this->view('header'); 
$songs = $this->user_song_model->get_all_song();
?>

<?php $this->view('menu'); ?>


<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
			<div class="row mt">
                  <div class="col-md-12">
					<h3>Song management</h3>
				  </div>
			</div>
              <div class="row mt">
                  <div class="col-md-12">
						
                      <div class="content-panel">
                          <table  class="table table-striped table-advance table-hover" id="song_table">
                              <thead>
                              <tr>
								  <th style="text-align:center" >Edit</th>
                                  <th style="text-align:center" class="hidden-phone"><i class="fa fa-music" aria-hidden="true"></i> Song Name</th>
                                  <th><i class="fa fa-play" aria-hidden="true"></i> Album Name</th>
								  <th><i class="fa fa-microphone" aria-hidden="true"></i> Singer Name</th>
								  <th><i class="fa fa-calendar" aria-hidden="true"></i> Modify Date</th>
								  <th><i class="fa fa-user" aria-hidden="true"></i> User Create</th>
                                  
                              </tr>
                              </thead>
                              <tbody>
								<?php foreach ($songs as $song) {?>  
								  <tr>
									  <td align="center"><a href ="<?php echo base_url() ."song_management/edit_song/". $song['id'];?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a></td>
									  <td align="center" class="hidden-phone">
										<?php echo $song['song_name'];?>
										<div class ="setting-class">
											<form style="display : none" class = "detele-form" action="<?php echo base_url() ."song_management/delete_song";?>" method = "post">
												<input type="hidden" name="id" value="<?php echo $song['id'];?>">
												<a class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
											</form>
										</div>
									  </td>
									  <td><?php echo $song['album_name'];?></td>
									  <td><?php echo $song['singer_name'];?></td>
									  <td><?php echo $song['modify_date'];?></td>
									  <td><?php echo $this->login_database->get_name($song['owner_id']);?></td>
								  </tr>
								<?php } ?>
								<div class="dialog" title="Warning">
									<p>Are you sure to detele? All song of this user will be removed.</p>
								</div>
                              </tbody>
                          </table>
                      </div><!-- /content-panel -->
					  
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->

		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
<?php $this->view('footer'); ?>
	<script>
		$(document).ready(function(){
			
			$( ".dialog" ).dialog({
				autoOpen: false
			});
	  $(".btn-danger").on("click", function(e) {
		e.preventDefault();
		var submitform =  $(this).parent();
		$( ".dialog" ).dialog({
			show: "blind",
			hide: "explode",
			modal: true,
			buttons : {
				"Delete" : function() {
					submitform.submit();       
				},
				"Cancel" : function() {
					$(this).dialog("close");
				}
			}
		});
		$(".dialog").dialog("open");
	 });
			
	$('#song_table').DataTable({
		 language: {
			search: "_INPUT_",
			searchPlaceholder: "Search here..."
		}
	 });
	 
	 $('#song_table_length').prepend('<div class="form-group"> <a href = "<?php echo base_url();?>song_management/add_new_song"><input type = "button" value = "Add Song" class="btn btn-theme"/></a></div>');
	 $('#song_table_info').prepend('<div class="form-group"> <a href = "<?php echo base_url();?>song_management/add_new_song"><input type = "button" value = "Add Song" class="btn btn-theme"/></a></div>');
	 $('#song_table_filter input').addClass('form-control');
	 $('#song_table_length label select').addClass('btn btn-theme dropdown-toggle');
	 $('table.dataTable thead').click(function(){
		  $('#song_table_info').prepend('<div class="form-group"> <a href = "<?php echo base_url();?>song_management/add_new_song"><input type = "button" value = "Add Song" class="btn btn-theme"/></a></div>');
	 });
			
	});
	</script>