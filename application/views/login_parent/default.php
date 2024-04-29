<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo assets_path; ?>global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo assets_path; ?>global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo assets_path; ?>global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo assets_path; ?>global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo assets_path; ?>global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?php echo css_path; ?>login.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class="login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="<?php echo base_url(); ?>">
                <img src="<?php echo images_path; ?>orchid-big-logo.jpg" alt="" width="400"/> </a>
                
               
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
        	
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="<?php echo base_url('login_parent/send_otp');?>" method="post">
            	
                <h3 class="form-title font-green">Sign In</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter valid email and password. </span>
                </div>
                
                <?php if($this->session->flashdata('error_message')!=''){?>
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span> <?php echo $this->session->flashdata('error_message');?></span>
                </div>
                <?php }?>
                <?php if($this->session->flashdata('success_message')!=''){?>
                <div class="alert alert-success">
                    <button class="close" data-close="alert"></button>
                    <span> <?php echo $this->session->flashdata('success_message');?></span>
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
                
                <div class="form-group">
                    
                    <label class="control-label visible-ie8 visible-ie9">Enter Mobile No.</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" 
                    placeholder="Enter your registered mobile no" name="mobile_no" maxlength="10" value="<?php echo set_value('mobile_no');?>" /> 
				</div>
                <div class="form-actions">
                    <button type="submit" class="btn green uppercase btn-xs" title="send OTP for login">Send OTP (One Time Password)</button>
                </div>
 Recommended to use <b>Chrome or Mozilla Firefox</b> <br/>
                <span class="text-muted">Payment <a href="<?php echo base_url()."downloads/payment_terms.pdf"?>" target="_blank" style="color:#555;">Terms & Conditions</a></span>

            </form 
            <!-- END LOGIN FORM -->
           
           <!--<div class="Metronic-alerts alert alert-info fade in">
							<h4 style="color:black;">
							Currently System under maintainence, Kindly use <b>Paytm</b> for payments</h4>
							<span style="color:black;">
								<b>Steps:</b><br/> 
								1. go to : <a href="https://paytm.com/education" target="blank">https://paytm.com/education</a><br/>
								2. Select Institute as The Orchid School<br/>
								3. Enter your child Admission No (Enrollment No)<br/>
								4. Proceed to Pay<br/><br/>
								
							</span>
                		</div>-->
                		
            
        </div>
        <div class="copyright"> Designed & Developed by <a href="http://www.angularminds.com" target="_blank">Angular Minds</a></div>
        <!--[if lt IE 9]>
<script src="<?php echo assets_path; ?>global/plugins/respond.min.js"></script>
<script src="<?php echo assets_path; ?>global/plugins/excanvas.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo assets_path; ?>global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_path; ?>global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo assets_path; ?>global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo assets_path; ?>global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo scripts_path; ?>login.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>