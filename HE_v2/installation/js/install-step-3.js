$( document ).ready(function() {
 
 $("#tw-consumer-key").change(function(){
 	getBearerLink();
 });

 $("#tw-consumer-secret").change(function(){
 	getBearerLink();
 });

 $("#tw-token").change(function(){
 	getBearerLink();
 });

 $("#tw-token-secret").change(function(){
 	getBearerLink();
 });

 $("#submit").click(function(){
 	sendData();
 });
 
});

function getBearerLink(){

	var twconsumerkey = $("#tw-consumer-key").val();
	var twconsumersecret = $("#tw-consumer-secret").val();
	var twtoken = $("#tw-token").val();
	var twtokensecret = $("#tw-token-secret").val();

	var link = "";

	if(twconsumerkey!="" && twconsumersecret!="" && twtoken!="" && twtokensecret!="" ){
		link = "<a href='../API/getTwitterBearerToken.php?tw-consumer-key=" + twconsumerkey + "&tw-consumer-secret=" + twconsumersecret + "&tw-token=" + twtoken + "&tw-token-secret=" + twtokensecret + "' target='_blank'>Get Bearer Token</a>"
	}

	$("#bearer-holder").html(link);

}

function sendData(){

	var twconsumerkey = $("#tw-consumer-key").val();
	var twconsumersecret = $("#tw-consumer-secret").val();
	var twtoken = $("#tw-token").val();
	var twtokensecret = $("#tw-token-secret").val();

	if(twconsumerkey!="" && twconsumersecret!="" && twtoken!="" && twtokensecret!="" ){
		$("#social-data").submit();
	} else {
		alert("You need to at least fill in the Twitter data");
	}
}