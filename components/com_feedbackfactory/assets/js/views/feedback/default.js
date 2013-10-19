jQuery(document).ready(function ($) {
  // Ajax Loading Bar
  $("#loading-bar").ajaxStart(function(){
    $(this).show();
  });
  $("#loading-bar").ajaxStop(function(){
    $(this).hide();
  });

  // Load comments
  $.post(route_load_comments, { format: "raw" }, function (response) {
    $("#feedbackfactory-comments").html(response);
  });

  // Write comment
  $("#submit_comment").click(function () {
    var valid = true;

    // Comment
    if ($("#comment").val() == "")
    {
      valid = false;
      $("#comment_error").show();
    }
    else
    {
      $("#comment_error").hide();
    }

    // Captcha enabled ?
    if (captcha_comment || guest_captcha_comment)
    {
      // Comment
      if ($("#recaptcha_response_field").val() == "")
      {
        valid = false;
        $("#recaptcha_response_field_error span").html(txt_field_required);
        $("#recaptcha_response_field_error").show();
      }
      else
      {
        $("#recaptcha_response_field_error").hide();
      }
    }

    // Check author name
    if ($("#author_name").length)
    {
      if ($("#author_name").val() == "")
      {
        valid = false;
        $("#author_name_error").show();
      }
      else
      {
        $("#author_name_error").hide();
      }
    }

    // Check for a valid email
    if ($("#author_email").length)
    {
      var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

      if (reg.test($("#author_email").val()) == false)
      {
        valid = false;
        $("#author_email_error").show();
      }
      else
      {
        $("#author_email_error").hide();
      }
    }

    if (valid)
    {
      var link = $(this);
      link.hide();
      $("#comment-loader").show();

      $.post(route_feedback_comment, {
        recaptcha_response_field:  $("#recaptcha_response_field").val(),
        recaptcha_challenge_field: $("#recaptcha_challenge_field").val(),
        comment:      $("#comment").val(),
        feedback_id:  feedback_id,
        author_name:  $("#author_name").val(),
        author_email: $("#author_email").val()
      }, function (response) {

      	switch (response.errors)
        {
          case 1:
          $("#recaptcha_response_field_error span").html(response.message);
          $("#recaptcha_response_field_error").show();

          Recaptcha.reload();

          link.show();
          $("#comment-loader").hide();
          break;

          case 2:
          $("#write-comment").html(response.message);
          break;

          case 0:
          var height       = $("#feedbackfactory-comments").css("height");
          var targetOffset = $("#fieldset-comments").offset().top;

          $.post(route_load_comments, { format: "raw" }, function (response) {
            $("#feedbackfactory-comments").html(response);
            $('html').animate({scrollTop: targetOffset}, 'fast');
          });

          $("#write-comment").html(txt_comment_added);
          break;
         }
      }, "json");
    }

    return false;
  });
 
});