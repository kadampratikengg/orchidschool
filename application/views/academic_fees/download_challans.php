<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">
			Bulk Challan Download
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
					<li><a href="<?php echo base_url('academic_fees'); ?>">Academic Fees</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Download Challans</span></li>
			</ul>
		</div>
		<!-- END PAGE HEADER-->

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption font-dark">
							<i class="icon-settings font-dark"></i> 
							<span class="caption-subject bold uppercase">Download Challans</span>
						</div>
						<div class="actions">
							<a href="<?php echo base_url('academic_fees');?>"
								class="btn btn-circle default">
								Back </a>
						</div>
					</div>
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
						<form id="standards_selection_form" class="horizontal-form"
							action="<?php echo base_url('academic_fees/download_bulk_challan');?>" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label">Standard</label> <select
												id="standard_id" name="standard_id" class="form-control"
												onchange="get_divisions(this.value);get_instalments(this.value);">
												<option value="">Select</option>
												<option value="all">All</option>
												<?php
												foreach ( $standards_data as $row ) :
													?>
															<option value="<?php echo $row['standard_id'];?>"
															<?php echo set_select("standard_id",$row['standard_id']);?>>
																<?php echo $row['standard_name'];?>
										                    </option>
										                  	<?php
												endforeach
												;
												?>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label">Division</label> <select
												id="division_id" name="division_id" class="form-control">
												<option value="">Select Standard First</option>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label">Instalment</label> <select
												id="standard_instalment_id" name="standard_instalment_id" class="form-control">
												<option value="">Select Standard First</option>
											</select>
										</div>
									</div>
									<div class="col-md-3" style="margin-top: 25px;">
										<button id="submit" type="submit" class="btn green-meadow">
											<i class="fa fa-check"></i> Submit
										</button>
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

	<!-- </div> -->
	<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->

<script>
	var base_url = "<?php echo base_url(); ?>";
</script>

<?php
$data ['script'] = "download_challans.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>