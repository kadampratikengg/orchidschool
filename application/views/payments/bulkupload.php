<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">
			Manage Payments
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><a href="<?php echo base_url('payments'); ?>">Payments</a>
					<i class="fa fa-angle-right"></i></li>
				<li><span> Bulk Payments Upload</span>	
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
								class="caption-subject bold uppercase"> Bulk Payments Upload</span>
						</div>
						<div class="actions">
							
								<a href="<?php echo base_url('payments');?>"
									class="btn btn-circle default">
									Back</a>
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
			              
			              <?php if( $this->upload->display_errors()!=""){?>
			                <div
								class="Metronic-alerts alert alert-danger fade in">
								<button type="button" class="close" data-dismiss="alert"
									aria-hidden="true"></button>
								<i class="fa-lg fa fa-warning"></i>  <?php echo  $this->upload->display_errors();?>
			                </div>
			              <?php }?>
			              
			             
		              
						<form id="add_student_form" class="horizontal-form"
							action="<?php echo base_url('payments/save_bulkupload');?>"
							method="post" enctype="multipart/form-data">
							<div class="form-body">
								<h3 class="form-section">Bulk Payments</h3>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<a style="font-size:15px; text-decoration:underline;" 
												href="<?php echo base_url('payments/download_sample_excel'); ?>">
												Download Sample Excel
											</a>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Instalments</label> <select
												id="instalment_prefix" name="instalment_prefix" class="form-control">
												<option value="">Select Instalment Prefix</option>
												<?php foreach ($instalments as $row){?>
													<option value="<?php echo $row['instalment_prefix'];?>"
														<?php echo  set_select('instalment_prefix',$row['instalment_prefix']); ?>>
														<?php echo $row['instalment_prefix'];?>
													</option>
												<?php }?>
											</select>
										</div>
									</div>
									<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Upload Excel</label><br>
										<div class="fileinput fileinput-new"
											data-provides="fileinput">
											<div class="input-group input-large">
												<div
													class="form-control uneditable-input input-fixed input-medium"
													data-trigger="fileinput">
													<i class="fa fa-file fileinput-exists"></i>&nbsp; <span
														class="fileinput-filename"> </span>
												</div>
												<span class="input-group-addon btn default btn-file"> <span
													class="fileinput-new"> Select file </span> <span
													class="fileinput-exists"> Change </span> <input
													type="file" name="payments_excel">
												</span> <a href="javascript:;"
													class="input-group-addon btn red fileinput-exists"
													data-dismiss="fileinput"> Remove </a>
													
											</div>
										</div>
										<span class="help-block"> Allowed file types .xlsx and size less than 2MB</span>
									</div>
								</div>
								</div>
							</div>
							<div class="form-actions right">
								<button type="submit" class="btn blue">
									<i class="fa fa-check"></i> Save
								</button>
								<a type="button" class="btn default" href="<?php echo base_url('payments');?>">Cancel</a>
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
$data ['script'] = "payments.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>