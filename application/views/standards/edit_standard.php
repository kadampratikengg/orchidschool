<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">
			Manage Standards
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><a href="<?php echo base_url('standards'); ?>">Standards</a>
					<i class="fa fa-angle-right"></i></li>
				<li><span>Edit Standard</span></li>
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
								class="caption-subject bold uppercase"> Edit Standard</span>
						</div>
						<div class="actions">
							<a href="<?php echo base_url('standards');?>"
								class="btn btn-circle default"> Back</a>
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
						<form id="add_staff_form" class="horizontal-form"
							action="<?php echo base_url('standards/update_standard/'.$standard_data['standard_id']);?>" method="post">
							<div class="form-body">
								<h3 class="form-section">Standards Details</h3>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Standard</label> 
											<input id="standard_name" name="standard_name" class="form-control"
												type="text" value="<?php echo set_value('standard_name',$standard_data['standard_name']);?>">
											<input id="standard_id" value="<?php echo $standard_data['standard_id']; ?>" hidden>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Standard Prefix</label> <select
												id="standard_prefix" name="standard_prefix"
												class="form-control" onchange="check_standard_prefix(this.value)">
												<?php ?>
												
												<option value="">Selelct</option>
												<?php for($prefix = 'A'; $prefix < 'Z'; $prefix++) {	?>
													<option value="<?php echo $prefix;?>"
													<?php echo set_select('standard_prefix',$prefix,(($standard_data['standard_prefix'] == $prefix)? TRUE : FALSE ));?>>
														<?php echo $prefix;?>
								                    </option>
											    <?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Total Fees</label> <input
												id="total_fees" name="total_fees" class="form-control"
												type="text" value="<?php echo set_value('total_fees',$standard_data['total_fees']);?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group" >
											<div></div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group" >
											<div id="prefix_msg"></div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn green-meadow">
										<i class="fa fa-check"></i> Save
									</button>
									<a href="<?php echo base_url('standards')?>" class="btn default">Cancel</a>
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
$data ['script'] = "standards.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>