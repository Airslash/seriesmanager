//masonry
$('.grid').masonry({
  // options
  itemSelector: '.grid-item',
  columnWidth: 150
});

// Serie search function
$("#keyword-input").on("keyup", function() {
		var wordSearch = $("#keyword-input").val();
		if (wordSearch.length>=3) {
			$.ajax({
				"url": $("#serie-search-form").attr("action"),
				"type": $("#serie-search-form").attr("method"),
				"data": $("#serie-search-form").serialize()
			}).done(function(response) {
				$("#result-search").html(response);
			});
		} else {
			$("#result-search").empty();
		}
	});

function randomSeries(arSeries, $Target){

	intLength = arSeries.length;
	for (i=0; i<intLength; i++){

		strSerieTitle =     arSeries[i].title;
		strSerieImageSrc = 	arSeries[i].poster_id;
		strSerieId =       	arSeries[i].id;
		strSerieSummary = 	arSeries[i].summary;

		var $Card = $("<div>");
		$Card.addClass("card grid-item col-sm-6 col-lg-4 thumbnail");

		var $serieTitle = $("<h1>");

		var $ImageBox = $("<div>");
		$ImageBox.addClass("image-box");
		
		// Adds attribute for strArtistId easy access
		$ImageBox.attr("data-artist-id", strArtistId);
		// Appends box to card
		$Card.append($ImageBox);
		fnAppendArtistImage(strArtistId, strArtistImageSrc, $ImageBox);
		// Creates card ListBox
		var $ListBox = $("<div>");
		$ListBox.addClass("list-box");
		// Adds attribute to target ListBox easily
		$ListBox.attr("data-artist-id", strArtistId);
		// Appends ListBox to card
		$Card.append($ListBox);
		// Appends $Card to $Grid
		$Target.append($Card);
		// Updates masonry
		$Target.masonry('appended', $Card);
	}
	// Reloads masony layout
	$Target.masonry("reloadItems");
	// Refreshes $Target layout
	$Target.masonry("layout");
}