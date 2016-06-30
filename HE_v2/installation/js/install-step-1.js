$( document ).ready(function() {
 
   $("#submit").click( function(){
   	saveData();
   } );
 
});

function saveData(){

	var dbname = $("#db-name").val();
	var dbhost = $("#db-host").val();
	var dbuser = $("#db-user").val();
	var dbpwd = $("#db-pwd").val();

	var errormessage = "";
	if(dbname==""){
		errormessage = errormessage + "Database name cannot be empty; ";
	}
	if(dbhost==""){
		errormessage = errormessage + "Database host cannot be empty; ";
	}
	if(dbuser==""){
		errormessage = errormessage + "User name cannot be empty; ";
	}
	if(dbpwd==""){
		errormessage = errormessage + "password cannot be empty; ";
	}

	if(errormessage!=""){
		alert(errormessage);
	} else{
		$("#database-data").submit();
	}

}