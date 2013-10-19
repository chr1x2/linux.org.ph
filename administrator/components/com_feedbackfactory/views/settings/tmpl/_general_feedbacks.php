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

<table class="adminlist">
  
  <!-- allow_guest_write -->
  <tr class="hasTip" title="<?php echo JText::_('FEEDBACK_ALLOW_GUEST_WRITE'); ?>::<?php echo JText::_('FEEDBACK_ALLOW_GUEST_WRITE'); ?>">
    <td width="50%" class="paramlist_key">
      <span class="editlinktip">
        <label for="allow_guest_write"><?php echo JText::_('FEEDBACK_ALLOW_GUEST_WRITE'); ?></label>
      </span>
    </td>
    <td class="paramlist_value">
      <select id="allow_guest_write" name="allow_guest_write">
        <option value="0" <?php echo (!$this->feedbackSettings->allow_guest_write) ? 'selected="selected"' : ''; ?>><?php echo JText::_('No'); ?></option>
        <option value="1" <?php echo ($this->feedbackSettings->allow_guest_write) ? 'selected="selected"' : ''; ?>><?php echo JText::_('Yes'); ?></option>
      </select>
    </td>
  </tr>	

  <!-- uses the ReCapthca anti-bot service  style="color: #146295;" -->
  <!-- guest_captcha_write -->
  <tr>
  	<td colspan="2" class="paramlist_key">
  		<span class="paramlist_value writable">
  			<?php echo JText::_('FEEDBACK_WARNING'); ?><?php echo JText::_('FEEDBACK_WARNING_ENABLE_CAPTCHA'); ?>
      	</span>
  	</td>
  </tr>
  
  <tr class="hasTip" title="<?php echo JText::_('FEEDBACK_USE_RECAPTCHA_FOR_GUEST_WRITE'); ?>::<?php echo JText::_('FEEDBACK_USE_RECAPTCHA_FOR_GUEST_WRITE'); ?>">
    <td width="50%" class="paramlist_key">
    <span class="editlinktip">
        <label for="guest_captcha_write"><?php echo JText::_('FEEDBACK_USE_RECAPTCHA_FOR_GUEST_WRITE'); ?></label>
      </span>
    </td>
    <td class="paramlist_value">
      <select id="guest_captcha_write" name="guest_captcha_write">
        <option value="0" <?php echo (!$this->feedbackSettings->guest_captcha_write) ? 'selected="selected"' : ''; ?>><?php echo JText::_('No'); ?></option>
        <option value="1" <?php echo ($this->feedbackSettings->guest_captcha_write) ? 'selected="selected"' : ''; ?>><?php echo JText::_('Yes'); ?></option>
      </select>
    </td>
  </tr>
  
  <!-- enable_guest_view -->
  <tr class="hasTip" title="<?php echo JText::_('FEEDBACK_ALLOW_GUEST_READ'); ?>::<?php echo JText::_('FEEDBACK_ALLOW_GUEST_READ'); ?>">
    <td width="40%" class="paramlist_key">
      <span class="editlinktip">
        <label for="enable_guest_view"><?php echo JText::_('FEEDBACK_ALLOW_GUEST_READ'); ?></label>
      </span>
    </td>
    <td class="paramlist_value">
      <select id="enable_guest_view" name="enable_guest_view">
        <option value="0" <?php echo (!$this->feedbackSettings->enable_guest_view) ? 'selected="selected"' : ''; ?>><?php echo JText::_('No'); ?></option>
        <option value="1" <?php echo ($this->feedbackSettings->enable_guest_view) ? 'selected="selected"' : ''; ?>><?php echo JText::_('Yes'); ?></option>
      </select>
    </td>
  </tr>
  
  <!-- feedbacks_per_page -->
  <tr class="hasTip" title="<?php echo JText::_('FEEDBACK_DISPLAYED_PER_PAGE'); ?>::<?php echo JText::_('FEEDBACK_NO_DISPLAYED_PER_PAGE'); ?>">
    <td width="40%" class="paramlist_key">
      <span class="editlinktip">
        <label for="feedbacks_per_page"><?php echo JText::_('FEEDBACK_PER_PAGE'); ?></label>
      </span>
    </td>
    <td class="paramlist_value">
      <input type="text" name="feedbacks_per_page" id="feedbacks_per_page" value="<?php echo $this->feedbackSettings->feedbacks_per_page; ?>" style="width: 42px; text-align: right;" />
    </td>
  </tr>
  
  </table>
  
<script>
  jQuery(document).ready(function ($) {
       
    $("#allow_guest_write").change(function () {
	  if ( $('#allow_guest_write').val() == 1 ) {
		$("#enable_guest_view").attr('disabled', 'disabled');
		//$("#guest_captcha_write").attr('value', 1);
      }
      else
      {
        $("#enable_guest_view").removeAttr('disabled');
        $("#guest_captcha_write").attr('value', 0);
      }
    });

    $("#allow_guest_write").change();
    
  });
</script>

