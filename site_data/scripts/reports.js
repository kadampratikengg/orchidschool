var pageFunctions = function () {
   
    return {
        //main function to initiate the module
        init: function () {
          
	  init_datatables();
	  init_select2();
			
        }
    };

}();

function get_academic_years(academic_year_id){
	$.ajax({

		data: {"academic_year_id" : academic_year_id},
		url: base_url+'reports/get_academic_years',
		method: "post",
        success: function(response)
        {
            $('#academic_year_id').html(response);
        }
	});
}



$(document).ready(function(){
	
	$('body').on('click', 'a.close_container', function() {
		$(this).parent().parent().hide();
	});
	
	
	
});
function show_standard_details(prefix){
	
	$.ajax({
		type: "POST",
		url: base_url + 'reports/get_standard_details',
		cache: false,
		data: {"prefix":prefix},
		success: function (data) {
			$("#standard_"+prefix+"_container td").html(data);	
		},
		beforeSend: function () {
			$("#standard_"+prefix+"_container").show();

		},
		complete: function () {
			//$("#instalment_"+prefix+"_container td").html("test");	
		}
	});
	
}
function get_division_details(standard_id,standard_name,standard_prefix){
	
	$.ajax({
		type: "POST",
		url: base_url + 'reports/get_division_details',
		cache: false, 
		data: {"standard_id":standard_id,"standard_name":standard_name,"prefix":standard_prefix},
		success: function (data) {
			$("#division_"+standard_id+"_container td").html(data);
		},
		beforeSend: function () {
			$("#division_"+standard_id+"_container").show();	

		},
		complete: function () {
			//$("#instalment_"+prefix+"_container td").html("test");	
		}
	});
	
}
function get_student_details(division_id, division_name,standard_prefix){
	
	$.ajax({
		type: "POST",
		url: base_url + 'reports/get_student_details',
		cache: false,
		data: {"division_id":division_id,"division_name":division_name,"prefix":standard_prefix},
		success: function (data) {
			
			$("#students_"+division_id+"_container td").html(data);	
		},
		beforeSend: function () {
			$("#students_"+division_id+"_container").show();	

		},
		complete: function () {
			//$("#instalment_"+prefix+"_container td").html("test");	
		}
	});
	
}

function get_discounted_reports() {

	$.ajax({
		data: {"standard_id" : $("#standard_id").val()},
		type: "POST",
		url: base_url+'reports/get_discounted_reports',
        success: function(response)
        {
            $('#discounts_table_container').html(response);
        }
	});
}

function get_receivable_reports() {

	$.ajax({
		data: {"standard_id" : $("#standard_id").val(), "instalment_id" : $("#instalment_id").val()},
		type: "POST",
		url: base_url+'reports/get_receivable_reports',
        success: function(response)
        {
            $('#receivable_table_container').html(response);
        }
	});
}

function get_payment_received_reports() {

	$.ajax({
		data: {"from" : $("#from").val(), "to" : $("#to").val()},
		type: "POST",
		url: base_url+'reports/get_payment_received_reports',
        success: function(response)
        {
            $('#payment_received_table_container').html(response);
        }
	});
}

function get_instalments(standard_id) {
	
	$.ajax({

		data: {"standard_id" : standard_id},
		url: base_url+'reports/get_instalments',
        success: function(response)
        {
            $('#instalment_id').html(response);
        }
	});
}

function get_standards(academic_year_id){
	
	$.ajax({
		data: {"academic_year_id" : academic_year_id},
		url: base_url+'reports/get_standards',
        success: function(response)
        {
            $('#standard_id').html(response);
        }
	});

}
function get_divisions(standard_id){
	
	$.ajax({
		data: {"standard_id" : standard_id},
		url: base_url+'reports/get_divisions',
        success: function(response)
        {
            $('#division_id').html(response);
        }
	});
}

function get_instalments(standard_id){
	
	$.ajax({
		data: {"standard_id" : standard_id},
		url: base_url+'reports/get_instalments',
        success: function(response)
        {
            $('#instalment_id').html(response);
        }
	});
}


/*
function download_report(){
	
	var academic_year_id = $("#academic_year_id").val();
	var standard_id = $("#standard_id").val();
	var division_id = $("#division_id").val();

	$.ajax({
		data: {"academic_year_id": academic_year_id,
			"standard_id" : standard_id,
			"division_id" : division_id},
		method: "POST",
		url: base_url+'reports/download_student_data',
        success: function(response){}
	});	
}
*/
