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

class BackendViewChangestatus extends JViewLegacy
{
  function display($tpl = null)
  {

    JToolBarHelper::title(JText::_('Change status'), 'redirect.png');
    JToolBarHelper::save('changeStatuses');
    JToolBarHelper::cancel();
    
    $statuses 	  =& $this->get('Statuses');
    $feedbacks    =& $this->get('Feedbacks');
    
    $this->assignRef('statuses', $statuses);
    $this->assignRef('feedbacks',     $feedbacks);
    
    parent::display($tpl);
  }
}
