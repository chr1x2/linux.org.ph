<?php
/*------------------------------------------------------------------------
com_feedbackfactory - Feedback Factory 1.3.0
------------------------------------------------------------------------
author TheFactory
copyright Copyright (C) 2012 SKEPSIS Consult SRL. All Rights Reserved.
@license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
Websites: http://www.thefactory.ro
Technical Support: Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access'); ?>

<h1><?php echo JText::_('COM_WALLFACTORY_YOU_ALREADY_HAVE_A_WALL'); ?></h1>

<p>
  <a href="<?php echo JRoute::_('index.php?option=com_wallfactory&view=wall&Itemid=' . $this->Itemid); ?>">
    <?php echo JText::_('COM_WALLFACTORY_CLICK_HERE_TO_VIEW_YOUR_WALL'); ?>
  </a>
</p>
