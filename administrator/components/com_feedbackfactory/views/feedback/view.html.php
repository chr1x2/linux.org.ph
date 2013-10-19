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

class BackendViewFeedback extends JViewLegacy
{
  function display($tpl = null)
  {
  
    $feedback   =& $this->get('Data');
    $statuses   =& $this->get('Statuses');
    $categories =&  $this->get('Categories');
    $isNew      =  ($feedback->id < 1);

    $feedbackSettings = new feedbackSettings();
    $isCBIntegration = FeedbackHelper::getCBIntegration();

    $text = $isNew ? JText::_('New') : '"' . $feedback->title . '"';
    JToolBarHelper::title(JText::_('Feedback').': <small><small>[ ' . $text.' ]</small></small>');

    JToolBarHelper::save();
    ($isNew) ? JToolBarHelper::cancel() : JToolBarHelper::cancel('cancel', 'Close');

    $this->assignRef('feedback',   		 $feedback);
    $this->assignRef('statuses',      	 $statuses);
    $this->assignRef('categories', 		 $categories);
    $this->assignRef('feedbackSettings', $feedbackSettings);
    $this->assignRef('isCBIntegration',  $isCBIntegration);

    $document = JFactory::getDocument();
    $document->addScript(JUri::root().'components/com_feedbackfactory/assets/js/tiny_mce/tiny_mce.js');

    //JHTML::script('components/com_feedbackfactory/assets/js/tiny_mce/tiny_mce.js');

    parent::display($tpl);
  }
}
