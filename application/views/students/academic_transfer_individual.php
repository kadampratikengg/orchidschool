<form class="form-horizontal form-row-seperated"
	action="<?php echo base_url('students/change_academic_individual');?>"
	method="post" id="academic_transfer_individual_form">


	<div class="Metronic-alerts alert alert-success fade in"
		id="ajax-alert-success-container" style="display: none;">
		<i class="fa-lg fa fa-check"></i> <span
			id="ajax-alert-success-contents"></span>
	</div>


	<div class="Metronic-alerts alert alert-danger fade in"
		id="ajax-alert-danger-container" style="display: none;">
		<span id="ajax-alert-danger-contents"></span>
	</div>

	<div class="form-body">
		<!-- row -->
		<div class="row">
			<div class="col-md-6">
				<div class="form-group col-md-12">
					<label class="control-label">New Academic Year</label> <select
						id="new_academic_year_id" name="new_academic_year_id"
						onchange="get_standards_divisions(this.value)"
						class="form-control">
						<option value="">Select</option>
						<?php foreach ( $academic_years_data as $row ) : ?>
							<option value="<?php echo $row['academic_year_id'];?>"
							<?php echo set_select("new_academic_year_id",$row['academic_year_id']);?>>
							<?php echo $row['from_year'].'-'.$row['to_year'];?>
							</option>
							<?php endforeach ; ?>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group col-md-12">
					<label class="control-label">New Division</label> <select
						class="form-control" id="new_division_id" name="new_division_id">
						<option value="">Select New Academic Year First</option>
					</select> <input type="hidden" name="student_id"
						value="<?php echo $student_id;?>">
				</div>
			</div>
		</div>
		<!-- /row -->
		<div class="form-actions right">
			<button type="button" class="btn green-meadow"
				id="btn_academic_transfer" onclick="change_academic_individual()">
				<i class="fa fa-check"></i> Save
			</button>
		</div>
	</div>
</form>
