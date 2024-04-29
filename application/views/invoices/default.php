<?php $this->load->view('_includes/header');?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<!-- BEGIN CONTENT BODY -->
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->

			<h3 class="page-title"> Manage Invoices
                    </h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="icon-home"></i>
						<a href="<?php echo base_url('dashboard'); ?>">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<span>Invoices</span>
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
								<span class="caption-subject bold uppercase">Student Invoices</span>
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
							<table class="table table-striped table-bordered table-hover table-checkable order-column" id="managed_datatable">
								<thead>
									<tr>
										<th>Sr.No </th>
										<th>Student Name </th>
										<th>Academic Year </th>
										<th>Description</th>
										<th>Date</th>
										<th>Invoice Amount</th>
										<th>Status</th>
										
									</tr>
								</thead>
								<tbody>
						            <?php
						            $i=1;
						            foreach($invoices_data as $row)
						            {?>
						                <tr class="odd gradeX">
						                	<td>
						                        <?php echo $i ; $i++ ;?>
						                    </td>
						                	<td>
						                        <?php echo $row["student_firstname"].' '.$row["student_lastname"]; ?>
						                    </td>
						                    <td>
						                        <?php echo $row["from_year"].'-'.$row["to_year"]; ?>
						                    </td>
						                    <td>
						                        <?php echo $row["description"]; ?>
						                    </td>
						                     <td>
						                        <?php echo $row["invoice_date"]; ?>
						                    </td>
						                     <td>
						                        <?php  echo $row["invoice_amount"]; ?>
						                    </td>
						                    <td>
						                        <span class="<?php echo $row['status'] == "PAID" ? "font-green-seagreen":"font-red-thunderbird"?>"><?php echo $row["status"]; ?></span>
						                    </td>
						                   	<td>
												<a href="javascript:;" onclick="show_modal('<?php echo base_url('invoices/view/'.$row['invoice_id']);?>');" 
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
$data['script']="invoices.js";
$data['initialize']="pageFunctions.init();";
$this->load->view('_includes/footer',$data);
?>