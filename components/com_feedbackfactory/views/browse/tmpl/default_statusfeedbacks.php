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

<div id="feedback-wrapper">
  <h1><?php echo JText::_('COM_FEEDBACKFACTORY_STATUS_FEEDBACKS'); ?><?php echo $this->feedbacks[0]->status; ?></h1>
  <?php echo $this->loadTemplate('list');  ?>
</div>
