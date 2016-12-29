<?php
if (isset($id)) {
	$data = $this->client_model->get_user($id);
	$user_songs = $this->user_song_model->get_user_song_by_user_id($id);
	$songs = $this->user_song_model->get_all_song();
	if (!$data) {
		redirect(base_url() ."user_management");
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
						echo "Edit user";
					} else {
						echo "Add User";
					}
					?></h3>
				  </div>
			</div>
            <div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">
                      <form id  = "add_new_user_form" class="form-horizontal style-form" action="<?php
						if (isset($id)) {
							echo base_url() ."user_management/edit_user/". $id;
						} else {
							echo base_url() ."user_management/add_new_user";
						}	  
					  
					  ?>" method="post" enctype="multipart/form-data" data-toggle="validator">
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Status</label>
							 <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
								<div class = "col-sm-6">
								  <label>
									<input type="radio" name="status" id="optionsRadios1" value="active" <?php 
									if (isset($id)) {
										if ($data["status"] == "active") {
											echo "checked";
										}
									} else {
										echo "checked";
									}
									
									?>>
									Active
								  </label>
								</div>
								
								<div class = "col-sm-6 text-right">
								  <label>
									<input type="radio" name="status" id="optionsRadios1" value="deactive"<?php 
									if (isset($id) && $data["status"] != "active") {
										echo "checked";
									}									
									?>>
									Disable
								  </label>
								</div>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">User Name *</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                  <input <?php if (isset($id)){echo 'readonly="readonly"';}?> <?php echo isset($data) && $data? 'value ="' .$data["username"]. '"' : ""; ?>  name="client_name" type="text"  class="form-control" placeholder="User Name" />
                              </div>
                          </div>
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Password *</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                <input name="password" type="password" class="form-control" id="inputPassword" placeholder="Password" <?php if (!isset($id)){echo "required";}?>/>
                              </div>
                          </div>						  
						  <div class="form-group" id = "wap_uploadfile">
                             <label class="col-sm-2 col-sm-2 control-label">Upload File *</label>
							 <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
								<div class="row">
									<div class = "col-sm-12">
										<span class="help-block">Menu </span>
										<div class="row warp-row">
											<?php if(isset($id)) { ?>
											<div class = "col-sm-6">
												<a target="blank" href="<?php echo dirname(base_url()). "/uploads/menu/". $id ."_KTVMENU1.ini"?>" class="btn btn-theme">Download menu</a>
											</div>
											<?php }?>
											<div class = "<?php echo isset($id)? "col-sm-6": "col-sm-12";?>">
												<input accept=".ini" type="file" name = "menu" id="base-input-menu" class="form-control form-input form-style-base" <?php if (!isset($id)){echo "required";}?>>
												<input type="text" id="fake-input-menu" class="form-control form-input form-style-fake" placeholder="Upload menu" readonly>
												<span class="glyphicon glyphicon-open input-place"></span>
											</div>
											
										</div>
									</div>
									<div class = "col-sm-12">
										<span class="help-block">Song list </span>
										<div class = "row warp-row">
											<?php if(isset($id)) { ?>
											<div class = "col-sm-6">
												<a target="blank" href="<?php echo dirname(base_url()). "/uploads/songlist/". $id ."_SONGLIST.txt"?>" class="btn btn-theme">Download songlist</a>
											</div>
											<?php }?>
											<div class="<?php echo isset($id)? "col-sm-6": "col-sm-12";?>">
												<input accept=".txt" type="file" name = "songlist" id="base-input-songlist" class="form-control form-input form-style-base" <?php if (!isset($id)){echo "required";}?>>
												<input type="text" id="fake-input-songlist" class="form-control form-input form-style-fake" placeholder="Upload songlist" readonly>
												<span class="glyphicon glyphicon-open input-place"></span>
											</div>
										</div>
										
									</div>
								</div>
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
                              <label class="col-sm-2 col-sm-2 control-label">Phone</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                <input <?php echo isset($data) && $data? 'value ="' .$data["phone"]. '"' : ""; ?> class="form-control" id="phone"  name = "phone" placeholder="Phone number">
                              </div>
                          </div>
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Address</label>
							  <label class="col-sm-1 col-sm-1 control-label">:</label>
                              <div class="col-sm-4">
                                <input type="text" <?php echo isset($data) && $data? 'value ="' .$data["address"]. '"' : ""; ?> name = "address"  class="form-control" id="address" placeholder="Address" > 
                              </div>
                          </div>
							
						  <div class="form-group">
                             
						
                              <div class="col-sm-4 col-sm-offset-3">
                                <div class="row">
									
									<div class = "col-sm-6">
										<div class="btn-group btn-group-justified">
											<div class="btn-group">
												<a href="<?php echo base_url();?>user_management" type="button" class="btn btn-theme">Cancel</a>
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

			<?php if (isset($id)) {?>
				<div class="row mt">
					<div class="col-md-12">
                      <div class="content-panel">
						<form class="form-inline" role="form">
						  <div class="form-group">
							<a data-toggle="modal" href = "#myAdvancedSongModal">
								<input type = "button" value = "Add New Song" class="btn btn-theme"/>
							</a>
						  </div>							  
						</form>
						<form class="form-inline" role="form" method="post" action="<?php echo base_url() ."user_management/update_user_song/". $id;?>">
							</br>
							  <table class="table table-striped table-advance table-hover" id = "AdvancedSongtable">
								  <thead>
								  <tr>
									  <th style="text-align:center"><i class="fa fa-info" aria-hidden="true"></i> Song Id</th>
									  <th><i class="fa fa-music" aria-hidden="true"></i> Song Name</th>
									  <th><i class="fa fa-microphone" aria-hidden="true"></i> Singer Name</th>
									  <th><i class="fa fa-calendar" aria-hidden="true"></i> Date Create</th>
									  <th><i class="fa fa-bookmark" aria-hidden="true"></i> Status</th>
									  <th><i class="fa fa-download" aria-hidden="true"></i> Date Download</th>
									  <th> Delete</th>
									  
								  </tr>
								  </thead>
								  <tbody>
										<?php foreach ($user_songs as $user_song) {?>
										<tr>
										  <td align="center"><input type="hidden" name="user_songs[]" value="<?php echo $user_song['song_id'];?>"><?php echo $user_song['song_id'];?></td>
										  <td class="hidden-phone">
											<?php echo $user_song['song_name']; ?>
										  </td>
										  <td><?php echo $user_song['singer_name']; ?></td>
										  <td><?php echo $user_song['modify_date']; ?></td>
										  <td><span class="label label-info label-mini"><?php echo $user_song['status'] == 1 ? 'dowloaded' : 'new'; ?></span></td>
										  <td><?php echo $user_song['down_date']; ?></td>
										  <td><a class="btn btn-danger btn-xs user_song_delete"><i class="fa fa-trash-o "></i></a></td>
										</tr>
										<?php } ?>
								  </tbody>
							  </table>
							</br>
							<div class="form-group">
								<a href="<?php echo base_url();?>user_management" type="button" class="btn btn-theme">Cancel</a>
								<input type="submit" value="Save" class="btn btn-theme">
							</div>							  
						</form>
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->
			<?php } ?>
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->
		<?php if (isset($id)) {?>
			<div aria-hidden="true" aria-labelledby="Advanced" role="dialog" tabindex="-1" id="myAdvancedSongModal" class="modal fade">
			  <div class="modal-dialog">
				  <div class="modal-content">
					  <div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						  <h4 class="modal-title">Advanced Search</h4>
					  </div>
					  <div class="modal-body">
							<div class="content-panel">
								  <table class="table table-striped table-advance table-hover" id = "AdvancedSongtablepoup">
									  <thead>
									  <tr>
										  <th style="text-align : center"><input type="checkbox" class = "select-all"></th>
										  <th><i class="fa fa-music" aria-hidden="true"></i>  Song Name</th>
										  <th><i class="fa fa-microphone" aria-hidden="true"></i> Singer Name</th>
									  </tr>
									  </thead>
									  <tbody>
										<?php foreach ($songs as $song) {?>
										<tr>
										  <td align="center"><input class = "checkbox_get" type="checkbox" name = "<?php echo $song['id']; ?>"></td>
										  <td class="hidden-phone"><?php echo $song['song_name']; ?></td>
										  <td><?php echo $song['singer_name']; ?></td>
										</tr>
										<?php }?>
									  </tbody>
								  </table>
							  </div><!-- /content-panel -->

					  </div>
					  <div class="modal-footer">
						  <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
						  <button class="btn btn-theme" id="submit-song" type="button">Submit</button>
					  </div>
				  </div>
			  </div>
			</div>
		<?php } ?>

<?php $this->view('footer'); ?>

<script>
	
</script>


 <script>
$(function() {
	$("#add_new_user_form").validate({
		 
		 rules: {
			password :{
				minlength: 8 
			},
			client_name:	"required",
			name:	"required",
			menu:{
				accept: "ini"
			},
			songlist:{
				accept: "txt"
			},
			email: {
				required: true,
				email: true
			},
		 },
		 messages: {
			password: {
				 required: "Please enter password",
				 minlength: "Min pass is 8 char"
			},
			client_name: "Please Enter User Name",
			name:	   "Please Enter Name",
			menu:	{
				required: "Please upload menu file",
				accept: "Only accept menu.ini file"
			},
			songlist:	{
				required: "Please upload songlist file",
				accept: "Only accept songlist.txt file"
			},
			email:	   {
				required:  "Please Enter Email",
				email:	   "Email invalid"
			}
		 }
		 
	});
	$('#AdvancedSongtablepoup').DataTable();
	var t = $('#AdvancedSongtable').DataTable();
	$("#submit-song").click(function(){
		var rowCount = $('#AdvancedSongtablepoup tbody tr').length;
		var rows = $('#AdvancedSongtable tbody tr input');
		$(".checkbox_get:checked").each(function(){
			var row = $(this).closest("tr");
			var cell_zero = row.find("td").eq(0).find("input").attr("name");
			var cell_one = row.find("td").eq(1).text();
			var cell_two = row.find("td").eq(2).text();
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
					'',
					'',
					'',
					'<a class="btn btn-danger btn-xs user_song_delete"><i class="fa fa-trash-o "></i></a>'
				] ).draw( false );
			}
		});
		$('#myAdvancedSongModal').modal('hide');
	});
	$('#AdvancedSongtable').on( 'click', 'a.user_song_delete', function () {
		t.row( $(this).parents('tr') ).remove().draw();
	});		
});
</script>