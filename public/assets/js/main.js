//--------------------------------------------------
// SERIESMANAGER
//--------------------------------------------------

/**
 * @version        1.1.1
 * @lastmodified   16:23 02/02/2016
 * @category       linear
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @purpose        Manages layout and ajax for front end
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


function fnAppendSerieImage(intSerieId, strSerieImageSrc, $Target){

/**
 * @version        1.0
 * @lastmodified   11:58 02/02/2016
 * @category       seriesmanager_DOM
 * @purpose        Append Serie image to DOM
 * @requires       jQuery
 * @uses           fnGetDetailedSerie
 */

	// Empties $Target
	$Target.empty();
	// Creates SerieImage
	var $SerieImage = $("<img>");
	$SerieImage.attr("src", strSerieImageSrc);
	$SerieImage.attr("width", 240);
	$SerieImage.attr("height", 354);
	$SerieImage.attr("data-serie-id", intSerieId);
	$SerieImage.addClass("serie-image");
	// Listens to events on image
	$SerieImage.on("mousedown", function(){
		// Gets intSerieId from image attribute (anonymous function doesn't accept arguments)
		var intSerieId = $(this).attr("data-serie-id");
		// Targets $Card
		var $Card = $(this).parent().parent();
		fnGetSerie(intSerieId, $Grid);
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
 * @purpose        Appends series cards
 * @input          arSeries as Array, $Target as jQuery object
 * @requires       jQuery, Bootstrap, Masonry
 */

	// Empties $Grid
	$Grid.empty();

	intLength = arSeries.length;
	for (i=0; i<intLength; i++){

		// --------------------------------------------------
		// DATA
		// --------------------------------------------------

		strSerieTitle = arSeries[i].title;

		// Build images src from $poster_id :
		var strXxs    = '._V1_UY67_CR0,0,45,67_AL_.jpg';
		var strXs     = '._V1._SY74_CR0,0,54,74_.jpg';
		var strSmall  = '._V1_UX67_CR0,0,67,98_AL_.jpg';
		var strMedium = '._V1_SY317_CR0,0,214,317_AL_.jpg';
		var strLarge  = '._V1_SX640_SY720_.jpg'; // 488 x 720

		strSerieImageSrc = arSeries[i].poster_id;
		if (!strSerieImageSrc) {
			strSerieImageSrc = strAssetUrl + 'img/chill-out.jpg';
		} else {
			strSerieImageSrc = 'http://ia.media-imdb.com/images/M/' + strSerieImageSrc + strMedium;
		};

		// Appends Serie primary key for easy acces
		intSerieId      = arSeries[i].id;
		strSerieGenre   = arSeries[i].genre;
		strSerieSummary = arSeries[i].summary;

		// Creates card to contain TV series
		var $Card = $("<div>");
		$Card.addClass("card grid-item col-sm-6 col-lg-3 thumbnail");

		// --------------------------------------------------
		// TITLE
		// --------------------------------------------------

		// Adds title
		var $SerieTitle = $("<h1>");
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
		// Adds attribute for intSerieId easy access
		$ImageBox.attr("data-serie-id", intSerieId);
		// Adds ImageBox content
		fnAppendSerieImage(intSerieId, strSerieImageSrc, $ImageBox);
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
		$ListBox.attr("data-serie-id", intSerieId);
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
		// SUMMARY
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
		$Target.masonry("appended", $Card);
	}
	// Reloads masony layout
	$Target.masonry("reloadItems");
	// Refreshes $Target layout
	$Target.masonry("layout");
}



//--------------------------------------------------
// fnAppendSerieSheet v1.0
//--------------------------------------------------


function fnAppendSerieSheet(arSerie, $Target){

/**
 * @version        1.0
 * @category       seriesmanager_DOM
 * @purpose        Appends serie details sheet
 * @requires       jQuery, Bootstrap, Masonry
 */

	// Empties $Grid
	$Target.empty();

	// --------------------------------------------------
	// SHEET
	// --------------------------------------------------

	// Creates sheet to contain TV series
	var $Sheet = $("<div>");
	$Sheet.addClass("sheet grid-item col-sm-12 col-lg-12 thumbnail");
	// Appends $Sheet to $Grid
	$Target.append($Sheet);

	// --------------------------------------------------
	// TITLE
	// --------------------------------------------------

	strSerieTitle = arSerie.title;
	// Adds title
	var $SerieTitle = $("<h1>");
	// Adds title content
	$SerieTitle.html(strSerieTitle);
	$SerieTitle.addClass("serie-title sheet-item col-sm-12 col-lg-12");
	// Append title to sheet
	$Sheet.append($SerieTitle);

	// --------------------------------------------------
	// IMAGE CONTAINER
	// --------------------------------------------------

	// Appends Serie primary key for easy acces
	intSerieId      = arSerie.id;
	// Adds ImageContainer
	var $ImageContainer = $("<div>");
	// Adds class to ImageContainer
	$ImageContainer.addClass("image-box sheet-item");
	// Adds attribute for intSerieId easy access
	$ImageContainer.attr("data-serie-id", intSerieId);
	// Appends ImageContainer to sheet
	$Sheet.append($ImageContainer);

	// --------------------------------------------------
	// IMAGE
	// --------------------------------------------------

	// Build images src from poster_id :
	var strXxs    = '._V1_UY67_CR0,0,45,67_AL_.jpg';
	var strXs     = '._V1._SY74_CR0,0,54,74_.jpg';
	var strSmall  = '._V1_UX67_CR0,0,67,98_AL_.jpg';
	var strMedium = '._V1_SY317_CR0,0,214,317_AL_.jpg';
	var strLarge  = '._V1_SX640_SY720_.jpg';
	strSerieImageSrc = arSerie.poster_id;
	if (!strSerieImageSrc) {
		strSerieImageSrc = strAssetUrl + 'img/chill-out.jpg';
	} else {
		strSerieImageSrc = 'http://ia.media-imdb.com/images/M/' + strSerieImageSrc + strLarge;
	};

	// Adds ImageContainer content
	var $SerieImage = $("<img>");
	$SerieImage.attr("src", strSerieImageSrc);
	$SerieImage.addClass("serie-image img-responsive center-block");
	// Appends Image to ImageContainer
	$ImageContainer.append($SerieImage);

	// --------------------------------------------------
	// TEXT CONTAINER
	// --------------------------------------------------

	// Creates TextContainer
	var $TextContainer = $("<div>");
	// Adds class to TextContainer
	$TextContainer.addClass("list-box sheet-item col-sm-12 col-lg-12");
	// Adds attribute to target TextContainer easily
	$TextContainer.attr("data-serie-id", intSerieId);
	// Appends TextContainer to sheet
	$Sheet.append($TextContainer);

	// --------------------------------------------------
	// GENRE
	// --------------------------------------------------

	strSerieGenre   = arSerie.genre;
	var $Genre = $("<p>");
	// Adds class to Genre
	$Genre.addClass("genre sheet-item col-sm-12 col-lg-12 thumbnail");
	// Add content to Genre
	$Genre.html("<strong>Genre</strong> : " + strSerieGenre);
	// Appends Genre to TextContainer
	$TextContainer.append($Genre);

	// --------------------------------------------------
	// ACTORS
	// --------------------------------------------------

	strSerieActors  = arSerie.actors;
	var $Actors = $("<p>");
	// Adds class to Actors
	$Actors.addClass("actors sheet-item col-sm-12 col-lg-12 thumbnail");
	// Add content to Actors
	$Actors.html("<strong>Actors</strong> : " + strSerieActors);
	// Appends Actors to sheet
	$TextContainer.append($Actors);

	// --------------------------------------------------
	// SUMMARY
	// --------------------------------------------------

	strSerieSummary = arSerie.summary;
	var $Summary = $("<p>");
	// Adds class to Summary
	$Summary.addClass("summary sheet-item col-sm-12 col-lg-12 thumbnail");
	// Add content to Summary
	$Summary.html("<strong>Summary</strong> : " +strSerieSummary);
	// Appends Summary to sheet
	$TextContainer.append($Summary);

	// --------------------------------------------------
	// SEASONS
	// --------------------------------------------------

	// For each season
	for (i=1; i<=arSerie["season_count"]; i++){

		// Creates Season
		$Season = $("<div>");
		$Season.addClass("season sheet-item col-sm-12 col-lg-6 thumbnail");


		// Initializes strHtml
		strHtml = "";
		// Display Season number
		strHtml += '<a data-toggle="collapse" href="#collapseSeason" aria-expanded="false" aria-controls="collapseSeason">Season&nbsp;' + i +  '</a>';

		// For each episode
		strHtml += '<ul class="sheet-item collapse" id="collapseSeason">\n';
		for (var j in arSerie["seasons"][i].episodes){
			strHtml += "<li>Episode&nbsp;" + j + "&nbsp;:&nbsp;" + arSerie["seasons"][i]["episodes"][j].title + "</li>\n";
		}
		strHtml += "</ul>\n";
		$Season.html(strHtml);
		// Appends Season to DOM
		$TextContainer.append($Season);
	}
}



//--------------------------------------------------
// fnBuildSerieSeasons v1.0
//--------------------------------------------------


function fnBuildSerieSeasons(arSerie, $Target){

	// For each season
	for (i=1; i<=arSerie["season_count"]; i++){

		// Creates Season
		$Season = $("<div>");
		$Season.addClass("season sheet-item col-sm-12 col-lg-12 thumbnail dropdown");


		// Initializes strHtml
		strHtml = "";

		// Display Season number
		strHtml += '<h2>Season&nbsp;' + i +  '</h2>';

		// For each episode
		strHtml += '<ul class="sheet-item col-sm-6 col-lg-6">\n';
		for (var j in arSerie["seasons"][i].episodes){
			strHtml += "<li>Episode&nbsp;" + j + "&nbsp;:&nbsp;" + arSerie["seasons"][i]["episodes"][j].title + "</li>\n";
		}
		strHtml += "</ul>\n";
		$Season.html(strHtml);
		// Appends Season to DOM
		$Target.append($Season);
	}
}



//--------------------------------------------------
// fnGetRandomSeries v1.0
//--------------------------------------------------


function fnGetRandomSeries($Target){

/**
 * @version        1.1
 * @lastmodified   16:45 02/02/2016
 * @category       ajax
 * @purpose        Gets random series from seriesmanager with Ajax
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
	});
}



//--------------------------------------------------
// fnGetSerie v1.0
//--------------------------------------------------


function fnGetSerie(intSerieId, $Target){

/**
 * @version        1.2
 * @lastmodified   16:19 03/02/2016
 * @category       ajax
 * @purpose        Gets serie, seasons and episodes from seriesmanager API with Ajax
 * @requires       jQuery
 * @uses           fnAppendSeriesCard
 */

	$.ajax({
		"url": "http://localhost/seriesmanager/public/seriesmanagerapi",
		"type": "GET",
		"data":{
				"method"  : "getserie",
				"id"      : intSerieId,
				"api_key" : "inwexrlzidlwncjfrrahtexduwskgtvk"
		}
	})
	.done(function(response){
		var arSerie = response;
		// Appends arSerie to DOM
		fnAppendSerieSheet(arSerie, $Target);
	});
}



//--------------------------------------------------
// init v1.0
//--------------------------------------------------


function init() {

/**
 * @version        1.1.2
 * @lastmodified   21:29 02/02/2016
 * @category       init
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

	// Listens submit event on search form
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
			// Appends result to card
			fnAppendSeriesCard(response, $Grid);
		});
	});

	// Listens keyup event on search form
	$("#keyword-input").on("keyup", function(e) {
		e.preventDefault();
		var strKeyword = $("#keyword-input").val();

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



