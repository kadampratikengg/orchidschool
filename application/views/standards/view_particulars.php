  <div class="modal-records">
	<p>
		<strong>Installment : <?php echo $instalment_data['instalment_name'];?> | Rs.<?php echo $instalment_data['instalment_amount'];?>
		</strong>
	</p>
	<table class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th>#</th>
				<th>Particular</th>
				<th>Amount</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($particulars_data as $row){?>
			<tr>
				<td><?php echo $row['sequence_no'];?></td>
				<td><?php echo $row['description'];?></td>
				<td><?php echo $row['amount'];?></td>
				<td><a href="<?php echo base_url('standards/delete_particular/'.$row['instalment_particular_id']);?>">Delete Particular</a></td>
			</tr>
		<?php }?>
		<?php if(count($particulars_data)==0){?>
			<tr>
				<td colspan="4" align="center">No records found</td>
			</tr>
		<?php }?>
		</tbody>
	</table>
</div>
<br>



