<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<h3 class="page-title">Instalments</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><a href="<?php echo base_url('instalments'); ?>">Instalments</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li><span>Instalment Payment</span></li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light ">
				
					<div class="portlet-body" style="text-align: center;">
					<h1></h1>
						<i class="fa fa-check-circle check-mark font-green-meadow" style="font-size:50px;"></i>
						
						<h2  style="font-weight: 600;">Success!!</h2>
						<h4 style="font-weight: 600;"><?php echo $message;?></h4><br/>
						<a href="<?php echo base_url('student_dashboard'); ?>" class="btn default"><i class="fa fa-arrow-circle-left"></i>
						 Back to Dashbord</a>
						<a href="<?php echo base_url('instalments/download_receipt/'.$this->session->userdata('payment_id')); ?>" 
							class="btn blue-steel"> 
							<i class="fa fa-download"></i> Download Receipt
						</a>
						<br/><br/><br/>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
$data ['script'] = "";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>