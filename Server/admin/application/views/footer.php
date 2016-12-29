      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
          ---------------------------
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
		<div id="note" style="display:none;" title="Note"></div>
  </section>

    <!-- js placed at the end of the document so the pages load faster 
    <script src="<?php// echo base_url();?>assets/js/jquery.js"></script>
    <script src="<?php// echo base_url();?>assets/js/jquery-1.8.3.min.js"></script>-->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
    
    <script class="include" type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.sparkline.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
	
	

    <!--common script for all pages-->
    <script src="<?php echo base_url();?>assets/js/common-scripts.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="<?php echo base_url();?>assets/js/sparkline-chart.js"></script>    
	<script src="<?php echo base_url();?>assets/js/zabuto_calendar.js"></script>	
	<script src="<?php echo base_url();?>assets/js/custom.js"></script>
	<script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
	<script>
		$( function() {
			<?php if (isset($message_display)){?>
				var getnote = '<?php echo $message_display;?>';
				$('#note').html(getnote);
				$('#note').dialog({
					autoOpen: true,
					show: "blind",
					hide: "explode",
					modal: true,
					open: function(event, ui) {
						setTimeout(function(){
							$('#note').dialog('close');                
						}, 1500);
					}
				});
			<?php }?>
		});
		$(".select-all").click(function(event) {
			if(this.checked) {
			  // Iterate each checkbox
			  $(':checkbox').each(function() {
				  this.checked = true;
			  });
			}
			else {
			$(':checkbox').each(function() {
				  this.checked = false;
			  });
			}
		});
	</script>
  </body>
</html>