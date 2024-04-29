<form class="form-horizontal" role="form">
	<div class="form-body">
		<!-- <h3 class="margin-bottom-20">Staff Information</h3> -->
		<h4 class="form-section">Personal Info</h4>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Name:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $staff_data['first_name'].' '.$staff_data['last_name']; ?></span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Email:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $staff_data['email_id']; ?></span>
					</div>
				</div>
			</div>
			</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Contact no:</label>
					<div class="col-md-6">
						<p class="form-control-static"><?php echo $staff_data['mobile_no']; ?></p>
					</div>
				</div>
			</div>
			</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Gender:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $staff_data['gender']; ?></span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Status:</label>
					<div class="col-md-6">
						<span class="form-control-static"><?php echo $staff_data['status']; ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
