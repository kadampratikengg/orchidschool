<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">
			Manage Payments
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><a href="<?php echo base_url('payments'); ?>">Payments</a>
					<i class="fa fa-angle-right"></i></li>
				<li><span>Add Payments</span></li>
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
								class="caption-subject bold uppercase"> Add Payments</span>
						</div>
						<div class="actions">
							<a href="<?php echo base_url('payments');?>"
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
						<form id="add_payment_form" class="horizontal-form"
							action="<?php echo base_url('payments/save');?>" method="post">
							<div class="form-body">
								<h3 class="form-section">Payment Details</h3>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">


									
											<label class="control-label">Admission No</label> 
											<input type="text" id="admission_no" name="admission_no" class="form-control">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Student Name:</label> 
											 <input type="text" id="student" class="form-control" readonly="readonly">
											 <input type="text" id="student_id" name="student_id" style="display: none;">	
										</div>
									</div>
									
								</div>
								<div class="row">
									
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Invoice</label> 
											<select id="invoice_id" name="invoice_id" class="form-control"
											onchange="get_payment_amount()">
												<option value="">Select Student First</option>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Payment Mode</label> 
											<select id="payment_mode" name="payment_mode" class="form-control">
												<option value="" <?php echo set_select("payment_mode","");?>>Select</option>
												<option value="CASH" <?php echo set_select("payment_mode","CASH");?>>CASH</option>
												<option value="CHEQUE" <?php echo set_select("payment_mode","CHEQUE");?>>CHEQUE</option>
												<option value="ONLINE-TRANSFER" <?php echo set_select("payment_mode","ONLINE-TRANSFER");?>>ONLINE-TRANSFER</option>
												<option value="DD" <?php echo set_select("payment_mode","DD");?>>DD</option>
												<option value="BANK-DEPOSIT" <?php echo set_select("payment_mode","BANK-DEPOSIT");?>>BANK-DEPOSIT</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Narration</label> 
											<input id="narration" name="narration" class="form-control"
												type="text" value="<?php echo set_value('narration');?>">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Transaction Number</label> 
											<input id="transaction_no" name="transaction_no" class="form-control"
												type="text" value="<?php echo set_value('transaction_no');?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Payment Date</label> 
												<input id="payment_date" name="payment_date" class="form-control date-picker" 
												placeholder="dd/mm/yyyy" type="text" value="<?php echo set_value('payment_date');?>"
												onchange="get_late_fees()">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Payment Amount</label> 
											<input id="payment_amount" name="payment_amount" class="form-control"
												type="text" value="<?php echo set_value('payment_amount','0');?>" readonly="readonly">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Late Fee</label> 
											<input id="late_fee_amount" name="late_fee_amount" class="form-control"
												type="text" value="<?php echo set_value('late_fee_amount','0');?>">
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn green-meadow">
										<i class="fa fa-check"></i> Save
									</button>
									<a href="<?php echo base_url('payments')?>" class="btn default">Cancel</a>
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
$data ['script'] = "payments.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>