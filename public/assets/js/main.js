//Diaporama
  $(document).ready(function() {
    $('.carousel').carousel();
  });

  
//masonry
$('.grid').masonry({
  // options
  itemSelector: '.grid-item',
  columnWidth: 150
});

// Serie search function
$("#serie-search-input").on("keyup", function() {
		var wordSearch = $("#serie-search-input").val();
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