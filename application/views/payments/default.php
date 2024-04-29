<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">Manage Payments</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Payments</span></li>
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
							<span class="caption-subject bold uppercase">Payments</span>
						</div>
						<div class="actions">
							<a href="<?php echo base_url('payments/add');?>"
								class="btn btn-transparent green-meadow btn-outline btn-circle btn-sm active">
								Add Payment </a>
							<a href="<?php echo base_url('payments/bulkupload');?>"
								class="btn btn-transparent yellow-gold btn-outline btn-circle btn-sm active">
								Add Bulk Payment </a>
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
									action="<?php echo base_url("payments/index/");?>">
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
									<th>Student Name</th>
									<th>Intsalment Name</th>
									<th>Payment Details</th>
									<th>Payment Date</th>
									<th>Payment Amount</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
						            <?php 
						            $i=1;
						            foreach($payments_data as $row){?>
						            	
										<tr class="odd gradeX">
											<td><?php echo $i; $i++;?></td>
											<td>	
												<?php echo $row["student_firstname"].' '.$row["student_lastname"]; ?><br /> 
												<?php echo "(".$row["admission_no"].")"; ?>
											</td>
											<td>	<?php echo $row["instalment_name"]; ?> </td>
											<td>	 
												<?php echo "Type:".$row["payment_type"]; ?> <br />
												<?php echo "Mode:".$row["payment_mode"]; ?> 
												<?php echo $row['online_payment_mode']==""?'':"(".$row['online_payment_mode'].")";?>
												<?php echo "<br>".$row["narration"].' - '.$row["transaction_no"]; ?>	 
											</td>
											<td>	<?php echo swap_date_format($row["payment_date"]); ?> </td>
											<td>	
												Rs.<?php echo $row["total_paid_amount"]; ?> 
												<?php echo $row['late_fee_amount'] <= "0"?'':"<br>( +Rs.".$row['late_fee_amount']." late fees)";?>
											</td>
											<td>
		 										<a href="javascript:;" onclick="show_modal('<?php echo base_url('payments/view/'.$row['payment_id'].'/'.$division_id);?>');" 
													class="btn default btn-xs blue-sharp-stripe"> View </a>
												<a href="<?php	echo base_url('payments/delete/'.$row['payment_id']);	?>" class="btn default btn-xs red-soft-stripe" 
													onclick="if(!confirm('Are you sure to delete this payment? Please note, if deleted paid amount will added to outstanding amount')) return false;"> Delete </a>
												<a class="btn default btn-xs green-meadow-stripe" href="<?php echo base_url('payments/download_receipt/'.$row['payment_id']); ?>">
													Download</a> 
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
$data['script']="payments.js";
$data['initialize']="pageFunctions.init();";
$this->load->view('_includes/footer',$data);
?>