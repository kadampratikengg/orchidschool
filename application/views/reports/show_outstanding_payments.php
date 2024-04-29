<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<h3 class="page-title">Outstanding payments</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Other Fees</span></li>
			</ul>

		</div>
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption font-dark">
							<i class="icon-reports font-dark"></i> <span
								class="caption-subject bold uppercase">Outstanding Payments <span class="text-muted">from <?php echo $from_date;?> to <?php echo $to_date;?></span></span>
						</div>
					</div>
					<div class="portlet-body">
						<table	class="table table-striped table-bordered table-hover">
							<thead>
								<tr>

									<th>Sr.No.</th>
									<th>Invoice No.</th>
									<th>Student Name</th>
									<th>Invoice Date</th>
									<th>Type</th>
									<th>Total Amount</th>
									<th>Paid</th>
									<th>Discount</th>
									<th>Outstanding</th>
								</tr>
							</thead>
							<tbody>
						            <?php $i = 1; $total_outstanding=0;
						            foreach ( $outstanding_data as $row ) { ?>
										<tr class="odd gradeX">
									<td><?php echo $i; $i++;?></td>
									<td>	<?php echo $row["invoice_id"]; ?> </td>
									<td>	<?php echo $row["student_firstname"]." ".$row["student_lastname"]; ?> </td>
									<td>	<?php echo $row["invoice_date"]; ?> </td>
									<td>	<?php echo $row["invoice_type"]; ?> </td>
									<td>	Rs.<?php echo $row["invoice_amount"]; ?> </td>
									<td>	Rs.<?php echo $row["paid_amount"]; ?> </td>
									<td>	Rs.<?php echo $row["discount_amount"]; ?> </td>
									<td>	Rs.<?php echo $row["outstanding_amount"]; ?> </td>
									</tr>
						            <?php 
						            $total_outstanding = $total_outstanding+$row["outstanding_amount"]; 
						            }?>
						            <tr><td colspan="8" align="right"><strong>Total outstanding Amount:</strong> </td>
						            <td><strong>Rs.<?php echo $total_outstanding;?></strong></td></tr>
						            
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