<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
table td {
	font-size: 14px;
	font-family: Verdana, Geneva, sans-serif;
	line-height: 22px;
	color: #683613;
	background-color: #f2f2f2;
}
</style>
</head>
<table
	style="background: #f2f2f2; width: 100% !important; height: 100% !important; width: 100% !important; padding-top: 0; padding-bottom: 0; padding-left: 0; padding-right: 0; margin-bottom: 0; margin-left: 0; margin-right: 0; margin-top: 0"
	width="100%" cellspacing="0" height="100%" bgcolor="#f2f2f2">
	<tbody>
		<tr>
			<td valign="top" align="center">
				<table border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td>&nbsp;</td>
							<td
								style="padding-top: 30px; padding-bottom: 0px; padding-left: 10px; padding-right: 10px"
								valign="top" width="580" align="left">
								<table style="margin-bottom: 30px; padding: 0" width="100%"
									cellpadding="0" cellspacing="0">
									<tbody>
										<tr>
											<td align="center"><a href="<?php echo get_config_value("website_url");?>"
												target="_blank"><img class="CToWUd" alt="<?php echo get_config_value("website_name");?>"
													src="<?php echo images_path; ?>logo.png"
													width="250" border="0"></a></td>
											
										</tr>
									</tbody>
								</table>


								<table
									style="background: #fff; margin-bottom: 30px; padding: 0; border-radius: 3px; border-bottom: 2px solid #d8d6d1"
									width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
									<tbody>
										<tr>
											<td style="padding: 30px" valign="top">
												<h4
													style="text-align: center; padding: 0px; margin-top: 0px; margin-bottom: 0px">
													<a href="javascript:;"
														style="font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif; line-height: 42px; font-size: 32px; font-weight: 400; text-decoration: none; color: #444">
														<?php echo get_config_value("website_name"); ?> Reset password</a>
												</h4>
											</td>
										</tr>

										<tr>
											<td valign="top"><div
													style="padding: 30px; font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif; line-height: 25px; font-size: 16px; font-weight: 300; color: #444">
													Hello <?php echo $name; ?>,

													<p>
														To reset your password, click on below link or copy paste in your browser
														<a href="<?php echo $reset_link;?>"><?php echo $reset_link;?></a> 
													</p>
													
													<p>Kindly contact school authority if you have any queries</p>

													<br> Support Team,<br>
<?php echo get_config_value("website_name");?><br> 
<a href="mailto:<?php echo get_config_value("customer_care_email");?>"><?php echo get_config_value("customer_care_email");?></a> / 
<?php echo get_config_value("customer_care_contact_no");?>
												
												</div></td>
										</tr>
									</tbody>
								</table>
							</td>
							<td>&nbsp;</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
</html>