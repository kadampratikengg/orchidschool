<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">
			Manage Academic Fees
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><a href="<?php echo base_url('academic_fees'); ?>">Academic Fees</a>
					<i class="fa fa-angle-right"></i></li>
				<li><span>Apply Academic Fees</span></li>
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
								class="caption-subject bold uppercase"> Apply Academic Fees</span>
						</div>
						<div class="actions">
							<a href="<?php echo base_url('academic_fees');?>"
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
							action="<?php echo base_url('academic_fees/save');?>" method="post">
							<div class="form-body">
								<h3 class="form-section">Academic Fees Details</h3>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Standard</label> <select
												id="standard_id" name="standard_id" class="form-control"
												onchange="get_divisions(this.value)">
												<option value="">Select</option>
												<?php
												
												foreach ( $standards as $row ) :
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
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Division</label> 
											<select id="division_id" name="division_id" class="form-control"
											onchange="get_applicable_students()">
											<option value="">Select Standard First</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Select Applicable Student(s)</label> 
											<select id="applicable_student_id" name="applicable_student_id" class="form-control">
											<option value="">Select Division First</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Apply Staff Discounts</label>
											<div class="radio-list">
												<label class="radio-inline"> <input type="radio"
													name="apply_staff_discount" value="yes" <?php echo  set_radio('apply_staff_discount', 'yes'); ?>  checked="checked">
													Yes
												</label> <label class="radio-inline"> <input type="radio"
													name="apply_staff_discount" value="no" <?php echo  set_radio('apply_staff_discount', 'no'); ?>>
													No
												</label> 
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Fees Description</label> 
											<input id="fees_description" name="fees_description" class="form-control"
												type="text" value="<?php echo set_value('fees_description','Tuition Fees');?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Invoice Date</label> <input
												id="invoice_date" name="invoice_date"
												class="form-control date-picker" placeholder="dd/mm/yyyy"
												type="text" value="<?php echo set_value('date_of_birth');?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Total Fees</label> 
											<input id="total_fees" name="total_fees" class="form-control"
												type="text" value="" readonly="readonly">
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
$data ['script'] = "academic_fees.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>