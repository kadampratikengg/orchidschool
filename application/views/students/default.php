<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">Manage Students</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><span>Students</span></li>
			</ul>

		</div>
		<!-- END PAGE HEADER-->

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption font-dark">
							<i class="icon-settings font-dark"></i> <span
								class="caption-subject bold uppercase">Students</span>
						</div>
						<div class="actions">
							<a href="<?php echo base_url('students/add');?>"
								class="btn btn-transparent green-meadow btn-outline btn-circle btn-sm active">
								Add New </a> <a
								href="<?php echo base_url('students/bulkupload');?>"
								class="btn btn-transparent yellow-gold btn-outline btn-circle btn-sm active">
								Bulk Upload </a>
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
              			<div class="row">
							<div class="col-md-12">
								<form class="form-inline" method="get"
									action="<?php echo base_url("students/index/");?>">
									<div class="form-group">
										<select class="form-control" id="division_id"
											name="division_id">
											<option value="">Select Division</option>
											<?php foreach ( $divisions as $row ) :?>
													<option value="<?php echo $row['division_id'];?>"
												<?php echo set_select ( "division_id", $row ['division_id'], $row ['division_id'] == $division_id ? true : false );?>>
														<?php echo $row['standard_name'].' - '. $row['division_name'];?>
								                    </option>
								                  	<?php
											endforeach
											;
											?>
											</select>
									</div>
									<button type="submit" class="btn blue">Show Students</button>
									<hr>
								</form>
							</div>
						</div>
						<table
							class="table table-striped table-bordered table-hover table-checkable order-column"
							id="managed_datatable">
							<thead>
								<tr>
									<th>Sr.No.</th>
									<th>Name</th>
									<th>Division</th>
									<th>Parent Email</th>
									<th>Parent Contact</th>
									<th>Status</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
						            <?php
										$i = 1;
										foreach ( $student_data as $row ) {
									?>
								<tr class="odd gradeX">
									<td><?php echo $i; $i++;?></td>
									<td>
										<a href="<?php echo base_url('students/view').'/'.$row['student_id']; ?>">
											<?php echo $row["student_firstname"].' '.$row["student_lastname"]; ?>
										</a><br />
				                        <?php echo "<span class='text-muted'>(".$row["admission_no"].")</span>";?>
				                    </td>
									<td>
				                        <?php echo $row["standard_name"].'-'.$row["division_name"]; ?>
				                    </td>
									<td>
				                        <?php echo $row["parent_email_id"]; ?>
				                    </td>
									<td>
				                        <?php echo $row["parent_mobile_no"]; ?>
				                    </td>
									<td>
										<span class="<?php echo $row['status'] == "ACTIVE" ? "font-green-seagreen":"font-red-thunderbird"?>"><?php echo $row["status"]; ?></span>
											<br/><br/>
										<span class="font-red-thunderbird"><?php echo $row['rte_provision'] == 'YES'?'RTE':'';?></span>
									</td>
									<td>
				                   		<?php if($row['status'] == "ACTIVE")	$status = "Inactive";	else $status = "Active";?>
						                   		
										<a href="<?php echo base_url('students/view').'/'.$row['student_id']; ?>"
											class="btn default btn-xs blue-sharp-stripe"> 
											View </a> 
										<a href="<?php echo base_url('students/edit/'.$row['student_id']);?>"
											class="btn default btn-xs yellow-gold-stripe"> 
											Edit </a> 
										<a href="<?php echo base_url('students/delete/'.$row['student_id'].'/'.$row['division_id']);?>"
											class="btn default btn-xs red-soft-stripe" onclick="if(!confirm('Are you sure to delete ? All student related details will be deleted.')) return false;">
											Delete </a>
										
											<?php if($row['status']=="ACTIVE" || $row['status']=="RTE"){?>
												<a href="<?php echo base_url('students/withdraw_admission/'.$row['student_id'].'/'.$row['status'].'/'.$row['division_id']); ?>"
													 class="btn default btn-xs grey-mint-stripe" onclick="if(!confirm('Are you sure, you want to withdraw admission?')) return false;">
													Withdraw Student</a>
											
											<?php }else{?>
													<a href="<?php echo base_url('students/change_status_active'.'/'.$row['student_id'].'/'.$row['status'].'/'.$row['division_id']); ?>"
														class="btn default btn-xs grey-mint-stripe" onclick="if(!confirm('Are you sure, you want to make student as Active?')) return false;"> 
														<?php echo $status; ?> </a>
											<?php }?>
												
										<a href="javascript:;" onclick="show_modal('<?php echo base_url('students/reset_password/'.$row['student_id']);?>');"
											class="btn default btn-xs purple-stripe"> 
											Reset Password </a>
										<a href="javascript:;" onclick="show_modal('<?php echo base_url('students/academic_transfer_insividual/'.$row['student_id']);?>');"
											class="btn default btn-xs green-meadow-stripe" > 
											Academic Transfer </a>
									</td>
								</tr>
						                <?php }?>
						        </tbody>

						</table>
					</div>
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
			</div>
		</div>

	</div>
	<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<?php
$data ['script'] = "students.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>