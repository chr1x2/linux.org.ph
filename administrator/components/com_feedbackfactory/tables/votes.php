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

class TableVotes extends JTable
{
  var $id         	= null;
  var $user_id    	= null;
  var $feedback_id  = null;
  var $voted_at		= null;
  var $date_end		= null;

  function TableVotes(&$db)
  {
    parent::__construct('#__feedback_votes', 'id', $db);
  }
  
  // CRUD
  function delete($oid = null)
  {
    if ($oid)
    {
      $this->id = $oid;
    }

    return parent::delete($oid);
  }
}
