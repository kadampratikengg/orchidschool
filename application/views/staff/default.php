<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">Manage Staff</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><a href="<?php echo base_url('staff'); ?>">Staff</a></li>
			</ul>

		</div>
		<!-- END PAGE HEADER-->

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption font-dark">
							<i class="icon-settings font-dark"></i> 
							<span class="caption-subject bold uppercase">Staff</span>
						</div>
						<div class="actions">
							<a href="<?php echo base_url('staff/add');?>"
								class="btn btn-transparent green-meadow btn-outline btn-circle btn-sm active">
								Add New </a>
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
              
							<table
							class="table table-striped table-bordered table-hover table-checkable order-column"
							id="managed_datatable">
							<thead>
								<tr>
									<th>Sr.No.</th>
									<th>Name</th>
									<th>Email</th>
									<th>Contact</th>
									<th>Gender</th>
									<th>Status</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
						            <?php 
						            $i=1;
						            foreach($staff_data as $row){?>
						                <tr class="odd gradeX">
									<td><?php echo $i; $i++;?></td>
									<td>
						                        <?php echo $row["first_name"].' '.$row["last_name"]; ?>
						                    </td>
									<td>
						                        <?php echo $row["email_id"]; ?>
						                    </td>
									<td>
						                        <?php echo $row["mobile_no"]; ?>
						                    </td>
									<td>
						                        <?php echo $row["gender"]; ?>
						                    </td>
									<td><span
										class="<?php echo $row['status'] == "ACTIVE" ? "font-green-seagreen":"font-red-thunderbird"?>"><?php echo $row["status"]; ?></span>
									</td>
									<td>
						                <?php if($row['status'] == "ACTIVE")	$status = "Inactive";	else $status = "Active";?>
						                
										<a href="javascript:;"
										onclick="show_modal('<?php echo base_url('staff/view/'.$row['staff_id']);?>');"
										class="btn default btn-xs blue-sharp-stripe"> View </a> <a
										href="<?php echo base_url('staff/edit/'.$row['staff_id']);?>"
										class="btn default btn-xs yellow-gold-stripe"> Edit </a> <a
										href="<?php echo base_url('staff/delete/'.$row['staff_id']);?>"
										class="btn default btn-xs red-soft-stripe"
										onclick="if(!confirm('Are you sure to delete?')) return false;">
											Delete </a> 
										

										<?php if($row['status']=="ACTIVE"){?>
												
										<a href="<?php echo base_url('staff/change_status/'.$row['staff_id']."/".$status); ?>" class="btn default btn-xs grey-mint-stripe" 
											onclick="if(!confirm('Are you sure, you want to make staff as Inactive?')) return false;"> <?php echo $status; ?> </a>
											
										<?php }else{?>
										
										<a href="<?php echo base_url('staff/change_status/'.$row['staff_id']."/".$status); ?>" class="btn default btn-xs grey-mint-stripe" 
											onclick="if(!confirm('Are you sure, you want to make staff as Active?')) return false;"> <?php echo $status; ?> </a>
											
										<?php }?>
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
$data['script']="staff.js";
$data['initialize']="pageFunctions.init();";
$this->load->view('_includes/footer',$data);
?>