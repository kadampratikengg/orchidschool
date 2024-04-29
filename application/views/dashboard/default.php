<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<style>
	.dashboard-stat .details .number {
    padding-top: 25px;
    text-align: right;
    font-size: 20px;
    line-height: 36px;
    letter-spacing: -1px;
    margin-bottom: 0;
    font-weight: 300;
}
</style>
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->
		<h3 class="page-title">
			Dashboard
			<!--  span class="pull-right"> <i class="fa fa-graduation-cap"></i>
				Total Students: <?php echo $total_students['total']; ?>
			</span -->
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a href="<?php echo base_url();?>">Home</a>
					<i class="fa fa-angle-right"></i></li>
				<li><span>Dashboard</span></li>
			</ul>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN DASHBOARD STATS 1-->
        <?php if($this->session->flashdata("success_message")!=""){?>
            <div class="Metronic-alerts alert alert-info fade in">
			<button type="button" class="close" data-dismiss="alert"
				aria-hidden="true"></button>
			<i class="fa-lg fa fa-check"></i>  <?php echo $this->session->flashdata("success_message");?>
            </div>
          <?php }?>
          <?php if($this->session->flashdata("error_message")!=""){?>
            <div class="Metronic-alerts alert alert-danger fade in">
			<button type="button" class="close" data-dismiss="alert"
				aria-hidden="true"></button>
			<i class="fa-lg fa fa-warning"></i>  <?php echo $this->session->flashdata("error_message");?>
            </div>
          <?php }?>
		<div class="row">
			<div class="col-md-12">
				<form class="form-inline" method="get"
					action="<?php echo base_url("dashboard/index/");?>">
					<div class="form-group">
						<select class="form-control" id="instalment_prefix" name="instalment_prefix">
							<option value="">All Instalments</option>
							<?php $i=1; foreach ($instalments as $row){?>
								<option value="<?php echo $row['instalment_prefix'];?>"
									<?php echo set_select ( "instalment_prefix", $row ['instalment_prefix'], $row ['instalment_prefix'] == $instalment_prefix ? true : false );?>>
										Instalment: <?php echo $i." ( ".$row['instalment_prefix']." )";?>
								</option>
							<?php $i++; }?>
						</select>
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
					<br>&nbsp;
				</form>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat red">
					<div class="visual">
						<i class="fa fa-bar-chart-o"></i>
					</div>
					<div class="details">
						<div class="number">
							<i class="fa fa-rupee"></i> <span data-counter="counterup"
								data-value="<?php echo $fees_data['invoice_amount']?>">0</span>
						</div>
						<div class="desc">Total Fees</div>
					</div>
					
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat blue">
					<div class="visual">
						<i class="fa fa-comments"></i>
					</div>
					<div class="details">
						<div class="number">
							<i class="fa fa-rupee"></i><span data-counter="counterup"
								data-value="<?php echo $fees_data['discount_amount']; ?>">0</span>
						</div>
						<div class="desc">Total Discount Given</div>
					</div>
					
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat green">
					<div class="visual">
						<i class="fa fa-shopping-cart"></i>
					</div>
					<div class="details">
						<div class="number">
							<i class="fa fa-rupee"></i> <span data-counter="counterup"
								data-value="<?php echo $fees_data['paid_amount']?>">0</span>
						</div>
						<div class="desc">Total Fees Received</div>
					</div>
					
				</div>
			</div>

			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat purple">
					<div class="visual">
						<i class="fa fa-globe"></i>
					</div>
					<div class="details">
						<div class="number">
							<i class="fa fa-rupee"></i> <span data-counter="counterup"
								data-value="<?php echo $fees_data['outstanding_amount']?>"></span>
						</div>
						<div class="desc">Total Outstanding Fees</div>
					</div>
					
				</div>
			</div>
		</div>
		<br>


		<form class="form-inline" id="search_student_from" method="post"
			action="<?php echo base_url('dashboard/student_history'); ?>">
			<div class="row">
			<div class="col-md-6">
					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-user"></i> <span
									class="caption-subject bold uppercase"> Total Students: <span class="font-red-soft" style="font-size: 20px;"><?php echo $total_students;?></span> ( RTE: <?php echo $total_rte_students;?> - <a href="<?php echo base_url("reports_rte");?>" target="_blank">View</a> )</span>
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover table-checkable order-column" id="managed_datatable">
								<thead>
									<tr>
										
										<th>Standard</th>
										<th>Division</th>
										<th>No of Students</th>
									</tr>
								</thead>
								<tbody>
						            <?php
						            $i=1;
						            foreach($divisions as $row)
						            {?>
						                <tr class="odd gradeX">
						                	
						                	<td>
						                        <?php echo $row['standard_name']; ?>
						                    </td>
						                    <td>
						                        <?php echo $row["division_name"]; ?>
						                    </td>
						                    <td>
						                        <?php echo $row["student_count"]; ?> <a href="<?php echo base_url().'students?division_id='.$row['division_id'];?>">View Details</a>
						                    </td>
						                     

						                </tr>
						                <?php }?>
						        </tbody>
								
							</table>
						</div>
					</div>
					<!-- END Portlet PORTLET-->
				</div>
				<div class="col-md-6">
					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-user"></i> <span
									class="caption-subject bold uppercase"> View Student History</span>
							</div>
						</div>
						<div class="portlet-body">
							<ul style="padding-left: 15px; margin-bottom: 20px;">
								<li>Enter first three letters of Admission Number or Student
									Name to see autocomplete</li>
								<li>Autocomplete shows only 20 top search results</li>
							</ul>
							<div class="input-group">
								<input type="text" class="form-control" name="student_name"
									id="student_name"
									placeholder="Search Student using name, admission number"
									style="width: 350px;"> <input type="hidden"
									name="search_student_id" id="search_student_id" value=""> <span
									class="input-group-btn">
									<button class="btn btn-success" type="submit">
										<i class="fa fa-arrow-right fa-fw"></i> GO
									</button>
								</span>
							</div>
						</div>
					</div>
					<!-- END Portlet PORTLET-->
				</div>
				
				
			</div>
		</form>
		<div class="clearfix"></div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->

<script>
	var base_url = "<?php echo base_url(); ?>";
</script>

<?php
$data ['script'] = "dashboard.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>    