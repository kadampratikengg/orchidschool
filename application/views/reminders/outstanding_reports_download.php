<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">Outstanding Fees Report</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Reports</span></li>
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
								class="caption-subject bold uppercase">Outstanding Reports Download</span>
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
						<form id="send_reminders" class="horizontal-form"
							action="<?php echo base_url('reminders/download_orustanding_reports');?>"
							method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Standard</label> 
											<select id="standard_id" name="standard_id" class="form-control"
												onchange="get_instalmetns(this.value);">
												<option value="">Select</option>
												<option value="all">All</option>
													<?php foreach ( $standards as $row ){ ?>
														<option value="<?php echo $row['standard_id'];?>"
															<?php echo set_select("standard_id",$row['standard_id']);?>>
															<?php echo $row['standard_name'];?>
									                    </option>
								                  	<?php } ?>
											</select>
										</div>
									</div>
									<div id="standard_instalments" class="col-md-4">
										<div class="form-group">
											<label class="control-label">Instalment</label> <select
												id="standard_instalment_id" name="standard_instalment_id"
												class="form-control">
												<option value="">Select Standard First</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
										<label class="control-lable">&nbsp;</label>
											<button class="pull-right btn green-meadow btn-md">
													<i class="fa fa-download"></i> Download Report</button>
										</div>
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

<script>
	var base_url = "<?php echo base_url(); ?>";
</script>

<?php
$data ['script'] = "reminders.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>