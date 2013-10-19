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

jimport('joomla.application.component.model');

class FrontendModelAddfeedback extends JModelLegacy
{
	function __construct()
  {
    parent::__construct();
	
    $this->feedbackSettings = new feedbackSettings();
  }

  // Getters
  function &getData()
  {
    if (empty($this->_data))
    {
      $user = JFactory::getUser();

      $query = ' SELECT f.*'
             . ' FROM #__feedback_feedbacks f'
             . ' WHERE f.user_id = ' . $user->id;
      $this->_db->setQuery($query);

      $this->_data = $this->_db->loadObject();
    }

    if (!$this->_data)
    {
      $this->_data = $this->getTable('feedback');
      //$this->_data->published = 1;
    }

    return $this->_data;
  }
  
  function getCategories()
  {
 /*   switch ($this->feedbackSettings->categories_type)
    {
      case 0:
        return null;
      break;

      // Joomla categories
      case 1:
        return JHtml::_('category.options', 'com_content');
      break;

      // Custom categories
      case 2:*/
        $query = ' SELECT *'
               . ' FROM #__feedback_categories'
               . ' WHERE published = 1'
               . ' ORDER BY title ASC';
         $this->_db->setQuery($query);
         $categories1 = $this->_db->loadObjectList();

         $categories = array();
         foreach ($categories1 as $category)
         {
           if (!isset($categories[$category->id]))
           {
             $categories[$category->id] = array('title' => $category->title);
           }
         }

         return $categories;
     /* break;
    }*/
  }
 

  // Tasks
  function store()
  {
    $user = JFactory::getUser();
    $this->feedbackHelper   = feedbackHelper::getInstance();
    
    if ($user->guest && !$this->feedbackSettings->guest_captcha_write && !$this->feedbackSettings->allow_guest_write)
    {
      die('{ "errors": 2, "message": "' . JText::_('You must login to be able to write a feedback') . '"}');
    }

    if ($user->guest && $this->feedbackSettings->guest_captcha_write)
    {
      require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'recaptcha'.DS.'recaptchalib.php');

      $resp = recaptcha_check_answer(base64_decode($this->feedbackSettings->recaptcha_private_key), $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
      
      if (!$resp->is_valid)
      {
        return 3;
      }
    }
    
    
    //JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_feedbackfactory'.DS.'tables');
    //$feedback =& JTable::getInstance('feedback', 'Table');
    $app = JFactory::getApplication();
    $feedback =& $this->getTable('feedback');
    $data =  $app->input->getArray($_POST);

  //  $data['feedback_content'] = $app->input->getString('feedback_content', '');
      $f=new JFilterInput(array(),array(),1,1);
      $data['feedback_content'] = $f->clean($_REQUEST['feedback_content'],'html');

    $data['status_id'] = feedbackHelper::getStatusId('none');
   	    
    $is_title_unique = feedbackHelper::checkUniqueName($data['title']);

   	if (!$is_title_unique)
   	{
   		return 2;
   	}
   	else {
   	
   	if (!$feedback->bind($data))
    {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    if (!$feedback->check())
    {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    if (empty($feedback->id))
    {
      $isNew = true;
      $feedback->user_id = $user->id;
      $feedback->date_created = date('Y-m-d H:i:s');
    }
  
    $feedback->date_updated = date('Y-m-d H:i:s');

    if (!$feedback->store())
    {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    $feedback->load($feedback->id);

    return $feedback;
   	}
  }
  

}
