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