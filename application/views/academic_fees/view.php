<form class="form-horizontal" role="form">
	<div class="form-body">
		<!-- <h3 class="margin-bottom-20">Student Information</h3> -->
		<h4 class="form-section">Invoice Details</h4>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Invoice No.:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $invoice_data['invoice_id']; ?></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Invoice Status:</label>
					<div class="col-md-6">
						<p class="form-control-static"><?php echo $invoice_data['status']; ?></p>
					</div>
				</div>
			</div>
		</div>
		<!-- /row -->
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Student Name:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $invoice_data['student_firstname'].' '.$invoice_data['student_lastname']; ?></span>
					</div>
				</div>
			</div>
			
		</div>
		<!--/row-->
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Invoice Date:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo swap_date_format($invoice_data['invoice_date']); ?></span>
					</div>
				</div>
			</div>
		</div>
		<!--/row-->
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Invoice Description:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $invoice_data['description']; ?></span>
					</div>
				</div>
			</div>
		</div>		
		<!-- /row -->
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Total Fees:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $invoice_data['invoice_amount']; ?></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Discount Amount:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $invoice_data['discount_amount']; ?></span>
					</div>
				</div>
			</div>
		</div>
		<!--/row-->
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Paid Fees:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $invoice_data['paid_amount']; ?></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Outstanding Fees:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $invoice_data['outstanding_amount']; ?></span>
					</div>
				</div>
			</div>
		</div>
		<!--/row-->
		
		<div class="row">
			
		</div>
		<!--/row-->
		
	</div>
</form>
