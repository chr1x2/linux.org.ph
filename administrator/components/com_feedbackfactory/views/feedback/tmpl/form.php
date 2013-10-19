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

<script>
  tinyMCE.init({
    mode : "textareas",
    theme : "advanced",
    width: "80%",
    editor_selector : "feedbackfactory-mceEditor",
    content_css : "<?php echo JURI::root(); ?>components/com_feedbackfactory/assets/css/tinymce_editor4.css",
    theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,undo,redo,link,unlink,separator,image,media,separator,code,blockquote,pagebreak,showtoolbar,fullscreen,separator",
    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    theme_advanced_buttons2 : "formatselect,fontselect,fontsizeselect,forecolor,pastetext,pasteword,removeformat,charmap,outdent,indent",
    theme_advanced_buttons3 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    // Skin options
        skin : "o2k7",
        skin_variant : "silver",

    plugins : 'inlinepopups,spellchecker,pagebreak,fullscreen,preview,media,style,contextmenu,safari,paste' ,
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
     
    }
  });
</script>

<form action="index.php" method="post" name="adminForm" id="adminForm">

<table class="adminlist" width="100%">
		<tr valign="top">
			<td>
				<fieldset>
					<legend><?php echo JText::_('FEEDBACK_FEEDBACK'); ?></legend>

					<table class="table-striped" width="100%">
						<?php if ($this->feedback->id): ?>
						  <tr>
							  <td class="key" width="10%" class="right"><label for="id"><?php echo JText::_('ID'); ?>:</label></td>
							  <td width="80%"><strong><?php echo $this->feedback->id; ?></strong></td>
						  </tr>
						<?php endif; ?>

						<!-- username -->
						<?php if ($this->feedback->id): ?>
						  <tr>
							  <td class="key" width="20%" class="right"><label for="username"><?php echo JText::_('FEEDBACK_USERNAME'); ?>:</label></td>
							  <td width="80%"><strong><?php echo $this->feedback->username; ?></strong></td>
						  </tr>
						<?php endif; ?>

						<!-- enable_comments -->
						<tr>
							<td class="key" class="right"><label for="enable_comments"><?php echo JText::_('FEEDBACK_ENABLE_COMMENTS'); ?>:</label></td>
							<td>
							  <select name="enable_comments" id="enable_comments">
							    <option value="0" <?php echo ($this->feedback->enable_comments == 0) ? 'selected="selected"' : ''; ?>><?php echo JText::_('No'); ?></option>
							    <option value="1" <?php echo ($this->feedback->enable_comments == 1) ? 'selected="selected"' : ''; ?>><?php echo JText::_('Yes'); ?></option>
							  </select>
							</td>
						</tr>

                        <!-- enable_cb_avatar -->
                        <?php if ($this->isCBIntegration && $this->feedbackSettings->use_cb_avatars): ?>
						<tr>
							<td class="key" class="right"><label for="enable_cb_avatar"><?php echo JText::_('FEEDBACK_ENABLE_AVATARS'); ?>:</label></td>
							<td>
							  <select name="enable_cb_avatar" id="enable_cb_avatar">
							    <option value="0" <?php echo ($this->feedback->enable_cb_avatar == 0) ? 'selected="selected"' : ''; ?>><?php echo JText::_('No'); ?></option>
							    <option value="1" <?php echo ($this->feedback->enable_cb_avatar == 1) ? 'selected="selected"' : ''; ?>><?php echo JText::_('Yes'); ?></option>
							  </select>
							</td>
						</tr>
                        <?php endif; ?>

						<!-- category_id -->
					    <tr>
							<td class="key" class="right"><label for="category_id"><?php echo JText::_('FEEDBACK_CATEGORY'); ?>:</label></td>
							<td>
							  <select name="category_id" id="category_id">
							      <option value="0" <?php echo ($this->feedback->category_id == 0) ? 'selected="selected"' : ''; ?>><?php echo JText::_('FEEDBACK_UNCATEGORIZED'); ?></option>
	                  			<?php foreach ($this->categories as $id => $category): ?>
	                    			<option value="<?php echo $id; ?>" <?php echo ($this->feedback->category_id == $id) ? 'selected="selected"' : ''; ?>><?php echo $category['title']; ?></option>
	                  		    <?php endforeach; ?>
							  </select>
						    </td>
						</tr>
					
						<!-- status_id -->
						  <tr>
							  <td class="key" class="right"><label for="status_id"><?php echo JText::_('FEEDBACK_STATUS'); ?>:</label></td>
							  <td>
							    <select name="status_id" id="status_id">
							      <option value="0" <?php echo ($this->feedback->status_id == 0) ? 'selected="selected"' : ''; ?>><?php echo JText::_('FEEDBACK_SET_STATUS'); ?></option>
	                  			<?php foreach ($this->statuses as $id => $status): ?>
	                    			<option  value="<?php echo $status['id']; ?>" <?php echo ($this->feedback->status_id == $status['id']) ? 'selected="selected"' : ''; ?>><?php echo $status['status']; ?></option>
	                  			<?php endforeach; ?>
							    </select>
							  </td>
						  </tr>
					
						<!-- title -->
						<tr>
							<td class="key" class="right"><label for="title"><?php echo JText::_('FEEDBACK_FEEDBACK_TITLE'); ?>:</label></td>
							<td>
							  <input name="title" id="title" value="<?php echo $this->feedback->title; ?>" style="width: 200px;" />
							</td>
						</tr>

						<!-- content -->
						<tr>
							<td class="key" class="right" style="vertical-align: top;"><label for="feedback_content"><?php echo JText::_('FEEDBACK_CONTENT'); ?>:</label></td>
							<td>
							   <!-- <textarea name="content" id="content" rows="20" cols="100" class="feedbackfactory-mceEditor" style="width: 90%; height: 400px;"><?php /*echo $this->feedback->content; */?></textarea>-->
                                 <textarea name="feedback_content" id="feedback_content" rows="20" cols="100" class="feedbackfactory-mceEditor" style="width: 90%; height: 400px;"><?php echo $this->feedback->feedback_content; ?></textarea>
							</td>
						</tr>
					</table>
				</fieldset>
			</td>
		</tr>
	</table>

  <input type="hidden" name="controller" value="feedback" />
  <input type="hidden" name="id" value="<?php echo $this->feedback->id; ?>" />
  <input type="hidden" name="option" value="com_feedbackfactory" />
  <input type="hidden" name="task" value="" />
</form>
