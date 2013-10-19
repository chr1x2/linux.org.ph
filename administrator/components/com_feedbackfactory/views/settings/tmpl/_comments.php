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

<table class="adminlist table-striped">

  <!-- min_most_commented -->
  <tr>
    <td width="40%" class="paramlist_key">
      <span class="editlinktip">
        <label class="hasTip" for="min_most_commented" title="<?php echo JText::_('FEEDBACK_MIN_NO_OF_COMMENTS'); ?>::<?php echo JText::_('Minimum number of comments a feedback needs to receive to be shown in Most Commented.'); ?>"><?php echo JText::_('FEEDBACK_MIN_NO_OF_COMMENTS'); ?></label>
      </span>
    </td>
    <td class="paramlist_value">
      <input type="text" name="min_most_commented" id="min_most_commented" value="<?php echo ($this->feedbackSettings->min_most_commented); ?>" size="10" style="width: 42px; text-align: right;" />
    </td>
  </tr>


<!-- allow_guest_comments -->
  <tr class="hasTip" title="<?php echo JText::_('FEEDBACK_ALLOW_GUEST_COMMENTS'); ?>::<?php echo JText::_('FEEDBACK_ALLOW_GUEST_COMMENTS'); ?>">
    <td width="40%" class="paramlist_key">
      <span class="editlinktip">
        <label for="allow_guest_comments"><?php echo JText::_('FEEDBACK_ALLOW_GUEST_COMMENTS'); ?></label>
      </span>
    </td>
    <td class="paramlist_value">
      <select id="allow_guest_comments" name="allow_guest_comments">
        <option value="0" <?php echo (!$this->feedbackSettings->allow_guest_comments) ? 'selected="selected"' : ''; ?>><?php echo JText::_('No'); ?></option>
        <option value="1" <?php echo ($this->feedbackSettings->allow_guest_comments) ? 'selected="selected"' : ''; ?>><?php echo JText::_('Yes'); ?></option>
      </select>
    </td>
  </tr>
   
  <!-- captcha_comment -->
  <tr class="hasTip" title="<?php echo JText::_('FEEDBACK_USE_RECAPTCHA_FOR_ALL_COMMENTS'); ?>::<?php echo JText::_('FEEDBACK_USE_RECAPTCHA_FOR_ALL_COMMENTS'); ?>">
    <td width="40%" class="paramlist_key">
      <span class="editlinktip">
        <label for="captcha_comment"><?php echo JText::_('FEEDBACK_USE_RECAPTCHA_FOR_ALL_COMMENTS'); ?></label>
      </span>
    </td>
    <td class="paramlist_value">
      <select id="captcha_comment" name="captcha_comment">
        <option value="0" <?php echo (!$this->feedbackSettings->captcha_comment) ? 'selected="selected"' : ''; ?>><?php echo JText::_('No'); ?></option>
        <option value="1" <?php echo ($this->feedbackSettings->captcha_comment) ? 'selected="selected"' : ''; ?>><?php echo JText::_('Yes'); ?></option>
      </select>
    </td>
  </tr>
  
  <!-- guest_captcha_comment -->
  <tr class="hasTip" title="<?php echo JText::_('FEEDBACK_USE_RECAPTCHA_ONLY_FOR_GUEST_COMMENTS'); ?>::<?php echo JText::_('FEEDBACK_USE_RECAPTCHA_ONLY_FOR_GUEST_COMMENTS'); ?>">
    <td width="40%" class="paramlist_key">
      <span class="editlinktip">
        <label for="guest_captcha_comment"><?php echo JText::_('FEEDBACK_USE_RECAPTCHA_ONLY_FOR_GUEST_COMMENTS'); ?></label>
      </span>
    </td>
    <td class="paramlist_value">
      <select id="guest_captcha_comment" name="guest_captcha_comment">
        <option value="0" <?php echo (!$this->feedbackSettings->guest_captcha_comment) ? 'selected="selected"' : ''; ?>><?php echo JText::_('No'); ?></option>
        <option value="1" <?php echo ($this->feedbackSettings->guest_captcha_comment) ? 'selected="selected"' : ''; ?>><?php echo JText::_('Yes'); ?></option>
      </select>
    </td>
  </tr>
  
  <!-- comments_per_page -->
  <tr class="hasTip" title="<?php echo JText::_('FEEDBACKS_COMMENTS_PER_PAGE'); ?>::<?php echo JText::_('FEEDBACK_NUMBER_OF_COMMENTS_SHOWN_PER_PAGE'); ?>">
    <td width="40%" class="paramlist_key">
      <span class="editlinktip">
        <label for="comments_per_page"><?php echo JText::_('FEEDBACK_COMMENTS_PER_PAGE'); ?></label>
      </span>
    </td>
    <td class="paramlist_value">
      <input type="text" name="comments_per_page" id="comments_per_page" value="<?php echo $this->feedbackSettings->comments_per_page; ?>" style="width: 42px; text-align: right;" />
    </td>
  </tr>
  
</table>

<script>
  jQuery(document).ready(function ($) {
       
    $("#captcha_comment").change(function () {
	  if ( $('#captcha_comment').val() == 1 ) {
		$("#guest_captcha_comment").attr('disabled', 'disabled');
      }
      else
      {
        $("#guest_captcha_comment").removeAttr('disabled');
      }
    });

    $("#captcha_comment").change();
    
    
    $("#allow_guest_comments").change(function () {
	  if ( $('#allow_guest_comments').val() == 0 ) {
		$("#guest_captcha_comment").attr('disabled', 'disabled');
      }
      else
      {
        $("#guest_captcha_comment").removeAttr('disabled');
      }
    });

    $("#allow_guest_comments").change();
    
  });
</script>

