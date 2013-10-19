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

class BackendViewDashboard extends JViewLegacy
{
  function display($tpl = null)
  {
    JToolBarHelper::title(JText::_('Dashboard'), 'impressions.png');

    $latest_suggestions   =& $this->get('LatestFeedbacks');
    $total_suggestions    =& $this->get('TotalFeedbacks');
    $new_suggestions      =& $this->get('NewFeedbacks');
    
    $latest_comments      =& $this->get('LatestComments');
    $total_comments       =& $this->get('TotalComments');
    $new_comments         =& $this->get('NewComments');
    
    $most_voted_suggestions    =& $this->get('MostVotedFeedbacks');

    $this->assignRef('latest_suggestions',         $latest_suggestions);
    $this->assignRef('total_suggestions',          $total_suggestions);
    $this->assignRef('new_suggestions',            $new_suggestions);
    
    $this->assignRef('latest_comments',      $latest_comments);
    $this->assignRef('total_comments',       $total_comments);
    $this->assignRef('new_comments',         $new_comments);
      
    $this->assignRef('most_voted_suggestions',    $most_voted_suggestions);
    

    parent::display($tpl);
  }
}
