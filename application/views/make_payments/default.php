<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">Manage Payments</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Manage Payments</span></li>
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
								class="caption-subject bold uppercase">My Payments</span>
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
              
						<?php if($instalment_data != null) {?>	
							<div class="row">
								<div class="col-md-6">
									<h4>Current Instalment</h4>
									<div class="row">								
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-6">Name:</label>
												<div class="col-md-6">
													<span class="form-control-static"><?php echo $instalment_data['student_firstname'].' '.$instalment_data['student_lastname']; ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">								
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-6">Instalment:</label>
												<div class="col-md-6">
													<span class="form-control-static"><?php echo $instalment_data['instalment_name']; ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">								
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-6">Start Date:</label>
												<div class="col-md-6">
													<span class="form-control-static"><?php echo swap_date_format($instalment_data['start_date']); ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">								
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-6">Due Date:</label>
												<div class="col-md-6">
													<span class="form-control-static"><?php echo swap_date_format($instalment_data['due_date']); ?></span>
												</div>
											</div>
										</div>
									</div><div class="row">								
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-6">End Date:</label>
												<div class="col-md-6">
													<span class="form-control-static"><?php echo swap_date_format($instalment_data['end_date']); ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">								
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-6">Instalment Amount:</label>
												<div class="col-md-6">
													<span class="form-control-static"><?php echo $instalment_data['instalment_amount']; ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">								
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-6">Late Fee:</label>
												<div class="col-md-6">
													<span class="form-control-static"><?php echo $instalment_data['late_fee']; ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">								
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-6">Total Due Fees:</label>
												<div class="col-md-6">
													<span class="form-control-static"><?php echo $instalment_data['instalment_amount'] + $instalment_data['late_fee']; ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">								
										<div class="col-md-12">
											<div class="form-group">
												<div class="col-md-6">
													<a href="javascript:;" class="btn default btn-xs green-meadow-stripe">Pay Online</a>
													<a href="<?php echo base_url('make_payments/download_challan').'/'.$instalment_data['student_id'].'/'.$instalment_data['standard_instalment_id'];?>" class="btn default btn-xs blue-sharp-stripe">Download Challan</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php }?>
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
$data ['script'] = "make_payments.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>