<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">
			Manage Students
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><a href="<?php echo base_url('students'); ?>">Students</a>
					<i class="fa fa-angle-right"></i></li>
				<li><span>Add Student</span>
			
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
								class="caption-subject bold uppercase"> Add Student</span>
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
              
						 
                          
						<form id="add_student_form" class="horizontal-form"
							action="<?php echo base_url('students/save');?>" method="post">
							<div class="form-body">
								<h3 class="form-section">Personal Info</h3>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">First Name</label> <input
												id="student_firstname" name="student_firstname" class="form-control"
												type="text" value="<?php echo set_value('student_firstname');?>">
										</div>
									</div>
									<!--/span-->
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Last Name</label> <input
												id="student_lastname" name="student_lastname" class="form-control"
												type="text" value="<?php echo set_value('student_lastname');?>">
										</div>
									</div>
									<!--/span-->
								</div>
								<!--/row-->

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Date of Birth</label> <input
												id="date_of_birth" name="date_of_birth"
												class="form-control date-picker" placeholder="dd/mm/yyyy"
												type="text" value="<?php echo set_value('date_of_birth');?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Gender</label>
											<div class="radio-list">
												<label class="radio-inline"> <input type="radio"
													name="gender" value="male" <?php echo  set_radio('gender', 'male'); ?>>
													Male
												</label> <label class="radio-inline"> <input type="radio"
													name="gender" value="female" <?php echo  set_radio('gender', 'female'); ?>>
													Female
												</label> 
											</div>
										</div>
									</div>
								</div>
								<!-- row -->

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Blood Group</label> <select
												id="blood_group" name="blood_group" class="form-control">
												<option value="">Select</option>
												<option value="A+" <?php echo  set_select('blood_group','A+'); ?>>A+</option>
												<option value="A-" <?php echo  set_select('blood_group','A-'); ?>>A-</option>
												<option value="B+" <?php echo  set_select('blood_group','B+'); ?>>B+</option>
												<option value="B-" <?php echo  set_select('blood_group','B-'); ?>>B-</option>
												<option value="AB+" <?php echo  set_select('blood_group','AB+'); ?>>AB+</option>
												<option value="AB-" <?php echo  set_select('blood_group','AB-'); ?>>AB-</option>
												<option value="O+" <?php echo  set_select('blood_group','O+'); ?>>O+</option>
												<option value="O-" <?php echo  set_select('blood_group','O-'); ?>>O-</option>
											</select>
										</div>
									</div>
									<!--/span-->
								</div>
								<!-- /row -->

								<h3 class="form-section">Contact Details</h3>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Parent Name</label> <input
												id="parent_name" name="parent_name"
												class="form-control" type="text" value="<?php echo set_value('parent_name');?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Notification Preference</label>
											<div class="radio-list">
												<label class="radio-inline"> 
													<input type="radio" name="notification_preference"
														value="EMAIL" <?php echo  set_radio('notification_preference', 'EMAIL'); ?>>
													EMAIL
												</label>
												<label class="radio-inline"> 
													<input type="radio" name="notification_preference"
														value="SMS" <?php echo  set_radio('notification_preference', 'SMS'); ?>>
													SMS
												</label>
												<label class="radio-inline"> 
													<input type="radio" name="notification_preference"
														value="BOTH" <?php echo  set_radio('notification_preference', 'BOTH'); ?>>
													BOTH
												</label>
												<label class="radio-inline"> 
													<input type="radio" name="notification_preference" 
														value="NONE" <?php echo  set_radio('notification_preference', 'NONE'); ?>>
													NONE
												</label>   
											</div>
										</div>
									</div>
								</div>
								<!-- /row -->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Parent's Email ID</label> <input
												id="parent_email_id" name="parent_email_id"
												class="form-control" type="text" value="<?php echo set_value('parent_email_id');?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Parent's Contact No.</label> <input
												id="parent_contact_no" name="parent_contact_no"
												class="form-control maxlength-handler" type="text"
												maxlength="10" value="<?php echo set_value('parent_contact_no');?>">
										</div>
									</div>
								</div>
								<!--/row-->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Parent's Secondary Email ID</label> <input
												id="secondary_email_id" name="secondary_email_id"
												class="form-control" type="text" value="<?php echo set_value('secondary_email_id');?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Parent's Secondary Contact No.</label> <input
												id="secondary_contact_no" name="secondary_contact_no"
												class="form-control maxlength-handler" type="text"
												maxlength="10" value="<?php echo set_value('secondary_contact_no');?>">
										</div>
									</div>
								</div>
								<!--/row-->

								<h3 class="form-section">Academic Details</h3>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Provision For RTE</label>
											<div class="radio-list">
												<label class="radio-inline"> <input type="radio" id="rte_provision_yes"
													name="rte_provision" value="YES" <?php echo  set_radio('rte_provision', 'YES'); ?> onclick="allow_staff_discount()">
													YES
												</label> <label class="radio-inline"> <input type="radio" id="rte_provision_no"
													name="rte_provision" value="NO" <?php echo  set_radio('rte_provision', 'NO'); ?> onclick="allow_staff_discount()" checked >
													NO
												</label> 
											</div>
										</div>
									</div>
								</div>
								<!-- /row -->
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Admission Number</label> <input
												id="admission_number" name="admission_number"
												class="form-control" type="text" value="<?php echo set_value('admission_number');?>">
										</div>
									</div>
									<div class="col-md-6" id="staff_discount">
										<div class="form-group">
											<label class="control-label">Staff Discount (%)</label> <input
												id="staff_discount" name="staff_discount"
												class="form-control" type="text" value="<?php echo set_value('staff_discount',0);?>">
										</div>
									</div>
								</div>
								<!-- /row -->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Current Academic Year</label> <select
												id="academic_year_id" name="academic_year_id" class="form-control">
												<option value="">Select</option>
												<?php
												foreach ( $academic_years as $row ) :
													?>
																<option value="<?php echo $row['academic_year_id'];?>" 
																<?php echo set_select("academic_year_id",$row['academic_year_id']);?>
																>
																	<?php echo $row['from_year'].'-'.$row['to_year'];?>
											                    </option>
											                  	<?php
												endforeach
												;
												?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Admission Year</label> <input
												id="admission_year" name="admission_year"
												class="form-control" type="text" value="<?php echo set_value('admission_year');?>">
										</div>
									</div>

								</div>
								<!-- /row -->

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Current Standard</label> <select
												id="current_standard" name="current_standard" class="form-control"
												onchange="get_divisions(this.value)">
												<option value="">Select</option>
												<?php
												foreach ( $standards as $row ) :
													?>
																<option value="<?php echo $row['standard_id'];?>"
																<?php echo set_select("current_standard",$row['standard_id']);?>>
																	<?php echo $row['standard_name'];?>
											                    </option>
											                  	<?php
												endforeach
												;
												?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Current Division</label> <select
												id="division_id" name="division_id" class="form-control">
												<option value="">Select Standard first</option>
											</select>
										</div>
									</div>
								</div>
								<!-- /row -->

								<h3 class="form-section">Address</h3>
								<div class="row">
									<div class="col-md-6 ">
										<div class="form-group">
											<label>Address Line</label>
											<textarea id="address" name="address" class="form-control"><?php echo set_value('address');?></textarea>
										</div>
									</div>
									<div class="col-md-6 ">
										<div class="form-group">
											<label>Pincode</label> <input id="pincode" name="pincode"
												class="form-control maxlength-handler" maxlength="6" type="text" value="<?php echo set_value('pincode');?>">
										</div>
									</div>
								</div>
								<!-- /row -->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>City</label> <input id="city" name="city"
												class="form-control" type="text" value="<?php echo set_value('city');?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>State</label> <input id="state" name="state"
												class="form-control" type="text" value="<?php echo set_value('state');?>">
										</div>
									</div>
								</div>
								<!-- /row -->

							</div>
							<div class="form-actions right">
								<button type="submit" class="btn green-meadow">
									<i class="fa fa-check"></i> Save
								</button>
								<a href="<?php echo base_url('students')?>" class="btn default">Cancel</a>
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
$data ['script'] = "students.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>