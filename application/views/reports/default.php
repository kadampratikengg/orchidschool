<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">Reports</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Reports</span></li>
			</ul>
		</div>
		<!-- END PAGE HEADER-->
		
		<div class="row">
			<div class="col-md-12" style="background-color: #ffffff;padding-top: 15px;">
				<h4>Instalment wise Payment Summary</h4>
				<table class="table table-bordered table-hovered table-condensed" id="report_container">
					<tr class="bg-yellow-gold report_heading1">
						<td class="bg-font-yellow-gold">Instalment</td>
						<td class="bg-font-yellow-gold">Total Receivable</td>
						<td class="bg-font-yellow-gold">Paid</td>
						<td class="bg-font-yellow-gold">Discount</td>
						<td class="bg-font-yellow-gold">Outstanding</td>
						<td class="bg-font-yellow-gold">View Details</td>
					</tr>
					<?php $i=1;
						$receivable=0;$paid=0;$discount=0;$outstanding=0;
						
						foreach($instalment_data as $instalment){
							
						$receivable= $receivable+$instalment['receivable'];
						$paid= $paid+$instalment['paid'];
						$discount= $discount+$instalment['discount'];
						$outstanding= $outstanding+$instalment['outstanding'];
						
						?>
					<tr class="">
						<td>Instalment No. <?php echo $i;?> (<?php echo $instalment['prefix']?>)</td>
						<td>Rs.<?php echo $instalment['receivable'];?></td>
						<td>Rs.<?php echo $instalment['paid'];?></td>
						<td>Rs.<?php echo $instalment['discount'];?></td>
						<td>Rs.<?php echo $instalment['outstanding'];?></td>
						<td><a href="javascript:;" class="font-yellow-gold" onclick="show_standard_details('<?php echo $instalment['prefix'];?>')"><i class="fa fa-search"></i> View Details</a></td>
					</tr>
					<tr class="" id="standard_<?php echo $instalment['prefix'];?>_container" style="display: none;">
						<td colspan="6"><i class="fa fa-spin fa-refresh"></i> Loading data...</td>
					</tr>
					<?php $i++;}?>
					<tr class="">
						<td><strong>Total</strong></td>
						<td><strong>Rs.<?php echo $receivable;?></strong></td>
						<td><strong>Rs.<?php echo $paid;?></strong></td>
						<td><strong>Rs.<?php echo $discount;?></strong></td>
						<td><strong>Rs.<?php echo $outstanding;?></strong></td>
						<td></td>
					</tr>
					

				</table>
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