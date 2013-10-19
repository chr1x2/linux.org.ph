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

<h1><?php echo JText::_('ERROR_TITLE'); ?></h1>
<?php echo JText::_('COM_FEEDBACKFACTORY_NO_FEEDBACKS'); ?>

  <p><?php echo JText::_('FEEDBACK_NOT_FOUND'); ?>
  	<a href="<?php echo Juri::root().'index.php?option=com_feedbackfactory&task=addfeedback';?>"><?php echo JText::_('FEEDBACK_HERE'); ?></a> 
 	<?php echo JText::_('FEEDBACK_NOT_FOUND_SEARCH'); ?>
  	<a href="<?php echo Juri::root().'index.php?option=com_feedbackfactory&task=feedbacks';?>"><?php echo JText::_('FEEDBACK_HERE_SEARCH');?></a>
  </p>
  <br />
  <p><?php echo JText::_('FEEDBACK_RETURN'); ?> <a href="javascript: history.back();"><?php echo JText::_('FEEDBACK_PREVIOUS_PAGE'); ?></a></p>

