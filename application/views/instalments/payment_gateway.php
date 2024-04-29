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
				<li><span>Pay Instalment</span></li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption font-dark">
							<i class="icon-settings font-dark"></i> <span
								class="caption-subject bold uppercase">Pay Instalment</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="form-body">
							<form id="subFrm" name="subFrm" method="post" 
								action="https://www.billdesk.com/pgidsk/pgijsp/KreedaPaymentoption.jsp">
								<input type="hidden" name="msg" value="<?php echo $hash_message?>"> 
							</form>
							<center>
								<h3>
									<br> Redirecting to BillDesk Payment Gateway, <br> <br> <br> Please
									wait and Do not Press Back or Refresh
								</h3>
								If you are not redirected to BillDesk within 3 sec <a
									href="javascript:void(0);" onClick="document.subFrm.submit();">Click
									here to redirect</a> <br> <br> <img
									src="<?php echo images_path;?>loading.gif">
							</center>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
$data ['script'] = "_initiate_payment.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>