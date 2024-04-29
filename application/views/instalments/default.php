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
				<li><span>Instalments</span></li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption font-dark">
							<i class="icon-settings font-dark"></i> <span
								class="caption-subject bold uppercase">Instalment Details</span>
						</div>
					</div>
					<div class="portlet-body">
						<?php if($this->session->flashdata("success_message")!=""){?>
		                <div class="Metronic-alerts alert alert-info fade in">
							<button type="button" class="close" data-dismiss="alert"
								aria-hidden="true"></button>
							<i class="fa-lg fa fa-check"></i>  <?php echo $this->session->flashdata("success_message");?>
		                </div>
		              <?php }?>
		              <?php if($this->session->flashdata("error_message")!=""){?>
		                <div
							class="Metronic-alerts alert alert-danger fade in">
							<button type="button" class="close" data-dismiss="alert"
								aria-hidden="true"></button>
							<i class="fa-lg fa fa-warning"></i>  <?php echo $this->session->flashdata("error_message");?>
		                </div>
		              <?php }?>
		              
		              <?php if(validation_errors()!=""){?>
		                <div
							class="Metronic-alerts alert alert-danger fade in">
							<button type="button" class="close" data-dismiss="alert"
								aria-hidden="true"></button>
							<i class="fa-lg fa fa-warning"></i>  <?php echo validation_errors();?>
		                </div>
		              <?php }?>
		              
		              
		              
						<div class="form-body">
							<div class="row">
								<div class="col-md-12">
									<div id="terms_container" class="Metronic-alerts alert alert-danger fade in" style="display: none;">
										<!-- <h3 style="color:black;">Please read and accept terms & conditions</h3> -->
										<span style="color:black;">
											<b>Terms & Conditions</b><br/> 
											<div style="margin-left: 6px;">
												The bank charges will be applied additionally.<br/>
												1. Visa & Master card credit card 1.2% of the transaction amount + Service Tax<br/>
												2. Debit Card [RBI Rates] 0.75% of the transaction amount for transaction value less than or equal to Rs.2000 1% of the transaction amount for transaction value above Rs.2000. + Service Tax<br/>
												3. American Express Credit Card, Diners Credit Card, Cash Cards, Mobile Payments 3% of the transaction amount + Service Tax<br/>
												4. Internet Banking Rs.18 per transaction for SBI. &  Rs.15 per transaction for all other banks + Service Tax<br/><br/>
											</div>
											<label class="mt-checkbox mt-checkbox-outline" style="cursor: pointer;">
	                                            <input type="checkbox" id="terms_conditions">
	                                            <b class="alert-danger">* Please read and accept to the above terms & conditions.</b>
	                                            <span></span>
											</label>
										</span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h4 style="color: #777; font-size: 24px; margin-left: 15px;">
										Instalment Details
									</h4>
									<hr>
									<?php for($i = 0; $i<count($instalment_data); $i++){?>
									<?php if($i==4){?>
											<div class="clearfix"></div>
										<?php }?>
										<div class="col-md-3">
											<h4 class="<?php echo isset($instalment_data[$i]['payment_id'])?"font-green-meadow":"font-blue-steel"?>" 
												style="font-weight:bold;font-size:20px;">
												Installment: <?php echo $instalment_data[$i]['instalment_name'];?>
											</h4>
											<ul class="list-group">
											<li class="list-group-item">
													<strong><?php echo $this->session->userdata('first_name').' '.$this->session->userdata('last_name'); ?></strong>
												</li>
											
												<li class="list-group-item">
													<strong>
														Rs.<?php echo $instalment_data[$i]['invoice_amount'];?>
													</strong>
												</li>
												<?php if(isset($instalment_data[$i]['payment_id']) && $instalment_data[$i]['status'] =='PAYMENT-RECEIVED'){?>
	
													<li class="list-group-item">
														Paid Amount:
														<span class="pull-right">
															Rs.<?php echo $instalment_data[$i]['total_paid_amount'];?>
															<?php if($instalment_data[$i]['discount_amount']>0 || $instalment_data[$i]['late_fee_amount']>0){?>
																<a href="javascript:;" data-toggle="popover" data-trigger="hover" data-placement="top" 
																	data-html="true" title="Fees Bifurcation" 
																		data-content="<?php echo $instalment_data[$i]['discount_amount']>0?"<strong>Discount:</strong> Rs.".$instalment_data[$i]['discount_amount']."<br />":""?> 
																			<?php echo $instalment_data[$i]['late_fee_amount']>0?"<strong>Late Fees:</strong> Rs.".$instalment_data[$i]['late_fee_amount']:""?>">
																	<i class="fa fa-info-circle" style="color:#068;"></i>
																</a>
															<?php }?>
														</span>
													</li>
													<li class="list-group-item"> Pay Date: 
														<span class="pull-right">
															<?php echo date('d-M-Y',strtotime(swap_date_format($instalment_data[$i]['payment_date'])));?>
														</span> 
													</li>
													<li class="list-group-item"> 
														<a href="<?php echo base_url('instalments/download_receipt/'.$instalment_data[$i]['payment_id']); ?>" 
															class="btn green-meadow" style="font-size: 12px;"> 
															<i class="fa fa-download"></i> Download Receipt
														</a>
													</li>  
												<?php }else{?>
													<li class="list-group-item"> Start Date: 
														<span class="font-green-meadow pull-right">
															<?php echo date('d-M-Y', strtotime(swap_date_format($instalment_data[$i]['start_date'])));?>
														</span> 
													</li>
													<li class="list-group-item"> Due Date: 
														<span class="font-red-soft pull-right">
															<?php echo date('d-M-Y', strtotime(swap_date_format($instalment_data[$i]['due_date'])));?>
														</span> 
													</li>  
													<li class="list-group-item"> 
														<?php 
															$current_date =  new DateTime(date('Y-m-d'));
															$start_date = new DateTime($instalment_data[$i]['start_date']);
															$interval = $current_date->diff($start_date);
															
														?>
														<a 
															<?php if($current_date>=$start_date) { ?>
																href="<?php echo base_url('instalments/download_challan/'.$instalment_data[$i]['student_id'].'/'.$instalment_data[$i]['standard_instalment_id']);?>"
																onclick="return read_terms();"
															<?php }?> 
															class="btn blue-steel" style="font-size: 12px; width:50%;"
															<?php if($current_date<$start_date) echo "disabled = 'disabled'"; ?>> 
															<i class="fa fa-download"></i> Challan
														</a>
														<a 
															<?php if($current_date>=$start_date) { ?>
																href="<?php echo base_url('instalments/initiate_pay/'.$instalment_data[$i]['invoice_id']); ?>" 
																onclick="return read_terms();"
															<?php }?>
															class="btn green-jungle pull-right" style="font-size: 12px; width:50%;"
															<?php if($current_date<$start_date) echo "disabled = 'disabled'"; ?>> 
															<i class="fa fa-credit-card"></i> Pay Online
														</a>
													</li>
<!-- akshay -->

														<!-- li class="list-group-item">
															Pay with TP: 
																<a <?php if($current_date>=$start_date) { ?>
																href="<?php echo base_url('instalments/initiate_pay/'.$instalment_data[$i]['invoice_id']).'/tpsl'; ?>" 
																onclick="return read_terms();"
																<?php }?>
																	class="btn green-jungle btn-sm"
																	<?php if($current_date<$start_date) echo "disabled = 'disabled'"; ?>
																	><i class="fa fa-credit-card"></i> Tech Process</a>
															
														</li -->
<!-- /akshay -->

												<?php }?>
											</ul>
										</div>
									<?php }?>
								</div>
								<p style="text-align: center;">Note: Instalment Fees payment option will be available between their respective dates.</p>
							</div>
						</div>
						<div class="Metronic-alerts alert alert-info fade in">
							<!-- <h3 style="color:black;">You can also make payments from Paytm</h3>
							<span style="color:black;">
								<b>Steps:</b><br/> 
								1. go to : <a href="https://paytm.com/education" target="blank">https://paytm.com/education</a><br/>
								2. Select Institute as The Orchid School<br/>
								3. Enter your child Admission No (Enrollment No)<br/>
								4. Proceed to Pay<br/><br/>
								* Please note that payments made through Paytm will take some time to reflect it in your account
							</span> -->
							<h3 style="color:black;">Paytm payment option is removed due technical issue</h3>
                		</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<?php
$data ['script'] = "instalments.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>