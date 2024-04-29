<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<h3 class="page-title">Received payments</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Received Payments Fees</span></li>
			</ul>

		</div>
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption font-dark">
							<i class="icon-reports font-dark"></i> <span
								class="caption-subject bold uppercase">Received Payments <span
								class="text-muted">from <?php echo $from_date;?> to <?php echo $to_date;?></span></span>
						</div>
					</div>
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>

									<th>Sr.No.</th>
									<th>Invoice No.</th>
									<th>Student Name</th>
									<th>Payment Details</th>
									<th>Payment Date</th>
									<th>Payment Amount</th>
									<th>Late Fee</th>
									<th>Total paid</th>
								</tr>
							</thead>
							<tbody>
						            <?php $i = 1;
						            $total_paid = 0;
						            foreach ( $received_payments_data as $row ) { ?>
										<tr class="odd gradeX">
									<td><?php echo $i; $i++;?></td>
									<td>	<?php echo $row["invoice_id"]; ?> </td>
									<td>	<?php echo $row["student_firstname"]." ".$row["student_lastname"]; ?> </td>
									<td>	<?php echo "Type: ".$row["payment_type"]; ?><br>
											<?php echo "Mode: ".$row["payment_mode"]; ?><br>
											<?php echo "Bank: ".$row["bank_name"]." - ".$row["transaction_no"]; ?>
									 </td>
									<td>	<?php echo $row["payment_date"]; ?> </td>
									<td>	Rs.<?php echo $row["payment_amount"]; ?> </td>
									<td>	Rs.<?php echo $row["late_fee_amount"]; ?> </td>
									<td>	Rs.<?php echo $row["total_paid_amount"]; ?> </td>
								</tr>
						            <?php $total_paid = $total_paid + $row ["total_paid_amount"];
						            } ?>
						            <tr>
									<td colspan="7" align="right"><strong>Total Paid Amount:</strong>
									</td>
									<td><strong>Rs.<?php echo $total_paid;?></strong></td>
								</tr>

							</tbody>

						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<?php
$data ['script'] = "";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>