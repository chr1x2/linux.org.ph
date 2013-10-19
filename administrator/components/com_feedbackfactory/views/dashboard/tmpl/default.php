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

defined('_JEXEC') or die('Restricted access'); ?>

<table class="adminlist table-striped" width="98%">
    <tr valign="top">
        <td width="48%">
		  <?php require_once('_latest_suggestions.php'); ?>
		</td>

        <td width="48%">
		  <?php require_once('_most_voted_suggestions.php'); ?>
		</td>
	</tr>
	<tr valign="top">
		<td width="50%">
		  <?php require_once('_statistics.php'); ?>
		</td>
        <td width="48%">
		  <?php require_once('_latest_comments.php'); ?>
		</td>
	</tr>
</table>
