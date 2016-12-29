<?php
if (isset($id)) {
	$data = $this->user_song_model->get_song($id);
	$user_songs = $this->user_song_model->get_user_song_by_song_id($id);
	$users = $this->client_model->get_list_user();
	if (!$data) {
		redirect(base_url() ."song_management");
	}
}
$languages = $this->user_song_model->get_language();
$song_types = $this->user_song_model->get_song_type();
$singer_classs = $this->user_song_model->get_singer_class();
$this->view('header');
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
					<h3><?php if (isset($id)) {
						echo "Edit song";
					} else {
						echo "Add song";
					} ?></h3>
				  </div>
			</div>
            <div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">
                      <form id="add_new_song_form" class="form-horizontal style-form" method="post" data-toggle="validator" action="<?php
						if (isset($id)) {
							echo base_url() ."song_management/edit_song/". $id;
						} else {
							echo base_url() ."song_management/add_new_song";
						}	  
					  
					  ?>">
                        <div class="form-group">
							<div class="col-sm-6">
								<span class="help-block">Song Name *</span>
                                <input <?php echo isset($data) && $data? 'value ="' .$data["song_name"]. '"' : ""; ?> type="text" class="form-control" name = "song_name">
                            </div>
							<div class="col-sm-6">
								<span class="help-block">Song Url *</span>
                                <input <?php echo isset($data) && $data? 'value ="' .$data["url"]. '"' : ""; ?> type="text" class="form-control" name = "url">
                            </div>
							<div class="col-sm-6">
								<span class="help-block">Initial Spelling of Singer</span>
                                <input <?php echo isset($data) && $data? 'value ="' .$data["singer_spell"]. '"' : ""; ?> type="text" class="form-control" name = "singer_spell">
                            </div>
							<div class="col-sm-6">
								<span class="help-block">Vocal / Music</span>
                                <input <?php echo isset($data) && $data? 'value ="' .$data["song_position"]. '"' : ""; ?> type="text" class="form-control" name  = "song_position">
                            </div>
							<div class="col-sm-6">
								<span class="help-block">Singer Classfication *</span>
								<select name="singer_class" class="form-control">
									<?php foreach ($singer_classs as $singer_class) {?>
									<option value="<?php echo $singer_class['code']; ?>"  <?php 
									
									if (isset($data) && $data["singer_class"] == $singer_class['code']) {
										echo "selected";
									}
									
									?>><?php echo $singer_class['name']; ?></option>
									<?php } ?>
								</select>								
                            </div>
							<div class="col-sm-6">
								<span class="help-block">Singer's Name</span>
                                <input <?php echo isset($data) && $data? 'value ="' .$data["singer_name"]. '"' : ""; ?> type="text" class="form-control" name = "singer_name">
                            </div>
							<div class="col-sm-6">
								<span class="help-block">Song Type Code *</span>
								<select name="song_type" class="form-control">
									<?php foreach ($song_types as $song_type) {?>
									<option value="<?php echo $song_type['code']; ?>"  <?php 
									
									if (isset($data) && $data["song_type"] == $song_type['code']) {
										echo "selected";
									}
									
									?>><?php echo $song_type['name']; ?></option>
									<?php } ?>
								</select>
                            </div>
							<div class="col-sm-6">
								<span class="help-block">The Word Count Of Sery</span>
                                <input <?php echo isset($data) && $data? 'value ="' .$data["name_count"]. '"' : ""; ?> type="text" class="form-control" name = "name_count">
                            </div>
							<div class="col-sm-6">
								<span class="help-block">Album Name</span>
                                <input <?php echo isset($data) && $data? 'value ="' .$data["album_name"]. '"' : ""; ?> type="text" class="form-control" name = "album_name">
                            </div>
							<div class="col-sm-6">
								<span class="help-block">Song's Language Item Code *</span>
								<select name="lang_code" class="form-control">
									<?php foreach ($languages as $language) {
										?>
									<option value="<?php echo $language['code']; ?>"  <?php 
									
									if (isset($data) && $data["lang_code"] == $language['code']) {
										echo "selected";
									}
									
									?>><?php echo $language['name']; ?></option>
									<?php } ?>
								</select>
                            </div>
							<div class="col-sm-6">
								<span class="help-block">Initial Letter Of Spelling Of Album Name</span>
                                <input <?php echo isset($data) && $data? 'value ="' .$data["album_spell"]. '"' : ""; ?> type="text" class="form-control" name = "album_spell">
                            </div>
							<div class="col-sm-6">
								<span class="help-block">Volume</span>
                                <input <?php echo isset($data) && $data? 'value ="' .$data["song_volume"]. '"' : ""; ?> type="text" class="form-control" name = "song_volume">
                            </div>
							<div class="col-sm-6">
								<span class="help-block">Singer Photo (File Name)</span>
                                <input <?php echo isset($data) && $data? 'value ="' .$data["singer_photo"]. '"' : ""; ?> type="text" class="form-control" name = "singer_photo">
                            </div>
							<div class="col-sm-6">
								<span class="help-block">Initial Spelling For Song Name</span>
                                <input <?php echo isset($data) && $data? 'value ="' .$data["name_spell"]. '"' : ""; ?> type="text" class="form-control" name = "name_spell">
                            </div>
							<div class="col-sm-6">
								<span class="help-block">Song Lyric</span>
                                <input <?php echo isset($data) && $data? 'value ="' .$data["song_lyric"]. '"' : ""; ?> type="text" class="form-control" name = "song_lyric">
                            </div>
							
                        </div>
						  
						<div class="form-group">
						  <div class="col-sm-4 col-sm-offset-3">
							<div class="row">
								
								<div class = "col-sm-6">
									<div class="btn-group btn-group-justified">
										<div class="btn-group">
											<a href="<?php echo base_url();?>song_management" type="button" class="btn btn-theme">Cancel</a>
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
				  
				 
				  
				<?php if (isset($id)) { ?>
				    <div class="content-panel">
						<div class = "row">	
							<div class="col-sm-6">
								  <div class="btn-group">
									<a data-toggle="modal" href="#myAdvancedModal">
										<input type="button" value="Add Custom For Song" class="btn btn-theme">
									</a>
								  </div>
								<br>
								<br>
							</div>
						</div>
						<form class="form-inline" role="form" method="post" action="<?php echo base_url() ."song_management/update_user_song/". $id;?>">
							<table class="table table-striped table-advance table-hover" id="user_table">
								<thead>
								<tr>
								  <th style="text-align:center"><i class="fa fa-id-card-o"></i> User_id</th>
								  <th class="hidden-phone"><i class="fa fa-user"></i> User</th>
								  <th><i class="fa fa-hand-o-right" aria-hidden="true" ></i> Name</th>
								  <th><i class="fa fa-envelope" aria-hidden="true"></i> Email</th>
								  <th><i class="fa fa-phone" aria-hidden="true"></i></i> Address</th>
								  <th><i class="fa fa-bookmark" aria-hidden="true"></i> Status</th>
								  <th><i class="fa fa-download" aria-hidden="true"></i> Date Download</th>
								  <th> Delete</th>
								</tr>
								</thead>
								<tbody>
								<?php foreach($user_songs as $user_song) { ?>
								   <tr>
									  <td align="center"><input type="hidden" name="user_songs[]" value="<?php echo $user_song['user_id'];?>"><?php echo $user_song['user_id'];?></td>
									  <td class="hidden-phone"><?php echo $user_song['username'];?></td>
									  <td><?php echo $user_song['name'];?></td>
									  <td><?php echo $user_song['email'];?></td>
									  <td><?php echo $user_song['address'];?></td>
									  <td><span class="label label-info label-mini"><?php echo $user_song['status'] == 1 ? 'dowloaded' : 'new'; ?></span></td>
									  <td><?php echo $user_song['down_date']; ?></td>
									  <td><a class="btn btn-danger btn-xs user_song_delete"><i class="fa fa-trash-o "></i></a></td>
								  </tr>
								<?php }?>
								</tbody>
							</table>
							<div class="form-group">
								<a href= "<?php echo base_url();?>song_management" class="btn btn-theme"/>Cancel</a>
								<input value = "Save" type = "submit" class="btn btn-theme"/>
							</div>							  
						</form>
                    </div><!-- /content-panel -->
					  
					<!-- Modal -->
					<div aria-hidden="true" aria-labelledby="Advanced" role="dialog" tabindex="-1" id="myAdvancedModal" class="modal fade">
					  <div class="modal-dialog">
						  <div class="modal-content">
							  <div class="modal-header">
								  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								  <h4 class="modal-title">Advanced Search</h4>
							  </div>
							  <div class="modal-body">
									<div class="content-panel">
					<table id="AdvancedSongtablepoup" class="table table-striped table-advance table-hover">
					  <thead>
					  <tr>
						  <th><input class = "select-all" type="checkbox"></th>
						  <th class="hidden-phone"><i class="fa fa-user"></i> User</th>
						  <th><i class="fa fa-hand-o-right" aria-hidden="true" ></i> Name</th>
						  <th><i class="fa fa-envelope" aria-hidden="true"></i> Email</th>
						  <th><i class="fa fa-phone" aria-hidden="true"></i></i> Address</th>
					  </tr>
					  </thead>
					  <tbody>
						<?php foreach($users as $user) {?>
						  <tr>
							  <td align="center" ><input class="checkbox_get" type="checkbox" name = "<?php echo $user['id']; ?>"></td>
							  <td class="hidden-phone"><?php echo $user['username']; ?></td>
							  <td><?php echo $user['name']; ?></td>
							  <td><?php echo $user['email']; ?></td>
							  <td><?php echo $user['address']; ?></td>
						  </tr>
						<?php } ?>
					  </tbody>
					</table>
					</div><!-- /content-panel -->

							  </div>
							  <div class="modal-footer">
								  <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
								  <button class="btn btn-theme" id="submit-user" type="button">Submit</button>
							  </div>
						  </div>
					  </div>
					</div>
					<!-- modal -->					
				<?php } ?>
				  
				  
				  
          		</div><!-- col-lg-12-->      	
          	</div><!-- /row -->

		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->

<?php $this->view('footer'); ?>
	
<script>
	$(function() {
		$("#add_new_song_form").validate({
			 
			 rules: {
				url : "required",
				song_name : "required"
			 },
			 messages: {
				url : "Please enter video url",
				song_name : "Please enter song name"
			 }
			 
		});
		$('#AdvancedSongtablepoup').DataTable();
		var t = $('#user_table').DataTable();
		$("#submit-user").click(function(){
			var rowCount = $('#AdvancedSongtablepoup tbody tr').length;
			var rows = $('#user_table tbody tr input');
			$(".checkbox_get:checked").each(function(){
				var row = $(this).closest("tr");
				var cell_zero = row.find("td").eq(0).find("input").attr("name");
				var cell_one = row.find("td").eq(1).text();
				var cell_two = row.find("td").eq(2).text();
				var cell_three = row.find("td").eq(3).text();
				var cell_four = row.find("td").eq(4).text();
				var check = true;
				rows.each(function()
				{
				  if ($(this).val() ==  cell_zero) {
					check = false;
				  }
				});
				if (check) {
					t.row.add( [
						"<center><input type='hidden' name='user_songs[]' value='" + cell_zero +"'>"+cell_zero+"</center>",
						cell_one,
						cell_two,
						cell_three,
						cell_four,
						'',
						'',
						'<a class="btn btn-danger btn-xs user_song_delete"><i class="fa fa-trash-o "></i></a>'
					] ).draw( false );
				}
			});
			 $('#myAdvancedModal').modal('hide');
			 $('#user_table').DataTable();
		});
		$('#user_table').on( 'click', 'a.user_song_delete', function () {
			t.row( $(this).parents('tr') ).remove().draw();
		});		
	});
</script>