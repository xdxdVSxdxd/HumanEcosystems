$( document ).ready(function() {
 
 $("#research").change(function(){
 	var selectedID = $("#research").val();
	var selectedName = $("#research option:selected").text();
	if(selectedID!=-1){
		// prendere le statistiche della ricerca e pubblicarle nel div: researchdetails
		$.getJSON("../API/tools-getProjectStatistics.php?w=" + selectedName , function(data){
			console.log(data);
			var desc = "";
			if(data.contents){
				desc = desc + "Contents: " + data.contents + " | ";
			}
			if(data.users){
				desc = desc + "Users: " + data.users + " | ";
			}
			if(data.geocontents){
				desc = desc + "Geographic content: " + data.geocontents + " | ";
			}
			$("#researchdetails").text(desc);
		});


		var crons = "";
		crons = crons + "*/3 * * * * /usr/bin/wget " + serverUrl + "API/getTwitter.php?w=" + selectedName + " >/dev/null 2>&1\n";
		crons = crons + "*/15 * * * * /usr/bin/wget " + serverUrl + "API/word_classifier.php?w=" + selectedName + " >/dev/null 2>&1\n";
		crons = crons + "*/42 * * * * /usr/bin/wget " + serverUrl + "API/getTwitter_from_users.php?w=" + selectedName + " >/dev/null 2>&1\n";
		crons = crons + "*/9 * * * * /usr/bin/wget " + serverUrl + "API/emotioner.php?w=" + selectedName + " >/dev/null 2>&1\n";
		crons = crons + "*/4 * * * * /usr/bin/wget " + serverUrl + "API/getInstagram.php?w=" + selectedName + " >/dev/null 2>&1\n";
		crons = crons + "*/5 * * * * /usr/bin/wget " + serverUrl + "API/relationer.php?w=" + selectedName + " >/dev/null 2>&1\n";

		$("#cronjobsdetails pre").text( crons );

	} else {
		$("#researchdetails").text("");
	}
 });
 
});
