// JavaScript Document

var commanFunctions = function() {

	return {

		// main function
		init : function() {

			// modal forms
			init_ajax_forms();

			// initilize tooltip
			$('[data-toggle="tooltip"]').tooltip();
			$('[data-toggle="popover"]').popover();
			
			
			

			// init datepickers
			$('.date-picker').datepicker({
				 format: 'dd/mm/yyyy'
			});

			// init datetimepickers
			$(".datetime-picker").datetimepicker();

			// init maxlength handler
			$('.maxlength-handler').maxlength({
				limitReachedClass : "label label-danger",
				alwaysShow : true,
				threshold : 5
			});

			// init summer note
			$('.summernote').summernote({
				height : 300
			});

			// close alert in modal

			$(document).delegate('.alert_close', 'click', function() {

				$(this).parent(".alert_container").hide();

			});
		}

	};

}();

function init_ajax_forms() {
	$(document).on('submit', 'form.my_ajax_form', function(e) {

		var form = $(this);

		e.preventDefault();
		e.stopPropagation();
		$.ajax({
			url : $(this).attr('action'),
			data : $(this).serialize(),
			dataType : 'json',
			method : $(this).attr('method'),
			success : function(data) {
				if (data.status == "success") {
					form[0].reset();
					form.find(".alert_container").addClass('alert-success');
					form.find(".alert_container").removeClass('alert-danger');

				} else {
					form.find(".alert_container").addClass('alert-danger');
					form.find(".alert_container").removeClass('alert-success');
				}

				form.find(".alert_contents").html(data.message);
				form.find(".alert_container").show();
			},
			error : function() {
				alert('error occured');
			},
			beforeSend : function() {
				form.find(':submit').button('loading');

			},
			complete : function() {
				form.find(':submit').button('reset');
			}

		});
	});

}

function changePassword() {
	$("#change_password_btn").prop("disabled", true);
	$("#ajax-alert-success-container").hide();
	$("#ajax-alert-danger-container").hide();

	$.ajax({
		url : base_url + 'login/update_password/',
		data : $("#change_password_form").serialize(),
		type : 'post',
		cache : false,
		dataType : "json",
		success : function(data) {
			if (data.status == "success") {
				$("#change_password_form")[0].reset();
				/*$("#ajax-alert-success-contents").html(data.message);
				$("#ajax-alert-success-container").show();
				$("#change_password_btn").prop("disabled", false);
				*/
				alert(data.message);
				window.location.assign(base_url);
				
			} else {
				$("#ajax-alert-danger-contents").html(data.message);
				$("#ajax-alert-danger-container").show();
				$("#change_password_btn").prop("disabled", false);
			}
		},
		error : function(data) {
			alert("An error occured.");
			$("#change_password_btn").prop("disabled", false);

		}
	});

}
function show_modal(ajax_url) {
	
	$.ajax({
		url : ajax_url,
		cache : false,
		dataType : "json",
		success : function(data) {
			$("#my_modal_title").html(data.title);
			$("#my_modal_body").html(data.body);
			$("#my_modal").modal("show");
		},
		error : function() {
			alert("An error occured.");
		}
	});
}