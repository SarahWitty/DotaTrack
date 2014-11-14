$(document).ready(function(){
	//alert("PlayerId " + server.playerId);
	$.ajax("matches/apiCall")
		.done(function(results){
			alert(results);
			var newMatches = JSON.parse(results);
			$("#ourtest").append("<ul>");
			for(var i = 0; i<newMatches.length; i++){
				$("#ourTest").append("<li>" + newMatches[i][0] + "</li>");
			}
			$("#ourtest").append("</ul>");
			
			
		})
		.fail(function(){
			alert("fail");
		});
});