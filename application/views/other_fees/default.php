<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">Manage Other Fees</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Other Fees</span></li>
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
								class="caption-subject bold uppercase">Other Fees</span>
						</div>
						<div class="actions">
							<a
								href="<?php echo base_url('other_fees/apply_division_fees');?>"
								class="btn btn-transparent green-meadow btn-outline btn-circle btn-sm active">
								Apply Fees to Division</a> <a
								href="<?php echo base_url('other_fees/apply_student_fees');?>"
								class="btn btn-transparent yellow-gold btn-outline btn-circle btn-sm active">
								Apply Fees to a Student</a>
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
              
							<table
							class="table table-striped table-bordered table-hover table-checkable order-column"
							id="managed_datatable">
							<thead>
								<tr>

									<th>Sr.No.</th>
									<th>Description</th>
									<th>Fees</th>
									<th>Compulsory</th>
									<th>Start Date</th>
									<th>Due Date</th>
									<th>End Date</th>
									<th>Late Fess</th>
								</tr>
							</thead>
							<tbody>
						            <?php $i = 1; 
						            foreach ( $other_fees_data as $row ) { ?>
										<tr class="odd gradeX">
									<td><?php echo $i; $i++;?></td>
									<td>	<?php echo $row["description"]; ?> 
											<?php echo "<span class='text-muted'><br>Applied to: ".$row['applicable_to']." (";?>
											<?php echo $row['applicable_to']=="DIVISION"?$row['division_name']." )":$row['student_firstname'].' '.$row['student_lastname']." )";?>
											<?php echo "</span>";?>
									</td>
									<td>	<?php echo $row["amount"]; ?> </td>
									<td>	<?php echo $row["compulsory"]; ?> </td>
									<td>	<?php echo $row["start_date"]; ?> </td>
									<td>	<?php echo $row["due_date"]; ?> </td>
									<td>	<?php echo $row["end_date"]; ?> </td>
									<td>	<?php echo $row["late_fees"]; ?> </td>
									
									
						            <?php }?>
						        </tbody>

						</table>
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
$data ['script'] = "other_fees.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>