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

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class BackendViewBackend extends JViewLegacy
{
  function display($tpl = null)
  {
    $mainframe = JFactory::getApplication();
    $mainframe->redirect('index.php?option=com_feedbackfactory&task=feedbacks');
  }
}
