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
							<i class="icon-settings font-dark"></i> 
							<span class="caption-subject bold uppercase">RTE Students Report</span>
						</div>
						<a class="pull-right btn green-meadow btn-md" href="<?php echo base_url('reports_rte/download_report')?>" ><i class="fa fa-download"></i> Download Report</a>
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
									<th>Student Name</th>
									<th>Division</th>
									<th>Admission Year</th>
									<th>Parent Email</th>
									<th>Parent Mobile</th>
									<th>Status</th>
									<th>View</th>
								</tr>
							</thead>
							<tbody>
					            <?php 
					            $i=1;
					            foreach($student_data as $row){?>
									<tr class="odd gradeX">
										<td><?php echo $i; $i++;?></td>
										<td>
											<a href="<?php echo base_url('reports_rte/view').'/'.$row['student_id']; ?>">	
												<?php echo $row['student_firstname'].' '.$row['student_lastname']; ?><br/>
											</a>
											<?php echo '('.$row['admission_no'].')';?> 
										</td>
										<td align="center">	<?php echo $row['standard_name'].'-'.$row['division_name']; ?> </td>
										<td align="center">	<?php echo $row['admission_year']; ?> </td>
										<td>	<?php echo $row['parent_email_id']; ?> </td>
										<td align="center">	<?php echo $row['parent_mobile_no']; ?> </td>
										<td class="font-green-seagreen" align="center">	<?php echo $row['status']; ?> </td>
										<td>
											<a href="<?php echo base_url('reports_rte/view').'/'.$row['student_id']; ?>"
												class="btn default btn-xs blue-sharp-stripe"> 
												View </a> 
										</td>
									</tr>
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
$data['script']="academic_fees.js";
$data['initialize']="pageFunctions.init();";
$this->load->view('_includes/footer',$data);
?>