<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payment Receipt</title>
<style type="text/css" media="print">
	@page {
		size: auto;   /* auto is the initial value */
		margin: 5mm;  /* this affects the margin in the printer settings */
	}
</style>

<style type="text/css">

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
	table td.noborder{
		border: none !important;
	}
	table {
		cellpadding
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
		color:#333;
	}
	table.styleme td {
		background: #fff;
	}
	table.styleme td.highlight {
		background:  #ECDCD5;
	}
	table.styleme td.no_highlight {
		color: #fff;
	}
	table.styleme tr.blank td {
		background: #FFF !important;
	}
</style>
</head>

<body style="margin:0px;" onload="">
	<div id="wrapper" style="width: 800px; margin: 0px auto; border: 1px solid #000; background:#FFF; z-index:1000px;">
		<div id="header" style="height:110px;padding:10px;">
			<table width="100%">
				<tr>
					<td width="55%" align="left" valign="middle" class="noborder">
						<img src="<?php echo images_path."/logo.png"; ?>" />
					</td>
					<td width="45%" class="noborder" align="left" valign="top">
						<strong style="font-size: 18px; color: #930;">
							Orchid School
						</strong><br /><br />
						Baner - Mhalunge Road, Baner,<br />
						Pune: 411045, Maharashtra, India.<br />
						<strong>Contact</strong>: + 91 020 65007681 / 020 65007680 <br />
						<strong>Email</strong>: contactus@theorchidschool.org
					</td>
				</tr>
			</table>
		</div>
		<div id="title" style="width: 800px; border-bottom: 1px solid #999; border-top: 1px solid #999; padding: 5px; ">
			<table width="100%" border="0" cellspacing="0">
				<tr>
					<th scope="col" align="left">
						<span class="page_title" style="text-align:center;">
							Payment Receipt No: <?php echo $payment_data['payment_id']; ?>
						</span>
					</th>
				</tr>
			</table>
		</div>
		
		<div id="container" style="width: 800px; padding:10px;">
			<table width="100%" border="0" cellspacing="5" cellpadding="5" class="styleme">
				<tr>
					<td colspan="4" class="highlight">
						<strong>Payment Receipt Details:</strong>
					</td>
				</tr>
				<tr>
			        <td width="25%">Student Name</td>
			        <td width="25%">: <?php echo $payment_data['student_firstname']." ".$payment_data['student_lastname'];?></td>
					<td width="25%">Installment</td>
			        <td width="25%">: <?php echo $payment_data['instalment_name'];?></td>
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
			        <td width="25%" colspan="3">: <?php echo $payment_data['payment_amount'];?></td>
				</tr>
				<tr>
					<td width="25%">Late Fees Amount</td>
			        <td width="25%" colspan="3">: <?php echo $payment_data['late_fee_amount']?></td>
			    </tr>
			    <tr>
			        <td width="25%">Total Paid</td>
			        <td width="25%" colspan="3">: <?php echo $payment_data['total_paid_amount'];?></td>
				</tr>
				<tr>
			    	<td colspan="4" class="highlight">
			    		<strong>Particulars Items:</strong>
			    	</td>
			    </tr>
			    <tr class="blank">
					<td colspan="4" class="blank">
						<table width="100%" border="0" cellpadding="2" cellspacing="2" class="styleme">
							<tr>
								<td width="10%"><strong>Sr.No.</strong></td>
					            <td width="60%"><strong>Particular Name</strong></td>
								<td width="30%"><strong>Sub Total</strong></td>
							</tr>
							<?php $i=1; foreach ($instalment_particulars as $row){?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $row['description'];?></td>
								<td>Rs. <?php echo $row['amount'];?></td>
							</tr>
							<?php $i++; } ?>
							<tr>
								<td align="right" colspan="2">Total Instalment Amount</td>
								<td>Rs. <?php echo $payment_data['payment_amount'];?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="highlight">Net payable Cost <br />In Words:</td>
					<td class="highlight"colspan="3">: Thirty Six Thousand Five Hundred Eighty Three Rupees Only</td>
				</tr>
			</table>
			
			
			<table width="100%" cellspacing="5" cellpadding="5"  style="border: 1px solid #ccc; ">
				<tr>
					<td colspan="" class="highlight">
						Terms & Conditions:
						<ul style="padding-left: 20px;">
							<li>
								All Taxes are included in the instalment amount.
							</li>
							<li>
								Once the instalment is paid can not be claimed for cashback.
							</li>
							<li>
								This receipt dictacts that you have paid the instalment mentioned in the receipt. 
							</li>
							<li>
								The particulars of the instalment are mentioned in the receipt.  
							</li>
						</ul>
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>