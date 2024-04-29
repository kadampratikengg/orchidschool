<form class="form-horizontal" role="form">
	<div class="form-body">
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
					<td><?php echo $row['amount'] - $row['amount']*$row['staff_discount'] / 100;?></td>
				</tr>
			<?php }?>
			
			<?php if(count($instalment_particulars)==0){?>
				<tr>
					<td colspan="4" align="center">No particulars found</td>
				</tr>
			<?php }?>
			</tbody>
		</table>
	</div>
</form>
