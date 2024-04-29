function read_terms(){
	if($("#terms_conditions").is(":checked")){
		return true;
	}else{
		$("#terms_container").show();
		return false;
		
	}
}