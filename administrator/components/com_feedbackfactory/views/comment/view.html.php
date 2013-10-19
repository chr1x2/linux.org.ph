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

class BackendViewComment extends JViewLegacy
{
  function display($tpl = null)
  {
    $comment =& $this->get('Data');

    if (!$comment)
    {
      $this->_layout = 'not_found';
    }
    else
    {
      JToolBarHelper::title(JText::_('Comment'));
      JToolBarHelper::save();
      JToolBarHelper::cancel('cancel', 'Close');

      $this->assignRef('comment', $comment);
    }

    parent::display($tpl);
  }
}
