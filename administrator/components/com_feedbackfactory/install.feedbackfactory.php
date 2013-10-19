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
defined('DS')?'':define('DS',DIRECTORY_SEPARATOR);

// Component installer
class com_feedbackfactoryInstallerScript
{
  	 var $installer = null;

	public function install($adapter)
	{
        
	}
	
	public function update($adapter)
	{
		$installer = $this->installer;

		$installer->AddMessage("<h1>Your upgrade from Feedback Factory v. " . $installer->versionprevious . " to v. " . $installer->version . " has finished</h1>");
	}

	function uninstall($adapter)
	{

	}
	
	public function preflight($route, $adapter)
	{
		//require_once($adapter->getParent()->getPath('source') . DS . 'administrator' . DS . 'components' . DS . 'com_feedbackfactory' . DS . 'thefactory' . DS . 'installer' . DS . 'installer.php');
	    require_once($adapter->getParent()->getPath('source') . DS . 'site' . DS . 'installer' . DS . 'installer.php');
		$this->installer = new TheFactoryFeedbackFactoryInstaller('com_feedbackfactory', $adapter);

		if (!$this->installer->versionprevious) { //new install
		
			$this->installer->AddMenuItem("Feedback Factory Menu", "All feedbacks", "feedbacks", "index.php?option=com_feedbackfactory&task=feedbacks", 1);
			$this->installer->AddMenuItem("Feedback Factory Menu", "Top feedbacks", "top-feedbacks", "index.php?option=com_feedbackfactory&task=top", 1);
			$this->installer->AddMenuItem("Feedback Factory Menu", "Most commented", "most-commented", "index.php?option=com_feedbackfactory&task=mostcommented", 1);
			$this->installer->AddMenuItem("Feedback Factory Menu", "Accepted feedbacks", "accepted-feedbacks", "index.php?option=com_feedbackfactory&task=accepted", 1);
			$this->installer->AddMenuItem("Feedback Factory Menu", "Completed feedbacks", "completed-feedbacks", "index.php?option=com_feedbackfactory&task=completed", 1);
			$this->installer->AddMenuItem("Feedback Factory Menu", "Add Feedback", "add-feedback", "index.php?option=com_feedbackfactory&task=addfeedback", 1);
			
			$this->installer->AddSQLFromFile('install.feedbackfactory.inserts.sql');
		}

		$this->installer->AddCBPlugin('Feedback Factory - My Feedbacks', 'My Feedbacks', 'feedback_factory', 'getmyfeedbacksTab');
		
		$this->installer->AddMessageFromFile('install.notes.txt');

		$this->installer->AddMessage("Thank you for purchasing <strong>Feedback Factory</strong>");
		$this->installer->AddMessage("Please set up your <strong>Feedback Factory</strong> in the <a href='" . JURI::root() . "/administrator/index.php?option=com_feedbackfactory&task=settings'>admin panel</a></p>");
		$this->installer->AddMessage("Visit us at <a target='_blank' href='http://www.thefactory.ro'>thefactory.ro</a> to learn  about new versions and/or to give us feedback<br>");
		$this->installer->AddMessage("(c) 2006 - " . date('Y') . " thefactory.ro");


	}

	public function postflight($route, $adapter)
	{
		if ($this->installer->versionprevious) {
			//$this->installer->upgrade();
		} else {
			$this->installer->install();
		}
		
		// Extract Tiny MCE
		jimport('joomla.filesystem.archive');
		jimport('joomla.filesystem.file');

		/*$source      = JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'tinymce'.DS.'tinymce_3_3_9_3.zip';
		$destination = JPATH_COMPONENT_SITE.DS.'assets'.DS.'js';
		JArchive::extract($source, $destination);*/

		$message = is_array($this->installer->extension_message) ? implode("\r\n", $this->installer->extension_message) : $this->installer->extension_message;
		$error = is_array($this->installer->errors) ? implode("<br/>", $this->installer->errors) : $this->installer->errors;
		$warning = is_array($this->installer->warnings) ? implode("<br/>", $this->installer->warnings) : $this->installer->warnings;

		if ($error) JError::raiseWarning(100, $error);
		if ($warning) JError::raiseNotice(1, $warning);
		$adapter->getParent()->set('extension_message', $message);

		$session = JFactory::getSession();
		$session->set('com_feedbackfactory_install_msg', $message);

	}
  	        
}

