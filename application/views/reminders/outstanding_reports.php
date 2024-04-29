<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">Outstanding Fees Report</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Reports</span></li>
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
								class="caption-subject bold uppercase">Outstanding Reports</span>
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
						<form id="send_reminders" class="horizontal-form"
							action="<?php echo base_url('reminders/send_outstanding_reminder');?>"
							method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="col-md-4">
											<div class="form-group">
												<label class="control-label">Standard</label> <select
													id="standard_id" name="standard_id" class="form-control"
													onchange="get_instalmetns(this.value);">
													<option value="">Select</option>
													<option value="all">All</option>
												<?php foreach ( $standards as $row ){ ?>
													<option value="<?php echo $row['standard_id'];?>"
														<?php echo set_select("standard_id",$row['standard_id']);?>>
														<?php echo $row['standard_name'];?>
								                    </option>
							                  	<?php } ?>
											</select>
											</div>
										</div>
										<div id="standard_instalments" class="col-md-4">
											<div class="form-group">
												<label class="control-label">Instalment</label> <select
													id="standard_instalment_id" name="standard_instalment_id"
													class="form-control">
													<option value="">Select Standard First</option>
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
											<label class="control-lable">&nbsp;</label>
												<a href="javascript:;" id="btn_show"
													class="btn btn-default form-control blue" onclick="get_outstanding_reports()">SHOW</a>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<hr>
									<table class="table">
										<thead>
											<tr>
												<th>Sr.</th>
												<th>Admission No.</th>
												<th>Student Name</th>
												<th>Parent email</th>
												<th>Parent Mobile</th>
												<th>Instalment Amount</th>
												<th>Outstanding Payment</th>
											</tr>
										</thead>
										<tbody id="outstanding_table_container">
											<tr><td colspan="7" align="center"><span>No data to display</span></td></tr>
										</tbody>
									</table>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Message</label>
											<textarea id="message" name="message" rows="5" class="form-control" 
												style="resize: none;"><?php echo set_value('message');?></textarea>
<!-- 'Dear parent, due date for installment: No.X (Rs.XXX) is X-X-XX. For online payment goto http://goo.gl/fsxtMP , Regards - THE ORCHID SCHOOL' -->												
										</div>
									</div>
									<div class="col-md-8">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label">Notify By</label>
												<div class="radio-list">
													<!-- label class="radio-inline"> 
														<input type="radio" name="notify_by" value="EMAIL"
															<?php echo  set_radio('notification_preference', 'EMAIL'); ?>
														checked> EMAIL
													</label --> 
													<label class="radio-inline"> 
														<input type="radio" name="notify_by" value="SMS"
															<?php echo  set_radio('notification_preference', 'SMS'); ?> checked>
															SMS
													</label> 
													<!-- label class="radio-inline"> 
														<input type="radio" name="notify_by" value="BOTH"
														<?php echo  set_radio('notification_preference', 'BOTH'); ?>>
														BOTH
													</label -->
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn green-meadow"
										onclick="if(!confirm('Are you sure, you want to send reminders to Selected Students?')) return false;">
										<i class="fa fa-check"></i> Send Reminder
									</button>
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
</script>

<?php
$data ['script'] = "reminders.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>