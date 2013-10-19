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
  <!-- banned_words -->
  <tr class="hasTip" title="<?php echo JText::_('FEEDBACK_BANNED_WORDS'); ?>::<?php echo JText::_('FEEDBACK_BANNED_WORDS_LIST'); ?>">
    <td width="40%" class="paramlist_key" style="vertical-align: top;">
      <span class="editlinktip">
        <label for="banned_words"><?php echo JText::_('FEEDBACK_BANNED_WORDS'); ?></label>
      </span>
    </td>
    <td class="paramlist_value">
      <textarea id="banned_words" name="banned_words" rows="20" cols="40"><?php foreach ($this->feedbackSettings->banned_words as $word): ?><?php echo base64_decode($word) . "\n"; ?><?php endforeach; ?></textarea>
    </td>
  </tr>
</table>
