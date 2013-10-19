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
  <!-- allow_multiple_votes -->
  <tr class="hasTip" title="<?php echo JText::_('FEEDBACK_ALLOW_MULTIPLE_VOTES'); ?>::<?php echo JText::_('FEEDBACK_ALLOW_MULTIPLE_VOTES_PER_USER'); ?>">
    <td width="40%" class="paramlist_key">
      
      <span class="editlinktip">
        <label for="allow_multiple_votes"><?php echo JText::_('FEEDBACK_ALLOW_MULTIPLE_VOTES'); ?></label>
      </span>
      
    </td>
    <td class="paramlist_value">
      <select id="allow_multiple_votes" name="allow_multiple_votes" style="margin: 6px 0 0 2px; !important">
        <option value="0" <?php echo (!$this->feedbackSettings->allow_multiple_votes) ? 'selected="selected"' : ''; ?>><?php echo JText::_('No'); ?></option>
        <option value="1" <?php echo ($this->feedbackSettings->allow_multiple_votes) ? 'selected="selected"' : ''; ?>><?php echo JText::_('Yes'); ?></option>
      </select>
      <span><?php echo JHTML::tooltip(JText::sprintf('FEEDBACK_ALLOW_MULTIPLE_VOTES_INTERVAL', JURI::root(), JURI::root()), JText::_('FEEDBACK_VOTES_INTERVAL'), '../../components/com_feedbackfactory/assets/images/help.png'); ?>  </span>
    </td>
  </tr>
  
  <!-- min_top_votes -->
  <tr>
    <td width="40%" class="paramlist_key">
      <span class="editlinktip">
        <label class="hasTip" for="min_top_votes" title="<?php echo JText::_('FEEDBACK_MIN_NO_VOTES'); ?>::<?php echo JText::_('FEEDBACK_MIN_NO_VOTES_NEEDED_FOR_TOP'); ?>"><?php echo JText::_('FEEDBACK_MIN_NO_VOTES'); ?></label>
      </span>
    </td>
    <td class="paramlist_value">
      <input type="text" name="min_top_votes" id="min_top_votes" value="<?php echo ($this->feedbackSettings->min_top_votes); ?>" size="10" style="width: 42px; text-align: right;" />
    </td>
  </tr>
 
</table>  
