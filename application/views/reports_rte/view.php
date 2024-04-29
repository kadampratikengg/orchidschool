<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">RTE Reports</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><a href="<?php echo base_url('reports_rte'); ?>">RTE Reports</a><i
					class="fa fa-angle-right"></i></li>
				<li><span>Student History</span></li>
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
								class="caption-subject bold uppercase">Student History</span>
						</div>
						<div class="actions">
								<a href="<?php echo base_url('reports_rte');?>" class="btn btn-circle default">Back</a>
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
		      			
						<div class="student-info-container"
							style="background-color: #FDFCF5; border: 1px solid #faebcc;">
							<header>
								<div class="col-md-12">
									<h1 style="font-weight: bold;" class="font-red-soft">
										<?php echo $student_data['student_firstname'].' '.$student_data['student_lastname']; ?>
									</h1>
									<i class="fa fa-envelope"></i> 
									<a href="mailto:<?php echo $student_data['parent_email_id']; ?>" style="color: #8a6d3b;">
										<?php echo $student_data['parent_email_id']; ?>
									</a>&nbsp; 
									<i class="fa fa-phone"></i> <?php echo $student_data['parent_mobile_no']; ?> &nbsp; 
									<i class="fa fa-user"></i><?php echo $student_data['gender']; ?>&nbsp; 
									<i class="fa fa-calendar"></i>
									Birthdate: <?php echo date('d-M-Y',strtotime(swap_date_format( $student_data['date_of_birth'] ))); ?> 
									<Strong>Blood Group:</Strong> <?php echo $student_data['blood_group']; ?> <br>
								</div>
								<div class="clearfix"></div>
							</header>
							<hr>
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-6">
										<h4 style="color: #777;">Contact Information</h4>
										<ul class="list-group">
											<li class="list-group-item">
												<strong>Parent:</strong>
												<?php echo $student_data['parent_name']; ?>
											</li>
											<?php if($student_data['secondary_mobile_no']!= '' || $student_data['secondary_email_id']!= '') {?>
												<li class="list-group-item"><strong>Secondary Contact:</strong><br>
													<?php if($student_data['secondary_mobile_no'] != ''){?>
														<i class="fa fa-phone"></i> 
														<?php echo $student_data['secondary_mobile_no']; ?> <br>
													<?php }?> 
													<?php if($student_data['secondary_email_id'] != ''){?>
														<i class="fa fa-envelope"></i> 
														<a href="mailto:<?php echo $student_data['secondary_email_id']; ?>" style="color: #8a6d3b;">
															<?php echo $student_data['secondary_email_id']; ?>
														</a>
													<?php }?>
												</li>
											<?php }?>
											<li class="list-group-item">
												<strong>Address:</strong>
												<?php echo $student_data['address']; ?><br>
												<?php echo $student_data['city']; ?>, <?php echo $student_data['state']; ?> - 
												<?php echo $student_data['pincode']; ?>
											</li>
										</ul>
									</div>
									<div class="col-md-6">
										<h4 style="color: #777;">Academic Information</h4>
										<ul class="list-group">
											<li class="list-group-item">
												<strong>Admission Number:</strong> <?php echo $student_data['admission_no']; ?><br> 
												(Year: <?php echo $student_data['from_year'].'-'.$student_data['to_year']; ?>)
											</li>
											<li class="list-group-item">
												<strong>Standard:</strong> <?php echo $division['standard_name']; ?>
												(<?php echo $division['division_name']; ?>) - 
												<strong><?php echo $student_data['status']; ?></strong>
											</li>
											<?php if($student_data['status'] == "INACTIVE"){?>
												<li class="list-group-item">
													<strong>Withdrawal Date :</strong> 
													<?php echo date('d-M-Y',strtotime(swap_date_format($student_data['withdraw_date']))); ?>
												</li>
												<li class="list-group-item">
													<strong>Withdrawl Reason:</strong> 
													<?php echo $student_data['withdraw_reason']; ?> 
												</li>
											<?php }?>	
											<li class="list-group-item">
												<strong>Admission Year:</strong> <?php echo $student_data['admission_year']; ?><br> 
											</li>
											<li class="list-group-item">
												<strong>RTE :</strong> <?php echo $student_data['rte_provision']; ?> <strong>
												<?php if($student_data['rte_provision'] != 'YES'){ ?>
													/ Staff Discount:</strong> 
														<?php echo $student_data['staff_discount'] > 0? $student_data['staff_discount']." %":"NONE" ?>
												<?php }?>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
			</div>
		</div>

	</div>
	<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<?php
$data ['script'] = "reports_rte.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>