<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">
			Manage Other Fees
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><a href="<?php echo base_url('other_fees'); ?>">Other Fees</a>
					<i class="fa fa-angle-right"></i></li>
				<li><span>Apply Other Fees</span></li>
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
								class="caption-subject bold uppercase"> Apply Other Fees to Students</span>
						</div>
						<div class="actions">
							<a href="<?php echo base_url('other_fees');?>"
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
						<form id="apply_student_other_fees_form" class="horizontal-form"
							action="<?php echo base_url('other_fees/save_student_fees');?>" method="post">
							<div class="form-body">
								<h3 class="form-section">Other Fees Details</h3>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Division</label> <select
												id="division_id" name="division_id" class="form-control"
												onchange="get_students()">
												<option value="">Select</option>
												<?php foreach ( $divisions as $row ) :?>
													<option value="<?php echo $row['division_id'];?>"
													<?php echo set_select("division_id",$row['division_id']);?>>
														<?php echo $row['standard_name'].' - '. $row['division_name'];?>
								                    </option>
								                  	<?php
												endforeach;	?>
											</select>
										</div>
									</div>
									
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label">Select Applicable Students</label> 
											<select id="student_id" name="student_id[]" class="form-control select2-multiple" multiple="multiple">
											<option>Select Division First</option>
											</select>
										</div>
									</div>
									
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Fees Description</label> 
											<input id="description" name="description" class="form-control"
												type="text" value="<?php echo set_value('description','Other Fees');?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Total Fees</label> 
											<input id="total_fees" name="total_fees" class="form-control"
												type="text" value="<?php echo set_value('total_fees');?>">
										</div>
									</div>
								</div>
								
								
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Start Date</label> <input
												id="start_date" name="start_date"
												class="form-control date-picker" placeholder="dd/mm/yyyy"
												type="text" value="<?php echo set_value('start_date');?>">
										</div>
									</div>
									<div class="col-md-4" id="due_date_container">
										<div class="form-group">
											<label class="control-label">Due Date</label> <input
												id="due_date" name="due_date"
												class="form-control date-picker" placeholder="dd/mm/yyyy"
												type="text" value="<?php echo set_value('due_date');?>">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">End Date</label> <input
												id="end_date" name="end_date"
												class="form-control date-picker" placeholder="dd/mm/yyyy"
												type="text" value="<?php echo set_value('end_date');?>">
										</div>
									</div>
								</div>
								<div class="row" id="late_fees_container">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Late Fees per day</label> <input
												id="late_fees" name="late_fees"
												class="form-control"
												type="text" value="<?php echo set_value('late_fees');?>">
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn green-meadow" onclick="if(!confirm('Are you sure, you want to apply fees to Selected Students, Please note this can not be modified later?')) return false;">
										<i class="fa fa-check"></i> Save
									</button>
									<a href="<?php echo base_url('academic_fees')?>" class="btn default">Cancel</a>
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
$data ['script'] = "other_fees.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>