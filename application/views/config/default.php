<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">System Configuration</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Config</span></li>
			</ul>

		</div>
		<!-- END PAGE HEADER-->

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption font-dark">
							<i class="icon-settings font-dark"></i> <span
								class="caption-subject bold uppercase">Config</span>
						</div>
							
					</div>
					<div class="portlet-body">
							 <?php if($this->session->flashdata("success_message")!=""){?>
		                <div class="Metronic-alerts alert alert-info fade in">
							<button type="button" class="close" data-dismiss="alert"
								aria-hidden="true"></button>
							<i class="fa-lg fa fa-check"></i>  <?php echo $this->session->flashdata("success_message");?>
		                </div>
		              <?php }?>
		              <?php if($this->session->flashdata("error_message")!=""){?>
		                <div
							class="Metronic-alerts alert alert-danger fade in">
							<button type="button" class="close" data-dismiss="alert"
								aria-hidden="true"></button>
							<i class="fa-lg fa fa-warning"></i>  <?php echo $this->session->flashdata("error_message");?>
		                </div>
		              <?php }?>
		              
		              <?php if(validation_errors()!=""){?>
		                <div
							class="Metronic-alerts alert alert-danger fade in">
							<button type="button" class="close" data-dismiss="alert"
								aria-hidden="true"></button>
							<i class="fa-lg fa fa-warning"></i>  <?php echo validation_errors();?>
		                </div>
		              <?php }?>
              
							<form class="form-horizontal form-row-seperated" action="<?php echo base_url("config/save#General");?>" method="post">
                      <div class="form-body">
                        <?php
					foreach($config_data as $row)
					{
					?>
                        <div class="form-group">
                          <label class="col-md-4 control-label text-align-right"><?php echo $row["help_text"];?></label>
                          <div class="col-md-8">
                            <input type="text" class="form-control input-large" name="config[]" 
                            placeholder="" value="<?php echo set_value('config[]',$row["config_value"]);?>" >
                            <input type="hidden" name="config_id[]" value="<?php echo $row["config_id"]; ?>" />
                          </div>
                        </div>
                        <?php }?>
                        <hr>
                        <div class="form-group">
                          <label class="col-md-4 control-label"></label>
                          <div class="col-md-8">
                            <button type="submit" class="btn green btn-circle"><i class="fa fa-check"></i> Update Settings</button>
                            &nbsp;&nbsp;&nbsp;
                            <button type="reset" class="btn default btn-circle">Reset</button>
                          </div>
                        </div>
                      </div>
                    </form>
					</div>
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
			</div>
		</div>

	</div>
	<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->

<?php
$data ['script'] = "students.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>


                    
                  