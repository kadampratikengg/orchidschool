<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
<meta charset="utf-8" />
<title>Dashboard</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link
	href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>global/plugins/font-awesome/css/font-awesome.min.css"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>global/plugins/simple-line-icons/simple-line-icons.min.css"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>global/plugins/bootstrap/css/bootstrap.min.css"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>global/plugins/uniform/css/uniform.default.css"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"
	rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGINS -->

<!-- for autocomplete -->
<link rel="stylesheet"
	href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link
	href="<?php echo assets_path; ?>global/plugins/bootstrap-daterangepicker/daterangepicker.min.css"
	rel="stylesheet" type="text/css" />
<link href="<?php echo assets_path; ?>global/plugins/morris/morris.css"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>global/plugins/fullcalendar/fullcalendar.min.css"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>global/plugins/jqvmap/jqvmap/jqvmap.css"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>global/plugins/datatables/datatables.min.css"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>global/plugins/bootstrap-daterangepicker/daterangepicker.min.css"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>global/plugins/bootstrap-summernote/summernote.css"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>global/plugins/select2/css/select2.min.css"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>global/plugins/select2/css/select2-bootstrap.min.css"
	rel="stylesheet" type="text/css" />
<!-- MY CSS -->
<link href="<?php echo css_path; ?>style.css" rel="stylesheet"
	type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="<?php echo assets_path; ?>global/css/components.min.css"
	rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo assets_path; ?>global/css/plugins.min.css"
	rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN THEME LAYOUT STYLES -->
<link
	href="<?php echo assets_path; ?>layouts/layout2/css/layout.min.css"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo assets_path; ?>layouts/layout2/css/themes/blue.min.css"
	rel="stylesheet" type="text/css" id="style_color" />
<link
	href="<?php echo assets_path; ?>layouts/layout2/css/custom.min.css"
	rel="stylesheet" type="text/css" />
<!-- END THEME LAYOUT STYLES -->
<link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->

<body
	class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
	<script> 
    	var base_url = '<?php echo base_url();?>';
   	</script>

	<!-- BEGIN HEADER -->
	<div class="page-header navbar navbar-fixed-top">
		<!-- BEGIN HEADER INNER -->
		<div class="page-header-inner ">
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<?php $account_type = $this->session->userdata('account_type'); ?>
					<a
					href="<?php echo $account_type == 'STUDENT'?base_url('student_dashboard'):base_url('dashboard')?>">
					 <img
					src="<?php echo assets_path; ?>layouts/layout2/img/nav-logo.png"
					alt="logo" class="logo-default" />
				</a>
				<div class="menu-toggler sidebar-toggler">
					<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
				</div>
			</div>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="menu-toggler responsive-toggler"
				data-toggle="collapse" data-target=".navbar-collapse"> </a>
			<!-- END RESPONSIVE MENU TOGGLER -->
			<div class="page-actions">
               		<?php $account_type = $this->session->userdata('account_type'); ?>
					<a
					href="<?php echo $account_type == 'STUDENT'?base_url('student_dashboard'):base_url('dashboard')?>">
					<img
					src="<?php echo assets_path; ?>layouts/layout2/img/orchid-logo.png">
				</a>
			</div>
			<!-- BEGIN PAGE TOP -->
			<div class="page-top">

				<!-- BEGIN TOP NAVIGATION MENU -->
				<div class="top-menu">
					<form name="workspace_form"
						action="<?php echo base_url('login/change_current_academic_year');?>"
						method="post" style="display: inline;">
						<ul class="nav navbar-nav pull-right">


							<!-- BEGIN USER LOGIN DROPDOWN -->
							<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            
                            
                            
                            <?php $academic_years = $this->login_model->get_academic_years();?>
                            <li class="dropdown workspace">Academic Year: <select
								class="" id="workspace_academic_id" name="workspace_academic_id"
								onchange="this.form.submit();">
                                <?php foreach($academic_years as $year){?>
				                    <option
										value="<?php echo $year['academic_year_id'];?>"
										<?php echo $year['academic_year_id']==$this->session->userdata('current_academic_year_id')?"selected='selected'":""; ?>>
                                    <?php echo $year["from_month"]." ".$year["from_year"]." - ".$year["to_month"]." ".$year["to_year"];?>
                                    </option>
                                <?php } ?>
				                           
                            </select>
							</li>


							<li class="dropdown dropdown-user"><a href="javascript:;"
								class="dropdown-toggle" data-toggle="dropdown"
								data-hover="dropdown" data-close-others="true"> <img alt=""
									class="img-circle"
									src="<?php echo assets_path; ?>layouts/layout2/img/avatar.png" />
									<span class="username username-hide-on-mobile"> <?php echo $this->session->userdata('first_name');?> </span>
									<i class="fa fa-angle-down"></i>
							</a>
								<ul class="dropdown-menu dropdown-menu-default">

									<!-- <li class="divider"> </li> -->
									<?php if($this->session->userdata('account_type') == "STAFF") {?>
									<li><a href="javascript:;"
										onclick="show_modal('<?php echo base_url('login/change_password');?>')">
											<i class="icon-lock"></i> Change Password
									</a></li>
									<?php }?>
									<!-- <li>
                                        <a href="page_user_lock_1.html">
                                            <i class="icon-lock"></i> Lock Screen </a>
                                    </li> -->
									<li><a href="<?php echo base_url('login/logout');?>"> <i
											class="icon-key"></i> Log Out
									</a></li>
								</ul></li>
							<!-- END USER LOGIN DROPDOWN -->

						</ul>
					</form>
				</div>
				<!-- END TOP NAVIGATION MENU -->
			</div>
			<!-- END PAGE TOP -->
		</div>
		<!-- END HEADER INNER -->
	</div>
	<!-- END HEADER -->
	<!-- BEGIN HEADER & CONTENT DIVIDER -->
	<div class="clearfix"></div>
	<!-- END HEADER & CONTENT DIVIDER -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container">
		<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar-wrapper">
			<!-- END SIDEBAR -->
			<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
			<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
			<div class="page-sidebar navbar-collapse collapse">
				<!-- BEGIN SIDEBAR MENU -->
				<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
				<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
				<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
				<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
				<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
				<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
				<ul
					class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu "
					data-keep-expanded="false" data-auto-scroll="true"
					data-slide-speed="200">
                        <?php if($this->session->userdata('account_type')=='STAFF'){?>
                        <li class="nav-item"><a
						href="<?php echo base_url('dashboard');?>"
						class="nav-link nav-toggle"> <i class="icon-home"></i> <span
							class="title">Dashboard</span> <span class="arrow"></span>
					</a></li>
					<li class="nav-item"><a href="<?php echo base_url('students');?>"
						class="nav-link nav-toggle"> <i class="icon-users"></i> <span
							class="title">Students</span> <span class="arrow"></span>
					</a>
						<ul class="sub-menu">
							<li class="nav-item "><a
								href="<?php echo base_url('students');?>" class="nav-link "> <span
									class="title">Manage Students</span>
							</a></li>
							<li class="nav-item "><a
								href="<?php echo base_url('students/add');?>" class="nav-link ">
									<span class="title">Add Student</span>
							</a></li>
							<li class="nav-item "><a
								href="<?php echo base_url('students/bulkupload');?>"
								class="nav-link "> <span class="title">Bulk Students Upload</span>
							</a></li>
							<li class="nav-item "><a
								href="<?php echo base_url('students/academic_transfer');?>"
								class="nav-link "> <span class="title">Academic Transfer</span>
							</a></li>
						</ul></li>

					<li class="nav-item  "><a
						href="<?php echo base_url('academic_fees');?>"
						class="nav-link nav-toggle"> <i class="icon-graduation"></i> <span
							class="title">Academic Fees</span> <span class="arrow"></span>
					</a>
						<ul class="sub-menu">
							<li class="nav-item "><a
								href="<?php echo base_url('academic_fees');?>" class="nav-link ">
									<span class="title">Manage Academic Fees</span>
							</a></li>
							<li class="nav-item "><a
								href="<?php echo base_url('academic_fees/bulk_challan');?>"
								class="nav-link "> <span class="title">Download Challans</span>
							</a></li>
							<li class="nav-item "><a
								href="<?php echo base_url('academic_fees/add');?>"
								class="nav-link "> <span class="title">Apply Fees</span>
							</a></li>

						</ul></li>

					<li class="nav-item  "><a href="<?php echo base_url('payments');?>"
						class="nav-link nav-toggle"> <i class="icon-wallet"></i> <span
							class="title">Payments</span> <span class="arrow"></span>
					</a>
						<ul class="sub-menu">
							<li class="nav-item "><a
								href="<?php echo base_url('payments');?>" class="nav-link "> <span
									class="title">Manage Payments</span>
							</a></li>
							<li class="nav-item "><a
								href="<?php echo base_url('payments/add');?>" class="nav-link ">
									<span class="title">Add Payment</span>
							</a></li>
							<li class="nav-item "><a
								href="<?php echo base_url('payments/bulkupload');?>"
								class="nav-link "> <span class="title">Bulk Payments Upload</span>
							</a></li>

						</ul></li>

					<!--  <li class="nav-item  ">
                            <a href="<?php echo base_url('other_fees');?>" class="nav-link nav-toggle">
                                <i class="icon-game-controller"></i>
                                <span class="title">Other Fees</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item ">
                                    <a href="<?php echo base_url('other_fees');?>" class="nav-link ">
                                        <span class="title">Manage Other Fees</span>
                                    </a>
                                </li>
                               	<li class="nav-item ">
                                    <a href="<?php echo base_url('other_fees/apply_division_fees');?>" class="nav-link ">
                                        <span class="title">Apply Fees to Division</span>
                                    </a>
                                </li>
                                	<li class="nav-item ">
                                    <a href="<?php echo base_url('other_fees/apply_student_fees');?>" class="nav-link ">
                                        <span class="title">Apply Fees to a Student</span>
                                    </a>
                                </li>
                            </ul>
                        </li> -->
                    <li class="nav-item nav-link nav-toggle"><a
						href="<?php echo base_url('reminders');?>" class="nav-link "> 
							<i class="fa fa-paper-plane-o"></i>
							<span class="title">Send Message</span>
							</a>
					</li>
					<li class="nav-item  "><a href="<?php echo base_url('reports');?>"
						class="nav-link nav-toggle"> <i class="icon-bar-chart"></i> <span
							class="title">Reports</span> <span class="arrow"></span>
					</a>
						<ul class="sub-menu">
							<li><a href="<?php echo base_url('reports/get_students');?>" class="nav-link ">
									<span class="title">Student Data</span>
							</a></li>
							<li><a href="<?php echo base_url('reports');?>" class="nav-link ">
									<span class="title">General</span>
							</a></li>
							<li class="nav-item "><a
								href="<?php echo base_url('reports_rte');?>" class="nav-link ">
									<span class="title">RTE</span>
							</a></li>
							<li class="nav-item "><a
								href="<?php echo base_url('reminders/outstanding_reports');?>"
								class="nav-link "> <span class="title">Outstanding</span>
							<li class="nav-item "><a
								href="<?php echo base_url('reminders/outstanding_reports_download');?>"
								class="nav-link "> <span class="title">Download Outstanding</span>
							</a></li>
							<li class="nav-item "><a
								href="<?php echo base_url('reports/discount_reports');?>"
								class="nav-link "> <span class="title">Staff Discount</span>
							</a></li>
							<li class="nav-item "><a
								href="<?php echo base_url('reports/receivable_reports');?>"
								class="nav-link "> <span class="title">Receivable</span>
							</a></li>
							<li class="nav-item "><a
								href="<?php echo base_url('reports/payment_received_reports');?>"
								class="nav-link "> <span class="title">Paid Report</span>
							</a></li>
						</ul></li>

					<li class="nav-item  "><a href="javascript:;"
						class="nav-link nav-toggle"> <i class="icon-settings"></i> <span
							class="title">Settings</span> <span class="arrow"></span>
					</a>
						<ul class="sub-menu">
							<li class="nav-item "><a
								href="<?php echo base_url('standards');?>" class="nav-link "> <span
									class="title">Standards</span>
							</a></li>
							<li class="nav-item "><a
								href="<?php echo base_url('divisions');?>" class="nav-link "> <span
									class="title">Divisions</span>
							</a></li>
							<li class="nav-item "><a
								href="<?php echo base_url('academic_years');?>"
								class="nav-link "> <span class="title">Academic Years</span>
							</a></li>
							<li class="nav-item "><a href="<?php echo base_url('staff');?>"
								class="nav-link "> <span class="title">Staff</span>
							</a></li>
							<li class="nav-item "><a href="<?php echo base_url('config');?>"
								class="nav-link "> <span class="title">config</span>
							</a></li>

						</ul></li>
                        
                        <?php }else{?>
                        
                    	<li class="nav-item"><a
						href="<?php echo base_url('student_dashboard');?>"
						class="nav-link nav-toggle"> <i class="icon-home"></i> <span
							class="title">My Dashboard</span> <span class="arrow"></span>
					</a></li>

					<li class="nav-item"><a
						href="<?php echo base_url('instalments');?>"
						class="nav-link nav-toggle"> <i class="icon-graduation"></i> <span
							class="title"> Instalments</span> <span class="arrow"></span>
					</a></li>
					<!--  <li class="nav-item">
                            <a href="<?php echo base_url('paid_fees');?>" class="nav-link nav-toggle">
                                <i class="icon-home"></i>
                                <span class="title">Paid Fees</span>
                                <span class="arrow"></span>
                            </a>
                        </li> -->
					<li class="nav-item"><a
						href="<?php echo base_url('student_profile');?>"
						class="nav-link nav-toggle"> <i class="icon-user"></i> <span
							class="title">My Profile</span> <span class="arrow"></span>
					</a></li>
                        <?php } ?>
                        
                       </ul>
				<!-- END SIDEBAR MENU -->
			</div>
			<!-- END SIDEBAR -->
		</div>
		<!-- END SIDEBAR -->