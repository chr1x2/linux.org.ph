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

<form action="index.php" method="POST" name="adminForm" id="adminForm">

  <?php echo JText::_('FEEDBACK_MOVE_SELECTED_TO'); ?>: <?php echo $this->statuses; ?>

  <?php foreach ($this->feedbacks as $feedback): ?>
    <input type="hidden" name="cid[]" value="<?php echo $feedback; ?>" />
  <?php endforeach; ?>

  <input type="hidden" name="controller" value="feedback" />
  <input type="hidden" name="option" value="com_feedbackfactory" />
  <input type="hidden" name="task" value="" />
</form>
