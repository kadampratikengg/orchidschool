<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payment Receipt</title>
<style type="text/css" media="print">
@page {
	size: auto; /* auto is the initial value */
	margin: 5mm; /* this affects the margin in the printer settings */
}
</style>

<style type="text/css">
.watermark {
	background-image: url('site_data/images/logo.jpg');
	width: 100%;
	background-position: center;
	height: 40px;
	background-repeat: no-repeat;
}

ul li {
	margin-bottom: 10px;
}

@media print {
	body {
		/* 		font-family: Verdana, Geneva, sans-serif; */
		font-size: 14px !important;
	}
	table td {
		border: 1px solid #ccc;
	}
	table td.noborder {
		border: none !important;
	}
	table {cellpadding
		
	}
	table {
		border-collapse: collapse; /* 'cellspacing' equivalent */
	}
	table td, table th {
		padding: 5px; /* 'cellpadding' equivalent */
	}
}

strong {
	color: #333;
}

body {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
}

.page_title {
	font-size: 18px;
	color: #333;
}

table.styleme td {
	background: #fff;
}

table.styleme td.highlight {
	background: #ECDCD5;
}

table.styleme td.no_highlight {
	color: #fff;
}

table.styleme tr.blank td {
	background: #FFF !important;
}

table td {
	border: 1px solid #ccc;
}

table td.noborder {
	border: none !important;
}

table {cellpadding
	
}

table {
	border-collapse: collapse; /* 'cellspacing' equivalent */
}

table td, table th {
	padding: 5px; /* 'cellpadding' equivalent */
}
</style>
</head>

<body style="margin: 0px;" onload="">
	<div id="wrapper"
		style="width: 100%; border: 1px solid #000; background: #FFF;">
		<div id="header" style="height: 110px; padding: 10px;">
			<table width="100%">
				<tr>
					<td style="border: 0px;">
						<div class="watermark"></div>
					</td>
				</tr>
				<tr>
					<!-- <td width="55%" align="left" valign="middle" class="noborder">
						<img src=" data:image/jpeg;base64,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" />
					</td> -->
					<td class="noborder" align="center" valign="top">Baner - Mhalunge
						Road, Baner,<br /> Pune: 411045, Maharashtra, India.<br /> <strong>Contact</strong>:
						+ 91 020 65007681 / 020 65007680 , <strong>Email</strong>:
						fees@theorchidschool.org
					</td>
				</tr>
			</table>
		</div>
		<div id="title"
			style="width: 100%; border-bottom: 1px solid #999; border-top: 1px solid #999; padding: 5px;">
			<table width="100%" border="0" cellspacing="0">
				<tr>
					<th scope="col" align="left"><span class="page_title"
						style="text-align: center;">
							Payment Receipt No: <?php echo $payment_data['payment_id']; ?>
						</span></th>
				</tr>
			</table>
		</div>

		<div id="container" style="width: 100%; padding: 10px;">
			<table width="100%" border="0" cellspacing="5" cellpadding="5"
				class="styleme">
				<tr>
					<td colspan="4" class="highlight"><strong>Payment Receipt Details:</strong>
					</td>
				</tr>
				<tr>
					<td width="25%">Student Name</td>
					<td width="25%">: 
			        		<?php echo $payment_data['student_firstname']." ".$payment_data['student_lastname'];?><br />
			        		<?php echo "(".$payment_data['admission_no'].")";?>
			        </td>
					<td width="25%">Installment</td>
					<td width="25%">: <?php echo $payment_data['instalment_name'];?></td>
				</tr>
				<tr>
					<td width="25%">Standard</td>
					<td width="25%">: 
			        		<?php echo $payment_data['standard_name'];?>
			        </td>
					<td width="25%">Division</td>
					<td width="25%">:
			        		<?php echo $payment_data['division_name'];?> </td>
				</tr>

				<tr>
					<td width="25%">Payment Date</td>
					<td width="25%">: <?php echo swap_date_format($payment_data['payment_date']);?></td>
					<td width="25%">Payment Mode</td>
					<td width="25%">: <?php echo $payment_data['payment_mode'];?></td>
				</tr>
				<tr>
					<td width="25%">Narration</td>
					<td width="25%">: <?php echo $payment_data['narration'];?></td>
					<td width="25%">Transaction No</td>
					<td width="25%">: <?php echo $payment_data['transaction_no'];?></td>
				</tr>
				<tr>
					<td width="25%">Instalment Amount</td>
					<td width="25%" colspan="3">: Rs. <?php echo $payment_data['payment_amount'];?></td>
				</tr>
				<tr>
					<td width="25%">Late Fees Amount</td>
					<td width="25%" colspan="3">: Rs. <?php echo $payment_data['late_fee_amount']?></td>
				</tr>
				<tr>
					<td width="25%">Total Paid</td>
					<td width="25%" colspan="3">: Rs. <?php echo $payment_data['total_paid_amount'];?></td>
				</tr>
				<tr>
					<td colspan="4" class="highlight"><strong>Particulars Items:</strong>
					</td>
				</tr>
				<tr class="blank">
					<td colspan="4" class="blank">
						<table width="100%" border="0" cellpadding="2" cellspacing="2"
							class="styleme">
							<tr>
								<td width="10%"><strong>Sr.No.</strong></td>
								<td width="60%"><strong>Particular Name</strong></td>
								<td width="30%"><strong>Sub Total</strong></td>
							</tr>
							<?php $i=1; foreach ($instalment_particulars as $row){?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $row['description'];?></td>
								<td>Rs. <?php echo $row['amount'] - ($row['amount']*$payment_data['staff_discount'] /100);?></td>
							</tr>
							<?php $i++; } ?>
							<tr>
								<td align="right" colspan="2">Total Instalment Amount</td>
								<td>
									Rs. <?php echo $payment_data['payment_amount'];?><br />
									<?php echo $payment_data['late_fee_amount']>0?"(+Late Fee: ".$payment_data['late_fee_amount'].")":"";?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="highlight">In Words:</td>
					<td class="highlight" colspan="3">: <?php echo number_to_rupees($payment_data['total_paid_amount']);?></td>
				</tr>
			</table>


			<table width="100%" border="0" cellspacing="5" cellpadding="5"
				class="">
				<tr>
					<td colspan="" class="highlight">Terms & Conditions:
						<ul style="padding-left: 20px;">
							<li>Once the instalment is paid can not be claimed for cashback.
							</li>
							<li>This receipt dictacts that you have paid the instalment
								mentioned in the receipt.</li>
							<li>The particulars of the instalment are mentioned in the
								receipt.</li>
						</ul>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td style="border: none;" height="100px" width="auto"><div>
							Thanking You <br /> <br /> Accounts, <br /> THE ORCHID SCHOOL
						</div></td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>