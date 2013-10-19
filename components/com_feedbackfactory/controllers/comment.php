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

class FrontendControllerComment extends FrontendController
{
	function __construct()
	{
		parent::__construct();
	}

	
	function addComment()
	{
	  $model =& $this->getModel('comment');
	  $model->store();
	}
	
	function delete() {
		//admin only
	  $id       = JFactory::getApplication()->input->getInt('id', 0);
	  $database = JFactory::getDbo();
	  
	  // Find the comment
	  $query = ' SELECT c.id'
	         . ' FROM #__feedback_comments c'
	         . ' WHERE c.id = ' . $id;
	  $database->setQuery($query);
	  $comment = $database->loadObject();

	  if ($comment != null) {
		//delete comment
		$query = ' DELETE'
	         . ' FROM #__feedback_comments'
	         . ' WHERE id = ' . $id;
	  	$database->setQuery($query);
	  	$database->query();
	  	die('{"status": 2, "message": "' . JText::_('(comment has been deleted)') . '"}');
        //  die('{"status": 2, "message": "' . JText::_('(FEEDBACK_COMMENT_HAS_BEEN_DELETED)') . '"}');
	  }
	  
	  // Comment not found
	  if (!$comment)
	  {
	    die('{"status": 1, "message": "' . JText::_('Comment not found or already deleted!') . '"}');
        //  die('{"status": 1, "message": "' . JText::_('FEEDBACK_COMMENT_NOT_FOUND') . '"}');
	  }

	}

}
