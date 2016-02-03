//--------------------------------------------------
// SERIESMANAGER
//--------------------------------------------------

/**
 * @version        1.1.1
 * @lastmodified   16:23 02/02/2016
 * @category       linear
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Manages cards layout and ajax for front end
 */

// Sets $Grid as global variable
$Grid = $("#grid");

// Initializes script
init();




//==================================================
// FUNCTIONS
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
 * @version        1.1
 * @lastmodified   21:00 02/02/2016
 * @category       seriesmanager_DOM
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Appends series cards
 * @input          arSeries as Array, $Target as jQuery object
 * @requires       jQuery, Bootstrap, Masonry
 */

	intLength = arSeries.length;
	for (i=0; i<intLength; i++){

		// --------------------------------------------------
		// DATA
		// --------------------------------------------------

		strSerieTitle = arSeries[i].title;

		// Build images src from $poster_id :
		var strXxs       = '._V1_UY67_CR0,0,45,67_AL_.jpg';
		var strXs        = '._V1._SY74_CR0,0,54,74_.jpg';
		var strSmall     = '._V1_UX67_CR0,0,67,98_AL_.jpg';
		var strMedium    = '._V1_SY317_CR0,0,214,317_AL_.jpg';
		var strLarge     = '._V1_SX640_SY720_.jpg';
		strSerieImageSrc = arSeries[i].poster_id;
		if (!strSerieImageSrc) {
			strSerieImageSrc = strAssetUrl + 'img/chill-out.jpg';
		} else {
			strSerieImageSrc = 'http://ia.media-imdb.com/images/M/' + strSerieImageSrc + strMedium;
		};

		// Appends Serie primary key for easy acces
		strSerieId      = arSeries[i].id;
		strSerieGenre   = arSeries[i].genre;
		strSerieSummary = arSeries[i].summary;

		// Creates card to contain TV series
		var $Card = $("<div>");
		$Card.addClass("card grid-item col-sm-6 col-lg-3 thumbnail");

		// --------------------------------------------------
		// TITLE
		// --------------------------------------------------

		// Adds title
		var $SerieTitle = $("<h2>");
		// Adds title content
		$SerieTitle.html(strSerieTitle);
		// Append title to card
		$Card.append($SerieTitle);

		// --------------------------------------------------
		// IMAGE BOX
		// --------------------------------------------------

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

		// --------------------------------------------------
		// TEXT BOX
		// --------------------------------------------------

		// Creates ListBox
		var $ListBox = $("<div>");
		// Adds class to ListBox
		$ListBox.addClass("list-box");
		// Adds attribute to target ListBox easily
		$ListBox.attr("data-serie-id", strSerieId);
		// Appends ListBox to card
		$Card.append($ListBox);

		// --------------------------------------------------
		// GENRE
		// --------------------------------------------------

		var $Genre = $("<p>");
		// Add content to Genre
		$Genre.html(strSerieGenre);
		// Appends Genre to card
		$Card.append($Genre);

		// --------------------------------------------------
		// TEXT
		// --------------------------------------------------

		var $Summary = $("<p>");
		// Add content to Summary
		$Summary.html(strSerieSummary);
		// Appends Summary to card
		$Card.append($Summary);

		// --------------------------------------------------
		// APPENDS TO DOM
		// --------------------------------------------------

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
 * @version        1.1
 * @lastmodified   16:45 02/02/2016
 * @category       ajax
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Gets random series from seriesmanager with Ajax
 * @input          strSerie as String, $Target as jQuery object
 * @requires       jQuery
 * @uses           fnAppendSeriesCard
 */

	$.ajax({
		"url": "http://localhost/seriesmanager/public/seriesmanagerapi",
		"type": "GET",
		"data":{
				"method"  : "getrandomseries",
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
// fnGetSerie v1.1
//--------------------------------------------------


function fnGetSerie(strSerieId, $Target){

/**
 * @version        1.1
 * @lastmodified   20:41 02/02/2016
 * @category       ajax
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Gets serie, seasons and episodes from seriesmanager API with Ajax
 * @input          strSerieId as Integer, $Target as jQuery object
 * @requires       jQuery
 * @uses           fnAppendSeriesCard
 */

	$.ajax({
		"url": "http://localhost/seriesmanager/public/seriesmanagerapi",
		"type": "GET",
		"data":{
				"method"  : "getserie",
				"id"      : strSerieId,
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
// init v1.1.1
//--------------------------------------------------


function init() {

/**
 * @version        1.1.2
 * @lastmodified   21:29 02/02/2016
 * @category       init
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Initialyzes script
 * @assumes        $Grid
 * @requires       jQuery, Masonry
 * @uses           fnGetRandomSeries
 * @uses           fnAppendSeriesCard
 * @todo           Please wait
 */

	// Initializes masonry
	$Grid.masonry({
		itemSelector: ".grid-item",
		gutter: 20,
	});

	// Loads random series
	fnGetRandomSeries($Grid);

	$("#serie-search-form").on("submit", function(e){
		// Prevents browser from refreshing page after form submit
		e.preventDefault();
		var keyword = $("#keyword-input").val();
		$.ajax({
			"url": "http://localhost/seriesmanager/public/seriesmanagerapi",
			"type": "GET",
			"data":{
				"method"  : "scrapeserie",
				"api_key" : "inwexrlzidlwncjfrrahtexduwskgtvk",
				"keyword" : keyword
			}
		}).done(function(response) {
			// Empties $Grid
			$Grid.empty();

			// Appends result to card
			fnAppendSeriesCard(response, $Grid);
		});
	});

	// Serie search function
	$("#keyword-input").on("keyup", function(e) {
		e.preventDefault();
		var strKeyword = $("#keyword-input").val();

		// Empties $Grid
		$Grid.empty();

		if (strKeyword.length>1) {
			$.ajax({
				"url": "http://localhost/seriesmanager/public/seriesmanagerapi",
				"type": "GET",
				"data":{
					"method"  : "searchserie",
					"api_key" : "inwexrlzidlwncjfrrahtexduwskgtvk",
					"keyword" : strKeyword
				}
			}).done(function(response) {
				// Appends result to card
				fnAppendSeriesCard(response, $Grid);
			});
		} else {
			// Loads random series
			fnGetRandomSeries($Grid);
		}
	});
}


/*Fonction burger menu*/
$("#burger-icon").on("click", function(){
	$("#burger").toggleClass("opened");
});