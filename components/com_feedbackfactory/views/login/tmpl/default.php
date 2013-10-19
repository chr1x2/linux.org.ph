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

<p><?php echo JText::_('LOGIN_NEED_TO_LOGIN'); ?></p>

<p>
  <a class="feedbackfactory-icon feedbackfactory-lock" href="<?php echo JRoute::_('index.php?option=com_users&view=login&Itemid=' . $this->Itemid . '&return=' . $this->referer); ?>">
    <?php echo JText::_('LOGIN_CLICK_HERE'); ?>
  </a>
</p>
