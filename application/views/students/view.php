<?php $this->load->view('_includes/header');?>
<style>
.student-info-container strong {
	font-weight: 600;
}
</style>

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
				<li><a href="<?php echo base_url('students'); ?>">Students</a><i
					class="fa fa-angle-right"></i></li>
				<li><span>View Student</span></li>
			</ul>

		</div>
		<!-- END PAGE HEADER-->

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption ">
							<i class="icon-settings blue-steel "></i> <span
								class="caption-subject bold uppercase blue-steel">Students
								History</span>
						</div>
						<div class="actions">
							<a href="<?php echo base_url('students/edit/'.$student_data['student_id']);?>"
								class="btn btn-circle sm green-meadow">Edit</a>
							<a href="<?php echo base_url('students/index').'/'.$student_data['division_id'];?>"
								class="btn btn-circle default">Back</a>
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
									<i class="fa fa-envelope"></i> <a
										href="mailto:<?php echo $student_data['parent_email_id']; ?>"
										style="color: #8a6d3b;">
										<?php echo $student_data['parent_email_id']; ?>
									</a>&nbsp; <i class="fa fa-phone"></i> <?php echo $student_data['parent_mobile_no']; ?> &nbsp; 
									<i class="fa fa-user"></i><?php echo $student_data['gender']; ?>&nbsp; 
									<i class="fa fa-calendar"></i>
									Birthdate: <?php echo date('d-M-Y',strtotime(swap_date_format( $student_data['date_of_birth'] ))); ?> 
									<Strong>Blood Group:</Strong> <?php echo $student_data['blood_group']; ?>
									
								</div>
								<div class="clearfix"></div>
							</header>
							<hr>
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-4">
										<h4 style="color: #777;">Contact Information</h4>
										<ul class="list-group">
											<li class="list-group-item"><strong>Parent:</strong>
												<?php echo $student_data['parent_name']; ?>
											</li>
											<?php if($student_data['secondary_mobile_no']!= '' || $student_data['secondary_email_id']!= '') {?>
												<li class="list-group-item"><strong>Secondary Contact:</strong><br>
													<?php if($student_data['secondary_mobile_no'] != ''){?>
														<i class="fa fa-phone"></i> 
														<?php echo $student_data['secondary_mobile_no']; ?> <br>
													<?php }?> 
													<?php if($student_data['secondary_email_id'] != ''){?>
														<i class="fa fa-envelope"></i> <a
												href="mailto:<?php echo $student_data['secondary_email_id']; ?>"
												style="color: #8a6d3b;">
															<?php echo $student_data['secondary_email_id']; ?>
														</a>
													<?php }?>
												</li>
											<?php }?>
											<li class="list-group-item"><strong>Address:</strong>
												<?php echo $student_data['address']; ?><br>
												<?php echo $student_data['city']; ?>, <?php echo $student_data['state']; ?> - 
												<?php echo $student_data['pincode']; ?>
											</li>
										</ul>
									</div>
									<div class="col-md-4">
										<h4 style="color: #777;">Academic Information</h4>
										
										
										<div id="ajax-alert-success-container" style="display: none;" >
											
											<div id="ajax-alert-success-contents" class="alert alert-success alert-dismissible" role="alert">
											  <button type="button" class="close" data-dismiss="alert" aria-label="Close" >
											  <span aria-hidden="true">&times;</span></button>
											  
											</div>
										</div>
										<div id="ajax-alert-danger-container" style="display: none;">
											<div id="ajax-alert-danger-contents" class="alert alert-danger"></div>

										</div>
										<ul class="list-group">
											<li class="list-group-item"><strong>Admission Number:</strong> <span id="admission_no"><?php echo $student_data['admission_no']; ?></span><br> 
												(Year: <?php echo $student_data['from_year'].'-'.$student_data['to_year']; ?>)
												<a href="javascript:" onclick="update_admission_no()"><span class="glyphicon glyphicon-pencil"></span></a><br/><br/>
												<div style=" display: none;" id="admission_div">
													<form id="admission_no_frm" action="" method="post">
													<input type="text" class="form-control" name="new_admission_no" id="new_admission_no" value="" required="" >
													<input type="hidden" class="form-control" name="old_admission_no" id="old_admission_no" value="<?php echo $student_data['admission_no']; ?>" required="" >
													<br/>
													<input type="button" class="btn btn-success" name="submit" value="Update"  onclick="update()" >
													<input type="button" class="btn btn-default" name="cancel" value="Cancel" onclick="hide_admission_div()">

                                                  </form>
												</div>
											</li>
											<li class="list-group-item"><strong>Standard:</strong> <?php echo $student_data['standard_name']; ?>
												(<?php echo $student_data['division_name']; ?>) - 
												<strong><?php echo $student_data['status']; ?></strong></li>
											<?php if($student_data['status'] == "INACTIVE"){?>
												<li class="list-group-item"><strong>Withdrawal Date :</strong> 
													<?php echo date('d-M-Y',strtotime(swap_date_format($student_data['withdraw_date']))); ?>
												</li>
											<li class="list-group-item"><strong>Withdrawl Reason:</strong> 
													<?php echo $student_data['withdraw_reason']; ?> 
												</li>
											<?php }?>	
											<li class="list-group-item"><strong>Admission Year:</strong> <?php echo $student_data['admission_year']; ?><br>
											</li>
											<li class="list-group-item"><strong>RTE :</strong> <?php echo $student_data['rte_provision']; ?> <strong>
												<?php if($student_data['rte_provision'] != 'YES'){ ?>
													/ Staff Discount:</strong> 
														<?php echo $student_data['staff_discount'] > 0? $student_data['staff_discount']." %":"NONE"?>
												<?php }?>
											</li>
										</ul>
									</div>
									<?php if($student_data['total_fees'] > 0){ ?>
										<div class="col-md-4">
											<h4 style="color: #777;">Payment Summary</h4>
											<ul class="list-group">
												<li class="list-group-item font-blue-steel"
													style="font-size: 20px;">Total Fees: <span
													class="pull-right">
														Rs.<?php echo $student_data['total_fees']; ?>
													</span>
												</li>
												<?php if($student_data['total_discount']>0){ ?>
													<li class="list-group-item">Staff Discount: <span
													class="pull-right">
															Rs.<?php echo $student_data['total_discount']; ?>
														</span>
												</li>
												<?php }?>
												<li class="list-group-item font-green-meadow"
													style="font-size: 20px;">Paid Fees: <span class="pull-right">
														Rs.<?php echo $student_data['total_paid']; ?>
													</span>
												</li>
												<li class="list-group-item font-red-soft"
													style="font-size: 20px;">Outstading Fees: <span
													class="pull-right">
														Rs.<?php echo $student_data['total_outstanding']; ?>
													</span>
												</li>
												<?php if(($student_data['total_paid']+$student_data['total_outstanding']) - ($student_data['total_fees'] - $student_data['total_discount'])>0){?>
													<li class="list-group-item">Late Fees Paid: <span
													class="pull-right">
															Rs.<?php echo ($student_data['total_paid']+$student_data['total_outstanding']) - ($student_data['total_fees'] - $student_data['total_discount']); ?>
														</span>
												</li>
												<?php }?>
											</ul>
										</div>
									<?php }?>
								</div>
							</div>
							<?php if(count($instalments)>0){?>
								<div class="row">
								<div class="col-md-12">
									<h4 style="color: #777; font-size: 24px; margin-left: 15px;">
										Instalment Details</h4>
									<hr>
										<?php for($i = 0; $i<count($instalments); $i++){?>
										<?php if($i==4){?>
											<div class="clearfix"></div>
										<?php }?>
											<div class="col-md-3">
												<h4 class="<?php echo isset($instalments[$i]['payment_id'])?"font-green-meadow":"font-blue-steel"?>"
													style="font-weight: bold; font-size: 20px;">
													Installment: <?php echo $instalments[$i]['instalment_name'];?>
												</h4>
												<ul class="list-group">
													<li class="list-group-item"><strong>
															Rs.<?php echo $instalments[$i]['invoice_amount'];?>
														</strong></li>
													<?php if(isset($instalments[$i]['payment_id']) && $instalments[$i]['status'] == 'PAYMENT-RECEIVED'){?>
	
														<li class="list-group-item">Paid Amount: 
															<span class="pull-right">
																Rs.<?php echo $instalments[$i]['total_paid_amount'];?>
																<?php if($instalments[$i]['discount_amount']>0 || $instalments[$i]['late_fee_amount']>0){?>
																	<a href="javascript:;" data-toggle="popover" data-trigger="hover" 
																		data-placement="top" data-html="true" title="Fees Bifurcation"
																		data-content="<?php echo $instalments[$i]['discount_amount']>0?"<strong>Discount:</strong> Rs.".$instalments[$i]['discount_amount']."<br />":""?> 
																		<?php echo $instalments[$i]['late_fee_amount']>0?"<strong>Late Fees:</strong> Rs.".$instalments[$i]['late_fee_amount']:""?>">
																		<i class="fa fa-info-circle" style="color: #068;"></i>
																	</a>
																<?php }?>
															</span>
														</li>
														<li class="list-group-item">Payment Date: <span
															class="pull-right">
																<?php echo date('d-M-Y',strtotime(swap_date_format($instalments[$i]['payment_date'])));?>
															</span>
														</li>
														<li class="list-group-item"><a
															href="<?php echo base_url('students/download_receipt/'.$instalments[$i]['payment_id']); ?>"
															class="btn green-meadow"> <i class="fa fa-download"></i>
																Download Receipt
														</a></li>  
													<?php }else{?>
														<li class="list-group-item">Start Date: <span
															class="font-green-meadow pull-right">
																<?php echo date('d-M-Y', strtotime(swap_date_format($instalments[$i]['start_date'])));?>
															</span>
														</li>
														<li class="list-group-item">Due Date: <span
															class="font-red-soft pull-right">
																<?php echo date('d-M-Y', strtotime(swap_date_format($instalments[$i]['due_date'])));?>
															</span>
														</li>
														<li class="list-group-item"><a
															href="<?php echo base_url('students/download_challan').'/'.$student_data['student_id'].'/'.$instalments[$i]['standard_instalment_id'];?>"
															class="btn blue-steel"> <i class="fa fa-download"></i>
																Download Challan
														</a></li>
														<?php if ($instalments[$i]['status'] != 'FULLY_PAID'){?>
															<li class="list-group-item"><a
																href="<?php echo base_url('reminders/send_sms').'/'.$student_data['student_id'].'/'.$instalments[$i]['standard_instalment_id'];?>"
																class="btn yellow-gold "> <i
																	class="fa fa-bell-o"></i>&nbsp;&nbsp; Send
																	Reminder&nbsp;&nbsp;&nbsp;
															</a></li>
														<?php }
															$current_date = date('Y-m-d');
															if($instalments[$i]['due_date'] < $current_date){?>
															<li class="list-group-item"><a
																href="<?php echo base_url('students/delete_invoice').'/'.$student_data['student_id'].'/'.$instalments[$i]['invoice_id'];?>"
																class="btn red-thunderbird"
																onclick="if(!confirm('Are you sure to delete ?')) return false;"> <i
																	class="fa fa-trash"></i>&nbsp;&nbsp; Delete Invoice&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
															</a></li>  
														<?php }
													}?>
												</ul>
											</div>
										<?php }?>
									</div>
								</div>
							<?php }else{?>
								<div class="row">
								<div class="col-md-12">
									<?php if($student_data['rte_provision'] == 'NO'){?>
										<h3 class="font font-red-soft"
											style="font-size: 26px; margin-left: 20px;">Note: Fee is not
											applied to this student</h3>
									<?php }else{?>
										<h3 class="font font-red-soft"
											style="font-size: 26px; margin-left: 20px;">Note: This is an RTE student</h3>
									<?php }?>
								</div>
							</div>
							<?php }?>
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
$data ['script'] = "students.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>