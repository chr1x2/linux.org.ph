<?php
/*------------------------------------------------------------------------
mod_feedback_statuses - Feedback Factory 2.0.0
------------------------------------------------------------------------
author TheFactory
copyright Copyright (C) 2013 SKEPSIS Consult SRL. All Rights Reserved.
@license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
Websites: http://www.thefactory.ro
Technical Support: Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');

class JElementItemid extends JElement
{
  function fetchElement($name, $value, &$node, $control_name)
  {
    $db = JFactory::getDbo();

    $query = ' SELECT m.id AS value, m.name AS text'
           . ' FROM #__menu m'
           . ' WHERE m.published = 1'
           . ' ORDER BY m.name ASC';
    $db->setQuery($query);
    $options = $db->loadObjectList();

    $output = JHTML::_(
      'select.genericlist',
      $options,
      ''.$control_name.'['.$name.'][]',
      'class="inputbox" size="8"',
      'value',
      'text',
      $value,
      $control_name.$name);

    return $output;
  }
}
