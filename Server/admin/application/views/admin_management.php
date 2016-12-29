<?php
$data = $this->admin_model->get_list_user();

$this->view('header'); ?>
	  
<?php $this->view('menu'); ?>
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
<!--main content start-->

      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Admin management</h3>

              <div class="row mt">
                  <div class="col-md-12">
					
                      <div class="content-panel">
							
                          <table id = "user_table" class="table table-striped table-advance table-hover">
                              <thead>
                              <tr>
								  <th style="text-align:center" >Edit</th>
                                  <th style="text-align:center" class="hidden-phone"><i class="fa fa-user"></i> User Name</th>
                                  <th><i class="fa fa-hand-o-right" aria-hidden="true" ></i> Name</th>
								  <th><i class="fa fa-cubes" aria-hidden="true"></i> Email</th>
								  <th style="text-align:center" >Detele</th>
                              </tr>
                              </thead>
                              <tbody>
								<?php
								foreach ($data as $da) { ?>
								  <tr>
									  <td align="center"><a href ="<?php echo base_url() ."admin_management/edit_user/". $da['id'];?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a></td>
									  <td align="center"  class="hidden-phone">
										<?php echo $da['username'];?>
										<div class ="setting-class"> 
										</div>
									  </td>
									  <td><?php echo $da['name'];?></td>
									  <td><?php echo $da['email'];?></td>
									  <td align="center">
										<form class = "detele-form" action="<?php echo base_url() ."admin_management/delete_user";?>" method = "post">
												<input type="hidden" name="id" value="<?php echo $da['id'];?>">
												<a class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
										</form>
									  </td>
								  </tr>
								<?php }?>  
								<div style="display : none" class="dialog" title="Warning">
									<p>Are you sure to detele this admin?</p>
								</div>
								<div style="display : none" id="dialog"  title="Warning">
									<p>You can't delete your account</p>
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
$( function() {
	$( ".dialog" ).dialog({
		autoOpen: false
	});
	 $(".btn-danger").on("click", function(e) {
		e.preventDefault();
		var submitform =  $(this).parent();
		var admin = "<?php echo $this->session->userdata['logged_in']['id'];?>";
		var current_id = submitform.find('input[name="id"]').val();
		if (admin == current_id) {
			$( "#dialog" ).dialog({
				autoOpen: true,
					show: "blind",
					hide: "explode",
					modal: true,
					open: function(event, ui) {
						setTimeout(function(){
							$('#dialog').dialog('close');                
						}, 1000);
					}
			});
		} else {
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
		}		
	 });  
	 $('#user_table').DataTable({
		 language: {
			search: "_INPUT_",
			searchPlaceholder: "Search here..."
		}
	 });
	 $('#user_table_length').prepend('<div class="form-group"> <a href = "<?php echo base_url();?>admin_management/add_new_user"><input type = "button" value = "Add Admin" class="btn btn-theme"/></a></div>');
	 $('#user_table_info').prepend('<div class="form-group"> <a href = "<?php echo base_url();?>admin_management/add_new_user"><input type = "button" value = "Add Admin" class="btn btn-theme"/></a></div>');
	 $('#user_table_filter input').addClass('form-control');
	 $('#user_table_length label select').addClass('btn btn-theme dropdown-toggle');
	 $('table.dataTable thead').click(function(){
		  $('#user_table_info').prepend('<div class="form-group"> <a href = "<?php echo base_url();?>admin_management/add_new_user"><input type = "button" value = "Add New User" class="btn btn-theme"/></a></div>');
	 });
});
</script>