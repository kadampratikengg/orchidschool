<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">Staff Discount Reports</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><a href="<?php echo base_url('reports'); ?>">Reports</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Staff Discounts</span></li>
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
						<a href="<?php echo base_url('reports/download_staff_discount_report')?>" class="btn green-meadow">
							<i class="fa fa-download"></i> Download Report</a>
						<div class="row">
							<hr>
							<table class="table">
								<thead>
									<tr>
										<th>Sr.</th>
										<th>Admission No.</th>
										<th>Student Name</th>
										<th>Parent's Email</th>
										<th>Parent's Mobile</th>
										<th>Total Receivable Amount</th>
										<th>Discount Provided</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; foreach ( $students as $row ) {
				
				echo "<tr><td>" . $i ++ . "</td>";
				echo "<td>" . $row ['admission_no'] . "</td>";
				echo "<td>" . $row ['student_firstname'] ." ". $row ['student_lastname'] . "</td>";
				echo "<td>" . $row ['parent_email_id'] . "</td>";
				echo "<td>" . $row ['parent_mobile_no'] . "</td>";
				echo "<td>Rs." . $row ['invoice_amount'] . "</td>";
				echo "<td>Rs." . $row ['discount_amount'] . "</td></tr>";
				
				
			} ?>
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