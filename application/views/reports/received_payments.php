<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">
			Received Payments
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Received Payments</span></li>
			</ul>
		</div>
		<!-- END PAGE HEADER-->
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light ">
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
						<form id="apply_fees_form" class="horizontal-form"
							action="<?php echo base_url('reports/show_received_payments');?>" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Academic Year</label> <select
												id="academic_year_id" name="academic_year_id" class="form-control">
												<option value="">Select</option>
												<?php
												
												foreach ( $academic_year_data as $row ) :
													?>
																<option value="<?php echo $row['academic_year_id'];?>"
																<?php echo set_select("academic_year_id",$row['academic_year_id']);?>>
																	<?php echo $row['from_year']."-".$row['to_year'] ;?>
											                    </option>
											                  	<?php
												endforeach; ?>
											</select>
										</div>
									</div>
									</div>
									<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">From Date</label> <input
												id="from_date" name="from_date"
												class="form-control date-picker" placeholder="dd/mm/yyyy"
												type="text" value="<?php echo set_value('from_date');?>">
										</div>
									</div>
									<div class="col-md-4" id="due_date_container">
										<div class="form-group">
											<label class="control-label">To Date</label> <input
												id="to_date" name="to_date"
												class="form-control date-picker" placeholder="dd/mm/yyyy"
												type="text" value="<?php echo set_value('to_date');?>">
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn green-meadow">
										<i class="fa fa-check"></i> Submit
									</button>
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