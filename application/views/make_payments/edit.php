<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">
			Manage Staff
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><a href="<?php echo base_url('staff'); ?>">Staff</a>
					<i class="fa fa-angle-right"></i></li>
				<li><span>Edit Staff</span>
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
								class="caption-subject bold uppercase"> Edit Staff</span>
						</div>
						<div class="actions">
							<a href="<?php echo base_url('staff');?>"
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
						<form id="update_staff_form" class="horizontal-form"
							action="<?php echo base_url('staff/update/'.$staff_data['staff_id']);?>" method="post">
							<div class="form-body">
								<h3 class="form-section">Edit Personal Info</h3>
								<div class="row">
									
									
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">First Name</label> <input
												id="first_name" name="first_name" class="form-control"
												type="text" value="<?php echo set_value('first_name',$staff_data['first_name']);?>">
										</div>
									</div>
									<!--/span-->
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Last Name</label> <input
												id="last_name" name="last_name" class="form-control"
												type="text" value="<?php echo set_value('last_name',$staff_data['last_name']);?>">
										</div>
									</div>
									<!--/span-->
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Mobile Number</label> <input
												id="mobile_no" name="mobile_no"
												class="form-control" type="text" value="<?php echo set_value('mobile_no',$staff_data['mobile_no']);?>">
										</div>
									</div>
									<!--/span-->
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Email ID</label> <input
												id="email_id" name="email_id"
												class="form-control" type="text" value="<?php echo set_value('email_id',$staff_data['email_id']);?>">
										</div>
									</div>
									<!--/span-->
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Gender</label>
											<div class="radio-list">
											<?php 
												$male_checked = false;
												$female_checked = false;
												if ( strcmp( $staff_data['gender'], 'MALE') == 0 )
													$male_checked = true;
												if ( strcmp( $staff_data['gender'], 'FEMALE') == 0 )
													$female_checked = true;
												?>
												<label class="radio-inline"> <input type="radio"
													name="gender" value="MALE" <?php echo  set_radio('gender', 'MALE', $male_checked); ?>>
													Male
												</label> <label class="radio-inline"> <input type="radio"
													name="gender" value="FEMALE" <?php echo  set_radio('gender', 'FEMALE', $female_checked); ?>>
													Female
												</label> 
											</div>
										</div>
									</div>
									<!--/span-->
								   </div>
								<div class="form-actions right">
									<button type="submit" class="btn green-meadow">
										<i class="fa fa-check"></i> Update
									</button>
									<a href="<?php echo base_url('staff')?>" class="btn default">Cancel</a>
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
	
	function get_divisions(standard_id) {
		$.ajax({

			data: {"standard_id" : standard_id},
			url: base_url+'students/get_class_divisions',
	        success: function(response)
	        {
	            $('#division_id').html(response);
	        }
		});
    }

</script>

<?php
$data ['script'] = "students.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>