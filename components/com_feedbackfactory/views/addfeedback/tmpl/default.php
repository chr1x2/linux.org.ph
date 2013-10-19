<?php 
/*------------------------------------------------------------------------
com_feedbackfactory - Feedback Factory 2.0.0
------------------------------------------------------------------------
author TheFactory
copyright Copyright (C) 2013 SKEPSIS Consult SRL. All Rights Reserved.
@license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
Websites: http://www.thefactory.ro
Technical Support: Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access'); ?>

<h1> <?php echo JText::_('COM_FEEDBACKFACTORY_ADD_FEEDBACK'); ?> </h1>

<?php $user= JFactory::getUser(); ?>

<form action="<?php echo JRoute::_('index.php'); ?>" method="POST" id="post">
	<table style="width: 100%;">
        <tr id="title-error" class="error" style="display: none;">
          <td colspan="2">&darr;&nbsp;<?php echo JText::_('COM_FEEDBACKFACTORY_TITLE_RQUIRED'); ?>&nbsp;&darr;</td>
        </tr>
        <tr id="title-exists" class="error" style="display: none;">
          <td colspan="2">&darr;&nbsp;<?php echo JText::_('FEEDBACK_TITLE_EXISTS'); ?>&nbsp;&darr;</td>
        </tr>
		<tr>
		  <td style="vertical-align: top; width: 150px;"><label for="category_id"><?php echo JText::_('COM_FEEDBACKFACTORY_TITLE'); ?>:</label></td>
          <td><input type="text" name="title" id="title" class="feedbackfactory-title" value="<?php //echo $this->feedback->title; ?>" /></td>
        </tr>
        <tr>
          <td style="vertical-align: top;"><label for="category_id"><?php echo JText::_('COM_FEEDBACKFACTORY_CATEGORY'); ?>:</label></td>
          <td>
            <select id="category_id" name="category_id">
              <option value="0" <?php echo ($this->feedback->category_id == 0) ? 'selected="selected"' : ''; ?>><?php echo JText::_('COM_FEEDBACKFACTORY_UNCATEGORIZED'); ?></option>
                <?php foreach ($this->categories as $id => $category): ?>
                  <option <?php echo ($this->feedback->category_id == $id) ? 'selected="selected"' : ''; ?> value="<?php echo $id; ?>"><?php echo $category['title']; ?></option>
          		<?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <textarea name="feedbackfactory-content" id="feedbackfactory-content" class="feedbackfactory-mceEditor" style="width: 92%; height: 460px;">
              <?php //echo $this->feedback->content; ?>
            </textarea>
          </td>
        </tr>
        
        <tr>
	      <td style="vertical-align: middle; width: 140px;"><label for="enable_comments"><?php echo JText::_('COM_FEEDBACKFACTORY_ENABLE_COMMENTS'); ?>:<label></td>
	      <td>
	          <select name="enable_comments" id="enable_comments">
	            <option value="0" <?php echo (!$this->feedback->enable_comments) ? 'selected="selected"' : ''; ?>><?php echo JText::_('COM_FEEDBACKFACTORY_NO'); ?></option>
	            <option value="1" <?php echo ($this->feedback->enable_comments) ? 'selected="selected"' : ''; ?>><?php echo JText::_('COM_FEEDBACKFACTORY_YES'); ?></option>
	          </select>
	      </td>
	    </tr>
        <?php if ($this->isCBIntegration && $this->feedbackSettings->use_cb_avatars): ?>
        <tr>
	      <td style="vertical-align: middle; width: 140px;"><label for="enable_cb_avatar"><?php echo JText::_('COM_FEEDBACKFACTORY_SHOW_CB_AVATAR'); ?>:<label></td>
	      <td>
	          <select name="enable_cb_avatar" id="enable_cb_avatar">
	            <option value="0" <?php echo (!$this->feedback->enable_cb_avatar) ? 'selected="selected"' : ''; ?>><?php echo JText::_('COM_FEEDBACKFACTORY_NO'); ?></option>
	            <option value="1" <?php echo ($this->feedback->enable_cb_avatar) ? 'selected="selected"' : ''; ?>><?php echo JText::_('COM_FEEDBACKFACTORY_YES'); ?></option>
	          </select>
	      </td>
	    </tr>
	    <?php endif; ?>
	    <!-- if captcha enabled -->        
	    <?php if ($this->user->guest && $this->feedbackSettings->allow_guest_write && $this->feedbackSettings->guest_captcha_write ): ?>
	    	 <tr><td id="recaptcha_response_field_error" colspan="2" style="color: #ff0000; display: none;">&darr;&nbsp;<span></span>&nbsp;&darr;</td></tr>
             <tr>
                <td style="vertical-align: top;"><label for="recaptcha_response_field"><?php echo JText::_('FEEDBACK_ARE_YOU_HUMAN'); ?></label></td>
                <td><?php echo $this->captcha_html; ?></td>
             </tr>
	    <?php endif; ?>  
	      
      </table>

  <div style="margin: 10px; ">
    <input type="button" value="<?php echo JText::_('COM_FEEDBACKFACTORY_SAVE_FEEDBACK'); ?>" class="save-button" />
    <input type="button" value="<?php echo JText::_('COM_FEEDBACKFACTORY_SAVE_AND_RETURN'); ?>" class="save-button return" />
    <!--CANCEL-->
    <span id="status" style="display: none;"></span>
  </div>

  <input type="hidden" name="controller" value="addfeedback" />
  <input type="hidden" name="task" value="save" />
  <input type="hidden" name="id" id="id" value="<?php echo $this->feedback->id; ?>" />
  <input type="hidden" name="status_id" id="status_id" value="<?php echo $this->none_id;?>" />
  <input type="hidden" name="Itemid" value="<?php echo $this->Itemid; ?>" />
</form>

<script>
  var root = "<?php echo JUri::root(); ?>";
</script>

<script>
  tinyMCE.init({
    mode : "textareas",
    theme : "advanced",
    width: "100%",
    editor_selector : "feedbackfactory-mceEditor",
    content_css : "<?php echo JURI::root(); ?>components/com_feedbackfactory/assets/css/tinymce_editor4.css",
    theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,undo,redo,link,unlink,separator,image,media,separator,code,blockquote,pagebreak,showtoolbar,fullscreen,separator",
    //theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    theme_advanced_buttons2 : "formatselect,fontselect,fontsizeselect,forecolor,pastetext,pasteword,removeformat,charmap,outdent,indent",
    theme_advanced_buttons3 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    // Skin options
        skin : "o2k7",
        skin_variant : "silver",

    plugins : 'inlinepopups,pagebreak,fullscreen,media,contextmenu,paste' ,
    relative_urls : false,
    remove_script_host : false,
    convert_urls : false,
    setup : function(ed) {
      // "More" tag functionality
      ed.onBeforeExecCommand.add(function(ed, cmd, ui, val, o) {
        if (cmd == "mcePageBreak")
        {
          var feedback_content = tinyMCE.activeEditor.getContent();
				  if (feedback_content.indexOf('<hr id="read-more" />') > -1)
				  {
				    alert("<?php echo JText::_('WRITEPOST_ALREADY_PAGE_BREAK'); ?>");
				  }
				  else
				  {
				    ed.focus();
            ed.selection.setContent('<hr id="read-more" />');
				  }

				  o.terminate = true;
        }
      });
      // Add the show toolbar button
     /* ed.addButton('showtoolbar', {
        title : 'Show toolbar',
        image : '<?php echo Juri::root(); ?>components/com_feedbackfactory/assets/images/arrow_down.png',
        onclick : function() {
				  // Add you own code to execute something on click
				  jQuery("#feedbackfactory-content_toolbar2").toggle();
				  jQuery("#feedbackfactory-content_showtoolbar").toggleClass("mceButtonActive");
        }
      });*/
    }
  });


  var media_loaded = false;
  var saving       = false;

  jQuery(document).ready(function ($) {

  	if($().dialog)
    {
      jQuery("#dialog").dialog({
        bgiframe: true,
        height:   600,
        width:    800,
        modal:    true,
        autoOpen: false,
        resizable: false,
        beforeclose: function(event, ui) {
          //$("#dialog").html("");
        }
      });
    }
    else
    {
      $("#dialog").append("<h1>jQuery UI library is missing or not loaded! This page cannot be displayed properly!</h1>");
    }

	  // Save button
    $(".save-button").click(function () {

      var and_return = $(this).hasClass("return");

      // Validate
      if ($("#title").val() == "")
      {
        $("#title").addClass("feedbackfactory-error");
        $("#title-error").show();

        return false;
      }
      else
      {
        $("#title").removeClass("feedbackfactory-error");
        $("#title-error").hide();
      }
  
      tinyMCE.triggerSave();
      
      $("#status").html("<span class='feedbackfactory-icon feedbackfactory-loader'>Saving feedback...</span>").show();
      $(".save-button").hide();
      
      $.post("<?php echo JRoute::_('index.php?option=com_feedbackfactory&controller=addfeedback&task=save', false); ?>", {
        title:            $("#title").val(),
        category_id:      $("#category_id").val(),
        enable_comments:  $("#enable_comments").val(),
        enable_cb_avatar: $("#enable_cb_avatar").val(),
        feedback_content:          $("#feedbackfactory-content").val(),
        recaptcha_response_field:  $("#recaptcha_response_field").val(),
        recaptcha_challenge_field: $("#recaptcha_challenge_field").val(),
        format:           "raw"
      }, function (data) {

      	$(".save-button").show();

        if (data.status_save == 0)
        {
          $("#status").html("<?php echo JText::_('FEEDBACK_ERROR_SAVE'); ?>");
        }
        else if (data.status_save == 2)
        {
          $("#title").addClass("feedbackfactory-error");
          $("#title-exists").show();
          $("#status").css("font-size", "13px").css("color", "#ff0000").html("<?php echo JText::_('FEEDBACK_TITLE_EXISTS'); ?>");
        }
        else if (data.status_save == 3)
        {
          Recaptcha.reload();
        	$("#status").css("font-size", "13px").css("color", "#ff0000").html("<?php echo JText::_('FEEDBACK_ERROR_INVALID_CAPTCHA'); ?>");
        	return false;
        }
        else 
        {
          $("#status").html("feedback saved! (" + data.last_saved + ")");
          $("#id").val(data.id);
          
       	  document.location.href = root + 'index.php?option=com_feedbackfactory&task=feedback&id='+data.id;
        }

        if (and_return)
        {
          document.location.href = "<?php echo JRoute::_('index.php?option=com_feedbackfactory&task=feedbacks&Itemid=' . $this->Itemid, false); ?>";
        }
      }, "json");
    });
  });
</script>
