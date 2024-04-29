<?php $this->load->view('_includes/header');?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->

		<h3 class="page-title">
			Manage Academic Years
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><i class="icon-home"></i> <a
					href="<?php echo base_url('dashboard'); ?>">Home</a> <i
					class="fa fa-angle-right"></i></li>
				<li><a href="<?php echo base_url('academic_years'); ?>">Academic Years</a>
					<i class="fa fa-angle-right"></i></li>
				<li><span>Edit</span></li>
			
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
								class="caption-subject bold uppercase">Edit Academic Years </span>
						</div>
						<div class="actions">
							
								<a href="<?php echo base_url('academic_years');?>"
									class="btn btn-circle default"> Back</a>

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
						<form id="add_student_form" class="horizontal-form"
							action="<?php echo base_url('academic_years/update/'.$academic_year_data['academic_year_id']);?>" method="post">
							<div class="form-body">
								<h3 class="form-section">Academic Years Details</h3>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">From Month</label>
											<select id="from_month" name="from_month" class="form-control">
											<option value="">Select</option>
                                            <?php
                                             foreach($month as $row)
                                             {
                                               if( strcmp ( $row, $academic_year_data['from_month'] ) == 0 )  { ?>
                                                 <option value="<?php echo $row;?>" <?php echo set_select('from_month',$row, true);?>><?php echo $row;?></option>
                                                 <?php } else { ?>
                                                  <option value="<?php echo $row;?>" <?php echo set_select('from_month',$row);?>><?php echo $row;?></option>
                                                <?php
                                                }
                                              }
                                             
                                              ?>
											</select>
											 
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">From Year</label>
											<select id="from_year" name="from_year" class="form-control" onchange="get_year(this.value);">
                                            <option value="">Select</option>
	                                            <?php
												 foreach($from_year as $row) {
												 	
												 	if(strcmp($academic_year_data['from_year'], $row) == 0){?>
	                                               	<option value="<?php echo $row; ?>"<?php echo set_select('from_year', $row, TRUE);?>> <?php echo $row;?> </option>
	                                              	<?php }else { ?>
	                                               	<option value="<?php echo $row; ?>"<?php echo set_select('from_year', $row);?>> <?php echo $row;?> </option>
	                                              	<?php 
												 	}
												 } ?>
                                         </select>
										</div>
									</div>
									
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
										<div class="form-group">
											<label class="control-label">To Month</label>
											<select id="to_month" name="to_month" class="form-control">
											   <option value="">Select</option>
                                              <?php
                                             foreach($month as $row)
                                             {
                                               if( strcmp ( $row, $academic_year_data['to_month'] ) == 0 )  { ?>
                                                 <option value="<?php echo $row;?>" <?php echo set_select('to_month',$row, true);?>><?php echo $row;?></option>
                                                 <?php } else { ?>
                                                  <option value="<?php echo $row;?>" <?php echo set_select('to_month',$row);?>><?php echo $row;?></option>
                                                <?php
                                                }
                                              }
                                             
                                              ?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">To Year</label> 
											<select id="to_year" name="to_year" class="form-control">
												<option value="<?php echo $academic_year_data['to_year'];?>"><?php echo $academic_year_data['to_year'];?></option>
											</select>
										</div>
									</div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Current Year</label> 
											<select name=current_year class="form-control">
											      <option value="Yes" <?php set_select('current_year');?>
											      	<?php echo $academic_year_data['current_academic_year']=='YES'?'selected':''?>>Yes</option>
											      <option value="No" <?php set_select('current_year');?>
											      	<?php echo $academic_year_data['current_academic_year']=='NO'?'selected':''?>>No</option>
											</select>
											
										</div>
									</div>
                                 </div>
							</div>
							<div class="form-actions right">
								<button type="submit" class="btn green-meadow">
									<i class="fa fa-check"></i> Save
								</button>
								<a href="<?php echo base_url('academic_years')?>" class="btn default">Cancel</a>
							</div>
						</form>
					</div>
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
			</div>
		</div>

	</div>
	<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<script>

	var base_url = "<?php echo base_url(); ?>";
	
	/* function get_year(year) 
	{
		//alert('hi');
		$.ajax({

			data: {"year" : year},
			url: base_url+'academic_years/get_toyear',
	        success: function(response)
	        {
	            $('#to_year').html(response);
	        }
		});
    }
    
	function check_year(year) 
	{
		//alert('hi');
		$.ajax({

			data: {"year" : year},
			url: base_url+'academic_years/get_check_year',
	        success: function(response)
	        {
	            $('#new_current').html(response);
	        }
		});
    }
    	
	function get_current_year(res) 
	{
		alert('hi');
		$.ajax({

			data: {"res" : res},
			url: base_url+'academic_years/get_rdcurrent_year',
	        success: function(response)
	        {
	            $('#new_current').html(response);
	        }
		});
    } */
	
</script>
<?php
$data ['script'] = "academic_years.js";
$data ['initialize'] = "pageFunctions.init();";
$this->load->view ( '_includes/footer', $data );
?>
