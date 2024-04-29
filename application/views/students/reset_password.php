<form class="form-horizontal form-row-seperated"
	action="<?php echo base_url('students/save_password');?>" method="post"
	id="reset_password_form">


	<div class="Metronic-alerts alert alert-success fade in"
		id="ajax-alert-success-container" style="display: none;">
		<i class="fa-lg fa fa-check"></i> <span
			id="ajax-alert-success-contents">Hello Test</span>
	</div>


	<div class="Metronic-alerts alert alert-danger fade in"
		id="ajax-alert-danger-container" style="display: none;">
		<span id="ajax-alert-danger-contents">again</span>
	</div>

	<div class="form-body">
		<div class="form-group">
			<label class="col-md-4 control-label">New Password: <span
				class="required"> * </span>
			</label>
			<div class="col-md-8">
				<input type="hidden" name="student_id" value="<?php echo $student_id?>">
				<input type="password" class="form-control"
					name="new_password" id="new_password">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 control-label">Confirm Password: <span
				class="required"> * </span>
			</label>
			<div class="col-md-8">
				<input type="password" class="form-control"
					name="confirm_password" id="confirm_password">
			</div>
		</div>

		<hr>
		<div class="form-group">
			<label class="col-md-4 control-label"></label>
			<div class="col-md-8">
				<button id="change_password_btn" type="button"
					onclick="reset_password()" data-loading-text="Processing..."
					class="btn green-meadow" autocomplete="off">
					<i class="fa fa-check"></i> Update Password
				</button>


			</div>
		</div>
	</div>
	
</form>
