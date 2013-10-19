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

jimport('joomla.application.component.controller');

class FrontendController extends JControllerLegacy
{
  function __construct()
  {
    require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'feedbackSettings.class.php');
    require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'helpers'.DS.'feedbackHelper.class.php');

    parent::__construct();
    
    $this->feedbackSettings = new feedbackSettings();
  }
  
  
  function display()
  {
    //$views = array( 'addfeedback');
      $views = array( 'comments', 'addfeedback');
      $tpl = $this->input->getWord('layout','default');

    if (in_array($this->input->getString('view', ''), $views))
    {
		parent::display($tpl);
        return true;
    }
   	
      $format = $this->input->getWord('format','html');
      $view  =& $this->getView('feedbacks', $format);

  	  $model =& $this->getModel('browse');
      $view->setModel($model, true);

      JHtml::_('jquery.framework');
	  $view->display();
  }

  function top()
  {
    $format = $this->input->getWord('format','html');
  	$view  =& $this->getView('browse', $format);
  	  
    $model =& $this->getModel('browse');
    $model->setParameters(array(
      'type' => 'top'
    ));

    JHtml::_('jquery.framework');
    $view->setModel($model, true);
    $view->display('top');
  }
  
  function mostcommented()
  {
    //$view  =& $this->getView('browse', 'html');
    $format = $this->input->getWord('format','html');
  	$view  =& $this->getView('browse', $format);
  	
    $model =& $this->getModel('browse');
    $model->setParameters(array(
      'type' => 'mostcommented'
    ));

    JHtml::_('jquery.framework');
    $view->setModel($model, true);
    $view->display('mostcommented');
  }
  
  function completed()
  {
    $format = $this->input->getWord('format','html');
  	$view  =& $this->getView('browse', $format);
  	
    $model =& $this->getModel('browse');
    $model->setParameters(array(
      'type' => 'completed'
    ));

    JHtml::_('jquery.framework');
    $view->setModel($model, true);
    $view->display('completed');
  }
  
  function search()
  {
  	$page = $this->input->getInt('search_type', 0);
    $format = $this->input->getWord('format','html');
  	
  	switch ($page) {
  		case 0: 
  		  $view  =& $this->getView('feedbacks', 'html');
  		  break;
  		case 1:
  		case 2:
  		case 3:		
  		  $view  =& $this->getView('browse', 'html');
  		  break;
  	}
  	
    $model =& $this->getModel('browse');
    
    $model->setParameters(array(
      'type'         => 'search',
      'search_query' => $this->input->getString('dataq', ''),
      'search_type'  => $this->input->getInt('search_type', 0)
    ));

    $view->setModel($model, true);
    $view->display('search');
  }
  
  function search_accepted()
  {
  	$view  =& $this->getView('accepted', 'html');
 	
  	$model =& $this->getModel('accepted');
    $search_type = $this->input->getInt('search_type', 0);
     
    $model->setParameters(array(
      'search_query' => $this->input->getString('dataq', ''),
      'search_type'  => $search_type
    ));

    $view->setModel($model, true);

    switch ($search_type) {
    	case 4:
    		$tpl = 'search_pending';
    		break;
    	case 5: 
    		$tpl = 'search_started';
    		break;
    	case 6:
    		$tpl = 'search_planned';
    		break;
    	default:
    		$tpl = 'search_pending';
    		break;				
    }
   
    $view->display($tpl);
  }

  function categoryfeedbacks()
  {
    $view  =& $this->getView('browse', 'html');
    $model =& $this->getModel('browse');

    $model->setParameters(array(
      'type' => 'categoryfeedbacks'
    ));

    JHtml::_('jquery.framework');
    $view->setModel($model, true);
    $view->display('categoryfeedbacks');
  }

  function statusfeedbacks()
  {
    $view  =& $this->getView('browse', 'html');
    $model =& $this->getModel('browse');

    $model->setParameters(array(
      'type' => 'statusfeedbacks'
    ));

    JHtml::_('jquery.framework');
    $view->setModel($model, true);
    $view->display('statusfeedbacks');
  }
  
  function accepted()
  {
    $format = $this->input->getWord('format','html');
  	
  	$view  =& $this->getView('accepted', $format);
    $model =& $this->getModel('accepted');

    JHtml::_('jquery.framework');
    $view->setModel($model, true);
    $view->display();
  }
  
  function vote()
  {
    if (JInput::getMethod() != 'POST')
    {
      $this->display();
      return false;
    }

    // Get the model
    $model =& $this->getModel('vote');
    $msg   =  JText::_('COM_FEEDBACKFACTORY_REGISTERED!');

    // Register voter
    if ($model->registerVoter())
    {
      // Register vote
      if (!$model->registerVote())
      {
        JError::raiseWarning('ERROR', JText::_('COM_FEEDBACKFACTORY_ERROR_VOTE'));
        $msg = JText::_('COM_FEEDBACKFACTORY_VOTE_NOT_REGISTERED');
      }
    }
    else
    {
      JError::raiseWarning('ERROR', JText::_('COM_FEEDBACKFACTORY_ERROR_VOTER'));
      $msg = JText::_('COM_FEEDBACKFACTORY_VOTE_NOT_REGISTERED');
    }

    $Itemid = $this->input->getInt('Itemid', 0);
    $app = JFactory::getApplication();

   	$app->redirect('index.php?option=com_feedbackfactory&Itemid=' . $Itemid, $msg);

  }

  function addfeedback()
  {
  	$view  =& $this->getView('addfeedback', 'html');
    $model =& $this->getModel('addfeedback');

    $view->setModel($model, true);
    $view->display();
  }
  
  function feedback()
  {
    $view  =& $this->getView('feedback', 'html');
    $model =& $this->getModel('feedback');

    JHtml::_('jquery.framework');
    $view->setModel($model, true);
    $view->display();
  }
  
}
