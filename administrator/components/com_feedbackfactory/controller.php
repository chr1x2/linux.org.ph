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

class BackendController extends JControllerLegacy
{
  function __construct()
  {
    parent::__construct();
    
    require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'feedbackSettings.class.php');
	require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'helpers'.DS.'feedbackHelper.class.php');

  }
  
  function display() 
  {
  	parent::display();
  }
	
  function feedbacks()
  {
  	$view  =& $this->getView('feedbacks', 'html');
    $model =& $this->getModel('feedbacks');
   
    $view->setModel($model, true);
    $view->display();
  }
  
  function settings()
  {
  	$view  =& $this->getView('settings', 'html');
    $model =& $this->getModel('settings');

    $view->setModel($model, true);
    $view->display();
  }
  
  function dashboard()
  {
  	$view  =& $this->getView('dashboard', 'html');
    $model =& $this->getModel('dashboard');

    $view->setModel($model, true);
    $view->display();
  }
  
  function comments()
  {
  	$view  =& $this->getView('comments', 'html');
    $model =& $this->getModel('comments');

    $view->setModel($model, true);
    $view->display();
  }
  
  function categories()
  {
  	$view  =& $this->getView('categories', 'html');
    $model =& $this->getModel('categories');

    $view->setModel($model, true);
    $view->display();
  }
  
  function changex()
  {
    $view  =& $this->getView('changex', 'html');
    $model =& $this->getModel('changex');

    $view->setModel($model, true);
    $view->display();
  }
  
  function changeStatus()
  {
    $view  =& $this->getView('changestatus', 'html');
    $model =& $this->getModel('changex');

    $view->setModel($model, true);
    $view->display();
  }
  
  function statuses()
  {
  	$view  =& $this->getView('statuses', 'html');
    $model =& $this->getModel('statuses');

    $view->setModel($model, true);
    $view->display();
  }
  
    function about(){
      $view=$this->getView('about', 'html');
      $view->display();
    }

  function installCBPlugin()
  {
      $app = JFactory::getApplication();
      $option = $app->input->getWord('option', 'com_feedbackfactory');

    $feedbackHelperClass = new feedbackHelper();

    $isCBIntegration = $feedbackHelperClass->getCBIntegration();

    if(!$isCBIntegration) {
        $app->redirect('index.php?option='.$option.'&task=settings','CB not installed!','error');
    }

    $feedbackHelperClass->adminCBInstall();
      
      $app->redirect('index.php?option='.$option.'&task=settings',JText::_("Plugin Installed!"));
    return true;

  }
  
}
