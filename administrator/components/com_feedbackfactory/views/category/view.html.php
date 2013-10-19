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

class BackendViewCategory extends JViewLegacy
{
  function display($tpl = null)
  {
    $category  =& $this->get('Data');
    $isNew     = ($category->id < 1);

    $text = $isNew ? JText::_('FEEDBACK_NEW') : '"' . $category->title . '"';
    JToolBarHelper::title(JText::_('Category').': <small><small>[ ' . $text.' ]</small></small>');

    JToolBarHelper::save();
    ($isNew) ? JToolBarHelper::cancel() : JToolBarHelper::cancel('cancel', 'Close');

    $this->assignRef('category', $category);

    parent::display($tpl);
  }
}
