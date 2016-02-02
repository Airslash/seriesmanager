// Sets $Grid as global variable
$Grid = $("#grid");
// Initializes script
init();

function init() {
/**
 * @purpose   Initialyzes script
 * @assumes   $Grid
 * @requires  jQuery, Masonry
 * @uses      fnGetRandomSeries
 * @todo      Demander à Guillaume pour .serialize()
 */
	// Initializes masonry
	$Grid.masonry({
		itemSelector: ".grid-item",
	});

	// Loads default page
	// fnGetRandomSeries($Grid);
	fnTest($Grid);

	$("form").on("submit", function(e){
		// Prevents browser from refreshing page after form submit
		e.preventDefault();
		var keyword = $("#keyword-input").val();
		$.ajax({
			"url": "http://localhost/seriesmanager/public/seriesmanagerapi",
			"type": "POST",
			"data":{
				"method"  : "scrape",
				"api_key" : "inwexrlzidlwncjfrrahtexduwskgtvk",
				"keyword" : keyword
				// "keyword" : $("#serie-search-form").serialize()
			}
		}).done(function(response) {
			$Grid.empty();
			fnAppendSeriesCard(response, $Grid);
			// Empties $Grid
			// fnGetRandomSeries($Grid);
		});
	});

	// Serie search function
	$("#keyword-input").on("keyup", function(e) {
		e.preventDefault();
		var keyword = $("#keyword-input").val();
		if (keyword.length>=2) {
			$.ajax({
				"url": "http://localhost/seriesmanager/public/seriesmanagerapi",
				"type": "POST",
				"data":{
					"method"  : "search",
					"api_key" : "inwexrlzidlwncjfrrahtexduwskgtvk",
					"keyword" : keyword
					// "keyword" : $("#serie-search-form").serialize()
				}
			}).done(function(response) {
				$Grid.empty();
				fnAppendSeriesCard(response, $Grid);
			});
		} else {
			// $("#result-search").empty();
		}
	});
}

function fnAppendSeriesCard(arSeries, $Target){
	intLength = arSeries.length;
	for (i=0; i<intLength; i++){

		strSerieTitle = arSeries[i].title;

		// Build images src from $poster_id :
		var strXxs       = '._V1_UY67_CR0,0,45,67_AL_.jpg';
		var strXs        = '._V1._SY74_CR0,0,54,74_.jpg';
		var strSmall     = '._V1_UX67_CR0,0,67,98_AL_.jpg';
		var strMedium    = '._V1_SY317_CR0,0,214,317_AL_.jpg';
		var strLarge     = '._V1_SX640_SY720_.jpg';
		strSerieImageSrc = 'http://ia.media-imdb.com/images/M/' + arSeries[i].poster_id + strMedium;

		// Appends Serie primary key for easy acces
		strSerieId   = arSeries[i].id;
		SerieSummary = arSeries[i].summary;

		var $Card = $("<div>");
		$Card.addClass("card grid-item col-sm-6 col-lg-4 thumbnail");

		var $SerieTitle = $("<h1>");
		$SerieTitle.html(strSerieTitle);
		$Card.append($SerieTitle);

		var $ImageBox = $("<div>");
		$ImageBox.addClass("image-box");

		// Adds attribute for strSerieId easy access
		$ImageBox.attr("data-serie-id", strSerieId);

		// Appends box to card
		$Card.append($ImageBox);
		fnAppendSerieImage(strSerieId, strSerieImageSrc, $ImageBox);

		// Creates card ListBox
		var $ListBox = $("<div>");
		$ListBox.addClass("list-box");
		// Adds attribute to target ListBox easily
		$ListBox.attr("data-serie-id", strSerieId);
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

function fnAppendSerieImage(strSerieId, strSerieImageSrc, $Target){
/**
 * @category          seriesmanager_DOM
 * @purpose           Append Serie image to DOM
 * @input             strSerieId As String, strSerieImageSrc As String, $Target As jQuery object
 * @requires          jQuery
 * @uses              fnGetSerieAlbums
 */

	// Empties $Target
	$Target.empty();
	// Creates SerieImage
	var $SerieImage = $("<img>");
	$SerieImage.attr("src", strSerieImageSrc);
	$SerieImage.attr("width", 214);
	$SerieImage.attr("height", 317);
	$SerieImage.attr("data-serie-id", strSerieId);
	$SerieImage.addClass("serie-image");
	// Listens to events on image
	$SerieImage.on("mousedown", function(){
		// Gets strSerieId from image attribute (anonymous function doesn't accept arguments)
		var strSerieId = $(this).attr("data-serie-id");
		// Targets $Card
		var $Card = $(this).parent().parent();
		fnGetSerieAlbums(strSerieId, $Card.children(".list-box"));
	});
	// Appends SerieImage to DOM
	$Target.append($SerieImage);
}

function fnGetRandomSeries($Target){

/**
 * @purpose           Gets random series from seriesmanager with Ajax
 * @input             strSerie As String, $Target As jQuery object
 * @requires          jQuery
 * @uses              fnAppendSeriesCard
 * @note              Caches jSon object into sessionStorage
 */

	// Checks if data is availlable in sessionStorage to avoid unnecessary server requests
	var jsSeries = window.sessionStorage.getItem("Series");
	if (!!jsSeries){
		// Appends jsSeries to DOM
		fnAppendSeriesCard(JSON.parse(jsSeries), $Target);
	}else{
		$.ajax({
			"url": "http://localhost/seriesmanager/public/seriesmanagerapi",
			"type": "POST",
			"data":{
					"method"  : "random",
					"limit"   : 15,
					"api_key" : "inwexrlzidlwncjfrrahtexduwskgtvk"
			}
		})
		.done(function(response){
			// Stringifys response to properly cache it into sessionStorage
			var jsSeries = JSON.stringify(response);
			// Caches resulting string into sessionStorage in order to avoid unnecessary server requests
			window.sessionStorage.setItem("Series", jsSeries);
			// Returns response value
			var arSeries = response;
			// Appends arSeries to DOM
			fnAppendSeriesCard(arSeries, $Target);
		});
	}
}

function fnTest($Target){
/**
 * @purpose           Gets random series from seriesmanager with Ajax
 * @input             strSerie As String, $Target As jQuery object
 * @requires          jQuery
 * @uses              fnAppendSeriesCard
 * @note              Caches jSon object into sessionStorage
 */

	$.ajax({
		// "url": "http://localhost/seriesmanager/public/randomseries/15/",
		"url": "http://localhost/seriesmanager/public/seriesmanagerapi",
		// "url": "http://localhost/seriesmanager/public/test",
		"type": "POST",
		"data":{
				"method"  : "random",
				"limit"   : 15,
				"api_key" : "inwexrlzidlwncjfrrahtexduwskgtvk"
		}
	})
	.done(function(response){
		var arSeries = response;
		// Appends arSeries to DOM
		fnAppendSeriesCard(arSeries, $Target);
		// console.log(response);
	});
}