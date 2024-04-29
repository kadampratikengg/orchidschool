<style>
.student-info-container strong{
	font-weight: 600;	
}
</style>

<form class="form-horizontal student-info-container" role="form">
	<div class="form-body">
		<h4 class="font-red-soft" style="font-weight: bold;"><?php echo $payment_data['student_firstname'].' '.$payment_data['student_lastname']; ?></h4>
		<strong>Instalment:</strong> <?php echo $payment_data['instalment_name']; ?> &nbsp;&nbsp;
		<strong>Date:</strong> <?php echo swap_date_format($payment_data['payment_date']); ?>&nbsp;&nbsp;
		<strong> Mode:</strong> <?php echo $payment_data['payment_mode']; ?> 
		<?php echo $payment_data['online_payment_mode'] != null? "( ".$payment_data['online_payment_mode']." )":""?>
		
		<br/> <br/>
		<ul class="list-group">
			
			<?php if($payment_data['transaction_no'] != ""){ ?>
				<li class="list-group-item">
					<strong> Transaction No.: </strong>
					<?php echo $payment_data['transaction_no']; ?>
				</li>
			<?php }?>
			<li class="list-group-item">
				<strong>Narration:</strong> <?php echo $payment_data['narration']; ?>
			</li>
			<li class="list-group-item font-blue-steel" style="font-size: 16px;">
				<strong>Instalment Amount:</strong> <?php echo $payment_data['payment_amount']; ?>
				<span class="font-red-soft"><?php echo $payment_data['late_fee_amount'] > 0? " + Late Fees: ".$payment_data['late_fee_amount']:"" ?></span>
			</li>
			<?php if($payment_data['discount_amount']>0){?>
				<li class="list-group-item">
					<strong>Total Discount:</strong> <?php echo $payment_data['discount_amount']; ?>
				</li>
			<?php }?>
			<li class="list-group-item font-green-meadow" style="font-size: 16px;">
				<strong>Total Paid Amount:</strong> <?php echo $payment_data['total_paid_amount']; ?> 
			</li>
		</ul>
		<!-- /row -->
		<div class="modal-records">
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>#</th>
						<th>Particular</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($instalment_particulars as $row){?>
					<tr>
						<td><?php echo $row['sequence_no'];?></td>
						<td><?php echo $row['description'];?></td>
						<td><?php echo $row['amount'];?></td>
					</tr>
				<?php }?>
				<?php if(count($instalment_particulars)==0){?>
					<tr>
						<td colspan="4" align="center">Particulars not found for this
							instalment</td>
					</tr>
				<?php }?>
				</tbody>
			</table>
		</div>
		<!--/row-->
	</div>
</form>
