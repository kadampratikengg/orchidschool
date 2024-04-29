<form class="form-horizontal" role="form">
	<div class="form-body">
		<h4 class="form-section">Personal Info</h4>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Student Name:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $student_data['student_firstname'].' '.$student_data['student_lastname']; ?></span>
					</div>
				</div>
			</div>
			
		</div>
		<!--/row-->
		<h4 class="margin-bottom-20">Academic Details</h4>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Academic Year:</label>
					<div class="col-md-6">
						<p class="form-control-static"><?php echo $academic_data['from_year'].'-'.$academic_data['to_year']; ?></p>
					</div>
				</div>
			</div>
			<!--/span-->
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Standard(Div):</label>
					<div class="col-md-6">
						<p class="form-control-static"><?php echo $standard_data['standard_name'].'-'.$division_data['division_name']; ?></p>
					</div>
				</div>
			</div>
			<!--/span-->
		</div>
		<!--/row-->
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Admission No:</label>
					<div class="col-md-6">
						<p class="form-control-static"><?php echo $student_data['admission_no']; ?></p>
					</div>
				</div>
			</div>
		</div>
		
		<h4 class="margin-bottom-20">Payment Details</h4>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Payment Date:</label>
					<div class="col-md-6">
						<p class="form-control-static"><?php echo $payment_data['payment_date']; ?></p>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Payment Amount:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $payment_data['payment_amount']; ?></span>
					</div>
				</div>
			</div>
		</div>
		<!-- /row -->
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Late Fee:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $payment_data['late_fee_amount']; ?></span>
					</div>
				</div>
			</div>
				<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Discount Amount:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $discount_amount['discount_amount']; ?></span>
					</div>
				</div>
			</div>
	
		</div>	
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Total Fees:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $payment_data['total_paid_amount']; ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
