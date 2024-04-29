<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->
		<h3 class="page-title">
			My Dashboard <span class="pull-right"> <?php echo $this->session->userdata('first_name').' '.$this->session->userdata('last_name'); ?></span> 
		<!-- <span class="pull-right">
				<a class="btn green-meadow" href="<?php echo base_url('Student_dashboard/download_tax_certificate');	?>">
				<i class="fa fa-download"></i>Download Tax Certificate</a>
			</span> -->
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <span>Home</span>
			</ul>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN DASHBOARD STATS 1-->
		 <?php if($this->session->flashdata("success_message")!=""){?>
            <div class="Metronic-alerts alert alert-info fade in">
			<button type="button" class="close" data-dismiss="alert"
				aria-hidden="true"></button>
			<i class="fa-lg fa fa-check"></i>  <?php echo $this->session->flashdata("success_message");?>
            </div>
          <?php }?>
          <?php if($this->session->flashdata("error_message")!=""){?>
            <div class="Metronic-alerts alert alert-danger fade in">
			<button type="button" class="close" data-dismiss="alert"
				aria-hidden="true"></button>
			<i class="fa-lg fa fa-warning"></i>  <?php echo $this->session->flashdata("error_message");?>
            </div>
          <?php }?>

          
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat red">
					<div class="visual">
						<i class="fa fa-bar-chart-o"></i>
					</div>
					<div class="details">
						<div class="number">
							<i class="fa fa-rupee"></i> <span data-counter="counterup"
								data-value="<?php echo $fees_data['total_fees']?>">0</span>
						</div>
						<div class="desc">Total Payble</div>
					</div>
				</div>
			</div>
			<?php if($fees_data['total_discount'] > 0){?>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue">
						<div class="visual">
							<i class="fa fa-comments"></i>
						</div>
						<div class="details">
							<div class="number">
								<i class="fa fa-rupee"></i> <span data-counter="counterup"
									data-value="<?php echo $fees_data['total_discount']; ?>">0</span>
							</div>
							<div class="desc">Total Discount Received</div>
						</div>
					</div>
				</div>
			<?php }?>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat green-meadow">
					<div class="visual">
						<i class="fa fa-shopping-cart"></i>
					</div>
					<div class="details">
						<div class="number">
							<i class="fa fa-rupee"></i> <span data-counter="counterup"
								data-value="<?php echo $fees_data['total_fees_paid']?>">0</span>
						</div>
						<div class="desc">Total Fees Paid</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat red-pink">
					<div class="visual">
						<i class="fa fa-globe"></i>
					</div>
					<div class="details">
						<div class="number">
							<i class="fa fa-rupee"></i> <span data-counter="counterup"
								data-value="<?php echo ($fees_data['total_fees_paid'] + $fees_data['total_outstanding_fees']) - ($fees_data['total_fees'] - $fees_data['total_discount']); ?>"></span>
						</div>
						<div class="desc">Total Late Fees Paid</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat purple">
					<div class="visual">
						<i class="fa fa-globe"></i>
					</div>
					<div class="details">
						<div class="number">
							<i class="fa fa-rupee"></i> <span data-counter="counterup"
								data-value="<?php echo $fees_data['total_outstanding_fees']?>"></span>
						</div>
						<div class="desc">Total Outstanding Fees</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<?php
$data ['script'] = "student_dashboard.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>    