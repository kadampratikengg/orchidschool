<?php $this->load->view('_includes/header');?>
<!-- BEGIN PAGE CONTAINER -->

<div class="page-container"> 
  <!-- BEGIN PAGE HEAD -->
  <div class="page-head">
    <div class="container"> 
      <!-- BEGIN PAGE TITLE -->
      <div class="page-title">
        <h1>Config <small>Configure various modules</small></h1>
      </div>
      <!-- END PAGE TITLE --> 
      
    </div>
  </div>
  <!-- END PAGE HEAD --> 
  <!-- BEGIN PAGE CONTENT -->
  <div class="page-content">
    <div class="container"> 
      
      <!-- BEGIN PAGE BREADCRUMB -->
      <ul class="page-breadcrumb breadcrumb">
        <li> <a href="<?php echo base_url('dashboard');?>">Home</a><i class="fa fa-circle"></i> </li>
        <li class="active"> Config</li>
      </ul>
      <!-- END PAGE BREADCRUMB --> 
      <!-- BEGIN PAGE CONTENT INNER -->
      <div class="row">
        <div class="col-md-12">
          <?php if($this->session->flashdata("admin_success")!=""){?>
          <div class="Metronic-alerts alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <i class="fa-lg fa fa-check"></i> <?php echo $this->session->flashdata("admin_success");?> </div>
          <?php }?>
          <?php if($this->session->flashdata("admin_error")!=""){?>
          <div class="Metronic-alerts alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <i class="fa-lg fa fa-warning"></i> <?php echo $this->session->flashdata("admin_error");?> </div>
          <?php }?>
          <?php if(validation_errors()!=""){?>
          <div class="Metronic-alerts alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <i class="fa-lg fa fa-warning"></i> <?php echo validation_errors();?> </div>
          <?php }?>
          <div class="tabbable tabbable-custom tabbable-noborder">
            <ul class="nav nav-tabs">
              <li class="active"> <a data-toggle="tab" href="#General"> General</a> </li>
              <li> <a data-toggle="tab" href="#default_meta"> Default Meta Tags </a> </li>
              <li> <a data-toggle="tab" href="#payment_gateway"> Payment Gateway</a> </li>
              <li> <a data-toggle="tab" href="#sms_gateway"> SMS Gateway </a> </li>
              <li> <a data-toggle="tab" href="#shipping"> Shipping </a> </li>
            </ul>
            <div class="tab-content">
              <div id="General" class="tab-pane active">
                <div class="row">
                  <div class="col-md-12">
                    <form class="form-horizontal form-row-seperated" action="<?php echo base_url("config/save#General");?>" method="post">
                      <div class="form-body">
                        <?php
					foreach($general_config as $row)
					{
					?>
                        <div class="form-group">
                          <label class="col-md-4 control-label text-align-right"><?php echo $row["help_text"];?></label>
                          <div class="col-md-8">
                            <input type="text" class="form-control input-large" name="config[]" 
                            placeholder="" value="<?php echo set_value('config[]',$row["config_value"]);?>" >
                            <input type="hidden" name="config_id[]" value="<?php echo $row["config_id"]; ?>" />
                          </div>
                        </div>
                        <?php }?>
                        <hr>
                        <div class="form-group">
                          <label class="col-md-4 control-label"></label>
                          <div class="col-md-8">
                            <button type="submit" class="btn green btn-circle"><i class="fa fa-check"></i> Update Settings</button>
                            &nbsp;&nbsp;&nbsp;
                            <button type="reset" class="btn default btn-circle">Reset</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div id="default_meta" class="tab-pane">
                <div class="row">
                  <div class="col-md-12">
                    <form class="form-horizontal form-row-seperated" action="<?php echo base_url("config/save#default_meta");?>" method="post">
                      <div class="form-body">
                        <?php
					foreach($meta_config as $row)
					{
					?>
                        <div class="form-group">
                          <label class="col-md-4 control-label text-align-right"><?php echo $row["help_text"];?></label>
                          <div class="col-md-8">
                            <input type="text" class="form-control input-large" name="config[]" 
                            placeholder="" value="<?php echo set_value('config[]',$row["config_value"]);?>" >
                            <input type="hidden" name="config_id[]" value="<?php echo $row["config_id"]; ?>" />
                          </div>
                        </div>
                        <?php }?>
                        <hr>
                        <div class="form-group">
                          <label class="col-md-4 control-label"></label>
                          <div class="col-md-8">
                            <button type="submit" class="btn green btn-circle"><i class="fa fa-check"></i> Update Settings</button>
                            &nbsp;&nbsp;&nbsp;
                            <button type="reset" class="btn default btn-circle">Reset</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div id="payment_gateway" class="tab-pane">
                <div class="row">
                  <div class="col-md-12">
                    <form class="form-horizontal form-row-seperated" action="<?php echo base_url("config/save#payment_gateway");?>" method="post">
                      <div class="form-body">
                        <?php
					foreach($payment_config as $row)
					{
					?>
                        <div class="form-group">
                          <label class="col-md-4 control-label text-align-right"><?php echo $row["help_text"];?></label>
                          <div class="col-md-8">
                            <input type="text" class="form-control input-large" name="config[]" 
                            placeholder="" value="<?php echo set_value('config[]',$row["config_value"]);?>" >
                            <input type="hidden" name="config_id[]" value="<?php echo $row["config_id"]; ?>" />
                          </div>
                        </div>
                        <?php }?>
                        <hr>
                        <div class="form-group">
                         <label class="col-md-4 control-label"></label>
                          <div class="col-md-8">
                            <button type="submit" class="btn green btn-circle"><i class="fa fa-check"></i> Update Settings</button>
                            &nbsp;&nbsp;&nbsp;
                            <button type="reset" class="btn default btn-circle">Reset</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div id="sms_gateway" class="tab-pane">
                <div class="row">
                  <div class="col-md-12">
                    <form class="form-horizontal form-row-seperated" action="<?php echo base_url("config/save#sms_gateway");?>" method="post">
                      <div class="form-body">
                        <?php
					foreach($sms_config as $row)
					{
					?>
                        <div class="form-group">
                          <label class="col-md-4 control-label text-align-right"><?php echo $row["help_text"];?></label>
                          <div class="col-md-8">
                            <input type="text" class="form-control input-large" name="config[]" 
                            placeholder="" value="<?php echo set_value('config[]',$row["config_value"]);?>" >
                            <input type="hidden" name="config_id[]" value="<?php echo $row["config_id"]; ?>" />
                          </div>
                        </div>
                        <?php }?>
                        <hr>
                        <div class="form-group">
                         <label class="col-md-4 control-label"></label>
                          <div class="col-md-8">
                            <button type="submit" class="btn green btn-circle"><i class="fa fa-check"></i> Update Settings</button>
                            &nbsp;&nbsp;&nbsp;
                            <button type="reset" class="btn default btn-circle">Reset</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div id="shipping" class="tab-pane">
                <div class="row">
                  <div class="col-md-12">
                    <form class="form-horizontal form-row-seperated" action="<?php echo base_url("config/save#shipping");?>" method="post">
                      <div class="form-body">
                        <?php
					foreach($shipping_config as $row)
					{
					?>
                        <div class="form-group">
                          <label class="col-md-4 control-label text-align-right"><?php echo $row["help_text"];?></label>
                          <div class="col-md-8">
                            <input type="text" class="form-control input-large" name="config[]" 
                            placeholder="" value="<?php echo set_value('config[]',$row["config_value"]);?>" >
                            <input type="hidden" name="config_id[]" value="<?php echo $row["config_id"]; ?>" />
                          </div>
                        </div>
                        <?php }?>
                        <hr>
                        <div class="form-group">
                         <label class="col-md-4 control-label"></label>
                          <div class="col-md-8">
                            <button type="submit" class="btn green btn-circle"><i class="fa fa-check"></i> Update Settings</button>
                            &nbsp;&nbsp;&nbsp;
                            <button type="reset" class="btn default btn-circle">Reset</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              
              <!--end tab-pane--> 
            </div>
          </div>
        </div>
      </div>
      <!-- END PAGE CONTENT INNER --> 
    </div>
  </div>
  <!-- END PAGE CONTENT --> 
</div>
<!-- END PAGE CONTAINER -->

<?php 
$data['script']="config/default.js";
$data['initialize']="pageFunctions.init();";
$this->load->view('_includes/footer',$data);
?>
