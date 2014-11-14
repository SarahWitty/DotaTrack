$(document).ready(function(){
	//alert("PlayerId " + server.playerId);
	$.ajax("matches/apiCall/"+server["lastMatchId"])
		.done(function(results){
			console.log(results);
			var newMatches = results;
			var infoHeaders = ["matchId", "date", "result", "hero", "kills", "deaths", "assists"];
			infoHeaders.reverse();	
			newMatches.reverse();
			$.each(newMatches, function(index, item) {
				$("#loading").after("<tr>");
				$.each(infoHeaders, function(index, header)
				{
					if(header == "matchId")
					{
						$('#loading').after("<td><a href='"+ server['baseUrl'] +"/Match/index/" + item[header] + "'>" + item[header] + "</a></td>");
					}
					else
					{
						$('#loading').after("<td>" + item[header] + "</td>");
					}
				});
				$("#loading").after("</tr>");
			});

			$('#loading').remove();
		})
		.fail(function(){
			alert("fail");
		});
});
