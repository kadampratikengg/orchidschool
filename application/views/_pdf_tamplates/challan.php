<html>
<head>
<style type="text/css">
* {
	/* margin: 3px; */
	font-size: 10px;
}

.watermark {
	background-image: url("site_data/images/background.jpg");
	background-repeat: no-repeat;
	background-position: 50% 20%;
	opacity: 0.2;
	background-attachment: fixed;
}

h1 {
	font-size: 18px;
	margin: 0px;
}

table {
	border-collapse: collapse;
}

table td, table th {
	padding: 3px;
}

table.borders {
	margin-right: 20px;
}

table.borders td {
	border: 1px solid #ccc;
}

table.no_border td {
	border: none;
}

table.inner_table {
	width: 100%;
}

.pagebreak {
	page-break-after: always;
}
</style>
</head>
<body>
	<div style="width: 990px;"><br>
		<table>
			<tr>
			<?php for($k=0;$k<3;$k++){ ?>
				<td class="watermark">
					<table class="borders">
						<tr>
							<td colspan="2"><table class="inner_table no_border">
									<tr>
									<td align="center">
										<?php
											if ($k == 0)
												echo "Bank Copy";
											elseif ($k == 1)
												echo "School Copy";
											else
												echo "Student Copy";
											?>
										</td>
										<td align="center">Academic Year <?php echo $student_data['from_year']."-".$student_data['to_year']; ?></td>
										<td align="center">Installment <?php echo $student_data['instalment_name']; ?></td>
									</tr>
								</table></td>

						</tr>
						<tr>
							<td colspan="2" align="center" class="noborder"><h1>THE ORCHID
									SCHOOL</h1></td>
						</tr>

						<tr>
							<td colspan="2">Bank Name: HDFC Bank Ltd</td>
						</tr>
						<tr>
							<td colspan="2">Account Name: PNES - The Orchid School</td>
						</tr>
						<tr>
							<td colspan="2">Client Code: <strong>POCDPNSCHL</strong></td>
						</tr>
						<tr>
							<td colspan="2">Accept Till Date : 
								<strong>
									<?php
										$current_date =  new DateTime(date('Y-m-d'));
										$due_date = new DateTime($student_data['due_date']);
										
										if($due_date<$current_date){
											echo date('d-M-Y');
										}else{
											echo date('d-M-Y',strtotime(swap_date_format( $student_data['due_date'] )));
										}
									?>
								</strong>
							</td>

						</tr>
						<tr>
							<td colspan="2">Challan No: <strong><?php echo $student_data ['standard_prefix'] . $student_data ['instalment_prefix'] . "-" . $student_data ['student_id'];?></strong>
							</td>

						</tr>

						<tr>
							<td>Admission No:</td>
							<td>
								<strong><?php echo $student_data['admission_no'];?></strong>
							</td>
						</tr>

						<tr>
							<td>Students Name:</td>
							<td><strong><?php echo $student_data['student_firstname']." ".$student_data['student_lastname'];?></strong>
							</td>
						</tr>
						<tr>
							<td>Standard:</td>
							<td><?php echo $student_data['standard_name']; ?>
							</td>
						</tr>
						<tr>
							<td>Division:</td>
							<td><?php echo $student_data['division_name']; ?>
							</td>
						</tr>
						<tr>
							<td><strong>PARTICULARS</strong></td>
							<td align="right"><strong>AMOUNT</strong></td>
						</tr>
						<?php $i=1; foreach ($instalment_particulars as $row){?>
							<tr>
							<td><?php echo $i.". ".$row['description']; ?></td>
							<td align="right">Rs.<?php echo $row['amount'] - round ( $row['amount']*$student_data['staff_discount']/100 );?></td>
						</tr>
						<?php $i++; }?>
				
						<tr>
							<td align="right">Fee Sub Total:</td>
							<td align="right">
								Rs.<?php echo $student_data['instalment_amount']- round ( $student_data['instalment_amount']*$student_data['staff_discount']/100 ) ;?>
							</td>
						</tr>
						<tr>
							<td align="right">
								Late Fees x <?php echo $student_data['late_fee']; ?>: 
							</td>
							<td align="right">
								<?php
				$due_date = new DateTime ( $student_data ['due_date'] );
				$current_date = new DateTime ( date ( "Y-m-d" ) );
				$interval = $current_date->diff ( $due_date );
				$late_days = $interval->format ( '%a' );
				$total_late_fees = 0;
				if ($current_date > $due_date && $late_days > 0) {
					$total_late_fees = $late_days * $student_data ["late_fee"];
				}
				$total_amount = $total_late_fees + $student_data ['instalment_amount'] - round ( $student_data ['instalment_amount'] * $student_data ['staff_discount'] / 100 );
				echo $total_late_fees;
				?> 
							</td>
						</tr>

						<tr>
							<td align="right"><strong>TOTAL AMOUNT: </strong></td>
							<td align="right"><strong>Rs. <?php echo $total_amount; ?></strong></td>
						</tr>
						<tr>
							<td colspan="2">
								Amount in Words: <?php echo number_to_rupees($total_amount);?>
							</td>
						</tr>
						<tr>
							<td colspan="2">Cash / Cheque No:
								__________________________________</td>
						</tr>
						<tr>
							<td colspan="2">Drawn On: __________________________________</td>
						</tr>
						<tr>
							<td colspan="2">Parents Contact No: <?php echo $student_data['parent_mobile_no']; ?></td>
						</tr>
						<tr>
							<td colspan="2">
								<table class="inner_table no_border">
									<tr>
										<td align="center"><br>Created By</td>
										<td align="center"><br>Sign of Bank Officer</td>
										<td align="center"><br>Sign of Depositor</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2"><strong>Terms: </strong></td>
						</tr>
						<tr>
							<td colspan="2">1. This challan is valid only till the due date.
								After the due date, parents needs to endorse this challan</td>
						</tr>
						<tr>
							<td colspan="2">2. Signature from the school authority. Without
								proper attestation, it will not be accepted.</td>
						</tr>
						<tr>
							<td colspan="2">3. Cheques accepted for outstation account
								holders. #Separate cheques to submited for payments of this
								challan.</td>
						</tr>

					</table>
				</td>
				<?php } ?>
			</tr>
		</table>
		<!-- <div class="pagebreak"></div> -->
	</div>
</body>
</html>