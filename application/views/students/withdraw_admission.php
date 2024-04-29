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
				<li><span>Withdraw Admission</span>
			
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
								class="caption-subject bold uppercase"> Withdraw Student Admission</span>
						</div>
						<div class="actions">
							<a href="<?php echo base_url('students/index').'/'.$division_id;?>"
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
              
						 
                          
						<form id="withdraw_admission_form" class="horizontal-form"
							action="<?php echo base_url('students/change_status_inactive');?>" method="post">
							<div class="form-body">
								
								<input type="text" value="<?php echo $student_id; ?>" name="student_id" hidden>
								<input type="text" value="<?php echo $status; ?>" name="status" hidden>
								<input type="text" value="<?php echo $division_id; ?>" name="division_id" hidden>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Reason to Withdraw Admission</label> <input
												id="withdraw_reason" name="withdraw_reason" class="form-control"
												type="text" value="<?php echo set_value('withdraw_reason');?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Date of Withdrawal</label> <input
												id="withdraw_date" name="withdraw_date"
												class="form-control date-picker" placeholder="dd/mm/yyyy"
												type="text" value="<?php echo set_value('withdraw_date');?>">
										</div>
									</div>
								</div>
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