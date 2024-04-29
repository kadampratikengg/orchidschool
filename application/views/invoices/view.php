<form class="form-horizontal" role="form">
	<div class="form-body">
		<!-- <h3 class="margin-bottom-20">Invoice Information</h3> -->
		<h4 class="form-section">Student Invoice Info</h4>
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Invoice Id:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $invoice_data['invoice_id']; ?></span>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Student Name:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $invoice_data['student_firstname'].' '.$invoice_data['student_lastname']; ?></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Academic Year:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $invoice_data['from_year'].' - ' .$invoice_data['to_year']; ?></span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Description:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo ( $invoice_data['description'] ); ?></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Invoice Type:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $invoice_data['invoice_type']; ?></span>
					</div>
				</div>
			</div>
		</div>
		<!--/row-->
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Fees:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $invoice_data['invoice_amount']; ?></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Discount:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $invoice_data['discount_amount']; ?> </span>
					</div>
				</div>
			</div>
		</div>
			<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Paid Amount:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $invoice_data['paid_amount']; ?></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Outstanding Amount:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $invoice_data['outstanding_amount']; ?> </span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">State:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $invoice_data['status']; ?></span>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</form>
