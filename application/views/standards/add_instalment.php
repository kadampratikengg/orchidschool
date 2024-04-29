<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">Add Instalment</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><a href="<?php echo base_url('Standards'); ?>">Standards</a>
					<i class="fa fa-angle-right"></i></li>
				<li><span>Add Instalments</span></li>
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
								class="caption-subject bold uppercase"> Add Instalment</span>
						</div>
						<div class="actions">
							<a href="<?php echo base_url('standards');?>"
								class="btn btn-circle default"> Back</a>
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
		              
		              <form id="add_instalment_form" class="horizontal-form"
							action="<?php echo base_url('standards/save_instalment');?>"
							method="post">
							<div class="form-body">
								<h3 class="form-section">Instalment Details</h3>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Standard</label> <select
												id="standard_id" name="standard_id" class="form-control">
												<option value="">Select</option>
												<?php foreach ( $standards_data as $row ) :	?>
													
													<option value="<?php echo $row['standard_id'];?>" 
														<?php echo  set_select('standard_id', $row['standard_id']);?> >
														<?php echo $row['standard_name'];?>
								                    </option>
											    <?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Installment Name</label> <input
												id="instalment_name" name="instalment_name"
												class="form-control" type="text"
												value="<?php echo set_value('instalment_name');?>">
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label class="control-label">Instalment Prefix</label> <select
												id="instalment_prefix" name="instalment_prefix"
												class="form-control" >
												<option value="">Selelct</option>
												<?php for($prefix = 'A'; $prefix < 'Z'; $prefix++) {	?>
													<option value="<?php echo $prefix;?>"
													<?php echo set_select('instalment_prefix',$prefix);?>>
														<?php echo $prefix;?>
								                    </option>
											    <?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4"><div class="form-group"></div>
									</div>
									<div class="col-md-4"><div class="form-group"></div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<div id="prefix_msg"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Installment Amount</label> <input
												id="instalment_amount" name="instalment_amount"
												class="form-control" type="text"
												value="<?php echo set_value('instalment_amount');?>">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Late Fees per day</label> <input
												id="late_fee" name="late_fee" class="form-control"
												type="text" value="<?php echo set_value('late_fee');?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Start Date</label> <input
												id="start_date" name="start_date"
												class="form-control date-picker" placeholder="dd/mm/yyyy"
												type="text" value="<?php echo set_value('start_date');?>">
										</div>
										
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Due Date</label> <input
												id="due_date" name="due_date"
												class="form-control date-picker" placeholder="dd/mm/yyyy"
												type="text" value="<?php echo set_value('due_date');?>">
										</div>
										
									</div>
									<!-- <div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Due Date</label> <input
												type="text" placeholder="dd/mm/yyyy"
												class="form-control date-picker" name="due_date"
												id="due_date" value="<?php //echo set_value('due_date');?>">
												
										</div>
									</div> -->
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn green-meadow">
										<i class="fa fa-check"></i> Save
									</button>	
									<a href="<?php echo base_url("standards");?>" class="btn red-soft"> Cancel </a>
									</button>

								</div>
							</div>
						</form>
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
$data ['script'] = "standards.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>