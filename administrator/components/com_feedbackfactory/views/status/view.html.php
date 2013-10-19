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

class BackendViewStatus extends JViewLegacy
{
  function display($tpl = null)
  {
    $status  =& $this->get('Data');
    $isNew     = ($status->id < 1);

    $text = $isNew ? JText::_('New') : '"' . $status->status . '"';
    JToolBarHelper::title(JText::_('Status').': <small><small>[ ' . $text.' ]</small></small>');

    JToolBarHelper::save();
    ($isNew) ? JToolBarHelper::cancel() : JToolBarHelper::cancel('cancel', 'Close');

    $this->assignRef('status', $status);

    parent::display($tpl);
  }
}
