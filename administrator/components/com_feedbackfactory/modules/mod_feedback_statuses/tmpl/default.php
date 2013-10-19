<?php
/*------------------------------------------------------------------------
mod_feedback_statuses - Feedback Factory 2.0.0
------------------------------------------------------------------------
author TheFactory
copyright Copyright (C) 2013 SKEPSIS Consult SRL. All Rights Reserved.
@license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
Websites: http://www.thefactory.ro
Technical Support: Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access'); ?>

<ul style="list-style-type: none; margin: 0px; padding: 0px; ">
<?php if (count($statuses) > 1): ?>
  <?php foreach($statuses as $k => $status): ?>
    <li><a href="<?php echo JURI::root().'index.php?option=com_feedbackfactory&task=statusfeedbacks&status_id=' . $status->id . 'Itemid=' . $Itemid; ?>"><?php echo $status->status; ?></a>&nbsp;</li>
  <?php endforeach; ?>
<?php else: ?>
  <li><?php echo JText::_('FEEDBACK_NO_STATUS'); ?></li>
<?php endif; ?>
</ul>
