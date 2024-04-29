<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">Manage Students</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><a href="<?php echo base_url('students'); ?>">Students</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Academic Transfer</span>
			
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
								class="caption-subject bold uppercase">Academic Transfer for
								Division</span>
						</div>
						<div class="actions">
							<a href="<?php echo base_url('students');?>"
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
              
						 
                          
						<form id="academic_transfer_form" class="horizontal-form"
							action="<?php echo base_url('students/change_academic_year');?>"
							method="post">
							<div class="form-body">
								<h4 class="form-section">Transfer From Academic Year</h4>
								<!-- row -->
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Current Academic Year</label> <select
												id="current_academic_year_id"
												onchange="get_years_standards_divisions(this.value)"
												name="current_academic_year_id" class="form-control">
												<option value="">Select</option>
												<?php
												foreach ( $academic_years as $row ) :
													?>
																<option value="<?php echo $row['academic_year_id'];?>"
													<?php echo set_select("current_academic_year_id",$row['academic_year_id']);?>>
																	<?php echo $row['from_year'].'-'.$row['to_year'];?>
											                    </option>
											                  	<?php
												endforeach
												;
												?>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Current Division</label> <select
												class="form-control" id="current_division_id"
												name="current_division_id">
												<option value="">Select Academic Year First</option>
											</select>
										</div>
									</div>
								</div>
								<!-- /row -->
								<hr>
								<h4 class="form-section">Transfer To Academic Year</h4>
								<!-- row -->
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">New Academic Year</label> <select
												id="new_academic_year_id" name="new_academic_year_id"
												onchange="get_standards_divisions(this.value)"
												class="form-control">
												<option value="">Select</option>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">New Division</label> <select
												class="form-control" id="new_division_id"
												name="new_division_id">
												<option value="">Select New Academic Year First</option>
											</select>
										</div>
									</div>
								</div>
								<!-- /row -->
							</div>
							<div class="form-actions right">
								<button type="submit" class="btn green-meadow"> 
								<!-- onclick="if(!confirm('Are you sure to transfer ? All students will be transfered to the selected academic year.')) return false;"> -->
									<i class="fa fa-check"></i> Save
								</button>
								<a href="<?php echo base_url('students'); ?>" class="btn default">Cancel</a>
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

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
	var base_url = "<?php echo base_url(); ?>";
	$( document ).ready(function() {
			if($( '#current_academic_year_id' ).val ())
				get_years_standards_divisions ( $( '#current_academic_year_id' ).val () );
			if( $( '#new_academic_year_id' ).val () )
				get_standards_divisions( $( '#new_academic_year_id' ).val () )
	});
</script>

<?php
$data ['script'] = "students.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>