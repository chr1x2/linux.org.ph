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

class TableComment extends JTable
{
  var $id          		= null;
  var $feedback_id    	= null;
  var $user_id     		= null;
  var $author_email		= null;
  var $author_name		= null;
  var $comment     		= null;
  var $date_added  		= null;

  function TableComment(&$db)
  {
    parent::__construct('#__feedback_comments', 'id', $db);
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
