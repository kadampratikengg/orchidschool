<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">Manage Academic Fees</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Academic Fees</span></li>
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
							<span class="caption-subject bold uppercase">Academic Fees</span>
						</div>
						<div class="actions">
							<a href="<?php echo base_url('academic_fees/add');?>"
								class="btn btn-transparent green-meadow btn-outline btn-circle btn-sm active">
								Apply Fees </a>
							<a href="<?php echo base_url('academic_fees/bulk_challan');?>"
								class="btn btn-transparent yellow-gold btn-outline btn-circle btn-sm active">
								Download Challan </a>
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
              			<div class="row">
							<div class="col-md-12">
								<form class="form-inline" method="get"
									action="<?php echo base_url("academic_fees/index/");?>">
									<div class="form-group">
										<select class="form-control" id="division_id"
											name="division_id">
											<option value="">Select Division</option>
											<?php foreach ( $divisions as $row ) :?>
													<option value="<?php echo $row['division_id'];?>"
												<?php echo set_select ( "division_id", $row ['division_id'], $row ['division_id'] == $division_id ? true : false );?>>
														<?php echo $row['standard_name'].' - '. $row['division_name'];?>
								                    </option>
								                  	<?php
											endforeach
											;
											?>
											</select>
									</div>
									<button type="submit" class="btn blue">Show Students</button>
									<hr>
								</form>
							</div>
						</div>
						<table
							class="table table-striped table-bordered table-hover table-checkable order-column"
							id="managed_datatable">
							<thead>
								<tr>
									<th>Sr.No.</th>
									<th>Invoice No</th>
									<th>Instalment</th>
									<th>Student Name</th>
									<th>Fees</th>
									<th>Discount</th>
									<th>Paid</th>
									<th>Outstanding</th>
									<th>Status</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
						            <?php 
						            $i=1;
						            foreach($academic_fees_data as $row){?>
										<tr class="odd gradeX">
											<td><?php echo $i; $i++;?></td>
											<td>	<?php echo $row["invoice_id"]; ?> </td>
											<td>	<?php echo $row["instalment_name"]; ?> </td>
											<td>	<?php echo $row["student_firstname"].' '.$row["student_lastname"]; ?> </td>
											<td>	<?php echo $row["invoice_amount"]; ?> </td>
											<td>	<?php echo $row["discount_amount"]; ?> </td>
											<td>	<?php echo $row["paid_amount"]; ?> </td>
											<td>	<?php echo $row["outstanding_amount"]; ?> </td>
											<td class="<?php echo $row['status'] == "FULLY_PAID" ? "font-green-seagreen":"font-red-thunderbird"?>">	
												<?php echo $row['status'] == "FULLY_PAID" ? "PAID":"UNPAID"?>
											</td>
											<td>
		 										<a href="javascript:;" 
		 											onclick="show_modal('<?php echo base_url('academic_fees/view/'.$row['invoice_id']);?>');" 
													class="btn default btn-xs blue-sharp-stripe"> View </a> 
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