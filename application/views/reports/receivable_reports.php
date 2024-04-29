<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">Receivable Payment Reports</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><a href="<?php echo base_url('reports'); ?>">Reports</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Receivable Payment</span></li>
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
						<form id="staff_discount_report" class="horizontal-form" 
							method="post" action="<?php echo base_url('reports/download_receivable_report'); ?>">
							<div class="form-body">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label">Standard</label> <select
												id="standard_id" name="standard_id" class="form-control"
												onchange="get_instalments(this.value);">
												<option value="">Select</option>
												<option value="all">All</option>
												<?php foreach ( $standard_data as $row ){ ?>
													<option value="<?php echo $row['standard_id'];?>"
													<?php echo set_select("standard_id",$row['standard_id']);?>>
														<?php echo $row['standard_name'];?>
								                    </option>
							                  	<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label">Instalment</label> <select
												id="instalment_id" name="instalment_id" class="form-control">
												<option value="">select standard first</option>
												
											</select>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label class="control-lable">&nbsp;</label> <a
												href="javascript:;" id="btn_show"
												class="btn btn-default form-control blue"
												onclick="get_receivable_reports()">SHOW</a>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label class="control-lable">&nbsp;</label> 
												<button type="submit" class="btn form-control pull-right green-meadow"> 
													<i class="fa fa-download"></i> Dowload Report
												</button>
										</div>
									</div>
								</div>
							</div>
						</form>
						<div class="row">
							<hr>
							<table class="table">
								<thead>
									<tr>
										<th>Sr.</th>
										<th>Admission No.</th>
										<th>Student Name</th>
										<th>Challan No.</th>
										<th>Challan Amount(Late Fees)</th>
									</tr>
								</thead>
								<tbody id="receivable_table_container">
									<tr>
										<td colspan="5" align="center"><span>No data to display</span></td>
									</tr>
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