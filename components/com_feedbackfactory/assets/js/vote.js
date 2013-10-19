jQuery(document).ready(function ($) {
// Feedback vote click
   $(".vote").live('click', function (event) {
    event.preventDefault();
    var id = $(this).attr("id");
  
    $.post(
      route_vote,
      { feedback_id: id, format: "raw" },
      function (response) {
        switch (response.status)
        {
          case 0:
	        $("#right-button-err"+id).css("font-size", "13px").css("font-weight", "bold").css("color", "#ff0000").html(response.message);
	      break;
          case 2:
            $("#right-button-err"+id).css("font-size", "13px").css("font-weight", "bold").css("color", "#ff0000").html(response.message);
          break;

          case 1:
            $("#feedback-vote-value"+id).html(response.hits);
            $("#feedback-vote"+id).hide();
          break;
        }
    }, "json");
    return false;

  });
});
