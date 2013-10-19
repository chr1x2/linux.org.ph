<?php 
/*------------------------------------------------------------------------
com_wallfactory - Wall Factory 3.0.0
------------------------------------------------------------------------
author    TheFactory
copyright Copyright (C) 2013 SKEPSIS Consult SRL. All Rights Reserved.
@license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
Websites: http://www.thefactory.ro
Technical Support:  Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access'); ?>

<table>
  <tr>
    <td><?php echo JText::_('Your version'); ?>:</td>
    <td><?php echo $this->current_version; ?></td>
  </tr>
  <tr>
    <td><?php echo JText::_('Latest version'); ?>:</td>
    <td><?php echo $text; ?></td>
  </tr>
  <tr>
    <td colspan="2" style="color: #<?php echo (!$this->new_version ? '000000' : 'ff0000'); ?>; font-weight: bold; padding-top: 10px;">
      <?php echo JText::_(!$this->new_version ? 'You have the latest version!' : 'A new version is available!'); ?>
    </td>
  </tr>
</table>