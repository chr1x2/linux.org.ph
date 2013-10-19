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

class BackendModelSettings extends JModelLegacy
{
  function __construct()
  {
	parent::__construct();

	$this->settings = array(
	  	'enable_guest_view'       	=> 'integer',
	  	'allow_guest_write'			=> 'integer',
	  	'guest_captcha_write'		=> 'integer',
	  	'allow_multiple_votes'		=> 'integer',
      	'min_top_votes'				=> 'integer',
	  	'allow_guest_comments'    	=> 'integer',
	  	'comments_per_page'			=> 'integer',
		'feedbacks_per_page'    	=> 'integer',
		'min_most_commented'		=> 'integer',
		'feedbacks_per_page'    	=> 'integer',
      	'captcha_comment'			=> 'integer',
      	'guest_captcha_comment'		=> 'integer',
		'use_cb_avatars'            => 'integer',
        'avatar_max_width'          => 'integer',
        'avatar_max_height'         => 'integer',
       	'banned_words'            => 'banned_words',
		'recaptcha_public_key'    => 'string',
      	'recaptcha_private_key'   => 'string'

	 );
	
	 $this->feedbackSettings = new feedbackSettings();
  }
  
  function store()
  {
  	$this->updateSettings();

    return $this->writeSettings();

  }

  function updateSettings()
  {
      $app = JFactory::getApplication();

    foreach ($this->settings as $setting => $type)
    {
      switch ($type)
      {
        case 'string':
          $this->feedbackSettings->$setting = $app->input->getString($setting, $this->feedbackSettings->$setting);
          $this->feedbackSettings->$setting = base64_encode($this->feedbackSettings->$setting);
        break;

        case 'array':
          $this->feedbackSettings->$setting = $app->input->get($setting, array(), 'array');
        break;

        case 'integer':
          $this->feedbackSettings->$setting = $app->input->getInt($setting, $this->feedbackSettings->$setting);
        break;

        case 'banned_words':
          $words = $app->input->getString($setting, '');
          $words = explode("\n", $words);

          $this->feedbackSettings->$setting = array();

          $array = array();
          foreach ($words as $word)
          {
            if ('' != $word)
            {
              $array[] = base64_encode(trim($word));
            }
          }
          $this->feedbackSettings->$setting = $array;
        break;
      }
    }

  }
  
  function writeSettings()
  {
	// Check if file writable
    if (!is_writable(JPATH_COMPONENT_ADMINISTRATOR.DS.'feedbackSettings.class.php'))
    {
      $this->setError(JText::_('Settings file is not writable!'));
      return false;
	 }

    $handle = fopen(JPATH_COMPONENT_ADMINISTRATOR.DS.'feedbackSettings.class.php', 'w');
    
    fwrite($handle, $this->templateSettings());
    fclose($handle);

    return true;

  }
 
  function templateSettings()
  {
    $max_length = 0;
    foreach ($this->settings as $setting => $type)
    {
      $max_length = (strlen($setting) > $max_length) ? strlen($setting) : $max_length;
    }
      $template = "<?php

defined('_JEXEC') or die('Restricted access');

class feedbackSettings
{";

    foreach ($this->settings as $setting => $type)
    {
      $template .= "\n";
      $template .=
'  var $' . $setting . str_repeat(' ', $max_length - strlen($setting)) . ' = ';

     switch ($type)
      {
        case 'array':
        case 'banned_words':
          $template .= 'array(';
          if (count($this->feedbackSettings->$setting))
          {
            $template .= '\'' . implode('\', \'', $this->feedbackSettings->$setting) . '\'';
          }
          $template .= ')';
        break;

        case 'integer':
          $template .= $this->feedbackSettings->$setting;
        break;

        case 'string':
          $template .= '\'' . $this->feedbackSettings->$setting . '\'';
        break;
      }
    
      $template .= ';';
    }

    $template .= "\n";
    $template .=
'}';

    return $template;
  }
  
    function getAdmins()
  {
    jimport('joomla.database.tablenested');

    $usergroup = new JTableNested('#__usergroups', 'id', JFactory::getDbo());
    $groups    = JAccess::getAssetRules(1)->getData();
    $groups    = $groups['core.admin']->getData();
    $array     = array();

    $usergroup->load(1);
    $tree = $usergroup->getTree();

    foreach ($tree as $leaf)
    {
      $array[$leaf->id] = $leaf;
    }

    $tree  = $array;
    $array = array();

    foreach ($groups as $id => $access)
    {
      $current = $tree[$id];

      foreach ($tree as $leaf)
      {
        if ($leaf->lft >= $current->lft &&
        $leaf->rgt <= $current->rgt)
        {
          if (!$access && isset($array[$leaf->id]))
          {
            unset($array[$leaf->id]);
          }

          if ($access && !isset($array[$leaf->id]))
          {
            $array[$leaf->id] = $access;
          }
        }
      }
    }

    $db =& JFactory::getDbo();
    $query = $db
    ->getQuery(true)
    ->select('u.id, u.username')
    ->from('#__users AS u')
    ->leftJoin('#__user_usergroup_map m ON m.user_id = u.id')
    ->where('m.group_id IN (' . implode(',', array_keys($array)) . ')')
    ->order('u.username ASC');

    $db->setQuery($query);

    return $db->loadObjectList();
  }
  
  function getGroups()
  {
    $db = JFactory::getDbo();
    $db->setQuery(
			'SELECT a.*, COUNT(DISTINCT b.id) AS level' .
			' FROM #__usergroups AS a' .
			' LEFT JOIN `#__usergroups` AS b ON a.lft > b.lft AND a.rgt < b.rgt' .
			' GROUP BY a.id' .
			' ORDER BY a.lft ASC'
		);

		return $db->loadObjectList();
  }

  
}
