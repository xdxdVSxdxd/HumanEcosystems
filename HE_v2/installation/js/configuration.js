$( document ).ready(function() {
 
 $("#save-research").click(function(){
 	saveResearch();
 });

 $("#del-research").click(function(){
 	deleteResearch();
 });

 $("#conf-research").click(function(){
 	configureResearch();
 });

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
	} else {
		$("#researchdetails").text("");
	}
 });
 
});

function saveResearch(){
	if( $("#research-name").val()!="" && $("#research-label").val()!="" ){
		$("#research-new").submit();
	}
}

function deleteResearch(){
	var selectedID = $("#research").val();
	var selectedName = $("#research option:selected").text();
	if(selectedID!=-1){
		if(confirm("Really delete research [" +  selectedName + "]? (will also delete related data: no recovery possible!)")){
			// cancellare ricerca
			document.location = "configuration.php?cmd=del-research&id=" + selectedID + "&label=" + selectedName;
		}
	}
}

function configureResearch(){
	var selectedID = $("#research").val();
	var selectedName = $("#research option:selected").text();
	if(selectedID!=-1){
		document.location = "configuration-research.php?researchid=" + selectedID + "&researchlabel=" + selectedName;
	}	
}