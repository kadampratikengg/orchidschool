<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">Manage Standards</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Standards</span></li>
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
							<span class="caption-subject bold uppercase">standards</span>
						</div>
						<div class="actions">
							<a href="<?php echo base_url('standards/add_standard');?>"
								class="btn btn-transparent green-meadow btn-outline btn-circle btn-sm active">
								Add Standard </a>
							<a href="<?php echo base_url('standards/add_instalment');?>"
								class="btn btn-transparent yellow-gold btn-outline btn-circle btn-sm active">
								Add Instalment </a>
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
									<th>Standard</th>
									<th>Total Fees</th>
									<th>No of Installments</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
						            <?php 
						            $i=1;
						            foreach($standards_data as $row){?>
						                <tr class="odd gradeX">
									<td><?php echo $i; $i++;?></td>
									<td>
						                   <?php echo $row["standard_name"]; ?>
						            </td>
						            <td>
						                   <?php echo $row["total_fees"]; ?>
						            </td>
									<td>
						                   <?php echo $row["no_of_instalments"]; ?> 
						            </td>
									
									<td>
						              
						              	<a href="<?php echo base_url('standards/view_instalments/'.$row['standard_id']);?>"
											class="btn default btn-xs yellow-gold-stripe"> View Instalments </a> 
 										<a href="<?php echo base_url('standards/edit_standard/'.$row['standard_id']);?>"
											class="btn default btn-xs yellow-gold-stripe"> Edit </a> 
										<a href="<?php echo base_url('standards/delete_standard/'.$row['standard_id']);?>"
										class="btn default btn-xs red-soft-stripe"
										onclick="if(!confirm('Deleting standard will delete all instalments and particulars related to the standard.\nContinue delete?')) return false;">
											Delete </a> 
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
$data['script']="standards.js";
$data['initialize']="pageFunctions.init();";
$this->load->view('_includes/footer',$data);
?>