//--------------------------------------------------
// SERIESMANAGER
//--------------------------------------------------

/**
 * @version        1.1
 * @lastmodified   11:58 02/02/2016
 * @category       linear
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Manages cards layout and ajax for front end
 */

// Sets $Grid as global variable
$Grid = $("#grid");

// Initializes script
init();




//==================================================
// FUNCTION
//==================================================


//--------------------------------------------------
// fnAppendSerieImage v1.0
//--------------------------------------------------


function fnAppendSerieImage(strSerieId, strSerieImageSrc, $Target){

/**
 * @version        1.0
 * @lastmodified   11:58 02/02/2016
 * @category       seriesmanager_DOM
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Append Serie image to DOM
 * @input          strSerieId as String, strSerieImageSrc as String, $Target as jQuery object
 * @requires       jQuery
 * @uses           fnGetSerieSeasons
 */

	// Empties $Target
	$Target.empty();
	// Creates SerieImage
	var $SerieImage = $("<img>");
	$SerieImage.attr("src", strSerieImageSrc);
	$SerieImage.attr("width", 240);
	$SerieImage.attr("height", 354);
	$SerieImage.attr("data-serie-id", strSerieId);
	$SerieImage.addClass("serie-image");
	// Listens to events on image
	$SerieImage.on("mousedown", function(){
		// Gets strSerieId from image attribute (anonymous function doesn't accept arguments)
		var strSerieId = $(this).attr("data-serie-id");
		// Targets $Card
		var $Card = $(this).parent().parent();
		fnGetSerieSeasons(strSerieId, $Card.children(".list-box"));
	});
	// Appends SerieImage to DOM
	$Target.append($SerieImage);
}




//--------------------------------------------------
// fnAppendSeriesCard v1.0
//--------------------------------------------------


function fnAppendSeriesCard(arSeries, $Target){

/**
 * @version        1.0
 * @lastmodified   11:58 02/02/2016
 * @category       seriesmanager_DOM
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Fn append series card v 1 . 0
 * @input          arSeries as Array, $Target as jQuery object
 * @requires       jQuery, Bootstrap, Masonry
 */

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
		strSerieId      = arSeries[i].id;
		strSerieSummary = arSeries[i].summary;

		// Creates card to contain TV series
		var $Card = $("<div>");
		$Card.addClass("card grid-item col-sm-6 col-lg-3 thumbnail");

		// Adds title
		var $SerieTitle = $("<h2>");
		// Adds title content
		$SerieTitle.html(strSerieTitle);
		// Append title to card
		$Card.append($SerieTitle);

		// Adds ImageBox
		var $ImageBox = $("<div>");
		// Adds class to ImageBox
		$ImageBox.addClass("image-box");
		// Adds attribute for strSerieId easy access
		$ImageBox.attr("data-serie-id", strSerieId);
		// Adds ImageBox content
		fnAppendSerieImage(strSerieId, strSerieImageSrc, $ImageBox);
		// Appends ImageBox to card
		$Card.append($ImageBox);

		// Creates ListBox
		var $ListBox = $("<p>");
		// Add content to ListBox
		$ListBox.html(strSerieSummary);
		// Adds class to ListBox
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




//--------------------------------------------------
// fnGetRandomSeries v1.0
//--------------------------------------------------


function fnGetRandomSeries($Target){

/**
 * @version        1.0
 * @lastmodified   11:58 02/02/2016
 * @category       ajax
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Gets random series from seriesmanager with Ajax
 * @input          strSerie as String, $Target as jQuery object
 * @requires       jQuery
 * @uses           fnAppendSeriesCard
 */

	$.ajax({
		"url": "http://localhost/seriesmanager/public/seriesmanagerapi",
		"type": "POST",
		"data":{
				"method"  : "random",
				"limit"   : 20,
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




//--------------------------------------------------
// fnTest v1.0
//--------------------------------------------------


function fnTest($Target){

/**
 * @version        1.0
 * @deprecated     1.0
 * @lastmodified   11:58 02/02/2016
 * @category       ajax
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Gets random series from seriesmanager with Ajax
 * @input          strSerie as String, $Target as jQuery object
 * @requires       jQuery
 * @uses           fnAppendSeriesCard
 * @note           Caches jSon object into sessionStorage
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
					"limit"   : 20,
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




//--------------------------------------------------
// init v1.0
//--------------------------------------------------


function init() {

/**
 * @version        1.0
 * @lastmodified   11:58 02/02/2016
 * @category       init
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Initialyzes script
 * @assumes        $Grid
 * @requires       jQuery, Masonry
 * @uses           fnGetRandomSeries
 * @todo           Please wait
 */

	// Initializes masonry
	$Grid.masonry({
		itemSelector: ".grid-item",
	});

	// Loads default page
	// fnGetRandomSeries($Grid);
	fnTest($Grid);

	$("#serie-search-form").on("submit", function(e){
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


function fnGetSerieSeasons(strSerieId, $Target){

/**
 * @version           1.0b
 * @datelastmodified  02:33 06/01/2016
 * @category          ajax
 * @purpose           Gets artist albums from Last-fm with Ajax
 * @requires          jQuery
 * @uses              fnAppendAlbumSmallCovers
 * @note              Caches jSon object into sessionStorage
 * @todo              sessionStorage
 */

	// Checks if data is availlable in sessionStorage to avoid unnecessary server requests
	var jsAlbums = window.sessionStorage.getItem(strSerieId + "_albums");
	if (!!jsAlbums){
		// Appends jsAlbums to DOM
		fnAppendAlbumSmallCovers(JSON.parse(jsAlbums), $Target);
	}else{
		$.ajax({
			"url": "http://ws.audioscrobbler.com/2.0/",
			"data":{
				"method"  : "seasons",
				"id"      : strSerieId,
				"api_key" : "inwexrlzidlwncjfrrahtexduwskgtvk",
				"format"  : "json"
			}
		})
		.done(function(response){
				// Stringifys response to properly cache it into sessionStorage
				var jsAlbums = JSON.stringify(response.topalbums.album);
				// Caches resulting string into sessionStorage in order to avoid unnecessary server requests
				window.sessionStorage.setItem(strSerieId + "_albums", jsAlbums);
				// Returns response value
				var arAlbums = response.topalbums.album;
				// Appends arAlbums to DOM
				fnAppendAlbumSmallCovers(arAlbums, $Target);
		});
	}
}
