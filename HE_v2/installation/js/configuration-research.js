$( document ).ready(function() {

	$("#save-class").click(function(){
		saveClass();
	});

});

function saveClass(){

	if( $("#class-name").val()!="" && $("#class-color").val()!=""  && $("#class-words").val()!="" ){
		$("#new-class-form").submit();
	} else {
		alert("Fill in the class name, color and insert one or more words.")
	}

}
