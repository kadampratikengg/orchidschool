<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<h3 class="page-title">Standard Wise Reports</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Reports</span></li>
			</ul>

		</div>
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption font-dark">
							<i class="icon-reports font-dark"></i> <span
								class="caption-subject bold uppercase">Standard Wise Report - <span
								class="text-muted"><?php echo $standards_data['standard_name'];?> Standard</span></span>
						</div>
						<div class="actions">
							<a href="<?php base_url('reports_standards');?>"
								class="btn btn-circle default"> Back</a>
						</div>
					</div>
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>

									<th>Sr.No.</th>
									<th>Total Receivable</th>
									<th>Received</th>
									<th>Discount Offered</th>
									<th>Outstanding</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1; foreach ( $reports_data as $row ) { ?>
									<tr class="odd gradeX">
										<td><?php echo $i; $i++;?></td>
										<td><a href="javascript:;" onclick="show_receivable()">	Rs. <?php echo $row["invoice_amount"]; ?> </a></td>
		
										<td><a href="javascript:;" onclick="show_received()">	Rs. <?php echo $row["paid_amount"]; ?> </a></td>
		
										<td><a href="javascript:;" onclick="show_discout_offered()">	Rs. <?php echo $row["discount_amount"]; ?> </a></td>
		
										<td><a href="javascript:;" onclick="show_outstanding()">	Rs. <?php echo $row["outstanding_amount"]; ?> </a></td>
									</tr>
					            <?php }?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div id="show_details_container">
					<h3 align="center">Payments Information</h3>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var standard_id = "<?php echo $standards_data['standard_id']; ?>"
	var division_id = "<?php echo $division_id; ?>"	
</script>
<?php
$data ['script'] = "show_reports.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>