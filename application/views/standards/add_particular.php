<form id="save_particular_form" class="my_ajax_form" 
	action="<?php echo base_url('standards/save_particular/'.$standard_instalment_id); ?>" method="post">
	
	<div class="Metronic-alerts alert alert-success fade in"
		id="ajax-alert-success-container" style="display: none;">
		<i class="fa-lg fa fa-check"></i> <span
			id="ajax-alert-success-contents">Hello Test</span>
	</div>


	<div class="Metronic-alerts alert alert-danger fade in"
		id="ajax-alert-danger-container" style="display: none;">
		<span id="ajax-alert-danger-contents">again</span>
	</div>

	<div class="form-group">
		<input type="text" value="<?php echo $standard_instalment_id; ?>" name="standard_instalment_id" hidden>
		<label>Description</label> <input type="text" class="form-control"
			id="description" name="description"
			placeholder="Particular Description" autocomplete="off">
	</div>
	<div class="form-group">
		<label>Amount</label> <input type="text" class="form-control"
			id="amount" name="amount" placeholder="Amount" autocomplete="off">
	</div>
	<div class="form-group">
		<label>Sequence No</label> <input type="text" class="form-control"
			id="sequence_no" name="sequence_no" placeholder="Number"
			autocomplete="off">
	</div>
	 <button id="save_particular_btn" type="button" class="btn btn-success" 
	 	data-loading-text="Processing..." onclick="save_particular()">
		Submit
	</button>
</form>