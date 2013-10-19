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

<fieldset>
  <legend><?php echo JText::_('FEEDBACK_STATISTICS'); ?></legend>

  <table class="adminlist table-condensed">
	  <tbody>
      <tr>
        <td><?php echo JText::_('FEEDBACK_NEW_WEEK_SUGGESTIONS'); ?> / <b><?php echo JText::_('FEEDBACK_TOTAL_SUGGESTIONS'); ?></b></td>
        <td style="text-align: center; "><?php echo $this->new_suggestions; ?> / <b><?php echo $this->total_suggestions; ?></b></td>
      </tr>
	  <tr>
        <td><?php echo JText::_('FEEDBACK_NEW_COMMENTS_THIS_WEEK'); ?> / <b><?php echo JText::_('FEEDBACK_TOTAL_COMMENTS'); ?></b></td>
        <td style="text-align: center; "><?php echo $this->new_comments; ?> / <b><?php echo $this->total_comments; ?></b></td>
      </tr>
    </tbody>
  </table>
</fieldset>
