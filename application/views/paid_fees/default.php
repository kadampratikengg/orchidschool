<?php $this->load->view('_includes/header');?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<!-- BEGIN CONTENT BODY -->
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->

			<h3 class="page-title"> Manage Students
                    </h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="icon-home"></i>
						<a href="<?php echo base_url('dashboard'); ?>">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<span>Students</span>
					</li>
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
								<span class="caption-subject bold uppercase">Paid Fees Detail</span>
							</div>
							
						</div>
						<div class="portlet-body">
							 <?php if($this->session->flashdata("success_message")!=""){?>
		                <div class="Metronic-alerts alert alert-info fade in">
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		                    <i class="fa-lg fa fa-check"></i>  <?php echo $this->session->flashdata("success_message");?>
		                </div>
		              <?php }?>
		              <?php if($this->session->flashdata("error_message")!=""){?>
		                <div class="Metronic-alerts alert alert-danger fade in">
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		                    <i class="fa-lg fa fa-warning"></i>  <?php echo $this->session->flashdata("error_message");?>
		                </div>
		              <?php }?>
		              
		              <?php if(validation_errors()!=""){?>
		                <div class="Metronic-alerts alert alert-danger fade in">
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		                    <i class="fa-lg fa fa-warning"></i>  <?php echo validation_errors();?>
		                </div>
		              <?php }?>
              <?php //echo '<pre>';
              		//print_r($paid_fees_data);
              		//print_r($academic_year);
              		//print_r($standard);
              		//exit();	?>
							<table class="table table-striped table-bordered table-hover table-checkable order-column" id="managed_datatable">
								<thead>
									<tr>
										
										<th>Sr.No.</th>
										<th> Name </th>
										<th> Admission Year </th>
										<th> Instalment Name</th>
										<th> Payment Date </th>
										<th> Instalment Amount </th>
										<th> Paid Fees </th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
						            <?php
						            $i=1;
						            foreach($paid_fees_data as $row)
						            {
						            ?>
						            <tr class="odd gradeX">
						                <td><?php echo $i; $i++;?></td>
						               	<td>
						                    <?php echo $row["student_firstname"].' '.$row["student_lastname"]; ?>
						                </td>
						                <td>
						                    <?php echo $row["admission_year"]; ?>
						                </td>
						                <td>
						                     <?php echo $row['instalment_name']; ?>
						                </td>
						                <td>
						                     <?php echo $row["payment_date"]; ?>
						                </td>
						                 <td>
						                      <?php echo $row["payment_amount"]; ?>
						                 </td>
						                 <?php
						                 		if($row["late_fee_amount"]==0)
						                 		{
						                 			?>
						                 				<td>
						             			    		<?php echo $row["total_paid_amount"]; ?>
						                 				</td>
						                 			<?php 
						                 		}
						                 		else 
						                 		{
						                 			?>
						                 				<td>
						             			    		<?php echo $row["total_paid_amount"]; ?></br>
						             			    		(late fee + <?php echo $row["late_fee_amount"];?>)
						                 				</td>
						                 				
						                 			<?php 
						                 		}
						                 
						                 						                 
						                 ?>
						                   	<td>
						                   		
												<a href="javascript:;" onclick="show_modal('<?php echo base_url('paid_fees/view/'.$row['student_id'].'/'.$row['invoice_id']);?>');" 
													class="btn default btn-xs blue-sharp-stripe"> View </a>
												<a href="<?php echo base_url('paid_fees/download_receipt/'.$row['student_id'].'/'.$row['invoice_id']);?>" 
													class="btn default btn-xs yellow-gold-stripe"> Download </a>
											</td>
						                </tr>
						               		
						            <?php 
						            }
						            ?>
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
$data['script']="students.js";
$data['initialize']="pageFunctions.init();";
$this->load->view('_includes/footer',$data);
?>