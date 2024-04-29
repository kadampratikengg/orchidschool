<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">Paid Report</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><a href="<?php echo base_url('reports'); ?>">Reports</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Payments Received</span></li>
			</ul>
		</div>
		<!-- END PAGE HEADER-->

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light ">
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
						<form id="staff_discount_report" class="horizontal-form" 
							method="post" action="<?php echo base_url('reports/payment_received_reports'); ?>">
							<div class="form-body">
							<!--	<div class="row">
									<div class="col-md-4">
										<label class="control-label">Select date range to see payments</label>
										<div class="form-group">
											<div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
												<input class="form-control" id="from" name="from" type="text" value="<?php echo set_value('from');?>">
												<span class="input-group-addon"> to </span>
												<input class="form-control" id="to" name="to" type="text" value="<?php echo set_value('to');?>"> 
											</div>
										</div>
									</div>
								</div>	-->
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Standard</label> 
											<select id="standard_id" name="standard_id" 
											class="form-control"
												onchange="get_instalments(this.value);">
												<option value="">Select</option>
												<option value="all">All</option>
												<?php 
													foreach ( $standards as $row ) :
													?>
														<option value="<?php echo $row['standard_id'];?>"
														<?php echo set_select("standard_id",$row['standard_id']);?>>
															<?php echo $row['standard_name'];?>
									                    </option>
							                  	<?php
												endforeach; ?>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Instalments</label> 
											<select id="instalment_id" name="instalment_id"
												class="form-control">
												<option value="">Select Standards First</option>
											</select>
										</div>
									</div>
									<div class="col-md-4"><br>
										<button type='submit' id="btn_show" 
											value="show_report" name="btn" class="btn blue" style="margin-top:5px;">SHOW
										</button>
									
										<button type="submit" class="btn green-meadow"
											value='download_report' name="btn"
											style="margin-top:5px;margin-left:10px;"> 
											<i class="fa fa-download"></i> Dowload Report
										</button>
									</div>
								</div>
							</div>
						</form>
						<div class="row">
							<hr>
							<table class="table">
								<thead>
									<tr>
										<th>Sr.</th>
										<th>Division</th>
										<th>Instalment</th>
										<th>Admission No.</th>
										<th>Student Name</th>
										<th>Payment Date</th>
										<th>Mode</th>
										<th>Narration</th>
										<th>Amount</th>
										
									</tr>
								</thead>
								<tbody id="payment_received_table_container">
									<?php $i=1; $total=0;
										foreach ( $student_data as $row ) {
								
											echo "<tr><td>" . $i ++ . "</td>";
											echo "<td>" . $row ['division'] . "</td>";
											echo "<td>" . $row ['instalment_name'] . "</td>";
											echo "<td>" . $row ['admission_no'] . "</td>";
											echo "<td>" . $row ['student_name'] . "</td>";
											echo "<td>" . $row ['payment_date'] . "</td>";
											echo "<td>" . $row ['payment_mode'] . "</td>";
											echo "<td>" . $row ['narration'] . "</td>";
											echo "<td>" . $row ['total_paid_amount'] . "</td>";
											$total += $row['total_paid_amount'];
										}
									?>
									<tr>
										<td colspan="8" align="right"><b>Total</b></td>
										<td><b><?php echo $total;?></b></td>
									</tr>
								</tbody>
							</table>
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

<script>
	var base_url = "<?php echo base_url(); ?>";
</script>

<?php
$data ['script'] = "reports.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>