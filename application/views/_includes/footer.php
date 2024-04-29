    
        </div>
        <!-- END CONTAINER -->

<div class="modal fade" id="my_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="my_modal_title">Modal title</h4>
      </div>
      <div class="modal-body" id="my_modal_body">
        <p>One fine body&hellip;</p>
      </div>
     
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> 2016 &copy; Developed by <a href="http://www.angularminds.com" target="_blank">Angular Minds</a>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>




        <!-- END FOOTER -->

        <!--[if lt IE 9]>
<script src="<?php echo assets_path; ?>global/plugins/respond.min.js"></script>
<script src="<?php echo assets_path; ?>global/plugins/excanvas.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo assets_path; ?>global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <!-- for autocomplete -->
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
          
        <script src="<?php echo assets_path; ?>global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        
<script src="<?php echo assets_path; ?>global/scripts/datatable.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
 <script src="<?php echo assets_path; ?>global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
 <script src="<?php echo assets_path; ?>global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
 <script src="<?php echo assets_path; ?>global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
 <script src="<?php echo assets_path; ?>global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
 <script src="<?php echo assets_path; ?>global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo assets_path; ?>global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo assets_path; ?>pages/scripts/dashboard.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>pages/scripts/table-datatables-managed.js" type="text/javascript"></script>
	<script src="<?php echo scripts_path;?>_comman.js"></script>

	<?php 
	echo "<script src=\"".scripts_path."$script\" type=\"text/javascript\"></script>";
	?>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo assets_path; ?>layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->

	<script>
	    jQuery(document).ready(function() {    
		commanFunctions.init();
	        <?php echo $initialize;?>

	    });
	
	</script>
    </body>

</html>