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

class TableStatus extends JTable
{
  var $id        		= null;
  var $status    		= null;
  var $default_status   = null;
  var $published 		= null;

  function TableStatus(&$db)
  {
    parent::__construct('#__feedback_statuses', 'id', $db);
  }
}
